@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Cập nhật sản phẩm: {{ $product->name }}</h5>
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">Quay lại</a>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="mb-3">
                        <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Giá <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price"
                               value="{{ old('price', $product->price) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="store_id" class="form-label">Cửa hàng <span class="text-danger">*</span></label>
                        <select class="form-select" id="store_id" name="store_id" required>
                            <option value="">-- Chọn cửa hàng --</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}"
                                    {{-- Logic kiểm tra: Nếu id cửa hàng khớp với store_id của sản phẩm thì chọn --}}
                                    {{ (old('store_id', $product->store_id) == $store->id) ? 'selected' : '' }}>
                                    {{ $store->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
