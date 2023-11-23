$(document).ready(function () {

    let status = $('#trplafon-status_benefit');
    let nonbenefitInput = $('#nonbenefit');
    let nonbenefitForm = $('#nonbenefit_form');
    let inputIdPeserta = $('#trplafon-id_peserta');
    let inputNamaPlafon = $('#trplafon-nama_plafon');
    let inputIdProvider = $('#trplafon-id_provider');
    let inputStatusBenefit = $('#trplafon-status_benefit');
    let inputKeluhan = $('#keluhan');
    let inputTindakan = $('#tindakan');
    let inputKeterangan = $('#trplafon-keterangan');
    let inputInvoice = $('#trplafon-invoice');
    let inputNoSurat = $('#trplafon-no_surat');
    let inputStatusBayar = $('#trplafon-status_bayar');

    function toggleNonbenefitFormVisibility() {

        if (status.val() === 'Ya') {
            nonbenefitForm.hide();
            nonbenefitInput.val('');
            inputKeluhan.val('');
            inputTindakan.val('');
            inputKeterangan.val('');
            inputInvoice.val('');
            inputNoSurat.val('');
            inputStatusBayar.val('');

        } else if (status.val() === '') {
            nonbenefitForm.hide();
            nonbenefitInput.val('');
            inputKeluhan.val('');
            inputTindakan.val('');
            inputKeterangan.val('');
            inputInvoice.val('');
            inputNoSurat.val('');
            inputStatusBayar.val('');

        } else {
            nonbenefitInput.val('*');
            nonbenefitForm.show();
        }

    }

    toggleNonbenefitFormVisibility();
    status.on('change', toggleNonbenefitFormVisibility);

    $('#trplafon-tanggal').on('change', function () {
        $('#trplafon-tanggal_selesai').attr('min', $('#trplafon-tanggal').val());

        if ($('#trplafon-tanggal').val().trim() !== '') {
            $('#trplafon-tanggal_selesai').prop('disabled', false);
        } else {
            $('#trplafon-tanggal_selesai').prop('disabled', true);
            $('#trplafon-tanggal_selesai').val('');
        }

        if ($('#trplafon-tanggal_selesai').val().trim() !== '') {
            if ($('#trplafon-tanggal_selesai').val() < $('#trplafon-tanggal').val()) {
                $('#trplafon-tanggal_selesai').val($('#trplafon-tanggal').val());
            }
        }
    });



});

