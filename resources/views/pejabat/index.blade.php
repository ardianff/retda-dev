@extends('template.master')
@section('title', 'Pejabat | E-Tarif RETDA')
@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="{{route('pejabat.index')}}">Set Pejabat</a> </li>

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-dark">Data Pejabat</div>
            <div class="card-body">
                <form action="{{route('pejabat.index')}}" method="get" id="formfilter">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            {{-- <!--<div class=" row">-->
                            <!--    <label for="" class="col-md-4">Pilih Tahun</label>-->
                            <!--    <div class="col-md-5">-->
                            <!--        <select id="thn_id" class="form-control " name="thn_id" >-->
                            <!--            @foreach ($tahunall as $item)-->
                                        
                            <!--            <option {{ $item->tahun == $thn_id ? 'selected' : '' }}  value="{{$item->tahun}}">Tahun {{$item->tahun}}</option>-->
                            <!--            @endforeach-->
                                        
                            <!--            </select>-->
                            <!--    </div>-->
                            <!--</div>--> --}}
                            <input type="hidden" name="tahun" value="{{date('Y')}}">
                            <div class=" row">
                                <label for="" class="col-md-4 ">Pilih OPD</label>
                                <div class="col-md-8">
                                    <select id="opd_id" class="form-control " name="opd_id" >
                                        @foreach ($opdall as $item)
                                            
                                        <option {{ $item->id == $opd ? 'selected' : '' }}  value="{{$item->id}}"> {{$item->opd}}</option>
                                        @endforeach 
                                        
                                        </select>
                                </div>
                            </div>
                            <div class=" row">
                                <label for="" class="col-md-4 ">Pilih UPPD/BALAI/SATKER</label>
                                <div class="col-md-8">
                                    <select id="uppd_id" class="form-control " name="uppd_id" >
                                      
            
                                        @foreach ($uppdall as $item)
                                        
                                        <option {{ $item->id == $uppd ? 'selected' : '' }}  value="{{$item->id}}"> {{$item->nama}}</option>
                                        @endforeach
                                        
                                        </select>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="button" id="submitfilter">Tampilkan</button>

                        </div>
                       
                    </div>
                    
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h3>Data pejabat I</h3></div>
            <div class="card-body">
                <form action="{{route('pejabat.store')}}" method="post" id="pejabatform">
                    @csrf
                    <input type="hidden" name="tahun" value="{{date('Y')}}">

                    <input type="hidden" name="opd" value="{{$opd??0}}">
                    <input type="hidden" name="uppd" value="{{$uppd??0}}">
                    <div class="form-group row mb-1">
                        <label for="" class="col-md-2 ">Kota</label>
                        <div class="col-md-6">
                           <input type="text" class="form-control" name="kota" value="{{$pejabat->kota??''}}">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="" class="col-md-2 ">Jabatan</label>
                        <div class="col-md-6">
                           <input type="text" class="form-control" name="jabatan" value="{{$pejabat->jabatan??''}}">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="" class="col-md-2 ">Antar Waktu</label>
                        <div class="col-md-6">
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="none" name="antr_waktu" {{ optional($pejabat)->antr_waktu == 'none' ? 'checked' : '' }} value="none">
                                <label for="none">
                                    None
                                </label>
                              </div>
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="plt" name="antr_waktu"  {{ optional($pejabat)->antr_waktu == 'Plt' ? 'checked' : '' }} value="Plt">
                                <label for="plt">
                                    Plt
                                </label>
                              </div>
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="plh" name="antr_waktu"  {{ optional($pejabat)->antr_waktu == 'plh' ? 'checked' : '' }} value="Plh">
                                <label for="plh">
                                    Plh
                                </label>
                              </div>
                          
                        </div>
                    </div>
                    
                    <div class="form-group row mb-1" style="display: none;" id="jabatan_utama">
                        <label for="jabatan_utama" class="col-md-2 ">Jabatan Utama</label>
                        <div class="col-md-6">
                           <input type="text" class="form-control" name="jabatan_utama" value="{{$pejabat->jabatan_utama??''}}">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="" class="col-md-2 ">Nama</label>
                        <div class="col-md-6">
                           <input type="text" class="form-control" name="nama" value="{{$pejabat->nama??''}}">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="" class="col-md-2 ">Pagkat/Golongan</label>
                        <div class="col-md-6">
                           <input type="text" class="form-control" name="pangkat" value="{{$pejabat->pangkat??''}}">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="" class="col-md-2 ">NIP</label>
                        <div class="col-md-6">
                           <input type="text" class="form-control" name="nip" value="{{$pejabat->nip??''}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                        <button type="button" id="submitPejabat" class="btn btn-success btn-sm">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
       
    </div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
    $('#opd_id ').select2({
    placeholder: "Pilih OPD",
    allowClear: true
});

    $('#uppd_id ').select2({
    placeholder: "Pilih UPPD?Balai/Satker",
    allowClear: true
});

$('#submitPejabat').on('click', function (e) {
    e.preventDefault(); // Pastikan tidak ada submit otomatis
    $('#pejabatform').submit(); // Kirim hanya form pejabat
});

$('#submitfilter').on('click', function () {
    // Submit the form with ID 'myForm'
    $('#formfilter').submit();
    });

});

$(document).on('select2:open', () => {
    setTimeout(() => {
        let searchField = document.querySelector('.select2-container--open .select2-search__field');
        if (searchField) {
            searchField.focus();
        }
    }, 50); // Delay kecil untuk memastikan field tersedia
});
$('#opd_id').on('input', function() {
            let opd_id = $(this).val();
            $('#uppd_id').empty().append('<option value="">-- Pilih UPPD/Balai/Satker --</option>');

            if (opd_id) {
                $.ajax({
                    url: `{{ url('/opd/uppd') }}/${opd_id}`,
                    type: 'GET',
                    success: function(data) {
                         data.forEach(function(uppd) {
                    $('#uppd_id').append(`<option value="${uppd.id}">${uppd.nama}</option>`);
                });
                $('#uppd_id').select2('open');
                setTimeout(() => {
                    let searchField = document.querySelector('.select2-container--open .select2-search__field');
                    if (searchField) {
                        searchField.focus();
                    }
                }, 50);
                    },
                    error: function() {
                        alert('Gagal mengambil data  Balai.');
                    }
                });
            }
        });

$(document).ready(function(){
    $('input[name="antr_waktu"]').change(function(){
        if ($('#plt').is(':checked') || $('#plh').is(':checked')) {
            $('#jabatan_utama').show();
        } else {
            $('#jabatan_utama').hide();
        }
    });

    // Pastikan input tetap sesuai saat halaman dimuat ulang
    if ($('#plt').is(':checked') || $('#plh').is(':checked')) {
        $('#jabatan_utama').show();
    } else {
        $('#jabatan_utama').hide();
    }
});


</script>
@endpush
