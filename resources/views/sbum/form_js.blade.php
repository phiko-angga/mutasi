<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    var base_url = '{{url('')}}';

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