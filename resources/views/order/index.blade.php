<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Badge - TRX Atribut</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --near-black: #14181D;
            --navy: #1C3B57;
            --blue: #2B8FC7;
            --blue-dark: #1E6E9E;
            --bg: #F2F4F6;
            --surface: #FFFFFF;
            --text: #1A1D21;
            --text-muted: #5B6570;
            --border: #DCE1E6;
            --warn-bg: #FFF3CD;
            --warn-text: #6B5300;
            --success-bg: #DCF2E3;
            --success-text: #155724;
            --error-bg: #FBE2E2;
            --error-text: #8A1F1F;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', Arial, sans-serif;
            margin: 0;
            background: var(--bg);
            color: var(--text);
            line-height: 1.5;
        }

        h1, h2, h3 {
            font-family: 'Barlow Condensed', 'Inter', sans-serif;
            font-weight: 700;
            letter-spacing: 0.01em;
            margin: 0;
        }

        .topbar {
            background: var(--near-black);
            color: #fff;
            padding: 18px 24px;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .topbar img { height: 36px; width: auto; }
        .topbar .wordmark { display: flex; flex-direction: column; }
        .topbar .wordmark strong { font-family: 'Barlow Condensed', sans-serif; font-size: 20px; font-weight: 700; }
        .topbar .wordmark span { font-size: 12px; color: #9FB3C4; }

        .container { max-width: 960px; margin: 0 auto; padding: 32px 20px 60px; }

        .section-heading {
            font-size: 22px;
            color: var(--near-black);
            border-left: 5px solid var(--blue);
            padding-left: 12px;
            margin-bottom: 18px;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-success { background: var(--success-bg); color: var(--success-text); }
        .alert-error { background: var(--error-bg); color: var(--error-text); }
        .alert-error ul { margin: 8px 0 0; padding-left: 20px; }
        .btn-wa {
            display: inline-block; margin-top: 12px; padding: 10px 20px;
            background: #1E6E9E; color: #fff; border-radius: 6px;
            text-decoration: none; font-weight: 600; font-size: 14px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 16px;
            margin-bottom: 48px;
        }
        .product-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px;
        }
        .product-image {
            width: 100%; height: 140px; object-fit: cover;
            border-radius: 5px; margin-bottom: 10px;
        }
        .product-image-placeholder {
            width: 100%; height: 140px; background: #E4E9EC; color: var(--text-muted);
            display: flex; align-items: center; justify-content: center;
            border-radius: 5px; margin-bottom: 10px; font-size: 13px;
        }
        .product-card .category-tag {
            display: inline-block; font-size: 11px; font-weight: 600;
            color: var(--navy); background: #E4EDF3; padding: 3px 8px;
            border-radius: 4px; margin-bottom: 6px;
        }
        .product-card h3 { font-size: 17px; margin-bottom: 2px; }
        .product-card .meta { font-size: 13px; color: var(--text-muted); margin: 2px 0; }
        .product-card .price { font-weight: 700; color: var(--blue-dark); font-size: 15px; margin-top: 4px; }
        .product-card .nego-note { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

        .order-form {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            overflow: hidden;
        }
        .order-form .form-header {
            background: var(--navy);
            color: #fff;
            padding: 14px 24px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 18px;
            font-weight: 700;
        }
        .order-form .form-body { padding: 24px; }
        .order-form label { display: block; margin-top: 16px; font-weight: 600; font-size: 14px; color: var(--near-black); }
        .order-form input,
        .order-form select,
        .order-form textarea {
            width: 100%; padding: 9px 10px; margin-top: 5px;
            border: 1px solid var(--border); border-radius: 5px;
            font-family: 'Inter', sans-serif; font-size: 14px; color: var(--text);
            background: #fff;
        }
        .order-form input:focus,
        .order-form select:focus,
        .order-form textarea:focus {
            outline: none;
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(43, 143, 199, 0.15);
        }
        .order-form button {
            margin-top: 24px; padding: 12px 26px;
            background: var(--blue); color: #fff;
            border: none; border-radius: 6px; cursor: pointer;
            font-size: 15px; font-weight: 600;
        }
        .order-form button:hover { background: var(--blue-dark); }

        .error { color: var(--error-text); font-size: 13px; margin-top: 5px; }
        #custom-fields { display: none; }

        .nego-box {
            display: none;
            background: var(--warn-bg);
            color: var(--warn-text);
            padding: 14px;
            border-radius: 6px;
            margin-top: 20px;
            font-size: 14px;
        }
        .nego-box a { color: var(--navy); font-weight: 700; }
    </style>
</head>
<body>

    <div class="topbar">
        <img src="{{ asset('images/logo-trx.png') }}" alt="TRX Atribut">
        <div class="wordmark">
            <strong>TRX ATRIBUT</strong>
            <span>Pemesanan Badge & Atribut</span>
        </div>
    </div>

    <div class="container">

        @if ($errors->any())
        <div class="alert alert-error">
            <strong>Pesanan gagal dikirim, mohon periksa kembali:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            @if (session('wa_link'))
                <br>
                <a href="{{ session('wa_link') }}" target="_blank" class="btn-wa">Konfirmasi via WhatsApp</a>
            @endif
        </div>
        @endif

        <h2 class="section-heading">Katalog Produk</h2>
        <div class="product-grid">
            @foreach ($products as $product)
                <div class="product-card">
                    @if ($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" class="product-image" alt="{{ $product->name }}">
                    @else
                        <div class="product-image-placeholder">Foto belum tersedia</div>
                    @endif
                    <span class="category-tag">{{ $product->category }}</span>
                    <h3>{{ $product->name }}</h3>
                    <p class="meta">{{ $product->size }}</p>
                    <p class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    @if ($product->min_qty_nego)
                        <p class="nego-note">Min. order nego: {{ $product->min_qty_nego }} pcs</p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="order-form">
            <div class="form-header">Form Pemesanan</div>
            <div class="form-body">
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

                        <label>Upload Gambar Referensi (opsional, max 10MB)</label>
                        <input type="file" name="custom_image" accept="image/*">
                        @error('custom_image') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <label>Jumlah (Qty)</label>
                    <input type="number" name="quantity" min="1" value="1">
                    @error('quantity') <div class="error">{{ $message }}</div> @enderror

                    <label>Nama Pemesan</label>
                    <input type="text" name="customer_name">
                    @error('customer_name') <div class="error">{{ $message }}</div> @enderror

                    <label>Ingin Dihubungi Balik Melalui</label>
                    <select name="contact_preference" id="contact_preference">
                        <option value="wa">WhatsApp</option>
                        <option value="email">Email</option>
                    </select>
                    @error('contact_preference') <div class="error">{{ $message }}</div> @enderror

                    <label id="contact_label">Nomor WhatsApp</label>
                    <input type="text" name="customer_contact" id="customer_contact" placeholder="08xxxxxxxxxx">
                    @error('customer_contact') <div class="error">{{ $message }}</div> @enderror

                    <label>Catatan Tambahan (opsional)</label>
                    <textarea name="notes" rows="2"></textarea>
                    @error('notes') <div class="error">{{ $message }}</div> @enderror

                    <div id="nego-box" class="nego-box">
                        <p style="margin:0 0 8px;">Jumlah pesanan Anda memenuhi syarat nego harga. Hubungi admin untuk penawaran khusus:</p>
                        <a href="https://wa.me/6287724037964" target="_blank">Hubungi Admin via WhatsApp</a>
                    </div>

                    <button type="submit">Kirim Pesanan</button>
                </form>
            </div>
        </div>

    </div>

    <script>
    const products = @json($products->keyBy('id'));
    const orderType = document.getElementById('order_type');
    const catalogFields = document.getElementById('catalog-fields');
    const customFields = document.getElementById('custom-fields');
    const productSelect = document.querySelector('select[name="product_id"]');
    const quantityInput = document.querySelector('input[name="quantity"]');
    const negoBox = document.getElementById('nego-box');
    const contactPref = document.getElementById('contact_preference');
    const contactLabel = document.getElementById('contact_label');
    const contactInput = document.getElementById('customer_contact');

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

    function toggleContactField() {
        if (contactPref.value === 'email') {
            contactLabel.textContent = 'Alamat Email';
            contactInput.type = 'email';
            contactInput.placeholder = 'nama@email.com';
        } else {
            contactLabel.textContent = 'Nomor WhatsApp';
            contactInput.type = 'text';
            contactInput.placeholder = '08xxxxxxxxxx';
        }
    }

    orderType.addEventListener('change', toggleFields);
    productSelect.addEventListener('change', checkNego);
    quantityInput.addEventListener('input', checkNego);
    contactPref.addEventListener('change', toggleContactField);

    toggleFields();
    toggleContactField();
    </script>

</body>
</html>