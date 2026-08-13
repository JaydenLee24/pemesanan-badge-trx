<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->get();
        return view('order.index', compact('products'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'order_type' => 'required|in:catalog,custom',
        'product_id' => 'required_if:order_type,catalog|nullable|exists:products,id',
        'custom_description' => 'required_if:order_type,custom|nullable|string',
        'custom_image' => 'nullable|image|max:2048',
        'quantity' => 'required|integer|min:1',
        'customer_name' => 'required|string|max:255',
        'customer_contact' => 'required|string|max:50',
        'notes' => 'nullable|string',
    ], [
        'order_type.required' => 'Jenis pesanan wajib dipilih.',
        'order_type.in' => 'Jenis pesanan tidak valid.',
        'product_id.required_if' => 'Produk wajib dipilih untuk pesanan katalog.',
        'product_id.exists' => 'Produk yang dipilih tidak ditemukan.',
        'custom_description.required_if' => 'Deskripsi custom wajib diisi.',
        'custom_image.image' => 'File yang diunggah harus berupa gambar.',
        'custom_image.max' => 'Ukuran gambar maksimal 2MB.',
        'quantity.required' => 'Jumlah pesanan wajib diisi.',
        'quantity.integer' => 'Jumlah harus berupa angka.',
        'quantity.min' => 'Jumlah minimal 1.',
        'customer_name.required' => 'Nama pemesan wajib diisi.',
        'customer_name.max' => 'Nama maksimal 255 karakter.',
        'customer_contact.required' => 'Kontak wajib diisi.',
        'customer_contact.max' => 'Kontak maksimal 50 karakter.',
    ]);

    if ($request->hasFile('custom_image')) {
        $path = $request->file('custom_image')->store('custom-orders', 'public');
        $validated['custom_image'] = $path;
    }

    Order::create($validated);

    return redirect()->route('order.index')->with('success', 'Pesanan berhasil dikirim! Admin akan segera menghubungi Anda.');
}
}