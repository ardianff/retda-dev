@push('scripts')
<script>

$('#subheader ').select2({
    dropdownParent: $("#modal-pindahTarif"),
    placeholder: "Pilih satuan tarif",
    allowClear: true
});
$('#subheaderheader ').select2({
    dropdownParent: $("#modal-pindahHeaderTarif"),
    placeholder: "Pilih satuan tarif",
    allowClear: true
});

function pindahTarif(url, url1) {
    $('#modal-pindahTarif').modal('show');

    $('#modal-pindahTarif form')[0].reset();
    $('#modal-pindahTarif form').attr('action', url1);
    $('#modal-pindahTarif [name=_method]').val('put');

    $.get(url)
        .done((response) => {
            $('#modal-pindahTarif [id=ID]').val(response.tarif.id);
            let header = 'kode : ' + response.tarif.number + ' > ' + response.tarif.uraian + ' > ';
          

            $('#modal-pindahTarif [id=header]').val(header);
            $('#modal-pindahTarif [id=opd-tarif]').val(response.tarif.opd_id).trigger('change');
            $('#modal-pindahTarif [id=balai-tarif]').val(response.tarif.uppd_id).trigger('change');
            $('#modal-pindahTarif [id=golongan-tarif]').val(response.tarif.golongan_id).trigger('change');
            $('#modal-pindahTarif [id=jenis-tarif]').val(response.tarif.jenis_id).trigger('change');

            $('#modal-pindahTarif [id=balai-tujuan]').val(response.tarif.uppd_id).trigger('change');
            $('#modal-pindahTarif [id=golongan-tujuan]').val(response.tarif.golongan_id).trigger('change');
            $('#modal-pindahTarif [id=jenis-tujuan]').val(response.tarif.jenis_id).trigger('change');

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
            $('#modal-pindahHeaderTarif [id=ID]').val(response.tarif.id);
            let header = 'kode : ' + response.tarif.number + ' > ' + response.tarif.uraian + ' > ';
        

            $('#modal-pindahHeaderTarif [id=headerheader]').val(header);
            $('#modal-pindahHeaderTarif [id=opd-headertarif]').val(response.tarif.opd_id).trigger('change');
            $('#modal-pindahHeaderTarif [id=balai-headertarif]').val(response.tarif.uppd_id).trigger('change');
            $('#modal-pindahHeaderTarif [id=golongan-headertarif]').val(response.tarif.golongan_id).trigger('change');
            $('#modal-pindahHeaderTarif [id=jenis-headertarif]').val(response.tarif.jenis_id).trigger('change');

            $('#modal-pindahHeaderTarif [id=balai-headertujuan]').val(response.tarif.uppd_id).trigger('change');
            $('#modal-pindahHeaderTarif [id=golongan-headertujuan]').val(response.tarif.golongan_id).trigger('change');
            $('#modal-pindahHeaderTarif [id=jenis-headertujuan]').val(response.tarif.jenis_id).trigger('change');

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
                url: "{{ route('usulan.getHeaders') }}",
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
                    $('#subheader').select2({
    dropdownParent: $("#modal-pindahTarif"),

                    placeholder: "Pilih subheader...",
                    allowClear: true,
                });

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
                url: "{{ route('usulan.getHeaders') }}",
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
                    $('#subheaderheader').select2({
    dropdownParent: $("#modal-pindahHeaderTarif"),

                    placeholder: "Pilih subheader...",
                    allowClear: true,
                });
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
            showMessage(response.type || 'success', response.message || 'Data tarif berhasil di pindah');
            
        })
        .fail((errors) => {
           showMessage(response.type || 'danger', response.message || 'gagal melakukan eksekusi');
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
           showMessage(response.type || 'danger', response.message || 'gagal melakukan eksekusi');
        });
});

});

</script>
<script>
    $('#golongan-headertujuan').on('change', function() {
        let golId = $(this).val();

        $('#jenis-headertujuan option').each(function() {
            let itemGol = $(this).data('gol');

            if (!itemGol || itemGol == golId) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // reset pilihan jenis
        $('#jenis-headertujuan').val('');
    });
</script>
@endpush