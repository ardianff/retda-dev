@extends('template.master')

@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="{{route('uppd.index')}}"> UPPD/UPT/Balai</a> </li>

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header with-border">
                <h5 class="mb-4">UPPD/UPT/Balai Management</h5>
                <form action="{{route('uppd.index')}}" method="get" >
                    @csrf
                <div class="form-group row">
                    <label for="opd" class="col-md-2 ">Pilih OPD</label>
                    <div class="col-md-8">
                        <select id="opd" class="form-control " name="opd" onchange="this.form.submit();"  required >
                          <option value="">Keseluruhan</option>

                            @foreach ($opd as $item)
                            
                            <option @if ($id_opd==$item->id)
                                @selected(true)
                            @endif value="{{$item->id}}"> {{$item->opd}}</option>
                            @endforeach
                            
                            </select>
                    </div>
                </div>
                </form>
                <button onclick="addForm('{{ route('uppd.store') }}')" class="btn btn-success btn-sm "><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width="5%">ID</th>
                        <th width="5%">GRMS_ID</th>
                        <th>Nama UPPD/UPT/Balai</th>
                        <th>Singkatan UPPD/UPT/Balai</th>
                        <th>Status</th>
                        <th>OPD</th>
                        <th width="5%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('uppd.form')
@endsection

@push('scripts')
<script>
  $(function () {
        $('#tgl_aktif').datetimepicker({
        format: 'DD-MM-YYYY'
    });
        $('#tgl_nonaktif').datetimepicker({
        format: 'DD-MM-YYYY'
    });
    $('#opd ').select2({
    placeholder: "Pilih OPD",
    allowClear: true
});
    })
    $(document).ready(function () {
    // Default: Set status ke 'aktif' dan tampilkan hanya Tanggal Aktif
    

    // Event listener untuk perubahan status
    $("input[name='status']").change(function () {
        if ($("#aktif").is(":checked")) {
            $("#tgl_aktif").closest('.row').show();
            $("#tgl_nonaktif").closest('.row').hide();
        } else if ($("#nonaktif").is(":checked")) {
            $("#tgl_aktif").closest('.row').hide();
            $("#tgl_nonaktif").closest('.row').show();
        }
    });
});

$(function () {
    $('#opd_id ').select2({
    dropdownParent: $("#modal-form"),
    placeholder: "Pilih OPD",
    allowClear: true
});
    });
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('uppd.data',$id_opd) }}',
            },
            columns: [
                {data: 'id_penari'},
                {data: 'id_grms'},
                {data: 'nama'},
                {data: 'singkatan'},
                {data: 'status'},
                {data: 'opd'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });


    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah UPPD/Balai/UPT');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $("#modal-form #aktif").prop("checked", true);
        $("#modal-form #tgl_aktif").closest('.row').show();
        $("#modal-form #tgl_nonaktif").closest('.row').hide();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit UPPD/Balai/UPT');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');



        $.get(url)
            .done((response) => {
                let tglAktifFormatted = response.tgl_aktif ? moment(response.tgl_aktif, 'YYYY-MM-DD').format('DD-MM-YYYY') : '';
                let tglNonAktifFormatted = response.tgl_nonaktif ? moment(response.tgl_nonaktif, 'YYYY-MM-DD').format('DD-MM-YYYY') : '';
                $('#modal-form [name=opd_id]').val(response.opd_id).trigger('change');
                $('#modal-form [name=nama]').val(response.nama);
                $('#modal-form [name=singkatan]').val(response.singkatan);
                $('#modal-form [name=id_penari]').val(response.id_penari);
                $('#modal-form [name=id_grms]').val(response.id_grms);
                $('#modal-form [name=kode]').val(response.kode);

                $('#modal-form [name=status]').prop('checked', false); // Reset dulu
                $('#modal-form [name=status][value="' + response.status + '"]').prop('checked', true);
                
                // Set tanggal
                $('#modal-form [name=tgl_aktif]').val(tglAktifFormatted);
                $('#modal-form [name=tgl_nonaktif]').val(tglNonAktifFormatted);

                // Pengkondisian untuk menampilkan tanggal yang sesuai
                if (response.status === 'aktif') {
                    $("#tgl_aktif").closest('.row').show();
                    $("#tgl_nonaktif").closest('.row').hide();
                } else if (response.status === 'nonaktif') {
                    $("#tgl_aktif").closest('.row').hide();
                    $("#tgl_nonaktif").closest('.row').show();
                }

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
