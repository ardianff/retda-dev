@push('scripts')
<script>
     function showMessage(type = 'success', message = '') {
    const alertHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    $('#ajax-alert').html(alertHTML);

    // Auto hide after 4 seconds
    setTimeout(() => {
        $('#ajax-alert .alert').alert('close');
    }, 4000);
}
// $('#tarifFormBody').on('submit', function (e) {
//     e.preventDefault();

//     let form = this;

//     // // 1️⃣ Jalankan dulu fungsi pengecekan perubahan tarif
//     // cekPenjelasan();

//     // // 2️⃣ Validasi khusus penjelasan
//     // if ($('#edit-penjelasan').prop('required') && 
//     //     !$('#edit-penjelasan').val().trim()) {

//     //     alert('Penjelasan wajib diisi karena terjadi perubahan tarif.');
//     //     $('#edit-penjelasan').focus();
//     //     return false;
//     // }

//     // 3️⃣ Validasi HTML5 (required dll)
//     if (!form.checkValidity()) {
//         form.reportValidity();
//         return false;
//     }

//     // 4️⃣ Jika semua valid → kirim AJAX
//     let formData = new FormData(form);

//     $.ajax({
//         url: $(form).attr('action'),
//         type: $(form).attr('method'),
//         data: formData,
//         processData: false,
//         contentType: false,
//         success: function (response) {
//             alert('Data berhasil disimpan');
//         },
//         error: function (xhr) {
//             alert('Terjadi kesalahan');
//         }
//     });
// });
$(function () {
    
  
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
    $('#satuan ').select2({
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
   
// $(document).on('select2:open', () => {
//         let searchField = document.querySelector('.select2-container--open .select2-search__field');
//         if (searchField) {
//             searchField.focus();
//         }
//     });
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
                let header = '';

                if (response.tarif.parent_id != 0) {
                    header = response.kode + ' : ' + response.tarif.parent.uraian + ' > ';
                } else {
                    header = response.kode + ' : ' + response.tarif.uraian + ' > ';
                }


                $('#modal-form [id=parent_id_header]').val(response.tarif.id);
                $('#modal-form [id=tahun]').val(response.tarif.tu_id);
                $('#modal-form [id=header]').val(header);
                $('#modal-form [id=number]').val(response.number);
                $('#modal-form [id=kode]').text(response.kode);
                $('#modal-form [name=opd]').val(response.tarif.opd_id);
                $('#modal-form [name=balai]').val(response.tarif.uppd_id);
                $('#modal-form [name=golongan]').val(response.tarif.golongan_id);
                $('#modal-form [name=jenis]').val(response.tarif.jenis_id);
                $('#modal-form [id=opd]').val(response.tarif.opd_id).trigger('change');
                $('#modal-form [id=balai]').val(response.tarif.uppd_id).trigger('change');
                $('#modal-form [id=golongan]').val(response.tarif.golongan_id).trigger('change');
                $('#modal-form [id=jenis]').val(response.tarif.jenis_id).trigger('change');
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



function addBody(url) {
    $('#modalFormTarif').modal('show');
    $('#modalFormTarif form')[0].reset();

    $('#modalFormTarif .modal-title').text('Tambah Tarif Retribusi');
    $.get(url)
            .done((response) => {
                let header = '';

                if (response.tarif.parent_id != 0) {
                    header = response.kode + ' : ' + response.tarif.parent.uraian + ' > ';
                } else {
                    header = response.kode + ' : ' + response.tarif.uraian + ' > ';
                }
                $('#modalFormTarif [id=parent_id_body]').val(response.tarif.id);
                $('#modalFormTarif [id=header]').val(header);
                $('#modalFormTarif [id=number]').val(response.number);
                $('#modalFormTarif [id=kode]').text(response.kode);
                $('#modalFormTarif [id=tahun]').val(response.tarif.tu_id);
                $('#modalFormTarif [name=opd]').val(response.tarif.opd_id);
                $('#modalFormTarif [name=balai]').val(response.tarif.uppd_id);
                $('#modalFormTarif [name=golongan]').val(response.tarif.golongan_id);
                $('#modalFormTarif [name=jenis]').val(response.tarif.jenis_id);

                $('#modalFormTarif [id=opd-tarif]').val(response.tarif.opd_id).trigger('change');
                $('#modalFormTarif [id=balai-tarif]').val(response.tarif.uppd_id).trigger('change');
                $('#modalFormTarif [id=golongan-tarif]').val(response.tarif.golongan_id).trigger('change');
                $('#modalFormTarif [id=jenis-tarif]').val(response.tarif.jenis_id).trigger('change');
            })
            .fail((errors) => {
                showMessage(response.type || 'danger', response.message || 'Tidak dapat menampilkan data');
            });

 
}


    function editForm(url,url1) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit User');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url1);
        $('#modal-form [name=_method]').val('put');

        $.get(url)
            .done((response) => {
                let header = '';
                let kode = '';
                let parent = '';

                if (response.tarif.parent_id != 0) {
                    header = response.tarif.parent.number + ' : ' + response.tarif.parent.uraian + ' > ';
                    kode = response.tarif.parent.number;
                    parent = response.tarif.parent_id;
                } else {
                    header = response.number + ' : ' + response.tarif.uraian + ' > ';
                    kode='';
                    parent=0;
                }

                $('#modal-form [id=header]').val(header);
                $('#modal-form [id=number]').val(response.number);
                $('#modal-form [id=kode]').text(kode);
                $('#modal-form [id=parent_id_header]').val(parent);
                $('#modal-form [id=opd]').val(response.tarif.opd_id).trigger('change');
                $('#modal-form [id=balai]').val(response.tarif.uppd_id).trigger('change');
                $('#modal-form [id=golongan]').val(response.tarif.golongan_id).trigger('change');
                $('#modal-form [id=jenis]').val(response.tarif.jenis_id).trigger('change');
                $('#modal-form [id=uraian]').val(response.tarif.uraian);
                $('#modal-form [id=penjelasan]').val(response.tarif.penjelasan);
                $('#modal-form [id=keterangan]').val(response.tarif.keterangan);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }
    function editFormbody(url,url1) {
        $('#modal-editform').modal('show');
        $('#modal-editform .modal-title').text('Edit form tarif');

        $('#modal-editform form')[0].reset();
        $('#modal-editform form').attr('action', url1);
        $('#modal-editform [name=_method]').val('put');
        $.get(url)
            .done((response) => {
                $('#modal-editform [id=ID]').val(response.id);
                let header = '';

                if (response.tarif.parent_id != 0) {
                    header = response.tarif.parent.number + ' : ' + response.tarif.parent.uraian + ' > ';
                } else {
                    header = response.number + ' : ' + response.tarif.uraian + ' > ';
                }
                console.log(header);

                let nilai = Number(response.tarif.nilai ?? 0).toLocaleString('id-ID');

                    let bkn = response.tarif.bkn_nilai;
                    if (bkn === null || bkn === undefined || bkn === 'null') {
                        bkn = '';
                    }

                    let berlaku = nilai + bkn;
$('#db_nilai').val(response.tarif.u_nilai ?? 0);
$('#db_sarana').val(response.tarif.u_sarana ?? 0);
$('#db_layanan').val(response.tarif.u_layanan ?? 0);


                let nilaiFormatted = Number(response.tarif.u_nilai).toLocaleString('id-ID');
                let saranaFormatted = Number(response.tarif.u_sarana).toLocaleString('id-ID');
                let layananFormatted = Number(response.tarif.u_layanan).toLocaleString('id-ID');
                let saranaSaatini = Number(response.tarif.tarif_sarana).toLocaleString('id-ID');
                let layananSaatini = Number(response.tarif.tarif_layanan).toLocaleString('id-ID');
                $('#modal-editform [id=header]').val(header);
                $('#modal-editform [id=number-tarif]').val(response.number);
                $('#modal-editform [id=kode-tarif]').text(response.tarif.parent.number);
                $('#modal-editform [id=parent-tarif]').val(response.tarif.parent_id);
                $('#modal-editform [id=edit-keterangan]').val(response.tarif.keterangan);
                $('#modal-editform [id=edit-penjelasan]').val(response.tarif.penjelasan);

                $('#modal-editform [id=opd-tarif]').val(response.tarif.opd_id).trigger('change');
                $('#modal-editform [id=balai-tarif]').val(response.tarif.uppd_id).trigger('change');
                $('#modal-editform [id=golongan-tarif]').val(response.tarif.golongan_id).trigger('change');
                $('#modal-editform [id=jenis-tarif]').val(response.tarif.jenis_id).trigger('change');

                $('#modal-editform [id=edit_uraian]').val(response.tarif.uraian);
                $('#modal-editform [id=edit_satuan]').val(response.tarif.satuan_id).trigger('change');
                $('#modal-editform [id=edit_rekening]').val(response.tarif.rekening_id).trigger('change');
                $('#modal-editform [id=edit_format_tarif]').val(response.tarif.format_tarif).trigger('change');
                $('#modal-editform [id=berlaku]').val(berlaku);
                $('#modal-editform [id=edit_nilai]').val(nilaiFormatted);
                $('#modal-editform [id=edit_sarana]').val(saranaFormatted);
                $('#modal-editform [id=edit_layanan]').val(layananFormatted);
                $('#modal-editform [id=saat_ini_sarana]').show().val(saranaSaatini); // Tampilkan input sarana
                $('#modal-editform [id=saat_ini_layanan]').show().val(layananSaatini); // Tampilkan input layanan
                
                switch (response.tarif.u_format) {
    case 'rupiah':
        $('#edit_rupiah').prop('checked', true);
        break;
    case 'bukan_rupiah':
        $('#edit_bukan_nilai').prop('checked', true);
        $('#edit_bkn_nilai').show().val(response.tarif.bkn_nilai);
        break;
    case 'up':
        $('#edit_up').prop('checked', true);
        $('#edit_bkn_nilai').hide().val(response.tarif.bkn_nilai);
        $('#modal-editform [id=edit_nilai]').prop('disabled',true).val(nilaiFormatted);
                $('#modal-editform [id=edit_sarana]').prop('disabled',true).val(saranaFormatted);
                $('#modal-editform [id=edit_layanan]').prop('disabled',true).val(layananFormatted);

        break;
    default:
        // Fallback jika tidak ada yang cocok
        $('#edit_rupiah').prop('checked', true);
}
            //     if (response.tarif.format == 1) {
                
            //     $('#edit_bkn_nilai').val(response.tarif.bkn_nilai).show(); // Tampilkan edit_bkn_nilai dengan response.tarif.nilai
            //     $('#edit_bukan_nilai').prop('checked', true); // Centang checkbox bukan_nilai
            //     $('#edit_rupiah').prop('checked', false); // Centang checkbox bukan_nilai
            // } else {
            //     $('#edit_nilai').show().val(nilaiFormatted);  // Tampilkan input nilai
            //     $('#edit_sarana').show().val(saranaFormatted); // Tampilkan input sarana
            //     $('#edit_layanan').show().val(layananFormatted); // Tampilkan input layanan
            //     $('#saat_ini_sarana').show().val(saranaSaatini); // Tampilkan input sarana
            //     $('#saat_ini_layanan').show().val(layananSaatini); // Tampilkan input layanan
                
            //     $('#edit_rupiah').prop('checked', true); // Centang checkbox bukan_nilai
            //     $('#edit_bkn_nilai').val('').hide(); // Sembunyikan edit_bkn_nilai
            //     $('#edit_bukan_nilai').prop('checked', false); // Uncheck checkbox bukan_nilai
            // }

         
cekPenjelasan();


            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }
function getNum(v){
    return Number(String(v).replace(/[^0-9.-]+/g,"")) || 0;
}

function cekPenjelasan() {

    let berubah = false;

    if ($('#edit_nilai').length && !$('#edit_nilai').prop('disabled')) {
        berubah = berubah || (getNum($('#edit_nilai').val()) !== getNum($('#db_nilai').val()));
    }

    if ($('#edit_sarana').length && !$('#edit_sarana').prop('disabled')) {
        berubah = berubah || (getNum($('#edit_sarana').val()) !== getNum($('#db_sarana').val()));
    }

    if ($('#edit_layanan').length && !$('#edit_layanan').prop('disabled')) {
        berubah = berubah || (getNum($('#edit_layanan').val()) !== getNum($('#db_layanan').val()));
    }

    togglePenjelasan(berubah);
}
function togglePenjelasan(wajib) {

    let group = $('#edit-penjelasan').closest('.form-group');

    $('#edit-penjelasan').prop('required', wajib);

    if (wajib) {
        if (!group.find('.text-danger').length) {
            group.find('label').append(' <span class="text-danger">*</span>');
        }
    } else {
        group.find('.text-danger').remove();
    }
}
$('#edit_nilai, #edit_sarana, #edit_layanan').on('input', cekPenjelasan);

    function showMessage(type = 'success', message = '') {
    const alertHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    $('#ajax-alert').html(alertHTML);

    // Auto hide after 4 seconds
    setTimeout(() => {
        $('#ajax-alert .alert').alert('close');
    }, 4000);
}
    function deleteForm(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    showMessage(response.type || 'success', response.message || 'Berhasil');
                    table.ajax.reload();
                })
                .fail((response) => {
                    showMessage(response.type || 'danger', response.message || 'Gagal Mengahpus data');
                    // return;
                });
        }
    }
    function force_delete(url) {
        if (confirm('Yakin ingin menghapus paksa data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'post'
                })
                .done((response) => {
                    showMessage(response.type || 'success', response.message || 'Berhasil');
                    table.ajax.reload();
                })
                .fail((response) => {
                    showMessage(response.type || 'danger', response.message || 'Gagal Mengahpus data');
                    // return;
                });
        }
    }

    function editkode(url,url1) {
        $('#modal-editKode').modal('show');
        $('#modal-editKode .modal-title').text('Edit form tarif');

        $('#modal-editKode form')[0].reset();
        $('#modal-editKode form').attr('action', url1);
        $('#modal-editKode [name=_method]').val('put');

        $.get(url)
            .done((response) => {
                let header = '';
                let kode = '';
                let parent = '';

                if (response.tarif.parent_id != 0) {
                    header = response.tarif.parent.number + ' : ' + response.tarif.parent.uraian + ' > ';
                    kode = response.tarif.parent.number;
                    parent = response.tarif.parent_id;
                } else {
                    header = response.number + ' : ' + response.tarif.uraian + ' > ';
                    kode='';
                    parent=0;
                }

                $('#modal-editKode [id=header]').val(header);
                $('#modal-editKode [id=number]').val(response.number);
                $('#modal-editKode [id=id_tarif]').val(response.tarif.id);
                $('#modal-editKode [id=kode]').text(kode);
                $('#modal-editKode [id=opd]').val(response.tarif.opd_id).trigger('change');
                $('#modal-editKode [id=balai]').val(response.tarif.uppd_id).trigger('change');
                $('#modal-editKode [id=golongan]').val(response.tarif.golongan_id).trigger('change');
                $('#modal-editKode [id=jenis]').val(response.tarif.jenis_id).trigger('change');
                $('#modal-editKode [id=uraian]').val(response.tarif.uraian);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }

    $(document).ready(function () {
   
   $('#btn-updateKode').on('click', function (e) {
   e.preventDefault(); // Mencegah form submit secara default

   $.post($('#form-editKode ').attr('action'), $('#form-editKode ').serialize())
       .done((response) => {
           $('#modal-editKode').modal('hide');
           table.ajax.reload();
           showMessage(response.type || 'success', response.message || 'Kode berhasil di ubah');
           
       })
       .fail((errors) => {
          showMessage(response.type || 'danger', response.message || 'gagal melakukan eksekusi');
       });
});
});
</script>
@endpush