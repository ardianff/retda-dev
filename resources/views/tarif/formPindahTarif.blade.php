<div class="modal fade " id="modal-pindahTarif" tabindex="-1" role="dialog" aria-labelledby="modal-pindahTarifLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="pindahTarif" action="" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-pindahTarifLabel">Pindah Tarif </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
    <div class="row">
        <div class="col-lg-4 col-md-4">

                   <input type="hidden" name="id" id="ID">
                    <div class="form-group mb-2">
                        <label for="opd-tarif" class="form-label"> SKPD/OPD Awal</label>
                        
                            <select id="opd-tarif" class="form-control "   disabled>
                                <option value="0">Keseluruhan</option>
                                @foreach ($opd as $item)
                                    
                                
                                <option   value="{{$item->id}}"> {{$item->opd}}</option>
                                @endforeach
                                
                                </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="balai-tarif" class="form-label">Balai/UPPD/cabdin awal</label>

                            <select id="balai-tarif" class="form-control "  disabled>
                                <option value="0">Keseluruhan</option>
                                @foreach ($uppd as $item)
                                
                                <option   value="{{$item->id}}"> {{$item->nama}}</option>
                                @endforeach
                                
                                </select>
                    </div>

                    <div class="form-group mb-2">
                        <label for="golongan-tarif" class="form-label">Golongan Retribusi Awal</label>
                            <select id="golongan-tarif" class="form-control "   disabled>
                                <option value="0">Keseluruhan</option>
                                @foreach ($golongan as $item)                            
                                <option   value="{{$item->id}}"> {{$item->name}}</option>
                                @endforeach
                                
                                </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="jenis-tarif" class="form-label">Jenis Retribusi  Awal</label>
                            <select id="jenis-tarif" class="form-control "   disabled>
                                <option value="0">Keseluruhan</option>
                                @foreach ($jenis as $item)                            
                                <option   value="{{$item->id}}"> {{$item->name}}</option>
                                @endforeach
                                
                            </select>
                    </div>
                    <div class="form-group  mb-2">
                        <label for="header" class="form-label">SubHeader Retribusi Awal</label>

                        <input type="text" id="header" name="header" class="form-control" disabled>
                    </div>
        </div>
        <div class="col-md-2 pl-1 d-flex justify-content-center align-items-center">
            <button class="btn btn-lg bg-orange disabled d-flex flex-column justify-content-center align-items-center pt-3" style="width: 80px; height: 55px;">
                <i class="fas fa-sign-out-alt fa-lg"></i>
                <span class="text-small" style="font-size: 0.7em">Pindah</span>
            </button>
        </div>
        
                            {{-- TUJUAN --}}

        <div class="col-md-6 col-lg-6">
            <div class="form-group mb-2">
                <label for="opd-tarif" class="form-label"> SKPD/OPD Tujuan</label>
                
                    <select id="opd-tarif-tujuan" class="form-control "   name="opd_id" required>
                        <option value="0"></option>
                        @foreach ($opd as $item)
                            
                        
                        <option   value="{{$item->id}}"> {{$item->opd}}</option>
                        @endforeach
                        
                        </select>
            </div>
            <div class="form-group mb-2">
                <label for="balai-tujuan" class="form-label">Balai/UPPD/cabdin Tujuan</label>

                    <select id="balai-tujuan" class="form-control " name="uppd_id" required>
                        <option value="0"></option>
                        @foreach ($uppd as $item)
                        
                        <option   value="{{$item->id}}"> {{$item->nama}}</option>
                        @endforeach
                        
                        </select>
            </div>

            <div class="form-group mb-2">
                <label for="golongan-tujuan" class="form-label">Golongan Retribusi Tujuan</label>
                    <select id="golongan-tujuan" class="form-control " name="gol_id"   required>
                        <option value="0"></option>
                        @foreach ($golongan as $item)                            
                        <option   value="{{$item->id}}"> {{$item->name}}</option>
                        @endforeach
                        
                        </select>
            </div>
            <div class="form-group mb-2">
                <label for="jenis-tujuan" class="form-label">Jenis Retribusi  Tujuan</label>
                    <select id="jenis-tujuan" class="form-control " name="jenis_id"  required>
                        <option value="0">Keseluruhan</option>
                        @foreach ($jenis as $item)                            
                        <option   value="{{$item->id}}"> {{$item->name}}</option>
                        @endforeach
                        
                    </select>
            </div>
            <div class="form-group mb-2">
                <label for="subheader" class="form-label">Subheader Tujuan</label>
                    <select id="subheader" class="form-control " name="subheader"  required>
                        <option value="0"></option>
                       
                        
                    </select>
            </div>
        </div>
    </div>
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="buttonpindahtarif">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
