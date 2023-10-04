<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
<script>

    $(document).ready(function () {
        var stepper = new Stepper($('.bs-stepper')[0])
        $("#kota_asal_id,#kota_tujuan_id").select2({width: 'resolve'});
        $("#pejabat_komitmen_nama").trigger('change');
    })

    $(document).on("change","#pejabat_komitmen_nama",function(){
        let nip = $(this).find(":selected").data('nip');
        $("#pejabat_komitmen_nip").val(nip);
    })
</script>