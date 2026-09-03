<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
        'custom_image' => 'nullable|mimes:jpg,jpeg,png,webp,heic,heif|max:10240',
        'quantity' => 'required|integer|min:1',
        'customer_name' => 'required|string|max:255',
        'contact_preference' => 'required|in:wa,email',
        'customer_contact' => [
            'required',
            function ($attribute, $value, $fail) use ($request) {
                if ($request->input('contact_preference') === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $fail('Masukkan alamat email yang valid.');
                }
            },
        ],
        'notes' => 'nullable|string',
    ], [
        'order_type.required' => 'Jenis pesanan wajib dipilih.',
        'order_type.in' => 'Jenis pesanan tidak valid.',
        'product_id.required_if' => 'Produk wajib dipilih untuk pesanan katalog.',
        'product_id.exists' => 'Produk yang dipilih tidak ditemukan.',
        'custom_description.required_if' => 'Deskripsi custom wajib diisi.',
        'custom_image.image' => 'File yang diunggah harus berupa gambar.',
        'custom_image.max' => 'Ukuran gambar maksimal 10MB.',
        'quantity.required' => 'Jumlah pesanan wajib diisi.',
        'quantity.integer' => 'Jumlah harus berupa angka.',
        'quantity.min' => 'Jumlah minimal 1.',
        'customer_name.required' => 'Nama pemesan wajib diisi.',
        'customer_name.max' => 'Nama maksimal 255 karakter.',
        'contact_preference.required' => 'Preferensi kontak wajib dipilih.',
        'customer_contact.required' => 'Kontak wajib diisi.',
        'custom_image.mimes' => 'Format gambar harus JPG, PNG, WEBP, atau HEIC.',
        'custom_image.max' => 'Ukuran gambar maksimal 10MB.',
    ]);

    // Auto-koreksi: cross-check isi kontak vs pilihan dropdown, biar data selalu konsisten
    $isEmailFormat = filter_var($validated['customer_contact'], FILTER_VALIDATE_EMAIL);
    $validated['contact_preference'] = $isEmailFormat ? 'email' : 'wa';

    if ($request->hasFile('custom_image')) {
        $validated['custom_image'] = $request->file('custom_image')->store('custom-orders', 'public');
    }

    $order = Order::create($validated);
    $order->refresh();

    $productName = $order->order_type === 'catalog'
        ? optional($order->product)->name
        : 'Custom - ' . $order->custom_description;

    $this->notifyAdmin($order, $productName);

    if ($order->contact_preference === 'wa') {
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

    private function notifyAdmin(Order $order, ?string $productName): void
    {
        $adminEmail = config('services.admin.email');

        if (!$adminEmail) {
            return;
        }

        $body = "Ada pesanan badge baru masuk:\n\n"
            . "Jenis: {$order->order_type}\n"
            . "Produk: {$productName}\n"
            . "Jumlah: {$order->quantity} pcs\n"
            . "Nama Pemesan: {$order->customer_name}\n"
            . "Kontak: {$order->customer_contact} (via {$order->contact_preference})\n"
            . ($order->notes ? "Catatan: {$order->notes}\n" : '')
            . "\nWaktu: {$order->created_at}";

        Mail::raw($body, function ($mail) use ($adminEmail, $order) {
            $mail->to($adminEmail)
                ->subject('Pesanan Baru #' . $order->id . ' - TRX Atribut');
        });
    }
}