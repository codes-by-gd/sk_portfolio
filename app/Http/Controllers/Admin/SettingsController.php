<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('key')->get()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'office_address'  => 'nullable|string|max:500',
            'office_phone'    => 'nullable|string|max:100',
            'office_email'    => 'nullable|email|max:255',
            'office_timings'  => 'nullable|string|max:255',
            'facebook_url'    => 'nullable|url|max:500',
            'twitter_url'     => 'nullable|url|max:500',
            'instagram_url'   => 'nullable|url|max:500',
            'youtube_url'     => 'nullable|url|max:500',
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
