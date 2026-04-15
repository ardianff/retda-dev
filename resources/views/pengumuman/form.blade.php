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
                        <label for="judul" class="col-sm-3 col-form-label">judul</label>
                        <div class="col-sm-9">
                            <input type="text" name="judul" id="judul" class="form-control" required autofocus>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="deskripsi" class="col-sm-3 col-form-label">deskripsi </label>
                        <div class="col-sm-9">
                            <textarea name="deskripsi" id="deskripsi" cols="60" rows="5"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="link" class="col-sm-3 col-form-label">link </label>
                        <div class="col-sm-9">
                            <input type="text" name="link" id="link" class="form-control" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tgl_awal" class="col-sm-3 col-form-label">Tgl Awal</label>
                        <div class="col-sm-9">
                            <div class="input-group date" id="tgl_awal" data-target-input="nearest">
                                <div class="input-group-append" data-target="#tgl_awal" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <input type="text" class="form-control datetimepicker-input" data-target="#tgl_awal" name="tgl_awal"/>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tgl_akhir" class="col-sm-3 col-form-label">Tgl Akhir</label>
                        <div class="col-sm-9">
                            <div class="input-group date" id="tgl_akhir" data-target-input="nearest">
                                <div class="input-group-append" data-target="#tgl_akhir" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <input type="text" class="form-control datetimepicker-input" data-target="#tgl_akhir" name="tgl_akhir"/>
                            </div>
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

