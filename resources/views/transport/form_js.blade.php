<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    var base_url = '{{url('')}}';

    $(document).on('click','input[name="kode"]',function(e){
        let jenis = $(this).val();
        $("#alias").val(jenis);
    })
    
</script>