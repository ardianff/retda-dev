
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

if ({{ $jenis_id }} == 16) {
    columns.push({data: 'u_sarana'});
    columns.push({data: 'u_layanan'});
}
columns.push({data: 'u_nilai'});

columns.push({data: 'grms_id'});
columns.push({data: 'status'});

// Kolom "Aksi" dengan class tambahan agar bisa di-sticky
columns.push({data: 'aksi', orderable: false, searchable: false});

table = $('#table-tarif').DataTable({
    processing: true,
    serverSide: true,
    // scrollX: true, // Mengaktifkan scroll horizontal
    // fixedColumns: {
    //     right: 1 // Menjadikan kolom terakhir tetap terlihat
    // },
    ajax: {
        url: {!! json_encode(route('usulan.data', [$opd_id, $uppd_id, $gol_id, $jenis_id, $tu_id])) !!},
        data: function (d) {
            d.parent_id = 0; // Memuat data utama dulu
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

        if (icon.hasClass('fa-caret-right')) {
            icon.removeClass('fa-caret-right').addClass('fa-caret-down');

            if ($(`tr[data-parent-id="${parentId}"]`).length > 0) {
                $(`tr[data-parent-id="${parentId}"]`).show();
            } else {
                row.after(`<tr data-parent-id="${parentId}" class="loading-row"><td colspan="6">Loading...</td></tr>`);
                fetchChildRows(parentId);
            }

            updateOpenStatus(parentId, 1);
        } else {
            icon.removeClass('fa-caret-down').addClass('fa-caret-right');
            hideChildren(parentId);
            updateOpenStatus(parentId, 0);
        }
    });

});

// Fungsi untuk mengambil child row
function fetchChildRows(parentId, level = 1) {
    $.ajax({
        url: {!! json_encode(route('usulan.data', [$opd_id, $uppd_id, $gol_id, $jenis_id, $tu_id])) !!},
        data: { parent_id: parentId },
        success: function (response) {
            console.log(response);
            response.data.sort((a, b) => a.number.localeCompare(b.number, undefined, { numeric: true }));
            $('tr.loading-row[data-parent-id="' + parentId + '"]').remove(); // Perbaikan selektor

            response.data.reverse().forEach(function (child) {
                let toggleIcon = child.has_children 
                    ? `<i class="fas fa-caret-${child.open == 1 ? 'down' : 'right'} toggle-tree" data-id="${child.id}" title="List"></i> ${child.number}` 
                    : child.number;
        //     let toggleIcon = child.has_children 
        // ? `<i class="fas fa-caret-${child.open ? 'down' : 'right'} toggle-tree" data-id="${child.id}" data-open="${child.open}"></i>` 
        // : '';
                let newRow = `
                     <tr data-id="${child.id}" data-parent-id="${parentId}" class="child-row parent-${parentId}" style="display: none;">
                        <td style="padding-left: ${level * 10}px">${toggleIcon}</td>
                        <td>${child.uraian}</td>
                        <td>${child.satuan ? child.satuan : ''}</td>`;

                // Jika jenis_id == 16, tambahkan kolom "Sarana" dan "Layanan"
                @if ($jenis_id == 16)
                    newRow += `<td>${child.sarana ? child.sarana : ''}</td>
                               <td>${child.layanan ? child.layanan : ''}</td>
                              `;
                @endif
                newRow += `<td>${child.nilai}</td>`;

                @if ($jenis_id == 16)
                    newRow += `
                               <td>${child.u_sarana ? child.u_sarana : ''}</td>
                               <td>${child.u_layanan ? child.u_layanan : ''}</td>`;
                @endif

                newRow += `<td>${child.u_nilai}</td>
                           <td>${child.grms_id}</td>
                           <td>${child.status}</td>
                           <td >${child.aksi}</td>
                    </tr>`;


                $('tr[data-id="' + parentId + '"]').after(newRow);
                $('tr[data-id="' + child.id + '"]').fadeIn();

                if (child.open === 1) {
                    fetchChildRows(child.id, level + 1); // Tambah level jika ada anaknya
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
        url: {!! json_encode(route('usulan.updateOpenStatus')) !!},
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
        url: {!! json_encode(route('usulan.updateStatus')) !!},
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
@endpush