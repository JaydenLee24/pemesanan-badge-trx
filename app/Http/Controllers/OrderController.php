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
        'product_id' => 'nullable|exists:products,id',
        'custom_description' => 'nullable|string',
        'custom_image' => 'nullable|image|max:2048',
        'quantity' => 'required|integer|min:1',
        'customer_name' => 'required|string|max:255',
        'contact_preference' => 'required|in:wa,email',
        'customer_contact' => [
            'required',
            function ($attribute, $value, $fail) use ($request) {
                if ($request->contact_preference === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $fail('Masukkan alamat email yang valid.');
                }
            },
        ],
        'notes' => 'nullable|string',
    ]);

    if ($request->hasFile('custom_image')) {
        $path = $request->file('custom_image')->store('custom-orders', 'public');
        $validated['custom_image'] = $path;
    }

    $order = Order::create($validated);

    if ($order->contact_preference === 'wa') {
        $productName = $order->order_type === 'catalog'
            ? optional($order->product)->name
            : 'Custom - ' . $order->custom_description;

        $message = "Halo Admin TRX Atribut, saya ingin konfirmasi pesanan:\n\n"
            . "Produk: {$productName}\n"
            . "Jumlah: {$order->quantity} pcs\n"
            . "Nama: {$order->customer_name}\n"
            . "Kontak: {$order->customer_contact}\n"
            . ($order->notes ? "Catatan: {$order->notes}\n" : '');

        $waLink = 'https://wa.me/' . config('services.admin.whatsapp') . '?text=' . urlencode($message);

        return redirect()->route('order.index')
            ->with('success', 'Pesanan berhasil dikirim! Klik tombol di bawah untuk konfirmasi via WhatsApp.')
            ->with('wa_link', $waLink);
    }

    return redirect()->route('order.index')
        ->with('success', 'Pesanan berhasil dikirim! Admin akan menghubungi Anda melalui email dalam 1x24 jam.');
}
}