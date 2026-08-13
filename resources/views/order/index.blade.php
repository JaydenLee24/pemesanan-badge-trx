<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Badge</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        h1 { text-align: center; }
        .alert-success { background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-bottom: 40px; }
        .product-card { background: #fff; border-radius: 8px; padding: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
        .product-card h3 { margin: 8px 0 4px; font-size: 16px; }
        .product-card p { margin: 2px 0; font-size: 13px; color: #555; }
        .product-card .price { font-weight: bold; color: #2b6cb0; }
        .order-form { background: #fff; padding: 24px; border-radius: 8px; }
        .order-form label { display: block; margin-top: 12px; font-weight: bold; font-size: 14px; }
        .order-form input, .order-form select, .order-form textarea {
            width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box;
            border: 1px solid #ccc; border-radius: 4px;
        }
        .order-form button {
            margin-top: 20px; padding: 10px 20px; background: #2b6cb0; color: #fff;
            border: none; border-radius: 4px; cursor: pointer;
        }
        .error { color: #c00; font-size: 13px; margin-top: 4px; }
        #custom-fields { display: none; }
    </style>
</head>
<body>

    <h1>Pemesanan Badge</h1>

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <h2>Katalog Produk</h2>
    <div class="product-grid">
        @foreach ($products as $product)
            <div class="product-card">
                <h3>{{ $product->name }}</h3>
                <p>{{ $product->category }} · {{ $product->size }}</p>
                <p class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                @if ($product->min_qty_nego)
                    <p>Min. order nego: {{ $product->min_qty_nego }} pcs</p>
                @endif
            </div>
        @endforeach
    </div>

    <h2>Form Pemesanan</h2>
    <div class="order-form">
        <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label>Jenis Pesanan</label>
            <select name="order_type" id="order_type">
                <option value="catalog">Pilih dari katalog</option>
                <option value="custom">Custom (desain sendiri)</option>
            </select>
            @error('order_type') <div class="error">{{ $message }}</div> @enderror

            <div id="catalog-fields">
                <label>Pilih Produk</label>
                <select name="product_id">
                    <option value="">-- Pilih produk --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}</option>
                    @endforeach
                </select>
                @error('product_id') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div id="custom-fields">
                <label>Deskripsi Custom</label>
                <textarea name="custom_description" rows="3" placeholder="Jelaskan desain, warna, ukuran badge yang diinginkan"></textarea>
                @error('custom_description') <div class="error">{{ $message }}</div> @enderror

                <label>Upload Gambar Referensi (opsional, max 2MB)</label>
                <input type="file" name="custom_image" accept="image/*">
                @error('custom_image') <div class="error">{{ $message }}</div> @enderror
            </div>

            <label>Jumlah (Qty)</label>
            <input type="number" name="quantity" min="1" value="1">
            @error('quantity') <div class="error">{{ $message }}</div> @enderror

            <label>Nama Pemesan</label>
            <input type="text" name="customer_name">
            @error('customer_name') <div class="error">{{ $message }}</div> @enderror

            <label>Kontak (No. HP / WhatsApp)</label>
            <input type="text" name="customer_contact">
            @error('customer_contact') <div class="error">{{ $message }}</div> @enderror

            <label>Catatan Tambahan (opsional)</label>
            <textarea name="notes" rows="2"></textarea>
            @error('notes') <div class="error">{{ $message }}</div> @enderror

            <div id="nego-box" style="display:none; background:#fff3cd; padding:12px; border-radius:6px; margin-top:16px;">
    <p style="margin:0 0 8px;">Jumlah pesanan Anda memenuhi syarat nego harga. Hubungi admin untuk penawaran khusus:</p>
    <a href="https://wa.me/6287724037964" target="_blank" style="color:#2b6cb0; font-weight:bold;">Hubungi Admin via WhatsApp</a>
</div>
            <button type="submit">Kirim Pesanan</button>
        </form>
    </div>

    <script>
    const products = @json($products->keyBy('id'));

    const orderType = document.getElementById('order_type');
    const catalogFields = document.getElementById('catalog-fields');
    const customFields = document.getElementById('custom-fields');
    const productSelect = document.querySelector('select[name="product_id"]');
    const quantityInput = document.querySelector('input[name="quantity"]');
    const negoBox = document.getElementById('nego-box');

    function toggleFields() {
        if (orderType.value === 'custom') {
            catalogFields.style.display = 'none';
            customFields.style.display = 'block';
            negoBox.style.display = 'none';
        } else {
            catalogFields.style.display = 'block';
            customFields.style.display = 'none';
            checkNego();
        }
    }

    function checkNego() {
        const productId = productSelect.value;
        const qty = parseInt(quantityInput.value) || 0;

        if (orderType.value !== 'catalog' || !productId) {
            negoBox.style.display = 'none';
            return;
        }

        const product = products[productId];
        if (product && product.min_qty_nego > 0 && qty >= product.min_qty_nego) {
            negoBox.style.display = 'block';
        } else {
            negoBox.style.display = 'none';
        }
    }

    orderType.addEventListener('change', toggleFields);
    productSelect.addEventListener('change', checkNego);
    quantityInput.addEventListener('input', checkNego);
    toggleFields();
</script>

</body>
</html>