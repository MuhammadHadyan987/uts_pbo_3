@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
    <div class="page-heading compact-heading"><div><div class="breadcrumb"><a href="{{ route('example.index') }}">Data Inventaris</a> / <a href="{{ route('example.show', $example['kode']) }}">Detail Barang</a> / <strong>Edit</strong></div><h1>Edit Barang</h1><p>Perbarui informasi barang <strong>{{ $example['nama'] }}</strong>.</p></div></div>
    <section class="panel form-panel">
        <div class="panel-heading"><div><h2>Perbarui Informasi</h2><p>Nilai saat ini ditampilkan sebagai nilai awal form.</p></div><span class="step-label">FORM EDIT</span></div>
        <form method="POST" action="{{ route('example.update', $example['kode']) }}">
            @csrf
            @method('PUT')
            @include('examples._form')
            <div class="form-actions"><a class="btn btn-ghost" href="{{ route('example.show', $example['kode']) }}">Batal</a><button class="btn btn-primary" type="submit">Simpan Perubahan <span>→</span></button></div>
        </form>
    </section>
@endsection
