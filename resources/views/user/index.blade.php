@extends('template.master')

@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="{{route('user.index')}}">Manajemen Pengguna</a> </li>

@endsection

@section('content')
@php
$userLevel = auth()->user()->level;

$isSpecialLevel = in_array($userLevel, [1, 2, 6]);
    
@endphp
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                Filter User
            </div>
            <div class="card-body">
                <form action="{{route('user.index')}}" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="form-group row">
                                <label for="" class="col-md-4 ">Pilih OPD</label>
                                <div class="col-md-8">
                                    <select id="opd_id" class="form-control " name="opd_id" data-user-level="{{ auth()->user()->level }}" required>
                                        @if (userSpesial())
                                            
                                        <option value=""> Pilih OPD</option>
                                        @endif
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
                                        @if (userKusus())
                                        <option value="">Pilih Balai/UPT/UPPD</option>
                                            
                                        <option {{ $uppd_id == '0' ? 'selected' :'' }} value="0">Keseluruhan</option>
                                        @endif

                                        @foreach ($uppd as $item)
                                        
                                        <option {{ $item->id == $uppd_id ? 'selected' : '' }} value="{{$item->id}}"> {{$item->nama}}</option>
                                        @endforeach
                                        
                                        </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row"><button type="submit" class="btn btn-success btn-sm btn-flat float-right">Filter</button></div>
                </div>

                </form>
            </div>
        <div class="card">
            <div class="card-header with-border">
                <h5 class="mb-2">User Management</h5>
                <button onclick="addForm('{{ route('user.store') }}')" class="btn btn-success btn-sm "><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>OPD/UPT/Balai</th>
                        <th>Level</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('user.form')
@includeIf('user.akses')
@endsection

@push('scripts')
<script>
$(function () {
    // $('#modal-form').on('click', function () {
    // // Submit the form with ID 'myForm'
    // $('#modal-form#simpan').submit();
    // });
   

    $('#opd_id ').select2({
    placeholder: "Pilih OPD",
    allowClear: true
});
    $('#uppd_id ').select2({
    placeholder: "Pilih Balai/UPPD/Satker",
    allowClear: true
});

});
   
$(document).on('select2:open', () => {
    setTimeout(() => {
        let searchField = document.querySelector('.select2-container--open .select2-search__field');
        if (searchField) {
            searchField.focus();
        }
    }, 50); // Delay kecil untuk memastikan field tersedia
});

