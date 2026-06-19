@extends('layouts.admin')

@section('content')
<div class="topbar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Edit Book: {{ $book->title }}</h1>
    <a href="{{ route('admin.books.index') }}" class="btn btn-outline">&larr; Cancel</a>
</div>

<div class="panel" style="max-width: 800px; background: #fff; padding: 24px; border-radius: 8px; border: 1px solid #eaeaea;">
    <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 16px;">
            <label style="font-weight: bold; display: block; margin-bottom: 8px;">Title</label>
            <input type="text" name="title" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" value="{{ old('title', $book->title) }}">
        </div>

        <div style="margin-bottom: 16px;">
            <label style="font-weight: bold; display: block; margin-bottom: 8px;">Author</label>
            <input type="text" name="author" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" value="{{ old('author', $book->author) }}">
        </div>

        <div style="display: flex; gap: 16px; margin-bottom: 16px;">
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Price ($)</label>
                <input type="number" step="0.01" name="price" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" value="{{ old('price', $book->price) }}">
            </div>
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Stock Quantity</label>
                <input type="number" name="stock" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" value="{{ old('stock', $book->stock) }}">
            </div>
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Category</label>
                <select name="category" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="bestseller" {{ $book->category == 'bestseller' ? 'selected' : '' }}>Bestseller</option>
                    <option value="new_release" {{ $book->category == 'new_release' ? 'selected' : '' }}>New Release</option>
                    <option value="top_rated" {{ $book->category == 'top_rated' ? 'selected' : '' }}>Top Rated</option>
                    <option value="popular" {{ $book->category == 'popular' ? 'selected' : '' }}>Popular</option>
                </select>
            </div>
        </div>

        <div style="margin-bottom: 16px;">
            <label style="font-weight: bold; display: block; margin-bottom: 8px;">Description</label>
            <textarea name="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">{{ old('description', $book->description) }}</textarea>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="font-weight: bold; display: block; margin-bottom: 8px;">Update Cover Image (Leave blank to keep current)</label>
            <input type="file" name="image" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            
            @if($book->image)
                <div style="margin-top: 10px;">
                    <small style="color: #666;">Current Image:</small><br>
                    <img src="{{ asset('storage/' . $book->image) }}" alt="Current Cover" style="height: 100px; border-radius: 4px; margin-top: 5px;">
                </div>
            @endif
        </div>

        <button type="submit" style="background: #111; color: #fff; padding: 12px 24px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
            Update Book
        </button>
    </form>
</div>
@endsection