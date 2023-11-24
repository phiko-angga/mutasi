<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
        $('.numeric').maskNumber({integer: true});
        $("#provinsi_id").select2();
        initSelect2();
    })


</script>