<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script>
    var stepperEl = $('.bs-stepper');
    var stepper = new Stepper($('.bs-stepper')[0]);
    var incKel = 0;
    var incKelTrans = 0;
    var incKelTransPembantu = 0;
    var incMuat = 0;
    var curStep = 0;
    var curdate = 0;
    var countPerjDinas = 0;
    var countKelIkut = 0;
    var bendaharawan = JSON.parse($("#bendaharawan_list").val());
    var kuasaanggaran = JSON.parse($("#kuasaanggaran_list").val());
    var penerima = JSON.parse($("#penerima_list").val());
    var ppk = JSON.parse($("#ppk_list").val());

    $(document).ready(function () {
        $("#kota_asal_id").select2({width: 'resolve', placeholder:"Pilih tempat berangkat"});
        $("#kota_tujuan_id").select2({width: 'resolve', placeholder:"Pilih tempat tujuan"});
        $("#pejabat_komitmen2_id").trigger('change');
        $('.numeric').maskNumber({integer: true});

        $("#nip").mask("00000000 000000 0 000");

        // $("#rampung_bendaharawan_nip").val(bendaharawan.nip);
        // $("#rampung_kuasa_nip").val(penerima.nip);

        // console.log($("#rampung_kuasa_nip").val(),kuasaanggaran.nip);
        // $("#rampung_ppk_nip").val(ppk.nip);
        // $("#rampung_anggaran_nip").val(kuasaanggaran.nip);

        //Load Keluarga on Edit
        let keluargaList = JSON.parse($("#keluarga_list").val());
        if(keluargaList.length > 0){
            let item = $("#item-keluarga");
            $.each(keluargaList, function(x,y){
                newkel = template_keluarga(y);
                item.append(newkel);
            })
        }

        //Load Transport on Edit
        let TransportList = JSON.parse($("#transport_list").val());
        if(TransportList.length > 0){
            item = $("#item-transport");
            let total_kel = $("#item-keluarga").children().length + 1;
            $.each(TransportList, function(x,y){
                newkel = template_transport(false,total_kel,y);
                item.append(newkel);
            })
        }

        //Load Transport Pembantu on Edit
        let TransportPembantuList = JSON.parse($("#transport_pembantu_list").val());
        if(TransportPembantuList.length > 0){
            item = $("#item-transport-pembantu");
            let total_kel = $("#item-keluarga-pembantu").children().length + 1;
            $.each(TransportPembantuList, function(x,y){
                newkel = template_transport(true,total_kel,y);
                item.append(newkel);
            })
        }

        //Load Muat Barang on Edit
        let MuatList = JSON.parse($("#muatbarang_list").val());
        if(MuatList.length > 0){
            item = $("#item-muatbarang");
            let total_kel = $("#item-muatbarang").children().length + 1;
            $.each(MuatList, function(x,y){
                newkel = template_muatbarang(y);
                item.append(newkel);
            })
        }
        setTimeout(() => {
            $('.numeric').maskNumber({integer: true});
            initSelect2();
        }, 200);
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

        // dob = new Date(dob);
        // var today = new Date();
        // var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
        
        // var diff = Math.floor(today.getTime() - dob.getTime());
        // var secs = Math.floor(diff/1000);
        // var mins = Math.floor(secs/60);
        // var hours = Math.floor(mins/60);
        // var days = Math.floor(hours/24);
        // var months = Math.floor(days/31);
        // var years = Math.floor(months/12);
        // console.log('days1',days);
        // console.log('months1',months);
        // console.log('years1',years);
        // months=Math.floor(months%12);
        // days = Math.floor(days%31);
        // hours = Math.floor(hours%24);
        // mins = Math.floor(mins%60);
        // secs = Math.floor(secs%60); 
        // console.log('days2',days);
        // console.log('months2',months);
        url = "/kalkulasi-umur";

        let payload = {dob:dob};
        let params = {};
        params.url = url;
        params.data = payload;
        params.result = function(data){
            $('#kel_umur'+id).val(data.tahun+' Thn '+data.bulan+' Bln '+data.hari+' Hari');
            $('#kel_umur_thn_'+id).val(data.tahun);
        }
        ajaxCall(params);

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

        ++countKelIkut;
        $("#jumlah_pengikut").val(countKelIkut);
    })

    $(document).on("click",".kel_delete",function(e){
        e.preventDefault();

        let id = $(this).data('id');
        let item = $("#item-keluarga");
        item.find('tr[id="item'+id+'"]').remove();
        
        --countKelIkut;
        $("#jumlah_pengikut").val(countKelIkut);
    })

    $(document).on("click",".muat_delete",function(e){
        e.preventDefault();

        let id = $(this).data('id');
        let item = $("#item-muatbarang");
        item.find('tr[id="item'+id+'"]').remove();
        muatCalculateJumlahBiayaTotal();
    })

    function template_keluarga(data = null){
        if(data == null){
            data = {};
            data.id = "";
            data.biaya_perj_dinas = 0;
            data.nama = "";
            data.tanggal_lahir = "";
            data.umur = "";
            data.keterangan = "";
        }else{
            data.umur_tahun = data.umur.substr(0,data.umur.indexOf(" Thn"));
        }

        ++incKel;
        let template = 
                    '<tr id="item'+incKel+'" data-id="'+incKel+'">'+
                '<td>'+
                    '<div class="form-check">'+
                        '<input '+(data.biaya_perj_dinas == 1 ? "checked" : "")+' class="form-check-input cb_perj_dinas" id="cb_perj_dinas'+incKel+'" name="kel_perj_dinas_cb[]" type="checkbox" value="1">'+
                        '<input id="perj_dinas'+incKel+'" name="kel_perj_dinas[]" type="hidden" value="'+data.biaya_perj_dinas+'">'+
                        '<input name="kel_id[]" type="hidden" value="'+data.id+'">'+
                        '<label class="form-check-label" for="cb_perj_dinas'+incKel+'"></label>'+
                    '</div>'+
                '</td>'+
                '<td>'+incKel+'</td>'+
                '<td>'+
                    '<input type="text" name="kel_nama[]" id="kel_nama'+incKel+'" value="'+data.nama+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<input type="date" max="" name="kel_dob[]" id="kel_dob'+incKel+'" value="'+data.tanggal_lahir+'" class="form-control form-control-sm kel_dob">'+
                '</td>'+
                '<td>'+
                    '<input readonly type="text" name="kel_umur[]" id="kel_umur'+incKel+'" value="'+data.umur+'" class="form-control form-control-sm">'+
                    '<input type="hidden" name="kel_umur_thn[]" id="kel_umur_thn_'+incKel+'" value="'+data.umur_tahun+'">'+
                '</td>'+
                '<td>'+
                    '<select value="'+data.keterangan+'" name="kel_keterangan[]" id="kel_keterangan'+incKel+'" class="form-select form-select-sm">'+
                        '<option '+(data.keterangan == "Istri" ? 'selected' : '')+' value="Istri">Istri</option>'+
                        '<option '+(data.keterangan == "Suami" ? 'selected' : '')+' value="Suami">Suami</option>'+
                        '<option '+(data.keterangan == "AK" ? 'selected' : '')+' value="AK">AK</option>'+
                        '<option '+(data.keterangan == "AA" ? 'selected' : '')+' value="AA">AA</option>'+
                        '<option '+(data.keterangan == "ART" ? 'selected' : '')+' value="ART">ART</option>'+
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
        // let total_kel = $("#item-keluarga").children().length + 1;
        let total_kel = countPerjDinas + 1;

        let item = $("#item-transport");
        let newt = template_transport(false,total_kel);
        item.append(newt);
        $('.numeric').maskNumber({integer: true});

        setTimeout(() => {
            $('.numeric').maskNumber({integer: true});
            initSelect2();
        }, 200);
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

    $(document).on("change",".trans_jumlah_biaya",function(){
        let id = $(this).closest('tr').data('id');
        let biaya = parseInt($(this).val().replace(/\,/g, ''))

        let data = {"biaya":biaya,"metode":"Manual"};
        let pembantu = $(this).closest('tr').data('pembantu');
        transportCalculateBiaya(id,data,pembantu);
    })

    $(document).on("change",".biaya-per-orang",function(){
        let id = $(this).closest('tr').data('id');
        let pembantu = $(this).closest('tr').data('pembantu');
        
        if(pembantu == false){
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
        }else{
            
            let data = {"biaya":0,"metode":"Manual"};
            transportCalculateBiaya(id,data,pembantu);
        }

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
        
        setTimeout(() => {
            $('.numeric').maskNumber({integer: true});
            initSelect2();
        }, 200);
    })

    $(document).on("click",".cb_transport_manual",function(){
        let id = $(this).closest('tr').data('id');

        let checked = $(this).is(":checked");
        if(checked){
            $("#item-transport").find("#biaya_perorang"+id).attr('readonly',false);
        }else{
            $("#item-transport").find("#biaya_perorang"+id).attr('readonly',true);
        }
    })

    $(document).on("click",".trans_delete",function(e){
        e.preventDefault();

        let id = $(this).closest('tr').data('id');
        let pembantu = $(this).closest('tr').data('pembantu');
        console.log('pembantu',pembantu);
        if(pembantu == true)
            item = $("#item-transport-pembantu");
        else
            item = $("#item-transport");

        item.find('tr[id="item'+id+'"]').remove();
        transportCalculateBiayaTotal();
    })

    $(document).on("keyup",".trans_jumlah_biaya",function(e){
        transportCalculateBiayaTotal();
    })

    function checkUmur(umur){
        let kelUmur = $("input[name='kel_umur_thn[]']");
        // console.log('umur',kelUmur,umur);
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
        // console.log(umurFind);
        return umurFind;
    }

    function transportCalculateBiaya(id, data, pembantu = false){

        let biaya = 0;
        if($.isEmptyObject(data)){
            biaya = 0;
        }else{
            biaya = data.biaya;
        }
        
        let jumlah_pengikut = parseInt($("#jumlah_pengikut").val());
        // let jumlah_pengikut = countPerjDinas

        // let jumBiaya = pembantu ? 0 : biaya * total_orang;
        let jumBiaya = 0;
        if(!pembantu){
            
            $("#item-transport").find("#biaya_perorang"+id).val(addCommas(biaya));

            // metode = $("#trans_metode"+id).val();
            // metode = metode != "" ? metode.toLowerCase() : metode;
            let tranport_selected = $("#trans_transport_id"+id).find('option:selected').html();
            if(tranport_selected != "DARAT"){
                umur2thn = checkUmur(2);
                if(umur2thn){
                    jumBiaya = biaya * (jumlah_pengikut + 0.67);
                }else{
                    jumBiaya  = biaya * (jumlah_pengikut + 1);
                }
            }else{
                jumBiaya  = biaya * 1;
            }

            $("#item-transport").find("#jumlah_biaya"+id).val(addCommas(jumBiaya));
            $("#item-transport").find("#trans_metode"+id).val(data.metode);
        }else{
            
            $("#item-transport-pembantu").find("#biaya_perorang"+id).val(addCommas(biaya));
            $("#item-transport-pembantu").find("#trans_metode"+id).val(data.metode);
        }
        
        transportCalculateBiayaTotal();
    }

    function transportCalculateBiayaTotal(){

        //-------- Total biaya -------------
        let biayaEl = $("#item-transport").find("input[name='trans_jumlah_biaya[]']");
        let totalBiaya = 0;
        if(biayaEl.length > 0){
            $.each(biayaEl,function(){
                getBiaya = parseInt($(this).val().replace(/\,/g, ''));
                totalBiaya += getBiaya;
            })
        }
        $("#trans_total_biaya").html(addCommas(totalBiaya));

        //-------- Total biaya pembantu -------------
        biayaEl = $("#item-transport-pembantu").find("input[name='trans_jumlah_biaya[]']");
        totalBiaya = 0;
        if(biayaEl.length > 0){
            $.each(biayaEl,function(){
                getBiaya = parseInt($(this).val().replace(/\,/g, ''));
                totalBiaya += getBiaya;
            })
        }
        $("#trans_total_biaya_pembantu").html(addCommas(totalBiaya));
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
        biayaMuat = biayaMuat > 2000000 ? 2000000 : biayaMuat; 

        let pengepakan_biaya = parseInt($("#pengepakan_biaya").val().replace(/\,/g, ''));
        let uangh_jml_biaya = parseInt($("#uangh_jml_biaya").val().replace(/\,/g, ''));
        let uangh_jml_biaya_p = parseInt($("#uangh_jml_biaya_p").val().replace(/\,/g, ''));

        let uangh_jml_uang = biayaTransport + biayaMuat + uangh_jml_biaya + uangh_jml_biaya_p + pengepakan_biaya;
        $("#uangh_jml_uang").val(addCommas(uangh_jml_uang));
        $("#rampung_jumlah").val(addCommas(uangh_jml_uang));
        $("#rampung_dibayar").val(addCommas(uangh_jml_uang));
        $("#uangh_jml_terbilang").val(terbilang(uangh_jml_uang));
    }

    function template_transport(pembantu = false, kel_jumlah = 0, data = null){
        if(data == null){
            data = {};
            data.id = "";
            data.manual = 0;
            data.transport_id = "";
            data.kota_asal_id = "";
            data.kota_tujuan_id = "";
            data.orang = "0";
            data.rinci_perkiraan = "";
            data.biaya_perorang = 0;
            data.jumlah_biaya = "0";
            data.metode = "";
        }

        let inc = 0;
        if(pembantu){
            ++incKelTransPembantu;
            inc = incKelTransPembantu;
        }else{
            ++incKelTrans;
            inc = incKelTrans;
        }


        let template = 
            '<tr id="item'+inc+'" data-id="'+inc+'" data-pembantu="'+pembantu+'">'+
                '<td>'+inc+'</td>';

                template += '<td '+(pembantu ? 'hidden' : '')+'>'+
                    '<div class="form-check">'+
                        '<input '+(data.manual == 1 ? 'checked' : '')+' class="form-check-input trans_manual_cb" id="trans_manual_cb'+inc+'" name="trans_manual_cb[]" type="checkbox" value="1">'+
                        '<input id="trans_manual'+inc+'" name="trans_manual[]" type="hidden" value="'+data.manual+'">'+
                        '<input name="trans_id[]" type="hidden" value="'+data.id+'">'+
                        '<label class="form-check-label" for="cb_manual'+inc+'"></label>'+
                    '</div>'+
                '</td>';

            template += '<td>'+
                    '<input type="hidden" name="trans_pembantu[]" value="'+(pembantu ? 1 : 0)+'">'+
                    '<select style="width: 100%" name="trans_transport_id[]" id="trans_transport_id'+inc+'" class="form-select select2advance trans_transport" data-select2-placeholder="Jenis transport" data-select2-url="'+base_url+'/get-select/jenis-transport?excludelaut=1">'+
                    (data.transport_id != "" ? "<option value='"+data.transport_id+"'>"+data.transport_nama+"</option>" : "")+
                    '</select>'+
                '</td>'+
                '<td style="width:250px">'+
                    '<select style="width: 100%" name="trans_kota_asal_id[]" id="trans_kota_asal_id'+inc+'" class="form-select select2advance biaya-per-orang" data-select2-wilayah="1" data-select2-placeholder="Tempat berangkat" data-select2-url="'+base_url+'/get-select/kota">'+
                    (data.kota_asal_id != "" ? "<option value='"+data.kota_asal_id+"'>"+(data.kotaa_nama+'#'+data.provinsia_nama)+"</option>" : "")+
                    '</select>'+
                '</td>'+
                '<td style="width:250px">'+
                    '<select style="width: 100%" name="trans_kota_tujuan_id[]" id="trans_kota_tujuan_id'+inc+'" class="form-select select2advance biaya-per-orang" data-select2-wilayah="1" data-select2-placeholder="Tempat tujuan" data-select2-url="'+base_url+'/get-select/kota">'+
                    (data.kota_tujuan_id != "" ? "<option value='"+data.kota_tujuan_id+"'>"+(data.kotat_nama+'#'+data.provinsit_nama)+"</option>" : "")+
                    '</select>'+
                '</td>';
                
            // if(!pembantu){
                template += '<td '+(pembantu ? 'hidden' : '')+'>'+
                    '<input type="number" readonly name="trans_orang[]" id="orang'+inc+'" value="'+kel_jumlah+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td '+(pembantu ? 'hidden' : '')+' style="width:220px">'+
                    '<input type="text" value="'+addCommas(data.biaya_perorang)+'" readonly name="trans_biaya[]" id="biaya_perorang'+inc+'" class="form-control form-control-sm numeric trans_biaya">'+
                '</td>';
            // }else{
                template += 
                '<td '+(!pembantu ? 'hidden' : '')+'>'+
                    '<input type="text" value="'+data.rinci_perkiraan+'" name="trans_perkiraan[]" id="rinci_perkiraan'+inc+'" class="form-control form-control-sm">'+
                '</td>';
            // }

            // if(pembantu){
            //     template += '<td style="width:220px">'+
            //                     '<select value="'+data.jumlah_biaya+'" name="trans_jumlah_biaya[]" id="jumlah_biaya'+inc+'" class="form-select form-select-sm trans_jumlah_biaya">'+
            //                         '<option '+(data.jumlah_biaya == 500000 ? 'selected' : '')+' value="500000">'+addCommas(500000)+'</option>'+
            //                         '<option '+(data.jumlah_biaya == 200000 ? 'selected' : '')+' value="200000">'+addCommas(200000)+'</option>'+
            //                     '</select>'+
            //                 '</td style="width:220px">';
            // }else{
                
                template += '<td style="width:220px">'+
                                '<input '+(pembantu == true ? '' : 'readonly')+' type="text" value="'+addCommas(data.jumlah_biaya)+'" name="trans_jumlah_biaya[]" id="jumlah_biaya'+inc+'" class="form-control form-control-sm text-end numeric trans_jumlah_biaya">'+
                            '</td style="width:220px">';
            // }
            template += 
                '<td>'+
                    '<input readonly type="text" value="'+data.metode+'" name="trans_metode[]" id="trans_metode'+inc+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<a href="#" class="trans_delete" data-id="'+inc+'"><i class="bx bx-trash"></i></a>'+
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

    $(document).on("change",".muat-jarak-manual",function(){
        let id = $(this).closest('tr').data('id');
        data = {jarak_km:$(this).val(),metode:"Manual"};
        muatCalculatejarak(id,data);
    })
    
    $(document).on("change",".muat_manual_cb",function(){
        let id = $(this).closest('tr').data('id');
        let status = $(this).is(":checked");
        if(status){
            $("#muat_manual"+id).val(1);
            $("#pengepakan_metode"+id).val('Manual');
            $("#pengepakan_jarak"+id).attr('readonly',false);
        }else{
            $("#muat_manual"+id).val(0);
            $("#pengepakan_jarak"+id).attr('readonly',true);
            $("#pengepakan_metode"+id).val('');
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

        $("#pengepakan_jarak"+id).val(jarak);
        $("#pengepakan_metode"+id).val(data.metode);

        muatCalculateJumlahBiaya(id);
    }
    
    function muatCalculateJumlahBiaya(id){
        console.log('pengepakan_jarak_id',$("#pengepakan_jarak"+id).val());
        let berat = parseInt($("#pengepakan_berat"+id).val());
        let jarak = parseInt($("#pengepakan_jarak"+id).val().replace(/\,/g, ''));
        let tarif = parseInt($("#pengepakan_tarif"+id).val().replace(/\,/g, ''));
        tarif = tarif == "" ? 0 : tarif;

        let percent = 0;
        if(jarak <= 100)
            percent = 70;
        else if(jarak <= 250)
            percent = 50;
        else if(jarak <= 500)
            percent = 30;
        else if(jarak > 500)
            percent = 40;

        // console.log(jarak,berat,tarif,percent);
        let biaya = (jarak * berat * tarif) * percent / 100;
        biaya = Math.round(biaya/1000)*1000;
        
        // console.log('muatCalculateJumlahBiaya ',biaya,jarak,berat,tarif);
        $("#pengepakan_biaya"+id).val(addCommas(biaya));
        muatCalculateJumlahBiayaTotal();
    }

    function muatCalculateJumlahBiayaTotal(){
        
        //-------- Total biaya -------------
        let biayaEl = $("#item-muatbarang").find("input[name='muat_biaya[]']");
        let totalBiaya = 0;
        if(biayaEl.length > 0){
            $.each(biayaEl,function(){
                getBiaya = parseInt($(this).val().replace(/\,/g, ''));
                totalBiaya += getBiaya;
            })
        }
        totalBiaya = totalBiaya > 2000000 ? 2000000 : totalBiaya;
        $("#muat_total_biaya").html(addCommas(totalBiaya));

    }

    function template_muatbarang(data = null){
        
        if(data == null){
            data = {};
            data.id = "";
            data.manual = 0;
            data.transport_id = "";
            data.kota_asal_id = "";
            data.kota_tujuan_id = "";
            data.berat = 0;
            data.jarak = 0;
            data.tarif = 0;
            data.biaya = 0;
            data.metode = "";
        }

        let berat_max = $("#pengepakan_berat").val();
        
        ++incMuat;
        let template = 
            '<tr id="item'+incMuat+'" data-id="'+incMuat+'">'+
                '<td>'+incMuat+'</td>'+
                '<td>'+
                    '<div class="form-check">'+
                        '<input '+(data.manual == 1 ? 'checked' : '')+' class="form-check-input muat_manual_cb" id="muat_manual_cb'+incMuat+'" name="muat_manual_cb[]" type="checkbox" value="1">'+
                        '<input id="muat_manual'+incMuat+'" name="muat_manual[]" type="hidden" value="'+data.manual+'">'+
                        '<input name="muat_id[]" type="hidden" value="'+data.id+'">'+
                        '<label class="form-check-label" for="cb_muatmanual'+incMuat+'"></label>'+
                    '</div>'+
                '</td>'+
                '<td>'+
                    '<select name="muat_transport_id[]" id="pengepakan_transport_id'+incMuat+'" class="form-select select2advance muat_transport" data-select2-placeholder="Jenis transport" data-select2-url="'+base_url+'/get-select/jenis-transport?onlydarat=1">'+
                    (data.transport_id != "" ? "<option value='"+data.transport_id+"'>"+data.transport_nama+"</option>" : "")+
                    '</select>'+
                '</td>'+
                '<td>'+
                    '<select name="muat_kota_asal_id[]" id="pengepakan_kota_asal_id'+incMuat+'" class="form-select select2advance muat-jarak" data-select2-wilayah="1" data-select2-placeholder="Tempat berangkat" data-select2-url="'+base_url+'/get-select/kota">'+
                    (data.kota_asal_id != "" ? "<option value='"+data.kota_asal_id+"'>"+(data.kotaa_nama+'#'+data.provinsia_nama)+"</option>" : "")+
                    '</select>'+
                '</td>'+
                '<td>'+
                    '<select name="muat_kota_tujuan_id[]" id="pengepakan_kota_tujuan_id'+incMuat+'" class="form-select select2advance muat-jarak" data-select2-wilayah="1" data-select2-placeholder="Tempat tujuan" data-select2-url="'+base_url+'/get-select/kota">'+
                    (data.kota_tujuan_id != "" ? "<option value='"+data.kota_tujuan_id+"'>"+(data.kotat_nama+'#'+data.provinsit_nama)+"</option>" : "")+
                    '</select>'+
                '</td>'+
                '<td>'+
                    '<input readonly type="number" name="muat_berat[]" value="'+berat_max+'" id="pengepakan_berat'+incMuat+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<input readonly type="number" value="'+data.jarak+'" name="muat_jarak[]" id="pengepakan_jarak'+incMuat+'" class="form-control form-control-sm muat-jarak-manual">'+
                    '<input type="hidden" value="'+data.tarif+'" name="muat_tarif[]" id="pengepakan_tarif'+incMuat+'">'+
                '</td>'+
                '<td>'+
                    '<input readonly type="text" value="'+(addCommas(data.biaya))+'" name="muat_biaya[]" id="pengepakan_biaya'+incMuat+'" class="form-control form-control-sm text-end numeric">'+
                '</td>'+
                '<td>'+
                    '<input readonly type="text" value="'+data.metode+'" name="muat_metode[]" id="pengepakan_metode'+incMuat+'" class="form-control form-control-sm">'+
                '</td>'+
                '<td>'+
                    '<a href="#" class="muat_delete" data-id="'+incMuat+'"><i class="bx bx-trash"></i></a>'+
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
            $("#pengepakan_tarif"+id).val(tarif);
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
        console.log($(this).select2('data'),data);
        $("#rampung_bendaharawan_nip").val(data.nip);
    })

    $(document).on("change","#rampung_kuasa_select",function(e){
        let data = $(this).select2('data')[0].data;
        if(typeof data != 'undefined')
            $("#rampung_kuasa_nip").val(data.nip);
        else
            $("#rampung_kuasa_nip").val(penerima.nip);
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
        curStep = $(this).data('step');
        // console.log('btn-stepper-next',curStep);
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

    $(document).on('keydown',function(e) {
        if(e.which == 13) {
            e.preventDefault();
            return false;
            $(".btn-stepper-next").trigger('click');
        }
    });

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

        countPerjDinas = 0;
        let perjDinas = $("input[name='kel_perj_dinas_cb[]']");
        $.each(perjDinas,function(i,r){
            if($(this).is(':checked'))
                ++countPerjDinas;
        })
        // console.log('countPerjDinas',countPerjDinas);

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
            // console.log(el,el.val());
        }
            // console.log(kembali);


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
