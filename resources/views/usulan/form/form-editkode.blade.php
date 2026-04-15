<div class="modal fade " id="modal-editKode" tabindex="-1" role="dialog" aria-labelledby="modal-editKode">
    <div class="modal-dialog modal-lg " role="document">
        <form action="" id="form-editKode" method="post" class="form-horizontal" >
         @csrf

            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"></h4>

                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id_tarif" >
                    
                    <div class="row ">
                        <label for="opd" class="col-sm-3 col-form-label">Pilih SKPD/OPD</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="opd" >
                            <select id="opd" class="form-control "   disabled>
                                <option value="0">Keseluruhan</option>
                                @foreach ($opd as $item)
                                    
                                
                                <option   value="{{$item->id}}"> {{$item->opd}}</option>
                                @endforeach
                                
                                </select>
                        </div>
                    </div>
                    <div class="row ">
                        <label for="balai" class="col-sm-3 col-form-label">Pilih Balai/UPPD/cabdin</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="balai" >

                            <select id="balai" class="form-control "  disabled>
                                <option value="0">Keseluruhan</option>
                                @foreach ($uppd as $item)
                                
                                <option   value="{{$item->id}}"> {{$item->nama}}</option>
                                @endforeach
                                
                                </select>
                        </div>
                    </div>

                    <div class="row ">
                        <label for="golongan" class="col-sm-3 col-form-label">Golongan Retribusi </label>
                        <div class="col-sm-9">
                            <input type="hidden" name="golongan">
                            <select id="golongan" class="form-control "   disabled>
                                <option value="0">Keseluruhan</option>
                                @foreach ($golongan as $item)                            
                                <option   value="{{$item->id}}"> {{$item->name}}</option>
                                @endforeach
                                
                                </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="jenis" class="col-sm-3 col-form-label">Jenis Retribusi  </label>
                        <div class="col-sm-9">
                            <input type="hidden" name="jenis">
                            <select id="jenis" class="form-control "   disabled>
                                <option value="0">Keseluruhan</option>
                                @foreach ($jenis as $item)                            
                                <option   value="{{$item->id}}"> {{$item->name}}</option>
                                @endforeach
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="header" class="col-sm-3 col-form-label">Kelompok Retribusi </label>

                        <div class="col-sm-9">
                        <input type="text" id="header" name="header" class="form-control" disabled>
                    </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="kode" class="col-sm-3 col-form-label">Nomer Urut Tarif </label>

                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text" id="kode"></span>
                                
                                <!-- Bagian kedua (bisa diinput) -->
                                <input type="text" class="form-control" id="number" name="number" minlength="2" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="uraian" class="col-sm-3 col-form-label">uraian Retribusi  </label>
                        <div class="col-sm-9">
                           <input type="text" name="uraian" id="uraian" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="kode" class="col-sm-3 col-form-label">kode  Baru </label>
                        <div class="col-sm-9">
                           <input type="text" name="kode"  class="form-control" required>
                        </div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-flat btn-success" id="btn-updateKode"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm  btn-secondary"
                    data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

