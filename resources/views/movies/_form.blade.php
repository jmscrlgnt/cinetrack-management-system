@if($errors->any())
    <div class="alert alert-error">
        <strong>Please correct the following errors:</strong>
        <ul style="margin:7px 0 0;padding-left:18px">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-grid">
    <div class="form-group">
        <label for="title">Movie Title</label>
        <input type="text" id="title" name="title" value="{{ old('title', $movie->title ?? '') }}" placeholder="Example: Interstellar" required>
        @error('title')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="genre">Genre</label>
        <input type="text" id="genre" name="genre" value="{{ old('genre', $movie->genre ?? '') }}" placeholder="Example: Science Fiction" required>
        @error('genre')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="release_year">Release Year</label>
        <input type="number" id="release_year" name="release_year" min="1900" max="{{ now()->year + 1 }}" value="{{ old('release_year', $movie->release_year ?? '') }}" placeholder="Example: 2014" required>
        @error('release_year')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="status">Watch Status</label>
        @php $currentStatus = old('status', $movie->status ?? 'Plan to Watch'); @endphp
        <select id="status" name="status" required>
            <option value="Plan to Watch" @selected($currentStatus === 'Plan to Watch')>Plan to Watch</option>
            <option value="Watching" @selected($currentStatus === 'Watching')>Watching</option>
            <option value="Completed" @selected($currentStatus === 'Completed')>Completed</option>
        </select>
        @error('status')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="rating">Rating (0–10)</label>
        <input type="number" id="rating" name="rating" step="0.1" min="0" max="10" value="{{ old('rating', $movie->rating ?? '') }}" placeholder="Example: 8.5">
        <div class="form-help">Optional. Use decimals such as 8.5.</div>
        @error('rating')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group" style="display:flex;align-items:center;padding-top:25px">
        <label class="check-row">
            <input type="hidden" name="is_favorite" value="0">
            <input type="checkbox" name="is_favorite" value="1" @checked(old('is_favorite', $movie->is_favorite ?? false))>
            Mark this movie as a favorite ★
        </label>
    </div>
</div>

<div class="form-group">
    <label for="notes">Notes</label>
    <textarea id="notes" name="notes" placeholder="Optional comments, reminders, or thoughts about the movie...">{{ old('notes', $movie->notes ?? '') }}</textarea>
    <div class="form-help">Maximum 1,000 characters.</div>
    @error('notes')<div class="field-error">{{ $message }}</div>@enderror
</div>
