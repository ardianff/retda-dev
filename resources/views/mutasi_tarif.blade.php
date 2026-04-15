@extends('template.master')


{{-- @push('css')
    <style>
 
    </style>
@endpush --}}

@section('content')

<div class="row">
    <div class="col-lg-12">
      
        <div class="card">
            <div class="card-header bg-dark">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
        
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            Clone Tarif</div>
            <div class="card-body">
                <form action="{{ route('mutasiTarif') }}" method="POST" >
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                        
                            <div class="form-group row">
                                <label for="" class="col-md-4 "> Tahun</label>
                                <div class="col-md-5">
                                    <input type="text" name="ta_id" value="1" class="form-control" placeholder="tahun 2024">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Pilih OPD</label>
                                <div class="col-md-8">
                                    <select id="opd_id" class="form-control " name="opd_id" required>
                                        <option value=""></option>
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
                                       
                                        
                                        </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                          
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Golongan Retribusi</label>
                                <div class="col-md-8">
                                    <select id="golongan_id" class="form-control " name="golongan_id" required>
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
                                       
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-10"></div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success btn-sm btn-flat">Save <i class="fas fa-save fa-md"></i></button>
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
$(function () {
    $('#form_tarif').on('click', function () {
    // Submit the form with ID 'myForm'
    $('#tarifFormBody').submit();
    });
   

    $('#opd_id ').select2({
    placeholder: "Pilih OPD",
    allowClear: true
});
    $('#uppd_id ').select2({
    placeholder: "Pilih Balai/UPPD/Satker",
    allowClear: true
});
    $('#jenis_id ').select2({
    placeholder: "Pilih Jenis Retribusi",
    allowClear: true
});
    $('#golongan_id ').select2({
    placeholder: "Pilih Golongan Retribusi",
    allowClear: true
});
    $('#rekening_id ').select2({
    placeholder: "Pilih rekening Retribusi",
    allowClear: true
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
                        $('#uppd_id').append(`<option value="0">Keseluruhan</option>`);
                    },
                    error: function() {
                        alert('Gagal mengambil data  Balai.');
                    }
                });
            }
        });
$('#golongan_id').on('change', function() {
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


