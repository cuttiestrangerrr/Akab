<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display user profile dashboard with all info
     */
    public function show()
    {
        $user = Auth::user();
        
        return view('profile.dashboard', compact('user'));
    }

    /**
     * Show edit profile form
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Base validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image|max:2048',
        ];

        // Add developer-specific validation rules
        if ($user->isDeveloper() || $user->isCommunityDeveloper()) {
            $rules['specialization'] = 'required|string|max:255';
            $rules['description'] = 'required|string|max:1000';
        }

        // Add community developer-specific validation rules
        if ($user->isCommunityDeveloper()) {
            $rules['instagram_link'] = 'nullable|url';
            $rules['github_link'] = 'nullable|url';
            $rules['website_link'] = 'nullable|url';
        }

        $validated = $request->validate($rules);

        // Update basic information
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Update profile photo
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        // Update developer-specific fields
        if ($user->isDeveloper() || $user->isCommunityDeveloper()) {
            $user->specialization = $validated['specialization'];
            $user->description = $validated['description'];
        }

        // Update community developer-specific fields
        if ($user->isCommunityDeveloper()) {
            $user->instagram_link = $validated['instagram_link'] ?? null;
            $user->github_link = $validated['github_link'] ?? null;
            $user->website_link = $validated['website_link'] ?? null;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}

