@extends('template.master')
@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="#!">Dashboard</a> </li>

@endsection

@section('content')
<div class="row">
  <div class="col-lg-12 col-md-12">
    {{-- <div class="row">
      <div class="col-md-6"> --}}
        @foreach ($pengumuman as $item)
            
        <div class="card">
          <div class="card-header card-primary card-outline ">
           <h4>{{$item->judul}}</h4>
          </div>
          <div class="card-body">
            <p>{{$item->deskripsi}}</p>
            <a href="{{$item->link}}" target="_blank" class="btn btn-primary btn-sm float-right"><i class="fas fa-external-link-alt"></i>Lihat Dokumen</a>
          </div>
          <div class="card-footer">
            <h6>Berlaku</h6>
           <div class=""> &nbsp;<span class=" mr-3 text-success"><i class="far fa-calendar-alt"></i>{{tanggal_indonesia($item->tgl_awal)}}</span> - <span class="ml-3 text-success"><i class="far fa-calendar-alt"></i>{{tanggal_indonesia($item->tgl_akhir)}}</span></div>
          </div>
        </div>
        @endforeach
      {{-- </div>
    </div> --}}
    
  </div>
</div>


@endsection
