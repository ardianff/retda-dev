@extends('template.master')

@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="{{route('tarif.index')}}"> Tarif</a> </li>

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
            <div class="card-header bg-dark">Filter Tarif</div>
            <div class="card-body">
                <form action="{{route('tarif.index')}}" method="get" >
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Pilih Tahun</label>
                                <div class="col-md-8">
                                    <select id="thn_id" class="form-control " name="thn_id" required>
                                        @foreach ($TA as $item)
                                        
                                        <option {{ $item->id == $thn_id ? 'selected' : '' }}  value="{{$item->id}}">Tahun {{$item->tahun}}</option>
                                        @endforeach
                                        
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Pilih OPD</label>
                                <div class="col-md-8">
                                    <select id="opd_id" class="form-control " name="opd_id"  required>
                                       
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
                                <div class="col-md-10"></div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success btn-sm btn-flat">Filter <i class="fas fa-search fa-md"></i></button>
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

    
    <button onclick="addheader(0)" class="btn btn-success btn-sm float-right"><i class="fa fa-plus-circle"></i> Tambah</button>
</div>
<div class="card-body" >
    <div class="table-responsive" style="overflow-x: auto;">

        <table class="table table-striped " id="table-tarif" >
            <thead>
            <tr class="py-4">
                <th style="min-width:100px">Kode</th>
                <th style="min-width:250px">Uraian</th>
                <th>Satuan</th>
                @if ($jenis_id==16)
                <th>Sarana</th>
                <th>Layanan</th>
                    
                @endif
                <th>Tarif</th>
                <th>grms</th>
                <th style="min-width:150px">Aksi</th>
                {{-- <th style="width:10%">Keterangan</th> --}}
            </tr>
        </thead>
    </table>
</div>
    
</div>
</div>
</div>
</div>

@includeIf('tarif.form')
@includeIf('tarif.form-header')
@includeIf('tarif.form-tarif')
@includeIf('tarif.editFormTarif')
@includeIf('tarif.formPindahTarif')
@includeIf('tarif.formPindahHeaderTarif')
@endsection

@push('scripts')
<script>
let table;

$(function () {
    let columns = [
    {data: 'tree', orderable: false, searchable: false},
    {data: 'uraian'},
    {data: 'satuan'},
];

// Tambahkan kolom jika `jenis_id == 16`
if ({{ $jenis_id }} == 16) {
    columns.push({data: 'sarana'});
    columns.push({data: 'layanan'});
}

columns.push({data: 'nilai'});
columns.push({data: 'grms_id'});
columns.push({data: 'aksi', orderable: false, searchable: false});

// Inisialisasi DataTable
 table = $('#table-tarif').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: {!! json_encode(route('tarif.data', [$opd_id, $uppd_id, $gol_id, $jenis_id, $thn_id])) !!},
        data: function (d) {
            d.parent_id = 0; // Memuat data utama dulu
            console.log(d);
        }
    },
    columns: columns,

        rowCallback: function (row, data) {
            $(row).attr({
                'data-id': data.id,
                'data-parent-id': data.parent_id
            });

            if (data.open === 1) { 
                fetchChildRows(data.id);
            }
}
    });

    // Event delegation untuk toggle-tree
    $('#table-tarif tbody').on('click', '.toggle-tree', function () {
        let icon = $(this);
        let parentId = icon.data('id');
        let row = icon.closest('tr');

        if (icon.hasClass('fa-chevron-circle-right')) {
            icon.removeClass('fa-chevron-circle-right').addClass('fa-chevron-circle-down');

            if ($(`tr[data-parent-id="${parentId}"]`).length > 0) {
                $(`tr[data-parent-id="${parentId}"]`).show();
            } else {
                row.after(`<tr data-parent-id="${parentId}" class="loading-row"><td colspan="6">Loading...</td></tr>`);
                fetchChildRows(parentId);
            }

            updateOpenStatus(parentId, 1);
        } else {
            icon.removeClass('fa-chevron-circle-down').addClass('fa-chevron-circle-right');
            hideChildren(parentId);
            updateOpenStatus(parentId, 0);
        }
    });

   

});

