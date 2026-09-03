<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->exists ? 'Edit' : 'Tambah' }} Produk - Admin TRX Atribut</title>
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
            --error-text: #8A1F1F;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', Arial, sans-serif; margin: 0; background: var(--bg); color: var(--text); }
        h1 { font-family: 'Barlow Condensed', sans-serif; font-weight: 700; font-size: 22px; margin: 0; }
        .topbar { background: var(--near-black); color: #fff; padding: 16px 24px; }
        .topbar .wordmark strong { font-family: 'Barlow Condensed', sans-serif; font-size: 18px; }
        .topbar .wordmark span { font-size: 12px; color: #9FB3C4; display: block; }
        .container { max-width: 600px; margin: 0 auto; padding: 28px 20px 60px; }
        .back-link { display: inline-block; margin-bottom: 14px; color: var(--blue-dark); text-decoration: none; font-size: 14px; font-weight: 600; }
        .form-box { background: var(--surface); border: 1px solid var(--border); border-radius: 8px; overflow: hidden; margin-top: 14px; }
        .form-header { background: var(--navy); color: #fff; padding: 14px 24px; font-family: 'Barlow Condensed', sans-serif; font-size: 18px; font-weight: 700; }
        .form-body { padding: 24px; }
        label { display: block; margin-top: 16px; font-weight: 600; font-size: 14px; color: var(--near-black); }
        input, select, textarea {
            width: 100%; padding: 9px 10px; margin-top: 5px;
            border: 1px solid var(--border); border-radius: 5px; font-size: 14px;
            font-family: 'Inter', sans-serif; color: var(--text); background: #fff;
        }
        input:focus, select:focus, textarea:focus {
            outline: none; border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(43, 143, 199, 0.15);
        }
        button {
            margin-top: 22px; padding: 11px 24px; background: var(--blue); color: #fff;
            border: none; border-radius: 6px; cursor: pointer; font-size: 15px; font-weight: 600;
        }
        button:hover { background: var(--blue-dark); }
        .error { color: var(--error-text); font-size: 13px; margin-top: 5px; }
        .current-image { max-width: 120px; display: block; margin-top: 8px; border-radius: 6px; border: 1px solid var(--border); }
        .checkbox-row { display: flex; align-items: center; gap: 8px; margin-top: 18px; }
        .checkbox-row input { width: auto; margin: 0; }
        .checkbox-row label { margin: 0; font-weight: 500; }
    </style>
</head>
<body>

    <div class="topbar">
        <div class="wordmark">
            <strong>TRX ATRIBUT</strong>
            <span>Panel Admin - Kelola Produk</span>
        </div>
    </div>

    <div class="container">
        <a href="{{ route('admin.products.index') }}" class="back-link">&larr; Kembali ke daftar produk</a>

        <h1>{{ $product->exists ? 'Edit Produk' : 'Tambah Produk' }}</h1>

        <div class="form-box">
            <div class="form-header">Detail Produk</div>
            <div class="form-body">
                <form action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($product->exists)
                        @method('PUT')
                    @endif

                    <label>Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}">
                    @error('name') <div class="error">{{ $message }}</div> @enderror

                    <label>Kategori</label>
                    <input type="text" name="category" value="{{ old('category', $product->category) }}" placeholder="Polisi, Tentara, Pramuka, dst">
                    @error('category') <div class="error">{{ $message }}</div> @enderror

                    <label>Ukuran</label>
                    <input type="text" name="size" value="{{ old('size', $product->size) }}" placeholder="5cm x 5cm">
                    @error('size') <div class="error">{{ $message }}</div> @enderror

                    <label>Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}">
                    @error('price') <div class="error">{{ $message }}</div> @enderror

                    <label>Minimal Qty untuk Nego (kosongkan/0 kalau tidak berlaku)</label>
                    <input type="number" name="min_qty_nego" value="{{ old('min_qty_nego', $product->min_qty_nego) }}">
                    @error('min_qty_nego') <div class="error">{{ $message }}</div> @enderror

                    <label>Deskripsi (opsional)</label>
                    <textarea name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                    @error('description') <div class="error">{{ $message }}</div> @enderror

                    <label>Foto Produk</label>
                    @if ($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" class="current-image">
                    @endif
                    <input type="file" name="image" accept="image/*">
                    @error('image') <div class="error">{{ $message }}</div> @enderror

                    <div class="checkbox-row">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <label for="is_active">Aktifkan produk (tampil di katalog)</label>
                    </div>

                    <button type="submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>