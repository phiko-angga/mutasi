<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).on('change','#provinsi_id',function(e){
        $("#kota_id").data("select2-url",base_url+'/get-select/kota?provinsi='+$(this).val());
        $("#kota_id").val("");
        initSelect2();
    })

    $(document).ready(function(){
        $('.numeric').maskNumber({integer: true});
        $("#provinsi_id").select2();
        initSelect2();

        @if($action == 'store')
        $("#provinsi_id").trigger('change');
        @endif
    })

</script>