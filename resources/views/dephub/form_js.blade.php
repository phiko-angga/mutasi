<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    var base_url = '{{url('')}}';

    $(document).on('change','#provinsi_asal_id',function(e){
        $("#kota_asal_id").data("select2-url",base_url+'/get-select/kota?provinsi='+$(this).val());
        $("#kota_asal_id").val("");
        
        $("#provinsi_tujuan_id").data("select2-url",base_url+'/get-select/provinsi?exclude='+$(this).val());
        $("#provinsi_tujuan_id").val("");
        initSelect2();
    })
    $(document).on('change','#provinsi_tujuan_id',function(e){
        $("#kota_tujuan_id").data("select2-url",base_url+'/get-select/kota?provinsi='+$(this).val());
        $("#kota_tujuan_id").val("");
        initSelect2();
    })
    
    $(document).ready(function(){
        
        $('.numeric').maskNumber({integer: true});
        $("#provinsi_asal_id").select2();

        @if($action == 'store')
        $("#provinsi_asal_id").trigger('change');
        $("#provinsi_tujuan_id").trigger('change');
        @endif
        
        initSelect2();
    })

</script>