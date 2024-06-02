<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Article;

class CommentController extends Controller
{
    public function store(Request $request, $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        $request->validate([
            'body' => 'required|string|max:500',
        ]);

        $comment = new Comment();
        $comment->body = $request->input('body');
        // $comment->author = 'Unknown';
        $comment->article_id = $article->id;
        $comment->save();

        return redirect()->route('article.show', $slug)->with('success', 'Comment posted successfully!');
    }

    public function destroy($slug, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->route('article.show', $slug)->with('success', 'Comment deleted successfully!');
    }
}
