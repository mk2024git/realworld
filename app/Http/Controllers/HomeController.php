<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(8);
        $popularTags = Tag::popularTags();

        return view('home', compact('articles', 'popularTags'));
    }
}
