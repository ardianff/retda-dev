@extends('template.master')
@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="#!">Profile</a> </li>

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header text-white" style="background: url('../dist/img/photo1.png') center center;">
              <h3 class="widget-user-username text-right">Elizabeth Pierce</h3>
              <h5 class="widget-user-desc text-right">Web Designer</h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle" src="../dist/img/user3-128x128.jpg" alt="User Avatar">
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
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-header position-relative min-vh-25 mb-7">
              <div class="bg-holder rounded-3 rounded-bottom-0" style="background-image:url({{asset('falcon/assets/img/generic/4.jpg')}});"></div><!--/.bg-holder-->
              <div class="avatar avatar-5xl avatar-profile"><img class="rounded-circle img-thumbnail shadow-sm" src="{{ url($profil->foto ?? '/') }}" width="200" alt="" /></div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-8">
                  <h4 class="mb-1"> {{$profil->name}}<span data-bs-toggle="tooltip" data-bs-placement="right" title="Verified"><small class="fa fa-check-circle text-primary" data-fa-transform="shrink-4 down-2"></small></span></h4>
                </div>
<div class="col-lg-4">
<a href="{{URL::previous()}}" class="btn btn-primary" id="kembali">Kembali <span class="far fa-arrow-alt-circle-left "></span></a>
</div>

              </div>

              <div class="row g-0">
                  <form action="{{ route('update_profile') }}" method="post" class="row g-3" data-toggle="validator" enctype="multipart/form-data">
                      @csrf
                <div class="col-lg-8 pe-lg-2">

                        <div class="card mb-3">

                    <div class="card-body bg-body-tertiary">
                        <div class="row">

                            <div class="col-lg-6">
                                <label class="form-label" for="name">nama</label>
                                <input type="text" name="name" class="form-control" id="name" required autofocus value="{{ $profil->name }}">
                                <span class="help-block with-errors"></span>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" id="email" name="email" type="text" required autofocus value="{{ $profil->email }}"/>
                            </div>
                        </div>
                <div class="col-lg-6">
                    <label class="form-label" for="name">Username</label>
                    <input type="text" name="username" class="form-control" id="username" required autofocus value="{{ $profil->username }}">
                    <span class="help-block with-errors"></span>
                    {{-- <label class="form-label" for="admin">Level</label>
                    <select name="admin" id="admin" class="form-control" required>
                        <option value="Owner" {{ $profil->admin == "Owner" ? 'selected' : '' }}>Owner</option>
                        <option value="Superadmin" {{ $profil->admin == "Superadmin" ? 'selected' : '' }}>Superadmin</option>
                        <option value="Admin" {{ $profil->admin == "Admin" ? 'selected' : '' }}>Admin</option>
                    </select> --}}
                </div>
                        <div class="col-lg-12">
                            <label class="form-label" for="old_password">Password Lama</label>
                            <input class="form-control" id="old_password" name="old_password" type="password"  />
                        </div>
                        <div class="row">

                            <div class="col-lg-6">
                                <label class="form-label" for="password">Password Baru</label>
                                <input class="form-control" id="password" name="password" type="password"  />
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label" for="password_confirmation">Confirm Password Baru</label>
                            <input class="form-control" id="password_confirmation" name="password_confirmation" type="password"  />
                        </div>
                    </div>

                    </div>
                </div>

                </div>
                <div class="col-lg-4 ps-lg-2">



                    <div class="card mb-3">

                      <div class="card-body bg-body-tertiary">
                          <div class="mb-3">
                            <label class="form-label" for="old-password">Change Photo Profile</label>
                                <input type="file" name="foto" class="form-control" id="foto"
                                    onchange="preview('.tampil-foto', this.files[0])">
                                <span class="help-block with-errors"></span>
                                <br>
                                <div class="tampil-foto">
                                    <img src="{{ url($profil->foto ?? '/') }}" width="200">
                                </div>
                        </div>

                      </div>

                  </div>
                </div>
                <div class="col-12 d-flex justify-content-end"><button class="btn btn-primary" type="submit">Update </button></div>
            </form>
              </div>
            </div>
          </div>



    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#old_password').on('keyup', function () {
            if ($(this).val() != "") $('#password, #password_confirmation').attr('required', true);
            else $('#password, #password_confirmation').attr('required', false);
        });

        $('.form-profil').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.ajax({
                    url: $('.form-profil').attr('action'),
                    type: $('.form-profil').attr('method'),
                    data: new FormData($('.form-profil')[0]),
                    async: false,
                    processData: false,
                    contentType: false
                })
                .done(response => {
                    $('[name=name]').val(response.name);
                    $('.tampil-foto').html(`<img src="{{ url('/') }}${response.foto}" width="200">`);
                    $('.img-profil').attr('src', `{{ url('/') }}/${response.foto}`);

                    $('.alert').fadeIn();
                    setTimeout(() => {
                        $('.alert').fadeOut();
                    }, 3000);
                })
                .fail(errors => {
                    if (errors.status == 422) {
                        alert(errors.responseJSON);
                    } else {
                        alert('Tidak dapat menyimpan data');
                    }
                    return;
                });
            }
        });
    });
</script>
@endpush
