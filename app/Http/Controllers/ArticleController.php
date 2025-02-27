<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Tag;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of articles.
     */
    public function index(Request $request)
    {
        $query = Article::with(['category', 'author', 'tags'])
            ->published();

        // Filter by category if provided
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
            $currentCategory = ArticleCategory::where('slug', $request->category)->first();
        } else {
            $currentCategory = null;
        }

        // Filter by tag if provided
        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
            $currentTag = Tag::where('slug', $request->tag)->first();
        } else {
            $currentTag = null;
        }

        // Filter by author if provided
        if ($request->has('author')) {
            $query->whereHas('author', function ($q) use ($request) {
                $q->where('slug', $request->author);
            });
            $currentAuthor = Author::where('slug', $request->author)->first();
        } else {
            $currentAuthor = null;
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Sort articles
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            default: // latest
                $query->orderBy('published_at', 'desc');
                break;
        }

        $articles = $query->paginate(9);
        $featuredArticles = Article::with(['category', 'author'])
            ->published()
            ->featured()
            ->limit(3)
            ->orderBy('published_at', 'desc')
            ->get();

        $categories = ArticleCategory::active()->get();

        return view('pages.articles.index', compact(
            'articles',
            'featuredArticles',
            'categories',
            'currentCategory',
            'currentTag',
            'currentAuthor',
            'sort'
        ));
    }

    /**
     * Display the specified article.
     */
    public function show($slug)
    {
        $article = Article::with(['category', 'author', 'tags'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment view count
        $article->incrementViewCount();

        // Skip related articles from the relatedArticles() relationship
        // Instead, get articles from the same category
        $relatedArticles = Article::where('id', '!=', $article->id)
            ->where('article_category_id', $article->article_category_id)
            ->published()
            ->limit(3)
            ->orderBy('published_at', 'desc')
            ->get();

        // Get popular articles
        $popularArticles = Article::published()
            ->popular(4)
            ->get();

        // Get recent articles
        $recentArticles = Article::published()
            ->recent(4)
            ->get();

        return view('pages.articles.show', compact(
            'article',
            'relatedArticles',
            'popularArticles',
            'recentArticles'
        ));
    }

    /**
     * Display articles by category.
     */
    public function byCategory($slug)
    {
        return redirect()->route('articles.index', ['category' => $slug]);
    }

    /**
     * Display articles by tag.
     */
    public function byTag($slug)
    {
        return redirect()->route('articles.index', ['tag' => $slug]);
    }

    /**
     * Display articles by author.
     */
    public function byAuthor($slug)
    {
        return redirect()->route('articles.index', ['author' => $slug]);
    }
}
