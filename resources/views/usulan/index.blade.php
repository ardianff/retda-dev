@extends('template.master')
@section('title', 'Usulan Tarif | E-Tarif RETDA')

@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="{{route('usulan.index')}}">Usulan Tarif</a> </li>

@endsection
@push('css')
    <style>
         .hidden {
      display: none;
    }
    /* .sticky-column {
  position: sticky;
  right: 0;
  background: white;
  z-index: 2;
} */


    </style>
@endpush

@section('content')
<div id="ajax-alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-dark">Filter Tarif</div>
            <div class="card-body">
                <form action="{{route('usulan.index')}}" method="get" >
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Usulan Periode</label>
                                <div class="col-md-8">
                                    <select id="tu_id" class="form-control " name="tu_id" required>
                                        <option selected  value="{{$tu->id}}">{{$tu->deskripsi}}</option>
                                        
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Pilih OPD</label>
                                <div class="col-md-8">
                                    <select id="opd_id" class="form-control " name="opd_id" required>
                                        @foreach ($opd as $item)
                                            
                                        <option {{ $item->id == $opd_id ? 'selected' : '' }}  value="{{$item->id}}"> {{$item->opd}}</option>
                                        @endforeach 
                                        
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Pilih UPPD/BALAI/SATKER</label>
                                <div class="col-md-8">
                                    <select id="uppd_id" class="form-control " name="uppd_id" required>
                                      
            
                                        @foreach ($uppd as $item)
                                        
                                        <option {{ $item->id == $uppd_id ? 'selected' : '' }}  value="{{$item->id}}"> {{$item->nama}}</option>
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
                                        @foreach ($golongan as $item)                            
                                        <option {{ $item->id == $gol_id ? 'selected' : '' }}  value="{{$item->id}}"> {{$item->name}}</option>
                                        @endforeach
                                        
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Jenis Retribusi</label>
                                <div class="col-md-8">
                                    <select id="jenis_id" class="form-control " name="jenis_id" required>
                                        @foreach ($jenis as $item)                            
                                        <option {{ $item->id == $jenis_id ? 'selected' : '' }}  value="{{$item->id}}"> {{$item->name}}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-9"></div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-success btn-sm ">Tampilkan <i class="fas fa-search fa-md"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-header with-border ">
    <h3 class="text-center">{{$opd_h->opd}}</h3>
    <h5 class="text-center">{{$uppd_h->nama}}</h5>
   <h3 class="text-center">{{$gol_h->name}}</h3>
   <h5 class="text-center">{{$jenis_h->name}}</h5>

    
    <button onclick="addheader(0)" class="btn btn-success btn-sm float-right" title="Tambah Jenis Layanan"><i class="fa fa-plus-circle"></i> Tambah</button>
</div>
<div class="card-body" >
    <div class="table-responsive" style="overflow-x: auto;">

    <table class="table table-striped " id="table-tarif" >
        <thead>
            <tr class="">
                <th style="min-width: 100px;">No</th>
                <th style="min-width: 280px;">Uraian</th>
                <th >Satuan</th>
                @if ($jenis_id==16)
                    
                <th>Jasa Sarana</th>
                <th>Jasa Layanan</th>
                @endif
                <th>Semula</th>
                @if ($jenis_id==16)
                    
                <th>Jasa Sarana</th>
                <th>Jasa Layanan</th>
                @endif
                <th>Menjadi</th>
                <th >ID Epen</th>
                <th style="width: 40px;">Status</th>
                <th style="min-width: 130px;" >Aksi</th>
            </tr>
        </thead>
    </table>
</div>
</div>
</div>
</div>
</div>

@includeIf('usulan.form.form')
@includeIf('usulan.form.form-editkode')
@includeIf('usulan.form.form-header')
@includeIf('usulan.form.form-tarif')
@includeIf('usulan.form.editFormTarif')
@includeIf('usulan.formPindahTarif')
@includeIf('usulan.formPindahHeaderTarif')
@includeIf('usulan.copyHeaderUsulan')
@includeIf('usulan.copyChildUsulan')
@include('usulan.js.data')
@include('usulan.js.aksi')
@include('usulan.js.pindah')
@include('usulan.js.copy')
@endsection

@push('scripts')
<script>




</script>
@endpush
