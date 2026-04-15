@extends('template.master')

@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="{{route('jenis.index')}}"> Jenis Retribusi</a> </li>

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header with-border">
                <h5 class="mb-2">Jenis Retribusi </h5>
                <button onclick="addForm('{{ route('jenis.store') }}')" class="btn btn-success btn-sm "><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width="5%">ID</th>
                        <th width="5%">ID GRMS</th>
                        <th> Jenis Retribusi</th>
                        <th>Singkatan Jenis Retribusi</th>
                        <th>Golongan</th>
                        <th>Status</th>
                        <th width="5%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('jenis.form')
@endsection

@push('scripts')
<script>
$(function () {
    $('#golongan_id').select2({
        dropdownParent: $("#modal-form"),
    placeholder: "Pilih Golongan",
    allowClear: true
});
})

    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('jenis.data') }}',
            },
            columns: [
                {data: 'id_sipenari'},
                {data: 'grms_id'},
                {data: 'name'},
                {data: 'singkatan'},
                {data: 'golongan'},
                {data: 'status'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });


    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Jenis Retribusi');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');

    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Jenis Retribusi');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');



        $.get(url)
            .done((response) => {
                $('#modal-form [name=golongan_id]').val(response.golongan_id).trigger('change');
                $('#modal-form [name=kode]').val(response.kode);
                $('#modal-form [name=name]').val(response.name);
                $('#modal-form [name=singkatan]').val(response.singkatan);
                $('#modal-form [name=id_sipenari]').val(response.id_sipenari);
                $('#modal-form [name=grms_id]').val(response.grms_id);
                 $('#modal-form [name=status]').prop('checked', false); // Reset dulu
                $('#modal-form [name=status][value="' + response.status + '"]').prop('checked', true);
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
