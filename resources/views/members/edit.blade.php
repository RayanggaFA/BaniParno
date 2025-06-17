@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('content')
<div class="container mt-5">
    <h2>Edit Data Anggota</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('members.update', $member->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">Nama Lengkap</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $member->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="birth_place" class="col-sm-2 col-form-label">Tempat Lahir</label>
            <div class="col-sm-10">
                <input type="text" name="birth_place" class="form-control @error('birth_place') is-invalid @enderror"
                    value="{{ old('birth_place', $member->birth_place) }}">
                @error('birth_place')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="birth_date" class="col-sm-2 col-form-label">Tanggal Lahir</label>
            <div class="col-sm-10">
                <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror"
                    value="{{ old('birth_date', $member->birth_date) }}">
                @error('birth_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="gender" class="col-sm-2 col-form-label">Jenis Kelamin</label>
            <div class="col-sm-10">
                <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                    <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="job" class="col-sm-2 col-form-label">Pekerjaan</label>
            <div class="col-sm-10">
                <input type="text" name="job" class="form-control @error('job') is-invalid @enderror"
                    value="{{ old('job', $member->job) }}">
                @error('job')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="address_ktp" class="col-sm-2 col-form-label">Alamat KTP</label>
            <div class="col-sm-10">
                <textarea name="address_ktp" class="form-control @error('address_ktp') is-invalid @enderror">{{ old('address_ktp', $member->address_ktp) }}</textarea>
                @error('address_ktp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="current_address" class="col-sm-2 col-form-label">Alamat Sekarang</label>
            <div class="col-sm-10">
                <textarea name="current_address" class="form-control @error('current_address') is-invalid @enderror">{{ old('current_address', $member->current_address) }}</textarea>
                @error('current_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="domicile_city" class="col-sm-2 col-form-label">Kota Domisili</label>
            <div class="col-sm-10">
                <input type="text" name="domicile_city" class="form-control @error('domicile_city') is-invalid @enderror"
                    value="{{ old('domicile_city', $member->domicile_city) }}">
                @error('domicile_city')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="domicile_province" class="col-sm-2 col-form-label">Provinsi Domisili</label>
            <div class="col-sm-10">
                <input type="text" name="domicile_province" class="form-control @error('domicile_province') is-invalid @enderror"
                    value="{{ old('domicile_province', $member->domicile_province) }}">
                @error('domicile_province')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="phone" class="col-sm-2 col-form-label">Nomor HP</label>
            <div class="col-sm-10">
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $member->phone) }}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" name="email" class="form-control" value="{{ old('email', $member->email) }}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="status" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                <select name="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ old('status', $member->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="deceased" {{ old('status', $member->status) == 'deceased' ? 'selected' : '' }}>Meninggal</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="family_id" class="col-sm-2 col-form-label">Keluarga</label>
            <div class="col-sm-10">
                <select name="family_id" class="form-select @error('family_id') is-invalid @enderror">
                    @foreach($families as $family)
                        <option value="{{ $family->id }}" {{ old('family_id', $member->family_id) == $family->id ? 'selected' : '' }}>
                            {{ $family->name }}
                        </option>
                    @endforeach
                </select>
                @error('family_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
    <label for="generation_id" class="col-sm-2 col-form-label">Generasi</label>
    <div class="col-sm-10">
        <select name="generation_id" class="form-select @error('generation_id') is-invalid @enderror">
            <option value="">-- Pilih Generasi --</option>
            @foreach($generations as $generation)
                <option value="{{ $generation->id }}" {{ old('generation_id', $member->generation_id) == $generation->id ? 'selected' : '' }}>
                    {{ $generation->name }}
                </option>
            @endforeach
        </select>
        @error('generation_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>


        <div class="row mb-3">
            <label for="notes" class="col-sm-2 col-form-label">Catatan</label>
            <div class="col-sm-10">
                <textarea name="notes" class="form-control">{{ old('notes', $member->notes) }}</textarea>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('members.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
