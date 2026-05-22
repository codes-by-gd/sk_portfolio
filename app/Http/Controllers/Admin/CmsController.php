<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function index()
    {
        $pages = CmsPage::orderBy('key')->get();
        return view('admin.cms.index', compact('pages'));
    }

    public function update(Request $request, CmsPage $cms)
    {
        $validated = $request->validate([
            'content_en' => 'required|string',
            'content_gu' => 'nullable|string',
            'content_hi' => 'nullable|string',
        ]);

        $cms->update([
            'content_en' => $validated['content_en'],
            'content_gu' => $validated['content_gu'] ?? $validated['content_en'],
            'content_hi' => $validated['content_hi'] ?? $validated['content_en'],
        ]);

        return back()->with('success', "CMS key '{$cms->key}' updated successfully.");
    }
}
