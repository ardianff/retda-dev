@extends('template.master')

@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="{{route('usulan.index')}}"> Tarif</a> </li>

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
            <div class="card-header bg-dark">Filter Print Lampiran Usulan Tarif</div>
            <div class="card-body">
                <form action="{{route('print.usulanExport')}}" method="get" target="_blank">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row mb-1">
                                <label for="" class="col-md-2 "> Peridode Usulan</label>
                                <div class="col-md-6">
                                    <select id="pengajuan_id" class="form-control " name="pengajuan_id" required>
                                        @foreach ($pengajuan as $item)
                                        
                                        <option   value="{{$item->id}}">{{$item->deskripsi}} </option>
                                        @endforeach
                                        
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row mb-1">
                                <label for="" class="col-md-2 ">Pilih OPD</label>
                                <div class="col-md-6">
                                    <select id="opd_id" class="form-control " name="opd_id" required>
                                        @if (userSpesial())
                                            
                                        <option value=""> Pilih OPD</option>
                                        @endif

                                        @foreach ($opd as $item)
                                            
                                        <option  value="{{$item->id}}"> {{$item->opd}}</option>
                                        @endforeach 
                                        
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row mb-1">
                                <label for="" class="col-md-2 ">Pilih Balai/UPPD/UPT</label>
                                <div class="col-md-6">
                                    <select id="uppd_id" class="form-control " name="uppd_id" required>
                                        @if (userKusus())
                                        <option value="">Pilih Balai/UPT/UPPD</option>
                                            
                                        <option value="0">Keseluruhan</option>
                                        @endif
                                        @foreach ($uppd as $item)
                                            
                                        <option  value="{{$item->id}}"> {{$item->nama}}</option>
                                        @endforeach 
                                        
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-2 ">Golongan Retribusi</label>
                                <div class="col-md-6">
                                    <select id="gol_id" class="form-control " name="gol_id" required>
                                        <option value=""></option>
                                        @foreach ($golongan as $item)                            
                                        <option  value="{{$item->id}}"> {{$item->name}}</option>
                                        @endforeach
                                        
                                        </select>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-10">
                                        <div class="btn-group">

                                            <button type="submit" name="action" value="pdf" class="btn btn-danger btn-sm mr-3" target="_blank">
                                                Preview PDF <i class="fas fa-file-pdf"></i>
                                            </button>
                    
                                            <button type="submit" name="action" value="excel" class="btn btn-success btn-sm mr-3" target="_blank">
                                                Download Excel <i class="fas fa-file-excel"></i>
                                            </button>
                    
                                            <button type="submit" name="action" value="unduhPDF" class="btn btn-info btn-sm mr-3" >
                                                Download PDF <i class="fas fa-file-download"></i>
                                            </button>
@if (userSpesial())
    
<button type="submit" name="action" value="rekap" class="btn btn-warning btn-sm " >
    Rekap <i class="fas fa-file-archive"></i>
</button>
@endif
                                        </div>
                                        <p style="color: rgb(156, 5, 5)">Bilda Data terlalu Banyak dimungkingkan gagal untuk langsung unduh pdf bisa  melakukan preview pdf !!!</p>
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
       
       $('#opd_id ').select2({
       placeholder: "Pilih OPD",
       allowClear: true
   });
       $('#uppd_id ').select2({
       placeholder: "Pilih UPPD/Balai/UPT",
       allowClear: true
   });
   
       $('#gol_id ').select2({
       placeholder: "Golongan Retribusi",
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
   });
   
   const userLevel = @json(auth()->user()?->level ?? null);
        const allowedLevels = [1, 2, 3, 6]; // Level yang diperbolehkan

       $('#opd_id').on('input', function() {
           let opd_id = $(this).val();
           $('#uppd_id').empty().append('<option value="">-- Pilih UPPD/Balai/Satker --</option>');
   
           if (opd_id) {
               $.ajax({
                   url: `{{ url('/opd/uppd') }}/${opd_id}`,
                   type: 'GET',
                   success: function(data) {
                       // Cek apakah user level ada dalam daftar allowedLevels
                       if (allowedLevels.includes(userLevel)) {
                           $('#uppd_id').append(`<option value="0">Keseluruhan</option>`);
                       }
   
                       // Tambahkan data dari AJAX response
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
       
       $('#uppd_id').on('change', function() {
        $('#gol_id').select2('open');
                setTimeout(() => {
                    let searchField = document.querySelector('.select2-container--open .select2-search__field');
                    if (searchField) {
                        searchField.focus();
                    }
                }, 50);
    });
       </script>
@endpush