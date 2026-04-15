@extends('template.master')

@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="{{route('usulan.index')}}"> Tarif</a> </li>

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
            <div class="card-header bg-primary"> Generate Data Usulan Tarif</div>
            <div class="card-body">
              <form action="{{ route('generate.usulan') }}" method="get" target="_blank" id="exportForm">
    @csrf
    <div class="row">
        <div class="col-md-12">

            {{-- Pilih Jenis Export --}}
            <div class="form-group row mb-1">
                <label class="col-md-2">Jenis Export</label>
                <div class="col-md-6">
                    <select id="export_tipe" class="form-control" name="aksi" required>
                        <option value="">-- Pilih Jenis Export --</option>
                        <option value="excel">Excel</option>
                        <option value="pdf">PDF</option>
                        <option value="csv">CSV (Keseluruhan)</option>
                    </select>
                </div>
            </div>

            {{-- Pergub Tarif --}}
            <div class="form-group row mb-1">
                <label class="col-md-2">Usulan Tarif</label>
                <div class="col-md-6">
                    <select id="pengajuan_id" class="form-control" name="pengajuan_id" required>
                        @foreach ($pengajuan as $item)
                            <option value="{{ $item->id }}">{{ $item->deskripsi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-1 ">
                <label class="col-md-2">Filter Data</label>
                <div class="col-md-6">
                    <select id="filter" class="form-control" name="filter">
                        <option value="">=== Pilih Filter ===</option>
                            <option value="1">Tarif Lama (hanya tarif lama yg ditampilkan)</option>
                            <option value="2">Tarif Gabungan (dimunculkan tarif baru jika tarif lama tidak ada)</option>
                            <option value="3">Tarif Usulan (hanya tarif usulan yg ditampilkan)</option>
                    </select>
                </div>
            </div>

            {{-- OPD --}}
            <div class="form-group row mb-1 export-option">
                <label class="col-md-2">Pilih OPD</label>
                <div class="col-md-6">
                    <select id="id_opd" class="form-control" name="id_opd">
                        <option value="">Pilih OPD</option>
                        @foreach ($opd as $item)
                            <option value="{{ $item->id }}">{{ $item->opd }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Balai / UPPD --}}
            <div class="form-group row mb-1 export-option">
                <label class="col-md-2">Pilih Balai / UPPD / UPT</label>
                <div class="col-md-6">
                    <select id="id_uppd" class="form-control" name="id_uppd">
                        <option value="">Pilih Balai/UPT/UPPD</option>
                        <option value="0">Keseluruhan</option>
                        @foreach ($uppd as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Golongan --}}
            <div class="form-group row mb-1 export-option">
                <label class="col-md-2">Golongan Retribusi</label>
                <div class="col-md-6">
                    <select id="id_golongan" class="form-control" name="id_golongan">
                        <option value="">Pilih Golongan</option>
                        @foreach ($golongan as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Tombol Proses --}}
            <div class="row">
                <div class="col-md-10">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-cogs"></i> Proses
                    </button>
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
            <div class="card-header bg-dark">Generate Pergub Tarif (yg berlaku)</div>
            <div class="card-body">
              <form action="{{ route('generate.print') }}" method="get" target="_blank" id="exportForm">
    @csrf
    <div class="row">
        <div class="col-md-12">

            {{-- Pilih Jenis Export --}}
            <div class="form-group row mb-1">
                <label class="col-md-2">Jenis Export</label>
                <div class="col-md-6">
                    <select id="export_type" class="form-control" name="action" required>
                        <option value="">-- Pilih Jenis Export --</option>
                        <option value="excel">Excel</option>
                        <option value="pdf">PDF</option>
                        <option value="csv">CSV (Keseluruhan)</option>
                    </select>
                </div>
            </div>

            {{-- Pergub Tarif --}}
            <div class="form-group row mb-1">
                <label class="col-md-2">Pergub Tarif</label>
                <div class="col-md-6">
                    <select id="ta_id" class="form-control" name="ta_id" required>
                        @foreach ($ta as $item)
                            <option value="{{ $item->id }}">{{ $item->deskripsi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- OPD --}}
            <div class="form-group row mb-1 export-options">
                <label class="col-md-2">Pilih OPD</label>
                <div class="col-md-6">
                    <select id="opd_id" class="form-control" name="opd_id">
                        <option value="">Pilih OPD</option>
                        @foreach ($opd as $item)
                            <option value="{{ $item->id }}">{{ $item->opd }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Balai / UPPD --}}
            <div class="form-group row mb-1 export-options">
                <label class="col-md-2">Pilih Balai / UPPD / UPT</label>
                <div class="col-md-6">
                    <select id="uppd_id" class="form-control" name="uppd_id">
                        <option value="">Pilih Balai/UPT/UPPD</option>
                        <option value="0">Keseluruhan</option>
                        @foreach ($uppd as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Golongan --}}
            <div class="form-group row mb-1 export-options">
                <label class="col-md-2">Golongan Retribusi</label>
                <div class="col-md-6">
                    <select id="gol_id" class="form-control" name="gol_id">
                        <option value="">Pilih Golongan</option>
                        @foreach ($golongan as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Tombol Proses --}}
            <div class="row">
                <div class="col-md-10">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-cogs"></i> Proses
                    </button>
                </div>
            </div>

        </div>
    </div>
