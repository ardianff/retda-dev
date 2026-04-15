@extends('template.master')

@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="{{route('opd.index')}}"> Pengumuman</a> </li>

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header with-border">
                <h5 class="mb-2">Pengumuman Management</h5>
                <button onclick="addForm('{{ route('pengumuman.store') }}')" class="btn btn-success btn-sm "><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>

                            <th style="text-align: center;" rowspan="2" width="5%">No</th>
                            <th style="text-align: center;" rowspan="2">Judul</th>
                            <th style="text-align: center;" rowspan="2">Deskripsi</th>
                            <th style="text-align: center;" colspan="2">Berlaku</th>
                            <th style="text-align: center;" rowspan="2" width="15%"><i class="fa fa-cog"></i></th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">Tgl Awal</th>
                            <th style="text-align: center;">Tgl Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengumuman as $item)
                            
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->judul}}</td>
                            <td>{{$item->deskripsi}}</td>
                            <td>{{tanggal_indonesia($item->tgl_awal)}}</td>
                            <td>{{tanggal_indonesia($item->tgl_akhir)}}</td>
                            <td>
                                <div class="btn-group">

                                    <a href="{{$item->link}}" class="btn btn-primary btn-sm" target="_blank" title="unduh/lihat dokumen"> <i class="fas fa-download"></i></a>
                <button onclick="editForm('{{ route('pengumuman.update',$item->id) }}')" class="btn btn-warning btn-sm " title="ubah"><i class="fa fa-edit"></i> </button>
                <button onclick="deleteForm('{{ route('pengumuman.destroy',$item->id) }}')" class="btn btn-danger btn-sm " title="hapus"><i class="fas fa-trash"></i> </button>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('pengumuman.form')
@endsection

@push('scripts')
<script>
    $(function () {
        $('#tgl_awal').datetimepicker({
        format: 'DD-MMMM-YYYY'
    });
        $('#tgl_akhir').datetimepicker({
        format: 'DD-MMMM-YYYY'
    });

    })
    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Pengumuman');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');

    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Pengumuman');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');



        $.get(url)
            .done((response) => {
                let tglAwalFormatted = moment(response.tgl_awal, 'YYYY-MM-DD').format('DD-MMMM-YYYY');
                let tglAkhirFormatted = moment(response.tgl_akhir, 'YYYY-MM-DD').format('DD-MMMM-YYYY');
                $('#modal-form [name=judul]').val(response.judul);
                $('#modal-form [name=deskripsi]').val(response.deskripsi);
                $('#modal-form [name=link]').val(response.link);
                $('#modal-form [name=tgl_awal]').val(tglAwalFormatted);
                $('#modal-form [name=tgl_akhir]').val(tglAkhirFormatted);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }

    function deleteForm(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    location.reload();
                    showMessage(response.type || 'success', response.message || 'Berhasil');
                })
                .fail((response) => {
                    showMessage(response.type || 'danger', response.message || 'Gagal Mengahpus data');
                    // return;
                });
        }
    }
</script>
@endpush
