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
            <div class="card-header bg-dark">Filter Info Tarif</div>
            <div class="card-body">
                <form action="{{route('info.index')}}" method="get" >
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Pilih Tahun</label>
                                <div class="col-md-5">
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
<div class="card-body table-responsive">
    <table class="table table-striped " id="table-tarif" >
        <thead>
            <tr class="py-4">
                <th >Kode</th>
                <th>Uraian</th>
                <th>Satuan</th>
                @if ($jenis_id==16)
                <th>Sarana</th>
                <th>Layanan</th>
                    
                @endif
                <th>Tarif</th>
                <th>Status</th>
                <th>grms</th>
                {{-- <th style="width:10%">Keterangan</th> --}}
            </tr>
        </thead>
    </table>
    
</div>
</div>
</div>
</div>


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
columns.push({data: 'status'});
columns.push({data: 'grms_id'});

// Inisialisasi DataTable
 table = $('#table-tarif').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: {!! json_encode(route('info.data', [$opd_id, $uppd_id, $gol_id, $jenis_id, $thn_id])) !!},
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
        url: {!! json_encode(route('info.data', [$opd_id, $uppd_id, $gol_id, $jenis_id, $thn_id])) !!},
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
                           <td>${child.status}</td>
                           <td>${child.grms_id}</td>
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
        url: {!! json_encode(route('info.updateOpenStatus')) !!},
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
                    },
                    error: function() {
                        alert('Gagal mengambil data  Balai.');
                    }
                });
            }
        });


});
   

  
</script>
@endpush
