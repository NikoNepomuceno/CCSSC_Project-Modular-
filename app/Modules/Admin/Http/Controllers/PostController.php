<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Models\OrganizationUser;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Post::class);

        $search = $request->string('search')->toString();
        $authorId = $request->integer('author_id') ?: null;

        $posts = Post::query()
            ->with('organizationUser')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->when($authorId, fn ($query) => $query->where('organization_user_id', $authorId))
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        $authors = OrganizationUser::orderBy('name')->get();

        return view('admin::posts.index', [
            'posts' => $posts,
            'authors' => $authors,
            'filters' => [
                'search' => $search,
                'author_id' => $authorId,
            ],
        ]);
    }

    /**
     * Show the form for creating a new post.
     */
    public function create(): View
    {
        Gate::authorize('create', Post::class);

        $authors = OrganizationUser::orderBy('name')->get();

        return view('admin::posts.create', [
            'post' => new Post(),
            'authors' => $authors,
        ]);
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Post::class);

        try {
            $validated = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'content' => ['required', 'string'],
                'organization_user_id' => ['required', 'exists:organization_users,id'],
            ]);

            Post::create($validated);

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Post created successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create post. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post): View
    {
        Gate::authorize('update', $post);

        $authors = OrganizationUser::orderBy('name')->get();

        return view('admin::posts.edit', [
            'post' => $post,
            'authors' => $authors,
        ]);
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        Gate::authorize('update', $post);

        try {
            $validated = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'content' => ['required', 'string'],
                'organization_user_id' => ['required', 'exists:organization_users,id'],
            ]);

            $post->update($validated);

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Post updated successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update post. Please try again.');
        }
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        Gate::authorize('delete', $post);

        try {
            $post->delete();

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Post has been deleted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete post. Please try again.');
        }
    }
}