</form>



            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(function () {
       
       $('#opd_id ').select2({
       placeholder: "Pilih OPD",
       allowClear: true
   });
       $('#uppd_id ').select2({
       placeholder: "Pilih UPPD/Balai/UPT",
       allowClear: true
   });
   
       $('#gol_id ').select2({
       placeholder: "Golongan Retribusi",
       allowClear: true
   });

       $('#id_opd ').select2({
       placeholder: "Pilih OPD",
       allowClear: true
   });
       $('#id_uppd ').select2({
       placeholder: "Pilih UPPD/Balai/UPT",
       allowClear: true
   });
   
       $('#id_golongan ').select2({
       placeholder: "Golongan Retribusi",
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
   });
   
   var userLevel = @json(auth()->user()->level); // Ambil user level dari PHP ke JavaScript
       var allowedLevels = [1, 2, 3,4,5, 6]; // Level yang diperbolehkan
   
       $('#opd_id').on('input', function() {
           let opd_id = $(this).val();
           $('#uppd_id').empty().append('<option value="">-- Pilih UPPD/Balai/Satker --</option>');
   
           if (opd_id) {
               $.ajax({
                   url: `{{ url('/opd/uppd') }}/${opd_id}`,
                   type: 'GET',
                   success: function(data) {
                       // Cek apakah user level ada dalam daftar allowedLevels
                       if (allowedLevels.includes(userLevel)) {
                           $('#uppd_id').append(`<option value="0">Keseluruhan</option>`);
                       }
   
                       // Tambahkan data dari AJAX response
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
                       alert('Gagal mengambil data Balai.');
                   }
               });
           }
       });
       
       $('#uppd_id').on('change', function() {
        $('#gol_id').select2('open');
                setTimeout(() => {
                    let searchField = document.querySelector('.select2-container--open .select2-search__field');
                    if (searchField) {
                        searchField.focus();
                    }
                }, 50);
    });
 
   
       $('#id_opd').on('input', function() {
           let opd_id = $(this).val();
           $('#id_uppd').empty().append('<option value="">-- Pilih UPPD/Balai/Satker --</option>');
   
           if (opd_id) {
               $.ajax({
                   url: `{{ url('/opd/uppd') }}/${opd_id}`,
                   type: 'GET',
                   success: function(data) {
                       // Cek apakah user level ada dalam daftar allowedLevels
                       if (allowedLevels.includes(userLevel)) {
                           $('#id_uppd').append(`<option value="0">Keseluruhan</option>`);
                       }
   
                       // Tambahkan data dari AJAX response
                       data.forEach(function(uppd) {

                           $('#id_uppd').append(`<option value="${uppd.id}">${uppd.nama}</option>`);

                       });
                       $('#id_uppd').select2('open');
                setTimeout(() => {
                    let searchField = document.querySelector('.select2-container--open .select2-search__field');
                    if (searchField) {
                        searchField.focus();
                    }
                }, 50);
                   },
                   error: function() {
                       alert('Gagal mengambil data Balai.');
                   }
               });
           }
       });
       
       $('#id_uppd').on('change', function() {
        $('#id_golongan').select2('open');
                setTimeout(() => {
                    let searchField = document.querySelector('.select2-container--open .select2-search__field');
                    if (searchField) {
                        searchField.focus();
                    }
                }, 50);
    });
       </script>
       <script>
document.addEventListener('DOMContentLoaded', function () {
    const exportType = document.getElementById('export_type');
    const exportOptions = document.querySelectorAll('.export-options');
    const opd = document.getElementById('opd_id');
    const uppd = document.getElementById('uppd_id');
    const gol = document.getElementById('gol_id');

    function setCsvMode(isCsv) {
        exportOptions.forEach(div => div.style.display = isCsv ? 'none' : 'flex');

        if (isCsv) {
            opd.value = '';
            uppd.value = '0';
            gol.value = '';
            opd.disabled = true;
            uppd.disabled = true;
            gol.disabled = true;
        } else {
            opd.disabled = false;
            uppd.disabled = false;
            gol.disabled = false;
        }
    }

    exportType.addEventListener('change', function () {
        setCsvMode(this.value === 'csv');
    });

    // default hide if csv preselected
    setCsvMode(exportType.value === 'csv');
});
</script>
       <script>
document.addEventListener('DOMContentLoaded', function () {
    const exportType = document.getElementById('export_tipe');
    const exportOptions = document.querySelectorAll('.export-option');
    const opd = document.getElementById('id_opd');
    const uppd = document.getElementById('id_uppd');
    const gol = document.getElementById('id_golongan');

    function setCsvMode(isCsv) {
        exportOptions.forEach(div => div.style.display = isCsv ? 'none' : 'flex');

        if (isCsv) {
            opd.value = '';
            uppd.value = '0';
            gol.value = '';
            opd.disabled = true;
            uppd.disabled = true;
            gol.disabled = true;
        } else {
            opd.disabled = false;
            uppd.disabled = false;
            gol.disabled = false;
        }
    }

    exportType.addEventListener('change', function () {
        setCsvMode(this.value === 'csv');
    });

    // default hide if csv preselected
    setCsvMode(exportType.value === 'csv');
});
</script>
@endpush
