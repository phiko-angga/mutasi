<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
<script>
    var stepper = new Stepper($('.bs-stepper')[0]);
    var incKel = 0;
    var incKelTrans = 0;
    var incKelTransPembantu = 0;
    var incMuat = 0;

    $(document).ready(function () {
        $("#kota_asal_id,#kota_tujuan_id").select2({width: 'resolve'});
        $("#pejabat_komitmen_nama").trigger('change');
        $('.numeric').maskNumber({integer: true});
    })

    $(document).on("change","#pejabat_komitmen_nama",function(){
        let nip = $(this).find(":selected").data('nip');
        $("#pejabat_komitmen_nip").val(nip);
    })

    $(document).on("click","#maksud_ketuama, #maksud_dirjen",function(){
        let tgl = $("#tanggal").val();
        let nomor = $("#nomor").val();

        if($(this).prop('id') == 'maksud_ketuama'){
            text = "Untuk melaksanakan tugas ketempat yang baru berdasarkan SK KETUA MAHKAMAH AGUNG RI Nomor : "+nomor+" Tanggal : 25 September 2023";
            $("#maksud_perj_dinas").val(text);
        }else
        if($(this).prop('id') == 'maksud_dirjen'){
            text = "Untuk melaksanakan tugas ketempat yang baru berdasarkan SK DIREKTUR JENDERAL BADAN PERADILAN UMUM Nomor : "+nomor+" Tanggal : 25 September 2023";
            $("#maksud_perj_dinas").val(text);
        }
    })

    $(document).on("click",".kel_add",function(){
        let item = $("#item-keluarga");
        newkel = template_keluarga();
        item.append(newkel);
    })

    $(document).on("click",".kel_delete",function(e){
        e.preventDefault();

        let id = $(this).data('id');
        let item = $("#item-keluarga");
        item.find('tr[id="item'+id+'"]').remove();
    })

    function template_keluarga(){
        ++incKel;
        let template = 
                    '<tr id="item'+incKel+'">'+
                '<td>'+
                    '<div class="form-check">'+
                        '<input class="form-check-input cb_perj_dinas" id="cb_perj_dinas'+incKel+'" name="kel_perj_dinas[]" type="checkbox" value="1">'+
                        '<label class="form-check-label" for="cb_perj_dinas'+incKel+'"></label>'+
                    '</div>'+
                '</td>'+
                '<td>'+incKel+'</td>'+
                '<td>'+
                    '<input type="text" name="kel_nama[]" id="kel_nama'+incKel+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<input type="date" name="kel_dob[]" id="kel_dob'+incKel+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<input type="number" name="kel_umur[]" id="kel_umur'+incKel+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<a href="#" class="kel_delete" data-id="'+incKel+'"><i class="bx bx-trash"></i></a>'+
                '</td>'+
            '</tr>';
        return template;
    }

    // ---------------------- TRANSPORT --------------------------
    $(document).on("click",".trans_add",function(){
        let item = $("#item-transport");
        let newt = template_transport();
        item.append(newt);
        initSelect2();
    })

    $(document).on("click",".trans_add_pembantu",function(){
        let item = $("#item-transport-pembantu");
        let newt = template_transport(true);
        item.append(newt);
        initSelect2();
    })

    $(document).on("click",".trans_delete",function(e){
        e.preventDefault();

        let id = $(this).data('id');
        let item = $("#item-transport");
        item.find('tr[id="item'+id+'"]').remove();
    })

    function template_transport(pembantu =  false){

        ++incKelTrans;
        let template = 
            '<tr id="item'+incKelTrans+'">'+
                '<td>'+incKelTrans+'</td>';

            if(!pembantu){
                template += '<td>'+
                    '<div class="form-check">'+
                        '<input class="form-check-input cb_manual" id="cb_manual'+incKelTrans+'" name="trans_manual[]" type="checkbox" value="1">'+
                        '<label class="form-check-label" for="cb_manual'+incKelTrans+'"></label>'+
                    '</div>'+
                '</td>';
            }

            template += '<td>'+
                    '<select name="transport_id[]" id="transport_id" class="form-select select2advance" data-select2-placeholder="Jenis transport" data-select2-url="'+base_url+'/get-select/jenis-transport"></select>'+
                '</td>'+
                '<td>'+
                    '<select name="kota_asal_id[]" id="kota_asal_id" class="form-select select2advance" data-select2-placeholder="Tempat berangkat" data-select2-url="'+base_url+'/get-select/kota"></select>'+
                '</td>'+
                '<td>'+
                    '<select name="kota_tujuan_id[]" id="kota_tujuan_id" class="form-select select2advance" data-select2-placeholder="Tempat tujuan" data-select2-url="'+base_url+'/get-select/kota"></select>'+
                '</td>';
                
            if(!pembantu){
                template += '<td>'+
                    '<input type="number" name="orang[]" id="orang'+incKelTrans+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<input type="number" name="biaya_perorang[]" id="biaya_perorang'+incKelTrans+'" class="form-control form-control-sm">'+
                '</td>';
            }else{
                template += 
                '<td>'+
                    '<input type="text" name="rinci_perkiraan[]" id="rinci_perkiraan'+incKelTrans+'" class="form-control form-control-sm">'+
                '</td>';
            }
            template += 
                '<td>'+
                    '<input type="number" name="jumlah_biaya[]" id="jumlah_biaya'+incKelTrans+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                
                '</td>'+
                '<td>'+
                    '<a href="#" class="kel_delete" data-id="'+incKelTrans+'"><i class="bx bx-trash"></i></a>'+
                '</td>'+
            '</tr>';
        return template;
    }

    // ---------------------- MUAT BARANG --------------------------
    $(document).on("click",".muatbarang_add",function(){
        let item = $("#item-muatbarang");
        let newt = template_muatbarang();
        item.append(newt);
        
        $('.numeric').maskNumber({integer: true});
        initSelect2();
    })

    $(document).on("click",".muatbarang_delete",function(e){
        e.preventDefault();

        let id = $(this).data('id');
        let item = $("#item-muatbarang");
        item.find('tr[id="item'+id+'"]').remove();
    })

    function template_muatbarang(){
        ++incMuat;
        let template = 
            '<tr id="item'+incMuat+'">'+
                '<td>'+incMuat+'</td>'+
                '<td>'+
                    '<div class="form-check">'+
                        '<input class="form-check-input cb_manual" id="cb_manual'+incMuat+'" name="trans_manual[]" type="checkbox" value="1">'+
                        '<label class="form-check-label" for="cb_manual'+incMuat+'"></label>'+
                    '</div>'+
                '</td>'+
                '<td>'+
                    '<select name="transport_id[]" id="transport_id" class="form-select select2advance" data-select2-placeholder="Jenis transport" data-select2-url="'+base_url+'/get-select/jenis-transport"></select>'+
                '</td>'+
                '<td>'+
                    '<select name="kota_asal_id[]" id="kota_asal_id" class="form-select select2advance" data-select2-placeholder="Tempat berangkat" data-select2-url="'+base_url+'/get-select/kota"></select>'+
                '</td>'+
                '<td>'+
                    '<select name="kota_tujuan_id[]" id="kota_tujuan_id" class="form-select select2advance" data-select2-placeholder="Tempat tujuan" data-select2-url="'+base_url+'/get-select/kota"></select>'+
                '</td>'+
                '<td>'+
                    '<input type="number" name="pengepakan_berat[]" id="pengepakan_berat'+incMuat+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<input type="number" name="pengepakan_jarak[]" id="pengepakan_jarak'+incMuat+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<input type="number" name="pengepakan_biaya[]" id="pengepakan_biaya'+incMuat+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<input type="text" name="pengepakan_metode[]" id="pengepakan_metode'+incMuat+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<a href="#" class="kel_delete" data-id="'+incMuat+'"><i class="bx bx-trash"></i></a>'+
                '</td>'+
            '</tr>';
        return template;
    }

</script>