// Fungsi untuk mengambil child row
function fetchChildRows(parentId, level = 1) {
    $.ajax({
        url: {!! json_encode(route('tarif.data', [$opd_id, $uppd_id, $gol_id, $jenis_id, $thn_id])) !!},
        data: { parent_id: parentId },
        success: function (response) {
            console.log(response.data);
            response.data.sort((a, b) => a.number.localeCompare(b.number, undefined, { numeric: true }));

            $('tr.loading-row[data-parent-id="' + parentId + '"]').remove(); // Hapus loading row jika ada

            response.data.reverse().forEach(function (child) {
                let toggleIcon = child.has_children 
                    ? `<i class="fa fa-chevron-circle-right toggle-tree" data-id="${child.id}"></i> ${child.number}` 
                    : child.number;

                // Buat baris tabel dasar
                let newRow = `
                    <tr data-id="${child.id}" data-parent-id="${parentId}" class="child-row parent-${parentId}" style="display: none;">
                        <td style="padding-left: ${level * 40}px">${toggleIcon}</td>
                        <td>${child.uraian}</td>
                        <td>${child.satuan ? child.satuan : ''}</td>`;

                // Jika jenis_id == 16, tambahkan kolom "Sarana" dan "Layanan"
                @if ($jenis_id == 16)
                    newRow += `<td>${child.sarana ? child.sarana : ''}</td>
                               <td>${child.layanan ? child.layanan : ''}</td>`;
                @endif

                newRow += `<td>${child.nilai}</td>
                           <td>${child.grms_id}</td>
                           <td>${child.aksi}</td>
                    </tr>`;

                // Tambahkan ke tabel setelah parent
                $('tr[data-id="' + parentId + '"]').after(newRow);
                $('tr[data-id="' + child.id + '"]').fadeIn();

                // Jika ada anaknya, lanjutkan rekursi
                if (child.open === 1) {
                    fetchChildRows(child.id, level + 1);
                }
            });
        }
    });
}



// Fungsi untuk menutup semua anak
function hideChildren(parentId) {
    $(`tr[data-parent-id="${parentId}"]`).each(function () {
        let childId = $(this).attr('data-id');
        $(this).fadeOut();
        hideChildren(childId);
    });
}

