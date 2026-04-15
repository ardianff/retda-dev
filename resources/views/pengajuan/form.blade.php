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
                        <label for="tahun" class="col-sm-3 col-form-label">tahun</label>
                        <div class="col-sm-9">
                            <select name="tahun" id="tahun" class="form-control" required>
                                @foreach ($thn as $item)
                                    
                                <option   value="{{$item->id}}">{{$item->tahun}}|{{$item->deskripsi}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="deskripsi" class="col-sm-3 col-form-label">deskripsi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="deskripsi" id="deskripsi">
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
                    <div class="row">
                        <label for="opd" class="col-sm-3 col-form-label">Pilih OPD/RSUD</label>
                        <div class="col-md-9">
                            <div class="row mb-2">
                                <div class="col-lg-12 d-flex align-items-center ">
                                    <div class="icheck-primary mr-3">
                                        <input type="radio" id="all" name="pilih_opd" class="form-control" value="all" >
                                        <label for="all">
                                          Semua OPD
                                        </label>
                                      </div>
                                    <div class="icheck-primary ">
                                        <input type="radio" id="pilih" name="pilih_opd" class="form-control" value="pilih">
                                        <label for="pilih">
                                          Pilih OPD
                                        </label>
                                      </div>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                            <div class="row">

                                @foreach ($opd as $item)
                                
                        <div class="col-md-4">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" class="opd-checkbox" id="opd-{{ $item->id }}" name="opd_id[]" value="{{ $item->id }}" >
                                <label for="opd-{{ $item->id }}">{{ $item->singkatan }}</label>
                            </div>
                        </div>
                        @endforeach
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

