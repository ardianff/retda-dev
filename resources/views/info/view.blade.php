@extends('template.master')

@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="{{route('info.index')}}"> Tarif</a> </li>

@endsection
@push('css')
    <style>
         .hidden {
      display: none;
    }
    </style>
@endpush

@section('content')

<div class="row">
    <div class="col-lg-12">
      
        <div class="card">
            <div class="card-header bg-dark">Filter Tarif</div>
            <div class="card-body">
                <form action="{{route('info.index')}}" method="get" >
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Pilih Tahun</label>
                                <div class="col-md-5">
                                    <select id="thn_id" class="form-control " name="thn_id" required>
                                        @foreach ($TA as $item)
                                        
                                        <option {{ $item->id == $thn_id ? 'selected' : '' }}  value="{{$item->id}}">Tahun {{$item->tahun}}</option>
                                        @endforeach
                                        
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Pilih OPD</label>
                                <div class="col-md-8">
                                    <select id="opd_id" class="form-control " name="opd_id" data-user-level="{{ auth()->user()->level }}" required>
                                        @if (in_array(auth()->user()->level, [1, 2, 6]))
                                        <option value="">Pilih OPD</option>
                                    @endif
                                        @foreach ($opd as $item)
                                            
                                        <option   value="{{$item->id}}"> {{$item->opd}}</option>
                                        @endforeach 
                                        
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Pilih UPPD/BALAI/SATKER</label>
                                <div class="col-md-8">
                                    <select id="uppd_id" class="form-control " name="uppd_id" required>
                                        @if (in_array(auth()->user()->level, [1, 2, 6]))
                                        <option value="">Pilih UPPD/Balai/UPT</option>
                                    @endif
                                        @foreach ($uppd as $item)
                                        
                                        <option   value="{{$item->id}}"> {{$item->nama}}</option>
                                        @endforeach
                                        
                                        </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Golongan Retribusi</label>
                                <div class="col-md-8">
                                    <select id="gol_id" class="form-control " name="gol_id" required>
                                        <option value=""></option>
                                        @foreach ($golongan as $item)                            
                                        <option   value="{{$item->id}}"> {{$item->name}}</option>
                                        @endforeach
                                        
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label for="" class="col-md-4 ">Jenis Retribusi</label>
                                <div class="col-md-8">
                                    <select id="jenis_id" class="form-control " name="jenis_id" required>
                                        {{-- @foreach ($jenis as $item)                            
                                        <option {{ $item->id == $jenis_id ? 'selected' : '' }}  value="{{$item->id}}"> {{$item->name}}</option>
                                        @endforeach --}}
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-10"></div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success btn-sm btn-flat">Filter <i class="fas fa-search fa-md"></i></button>
                                </div>
                            </div>
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
    
    $(document).ready(function() {
        let allowedLevels = [1, 2, 3, 6];
        let userLevel = {{ auth()->user()->level }}; // Ambil level dari Laravel ke JavaScript

        if (allowedLevels.includes(userLevel)) {
            $('#opd_id, #uppd_id').select2({
                placeholder: "Pilih opsi",
                allowClear: true
            });
        }
    });
$(function () {
    $('#form_tarif').on('click', function () {
    // Submit the form with ID 'myForm'
    $('#tarifFormBody').submit();
    });
   

//     $('#opd_id ').select2({
//     placeholder: "Pilih OPD",
//     allowClear: true
// });
//     $('#uppd_id ').select2({
//     placeholder: "Pilih Balai/UPPD/Satker",
//     allowClear: true
// });
    $('#jenis_id ').select2({
    placeholder: "Pilih Jenis Retribusi",
    allowClear: true
});
    $('#gol_id ').select2({
    placeholder: "Pilih Golongan Retribusi",
    allowClear: true
});
   
$('#opd_id').on('input', function() {
    let userLevel = $(this).data('user-level'); // Ambil level user dari atribut data
    let allowedLevels = [1, 2, 3, 6];

    if (!allowedLevels.includes(userLevel)) {
        alert('Anda tidak memiliki akses untuk memilih OPD.');
        return; // Stop eksekusi jika level tidak diizinkan
    }

    let opd_id = $(this).val();
    $('#uppd_id').empty().append('<option value="">-- Pilih UPPD/Balai/Satker --</option>');

    if (opd_id) {
        $.ajax({
            url: `{{ url('/opd/uppd') }}/${opd_id}`,
            type: 'GET',
            success: function(data) {
                $('#uppd_id').append(`<option value="">Pilih UPPD/Balai/UPT</option>`);
                data.forEach(function(uppd) {
                    $('#uppd_id').append(`<option value="${uppd.id}">${uppd.nama}</option>`);
                });
            },
            error: function() {
                alert('Gagal mengambil data Balai.');
            }
        });
    }
});

$('#gol_id').on('change', function() {
            let gol = $(this).val();
            $('#jenis_id').empty().append('<option value="">-- Pilih Jenis Retribusi --</option>');

            if (gol) {
                $.ajax({
                    url: `{{ url('/golongan/jenis') }}/${gol}`,
                    type: 'GET',
                    success: function(data) {
                        data.forEach(function(jenis) {
                            $('#jenis_id').append(`<option value="${jenis.id}">${jenis.name}</option>`);
                        });
                    },
                    error: function() {
                        alert('Gagal mengambil data  Balai.');
                    }
                });
            }
        });

});
</script>
@endpush


