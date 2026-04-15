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
                    <div class="form-group row">
                        <label for="level_id" class="col-sm-3 col-form-label">Pilih Level User</label>
                        <div class="col-sm-9">
                            <select name="level_id" class="form-control" id="level_id">
                                <option value=""></option>
                                <option value="1">Superadmin</option>
                                <option value="2">Admin Bapenda</option>
                                <option value="6">Pengolah Data Bapenda</option>
                                <option value="3">Admin OPD</option>
                                <option value="4">Admin Balai/UPT/UPPD</option>
                                <option value="5">user</option>
                               
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        
                <div class="col-md-8 col-lg-8">
                    <ul>
                        @foreach ($menus as $menu)
                            @include('akses.partials_menu', ['menu' => $menu, 'userMenuIds' => []])
                        @endforeach
                    </ul>
                </div>
                
            </div>
        </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
