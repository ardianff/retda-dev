<div class="modal fade " id="modalFormTarif" tabindex="-1" role="dialog" aria-labelledby="modalFormTarifLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="tarifFormBody" action="{{ route('tarif.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormTarifLabel">Tambah Data Body</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="retribusi" value="retribusiBody">
                    <input type="hidden" id="parent_id_body" name="parent_id">
                    <input type="hidden" id="tipe" name="tipe" value="body">
                    <input type="hidden" id="tahun" name="tahun" value="{{$thn_id}}">
                    <div class="form-group row mb-2">
                        <label for="tahun" class="col-sm-3 col-form-label">Tahun </label>

                        <div class="col-sm-9">
                            <select id="tahun" class="form-control " name="tahun" disabled>
                                @foreach ($TA as $item)
                                
                                <option {{ $item->id == $thn_id ? 'selected' : '' }}  value="{{$item->id}}" disabled>Tahun {{$item->tahun}}</option>
                                @endforeach
                                
                                </select>
                       
                    </div>
                    </div>
                    <div class="row ">
                        <label for="opd-tarif" class="col-sm-3 col-form-label">Pilih SKPD/OPD</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="opd" >
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
                            <input type="hidden" name="balai" >

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
                            <input type="hidden" name="golongan">
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
                            <input type="hidden" name="jenis">
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
                        <label for="uraian" class="col-sm-3 col-form-label">Uraian </label>

                        <div class="col-sm-9">
                        <input type="text" id="uraian" name="uraian" class="form-control" required>
                       
                    </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="satuan" class="col-sm-3 col-form-label">Satuan</label>

                        <div class="col-sm-9">
                        <select id="satuan_id" name="satuan" class="form-control" required>
                            <option value="">Pilih Satuan</option>
                            <!-- Isi dengan data satuan -->
                            @foreach ($satuan as $item)
                                
                            <option value="{{$item->id}}">{{$item->uraian}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                  <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label">Format Tarif</label>
                    
                        <div class="col-sm-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format_tarif" id="rupiah" value="rupiah" checked>
                                <label class="form-check-label" for="rupiah">Nilai Rupiah</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format_tarif" id="bukan_nilai" value="bukan_rupiah">
                                <label class="form-check-label" for="bukan_nilai">Bukan Rupiah</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format_tarif" id="up" value="up">
                                <label class="form-check-label" for="up">UP</label>
                            </div>
                        </div>
                    </div>
                    @if ($jenis_id==16)
                        
                    <div class="form-group row mb-2">
                        <label for="sarana" class="col-sm-3 col-form-label">Jasa sarana </label>

                        <div class="col-sm-9">
                        <input type="text" id="sarana" name="sarana" class="form-control uang" value="0" required>
                       
                    </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="layanan" class="col-sm-3 col-form-label">Jasa layanan </label>

                        <div class="col-sm-9">
                        <input type="text" id="layanan" name="layanan" class="form-control uang" value="0" required>
                       
                    </div>
                    </div>
                    @endif
                    <div class="form-group row mb-2">
                        

                        <div class="col-sm-8">
                            @if ($jenis_id!= 16)
                                
                            <input type="text" id="nilai" name="nilai" class="form-control uang" >
                            @endif
                        </div>
                     
                    </div>
                    <div class="form-group row  ">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 ">
                            <input type="text" id="bkn_nilai" name="bkn_nilai" class="form-control hidden" placeholder="Masukan Imbuhan Bukan Rupiah..">
                    </div>
                      
                    </div>
                    
                    <div class="form-group row mb-2">
                        <label for="rekening" class="col-sm-3 col-form-label">Rekening</label>

                        <div class="col-sm-9">
                            <select id="rekening" name="rekening" class="form-control" required>
                                <option value="">Pilih rekening</option>
                                <!-- Isi dengan data rekening -->
                                @foreach ($rekening as $item)
                                    
                                <option value="{{$item->id}}">{{$item->ket}}</option>
                                @endforeach
                            </select>
                        </div>
                      
                    </div>
                     <div class="row mb-3">
                        <label for="keterangan" class="col-sm-3 col-form-label">keterangan   </label>
                        <div class="col-sm-9">
                           <input type="text" name="keterangan" id="keterangan" class="form-control" >
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="form_tarif">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