// Update status "open" di database
function updateOpenStatus(id, status) {
    $.ajax({
        url: {!! json_encode(route('tarif.updateOpenStatus')) !!},
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id,
            open: status
        },
        success: function (response) {
            console.log('Status updated:', response);
        }
    });
}
function updateStatus(id, status) {
    $.ajax({
        url: {!! json_encode(route('tarif.updateStatus')) !!},
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








$(function () {
    $('#form_tarif').on('click', function () {
    // Submit the form with ID 'myForm'
    $('#tarifFormBody').submit();
    });
    $('.uang').mask('0.000.000.000.000',{reverse:true});

    $('#opd_id ').select2({
    placeholder: "Pilih OPD",
    allowClear: true
});
    $('#opd-headertarif-tujuan').select2({
    dropdownParent: $("#modal-pindahHeaderTarif"),
    placeholder: "Pilih OPD",
    allowClear: true
});
    $('#balai-headertujuan').select2({
    dropdownParent: $("#modal-pindahHeaderTarif"),
    placeholder: "Pilih UPPD/Balai/Satker",
    allowClear: true
});
    $('#opd-tarif-tujuan').select2({
    dropdownParent: $("#modal-pindahTarif"),
    placeholder: "Pilih UPPD/Balai/Satker",
    allowClear: true
});
    $('#balai-tujuan').select2({
    dropdownParent: $("#modal-pindahTarif"),
    placeholder: "Pilih UPPD/Balai/Satker",
    allowClear: true
});
    $('#uppd_id ').select2({
    placeholder: "Pilih Balai/UPPD/Satker",
    allowClear: true
});
    $('#jenis_id ').select2({
    placeholder: "Pilih Jenis Retribusi",
    allowClear: true
});
    $('#gol_id ').select2({
    placeholder: "Pilih Golongan Retribusi",
    allowClear: true
});
    $('#satuan_id ').select2({
    dropdownParent: $("#modalFormTarif"),
    placeholder: "Pilih satuan tarif",
    allowClear: true
});
    $('#rekening ').select2({
    dropdownParent: $("#modalFormTarif"),
    placeholder: "Pilih rekening tarif",
    allowClear: true
});
    $('#edit_satuan ').select2({
    dropdownParent: $("#modal-editform"),
    placeholder: "Pilih satuan tarif",
    allowClear: true
});
    $('#edit_rekening ').select2({
    dropdownParent: $("#modal-editform"),
    placeholder: "Pilih rekening tarif",
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

  $('input[name="format_tarif"]').on('change', function () {
    const selected = $('input[name="format_tarif"]:checked').val();

    if (selected === 'rupiah') {
        $('#nilai, #sarana, #layanan').show().prop('disabled', false);
        $('#bkn_nilai').hide().val('');
    } else if (selected === 'bukan_rupiah') {
        $('#nilai, #sarana, #layanan').show().prop('disabled', false);
        $('#bkn_nilai').show().prop('disabled', false);
    } else if (selected === 'up') {
        $('#nilai, #sarana, #layanan').val('0').prop('disabled', true);
        $('#bkn_nilai').hide().val('');
    }
});
    $('input[name="edit_format_tarif"]').on('change', function () {
    const selected = $('input[name="edit_format_tarif"]:checked').val();

    if (selected === 'rupiah') {
        $('#edit_nilai, #edit_sarana, #edit_layanan').show().prop('disabled', false);
        $('#edit_bkn_nilai').hide().val('');
    } else if (selected === 'bukan_rupiah') {
        $('#edit_nilai, #edit_sarana, #edit_layanan').show().prop('disabled', false);
        $('#edit_bkn_nilai').show().prop('disabled', false);
    } else if (selected === 'up') {
        $('#edit_nilai, #edit_sarana, #edit_layanan').val('0').prop('disabled', true);
        $('#edit_bkn_nilai').hide().val('');
    }
});

      $('#opd_id').on('input', function() {
            let opd_id = $(this).val();
            $('#uppd_id').empty().append('<option value="">-- Pilih UPPD/Balai/Satker --</option>');

            if (opd_id) {
                $.ajax({
                    url: `{{ url('/opd/uppd') }}/${opd_id}`,
                    type: 'GET',
                    success: function(data) {
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
                        alert('Gagal mengambil data  Balai.');
                    }
                });
            }
        });
      $('#opd-headertarif-tujuan').on('input', function() {
            let opd_id = $(this).val();
            $('#balai-headertujuan').empty().append('<option value="">-- Pilih UPPD/Balai/Satker --</option>');

            if (opd_id) {
                $.ajax({
                    url: `{{ url('/opd/uppd') }}/${opd_id}`,
                    type: 'GET',
                    success: function(data) {
                        data.forEach(function(uppd) {
                            $('#balai-headertujuan').append(`<option value="${uppd.id}">${uppd.nama}</option>`);
                        });
                        $('#balai-headertujuan').select2('open');
                setTimeout(() => {
                    let searchField = document.querySelector('.select2-container--open .select2-search__field');
                    if (searchField) {
                        searchField.focus();
                    }
                }, 50);
                    },
                    error: function() {
                        alert('Gagal mengambil data  Balai.');
                    }
                });
            }
        });
      $('#opd-tarif-tujuan').on('input', function() {
            let opd_id = $(this).val();
            $('#balai-tujuan').empty().append('<option value="">-- Pilih UPPD/Balai/Satker --</option>');

            if (opd_id) {
                $.ajax({
                    url: `{{ url('/opd/uppd') }}/${opd_id}`,
                    type: 'GET',
                    success: function(data) {
                        data.forEach(function(uppd) {
                            $('#balai-tujuan').append(`<option value="${uppd.id}">${uppd.nama}</option>`);
                        });
                        $('#balai-tujuan').select2('open');
                setTimeout(() => {
                    let searchField = document.querySelector('.select2-container--open .select2-search__field');
                    if (searchField) {
                        searchField.focus();
                    }
                }, 50);
                    },
                    error: function() {
                        alert('Gagal mengambil data  Balai.');
                    }
                });
            }
        });
$('#gol_id').on('change', function() {
            let gol = $(this).val();
            $('#jenis_id').empty().append('<option value="">-- Pilih Jenis Retribusi --</option>');

            if (gol) {
                $.ajax({
                    url: `{{ url('/golongan/jenis') }}/${gol}`,
                    type: 'GET',
                    success: function(data) {
                        data.forEach(function(jenis) {
                            $('#jenis_id').append(`<option value="${jenis.id}">${jenis.name}</option>`);
                        });
                        $('#jenis_id').select2('open');
                setTimeout(() => {
                    let searchField = document.querySelector('.select2-container--open .select2-search__field');
                    if (searchField) {
                        searchField.focus();
                    }
                }, 50);
                    },
                    error: function() {
                        alert('Gagal mengambil data  Balai.');
                    }
                });
            }
        });


});
   

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form form')[0].reset();
        $('#modal-form .modal-title').text('Tambah Retribusi');

    $.get(url)
            .done((response) => {
                let header=(response.number+' > ' + response.uraian +' > ')
                $('#modal-form [id=parent_id_header]').val(response.id);
                $('#modal-form [id=tahun]').val(response.ta_id);
                $('#modal-form [id=header]').val(header);
                $('#modal-form [name=opd]').val(response.opd_id);
                $('#modal-form [name=balai]').val(response.uppd_id);
                $('#modal-form [name=golongan]').val(response.golongan_id);
                $('#modal-form [name=jenis]').val(response.jenis_id);
                $('#modal-form [id=opd]').val(response.opd_id).trigger('change');
                $('#modal-form [id=balai]').val(response.uppd_id).trigger('change');
                $('#modal-form [id=golongan]').val(response.golongan_id).trigger('change');
                $('#modal-form [id=jenis]').val(response.jenis_id).trigger('change');
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });

    }
    function addheader() {
        $('#modal-header').modal('show');
        $('#modal-header form')[0].reset();
        $('#modal-header .modal-title').text('Tambah Retribusi');

   

    }

    function addFormChild(button) {
        let url = $(button).data('url');
        $('#modal-form').modal('show');
        $('#modal-form form')[0].reset();
        $('#modal-form .modal-title').text('Tambah Retribusi');

    $.get(url)
            .done((response) => {
                $('#modal-form [id=parent_id_header]').val(response.id);
                $('#modal-form [id=tahun]').val(response.ta_id);
                $('#modal-form [name=opd]').val(response.opd_id);
                $('#modal-form [name=balai]').val(response.uppd_id);
                $('#modal-form [name=golongan]').val(response.golongan_id);
                $('#modal-form [name=jenis]').val(response.jenis_id);
                $('#modal-form [id=opd]').val(response.opd_id).trigger('change');
                $('#modal-form [id=balai]').val(response.uppd_id).trigger('change');
                $('#modal-form [id=golongan]').val(response.golongan_id).trigger('change');
                $('#modal-form [id=jenis]').val(response.jenis_id).trigger('change');
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });

    }

//     function addHeader(parentId) {
//     $('#modalFormHeader').modal('show');
//     $('#parent_id_header').val(parentId); // Set parent ID di modal header
// }

function addBody(url) {
    $('#modalFormTarif').modal('show');
    $('#modalFormTarif form')[0].reset();

    $('#modalFormTarif .modal-title').text('Tambah Tarif Retribusi');
    $.get(url)
            .done((response) => {
                let header=('kode : '+response.number+' > ' + response.uraian +' > ')
                $('#modalFormTarif [id=parent_id_body]').val(response.id);
                $('#modalFormTarif [id=header]').val(header);
                $('#modalFormTarif [id=tahun]').val(response.ta_id);
                $('#modalFormTarif [name=opd]').val(response.opd_id);
                $('#modalFormTarif [name=balai]').val(response.uppd_id);
                $('#modalFormTarif [name=golongan]').val(response.golongan_id);
                $('#modalFormTarif [name=jenis]').val(response.jenis_id);

                $('#modalFormTarif [id=opd-tarif]').val(response.opd_id).trigger('change');
                $('#modalFormTarif [id=balai-tarif]').val(response.uppd_id).trigger('change');
                $('#modalFormTarif [id=golongan-tarif]').val(response.golongan_id).trigger('change');
                $('#modalFormTarif [id=jenis-tarif]').val(response.jenis_id).trigger('change');
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });

 
}


    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit User');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');



        $.get(url)
            .done((response) => {
                let header = '';
                if (response.parent_id != 0) {
                    header = response.parent.number + ' : ' + response.parent.uraian + ' > ';
                } else {
                    header = response.number + ' : ' + response.uraian + ' > ';
                }

                $('#modal-form [id=header]').val(header);
                $('#modal-form [id=opd]').val(response.opd_id).trigger('change');
                $('#modal-form [id=balai]').val(response.uppd_id).trigger('change');
                $('#modal-form [id=golongan]').val(response.golongan_id).trigger('change');
                $('#modal-form [id=jenis]').val(response.jenis_id).trigger('change');
                $('#modal-form [id=uraian]').val(response.uraian);
                $('#modal-form [id=keterangan]').val(response.keterangan);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }
    function editFormbody(url, url1) {
    $('#modal-editform').modal('show');
    $('#modal-editform .modal-title').text('Edit form tarif');

    $('#modal-editform form')[0].reset();
    $('#modal-editform form').attr('action', url1);
    $('#modal-editform [name=_method]').val('put');

    $.get(url)
        .done((response) => {
            $('#modal-editform [id=ID]').val(response.id);
            let header = '';

            if (response.parent_id != 0) {
                header = response.parent.number + ' : ' + response.parent.uraian + ' > ';
            } else {
                header = response.number + ' : ' + response.uraian + ' > ';
            }
            // let header = 'kode : ' + response.number + ' > ' + response.uraian + ' > ';
            let nilaiFormatted = Number(response.nilai).toLocaleString('id-ID');
            let saranaFormatted = Number(response.tarif_sarana).toLocaleString('id-ID');
            let layananFormatted = Number(response.tarif_layanan).toLocaleString('id-ID');

            $('#modal-editform [id=header]').val(header);
            $('#modal-editform [id=opd-tarif]').val(response.opd_id).trigger('change');
            $('#modal-editform [id=balai-tarif]').val(response.uppd_id).trigger('change');
            $('#modal-editform [id=golongan-tarif]').val(response.golongan_id).trigger('change');
            $('#modal-editform [id=jenis-tarif]').val(response.jenis_id).trigger('change');

            $('#modal-editform [id=edit_uraian]').val(response.uraian);
            $('#modal-editform [id=edit_satuan]').val(response.satuan_id).trigger('change');
            $('#modal-editform [id=edit_rekening]').val(response.rekening_id).trigger('change');
                $('#modal-editform [id=keterangan]').val(response.keterangan);
                $('#modal-editform [id=edit_format_tarif]').val(response.format_tarif).trigger('change');

                 $('#modal-editform [id=edit_nilai]').val(nilaiFormatted);
                $('#modal-editform [id=edit_sarana]').val(saranaFormatted);
                $('#modal-editform [id=edit_layanan]').val(layananFormatted);


            // Kondisi jika bukan_nilai == 1
             switch (response.format_tarif) {
    case 'rupiah':
        $('#edit_rupiah').prop('checked', true);
        break;
    case 'bukan_rupiah':
        $('#edit_bukan_nilai').prop('checked', true);
        $('#edit_bkn_nilai').show().val(response.bukan_nilai);
        break;
    case 'up':
        $('#edit_up').prop('checked', true);
        $('#edit_bkn_nilai').hide().val(response.bukan_nilai);
        $('#modal-editform [id=edit_nilai]').prop('disabled',true).val(nilaiFormatted);
                $('#modal-editform [id=edit_sarana]').prop('disabled',true).val(saranaFormatted);
                $('#modal-editform [id=edit_layanan]').prop('disabled',true).val(layananFormatted);

        break;
    default:
        // Fallback jika tidak ada yang cocok
        $('#edit_rupiah').prop('checked', true);
}

        })
        .fail((errors) => {
            alert('Tidak dapat menampilkan data');
            return;
        });
}


    function pindahTarif(url, url1) {
    $('#modal-pindahTarif').modal('show');

    $('#modal-pindahTarif form')[0].reset();
    $('#modal-pindahTarif form').attr('action', url1);
    $('#modal-pindahTarif [name=_method]').val('put');

    $.get(url)
        .done((response) => {
            $('#modal-pindahTarif [id=ID]').val(response.id);
            let header = 'kode : ' + response.number + ' > ' + response.uraian + ' > ';
            let nilaiFormatted = Number(response.nilai).toLocaleString('id-ID');
            let saranaFormatted = Number(response.tarif_sarana).toLocaleString('id-ID');
            let layananFormatted = Number(response.tarif_layanan).toLocaleString('id-ID');

            $('#modal-pindahTarif [id=header]').val(header);
            $('#modal-pindahTarif [id=opd-tarif]').val(response.opd_id).trigger('change');
            $('#modal-pindahTarif [id=opd-tarif-tujuan]').val(response.opd_id).trigger('change');
            $('#modal-pindahTarif [id=balai-tarif]').val(response.uppd_id).trigger('change');
            $('#modal-pindahTarif [id=golongan-tarif]').val(response.golongan_id).trigger('change');
            $('#modal-pindahTarif [id=jenis-tarif]').val(response.jenis_id).trigger('change');

            $('#modal-pindahTarif [id=balai-tujuan]').val(response.uppd_id).trigger('change');
            $('#modal-pindahTarif [id=golongan-tujuan]').val(response.golongan_id).trigger('change');
            $('#modal-pindahTarif [id=jenis-tujuan]').val(response.jenis_id).trigger('change');

        })
        .fail((errors) => {
            alert('Tidak dapat menampilkan data');
            return;
        });
}
    function pindahHeaderTarif(url, url1) {
    $('#modal-pindahHeaderTarif').modal('show');

    $('#modal-pindahHeaderTarif form')[0].reset();
    $('#modal-pindahHeaderTarif form').attr('action', url1);
    $('#modal-pindahHeaderTarif [name=_method]').val('put');

    $.get(url)
        .done((response) => {
            $('#modal-pindahHeaderTarif [id=ID]').val(response.id);
            let header = 'kode : ' + response.number + ' > ' + response.uraian + ' > ';
            let nilaiFormatted = Number(response.nilai).toLocaleString('id-ID');
            let saranaFormatted = Number(response.tarif_sarana).toLocaleString('id-ID');
            let layananFormatted = Number(response.tarif_layanan).toLocaleString('id-ID');

            $('#modal-pindahHeaderTarif [id=headerheader]').val(header);
            $('#modal-pindahHeaderTarif [id=opd-headertarif]').val(response.opd_id).trigger('change');
            $('#modal-pindahHeaderTarif [id=opd-headertarif-tujuan]').val(response.opd_id).trigger('change');
            $('#modal-pindahHeaderTarif [id=balai-headertarif]').val(response.uppd_id).trigger('change');
            $('#modal-pindahHeaderTarif [id=golongan-headertarif]').val(response.golongan_id).trigger('change');
            $('#modal-pindahHeaderTarif [id=jenis-headertarif]').val(response.jenis_id).trigger('change');

            $('#modal-pindahHeaderTarif [id=balai-headertujuan]').val(response.uppd_id).trigger('change');
            $('#modal-pindahHeaderTarif [id=golongan-headertujuan]').val(response.golongan_id).trigger('change');
            $('#modal-pindahHeaderTarif [id=jenis-headertujuan]').val(response.jenis_id).trigger('change');

        })
        .fail((errors) => {
            alert('Tidak dapat menampilkan data');
            return;
        });
}

$(document).ready(function () {
    // Saat ada perubahan pada salah satu select
    $('#balai-tujuan, #golongan-tujuan, #jenis-tujuan').on('change', function () {
        var uppd_id = $('#balai-tujuan').val();
        var gol_id = $('#golongan-tujuan').val();
        var jenis_id = $('#jenis-tujuan').val();

        // Pastikan semua nilai sudah dipilih sebelum request AJAX
        if (uppd_id && gol_id && jenis_id) {
            $.ajax({
                url: "{{ route('tarif.getHeaders') }}",
                type: "GET",
                data: {
                    uppd_id: uppd_id,
                    gol_id: gol_id,
                    jenis_id: jenis_id
                },
                dataType: "json",
                success: function (response) {
                    var options = '<option value="0"></option>';
                    $.each(response, function (index, item) {
                        options += '<option value="' + item.id + '">'+item.number+'> ' + item.uraian + '</option>';
                    });
                    $('#subheader').html(options);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $('#subheader').html('<option value="0"></option>'); // Reset jika tidak lengkap
        }
    });
    $('#balai-headertujuan, #golongan-headertujuan, #jenis-headertujuan').on('change', function () {
        var uppd_id = $('#balai-headertujuan').val();
        var gol_id = $('#golongan-headertujuan').val();
        var jenis_id = $('#jenis-headertujuan').val();

        // Pastikan semua nilai sudah dipilih sebelum request AJAX
        if (uppd_id && gol_id && jenis_id) {
            $.ajax({
                url: "{{ route('tarif.getHeaders') }}",
                type: "GET",
                data: {
                    uppd_id: uppd_id,
                    gol_id: gol_id,
                    jenis_id: jenis_id
                },
                dataType: "json",
                success: function (response) {
                    var options = '<option value="0">Header Utama</option>';
                    $.each(response, function (index, item) {
                        options += '<option value="' + item.id + '">'+item.number+'> ' + item.uraian + '</option>';
                    });
                    $('#subheaderheader').html(options);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $('#subheaderheader').html('<option value="0"></option>'); // Reset jika tidak lengkap
        }
    });
});

$(document).ready(function () {
   
    $('#buttonpindahtarif').on('click', function (e) {
    e.preventDefault(); // Mencegah form submit secara default

    $.post($('#modal-pindahTarif form').attr('action'), $('#modal-pindahTarif form').serialize())
        .done((response) => {
            $('#modal-pindahTarif').modal('hide');
            table.ajax.reload();
        })
        .fail((errors) => {
            alert('Tidak dapat menyimpan data');
        });
});
    $('#buttonpindahHeadertarif').on('click', function (e) {
    e.preventDefault(); // Mencegah form submit secara default

    $.post($('#modal-pindahHeaderTarif form').attr('action'), $('#modal-pindahHeaderTarif form').serialize())
        .done((response) => {
            $('#modal-pindahHeaderTarif').modal('hide');
            table.ajax.reload();
        })
        .fail((errors) => {
            alert('Tidak dapat menyimpan data');
        });
});

});


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
