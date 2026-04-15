@extends('template.master')
@section('title', 'Profile | E-Tarif RETDA')

@section('breadcumb')
<li class="breadcrumb-item"><a href="{{ route('profile') }}">Profile</a></li>
@endsection

@section('content')
<div class="card card-widget widget-user">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header text-white" style="background: url('{{asset('admin/dist/img/user2-160x160.jpg')}}') center center;">
      <h3 class="widget-user-username text-right">Elizabeth Pierce</h3>
      <h5 class="widget-user-desc text-right">Web Designer</h5>
    </div>
    <div class="widget-user-image">
      <img class="img-circle" src="{{asset('admin/dist/img/user2-160x160.jpg')}}" alt="User Avatar">
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-sm-4 border-right">
          <div class="description-block">
            <h5 class="description-header">3,200</h5>
            <span class="description-text">SALES</span>
          </div>
          <!-- /.description-block -->
        </div>
        <!-- /.col -->
        <div class="col-sm-4 border-right">
          <div class="description-block">
            <h5 class="description-header">13,000</h5>
            <span class="description-text">FOLLOWERS</span>
          </div>
          <!-- /.description-block -->
        </div>
        <!-- /.col -->
        <div class="col-sm-4">
          <div class="description-block">
            <h5 class="description-header">35</h5>
            <span class="description-text">PRODUCTS</span>
          </div>
          <!-- /.description-block -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
  </div>
<div class="container mt-5">
    @if (session('message'))
        <div class="alert alert-{{ session('message.type') ?? 'success' }} alert-dismissible fade show" role="alert">
            {{ session('message.text') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-lg rounded-4 overflow-hidden">
        {{-- Header with background --}}
        <div class="position-relative" style="height: 200px; background: url('{{ asset('img/header.jpg') }}') center center / cover no-repeat;">
            {{-- Foto Profil --}}
            <div class="position-absolute top-100 start-50 translate-middle-y" style="transform: translateX(-50%) translateY(-50%); z-index: 2;">

                <div class="rounded-circle border border-white shadow" style="width: 120px; height: 120px; overflow: hidden;">
                    <img id="preview" src="{{asset('admin/dist/img/user2-160x160.jpg')}}" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                </div>
            
                {{-- Upload Button --}}
                <label class="btn btn-sm btn-primary rounded-circle position-absolute bottom-0 end-0" style="width: 35px; height: 35px; padding: 0;">
                    <i class="fa fa-camera" style="font-size: 14px;"></i>
                    <input type="file" name="foto" class="d-none" onchange="previewImage(event)">
                </label>
            </div>
            
        </div>

        {{-- Form --}}
        <form action="{{ route('update_profile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body mt-5 pt-5">
                {{-- Username --}}
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username', auth()->user()->username) }}" required>
                    @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Nama --}}
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', auth()->user()->name) }}" required>
                    @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru 
                        <small class="text-muted">(Kosongkan jika tidak ingin diubah)</small>
                    </label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control">
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                            <i class="fa fa-eye-slash"></i>
                        </button>
                    </div>
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation">
                            <i class="fa fa-eye-slash"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="card-footer bg-white text-end">
                <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const img = document.getElementById('preview');
        img.src = URL.createObjectURL(event.target.files[0]);
    }

    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    });
</script>
@endpush
