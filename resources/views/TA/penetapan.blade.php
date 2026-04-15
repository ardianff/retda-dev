@extends('template.master')

@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="{{route('TA.index')}}"> Penetapan Usulan Tarif</a> </li>

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card p-4">
            <div class="card-header">
                <h5 class="text-center">Penetapan Usulan Tarif Retda</h5>
            </div>
            <div class="card-body">
                <form action="{{route('TA.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data" >
                    @csrf
                    <div class="row mb-3">
                        <label for="tu_id" class="col-sm-3 col-form-label">Pilih Usulan Tarif</label>
                        <div class="col-sm-9">
                            <select name="tu_id" id="tu_id" class="form-control" required>
                               
                                <option value="{{$usulan->id}}">{{$usulan->tahun}} || {{$usulan->deskripsi}}</option>
                        </select>
                        </div>
                    </div>
               
                <div class="row mb-3">
                    <label for="tahun" class="col-sm-3 col-form-label">tahun</label>
                    <div class="col-sm-9">
                        <input type="text" name="tahun" id="tahun" class="form-control" required >
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="perihal" class="col-sm-3 col-form-label">Perihal</label>
                    <div class="col-sm-9">
                        <input type="text" name="perihal" id="perihal" class="form-control" required >
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="deskripsi" class="col-sm-3 col-form-label">deskripsi</label>
                    <div class="col-sm-9">
                        <input type="text" name="deskripsi" id="deskripsi" class="form-control" required autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tgl_terbit" class="col-sm-3 col-form-label">Tgl terbit</label>
                    <div class="col-sm-9">


                        <div class="input-group date" id="tgl_terbit" data-target-input="nearest">
                            <div class="input-group-append" data-target="#tgl_terbit" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input type="text" class="form-control datetimepicker-input" data-target="#tgl_terbit" name="tgl_terbit"/>
                        </div>
                    </div>


                </div>
                <div class="row mb-3">
                    <label for="tgl_berlaku" class="col-sm-3 col-form-label">Tgl Berlaku</label>
                    <div class="col-sm-9">


                        <div class="input-group date" id="tgl_berlaku" data-target-input="nearest">
                            <div class="input-group-append" data-target="#tgl_berlaku" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input type="text" class="form-control datetimepicker-input" data-target="#tgl_berlaku" name="tgl_berlaku"/>
                        </div>
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
        
    </div>
</div>

@includeIf('TA.form')
@endsection

@push('scripts')
<script>
    $(function () {
        $('#tgl_terbit').datetimepicker({
        format: 'YYYY-MM-DD'
    });
        $('#tgl_berlaku').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    })
</script>
@endpush
