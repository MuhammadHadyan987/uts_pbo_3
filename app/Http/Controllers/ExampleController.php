<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExampleController extends Controller
{
    private const SESSION_KEY = 'inventaris_lab';

    /**
     * Data awal hanya dipakai saat session pengguna belum memiliki data inventaris.
     * Seluruh perubahan berikutnya disimpan pada session, bukan database.
     */
    private const SAMPLE_DATA = [
        [
            'kode' => 'INV-001',
            'nama' => 'Mikroskop Digital',
            'kategori' => 'Alat Laboratorium',
            'lokasi' => 'Lab Biologi',
            'jumlah' => 5,
            'kondisi' => 'Baik',
            'deskripsi' => 'Mikroskop digital untuk pengamatan preparat praktikum.',
        ],
        [
            'kode' => 'INV-002',
            'nama' => 'Laptop Praktikum',
            'kategori' => 'Elektronik',
            'lokasi' => 'Lab Komputer 1',
            'jumlah' => 18,
            'kondisi' => 'Baik',
            'deskripsi' => 'Laptop yang digunakan untuk kegiatan praktikum pemrograman.',
        ],
        [
            'kode' => 'INV-003',
            'nama' => 'Proyektor Epson',
            'kategori' => 'Elektronik',
            'lokasi' => 'Ruang Seminar',
            'jumlah' => 2,
            'kondisi' => 'Perlu Perbaikan',
            'deskripsi' => 'Salah satu unit membutuhkan pemeriksaan pada konektor HDMI.',
        ],
        [
            'kode' => 'INV-004',
            'nama' => 'Kursi Laboratorium',
            'kategori' => 'Furnitur',
            'lokasi' => 'Lab Komputer 1',
            'jumlah' => 30,
            'kondisi' => 'Baik',
            'deskripsi' => 'Kursi untuk peserta praktikum.',
        ],
    ];

    /** Menampilkan seluruh inventaris dan menyediakan pencarian sederhana. */
    public function index(Request $request): View
    {
        $items = $this->allItems();
        $keyword = trim((string) $request->query('q', ''));

        $examples = array_values(array_filter($items, function (array $item) use ($keyword): bool {
            if ($keyword === '') {
                return true;
            }

            $searchable = implode(' ', [
                $item['kode'],
                $item['nama'],
                $item['kategori'],
                $item['lokasi'],
                $item['kondisi'],
            ]);

            return str_contains(strtolower($searchable), strtolower($keyword));
        }));

        return view('examples.index', [
            'examples' => $examples,
            'keyword' => $keyword,
            'totalItems' => count($items),
            'totalUnits' => array_sum(array_column($items, 'jumlah')),
            'needsAttention' => count(array_filter($items, fn (array $item): bool => $item['kondisi'] !== 'Baik')),
        ]);
    }

    /** Menampilkan form penambahan data inventaris. */
    public function create(): View
    {
        return view('examples.create');
    }

    /** Memvalidasi dan menyimpan data baru ke dalam session. */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $items = $this->allItems();

        $duplicate = collect($items)->contains(fn (array $item): bool => strtoupper($item['kode']) === strtoupper($validated['kode']));
        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors(['kode' => 'Kode inventaris sudah digunakan. Gunakan kode yang berbeda.']);
        }

        $validated['kode'] = strtoupper($validated['kode']);
        $validated['jumlah'] = (int) $validated['jumlah'];
        $items[] = $validated;
        session()->put(self::SESSION_KEY, $items);

        return redirect()->route('example.index')->with('success', 'Data inventaris berhasil ditambahkan.');
    }

    /** Menampilkan detail satu barang berdasarkan kode inventaris. */
    public function show(string $kode): View
    {
        return view('examples.show', ['example' => $this->findItem($kode)]);
    }

    /** Menampilkan form edit dengan nilai awal dari session. */
    public function edit(string $kode): View
    {
        return view('examples.edit', ['example' => $this->findItem($kode)]);
    }

    /** Memperbarui data inventaris yang cocok dengan kode pada URI. */
    public function update(Request $request, string $kode): RedirectResponse
    {
        $validated = $request->validate($this->rules(includeCode: false));
        $items = $this->allItems();
        $position = $this->findPosition($items, $kode);

        if ($position === null) {
            abort(404, 'Data inventaris tidak ditemukan.');
        }

        $items[$position] = array_merge($items[$position], $validated, [
            'jumlah' => (int) $validated['jumlah'],
        ]);
        session()->put(self::SESSION_KEY, $items);

        return redirect()->route('example.index')->with('success', 'Data inventaris berhasil diperbarui.');
    }

    /** Menghapus data inventaris berdasarkan kode. */
    public function destroy(string $kode): RedirectResponse
    {
        $items = $this->allItems();
        $position = $this->findPosition($items, $kode);

        if ($position === null) {
            return redirect()->route('example.index')->with('info', 'Data yang akan dihapus tidak ditemukan.');
        }

        unset($items[$position]);
        session()->put(self::SESSION_KEY, array_values($items));

        return redirect()->route('example.index')->with('success', 'Data inventaris berhasil dihapus.');
    }

    /** Mengambil data session; data contoh diinisialisasi satu kali per session. */
    private function allItems(): array
    {
        if (! session()->has(self::SESSION_KEY)) {
            session()->put(self::SESSION_KEY, self::SAMPLE_DATA);
        }

        return session()->get(self::SESSION_KEY, []);
    }

    /** Mencari satu data atau menghentikan request dengan HTTP 404. */
    private function findItem(string $kode): array
    {
        $items = $this->allItems();
        $position = $this->findPosition($items, $kode);

        if ($position === null) {
            abort(404, 'Data inventaris dengan kode tersebut tidak ditemukan.');
        }

        return $items[$position];
    }

    /** Mendapatkan posisi array berdasarkan kode tanpa mengubah kode yang tersimpan. */
    private function findPosition(array $items, string $kode): ?int
    {
        foreach ($items as $position => $item) {
            if (strcasecmp($item['kode'], $kode) === 0) {
                return $position;
            }
        }

        return null;
    }

    /** Aturan validasi untuk data inventaris. */
    private function rules(bool $includeCode = true): array
    {
        $rules = [
            'nama' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'max:60'],
            'lokasi' => ['required', 'string', 'max:80'],
            'jumlah' => ['required', 'integer', 'min:0', 'max:100000'],
            'kondisi' => ['required', 'in:Baik,Perlu Perbaikan,Rusak'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ];

        if ($includeCode) {
            $rules['kode'] = ['required', 'string', 'max:20', 'regex:/^[A-Za-z0-9-]+$/'];
        }

        return $rules;
    }
}
