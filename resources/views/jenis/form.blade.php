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
                        <label for="golongan_id" class="col-sm-3 col-form-label">Golongan</label>
                        <div class="col-sm-9">
                          <select name="golongan_id" id="golongan_id" class="form-control" required>
                            <option value=""></option>
                            @foreach ($golongan as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-3 col-form-label">Nama Jenis</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="name" class="form-control" required autofocus>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="singkatan" class="col-sm-3 col-form-label">Singkatan </label>
                        <div class="col-sm-9">
                            <input type="text" name="singkatan" id="singkatan" class="form-control"  autofocus>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="kode" class="col-sm-3 col-form-label">Kode  </label>
                        <div class="col-sm-9">
                            <input type="text" name="kode" id="kode" class="form-control" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="id_sipenari" class="col-sm-3 col-form-label">Kode SIPENARI </label>
                        <div class="col-sm-9">
                            <input type="text" name="id_sipenari" id="id_sipenari" class="form-control" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="grms_id" class="col-sm-3 col-form-label">Kode GRMS </label>
                        <div class="col-sm-9">
                            <input type="text" name="grms_id" id="grms_id" class="form-control" >
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

