@extends('layouts.admin')

@section('content')
<div class="topbar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Add New Book</h1>
    <a href="{{ route('admin.books.index') }}" class="btn btn-outline">&larr; Cancel</a>
</div>

<div class="panel" style="max-width: 800px; background: #fff; padding: 24px; border-radius: 8px; border: 1px solid #eaeaea;">
    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="margin-bottom: 16px;">
            <label style="font-weight: bold; display: block; margin-bottom: 8px;">Title</label>
            <input type="text" name="title" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" value="{{ old('title') }}">
        </div>

        <div style="margin-bottom: 16px;">
            <label style="font-weight: bold; display: block; margin-bottom: 8px;">Author</label>
            <input type="text" name="author" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" value="{{ old('author') }}">
        </div>

        <div style="display: flex; gap: 16px; margin-bottom: 16px;">
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Price ($)</label>
                <input type="number" step="0.01" name="price" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" value="{{ old('price') }}">
            </div>
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Stock Quantity</label>
                <input type="number" name="stock" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" value="{{ old('stock', 10) }}">
            </div>
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Category</label>
                <select name="category" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="bestseller">Bestseller</option>
                    <option value="new_release">New Release</option>
                    <option value="top_rated">Top Rated</option>
                    <option value="popular">Popular</option>
                </select>
            </div>
        </div>

        <div style="margin-bottom: 16px;">
            <label style="font-weight: bold; display: block; margin-bottom: 8px;">Description</label>
            <textarea name="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">{{ old('description') }}</textarea>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="font-weight: bold; display: block; margin-bottom: 8px;">Book Cover Image</label>
            <input type="file" name="image" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <button type="submit" style="background: #111; color: #fff; padding: 12px 24px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
            Save Book
        </button>
    </form>
</div>
@endsection