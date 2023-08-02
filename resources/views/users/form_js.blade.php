<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    var base_url = '{{url('')}}';

    $(document).on('click','.btn-savetoken',function(e){
        e.preventDefault();
        let token = $("#token").val();
        initFirebaseMessagingRegistration();
    })
    
    function initFirebaseMessagingRegistration() {
        messaging
        .requestPermission()
        .then(function() {
            return messaging.getToken()
        })
        .then(function(token) {
            console.log(token);
            // $("#fcm_token").val(token);
            submit_token(token);
        }).catch(function(err) {
            console.log('User Token Error' + err);
        });
    }

    function submit_token(token){
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        let userid = $("#id").val();
        $.ajax({
            url: "{{url('users/update-token')}}",
            type: 'POST',
            data: {id:userid,token:token},
            dataType: 'JSON',
            success: function(response) {
                alert('Token saved successfully.');
            },
            error: function(err) {
                console.log('User Chat Token Error' + err);
            },
        });

    }
 
    $(document).on('change','#provinsi_id, #kecamatan_id, #kota_id',function(e){
        
        if(e.target.id == 'provinsi_id'){
            $("#kota_id").val("");
            $("#kecamatan_id").val("");
            $("#kelurahan_id").val("");
            $("#kota_id").data("select2-url",base_url+'/get-select/kota?provinsi='+$("#provinsi_id").val());
        }else
        if(e.target.id == 'kota_id'){
            $("#kecamatan_id").val("");
            $("#kelurahan_id").val("");
            $("#kecamatan_id").data("select2-url",base_url+'/get-select/kecamatan?kota='+$("#kota_id").val());
        }else
        if(e.target.id == 'kecamatan_id'){
            $("#kelurahan_id").val("");
            $("#kelurahan_id").data("select2-url",base_url+'/get-select/kelurahan?kecamatan='+$("#kecamatan_id").val());
        }

        initSelect2();
    })

    $(document).ready(function(){
        initSelect2();
        // $("#provinsi_id").trigger('change');
        // $("#kota_id").trigger('change');
        // $("#kecamatan_id").trigger('change');
    })

    function initSelect2(){
        
        if ( $('.select2advance').length > 0 ){
            
            $('.select2advance').each(function(index, el) {
                var limit_rows = 10;
                var url = $(this).data('select2-url');
                var placeholder = $(this).data('select2-placeholder');

                $(this).select2({
                    placeholder: placeholder,
                    ajax: {
                        url: url,
                        dataType: 'json',
                        data: function (params) {
                            return {
                                q: params.term, // search term
                                page_limit: limit_rows,
                                page: params.page,
                            };
                        },
                        processResults: function (data, params) {
                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * limit_rows) < data.total           
                            }
                        };
                        },
                        cache: true
                    }
                });
            })
        }
    }

    function initSelect2Kota(){
        select2Kota = $('#kota_id').select2({
            placeholder: "Pilih kabupaten / kota",
            ajax: {
                url: "{{url('get-select/kota')}}",
                dataType: 'json',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        provinsi: $("#provinsi_id").val()
                    };
                },
                processResults: function (data) {
                return {
                    results: data.items
                };
                },
                cache: true
            }
        });
    }

</script>