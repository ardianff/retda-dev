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
                        <label for="uraian" class="col-sm-3 col-form-label">Uraian </label>
                        <div class="col-sm-9">
                            <input type="text" name="uraian" id="uraian" class="form-control" required autofocus>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="ket" class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-9">
                            <input type="text" name="ket" id="ket" class="form-control" >
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="kode" class="col-sm-3 col-form-label">kode </label>
                        <div class="col-sm-9">
                            <input type="text" name="kode" id="kode" class="form-control"  autofocus>
                            <small>Tidak wajib diisi</small>
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

