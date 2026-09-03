<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - TRX Atribut</title>
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
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: var(--near-black);
            display: flex; align-items: center; justify-content: center;
            height: 100vh; margin: 0;
        }
        .login-box {
            background: var(--surface);
            padding: 32px;
            border-radius: 8px;
            width: 320px;
            border-top: 4px solid var(--blue);
        }
        h1 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 22px; font-weight: 700; margin: 0 0 4px;
            color: var(--near-black);
        }
        .subtitle { font-size: 13px; color: var(--text-muted); margin-bottom: 20px; }
        label { display: block; font-weight: 600; font-size: 14px; color: var(--near-black); }
        input {
            width: 100%; padding: 10px; margin-top: 6px;
            border: 1px solid var(--border); border-radius: 5px; font-size: 14px;
        }
        input:focus {
            outline: none; border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(43, 143, 199, 0.15);
        }
        button {
            margin-top: 18px; width: 100%; padding: 11px;
            background: var(--blue); color: #fff; border: none;
            border-radius: 5px; cursor: pointer; font-size: 14px; font-weight: 600;
        }
        button:hover { background: var(--blue-dark); }
        .error { color: var(--error-text); font-size: 13px; margin-top: 6px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Login Admin</h1>
        <p class="subtitle">TRX Atribut - Kelola Produk</p>
        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <label>Password</label>
            <input type="password" name="password" autofocus>
            @error('password') <div class="error">{{ $message }}</div> @enderror
            <button type="submit">Masuk</button>
        </form>
    </div>
</body>
</html>