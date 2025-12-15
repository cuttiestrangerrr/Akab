<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeveloperRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        if (Auth::user()->role === 'developer') {
            return redirect()->route('developer.dashboard');
        }

        return view('developer.register');
    }

    public function registerDeveloper(Request $request)
    {
        $validated = $request->validate([
            'specialization' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
        ]);

        $user = Auth::user();
        
        $user->update([
            'role' => 'developer',
            'specialization' => $validated['specialization'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('developer.dashboard')->with('success', 'Selamat! Anda sekarang adalah Developer.');
    }

    /**
     * Show community developer registration form
     */
    public function showCommunityRegistrationForm()
    {
        $user = Auth::user();

        // Only developers can become community developers
        if ($user->role !== 'developer') {
            return redirect()->route('developer.register')->with('error', 'Anda harus menjadi developer terlebih dahulu.');
        }

        // Already a community developer
        if ($user->isCommunityDeveloper()) {
            return redirect()->route('developer.community')->with('info', 'Anda sudah terdaftar sebagai Community Developer.');
        }

        return view('developer.become_community');
    }

    /**
     * Register user as community developer
     */
    public function registerCommunityDeveloper(Request $request)
    {
        $user = Auth::user();

        // Validation
        if ($user->role !== 'developer') {
            return back()->with('error', 'Anda harus menjadi developer terlebih dahulu.');
        }

        if ($user->isCommunityDeveloper()) {
            return back()->with('error', 'Anda sudah terdaftar sebagai Community Developer.');
        }

        $validated = $request->validate([
            'agree_guidelines' => 'required|accepted',
            'bio' => 'nullable|string|max:1000',
            'instagram_link' => 'nullable|url',
            'github_link' => 'nullable|url',
            'website_link' => 'nullable|url',
        ]);

        // Update user
        $user->update([
            'is_community_developer' => true,
            'description' => $validated['bio'] ?? $user->description,
            'instagram_link' => $validated['instagram_link'],
            'github_link' => $validated['github_link'],
            'website_link' => $validated['website_link'],
        ]);

        return redirect()->route('developer.community')->with('success', 'Selamat! Anda sekarang adalah Community Developer. Selamat datang di komunitas!');
    }
}
