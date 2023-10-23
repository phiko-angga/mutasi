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
    var bendaharawan = JSON.parse($("#bendaharawan_list").val());
    var kuasaanggaran = JSON.parse($("#kuasaanggaran_list").val());
    var ppk = JSON.parse($("#ppk_list").val());

    $(document).ready(function () {
        $("#kota_asal_id").select2({width: 'resolve', placeholder:"Pilih tempat berangkat"});
        $("#kota_tujuan_id").select2({width: 'resolve', placeholder:"Pilih tempat tujuan"});
        $("#pejabat_komitmen2_id").trigger('change');
        $('.numeric').maskNumber({integer: true});

        $("#rampung_bendaharawan_nip").val(bendaharawan.nip);
        $("#rampung_kuasa_nip").val(kuasaanggaran.nip);

        // console.log($("#rampung_kuasa_nip").val(),kuasaanggaran.nip);
        $("#rampung_ppk_nip").val(ppk.nip);
        $("#rampung_anggaran_nip").val(ppk.nip);
    })

    $(".bs-stepper")[0].addEventListener('show.bs-stepper', function (event) {
        
        curStep = event.detail.from;
    })

    $(".bs-stepper")[0].addEventListener('shown.bs-stepper', function (event) {
        // console.log(event.detail);
        curStep = event.detail.indexStep;
        // console.log(curStep);
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
        let today = $("#today").val();

        if($(this).prop('id') == 'maksud_ketuama'){
            text = "Untuk melaksanakan tugas ketempat yang baru berdasarkan SK KETUA MAHKAMAH AGUNG RI Nomor : "+nomor+" Tanggal : "+today;
            $("#maksud_perj_dinas").val(text);
        }else
        if($(this).prop('id') == 'maksud_dirjen'){
            text = "Untuk melaksanakan tugas ketempat yang baru berdasarkan SK DIREKTUR JENDERAL BADAN PERADILAN UMUM Nomor : "+nomor+" Tanggal : "+today;
            $("#maksud_perj_dinas").val(text);
        }
    })

    $(document).on("change",".kel_dob",function(){
        let id = $(this).closest('tr').data('id');
        let dob = $(this).val();
        dob = new Date(dob);

        var today = new Date();
        // var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
        
        var diff = Math.floor(today.getTime() - dob.getTime());
        var secs = Math.floor(diff/1000);
        var mins = Math.floor(secs/60);
        var hours = Math.floor(mins/60);
        var days = Math.floor(hours/24);
        var months = Math.floor(days/31);
        var years = Math.floor(months/12);
        months=Math.floor(months%12);
        days = Math.floor(days%31);
        hours = Math.floor(hours%24);
        mins = Math.floor(mins%60);
        secs = Math.floor(secs%60); 

        $('#kel_umur'+id).val(years+' Thn '+months+' Bln '+days+' Hari');
        $('#kel_umur_thn_'+id).val(years);
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
                    '<input readonly type="text" name="kel_umur[]" id="kel_umur'+incKel+'" class="form-control form-control-sm">'+
                    '<input type="hidden" name="kel_umur_thn[]" id="kel_umur_thn_'+incKel+'" class="form-control form-control-sm">'+
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
            $("#biaya_perorang"+id).attr("readonly",false);
        }else{
            $("#trans_manual"+id).val(0);
            $("#biaya_perorang"+id).attr("readonly",true);
        }
    })

    $(document).on("keyup",".trans_biaya",function(){
        let id = $(this).closest('tr').data('id');
        let biaya = parseInt($(this).val().replace(/\,/g, ''))

        let data = {"biaya":biaya,"metode":"Manual"};
        let pembantu = $(this).closest('tr').data('pembantu');
        transportCalculateBiaya(id,data,pembantu);
    })

    $(document).on("change",".biaya-per-orang",function(){
        let id = $(this).closest('tr').data('id');
        
        let data = $("#trans_transport_id"+id).select2('data')[0].data;
        let transport = data.kode;
        url = "/transport/biaya-"+transport.toLowerCase();

        let kota_asal = $("#trans_kota_asal_id"+id).val();
        let kota_tujuan = $("#trans_kota_tujuan_id"+id).val();

        let payload = {kota_asal:kota_asal,kota_tujuan:kota_tujuan};
        let params = {};
        params.url = url;
        params.data = payload;
        params.result = function(data){
            let pembantu = $(this).closest('tr').data('pembantu');
            transportCalculateBiaya(id,data,pembantu);
        }
        ajaxCall(params);

        // let id = $(this).closest('tr').data('id');
        // let pembantu = $(this).closest('tr').data('pembantu');

        // let kota_asal = $("#transport_kota_asal_id").val();
        // let kota_tujuan = $("#transport_kota_tujuan_id").val();

        // let payload = {kota_asal:kota_asal,kota_tujuan:kota_tujuan};
        // let params = {};
        // params.url = '/transport/biaya-per-orang';
        // params.data = payload;
        // params.result = function(data){
        //     let biaya = 0;
        //     if($.isEmptyObject(data)){
        //         biaya = 0;
        //     }else{
        //         biaya = data.harga_tiket;
        //     }
        //     transportCalculateBiaya(id,biaya,pembantu);
        // }
        // ajaxCall(params);
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

    function checkUmur(umur){
        let kelUmur = $("input[name='kel_umur_thn[]']");
        let umurFind = false;
        if(kelUmur.length > 0){
            $.each(kelUmur,function(){
                getUmur = $(this).val();
                if(getUmur <= umur){
                    umurFind = true;
                    return false;
                }

            })
        }
        return umurFind;
    }

    function transportCalculateBiaya(id, data, pembantu = false){

        let biaya = 0;
        if($.isEmptyObject(data)){
            biaya = 0;
        }else{
            biaya = data.biaya;
        }
        
        let total_orang = $("#orang"+id).val();
        $("#biaya_perorang"+id).val(addCommas(biaya));

        // let jumBiaya = pembantu ? 0 : biaya * total_orang;
        let jumBiaya = 0;
        if(!pembantu){
            umur2thn = checkUmur(2);
            if(umur2thn){
                jumBiaya = biaya * 1.67;
            }else{
                jumBiaya  = biaya * 2;
            }
        }

        $("#jumlah_biaya"+id).val(addCommas(jumBiaya));
        
        $("#trans_metode"+id).val(data.metode);
    }

    function biayaCalculate(uangh){
            // console.log(uangh);
        if(uangh == 'orang'){
            let total_orang = $("#uangh_jml_orang").val();
            let hari = $("#uangh_jml_hari").val();
            let tarif = parseInt($("#uangh_jml_tarif").val().replace(/\,/g, ''));
            $("#uangh_jml_biaya").val(addCommas( (total_orang*hari)*tarif ));

            // console.log(total_orang,hari,tarif);
        }else
        if(uangh == 'pembantu'){
            let total_orang = $("#uangh_jml_pembantu").val();
            let hari = $("#uangh_jml_hari_p").val();
            let tarif = parseInt($("#uangh_jml_tarif_p").val().replace(/\,/g, ''));
            
            // console.log(total_orang,hari,tarif);
            $("#uangh_jml_biaya_p").val(addCommas( (total_orang*hari)*tarif ));
        }

        biayaCalculateAll();
    }

    function biayaCalculateTarifHari(){

        let id = $(this).closest('tr').data('id');

        let kota_asal = $("#kota_asal_id").val();
        let kota_tujuan = $("#kota_tujuan_id").val();
        
        let payload = {kota_asal:kota_asal,kota_tujuan:kota_tujuan};
        let params = {};
        params.url = '/uang-harian';
        params.data = payload;
        params.result = function(data){
            $("#uangh_jml_tarif").val(addCommas(data.uangh)).trigger('change');
            $("#uangh_jml_tarif_p").val(addCommas(data.uangh)).trigger('change');
        }
        ajaxCall(params);
    }

    function biayaCalculateAll(){

        var biayaTransport = 0;
        var biayaMuat = 0;

        //HITUNG TOTAL BIAYA TRANSPORT
        let itemTransport = $("#item-transport").find("input[name='trans_jumlah_biaya[]']");
        if(itemTransport.length > 0){
            $.each(itemTransport,function(){
                biaya = parseInt($(this).val().replace(/\,/g, ''));
                biayaTransport += biaya;
            })
        }

        //HITUNG TOTAL BIAYA MUAT BARANG
        let itemMuat= $("#item-muatbarang").find("input[name='muat_biaya[]']");
        if(itemMuat.length > 0){
            $.each(itemMuat,function(){
                biaya = parseInt($(this).val().replace(/\,/g, ''));
                biayaMuat += biaya;
            })
        }
        let pengepakan_biaya = parseInt($("#pengepakan_biaya").val().replace(/\,/g, ''));
        let uangh_jml_biaya = parseInt($("#uangh_jml_biaya").val().replace(/\,/g, ''));
        let uangh_jml_biaya_p = parseInt($("#uangh_jml_biaya_p").val().replace(/\,/g, ''));

        let uangh_jml_uang = biayaTransport + biayaMuat + uangh_jml_biaya + uangh_jml_biaya_p + pengepakan_biaya;
        $("#uangh_jml_uang").val(addCommas(uangh_jml_uang));
        $("#rampung_jumlah").val(addCommas(uangh_jml_uang));
        $("#rampung_dibayar").val(addCommas(uangh_jml_uang));
        $("#uangh_jml_terbilang").val(terbilang(uangh_jml_uang));
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
                    '<select style="width: 100%" name="trans_transport_id[]" id="trans_transport_id'+incKelTrans+'" class="form-select select2advance trans_transport" data-select2-placeholder="Jenis transport" data-select2-url="'+base_url+'/get-select/jenis-transport"></select>'+
                '</td>'+
                '<td style="width:250px">'+
                    '<select style="width: 100%" name="trans_kota_asal_id[]" id="trans_kota_asal_id'+incKelTrans+'" class="form-select select2advance biaya-per-orang" data-select2-placeholder="Tempat berangkat" data-select2-url="'+base_url+'/get-select/kota"></select>'+
                '</td>'+
                '<td style="width:250px">'+
                    '<select style="width: 100%" name="trans_kota_tujuan_id[]" id="trans_kota_tujuan_id'+incKelTrans+'" class="form-select select2advance biaya-per-orang" data-select2-placeholder="Tempat tujuan" data-select2-url="'+base_url+'/get-select/kota"></select>'+
                '</td>';
                
            // if(!pembantu){
                template += '<td '+(pembantu ? 'hidden' : '')+'>'+
                    '<input type="number" readonly name="trans_orang[]" id="orang'+incKelTrans+'" value="'+kel_jumlah+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td '+(pembantu ? 'hidden' : '')+' style="width:220px">'+
                    '<input type="text" readonly name="trans_biaya[]" id="biaya_perorang'+incKelTrans+'" class="form-control form-control-sm numeric trans_biaya">'+
                '</td>';
            // }else{
                template += 
                '<td '+(!pembantu ? 'hidden' : '')+'>'+
                    '<input type="text" name="trans_perkiraan[]" id="rinci_perkiraan'+incKelTrans+'" class="form-control form-control-sm">'+
                '</td>';
            // }

            if(pembantu){
                template += '<td style="width:220px">'+
                                '<select name="trans_jumlah_biaya[]" id="jumlah_biaya'+incKelTrans+'" class="form-select">'+
                                    '<option value="500000">'+addCommas(500000)+'</option>'+
                                    '<option value="200000">'+addCommas(200000)+'</option>'+
                                '</select>'+
                            '</td style="width:220px">';
            }else{
                
                template += '<td style="width:220px">'+
                                '<input readonly type="text" name="trans_jumlah_biaya[]" id="jumlah_biaya'+incKelTrans+'" class="form-control form-control-sm numeric">'+
                            '</td style="width:220px">';
            }
            template += 
                '<td>'+
                    '<input readonly type="text" name="trans_metode[]" id="trans_metode'+incKelTrans+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<a href="#" class="kel_delete" data-id="'+incKelTrans+'"><i class="bx bx-trash"></i></a>'+
                '</td>'+
            '</tr>';
        return template;
        // '<td style="width:300px">'+
        //             '<select style="width: 100%" name="trans_metode[]" id="transport_metode" class="form-select form-select-sm">'+
        //                 '<option value="Tiket Bus Manual">Tiket Bus Manual</option>'+
        //                 '<option value="SBU/M - Dep. Keu.">SBU/M - Dep. Keu.</option>'+
        //                 '<option value="Dep. Perhubungan">Dep. Perhubungan</option>'+
        //                 '<option value="Harga Tiket Manual">Harga Tiket Manual</option>'+
        //                 '<option value="Table Jarak Darat">Table Jarak Darat</option>'+
        //                 '<option value="Jarak Darat Manual">Jarak Darat Manual</option>'+
        //             '</select>'+
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
        getPengepakanBeratMax();
    }

    function initiateUangHarian(){
        let total_kel = $("#item-keluarga").children().length + 1;
        $("#uangh_jml_orang").val(total_kel);

        let pembantu_ikut = $("#pembantu_ikut option:selected").val();
        $("#uangh_jml_pembantu").val(parseInt(pembantu_ikut));

        let lama_dinas = $("#lama_perj_dinas").val();
        $("#uangh_jml_hari").val(lama_dinas);
        $("#uangh_jml_hari_p").val(lama_dinas);

        // let nip = $("#nip").val();
        // $("#rampung_kuasa_nip").val(nip);
        let nama = $("#pegawai_diperintah").val();
        $("#rampung_kuasa_nama").val(nama);

        $('.numeric').maskNumber({integer: true});
        initSelect2();
        
        biayaCalculateTarifHari();
        biayaCalculateAll();
    }

    // ---------------------- MUAT BARANG --------------------------
    $(document).on("change","#pengepakan_transport_id",function(){
        getPengepakanTarif();
    })

    $(document).on("change",".muat_transport",function(){
        let id = $(this).closest('tr').data('id');
        getMuatTarif(id);
    })

    $(document).on("change",".muat-jarak",function(){
        let id = $(this).closest('tr').data('id');

        let kota_asal = $("#pengepakan_kota_asal_id"+id).val();
        let kota_tujuan = $("#pengepakan_kota_tujuan_id"+id).val();
        let transport = $("#pengepakan_transport_id"+id).val();

        let payload = {kota_asal:kota_asal,kota_tujuan:kota_tujuan,transport:transport};
        let params = {};
        params.url = '/pengepakan/jarak';
        params.data = payload;
        params.result = function(data){
            muatCalculatejarak(id,data);
        }
        ajaxCall(params);
    })
    
    $(document).on("change",".muat_manual_cb",function(){
        let id = $(this).closest('tr').data('id');
        let status = $(this).is(":checked");
        if(status){
            $("#muat_manual"+id).val(1);
            $("#muat_metode"+id).val('Manual');
            $("#pengepakan_jarak"+id).attr('readonly',false);
        }else{
            $("#muat_manual"+id).val(0);
            $("#pengepakan_jarak"+id).attr('readonly',true);
            $("#muat_metode"+id).val('');
        }
    })

    $(document).on("keyup","#rampung_dibayar",function(){
        
        let biaya = parseInt($("#rampung_jumlah").val().replace(/\,/g, ''));
        let dibayar = parseInt($(this).val().replace(/\,/g, ''));
        let sisa = biaya - dibayar;
        
        $("#rampung_sisa").val(addCommas(sisa));
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
    
    function muatCalculatejarak(id,data){
        
        let jarak = 0;
        if($.isEmptyObject(data)){
            jarak = 0;
        }else{
            jarak = data.jarak_km;
        }

        $("#pengepakan_jarak"+id).val(addCommas(jarak));
        $("#pengepakan_metode"+id).val(data.metode);

        muatCalculateJumlahBiaya(id);
    }
    
    function muatCalculateJumlahBiaya(id){
        console.log('muatCalculateJumlahBiaya');
        let berat = parseInt($("#pengepakan_berat"+id).val());
        let jarak = parseInt($("#pengepakan_jarak"+id).val());
        let tarif = parseInt($("#muat_tarif").val());
        let percent = 0;
        if(jarak <= 100)
            percent = 70;
        else if(jarak <= 250)
            percent = 50;
        else if(jarak <= 500)
            percent = 30;
        else if(jarak > 500)
            percent = 40;

        let biaya = (jarak * berat * tarif) * percent / 100;
        
        console.log('muatCalculateJumlahBiaya ',biaya,jarak,berat,tarif);
        $("#pengepakan_biaya"+id).val(addCommas(biaya));

    }

    function template_muatbarang(){
        let berat_max = $("#pengepakan_berat").val();
        
        ++incMuat;
        let template = 
            '<tr id="item'+incMuat+'" data-id="'+incMuat+'">'+
                '<td>'+incMuat+'</td>'+
                '<td>'+
                    '<div class="form-check">'+
                        '<input class="form-check-input muat_manual_cb" id="muat_manual_cb'+incMuat+'" name="muat_manual_cb[]" type="checkbox" value="1">'+
                        '<input id="muat_manual'+incMuat+'" name="muat_manual[]" type="hidden" value="0">'+
                        '<label class="form-check-label" for="cb_muatmanual'+incMuat+'"></label>'+
                    '</div>'+
                '</td>'+
                '<td>'+
                    '<select name="muat_transport_id[]" id="pengepakan_transport_id'+incMuat+'" class="form-select select2advance muat_transport" data-select2-placeholder="Jenis transport" data-select2-url="'+base_url+'/get-select/jenis-transport?onlydarat=1"></select>'+
                '</td>'+
                '<td>'+
                    '<select name="muat_kota_asal_id[]" id="pengepakan_kota_asal_id'+incMuat+'" class="form-select select2advance muat-jarak" data-select2-placeholder="Tempat berangkat" data-select2-url="'+base_url+'/get-select/kota"></select>'+
                '</td>'+
                '<td>'+
                    '<select name="muat_kota_tujuan_id[]" id="pengepakan_kota_tujuan_id'+incMuat+'" class="form-select select2advance muat-jarak" data-select2-placeholder="Tempat tujuan" data-select2-url="'+base_url+'/get-select/kota"></select>'+
                '</td>'+
                '<td>'+
                    '<input readonly type="number" name="muat_berat[]" value="'+berat_max+'" id="pengepakan_berat'+incMuat+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<input readonly type="number" name="muat_jarak[]" id="pengepakan_jarak'+incMuat+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<input readonly type="text" name="muat_biaya[]" id="pengepakan_biaya'+incMuat+'" class="form-control form-control-sm numeric">'+
                '</td>'+
                '<td>'+
                    '<input type="text" name="muat_metode[]" id="pengepakan_metode'+incMuat+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<a href="#" class="kel_delete" data-id="'+incMuat+'"><i class="bx bx-trash"></i></a>'+
                '</td>'+
            '</tr>';
        return template;
    }
    
    function getPengepakanBeratMax(){
        let id = $(this).closest('tr').data('id');

        let golongan = $("#pangkat_golongan").val();
        let status_kawin = $("#status_perkawinan option:selected").data('kode');

        let payload = {golongan:golongan,status_kawin:status_kawin};
        let params = {};
        params.url = '/pengepakan/berat-max';
        params.data = payload;
        params.result = function(data){
            let berat = 0;
            if($.isEmptyObject(data)){
                berat = 0;
            }else{
                berat = data.berat_max;
            }
            $("#pengepakan_berat").val(berat);
        }
        ajaxCall(params);
    }

    function getPengepakanTarif(){
        let id = $(this).closest('tr').data('id');

        let transport = $("#pengepakan_transport_id").val();

        let payload = {transport:transport};
        let params = {};
        params.url = '/pengepakan/tarif';
        params.data = payload;
        params.result = function(data){
            let tarif = 0;
            if($.isEmptyObject(data)){
                tarif = 0;
            }else{
                tarif = data.tarif;
            }
            
            berat = $("#pengepakan_berat").val();

            $("#pengepakan_tarif").val(addCommas(tarif));
            $("#pengepakan_biaya").val(addCommas(berat * tarif));
        }
        ajaxCall(params);
    }

    function getMuatTarif(id){
        let transport = $("#pengepakan_transport_id"+id).val();

        let payload = {transport:transport};
        let params = {};
        params.url = '/muat/tarif';
        params.data = payload;
        params.result = function(data){
            let tarif = 0;
            if($.isEmptyObject(data)){
                tarif = 0;
            }else{
                tarif = data.tarif;
            }
            $("#muat_tarif").val(tarif);
        }
        ajaxCall(params);
    }

    // --------------- UANG HARIAN -------------------
    $(document).on("click","#cb_kuasa",function(e){
        let status = $(this).is(":checked");
        if(status){
            let nip = $("#nip").val();
            $("#rampung_kuasa_nip").val(nip);

            $("#rampung_kuasa_nama").show();
            $('#rampung_kuasa_select').next(".select2-container").hide();
        }else{
            $("#rampung_kuasa_nama").hide();
            $("#rampung_kuasa_select").next(".select2-container").show();
            $("#rampung_kuasa_select").val(kuasaanggaran.id).trigger('change');
        }
    })

    $(document).on("change","#rampung_bendaharawan_id",function(e){
        let data = $(this).select2('data')[0].data;
        $("#rampung_bendaharawan_nip").val(data.nip);
    })

    $(document).on("change","#rampung_kuasa_select",function(e){
        let data = $(this).select2('data')[0].data;
        if(typeof data != 'undefined')
            $("#rampung_kuasa_nip").val(data.nip);
        else
            $("#rampung_kuasa_nip").val(kuasaanggaran.nip);
    })

    $(document).on("change","#rampung_ppk_id",function(e){
        let data = $(this).select2('data')[0].data;
        $("#rampung_ppk_nip").val(data.nip);
    })

    $(document).on("change","#rampung_anggaran_id",function(e){
        let data = $(this).select2('data')[0].data;
        $("#rampung_anggaran_nip").val(data.nip);
    })

    //---------- VALIDATE -------------
    $(document).on('click','.btn-stepper-next', function(e){
        let curStep = $(this).data('step');
        console.log('btn-stepper-next',curStep);
        if(curStep == 0){
            validateBiayaPegawai();
        }else if(curStep == 1){
            validateBiayaTransport();
        }else if(curStep == 2){
            validateBiayaMuatBarang();
        }else if(curStep == 3){
            validateUangHarian();
        }
    })

    // $("#form-transaksi").submit(function(e){
    //     validateUangHarian(e);
    // })

    function validateBiayaPegawai(){
        let kembali = false;
        let formselect = false;

        if(!kembali){
            el = $("#nomor");
            if(el.val() == ""){
                kembali = true;
            }
        }
        
        if(!kembali){
            el = $("#nip");
            if(el.val() == ""){
                kembali = true;
            }
        }
            
        if(!kembali){
            el = $("#pegawai_diperintah");
            if(el.val() == ""){
                kembali = true;
            }
        }
            
        if(!kembali){
            el = $("#kota_asal_id");
            if(el.val() == "" || el.val() == null){
                kembali = true;
                formselect = true;
            }
        }
            
        if(!kembali){
            el = $("#kota_tujuan_id");
            if(el.val() == "" || el.val() == null){
                kembali = true;
                formselect = true;
            }
        }

        if(kembali){
            if(formselect)
                el.select2('open');
            else
                el.focus();
            return false;
        }
        stepper.next();
    }
    function validateBiayaTransport(){
        stepper.next();
    }
    function validateBiayaMuatBarang(){
        let kembali = false;
        let formselect = false;
        
        if(!kembali){
            el = $("#pengepakan_transport_id");
            if(el.val() == "" || el.val() == null){
                kembali = true;
                formselect = true;
            }
            console.log(el,el.val());
        }
            console.log(kembali);


        if(kembali){
            if(formselect)
                el.select2('open');
            else
                el.focus();
            return false;
        }
        stepper.next();
    }
    function validateUangHarian(event){
        
        let kembali = false;
        let formselect = false;
        
        if(!kembali){
            el = $("#pengepakan_transport_id");
            if(el.val() == "" || el.val() == null){
                kembali = true;
                formselect = true;
            }
            console.log(el,el.val());
        }
            console.log(kembali);


        if(kembali){
            if(formselect)
                el.select2('open');
            else
                el.focus();
            return false;
        }
        stepper.next();
    }
</script>
