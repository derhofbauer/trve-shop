<article class="blog-entry panel">
    <header class="blog-entry__header header">
        <h3>
            <a href="{{ route('blog.show', ['id' => $entry->id, 'slug' => str_slug($entry->title) ]) }}">
                {{ $entry->title }}
            </a>
        </h3>
    </header>
    <div class="blog-entry__abstract-container">
        <div class="blog-entry__abstract abstract">
            {{ $entry->abstract }}

            <div class="blog-entry__more">
                <a href="{{ route('blog.show', ['id' => $entry->id, 'slug' => str_slug($entry->title) ]) }}">{{ __('Read more ...') }}</a>
            </div>
        </div>
        @if ($entry->hasMedia())
        <div class="blog-entry__image image">
            <a href="{{ route('blog.show', ['id' => $entry->id, 'slug' => str_slug($entry->title) ]) }}">
                <img src="/public{{ Storage::disk('local')->url($entry->getFirstImageUri()) }}" alt="{{ __('Blog Image') }}" class="img-responsive">
            </a>
        </div>
        @endif
    </div>
</article>