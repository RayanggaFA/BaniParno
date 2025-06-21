@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Anggota Keluarga</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Oops!</strong> Ada kesalahan input.<br><br>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Foto Profil</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                        <small class="text-muted">JPG, JPEG, PNG, GIF. Maks 2MB.</small>
                        <div id="photo-preview" class="mt-2" style="display: none;">
                            <img id="preview-image" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tempat Lahir</label>
                        <input type="text" name="birth_place" class="form-control" value="{{ old('birth_place') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Pekerjaan</label>
                        <input type="text" name="job" class="form-control" value="{{ old('job') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>No. Telepon</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Jenis Kelamin</label>
                        <select name="gender" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="deceased" {{ old('status') == 'deceased' ? 'selected' : '' }}>Meninggal</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Generasi</label>
                        <select name="generation" class="form-control" required>
                            <option value="">-- Pilih Generasi --</option>
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('generation') == $i ? 'selected' : '' }}>Generasi {{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Keluarga</label>
                        <select name="family_id" class="form-control" required>
                            <option value="">-- Pilih Keluarga --</option>
                            @foreach ($families as $family)
                                <option value="{{ $family->id }}" {{ old('family_id') == $family->id ? 'selected' : '' }}>{{ $family->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Orang Tua (Jika Ada)</label>
                        <select name="parent_id" class="form-control">
                            <option value="">-- Tidak Ada --</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}" {{ old('parent_id') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Kota Domisili</label>
                        <input type="text" name="domicile_city" class="form-control" value="{{ old('domicile_city') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Provinsi Domisili</label>
                        <input type="text" name="domicile_province" class="form-control" value="{{ old('domicile_province') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Alamat KTP</label>
                        <textarea name="address_ktp" class="form-control" rows="2" required>{{ old('address_ktp') }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Alamat Sekarang</label>
                        <textarea name="current_address" class="form-control" rows="2" required>{{ old('current_address') }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Catatan</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <input type="hidden" name="changed_by" value="Admin">

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('members.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Preview Foto Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const photoInput = document.querySelector('input[name="photo"]');
        const previewDiv = document.getElementById('photo-preview');
        const previewImage = document.getElementById('preview-image');

        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    this.value = '';
                    previewDiv.style.display = 'none';
                    return;
                }

                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file tidak didukung.');
                    this.value = '';
                    previewDiv.style.display = 'none';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewDiv.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewDiv.style.display = 'none';
            }
        });
    });
</script>
@endsection
