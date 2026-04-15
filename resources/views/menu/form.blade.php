<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal" >
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>

                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="h_menu" class="col-sm-3 col-form-label">Menu utama</label>
                        <div class="col-sm-9">
                            <select name="parent_id" class="form-control">
                                <option value=""></option>
                                @foreach($parentMenus as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->menu }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="menu" class="col-sm-3 col-form-label">Menu</label>
                        <div class="col-sm-9">
                            <input type="text" name="menu" id="menu" class="form-control" required >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="route" class="col-sm-3 col-form-label">route</label>
                        <div class="col-sm-9">
                            <input type="text" name="route" id="route" class="form-control"  >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="urutan" class="col-sm-3 col-form-label">urutan</label>
                        <div class="col-sm-9">
                            <input type="text" name="urutan" id="urutan" class="form-control" required >
                        </div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-flat btn-success"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm  btn-secondary"
                    data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

