<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('store')->orderBy('products.created_at', 'desc')->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $stores = Store::all();
        return view('products.create', compact('stores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate [cite: 52]
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0.01', // Lớn hơn 0 [cite: 55]
            'store_id' => 'required|exists:stores,id', // Phải tồn tại trong bảng stores [cite: 56]
            'description' => 'nullable',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $stores = Store::all(); // Lấy danh sách cửa hàng để hiện trong thẻ <select>

        return view('products.edit', compact('product', 'stores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validate giống hệt lúc tạo mới (theo đề bài [cite: 66])
        $request->validate([
            'name' => 'required|string',      // [cite: 53]
            'price' => 'required|numeric|min:0.01', // [cite: 55]
            'store_id' => 'required|exists:stores,id', // [cite: 56]
            'description' => 'nullable',      // [cite: 54]
        ]);

        // Cập nhật toàn bộ dữ liệu từ form
        $product->update($request->all());

        // Quay về trang danh sách và báo công
        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete(); // Xóa khỏi database [cite: 70]

        return redirect()->route('products.index')->with('success', 'Đã xóa sản phẩm!');
    }
    public function search()
    {
        $query = request()->input('query');

        $products = Product::where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->with('store')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('products.index', compact('products'));

    }
}
