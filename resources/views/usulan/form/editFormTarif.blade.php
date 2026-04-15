<div class="modal fade " id="modal-editform" tabindex="-1" role="dialog" aria-labelledby="modal-editformLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="modal-editform" action="" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-editformLabel">Tambah Data Body</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <input type="hidden" name="id" id="ID">
                   <input type="hidden" name="parent_id" id="parent-tarif">
                    <div class="row ">
                        <label for="opd-tarif" class="col-sm-3 col-form-label">Pilih SKPD/OPD</label>
                        <div class="col-sm-9">
                            <select id="opd-tarif" class="form-control "   disabled>
                                <option value="0">Keseluruhan</option>
                                @foreach ($opd as $item)
                                    
                                
                                <option   value="{{$item->id}}"> {{$item->opd}}</option>
                                @endforeach
                                
                                </select>
                        </div>
                    </div>
                    <div class="row ">
                        <label for="balai-tarif" class="col-sm-3 col-form-label">Pilih Balai/UPPD/cabdin</label>
                        <div class="col-sm-9">

                            <select id="balai-tarif" class="form-control "  disabled>
                                <option value="0">Keseluruhan</option>
                                @foreach ($uppd as $item)
                                
                                <option   value="{{$item->id}}"> {{$item->nama}}</option>
                                @endforeach
                                
                                </select>
                        </div>
                    </div>

                    <div class="row ">
                        <label for="golongan-tarif" class="col-sm-3 col-form-label">Golongan Retribusi </label>
                        <div class="col-sm-9">
                            <select id="golongan-tarif" class="form-control "   disabled>
                                <option value="0">Keseluruhan</option>
                                @foreach ($golongan as $item)                            
                                <option   value="{{$item->id}}"> {{$item->name}}</option>
                                @endforeach
                                
                                </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="jenis-tarif" class="col-sm-3 col-form-label">Jenis Retribusi  </label>
                        <div class="col-sm-9">
                            <select id="jenis-tarif" class="form-control "   disabled>
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
                                <span class="input-group-text" id="kode-tarif"></span>
                                
                                <!-- Bagian kedua (bisa diinput) -->
                                <input type="text" class="form-control" id="number-tarif" name="number" minlength="2" required>
                            </div>
                        {{-- <input type="text" id="number" name="number" class="form-control" required>
                        <input type="text" id="kode" name="kode" class="form-control" required> --}}
                    </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="uraian" class="col-sm-3 col-form-label">Uraian </label>

                        <div class="col-sm-9">
                        <input type="text" id="edit_uraian" name="uraian" class="form-control" required>
                       
                    </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="satuan" class="col-sm-3 col-form-label">Satuan</label>

                        <div class="col-sm-9">
                        <select id="edit_satuan" name="satuan" class="form-control" required>
                            <option value="">Pilih Satuan</option>
                            <!-- Isi dengan data satuan -->
                            @foreach ($satuan as $item)
                                
                            <option value="{{$item->id}}">{{$item->uraian}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <input type="hidden" id="db_nilai">
<input type="hidden" id="db_sarana">
<input type="hidden" id="db_layanan">

@if ($jenis_id != 16)
    
<div class="form-group row mb-2">
    <label for="berlaku" class="col-sm-3 col-form-label">Tarif saat ini </label>
    
    <div class="col-sm-9">
        <input type="text" id="berlaku"  class="form-control" disabled>
        
    </div>
</div>
@endif
@if ($jenis_id==16)
<div class="form-group row mb-2">
    <label for="berlaku" class="col-sm-3 col-form-label">Tarif saat ini :</label>
</div>
                        
    <div class="form-group row mb-2 ml-2">
        <label for="sarana" class="col-sm-3 col-form-label">Jasa sarana </label>

        <div class="col-sm-8">
        <input type="text" id="saat_ini_sarana" class="form-control uang" disabled>
        
    </div>
    </div>
    <div class="form-group row mb-2 ml-2">
        <label for="layanan" class="col-sm-3 col-form-label">Jasa layanan </label>

        <div class="col-sm-8">
        <input type="text" id="saat_ini_layanan"  class="form-control uang" disabled>
        
    </div>
    </div>
@endif
<hr style="margin-top: 10px">

<div class="form-group row mb-2">
    <label class="col-sm-3 col-form-label">Format Tarif</label>

    <div class="col-sm-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="edit_format_tarif" id="edit_rupiah" value="rupiah" checked>
            <label class="form-check-label" for="edit_rupiah">Nilai Rupiah</label>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="edit_format_tarif" id="edit_bukan_nilai" value="bukan_rupiah">
            <label class="form-check-label" for="edit_bukan_nilai">Bukan Rupiah</label>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="edit_format_tarif" id="edit_up" value="up">
            <label class="form-check-label" for="edit_up">UP</label>
        </div>
    </div>
</div>


@if ($jenis_id==16)
<div class="form-group row mb-2">
    <label for="berlaku" class="col-sm-3 col-form-label">Tarif Usulan/Perubahan:</label>
</div>
                        
    <div class="form-group row mb-2 ml-2">
        <label for="sarana" class="col-sm-3 col-form-label">Jasa sarana </label>

        <div class="col-sm-8">
        <input type="text" id="edit_sarana" name="sarana" class="form-control uang" required>
        
    </div>
    </div>
    <div class="form-group row mb-4 ml-2">
        <label for="layanan" class="col-sm-3 col-form-label">Jasa layanan </label>

        <div class="col-sm-8">
        <input type="text" id="edit_layanan" name="layanan" class="form-control uang" required>
        
    </div>
    </div>
@endif

@if ($jenis_id != 16)
    
<div class="form-group row mb-2">
    <label for="nilai" class="col-sm-3 col-form-label">Tarif Usulan/Perubahan</label>
    <div class="col-sm-4">
        <input type="text" id="edit_nilai" name="nilai" class="form-control uang">
    </div>
    
  
</div>
@endif
<div class="form-group row  ">
    <div class="col-sm-3"></div>
    <div class="col-sm-8 ">
        <input type="text" id="edit_bkn_nilai" name="bkn_nilai" class="form-control hidden" placeholder="Masukan Imbuhan Bukan Rupiah..">
</div>
  
</div>
<div class="form-group row mb-2">
        <label for="keterangan" class="col-sm-3 col-form-label">Keterangan Tarif </label>

        <div class="col-sm-9">
        <input type="text" id="edit-keterangan" name="keterangan" class="form-control" placeholder="Masukan keterangan tarif contoh:  tarif belum termasuk ... atau lainnya (maksimal 300 karakter)"  >
        
    </div>
    </div>        
    <div class="form-group row mb-2">
        <label for="rekening" class="col-sm-3 col-form-label">Rekening</label>

        <div class="col-sm-9">
            <select id="edit_rekening" name="rekening" class="form-control" required>
                <option value="">Pilih rekening</option>
                <!-- Isi dengan data rekening -->
                @foreach ($rekening as $item)
                    
                <option value="{{$item->id}}">{{$item->ket}}</option>
                @endforeach
            </select>
        </div>
        
    </div>
    <div class="form-group row mb-2">
        <label for="penjelasan" class="col-sm-3 col-form-label">Penjelasan  </label>

        <div class="col-sm-9">
        <input type="text" id="edit-penjelasan" name="penjelasan" class="form-control"  placeholder="Masukan penjelasan alasan tarif baru/naik/turun (maksimal 300 karakter)"  >
        
    </div>
    </div>    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="form_tarif">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
