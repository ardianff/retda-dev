@extends('template.master')

@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="{{route('pejabat.index')}}">Set Pejabat</a> </li>

@endsection

@section('content')
@php
$userLevel = auth()->user()->level;


// Cek apakah $userLevel tidak null sebelum mengecek di dalam array
$isSpecialLevel = in_array($userLevel, [1, 2, 6]);
$isSpecial = in_array($userLevel, [1, 2,3, 6]);
@endphp
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-dark">Filter Tarif</div>
            <div class="card-body">
                <form action="{{route('pejabat.index')}}" method="get" >
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                           
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Pilih OPD</label>
                                <div class="col-md-8">
                                    <select id="opd_id" class="form-control " name="opd_id" data-user-level="{{ auth()->user()->level }}">
                                        @if ($isSpecialLevel)
                                            
                                        <option value=""></option>
                                        @endif
                                        @foreach ($opd as $item)
                                            
                                        <option  value="{{$item->id}}"> {{$item->opd}}</option>
                                        @endforeach 
                                        
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Pilih UPPD/BALAI/SATKER</label>
                                <div class="col-md-8">
                                    <select id="uppd_id" class="form-control " name="uppd_id" >
                                        @if ($isSpecial)
                                            
                                        <option value=""></option>
                                        @endif
                                        @foreach ($uppd as $item)
                                        
                                        <option   value="{{$item->id}}"> {{$item->nama}}</option>
                                        @endforeach
                                        
                                        </select>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Tampilkan</button>
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
</script>
@endpush
