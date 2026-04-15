@extends('template.master')

@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="{{route('tarif.index')}}"> Tarif</a> </li>

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
                <form action="{{route('tarif.index')}}" method="get" >
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Pilih Tahun</label>
                                <div class="col-md-8">
                                    <select id="thn_id" class="form-control " name="thn_id" data-user-level="{{ auth()->user()->level }}" required>
                                        <option value=""></option>
                                        @foreach ($TA as $item)
                                        
                                        <option  value="{{$item->id}}">Tahun {{$item->tahun}} || {{$item->deskripsi}}</option>
                                        @endforeach
                                        
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Pilih OPD</label>
                                <div class="col-md-8">
                                    <select id="opd_id" class="form-control " name="opd_id" data-user-level="{{ auth()->user()->level }}" required>
                                        @if (auth()->user()->level ==1)
                                            
                                        <option value=""></option>
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
                                        @if (auth()->user()->level ==1)
                                            
                                        <option value=""></option>
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
    $('#thn_id ').select2({
    placeholder: "Pilih Tahun Tarif",
    allowClear: true
});
    $('#jenis_id ').select2({
    placeholder: "Pilih Jenis Retribusi",
    allowClear: true
});
    $('#gol_id ').select2({
    placeholder: "Pilih Golongan Retribusi",
    allowClear: true
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
                        $('#jenis_id').select2('open');
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

$('#thn_id').on('change', function() {
    let userLevel = $(this).data('user-level'); // Ambil level user dari atribut data
    let allowedLevels = [1, 2, 6];

    if (!allowedLevels.includes(userLevel)) {
        alert('Anda tidak memiliki akses untuk memilih Tahun.');
        return; // Stop eksekusi jika level tidak diizinkan
    }
            let tahun = $(this).val();
            $('#opd_id').empty().append('<option value="">-- Pilih OPD --</option>');

            if (tahun) {
                $.ajax({
                    url: `{{ url('/opd/tahunAktif') }}/${tahun}`,
                    type: 'GET',
                    success: function(data) {
                        data.forEach(function(opd) {
                            $('#opd_id').append(`<option value="${opd.id}">${opd.opd}</option>`);
                        });
                    },
                    error: function() {
                        alert('Gagal mengambil data  OPD.');
                    }
                });
            }
        });

});
</script>
@endpush


