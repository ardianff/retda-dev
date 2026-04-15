<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-xl" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                    </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 col-lg-8">
@if ($isSpecialLevel)
    
                    <div class="form-group row mb-2">
                        <label for="kelompok" class="col-lg-3 col-lg-offset-1 control-label">Kelompok</label>
                        <div class="col-lg-3">
                            <div class="icheck-primary ">
                                <input type="radio" id="Bapenda" name="kelompok" class="form-control" value="bapenda">
                                <label for="Bapenda">
                                  Bidang Retribusi Lantai 5
                                </label>
                              </div>
                            <div class="icheck-primary ">
                                <input type="radio" id="non-bapenda" name="kelompok" class="form-control" value="non-bapenda" checked>
                                <label for="non-bapenda">
                                  Selain Bidang Retribusi Lantai 5
                                </label>
                              </div>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="col-lg-3">
                            <div class="icheck-primary ">
                                <input type="radio" id="Full-Akses" name="akses" class="form-control" value="Full-Akses" checked>
                                <label for="Full-Akses">
                                  Full Akses
                                </label>
                              </div>
                            <div class="icheck-primary ">
                                <input type="radio" id="Read-Only" name="akses" class="form-control" value="Read-Only">
                                <label for="Read-Only">
                                 Read Only
                                </label>
                              </div>
                            <span class="help-block with-errors"></span>
                        </div>

                    </div>
                    @endif
                    <div class="form-group row mb-2">
                        <label for="level" class="col-lg-4  control-label">Level</label>
                        <div class="col-lg-6">
                           <select name="level" id="level" class="form-control">
                            @foreach ($showlevel as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                           </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                 <div class="form-group row" id="opd-group">
    <label class="col-md-4">Pilih OPD</label>
    <div class="col-md-6">
        <select id="opd" class="form-control" name="opd_id">
            <option value="">-- Pilih OPD --</option>
            @foreach ($opd as $item)
                <option value="{{$item->id}}">{{$item->opd}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row" id="balai-group">
    <label class="col-md-4">Pilih UPPD/BALAI/SATKER</label>
    <div class="col-md-6">
        <select id="balai" class="form-control" name="uppd_id">
            <option value="">-- Pilih UPPD --</option>
            @foreach ($uppd as $item)
                <option value="{{$item->id}}">{{$item->nama}}</option>
            @endforeach
        </select>
    </div>
</div>
 
                    
                    <div class="form-group row mb-2">
                        <label for="name" class="col-lg-4 col-lg-offset-1 control-label">Nama</label>
                        <div class="col-lg-6">
                            <input type="text" name="name" id="name" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label for="username" class="col-lg-4 col-lg-offset-1 control-label">username</label>
                        <div class="col-lg-6">
                            <input type="text" name="username" id="username" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="password" class="col-lg-4 col-lg-offset-1 control-label">Password</label>
                        <div class="col-lg-6">
                            <input type="password" name="password" id="password" class="form-control"
                            >
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="password_confirmation" class="col-lg-4 col-lg-offset-1 control-label">Konfirmasi Password</label>
                        <div class="col-lg-6">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                                
                                data-match="#password">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-4 col-lg-4">
                    <ul>
                        @foreach ($menus as $menu)
                            @include('user.partials_menu', ['menu' => $menu, 'userMenuIds' => []])
                        @endforeach
                    </ul>
                </div> --}}
                
            </div>
        </div>
                <div class="modal-footer">
                    <button type="submit" id="simpan" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
