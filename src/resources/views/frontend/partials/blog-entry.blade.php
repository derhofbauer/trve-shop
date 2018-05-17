<article class="blog-entry">
    <header class="blog-entry__header header">
        <h3>{{ $entry->title }}</h3>
    </header>
    <div class="blog-entry__abstract abstract">
        {{ $entry->abstract }}
    </div>
    <div class="blog-entry__more">
        <a href="{{ route('blog.show', ['id' => $entry->id, 'slug' => str_slug($entry->title) ]) }}">{{ __('Read more') }}</a>
    </div>
</article>