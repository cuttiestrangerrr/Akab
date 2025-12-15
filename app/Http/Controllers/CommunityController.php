<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function index()
    {
        // Check if user can access community
        if (!Auth::user()->canAccessCommunity()) {
            return redirect()->route('developer.become.community')
                ->with('info', 'Silakan bergabung sebagai Community Developer untuk mengakses fitur komunitas.');
        }

        $posts = \App\Models\CommunityPost::with('developer')->latest()->get();
        return view('developer.community', compact('posts'));
    }

    public function store(Request $request)
    {
        // Check if user can access community
        if (!Auth::user()->canAccessCommunity()) {
            abort(403, 'Anda harus menjadi Community Developer untuk membuat postingan.');
        }

        $validated = $request->validate([
            'content' => 'required|string',
            'code' => 'nullable|string',
            'language' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('community_images', 'public');
        }

        \App\Models\CommunityPost::create([
            'id_developer' => Auth::id(),
            'konten' => $validated['content'],
            'code' => $validated['code'],
            'language' => $validated['language'],
            'lampiran_url' => $path,
            'judul' => '', // Default empty title
        ]);

        return redirect()->route('developer.community')->with('success', 'Postingan berhasil dibagikan!');
    }

    public function edit($id)
    {
        $post = \App\Models\CommunityPost::findOrFail($id);

        if ($post->id_developer !== Auth::id()) {
            abort(403);
        }

        return view('developer.community_edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = \App\Models\CommunityPost::findOrFail($id);

        if ($post->id_developer !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'content' => 'required|string',
            'code' => 'nullable|string',
            'language' => 'nullable|string',
        ]);

        $post->update([
            'konten' => $validated['content'],
            'code' => $validated['code'],
            'language' => $validated['language'],
        ]);

        return redirect()->route('developer.community')->with('success', 'Postingan diperbarui!');
    }

    public function destroy($id)
    {
        $post = \App\Models\CommunityPost::findOrFail($id);

        if ($post->id_developer !== Auth::id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('developer.community')->with('success', 'Postingan dihapus.');
    }

    public function like($id)
    {
        $post = \App\Models\CommunityPost::findOrFail($id);
        
        $existingLike = $post->likes()->where('user_id', Auth::id())->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            $post->likes()->create([
                'user_id' => Auth::id()
            ]);
        }

        return back();
    }

    public function comment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:community_comments,id'
        ]);

        $post = \App\Models\CommunityPost::findOrFail($id);
        
        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ]);

        return back()->with('success', 'Komentar ditambahkan!');
    }
    public function updateComment(Request $request, $id)
    {
        $comment = \App\Models\CommunityComment::findOrFail($id);

        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment->update([
            'content' => $request->content
        ]);

        return back()->with('success', 'Komentar diperbarui.');
    }

    public function destroyComment($id)
    {
        $comment = \App\Models\CommunityComment::findOrFail($id);

        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Komentar dihapus.');
    }

    public function profile()
    {
        $user = Auth::user();
        $posts = \App\Models\CommunityPost::where('id_developer', $user->id)
                    ->with('developer', 'comments', 'likes')
                    ->latest()
                    ->get();
                    
        return view('developer.community_profile', compact('user', 'posts'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'profile_photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string|max:1000',
            'instagram_link' => 'nullable|url',
            'github_link' => 'nullable|url',
            'website_link' => 'nullable|url',
        ]);

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        $user->description = $request->description;
        $user->instagram_link = $request->instagram_link;
        $user->github_link = $request->github_link;
        $user->website_link = $request->website_link;
        $user->save();

        return back()->with('success', 'Profil diperbarui!');
    }
}
