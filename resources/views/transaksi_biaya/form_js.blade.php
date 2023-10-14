<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
<script>
    var stepperEl = $('.bs-stepper');
    var stepper = new Stepper($('.bs-stepper')[0]);
    var incKel = 0;
    var incKelTrans = 0;
    var incKelTransPembantu = 0;
    var incMuat = 0;
    var curdate = 0;

    $(document).ready(function () {
        $("#kota_asal_id,#kota_tujuan_id").select2({width: 'resolve'});
        $("#pejabat_komitmen_nama").trigger('change');
        $('.numeric').maskNumber({integer: true});
    })

    $(".bs-stepper")[0].addEventListener('shown.bs-stepper', function (event) {
        curStep = event.detail.indexStep;
        if(curStep == 1){
            initiateBiayaTransport();
        }else if(curStep == 2){
            initiateBiayaMuatBarang();
        }else if(curStep == 3){
            initiateUangHarian();
        }
    })

    $(document).on("change","#pejabat_komitmen2_id",function(){
        let nip = $(this).find(":selected").data('nip');
        $("#pejabat_komitmen2_nip").val(nip);
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

    $(document).on("change",".kel_dob",function(){
        let id = $(this).closest('tr').data('id');
        let dob = $(this).val();
        dob = new Date(dob);

        var today = new Date();
        var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
        $('#kel_umur'+id).val(age);
    })

    $(document).on("change","#pangkat_golongan",function(){
        let golongan = $(this).find(":selected").data('golongan');
        if(golongan.indexOf('IV') >= 0){
            $(".panel_transport_pembantu").show();
        }else{
            $(".panel_transport_pembantu").hide();
        }
    })

    $(document).on("change","#cb_perj_dinas",function(){
        let status = $(this).is(":checked");
        if(status){
            $("#perj_dinas").val(1);
        }else{
            $("#perj_dinas").val(0);
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
                    '<tr id="item'+incKel+'" data-id="'+incKel+'">'+
                '<td>'+
                    '<div class="form-check">'+
                        '<input class="form-check-input cb_perj_dinas" id="cb_perj_dinas'+incKel+'" name="kel_perj_dinas_cb[]" type="checkbox" value="1">'+
                        '<input id="perj_dinas'+incKel+'" name="kel_perj_dinas[]" type="hidden" value="0">'+
                        '<label class="form-check-label" for="cb_perj_dinas'+incKel+'"></label>'+
                    '</div>'+
                '</td>'+
                '<td>'+incKel+'</td>'+
                '<td>'+
                    '<input type="text" name="kel_nama[]" id="kel_nama'+incKel+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<input type="date" max="" name="kel_dob[]" id="kel_dob'+incKel+'" class="form-control form-control-sm kel_dob">'+
                '</td>'+
                '<td>'+
                    '<input type="number" name="kel_umur[]" id="kel_umur'+incKel+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<select name="kel_keterangan[]" id="kel_keterangan'+incKel+'" class="form-select form-select-sm">'+
                        '<option value="Istri">Istri</option>'+
                        '<option value="Suami">Suami</option>'+
                        '<option value="AK">AK</option>'+
                        '<option value="AA">AA</option>'+
                    '</select>'+
                '</td>'+
                '<td></td>'+
                '<td></td>'+
                '<td></td>'+
                '<td></td>'+
                '<td>'+
                    '<a href="#" class="kel_delete" data-id="'+incKel+'"><i class="bx bx-trash"></i></a>'+
                '</td>'+
            '</tr>';
        return template;
    }

    // ---------------------- TRANSPORT --------------------------
    $(document).on("click",".trans_add",function(){
        let total_kel = $("#item-keluarga").children().length + 1;

        let item = $("#item-transport");
        let newt = template_transport(false,total_kel);
        item.append(newt);
        initSelect2();
        $('.numeric').maskNumber({integer: true});
    })
    
    $(document).on("change",".trans_manual_cb",function(){
        let id = $(this).closest('tr').data('id');
        let status = $(this).is(":checked");
        if(status){
            $("#trans_manual"+id).val(1);
        }else{
            $("#trans_manual"+id).val(0);
        }
    })

    $(document).on("change",".biaya-per-orang",function(){
        let id = $(this).closest('tr').data('id');
        let pembantu = $(this).closest('tr').data('pembantu');

        let kota_asal = $("#transport_kota_asal_id").val();
        let kota_tujuan = $("#transport_kota_tujuan_id").val();

        let payload = {kota_asal:kota_asal,kota_tujuan:kota_tujuan};
        let params = {};
        params.url = '/transport/biaya-per-orang';
        params.data = payload;
        params.result = function(data){
            let biaya = 0;
            if($.isEmptyObject(data)){
                biaya = 0;
            }else{
                biaya = data.harga_tiket;
            }
            transportCalculateBiaya(id,biaya,pembantu);
        }
        ajaxCall(params);
    })

    $(document).on("click",".trans_add_pembantu",function(){
        let item = $("#item-transport-pembantu");
        let newt = template_transport(true);
        item.append(newt);
        initSelect2();
    })

    $(document).on("click",".cb_transport_manual",function(){
        let id = $(this).closest('tr').data('id');

        let checked = $(this).is(":checked");
        if(checked){
            $("#biaya_perorang"+id).attr('readonly',false);
        }else{
            $("#biaya_perorang"+id).attr('readonly',true);
        }
    })

    $(document).on("click",".trans_delete",function(e){
        e.preventDefault();

        let id = $(this).data('id');
        let item = $("#item-transport");
        item.find('tr[id="item'+id+'"]').remove();
    })

    function transportCalculateBiaya(id,hargaTiket = 0, pembantu = false){
        let total_orang = $("#orang"+id).val();
        $("#biaya_perorang"+id).val(addCommas(hargaTiket));

        let jumBiaya = pembantu ? 0 : hargaTiket * total_orang;
        $("#jumlah_biaya"+id).val(addCommas(jumBiaya));
    }

    function template_transport(pembantu = false, kel_jumlah = 0){

        ++incKelTrans;
        let template = 
            '<tr id="item'+incKelTrans+'" data-id="'+incKelTrans+'" data-pembantu="'+pembantu+'">'+
                '<td>'+incKelTrans+'</td>';

                template += '<td '+(pembantu ? 'hidden' : '')+'>'+
                    '<div class="form-check">'+
                        '<input class="form-check-input trans_manual_cb" id="trans_manual_cb'+incKelTrans+'" name="trans_manual_cb[]" type="checkbox" value="1">'+
                        '<input id="trans_manual'+incKelTrans+'" name="trans_manual[]" type="hidden" value="0">'+
                        '<label class="form-check-label" for="cb_manual'+incKelTrans+'"></label>'+
                    '</div>'+
                '</td>';

            template += '<td>'+
                    '<input type="hidden" name="trans_pembantu[]" value="'+(pembantu ? 1 : 0)+'">'+
                    '<select style="width: 100%" name="trans_transport_id[]" id="trans_transport_id" class="form-select select2advance" data-select2-placeholder="Jenis transport" data-select2-url="'+base_url+'/get-select/jenis-transport"></select>'+
                '</td>'+
                '<td style="width:250px">'+
                    '<select style="width: 100%" name="trans_kota_asal_id[]" id="transport_kota_asal_id" class="form-select select2advance biaya-per-orang" data-select2-placeholder="Tempat berangkat" data-select2-url="'+base_url+'/get-select/kota"></select>'+
                '</td>'+
                '<td style="width:250px">'+
                    '<select style="width: 100%" name="trans_kota_tujuan_id[]" id="transport_kota_tujuan_id" class="form-select select2advance biaya-per-orang" data-select2-placeholder="Tempat tujuan" data-select2-url="'+base_url+'/get-select/kota"></select>'+
                '</td>';
                
            // if(!pembantu){
                template += '<td '+(pembantu ? 'hidden' : '')+'>'+
                    '<input type="number" readonly name="trans_orang[]" id="orang'+incKelTrans+'" value="'+kel_jumlah+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td '+(pembantu ? 'hidden' : '')+' style="width:220px">'+
                    '<input type="text" readonly name="trans_biaya[]" id="biaya_perorang'+incKelTrans+'" class="form-control form-control-sm numeric">'+
                '</td>';
            // }else{
                template += 
                '<td '+(!pembantu ? 'hidden' : '')+'>'+
                    '<input type="text" name="trans_perkiraan[]" id="rinci_perkiraan'+incKelTrans+'" class="form-control form-control-sm">'+
                '</td>';
            // }

            template += 
                '<td style="width:220px">'+
                    '<input '+(pembantu ? '' : 'readonly')+' type="text" name="trans_jumlah_biaya[]" id="jumlah_biaya'+incKelTrans+'" class="form-control form-control-sm numeric">'+
                '</td>'+
                '<td style="width:300px">'+
                    '<select style="width: 100%" name="trans_metode[]" id="transport_metode" class="form-select form-select-sm">'+
                        '<option value="Tiket Bus Manual">Tiket Bus Manual</option>'+
                        '<option value="SBU/M - Dep. Keu.">SBU/M - Dep. Keu.</option>'+
                        '<option value="Dep. Perhubungan">Dep. Perhubungan</option>'+
                        '<option value="Harga Tiket Manual">Harga Tiket Manual</option>'+
                        '<option value="Table Jarak Darat">Table Jarak Darat</option>'+
                        '<option value="Jarak Darat Manual">Jarak Darat Manual</option>'+
                    '</select>'+
                '</td>'+
                '<td>'+
                    '<a href="#" class="kel_delete" data-id="'+incKelTrans+'"><i class="bx bx-trash"></i></a>'+
                '</td>'+
            '</tr>';
        return template;
    }
    
    function initiateBiayaTransport(){
        let tgl = $("#tanggal").val();
        let nomor = $("#nomor").val();

        $("#lampiran_tanggal").val(tgl);
        $("#lampiran_sppd_no").val(nomor);
        
        $('.numeric').maskNumber({integer: true});
        initSelect2();
    }

    function initiateBiayaMuatBarang(){
        $('.numeric').maskNumber({integer: true});
        initSelect2();
    }

    function initiateUangHarian(){
        let total_kel = $("#item-keluarga").children().length + 1;
        $("#uangh_jml_orang").val(total_kel);

        let pembantu_ikut = $("#pembantu_ikut option:selected").val();
        $("#uangh_jml_pembantu").val(parseInt(pembantu_ikut));

        let lama_dinas = $("#lama_perj_dinas").val();
        $("#uangh_jml_hari").val(lama_dinas);
        $("#uangh_jml_hari_p").val(lama_dinas);

        $('.numeric').maskNumber({integer: true});
        initSelect2();
    }

    // ---------------------- MUAT BARANG --------------------------
    $(document).on("change",".muat-jarak",function(){
        let id = $(this).closest('tr').data('id');

        let kota_asal = $("#pengepakan_kota_asal_id").val();
        let kota_tujuan = $("#pengepakan_kota_tujuan_id").val();

        let payload = {kota_asal:kota_asal,kota_tujuan:kota_tujuan};
        let params = {};
        params.url = '/pengepakan/jarak';
        params.data = payload;
        params.result = function(data){
            let jarak = 0;
            if($.isEmptyObject(data)){
                jarak = 0;
            }else{
                jarak = data.jarak_km;
            }
            muatCalculatejarak(id,jarak);
        }
        ajaxCall(params);
    })
    
    $(document).on("change",".cb_muatmanual",function(){
        let id = $(this).closest('tr').data('id');
        let status = $(this).is(":checked");
        if(status){
            $("#muat_manual"+id).val(1);
        }else{
            $("#muat_manual"+id).val(0);
        }
    })

    $(document).on("change","#pengepakan_berat, #pengepakan_tarif",function(){
        let berat = parseInt($("#pengepakan_berat").val());
        let tarif = parseInt($("#pengepakan_tarif").val().replace(/\,/g, ''));
        let biaya = berat * tarif;
        $("#pengepakan_biaya").val(addCommas(biaya));
    })

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
    
    function muatCalculatejarak(id,jarak = 0){
        $("#pengepakan_jarak"+id).val(addCommas(jarak));
    }

    function template_muatbarang(){
        ++incMuat;
        let template = 
            '<tr id="item'+incMuat+'" data-id="'+incMuat+'">'+
                '<td>'+incMuat+'</td>'+
                '<td>'+
                    '<div class="form-check">'+
                        '<input class="form-check-input cb_muatmanual" id="cb_muatmanual'+incMuat+'" name="muat_manual_cb[]" type="checkbox" value="1">'+
                        '<input id="muat_manual'+incMuat+'" name="muat_manual[]" type="hidden" value="0">'+
                        '<label class="form-check-label" for="cb_muatmanual'+incMuat+'"></label>'+
                    '</div>'+
                '</td>'+
                '<td>'+
                    '<select name="muat_transport_id[]" id="transport_id" class="form-select select2advance" data-select2-placeholder="Jenis transport" data-select2-url="'+base_url+'/get-select/jenis-transport"></select>'+
                '</td>'+
                '<td>'+
                    '<select name="muat_kota_asal_id[]" id="pengepakan_kota_asal_id" class="form-select select2advance muat-jarak" data-select2-placeholder="Tempat berangkat" data-select2-url="'+base_url+'/get-select/kota"></select>'+
                '</td>'+
                '<td>'+
                    '<select name="muat_kota_tujuan_id[]" id="pengepakan_kota_tujuan_id" class="form-select select2advance muat-jarak" data-select2-placeholder="Tempat tujuan" data-select2-url="'+base_url+'/get-select/kota"></select>'+
                '</td>'+
                '<td>'+
                    '<input type="number" name="muat_berat[]" id="pengepakan_berat'+incMuat+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<input type="number" name="muat_jarak[]" id="pengepakan_jarak'+incMuat+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<input type="text" name="muat_biaya[]" id="pengepakan_biaya'+incMuat+'" class="form-control form-control-sm numeric">'+
                '</td>'+
                '<td>'+
                    '<select style="width: 100%" name="muat_metode[]" id="pengepakan_metode'+incMuat+'" class="form-select form-select-sm">'+
                        '<option value="Tiket Bus Manual">Tiket Bus Manual</option>'+
                        '<option value="SBU/M - Dep. Keu.">SBU/M - Dep. Keu.</option>'+
                        '<option value="Dep. Perhubungan">Dep. Perhubungan</option>'+
                        '<option value="Harga Tiket Manual">Harga Tiket Manual</option>'+
                        '<option value="Table Jarak Darat">Table Jarak Darat</option>'+
                        '<option value="Jarak Darat Manual">Jarak Darat Manual</option>'+
                    '</select>'+
                '</td>'+
                '<td>'+
                    '<a href="#" class="kel_delete" data-id="'+incMuat+'"><i class="bx bx-trash"></i></a>'+
                '</td>'+
            '</tr>';
        return template;
    }

    // --------------- UANG HARIAN -------------------
    $(document).on("change","#rampung_bendaharawan_id",function(e){
        let data = $(this).select2('data')[0].data;
        $("#rampung_bendaharawan_nip").val(data.nip);
    })

    $(document).on("change","#rampung_kuasa_nama",function(e){
        let data = $(this).select2('data')[0].data;
        $("#rampung_kuasa_nip").val(data.nip);
    })

    $(document).on("change","#rampung_ppk_id",function(e){
        let data = $(this).select2('data')[0].data;
        $("#rampung_ppk_nip").val(data.nip);
    })

    $(document).on("change","#rampung_anggaran_id",function(e){
        let data = $(this).select2('data')[0].data;
        $("#rampung_anggaran_nip").val(data.nip);
    })

</script>
