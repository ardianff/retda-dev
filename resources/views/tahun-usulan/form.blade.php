<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data" >
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>

                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="tahun" class="col-sm-3 col-form-label">tahun</label>
                        <div class="col-sm-9">
                            <input type="text" name="tahun" id="tahun" class="form-control" required autofocus>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="deskripsi" class="col-sm-3 col-form-label">deskripsi</label>
                        <div class="col-sm-9">
                            <input type="text" name="deskripsi" id="deskripsi" class="form-control" required autofocus>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="peraturan" class="col-sm-3 col-form-label">peraturan</label>
                        <div class="col-sm-9">
                            <input type="text" name="peraturan" id="peraturan" class="form-control" required autofocus>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tgl_terbit" class="col-sm-3 col-form-label">Tgl terbit</label>
                        <div class="col-sm-9">


                            <div class="input-group date" id="tgl_terbit" data-target-input="nearest">
                                <div class="input-group-append" data-target="#tgl_terbit" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <input type="text" class="form-control datetimepicker-input" data-target="#tgl_terbit" name="tgl_terbit"/>
                            </div>
                        </div>


                    </div>
                    <div class="row mb-3">
                        <label for="tgl_berlaku" class="col-sm-3 col-form-label">Tgl Berlaku</label>
                        <div class="col-sm-9">


                            <div class="input-group date" id="tgl_berlaku" data-target-input="nearest">
                                <div class="input-group-append" data-target="#tgl_berlaku" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <input type="text" class="form-control datetimepicker-input" data-target="#tgl_berlaku" name="tgl_berlaku"/>
                            </div>
                        </div>


                    </div>

                    <div class="row mb-3">
                        <label for="file" class="col-sm-3 col-form-label">Peraturan Perundang2an</label>
                        <div class="col-sm-9">
                            <input type="file" name="file" id="file" class="form-control" >
                            <p id="filename"></p>
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

