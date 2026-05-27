<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('mobile_number', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        $contacts = $query->latest()->paginate(10)->withQueryString();

        return view('admin.contact.index', compact('contacts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'designation' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Contact added successfully.');
    }

    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'designation' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $contact->update($validated);

        return back()->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        // Guard check inside controller to ensure only super-admin can delete
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $contact->delete();

        return back()->with('success', 'Contact deleted successfully.');
    }

    public function export(Request $request)
    {
        $query = Contact::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('mobile_number', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        $contacts = $query->latest()->get();

        $headers = [
            'ID', 'First Name', 'Last Name', 'Full Name', 'Mobile Number', 'Email', 'Designation', 'Address', 'Notes', 'Created At'
        ];

        $rows = [];
        foreach ($contacts as $contact) {
            $rows[] = [
                $contact->id,
                $contact->first_name,
                $contact->last_name,
                $contact->name,
                $contact->mobile_number,
                $contact->email ?? 'None',
                $contact->designation ?? 'None',
                $contact->address ?? 'None',
                $contact->notes ?? 'None',
                $contact->created_at->format('Y-m-d H:i:s'),
            ];
        }

        return \App\Helpers\ExcelExportHelper::exportToXlsx('contacts_export', $headers, $rows, 'Contacts');
    }
}
