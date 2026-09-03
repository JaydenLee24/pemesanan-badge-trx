<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Produk - Admin TRX Atribut</title>
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
            --success-bg: #DCF2E3;
            --success-text: #155724;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', Arial, sans-serif;
            margin: 0; background: var(--bg); color: var(--text);
        }
        h1 {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700; font-size: 22px; margin: 0;
        }
        .topbar {
            background: var(--near-black); color: #fff;
            padding: 16px 24px; display: flex;
            justify-content: space-between; align-items: center;
        }
        .topbar .wordmark strong { font-family: 'Barlow Condensed', sans-serif; font-size: 18px; }
        .topbar .wordmark span { font-size: 12px; color: #9FB3C4; display: block; }
        .container { max-width: 1100px; margin: 0 auto; padding: 28px 20px 60px; }
        .action-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
        .btn {
            display: inline-block; padding: 9px 16px; border-radius: 5px;
            text-decoration: none; font-size: 14px; font-weight: 600; border: none; cursor: pointer;
        }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-primary:hover { background: var(--blue-dark); }
        .btn-edit { background: #E4EDF3; color: var(--navy); }
        .btn-delete { background: #FBE2E2; color: #8A1F1F; }
        .btn-toggle { background: #E9ECEF; color: var(--text); }
        .btn-logout { background: transparent; color: #fff; border: 1px solid #3A4552; }
        .alert-success { background: var(--success-bg); color: var(--success-text); padding: 12px 14px; border-radius: 6px; margin-bottom: 18px; font-size: 14px; }

        table { width: 100%; border-collapse: collapse; background: var(--surface); border-radius: 8px; overflow: hidden; border: 1px solid var(--border); }
        th, td { padding: 11px 12px; text-align: left; border-bottom: 1px solid var(--border); font-size: 14px; }
        th { background: #E9EDF0; font-weight: 600; color: var(--navy); }
        tr:last-child td { border-bottom: none; }
        .status-active { color: var(--success-text); font-weight: 600; }
        .status-inactive { color: var(--text-muted); }
        .actions { display: flex; gap: 6px; flex-wrap: wrap; }
        form.inline { display: inline; }
    </style>
</head>
<body>

    <div class="topbar">
        <div class="wordmark">
            <strong>TRX ATRIBUT</strong>
            <span>Panel Admin - Kelola Produk</span>
        </div>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-logout">Logout</button>
        </form>
    </div>

    <div class="container">

        <div class="action-bar">
            <h1>Kelola Produk</h1>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Tambah Produk</a>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Ukuran</th>
                    <th>Harga</th>
                    <th>Min. Nego</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category }}</td>
                        <td>{{ $product->size }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->min_qty_nego ?: '-' }}</td>
                        <td>
                            @if ($product->is_active)
                                <span class="status-active">Aktif</span>
                            @else
                                <span class="status-inactive">Nonaktif</span>
                            @endif
                        </td>
                        <td class="actions">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-edit">Edit</a>

                            <form action="{{ route('admin.products.toggle', $product) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-toggle">{{ $product->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                            </form>

                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7">Belum ada produk.</td></tr>
                @endforelse
            </tbody>
        </table>

    </div>
</body>
</html>