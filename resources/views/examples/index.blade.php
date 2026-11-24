@extends('layouts.app')

@section('title', 'Data Inventaris')

@section('content')
    <div class="page-heading">
        <div><div class="breadcrumb">Beranda / <strong>Data Inventaris</strong></div><h1>Data Inventaris</h1><p>Kelola informasi barang dan fasilitas laboratorium dalam satu halaman.</p></div>
        <a class="btn btn-primary" href="{{ route('example.create') }}"><span>＋</span> Tambah Barang</a>
    </div>

    <div class="stats-grid">
        <article class="stat-card"><div class="stat-icon blue">▦</div><div><span>Total jenis barang</span><strong>{{ $totalItems }}</strong><small>Item inventaris tercatat</small></div></article>
        <article class="stat-card"><div class="stat-icon violet">▤</div><div><span>Total unit barang</span><strong>{{ number_format($totalUnits, 0, ',', '.') }}</strong><small>Akumulasi seluruh jumlah</small></div></article>
        <article class="stat-card"><div class="stat-icon amber">⚑</div><div><span>Perlu perhatian</span><strong>{{ $needsAttention }}</strong><small>Barang tidak dalam kondisi baik</small></div></article>
    </div>

    <section class="panel">
        <div class="panel-heading"><div><h2>Daftar Barang</h2><p>Informasi barang yang tersimpan pada session saat ini.</p></div><span class="counter">{{ count($examples) }} data ditampilkan</span></div>
        <form class="search-form" method="GET" action="{{ route('example.index') }}">
            <div class="search-box"><span>⌕</span><input type="text" name="q" value="{{ $keyword }}" placeholder="Cari kode, nama, kategori, atau lokasi..."></div>
            <button class="btn btn-light" type="submit">Cari Data</button>
            @if ($keyword !== '')<a class="btn btn-ghost" href="{{ route('example.index') }}">Reset</a>@endif
        </form>

        <div class="table-wrap">
            <table>
                <thead><tr><th>KODE</th><th>NAMA BARANG</th><th>KATEGORI</th><th>LOKASI</th><th>JUMLAH</th><th>KONDISI</th><th>AKSI</th></tr></thead>
                <tbody>
                @forelse ($examples as $example)
                    <tr>
                        <td><span class="code-pill">{{ $example['kode'] }}</span></td>
                        <td><strong class="item-name">{{ $example['nama'] }}</strong></td>
                        <td>{{ $example['kategori'] }}</td>
                        <td>{{ $example['lokasi'] }}</td>
                        <td><strong>{{ number_format($example['jumlah'], 0, ',', '.') }}</strong> unit</td>
                        <td><span class="status status-{{ $example['kondisi'] === 'Baik' ? 'good' : ($example['kondisi'] === 'Rusak' ? 'bad' : 'warning') }}">{{ $example['kondisi'] }}</span></td>
                        <td><div class="actions"><a class="action-link" href="{{ route('example.show', $example['kode']) }}" title="Detail">Lihat</a><a class="action-link edit" href="{{ route('example.edit', $example['kode']) }}" title="Edit">Edit</a><form method="POST" action="{{ route('example.destroy', $example['kode']) }}" onsubmit="return confirm('Yakin ingin menghapus {{ $example['nama'] }}?')">@csrf @method('DELETE')<button class="action-link delete" type="submit">Hapus</button></form></div></td>
                    </tr>
                @empty
                    <tr><td colspan="7"><div class="empty-state"><strong>Data tidak ditemukan</strong><span>Coba kata kunci lain atau tambahkan barang baru.</span><a href="{{ route('example.create') }}">Tambah barang sekarang</a></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="table-foot"><span>Menampilkan {{ count($examples) }} dari {{ $totalItems }} jenis barang</span><span>Data contoh tersimpan per session browser</span></div>
    </section>
@endsection
