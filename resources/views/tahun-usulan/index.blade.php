@extends('template.master')

@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="{{route('TA.index')}}"> Copy DB tarif</a> </li>

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card p-4">
            <div class="card-header">
                <h5 class="text-center">Pembuatan Database Pengolahan Data Usulan Tarif Retda</h5>
            </div>
            <div class="card-body">
                <form action="{{route('tahun-usulan.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data" >
                    @csrf
                <div class="row mb-2">
                    <div class="col-md-5">
                        <label for="tahun" class="form-label">Pergub Tarif Asal</label>
                            <select name="tahun" id="tahun" class="form-control" required>
                                @foreach ($thn as $item)
                                    <option value="{{$item->id}}">{{$item->tahun}} || {{$item->peraturan}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-5">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <input type="text" name="deskripsi" id="deskripsi" class="form-control" required>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5"></div>
                    <div class="col-md-2"><button type="submit" class="btn btn-warning btn-sm text-center" style="margin-left:3rem">Proses</button></div>
                    <div class="col-md-5"></div>
                </div>
            </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header with-border">
                <h5 class="mb-2">Tabel Pergub tarif</h5>
               
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th>Nama Database</th>
                        <th width="15%">Tahun Asal</th>
                        <th>Deskripsi</th>
                        
                    </thead>
                    <tbody>
                        @foreach ($usulan as $item)
                            <tr>
                                <td>{{$item->kode}}</td>
                                <td>{{$item->tahun}}</td>
                                <td>{{$item->deskripsi}}</td>
                                {{-- <td>{{$item->status}}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('TA.form')
@endsection

@push('scripts')

@endpush
