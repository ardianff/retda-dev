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
                        <label for="opd" class="col-sm-3 col-form-label">Nama SKPD/OPD</label>
                        <div class="col-sm-9">
                           <select name="opd_id" id="opd_id" class="form-control select2"  >
                            <option value=""></option>
                            @foreach ($opd as $item)
                                
                            <option value="{{$item->id}}">{{$item->singkatan}}</option>
                            @endforeach
                           </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nama" class="col-sm-3 col-form-label">Nama UPPD/Balai/UPT</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama" id="nama" class="form-control" required autofocus>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="singkatan" class="col-sm-3 col-form-label">Singkatan OPD</label>
                        <div class="col-sm-9">
                            <input type="text" name="singkatan" id="singkatan" class="form-control" required autofocus>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="kode" class="col-sm-3 col-form-label">Kode Tarif </label>
                        <div class="col-sm-9">
                            <input type="text" name="kode" id="kode" class="form-control" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="id_grms" class="col-sm-3 col-form-label">Kode GRMS </label>
                        <div class="col-sm-9">
                            <input type="text" name="id_grms" id="id_grms" class="form-control" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="id_penari" class="col-sm-3 col-form-label">Kode SIPENARI </label>
                        <div class="col-sm-9">
                            <input type="text" name="id_penari" id="id_penari" class="form-control" >
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="status" class="col-sm-3 col-form-label">Status </label>

                        <div class="col-lg-8 d-flex align-items-center ">
                            <div class="icheck-primary mr-3">
                                <input type="radio" id="aktif" name="status" class="form-control" value="Aktif" >
                                <label for="aktif">
                                 Aktif
                                </label>
                              </div>
                            <div class="icheck-primary ">
                                <input type="radio" id="nonaktif" name="status" class="form-control" value="NonAktif">
                                <label for="nonaktif">
                                 Non Aktif
                                </label>
                              </div>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tgl_aktif" class="col-sm-3 col-form-label">Tanggal Aktif</label>
                        <div class="col-sm-9">
                            <div class="input-group date" id="tgl_aktif" data-target-input="nearest">
                                <div class="input-group-append" data-target="#tgl_aktif" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                </div>
                                <input type="text" class="form-control datetimepicker-input" data-target="#tgl_aktif" name="tgl_aktif" laceholder="klik gamabar kalender untuk memilih tgl"/>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tgl_nonaktif" class="col-sm-3 col-form-label">Tanggal Non Aktif</label>
                        <div class="col-sm-9">
                            <div class="input-group date" id="tgl_nonaktif" data-target-input="nearest">
                                <div class="input-group-append" data-target="#tgl_nonaktif" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                </div>
                                <input type="text" class="form-control datetimepicker-input" data-target="#tgl_nonaktif" name="tgl_nonaktif" placeholder="klik gamabar kalender untuk memilih tgl"/>
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

