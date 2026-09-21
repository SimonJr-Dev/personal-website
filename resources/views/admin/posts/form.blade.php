@php
    $editing = $post->exists;
    $publishedAt = old('published_at', $post->published_at?->format('Y-m-d\TH:i'));
@endphp

<div class="card">

    <form method="POST"
        action="{{ $editing ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
        enctype="multipart/form-data">
        @csrf

        @if ($editing)
            @method('PUT')
        @endif

        <div class="form-grid">

            <div class="field full">
                <label for="title">Title</label>
                <input id="title" type="text" name="title" maxlength="160" required
                    value="{{ old('title', $post->title) }}">
                @error('title')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field full">
                <label for="content">Content</label>
                <textarea id="content" name="content" maxlength="20000" required
                    style="min-height:280px">{{ old('content', $post->content) }}</textarea>
                <span class="hint">Line breaks are kept as written.</span>
                @error('content')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field full">

                <label for="image">Image</label>
                <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif">
                <span class="hint">JPG, PNG, WebP or GIF, up to 4 MB. Optional.</span>

                @error('image')
                    <div class="error">{{ $message }}</div>
                @enderror

                <div class="image-preview" id="imagePreview" @if (! $post->imageUrl()) hidden @endif>

                    @if ($post->imageUrl())
                        <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}">
                    @endif

                    @if ($editing && $post->imageUrl())
                        <div class="check">
                            <input id="remove_image" type="checkbox" name="remove_image" value="1">
                            <label for="remove_image">Remove this image</label>
                        </div>
                    @endif

                </div>

            </div>

            <div class="field">
                <label for="published_at">Publish date</label>
                <input id="published_at" type="datetime-local" name="published_at" value="{{ $publishedAt }}">
                <span class="hint">Leave empty to publish immediately. A future date schedules the post.</span>
                @error('published_at')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label>Visibility</label>
                <div class="check" style="padding-top:12px">
                    <input id="is_published" type="checkbox" name="is_published" value="1"
                        @checked(old('is_published', $post->is_published))>
                    <label for="is_published">Published</label>
                </div>
                <span class="hint">Unpublished posts stay hidden from the blog.</span>
            </div>

        </div>

        <div class="form-actions" style="margin-top:22px">
            <button class="save-btn" type="submit">{{ $editing ? 'Save changes' : 'Create post' }}</button>
            <a class="btn" href="{{ route('admin.posts.index') }}">Cancel</a>
        </div>

    </form>

</div>
