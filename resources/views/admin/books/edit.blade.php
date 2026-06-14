@extends('layouts.admin')

@section('content')
<div class="topbar">
    <h1>Edit Book</h1>
    <a href="{{ route('admin.books.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="panel">
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-grid">
                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}" required>
                </div>
                <div class="form-group">
                    <label>Author *</label>
                    <input type="text" name="author" class="form-control" value="{{ old('author', $book->author) }}" required>
                </div>
                <div class="form-group">
                    <label>Price ($) *</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $book->price) }}" step="0.01" min="0.01" required>
                </div>
                <div class="form-group">
                    <label>Category *</label>
                    <select name="category" class="form-control">
                        @foreach(['bestseller','new_release','top_rated','popular','suggestion'] as $cat)
                        <option value="{{ $cat }}" {{ old('category', $book->category)==$cat ? 'selected':'' }}>
                            {{ ucfirst(str_replace('_',' ',$cat)) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Rating</label>
                    <input type="number" name="rating" class="form-control" value="{{ old('rating', $book->rating) }}" step="0.5" min="0" max="5">
                </div>
                <div class="form-group">
                    <label>Stock</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $book->stock) }}" min="0">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="is_active" class="form-control">
                        <option value="1" {{ $book->is_active ? 'selected':'' }}>Active (visible)</option>
                        <option value="0" {{ !$book->is_active ? 'selected':'' }}>Hidden</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>New Cover Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    @if($book->image)
                        <img src="{{ asset('storage/'.$book->image) }}" style="margin-top:8px;height:80px;border-radius:6px;" onerror="this.style.display='none'">
                    @endif
                </div>
                <div class="form-group form-full">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $book->description) }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-gold" style="margin-top:8px;"><i class="fas fa-save"></i> Update Book</button>
        </form>
    </div>
</div>
@endsection