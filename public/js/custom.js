
$('.print_pdf, .print_excel').click(function(e){
  let url = $(this).data('url');
  let search = $("#search").val();
  let provinsi = $("#provinsi_id").val();
  let kota = $("#kota_id").val();

  link = url+"?search="+search+"&provinsi="+provinsi+"&kota="+kota;
  

  window.open(link, '_blank');
})


function fetch_tabledata(url) {
        
  let provinsi = $("#provinsi_id").val();
  let kota = $("#kota_id").val();
  let show_per_page = $("#show-per-page").val();
  let search = $("#search").val();

  let payload = {provinsi:provinsi,kota:kota,show_per_page:show_per_page,search:search};

  let params = {};
  params.url = url;
  params.data = payload;
  params.result = function(data){
      $('tbody').html('');
      $('tbody').append(data);
  }
  ajaxCall(params);
}

function ajaxCall(params = null){
  let baseUrl = base_url;
  let url = '';
  let type = 'get';
  let data = '';
  let result = function(response){
    console.log(response);
  };

  if(params != null){
    if(typeof params.baseUrl != 'undefined') baseUrl = params.baseUrl;
    if(typeof params.url != 'undefined') url = params.url;
    if(typeof params.type != 'undefined') type = params.type;
    if(typeof params.data != 'undefined') data = params.data;
    if(typeof params.result != 'undefined') result = params.result;
  }

  $.ajax({
    url:baseUrl+url,
    type:type,
    data:data,
    success:result
  });
}

function getNewUrl(oldUrl = '', query) {
  var newUrl = oldUrl; 

  if(query.length > 0){
    $.each(query, function(index, val){

      if (oldUrl.match(val.key)) {
        
        var url = new URL(newUrl);
        url.searchParams.set(val.key, val.value); // setting your param
        newUrl = url.href;
      } else if (/\?/.test(newUrl)) {
        newUrl = newUrl +'&'+ val.key+"=" + val.value;
      } else {
        newUrl = newUrl + "?"+val.key+"=" + val.value;
      }
    })
    history.pushState('', '', newUrl);
  }
}  

function addCommas(nStr) {
  nStr += '';
  var x = nStr.split(',');
  var x1 = x[0];
  var x2 = x.length > 1 ? '.' + x[1] : '';
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2');
  }
  return x1 + x2;
}

function formatDesign(item) {
    var selectionText = item.text.split("#");
    if(typeof selectionText[1] != 'undefined')
        var $returnString = $('<span>'+selectionText[0] + '</br><small>' + selectionText[1]  + '</small></span><hr style="margin-top: 0.2rem;margin-bottom: 0.2rem">');
    else
        var $returnString = selectionText;
    return $returnString;
  };
  
  function formatDesignSelected(item) {
    var selectionText = item.text.split("#");
    var $returnString = $('<span>'+selectionText[0] + (typeof selectionText[1] != 'undefined' ? ' | ' +selectionText[1] : '') + '</span>');
    return $returnString;
  };

  function initSelect2(){
        
    if ( $('.select2advance').length > 0 ){
        $('.select2advance').each(function(index, el) {
            var limit_rows = 10;
            var url = $(this).data('select2-url');
            var placeholder = $(this).data('select2-placeholder');

            $(this).select2({
                width: 'resolve',
                placeholder: placeholder,
                ajax: {
                    url: url,
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page,
                            page_limit: limit_rows,
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

  $(document).on('change','#provinsi_asal_id',function(e){
    $("#kota_asal_id").data("select2-url",base_url+'/get-select/kota?provinsi='+$(this).val());
    $("#kota_asal_id").val("");
    
    if(typeof $(this).data('exclude') !== 'undefined' && $(this).data('exclude') == 1)
      $("#provinsi_tujuan_id").data("select2-url",base_url+'/get-select/provinsi?exclude='+$(this).val());
    else
      $("#provinsi_tujuan_id").data("select2-url",base_url+'/get-select/provinsi');

    $("#provinsi_tujuan_id").val("");
    initSelect2();
  })

  $(document).on('change','#provinsi_tujuan_id',function(e){
    if(typeof $(this).data('kota_exclude') !== 'undefined' && $(this).data('kota_exclude') == 1)
      $("#kota_tujuan_id").data("select2-url",base_url+'/get-select/kota?provinsi='+$(this).val()+"&exclude="+$("#kota_asal_id").val());
    else
      $("#kota_tujuan_id").data("select2-url",base_url+'/get-select/kota?provinsi='+$(this).val());

    $("#kota_tujuan_id").val("");
    initSelect2();
  })

  async function show_confirm(param){   
    console.log('ok');
    const alert =  await Swal.fire({
        title: param.pesan,
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: 'Iya',
        denyButtonText: 'Tidak',
    }).then(param.response)
  }

  function terbilang(bilangan) {

    bilangan    = String(bilangan);
    let angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
    let kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
    let tingkat = new Array('','Ribu','Juta','Milyar','Triliun');

    let panjang_bilangan = bilangan.length;
    let kalimat= subkalimat = kata1 = kata2 = kata3 = "";
    let i= j= 0;

     /* pengujian panjang bilangan */
           if (panjang_bilangan > 15) {
               kalimat = "Diluar Batas";
               return kalimat;
           }

           /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
           for (i = 1; i <= panjang_bilangan; i++) {
               angka[i] = bilangan.substr(-(i),1);
           }

           i = 1;
           j = 0;
           kalimat = "";

           /* mulai proses iterasi terhadap array angka */
           while (i <= panjang_bilangan) {

               subkalimat = "";
               kata1 = "";
               kata2 = "";
               kata3 = "";

               /* untuk Ratusan */
               if (angka[i+2] != "0") {
                   if (angka[i+2] == "1") {
                   kata1 = "Seratus";
                   } else {
                   kata1 = kata[angka[i+2]] + " Ratus";
                   }
               }

               /* untuk Puluhan atau Belasan */
               if (angka[i+1] != "0") {
                   if (angka[i+1] == "1") {
                   if (angka[i] == "0") {
                       kata2 = "Sepuluh";
                   } else if (angka[i] == "1") {
                       kata2 = "Sebelas";
                   } else {
                       kata2 = kata[angka[i]] + " Belas";
                   }
                   } else {
                   kata2 = kata[angka[i+1]] + " Puluh";
                   }
               }

               /* untuk Satuan */
               if (angka[i] != "0") {
                   if (angka[i+1] != "1") {
                   kata3 = kata[angka[i]];
                   }
               }

               /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
               if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
                   subkalimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
               }

               /* gabungkan variabe sub kalimat (untuk Satu blok 3 angka) ke variabel kalimat */
               kalimat = subkalimat + kalimat;
               i = i + 3;
               j = j + 1;

           }

           /* mengganti Satu Ribu jadi Seribu jika diperlukan */
           if ((angka[5] == "0") && (angka[6] == "0")) {
               kalimat = kalimat.replace("Satu Ribu","Seribu");
           }

           return (kalimat.trim().replace(/\s{2,}/g, ' ')) + " Rupiah";
       }