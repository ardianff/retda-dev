@push('scripts')
<script>
  $('#opd-copyHeader').on('input', function() {
            let opd_id = $(this).val();
            $('#balai-copyHeader').empty().append('<option value="">-- Pilih UPPD/Balai/Satker --</option>');

            if (opd_id) {
                $.ajax({
                    url: `{{ url('/opd/uppd') }}/${opd_id}`,
                    type: 'GET',
                    success: function(data) {
                        data.forEach(function(uppd) {
                            $('#balai-copyHeader').append(`<option value="${uppd.id}">${uppd.nama}</option>`);
                        });
                    },
                    error: function() {
                        alert('Gagal mengambil data  Balai.');
                    }
                });
            }
        });
  $('#opd-copyChild').on('input', function() {
            let opd_id = $(this).val();
            $('#balai-copyChild').empty().append('<option value="">-- Pilih UPPD/Balai/Satker --</option>');

            if (opd_id) {
                $.ajax({
                    url: `{{ url('/opd/uppd') }}/${opd_id}`,
                    type: 'GET',
                    success: function(data) {
                        data.forEach(function(uppd) {
                            $('#balai-copyChild').append(`<option value="${uppd.id}">${uppd.nama}</option>`);
                        });
                    },
                    error: function() {
                        alert('Gagal mengambil data  Balai.');
                    }
                });
            }
        });



function copyHeaderUsulan(url, url1) {
    $('#modal-copyHeaderusulan').modal('show');

    $('#modal-copyHeaderusulan form')[0].reset();
    $('#modal-copyHeaderusulan form').attr('action', url1);
    $('#modal-copyHeaderusulan [name=_method]').val('put');

    $.get(url)
        .done((response) => {
            $('#modal-copyHeaderusulan [id=ID]').val(response.tarif.id);
            let header = 'kode : ' + response.tarif.number + ' > ' + response.tarif.uraian + ' > ';
            

            $('#modal-copyHeaderusulan [id=copyHeaderAwal]').val(header);
            $('#modal-copyHeaderusulan [id=opd-copyHeaderAwal]').val(response.tarif.opd_id).trigger('change');
            $('#modal-copyHeaderusulan [id=balai-copyHeaderAwal]').val(response.tarif.uppd_id).trigger('change');
            $('#modal-copyHeaderusulan [id=golongan-copyHeaderAwal]').val(response.tarif.golongan_id).trigger('change');
            $('#modal-copyHeaderusulan [id=jenis-copyHeaderAwal]').val(response.tarif.jenis_id).trigger('change');

            $('#modal-copyHeaderusulan [id=opd-copyHeader]').val(response.tarif.opd_id).trigger('change');
            $('#modal-copyHeaderusulan [id=balai-copyHeader]').val(response.tarif.uppd_id).trigger('change');
            $('#modal-copyHeaderusulan [id=golongan-copyHeader]').val(response.tarif.golongan_id).trigger('change');
            $('#modal-copyHeaderusulan [id=jenis-copyHeader]').val(response.tarif.jenis_id).trigger('change');

        })
        .fail((errors) => {
            alert('Tidak dapat menampilkan data');
            return;
        });
}
function copyChildUsulan(url, url1) {
    $('#modal-copyChildUsulan').modal('show');

    $('#modal-copyChildUsulan form')[0].reset();
    $('#modal-copyChildUsulan form').attr('action', url1);
    $('#modal-copyChildUsulan [name=_method]').val('put');

    $.get(url)
        .done((response) => {
            $('#modal-copyChildUsulan [id=ID]').val(response.tarif.id);
            let header = 'kode : ' + response.tarif.number + ' > ' + response.tarif.uraian + ' > ';
            

            $('#modal-copyChildUsulan [id=copyChildAwal]').val(header);
            $('#modal-copyChildUsulan [id=opd-copyChildAwal]').val(response.tarif.opd_id).trigger('change');
            $('#modal-copyChildUsulan [id=balai-copyChildAwal]').val(response.tarif.uppd_id).trigger('change');
            $('#modal-copyChildUsulan [id=golongan-copyChildAwal]').val(response.tarif.golongan_id).trigger('change');
            $('#modal-copyChildUsulan [id=jenis-copyChildAwal]').val(response.tarif.jenis_id).trigger('change');

            $('#modal-copyChildUsulan [id=opd-copyChild]').val(response.tarif.opd_id).trigger('change');
            $('#modal-copyChildUsulan [id=balai-copyChild]').val(response.tarif.uppd_id).trigger('change');
            $('#modal-copyChildUsulan [id=golongan-copyChild]').val(response.tarif.golongan_id).trigger('change');
            $('#modal-copyChildUsulan [id=jenis-copyChild]').val(response.tarif.jenis_id).trigger('change');

        })
        .fail((errors) => {
            alert('Tidak dapat menampilkan data');
            return;
        });
}
   
// mengambil data Sub header
$(document).ready(function () {
    // Saat ada perubahan pada salah satu select
    $('#opd-copyHeader, #balai-copyHeader, #golongan-copyHeader, #jenis-copyHeader').on('change', function () {
        var opd_id = $('#opd-copyHeader').val();
        var uppd_id = $('#balai-copyHeader').val();
        var gol_id = $('#golongan-copyHeader').val();
        var jenis_id = $('#jenis-copyHeader').val();

        // Pastikan semua nilai sudah dipilih sebelum request AJAX
        if (opd_id && uppd_id && gol_id && jenis_id) {
            $.ajax({
                url: "{{ route('copytarif.getHeaders') }}",
                type: "GET",
                data: {
                    opd_id: opd_id,
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
                    $('#copyHeader').html(options);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $('#copyHeader').html('<option value="0"></option>'); // Reset jika tidak lengkap
        }
    });

    $('#opd-copyChild, #balai-copyChild, #golongan-copyChild, #jenis-copyChild').on('change', function () {
        var opd_id = $('#opd-copyChild').val();
        var uppd_id = $('#balai-copyChild').val();
        var gol_id = $('#golongan-copyChild').val();
        var jenis_id = $('#jenis-copyChild').val();

        // Pastikan semua nilai sudah dipilih sebelum request AJAX
        if (opd_id && uppd_id && gol_id && jenis_id) {
            $.ajax({
                url: "{{ route('copytarif.getHeaders') }}",
                type: "GET",
                data: {
                    opd_id: opd_id,
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
                    $('#copyChild').html(options);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $('#copyChild').html('<option value="0"></option>'); // Reset jika tidak lengkap
        }
    });


    
});

$(document).ready(function () {
   
    $('#buttonCopyChild').on('click', function (e) {
    e.preventDefault(); // Mencegah form submit secara default

    $.post($('#modal-copyChildUsulan form').attr('action'), $('#modal-copyChildUsulan form').serialize())
        .done((response) => {
            $('#modal-copyChildUsulan').modal('hide');
            table.ajax.reload();
        })
        .fail((errors) => {
            alert('Tidak dapat menyimpan data');
        });
});
    $('#buttonCopyHeader').on('click', function (e) {
    e.preventDefault(); // Mencegah form submit secara default

    $.post($('#modal-copyHeaderusulan form').attr('action'), $('#modal-copyHeaderusulan form').serialize())
        .done((response) => {
            $('#modal-copyHeaderusulan').modal('hide');
            table.ajax.reload();
        })
        .fail((errors) => {
            alert('Tidak dapat menyimpan data');
        });
});

});
</script>
@endpush