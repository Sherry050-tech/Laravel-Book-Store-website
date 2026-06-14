@extends('layouts.admin')

@section('content')
<div class="topbar">
    <h1>Add New Book</h1>
    <a href="{{ route('admin.books.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="panel">
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    @error('title')<p style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label>Author *</label>
                    <input type="text" name="author" class="form-control" value="{{ old('author') }}" required>
                    @error('author')<p style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label>Price ($) *</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price') }}" step="0.01" min="0.01" required>
                    @error('price')<p style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label>Category *</label>
                    <select name="category" class="form-control" required>
                        <option value="bestseller"  {{ old('category')=='bestseller'  ? 'selected':'' }}>Best Seller</option>
                        <option value="new_release" {{ old('category')=='new_release' ? 'selected':'' }}>New Release</option>
                        <option value="top_rated"   {{ old('category')=='top_rated'   ? 'selected':'' }}>Top Rated</option>
                        <option value="popular"     {{ old('category')=='popular'     ? 'selected':'' }}>Popular</option>
                        <option value="suggestion"  {{ old('category')=='suggestion'  ? 'selected':'' }}>Suggestion</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Rating (0–5)</label>
                    <input type="number" name="rating" class="form-control" value="{{ old('rating', 4.5) }}" step="0.5" min="0" max="5">
                </div>
                <div class="form-group">
                    <label>Stock *</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', 100) }}" min="0" required>
                </div>
                <div class="form-group form-full">
                    <label>Cover Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="form-group form-full">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-gold" style="margin-top:8px;"><i class="fas fa-save"></i> Add Book</button>
        </form>
    </div>
</div>
@endsection