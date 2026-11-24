@extends('layouts.app')

@section('title', 'Detail Barang')

@section('content')
    <div class="page-heading compact-heading"><div><div class="breadcrumb"><a href="{{ route('example.index') }}">Data Inventaris</a> / <strong>Detail Barang</strong></div><h1>Detail Barang</h1><p>Informasi lengkap mengenai satu item inventaris.</p></div><div class="heading-actions"><a class="btn btn-light" href="{{ route('example.index') }}">← Kembali</a><a class="btn btn-primary" href="{{ route('example.edit', $example['kode']) }}">Edit Barang</a></div></div>
    <section class="panel detail-panel">
        <div class="detail-hero"><div class="detail-symbol">▦</div><div><span class="code-pill">{{ $example['kode'] }}</span><h2>{{ $example['nama'] }}</h2><p>{{ $example['kategori'] }}</p></div><span class="status status-{{ $example['kondisi'] === 'Baik' ? 'good' : ($example['kondisi'] === 'Rusak' ? 'bad' : 'warning') }}">{{ $example['kondisi'] }}</span></div>
        <div class="detail-grid">
            <div class="detail-item"><span>Lokasi Penyimpanan</span><strong>{{ $example['lokasi'] }}</strong></div>
            <div class="detail-item"><span>Jumlah Tercatat</span><strong>{{ number_format($example['jumlah'], 0, ',', '.') }} unit</strong></div>
            <div class="detail-item"><span>Kode Inventaris</span><strong>{{ $example['kode'] }}</strong></div>
            <div class="detail-item"><span>Kategori Barang</span><strong>{{ $example['kategori'] }}</strong></div>
            <div class="detail-item full-width"><span>Keterangan Tambahan</span><p>{{ $example['deskripsi'] ?: 'Tidak ada keterangan tambahan.' }}</p></div>
        </div>
        <div class="detail-actions"><a class="btn btn-ghost" href="{{ route('example.index') }}">Kembali ke Daftar</a><a class="btn btn-primary" href="{{ route('example.edit', $example['kode']) }}">Edit Informasi</a><form method="POST" action="{{ route('example.destroy', $example['kode']) }}" onsubmit="return confirm('Yakin ingin menghapus data ini?')">@csrf @method('DELETE')<button class="btn btn-danger" type="submit">Hapus Barang</button></form></div>
    </section>
@endsection
