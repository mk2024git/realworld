<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleStoreRequest;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->has('tag')) {
            $tag = Tag::where('name', $request->input('tag'))->firstOrFail();
            $query->whereHas('tags', function ($q) use ($tag) {
                $q->where('tag_id', $tag->id);
            });
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(10);
        $popularTags = Tag::popularTags();

        return view('home', compact('articles', 'popularTags'));
    }

    public function create()
    {
        $action = route('articles.store');
        return view('create_edit_article',compact('action'));
    }

    public function edit($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        $action = route('article.update',$slug);
        return view('create_edit_article', compact('article','action'));
    }

    public function destroy($slug) {
        Article::where('slug', $slug)->firstOrFail()->delete();
        return redirect()->route('home');
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return view('article', compact('article'));
    }

    public function update(ArticleStoreRequest $request,$prev_slug){
        $validated = $request->validated();
        $new_slug = null;
        DB::transaction(function () use(&$prev_slug,&$new_slug,$validated,$request){
            $article = Article::query()->where('slug','=',$prev_slug)->firstOrFail();

            $new_slug = \Str::slug($request->input('title'));
            $originalSlug = $new_slug;
            $count = 1;
            while (Article::where('slug', $new_slug)->exists()) {
                $new_slug = "{$originalSlug}-{$count}";
                $count++;
            }
            $validated['slug'] = $new_slug;

            $article->fill($validated);
            $article->save();

            $tags = [];
            if ($request->has('tags')) {
                $tags = collect($request->input('tags'))->map(function ($tag) {
                    return Tag::firstOrCreate(['name' => trim($tag)])->id;
                });
            }
            $article->tags()->sync($tags);

            $new_slug = $article->slug;
        });

        return redirect()->route('article.show', $new_slug);

    }

    public function store(ArticleStoreRequest $request)
    {
        $validated = $request->validated();

        $slug = \Str::slug($request->input('title'));
        $originalSlug = $slug;
        $count = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $validated['slug'] = $slug;

        $article = Article::create($validated);

        if ($request->has('tags')) {
            $tags = collect($request->input('tags'))->map(function ($tag) {
                return Tag::firstOrCreate(['name' => trim($tag)])->id;
            });

            $article->tags()->sync($tags);
        }

        return redirect()->route('article.show', $article->slug);
    }




}
