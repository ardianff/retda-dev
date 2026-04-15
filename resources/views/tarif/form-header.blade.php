<div class="modal fade " id="modal-header" tabindex="-1" role="dialog" aria-labelledby="modal-header">
    <div class="modal-dialog modal-lg " role="document">
        <form action="{{route('tarif.store')}}" method="post" class="form-horizontal" >
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"></h4>

                </div>
                <div class="modal-body">
                    <input type="hidden" name="satuan_id" value="0">
                    <input type="hidden" name="retribusi" value="retribusiHeader">
                    <input type="hidden" name="tipe" value="header">
                    <input type="hidden"  name="parent_id" value="0">
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
                        <label for="opd" class="col-sm-3 col-form-label">Pilih SKPD/OPD</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="opd" value="{{$opd_id}}">
                            <select id="opd" class="form-control "   disabled>
                                @foreach ($opd as $item)
                                    
                                
                                <option {{ $item->id == $opd_id ? 'selected' : '' }}  value="{{$item->id}}"> {{$item->opd}}</option>
                                @endforeach
                                
                                </select>
                        </div>
                    </div>
                    <div class="row ">
                        <label for="balai" class="col-sm-3 col-form-label">Pilih Balai/UPPD/cabdin</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="balai" value="{{$uppd_id}}">

                            <select id="balai" class="form-control "  disabled>
                                @foreach ($uppd as $item)
                                
                                <option {{ $item->id == $uppd_id ? 'selected' : '' }} value="{{$item->id}}"> {{$item->nama}}</option>
                                @endforeach
                                
                                </select>
                        </div>
                    </div>

                    <div class="row ">
                        <label for="golongan" class="col-sm-3 col-form-label">Golongan Retribusi </label>
                        <div class="col-sm-9">
                            <input type="hidden" name="golongan" value="{{$gol_id}}">
                            <select id="golongan" class="form-control "   disabled>
                                @foreach ($golongan as $item)                            
                                <option {{ $item->id == $gol_id ? 'selected' : '' }}  value="{{$item->id}}"> {{$item->name}}</option>
                                @endforeach
                                
                                </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="jenis" class="col-sm-3 col-form-label">Jenis Retribusi  </label>
                        <div class="col-sm-9">
                            <input type="hidden" name="jenis" value="{{$jenis_id}}">
                            <select id="jenis" class="form-control "   disabled>
                                @foreach ($jenis as $item)                            
                                <option {{ $item->id == $jenis_id ? 'selected' : '' }}   value="{{$item->id}}"> {{$item->name}}</option>
                                @endforeach
                                
                            </select>
                        </div>
                    </div>
                   
                    <div class="row mb-3">
                        <label for="uraian" class="col-sm-3 col-form-label">uraian Retribusi  </label>
                        <div class="col-sm-9">
                           <input type="text" name="uraian" id="uraian" class="form-control" required>
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
                    <button type="submit" class="btn btn-sm btn-flat btn-success"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm  btn-secondary"
                    data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

