<div class="form-grid">
    <div class="form-field">
        <label for="kode">Kode Barang <span>*</span></label>
        <input id="kode" name="kode" type="text" value="{{ old('kode', $example['kode'] ?? '') }}" placeholder="Contoh: INV-005" maxlength="20" @if(isset($example)) readonly class="readonly" @endif required>
        @if(isset($example))<small class="helper">Kode menjadi identitas barang dan tidak diubah pada form edit.</small>@else<small class="helper">Gunakan huruf, angka, atau tanda hubung (-).</small>@endif
        @error('kode')<small class="field-error">{{ $message }}</small>@enderror
    </div>
    <div class="form-field">
        <label for="nama">Nama Barang <span>*</span></label>
        <input id="nama" name="nama" type="text" value="{{ old('nama', $example['nama'] ?? '') }}" placeholder="Masukkan nama barang" maxlength="100" required>
        @error('nama')<small class="field-error">{{ $message }}</small>@enderror
    </div>
    <div class="form-field">
        <label for="kategori">Kategori <span>*</span></label>
        <select id="kategori" name="kategori" required>
            <option value="">Pilih kategori</option>
            @foreach (['Elektronik', 'Alat Laboratorium', 'Furnitur', 'Peralatan', 'Lainnya'] as $category)
                <option value="{{ $category }}" @selected(old('kategori', $example['kategori'] ?? '') === $category)>{{ $category }}</option>
            @endforeach
        </select>
        @error('kategori')<small class="field-error">{{ $message }}</small>@enderror
    </div>
    <div class="form-field">
        <label for="lokasi">Lokasi <span>*</span></label>
        <input id="lokasi" name="lokasi" type="text" value="{{ old('lokasi', $example['lokasi'] ?? '') }}" placeholder="Contoh: Lab Komputer 1" maxlength="80" required>
        @error('lokasi')<small class="field-error">{{ $message }}</small>@enderror
    </div>
    <div class="form-field">
        <label for="jumlah">Jumlah Unit <span>*</span></label>
        <input id="jumlah" name="jumlah" type="number" min="0" max="100000" value="{{ old('jumlah', $example['jumlah'] ?? 1) }}" required>
        @error('jumlah')<small class="field-error">{{ $message }}</small>@enderror
    </div>
    <div class="form-field">
        <label for="kondisi">Kondisi <span>*</span></label>
        <select id="kondisi" name="kondisi" required>
            @foreach (['Baik', 'Perlu Perbaikan', 'Rusak'] as $condition)
                <option value="{{ $condition }}" @selected(old('kondisi', $example['kondisi'] ?? 'Baik') === $condition)>{{ $condition }}</option>
            @endforeach
        </select>
        @error('kondisi')<small class="field-error">{{ $message }}</small>@enderror
    </div>
    <div class="form-field full-width">
        <label for="deskripsi">Keterangan Tambahan</label>
        <textarea id="deskripsi" name="deskripsi" rows="4" maxlength="500" placeholder="Tambahkan informasi kondisi atau penggunaan barang (opsional)">{{ old('deskripsi', $example['deskripsi'] ?? '') }}</textarea>
        <small class="helper">Maksimal 500 karakter. Bagian ini bersifat opsional.</small>
        @error('deskripsi')<small class="field-error">{{ $message }}</small>@enderror
    </div>
</div>
