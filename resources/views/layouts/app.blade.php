<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Inventaris Laboratorium') - Inventaris Lab</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar">
            <a class="brand" href="{{ route('example.index') }}">
                <span class="brand-mark">IL</span>
                <span><strong>INVENTARIS</strong><small>LABORATORIUM</small></span>
            </a>
            <div class="side-label">MENU UTAMA</div>
            <a class="nav-link {{ request()->routeIs('example.index') ? 'active' : '' }}" href="{{ route('example.index') }}">
                <span class="nav-icon">▦</span> Data Inventaris
            </a>
            <a class="nav-link {{ request()->routeIs('example.create') ? 'active' : '' }}" href="{{ route('example.create') }}">
                <span class="nav-icon">＋</span> Tambah Barang
            </a>
            <div class="sidebar-note">
                <span class="note-dot"></span>
                <div><strong>Data Inventaris</strong><small>Data disimpan pada session</small></div>
            </div>
        </aside>

        <main class="main-area">
            <header class="topbar">
                <div><span class="eyebrow">SISTEM INFORMASI</span><strong>Pengelolaan Inventaris</strong></div>
                <div class="profile"><span class="profile-avatar">A</span><span><strong>Administrator</strong><small>Pengelola Lab</small></span></div>
            </header>

            <section class="page-content">
                @if (session('success'))
                    <div class="alert alert-success"><span>✓</span>{{ session('success') }}</div>
                @endif
                @if (session('info'))
                    <div class="alert alert-info"><span>i</span>{{ session('info') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-error"><span>!</span><div><strong>Periksa kembali data yang dimasukkan.</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>
                @endif

                @yield('content')
            </section>

            <footer class="footer">© {{ date('Y') }} Inventaris Laboratorium <span>UTS Pemrograman Berorientasi Objek</span></footer>
        </main>
    </div>
</body>
</html>