$('#opd ').select2({
    dropdownParent: $("#modal-form"),
    placeholder: "Pilih OPD",
    allowClear: true
});
    $('#balai ').select2({
    dropdownParent: $("#modal-form"),
    placeholder: "Pilih Balai/UPPD/Satker",
    allowClear: true
});
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('user.data',[$opd_id,$uppd_id]) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'name'},
                {data: 'username'},
                {data: 'upt'},
                {data: 'level'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

      
    });

    $(document).ready(function () {
    $(".menu-checkbox").on("change", function () {
        $(this).closest("li").find("ul input[type='checkbox']").prop("checked", this.checked);
    });

    $(".menu-checkbox").on("change", function () {
        let parent = $(this).closest("ul").prev("div").find(".menu-checkbox");
        let allChecked = $(this).closest("ul").find("input[type='checkbox']:checked").length > 0;
        parent.prop("checked", allChecked);
    });
});

 

    $('#opd_id').on('input', function() {
            let opd_id = $(this).val();
            $('#uppd_id').empty().append('<option value="">-- Pilih UPPD/Balai/Satker --</option>');

            if (opd_id) {
                $.ajax({
                    url: `{{ url('/opd/getuppd') }}/${opd_id}`,
                    type: 'GET',
                    success: function(data) {
                           $('#uppd_id').append(`<option value="0">Keseluruhan</option>`);
                           
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
        


    function hakAkses(url,url1) {
    $('#akses-form').modal('show');
    $('#akses-form .modal-title').text('Edit User');

    $('#akses-form form')[0].reset();
    $('#akses-form form').attr('action', url1);

    $.get(url)
        .done((response) => {
            let menus = response.menus;
            let userAccess = response.userAccess;

            let menuList = buildMenuHierarchy(menus, userAccess);
            $('#menu-list').html(menuList);
        })
        .fail((errors) => {
            alert('Tidak dapat menampilkan data');
        });
}
function buildMenuHierarchy(menus, userAccess) {
    if (!menus || menus.length === 0) return '<p>Tidak ada menu tersedia</p>';

    let html = '<ul class="menu-tree">';
    menus.forEach(menu => {
        html += buildMenuItem(menu, userAccess);
    });
    html += '</ul>';

    return html;
}


function buildMenuItem(menu, userAccess) {
    let isChecked = userAccess[menu.id] ? 'checked' : '';
    let accessType = userAccess[menu.id] ? userAccess[menu.id].aksi : null;
    let isFullAccess = accessType === 1 ? 'checked' : '';
    let isReadOnly = accessType === 0 ? 'checked' : '';

    let html = `<li>
          <div style="display: flex; align-items: center; gap: 15px;">
        <label>
            <input type="checkbox" name="menu_ids[]" value="${menu.id}" ${isChecked} onclick="toggleAccess(${menu.id})"> ${menu.menu}
        </label>
        <label>
            <input type="radio" name="aksi[${menu.id}]" value="1" ${isFullAccess} class="access-${menu.id}"> Full Akses
        </label>
        <label>
            <input type="radio" name="aksi[${menu.id}]" value="0" ${isReadOnly} class="access-${menu.id}"> Read Only
        </label>
        </div>`;

    // Menampilkan semua children, bukan hanya yang ada di userAccess
    if (menu.children && menu.children.length > 0) {
        html += '<ul>';
        menu.children.forEach(child => {
            html += buildMenuItem(child, userAccess);
        });
        html += '</ul>';
    }

    html += '</li>';
    return html;
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
<script>
let authLevel = @json(auth()->user()->level);
let authOpd   = @json(auth()->user()->opd_id);
let authBalai = @json(auth()->user()->uppd_id);

let editingUser = null;
window.addForm = function(url){
    editingUser = null;

    $('#modal-form').modal('show');
    $('#modal-form form')[0].reset();
    $('#modal-form form').attr('action',url);
    $('#modal-form [name=_method]').val('post');

    $('#password,#password_confirmation').attr('required', true);

    // default kelompok
    let kelompokDefault = [1,2,6].includes(authLevel) ? 'bapenda' : 'non-bapenda';
    $('[name=kelompok][value="'+kelompokDefault+'"]').prop('checked', true);

   applyKelompokRule(kelompokDefault, false);


    $('#opd').val(null);
    $('#balai').empty().append('<option value="">Pilih Balai</option>');

    applyAuthLock();
}
window.editForm = function(url){
    $('#modal-form').modal('show');
    $('#modal-form form')[0].reset();
    $('#modal-form form').attr('action',url);
    $('#modal-form [name=_method]').val('put');
    $('#password,#password_confirmation').removeAttr('required');

    $.get(url, res => {

        editingUser = res;

        $('#name').val(res.name);
        $('#username').val(res.username);

           /* ===== KELOMPOK ===== */
        $('[name=kelompok]').prop('checked', false);
        $('[name=kelompok][value="'+res.kelompok+'"]').prop('checked', true);

        /* JANGAN rebuild option level saat edit */
        applyKelompokRule(res.kelompok, true);

        /* Level */
        $('#level').val(res.level).trigger('change');

        /* Panggil rule TANPA rebuild */
        applyKelompokRule(res.kelompok, true);

        /* OPD */
        $('#modal-form #opd').val(res.opd_id).trigger('change');


        /* Balai (uppd_id) */
        loadBalai(res.opd_id, res.uppd_id);

        applyLevelVisibility(res.level);
        applyEditTargetRule();
        applyAuthLock();
    });
   

}
function applyKelompokRule(kelompok, isEdit=false){

    if(isEdit) return; // ← jangan rebuild saat edit

    let level = $('#level');
    level.empty().append('<option value="">Pilih Level</option>');

    if(kelompok === 'bapenda'){
        level.append('<option value="2">Admin Bapenda</option>');
        level.append('<option value="6">Pengolah Data</option>');
    }else{
        level.append('<option value="3">Admin OPD</option>');
        level.append('<option value="4">Admin Balai</option>');
        level.append('<option value="5">User</option>');
    }
}


function applyLevelVisibility(level){

    $('#opd-group, #balai-group').hide();
    $('#opd, #balai').prop('disabled', false);

    if(level == 3){ // Admin OPD
        $('#opd-group').show();
        $('#balai-group').hide();
        $('#balai').val(null).trigger('change');
    }
    else if(level == 4 || level == 5){ // Admin Balai
        $('#opd-group, #balai-group').show();
    }
}

function loadBalai(opdId, selected=null){
    $('#balai').empty().append('<option value="">Loading...</option>');

    $.get('/opd/uppd/'+opdId, res => {
        $('#balai').empty().append('<option value="">Pilih Balai</option>');
        res.forEach(b=>{
            $('#balai').append(`<option value="${b.id}">${b.nama}</option>`);
        });
       if(selected){
    $('#balai').val(selected).trigger('change');
}

    });
}
function applyAuthLock(){
    if(authLevel == 3){
        $('#opd').val(authOpd).prop('disabled', true);
    }
    if(authLevel == 4){
        $('#opd').val(authOpd).prop('disabled', true);
        $('#balai').val(authBalai).prop('disabled', true);
    }
}
function applyEditTargetRule(){
    if(!editingUser) return;

    if(editingUser.level == 4 && ![1,2,6].includes(authLevel)){
        $('#opd').prop('disabled', true);
        $('#balai').prop('disabled', true);
    }
}
$(document).on('change','[name=kelompok]',function(){
    applyKelompokRule(this.value);
});

$(document).on('change','#level',function(){
    applyLevelVisibility(this.value);
});

$(document).on('change','#opd',function(){
    loadBalai(this.value);
});


</script>



@endpush
