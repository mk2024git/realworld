@extends('layouts.app')

@section('content')
<div class="article-page">
    <div class="banner">
        <div class="container">
            <h1>{{ $article->title }}</h1>
            <div class="article-meta">
                <a href="#"><img src="http://i.imgur.com/Qr71crq.jpg" alt="{{ $article->title }}"></a>
                <div class="info">
                    <a href="#" class="author">Unknown Author</a>
                    <span class="date">{{ $article->created_at->format('F jS, Y') }}</span>
                </div>
                <button class="btn btn-sm btn-outline-secondary">
                    <i class="ion-plus-round"></i>
                    &nbsp; Follow Unknown Author <span class="counter">(0)</span>
                </button>
                &nbsp;&nbsp;
                <button class="btn btn-sm btn-outline-primary">
                    <i class="ion-heart"></i>
                    &nbsp; Favorite Post <span class="counter">(0)</span>
                </button>
                <a href="{{ route('article.edit', $article->slug) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="ion-edit"></i> Edit Article
                </a>
                <form method="POST" action="{{ route('article.destroy', $article->slug) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="ion-trash-a"></i> Delete Article
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="container page">
        <div class="row article-content">
            <div class="col-md-12">
                <p>{{ $article->body }}</p>
                <ul class="tag-list">
                    @foreach ($article->tags as $tag)
                        <li class="tag-default tag-pill tag-outline">{{ $tag->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <hr />

        <div class="article-actions">
            <div class="article-meta">
                <a href="#"><img src="http://i.imgur.com/Qr71crq.jpg" alt="Unknown Author"></a>
                <div class="info">
                    <a href="#" class="author">Unknown Author</a>
                    <span class="date">{{ $article->created_at->format('F jS, Y') }}</span>
                </div>
                <button class="btn btn-sm btn-outline-secondary">
                    <i class="ion-plus-round"></i>
                    &nbsp; Follow Unknown Author <span class="counter">(0)</span>
                </button>
                &nbsp;
                <button class="btn btn-sm btn-outline-primary">
                    <i class="ion-heart"></i>
                    &nbsp; Favorite Article <span class="counter">(0)</span>
                </button>
                <a href="{{ route('article.edit', $article->slug) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="ion-edit"></i> Edit Article
                </a>
                <form method="POST" action="{{ route('article.destroy', $article->slug) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="ion-trash-a"></i> Delete Article
                    </button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-8 offset-md-2">
                <form method="POST" action="{{ route('comments.store', $article->slug) }}" class="card comment-form">
                    @csrf
                    <div class="card-block">
                        <textarea class="form-control" name="body" placeholder="Write a comment..." rows="3" required></textarea>
                    </div>
                    <div class="card-footer">
                        <img src="http://i.imgur.com/Qr71crq.jpg" class="comment-author-img" />
                        <button type="submit" class="btn btn-sm btn-primary">Post Comment</button>
                    </div>
                </form>

                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @foreach($article->comments as $comment)
                <div class="card">
                    <div class="card-block">
                        <p class="card-text">{{ $comment->body }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="/profile/author" class="comment-author">
                            <img src="http://i.imgur.com/Qr71crq.jpg" class="comment-author-img" />
                          </a>
                          &nbsp;
                          <a href="#" class="comment-author">Unknown Author</a>
                        <span class="date-posted">{{ $comment->created_at->format('F jS, Y') }}</span>
                        <span class="mod-options">
                            <form method="POST" action="{{ route('comments.destroy', ['slug' => $article->slug, 'id' => $comment->id]) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link btn-sm">
                                    <i class="ion-trash-a"></i>
                                </button>
                            </form>
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
