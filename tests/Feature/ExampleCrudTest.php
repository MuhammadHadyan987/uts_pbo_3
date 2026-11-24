<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleCrudTest extends TestCase
{
    public function test_index_displays_inventory_list(): void
    {
        $response = $this->get(route('example.index'));

        $response->assertOk();
        $response->assertSee('Data Inventaris');
        $response->assertSee('INV-001');
    }

    public function test_user_can_create_inventory_item(): void
    {
        $response = $this->post(route('example.store'), [
            'kode' => 'INV-TEST',
            'nama' => 'Scanner Dokumen',
            'kategori' => 'Elektronik',
            'lokasi' => 'Ruang Administrasi',
            'jumlah' => 3,
            'kondisi' => 'Baik',
            'deskripsi' => 'Barang untuk pengujian fitur tambah.',
        ]);

        $response->assertRedirect(route('example.index'));
        $response->assertSessionHas('success');
        $response->assertSessionHas('inventaris_lab', function (array $items): bool {
            return collect($items)->contains(fn (array $item): bool => $item['kode'] === 'INV-TEST');
        });
    }

    public function test_duplicate_code_is_rejected(): void
    {
        $response = $this->from(route('example.create'))->post(route('example.store'), [
            'kode' => 'INV-001',
            'nama' => 'Barang Duplikat',
            'kategori' => 'Elektronik',
            'lokasi' => 'Gudang',
            'jumlah' => 1,
            'kondisi' => 'Baik',
        ]);

        $response->assertRedirect(route('example.create'));
        $response->assertSessionHasErrors('kode');
    }


    public function test_user_can_open_detail_and_edit_pages(): void
    {
        $this->get(route('example.show', 'INV-001'))
            ->assertOk()
            ->assertSee('Mikroskop Digital');

        $this->get(route('example.edit', 'INV-001'))
            ->assertOk()
            ->assertSee('Edit Barang');
    }

    public function test_user_can_update_inventory_item(): void
    {
        $response = $this->put(route('example.update', 'INV-001'), [
            'nama' => 'Mikroskop Digital Revisi',
            'kategori' => 'Alat Laboratorium',
            'lokasi' => 'Lab Biologi',
            'jumlah' => 6,
            'kondisi' => 'Baik',
            'deskripsi' => 'Jumlah telah diperbarui untuk pengujian.',
        ]);

        $response->assertRedirect(route('example.index'));
        $response->assertSessionHas('success');
        $response->assertSessionHas('inventaris_lab', function (array $items): bool {
            foreach ($items as $item) {
                if ($item['kode'] === 'INV-001') {
                    return $item['nama'] === 'Mikroskop Digital Revisi' && $item['jumlah'] === 6;
                }
            }
            return false;
        });
    }

    public function test_user_can_delete_inventory_item(): void
    {
        $response = $this->delete(route('example.destroy', 'INV-001'));

        $response->assertRedirect(route('example.index'));
        $response->assertSessionHas('success');
        $response->assertSessionHas('inventaris_lab', function (array $items): bool {
            return ! collect($items)->contains(fn (array $item): bool => $item['kode'] === 'INV-001');
        });
    }

    public function test_nonexistent_inventory_returns_404(): void
    {
        $this->get(route('example.show', 'KODE-TIDAK-ADA'))->assertNotFound();
    }
}
