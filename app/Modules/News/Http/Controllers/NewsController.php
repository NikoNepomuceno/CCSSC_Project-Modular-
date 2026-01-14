<?php

namespace App\Modules\News\Http\Controllers;

use App\Models\Post;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class NewsController extends Controller
{
    /**
     * Display the news listing page with article previews.
     */
    public function index(): View
    {
        // Get the featured article (most recent)
        $featured = Post::with('organizationUser')
            ->latest()
            ->first();

        // Get other articles for the sidebar (excluding featured)
        $articles = Post::with('organizationUser')
            ->when($featured, fn($query) => $query->where('id', '!=', $featured->id))
            ->latest()
            ->take(4)
            ->get();

        return view('news::index', compact('featured', 'articles'));
    }

    /**
     * Display the full article view.
     */
    public function show(Post $post): View
    {
        $post->load('organizationUser');

        // Get related articles for the sidebar
        $relatedArticles = Post::with('organizationUser')
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();

        return view('news::show', compact('post', 'relatedArticles'));
    }
}
