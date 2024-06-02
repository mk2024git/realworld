@extends('layouts.app')

@section('content')
<div class="home-page">
    <div class="banner">
        <div class="container">
            <h1 class="logo-font">conduit</h1>
            <p>A place to share your knowledge.</p>
        </div>
    </div>

    <div class="container page">
        <div class="row">
            <div class="col-md-9">
                <div class="feed-toggle">
                    <ul class="nav nav-pills outline-active">
                        <li class="nav-item">
                            <a class="nav-link" href="">Your Feed</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="">Global Feed</a>
                        </li>
                    </ul>
                </div>

                @foreach($articles as $article)
                <div class="article-preview">
                    <div class="article-meta">
                        <a href="#">
                            <img src="http://i.imgur.com/Qr71crq.jpg" />
                        </a>
                        <div class="info">
                            <a href="#" class="author">Unknown Author</a>
                            <span class="date">{{ $article->created_at->format('F jS') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('article.show', $article->slug) }}" class="preview-link">
                        <h1>{{ $article->title }}</h1>
                        <p>{{ $article->description }}</p>
                        <span>Read more...</span>
                        <ul class="tag-list">
                            @foreach($article->tags as $tag)
                            <li class="tag-default tag-pill tag-outline">{{ $tag->name }}</li>
                            @endforeach
                        </ul>
                    </a>
                </div>
                @endforeach

                <nav>
                    {{ $articles->links('pagination::bootstrap-4') }}
                </nav>
            </div>

            <div class="col-md-3">
                <div class="sidebar">
                    <p>Popular Tags</p>
                    <div class="tag-list">
                        @foreach($popularTags as $tag)
                        <a href="{{ route('articles.index', ['tag' => $tag->name]) }}" class="tag-pill tag-default">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
