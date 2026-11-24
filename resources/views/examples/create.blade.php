@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')
    <div class="page-heading compact-heading"><div><div class="breadcrumb"><a href="{{ route('example.index') }}">Data Inventaris</a> / <strong>Tambah Barang</strong></div><h1>Tambah Barang</h1><p>Lengkapi informasi barang yang akan dicatat ke inventaris.</p></div></div>
    <section class="panel form-panel">
        <div class="panel-heading"><div><h2>Informasi Barang</h2><p>Kolom bertanda <span class="required-mark">*</span> wajib diisi.</p></div><span class="step-label">FORM INPUT</span></div>
        <form method="POST" action="{{ route('example.store') }}">
            @csrf
            @include('examples._form')
            <div class="form-actions"><a class="btn btn-ghost" href="{{ route('example.index') }}">Batal</a><button class="btn btn-primary" type="submit">Simpan Barang <span>→</span></button></div>
        </form>
    </section>
@endsection
