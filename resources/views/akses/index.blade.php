@extends('template.master')

@section('breadcumb')
<li class="breadcrumb-item" style="float: left;"><a href="{{route('akseslevel.index')}}"> Akses User Level</a> </li>

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header with-border">
                <h5 class="mb-2">Akses User Level</h5>
                <button onclick="addForm('{{ route('akseslevel.store') }}')" class="btn btn-success btn-sm "><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Level User</th>
                            <th>Aksi</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                       <tr>
                        <td>1</td>
                        <td>Superadmin</td>
                        
                        <td>
                            <button onclick="editForm('{{ route('akseslevel.update',1) }}')" class="btn btn-warning btn-sm "><i class="fas fa-pencil-alt"></i> </button>
                        </td>
                       </tr>
                       <tr>
                        <td>2</td>
                        <td>Admin Bapenda</td>
                       
                        <td>
                            <button onclick="editForm('{{ route('akseslevel.update',2) }}')" class="btn btn-warning btn-sm "><i class="fas fa-pencil-alt"></i> </button>
                        </td>
                       </tr>
                     
                       <tr>
                        <td>3</td>
                        <td>Admin OPD</td>
                       
                        <td>
                            <button onclick="editForm('{{ route('akseslevel.update',3) }}')" class="btn btn-warning btn-sm "><i class="fas fa-pencil-alt"></i> </button>
                        </td>
                       </tr>
                       <tr>
                        <td>4</td>
                        <td>Admin Balai/UPT/UPPD</td>
                       
                        <td>
                            <button onclick="editForm('{{ route('akseslevel.update',4) }}')" class="btn btn-warning btn-sm "><i class="fas fa-pencil-alt"></i> </button>
                        </td>
                       </tr>
                       <tr>
                        <td>5</td>
                        <td>User</td>
                        
                        <td>
                            <button onclick="editForm('{{ route('akseslevel.update',5) }}')" class="btn btn-warning btn-sm "><i class="fas fa-pencil-alt"></i> </button>
                        </td>
                       </tr>
                       <tr>
                        <td>6</td>
                        <td>Pengolah Data</td>
                        
                        <td>
                            <button onclick="editForm('{{ route('akseslevel.update',6) }}')" class="btn btn-warning btn-sm "><i class="fas fa-pencil-alt"></i> </button>
                        </td>
                       </tr>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('akses.detail')
@includeIf('akses.form')
@endsection

@push('scripts')
<script>
    let table;

$(function () {
    table = $('.table').DataTable({ });


});

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Akses Level');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=name]').focus();

    }

    function editForm(url) {
    $('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Edit Akses Level');

    $('#modal-form form')[0].reset();
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('put');

    $.get(url)
        .done((response) => {
            console.log(response.menu_id);
           
            $('#modal-form [name=level_id]').val(response.level_id).prop('selected', true);
            // Hapus semua centang dulu
            $('#modal-form .menu-checkbox').prop('checked', false);

            // Centang menu yang sudah dipilih
            response.menu_id.forEach(id => {
                $('#menu-' + id).prop('checked', true);
            });
        })
        .fail((errors) => {
            alert('Tidak dapat menampilkan data');
        });
}


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
    function lihat(url) {
    $('#modal-detail').modal('show');
    
    $.ajax({
        url: url,
        type: "GET",
        success: function (response) {
            if (response.length > 0) {
                let menuHtml = generateMenuList(response);
                $('#menu-list').html(menuHtml);
            } else {
                $('#menu-list').html('<p class="text-muted">Tidak ada menu yang tersedia.</p>');
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
}

function generateMenuList(menus) {
    let html = '<ul class="list-unstyled">';
    menus.forEach(menu => {
        html += `<li>
            <div class="icheck-primary d-inline">
              
                <label for="menu-${menu.id}">${menu.menu}</label>
            </div>`;
        
        if (menu.children && menu.children.length > 0) {
            html += '<ul class="ml-3">' + generateMenuList(menu.children) + '</ul>';
        }
        
        html += '</li>';
    });
    html += '</ul>';
    return html;
}

// <input type="checkbox" class="menu-checkbox" id="menu-${menu.id}" name="menu_id[]" value="${menu.id}">
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
