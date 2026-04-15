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
                        <label for="no_rek" class="col-sm-3 col-form-label">Rekening </label>
                        <div class="col-sm-9">
                            <input type="text" name="no_rek" id="no_rek" class="form-control" required autofocus>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="ket" class="col-sm-3 col-form-label">Keterangan </label>
                        <div class="col-sm-9">
                            <input type="text" name="ket" id="ket" class="form-control" required autofocus>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="rek_grms" class="col-sm-3 col-form-label">ID GRMS</label>
                        <div class="col-sm-9">
                            <input type="text" name="rek_grms" id="rek_grms" class="form-control" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="grms_id_2025" class="col-sm-3 col-form-label">ID GRMS</label>
                        <div class="col-sm-9">
                            <input type="text" name="grms_id_2025" id="grms_id_2025" class="form-control" >
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

