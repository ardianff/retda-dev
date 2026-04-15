@extends('template.master')

@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="{{route('TA.index')}}">Penetapan Tarif</a> </li>

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header with-border">
                <h3 class="mb-2">Penetapan Tarif</h3>
                <a href="{{ route('TA.create') }}" class="btn btn-success btn-sm "><i class="fa fa-plus-circle"></i> Penetapan</a>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width="15%">Tahun Terbit</th>
                        <th>Deskripsi</th>
                        <th>Peraturan Pemerintah</th>
                        <th width="7%">tgl. Terbit</th>
                        <th width="7%">tgl. Berlaku</th>
                        <th>Status</th>
                        <th width="5%">Aksi</th>
                    </thead>
                </table>
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
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('TA.data') }}',
            },
            columns: [
                {data: 'tahun'},
                {data: 'deskripsi'},
                {data: 'perihal'},
                {data: 'tgl_terbit'},
                {data: 'tgl_berlaku'},
                {data: 'status'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });


    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Tahun Anggaran');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');

    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Tahun Anggaran');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);


        $.get(url)
            .done((response) => {
                $('#modal-form [name=tahun]').val(response.tahun);
                $('#modal-form [name=deskripsi]').val(response.deskripsi);
                $('#modal-form [name=peraturan]').val(response.peraturan);
                $('#modal-form [name=tgl_terbit]').val(response.tgl_terbit);
                $('#modal-form [name=tgl_berlaku]').val(response.tgl_berlaku);
                let displayFileName = response.file.replace('uploads', '...');
        $('#modal-form #filename').text(displayFileName);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }

    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }
</script>
@endpush
