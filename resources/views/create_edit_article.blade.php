@extends('layouts.app')

@section('content')
<div class="editor-page">
    <div class="container page">
        <div class="row">
            <div class="col-md-10 offset-md-1 col-xs-12">
                <ul class="error-messages">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <form method="POST" action="{{ $action }}" id="article-form">
                    @csrf
                    @if(isset($article))
                        @method('PUT')
                    @endif
                    <fieldset>
                        <fieldset class="form-group">
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                name="title"
                                placeholder="Article Title"
                                value="{{ old('title', $article->title ?? '') }}"
                                required
                            />
                        </fieldset>
                        <fieldset class="form-group">
                            <input
                                type="text"
                                class="form-control"
                                name="description"
                                placeholder="What's this article about?"
                                value="{{ old('description', $article->description ?? '') }}"
                                required
                            />
                        </fieldset>
                        <fieldset class="form-group">
                            <textarea
                                class="form-control"
                                name="body"
                                rows="8"
                                placeholder="Write your article (in markdown)"
                                required
                            >{{ old('body', $article->body ?? '') }}</textarea>
                        </fieldset>
                        <fieldset class="form-group">
                            <input type="text" class="form-control" placeholder="Enter tags" id="tag-input"/>
                            <div class="tag-list" id="tag-list">
                                @if(isset($article->tags))
                                    @foreach($article->tags as $tag)
                                        <span class="tag-default tag-pill">
                                            <i class="ion-close-round" data-tag="{{ $tag->name }}"></i>{{ $tag->name }}
                                            <input type="hidden" name="tags[]" value="{{ $tag->name }}">
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </fieldset>
                        <button class="btn btn-lg pull-xs-right btn-primary">
                            {{ isset($article) ? 'Update Article' : 'Publish Article' }}
                        </button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tagInput = document.getElementById('tag-input');
        const tagList = document.getElementById('tag-list');
        const articleForm = document.getElementById('article-form');
        let tags = [];

        function addTag(tag) {
            if (tag && !tags.includes(tag)) {
                tags.push(tag);
                const tagElement = document.createElement('span');
                tagElement.className = 'tag-default tag-pill';
                tagElement.innerHTML = `<i class="ion-close-round" data-tag="${tag}"></i> ${tag}`;
                tagList.appendChild(tagElement);
                tagInput.value = '';

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'tags[]';
                hiddenInput.value = tag;
                tagList.appendChild(hiddenInput);
            }
        }

        tagInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const tag = tagInput.value.trim();
                addTag(tag);
            }
        });

        tagList.addEventListener('click', function (e) {
            if (e.target.tagName === 'I') {
                const tag = e.target.getAttribute('data-tag');
                tags = tags.filter(t => t !== tag);
                e.target.parentElement.remove();
                const hiddenInputs = tagList.querySelectorAll(`input[name="tags[]"][value="${tag}"]`);
                hiddenInputs.forEach(input => input.remove());
            }
        });

        articleForm.addEventListener('submit', function (e) {
            if (tagInput.value.trim()) {
                addTag(tagInput.value.trim());
            }
        });
    });
</script>
@endsection
