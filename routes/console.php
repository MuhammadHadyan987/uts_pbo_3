<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('about:project', function () {
    $this->comment('Aplikasi Inventaris Laboratorium - UTS PBO');
})->purpose('Menampilkan identitas singkat proyek');
