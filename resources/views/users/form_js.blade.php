<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    var base_url = '{{url('')}}';

    $(document).ready(function(){
        initSelect2();
        
    })

    $("#form-user").submit(function(e){
        if($("#password").val() !== $("#password_ver").val()){
            alert("Password tidak cocok.");
            e.preventDefault();
            return false;
        }
    })
</script>