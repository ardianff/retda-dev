@extends('template.master')

@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="{{route('pengajuan.index')}}"> Set Tanggal Pengajuan</a> </li>

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header with-border">
                <h5 class="mb-2 text-center">Set Tanggal Entri Usulan Tarif</h5>
                <button onclick="addForm('{{ route('pengajuan.store') }}')" class="btn btn-success btn-sm "><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width="5%">Tahun</th>
                        <th>Deskripsi</th>
                        <th>tgl Awal</th>
                        <th>tgl Akhir</th>
                        <th>Status</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('pengajuan.form')
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
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('pengajuan.data') }}',
            },
            columns: [
                {data: 'tahun'},
                {data: 'deskripsi'},
                {data: 'tgl_awal'},
                {data: 'tgl_akhir'},
                {data: 'status'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });


    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Buka Usulan Tarif');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form #all').prop('checked',true);
        $('#modal-form .opd-checkbox').prop('checked',true);

    }

    function editForm(url) {
    $('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Edit Usulan Tarif');

    $('#modal-form form')[0].reset();
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('put');

    $.get(url)
        .done((response) => {
            let pengajuan = response.pengajuan;
            let selectedOpd = response.selectedOpd; // Daftar OPD yang terpilih

            // Format tanggal dengan Moment.js
            let tglAwalFormatted = moment(pengajuan.tgl_awal, 'YYYY-MM-DD').format('DD-MMMM-YYYY');
            let tglAkhirFormatted = moment(pengajuan.tgl_akhir, 'YYYY-MM-DD').format('DD-MMMM-YYYY');

            // Isi data pada modal
            $('#modal-form [name=tahun]').val(pengajuan.tu_id).prop('disabled', true);
            $('#modal-form [name=deskripsi]').val(pengajuan.deskripsi);
            // $('#modal-form [name=pilih_opd]').val(pengajuan.pilihan).prop('checked',true);
$('#modal-form [name=pilih_opd][value="' + pengajuan.pilihan + '"]').prop('checked', true);

            $('#modal-form [name=tgl_awal]').val(tglAwalFormatted);
            $('#modal-form [name=tgl_akhir]').val(tglAkhirFormatted);

            // Atur checkbox OPD
            $('.opd-checkbox').prop('checked', false); // Uncheck semua dulu
            selectedOpd.forEach(id => {
                $('#opd-' + id).prop('checked', true); // Centang yang sesuai
            });

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
    function updateStatus(id, status) {
    $.ajax({
        url: {!! json_encode(route('pengajuan.updateStatus')) !!},
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id,
            status: status
        },
        success: function (response) {
            table.ajax.reload();
            console.log('Status updated:', response);
        }
    });
}
</script>
<script>
    $(document).ready(function () {
        // Default: Semua OPD dipilih dan semua checkbox tercentang
        $(' .opd-checkbox').prop('checked', true);

        // Event ketika radio button berubah
        $('input[name="pilih_opd"]').change(function () {
            if ($('#all').is(':checked')) {
                $('.opd-checkbox').prop('checked', true); // Centang semua checkbox
            } else {
                $('.opd-checkbox').prop('checked', false); // Uncheck semua checkbox
            }
        });
    });
</script>
@endpush
