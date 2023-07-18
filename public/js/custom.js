
$('.print_pdf, .print_excel').click(function(e){
  let url = $(this).data('url');
  let search = $("#search").val();
  let provinsi = $("#provinsi_id").val();
  let kota = $("#kota_id").val();
  let kecamatan = $("#kecamatan_id").val();
  let kelurahan = $("#kelurahan_id").val();

  if(url.indexOf("/surveyor") > -1){
    let pelaporan_dpt = $("#pelaporan_dpt").val();
    let pelaporan_suara = $("#pelaporan_suara").val();
    link = url+"?search="+search+"&provinsi="+provinsi+"&kota="+kota+"&kecamatan="+kecamatan+"&kelurahan="+kelurahan+"&pelaporan_dpt="+pelaporan_dpt+"&pelaporan_suara="+pelaporan_suara;
  }else{
    link = url+"?search="+search+"&provinsi="+provinsi+"&kota="+kota+"&kecamatan="+kecamatan+"&kelurahan="+kelurahan;
  }

  window.open(link, '_blank');
})


function fetch_tabledata(url) {
        
  let provinsi = $("#provinsi_id").val();
  let kota = $("#kota_id").val();
  let kecamatan = $("#kecamatan_id").val();
  let kelurahan = $("#kelurahan_id").val();
  let show_per_page = $("#show-per-page").val();
  let search = $("#search").val();

  let payload = {provinsi:provinsi,kota:kota,kecamatan:kecamatan,kelurahan:kelurahan,show_per_page:show_per_page,search:search};
  if(url.indexOf("/surveyor") > -1){
    let pelaporan_dpt = $("#pelaporan_dpt").val();
    let pelaporan_suara = $("#pelaporan_suara").val();
    payload = {provinsi:provinsi,kota:kota,kecamatan:kecamatan,kelurahan:kelurahan,show_per_page:show_per_page,search:search,pelaporan_dpt:pelaporan_dpt,pelaporan_suara:pelaporan_suara};
  }else
  if(url.indexOf("/analisa-data") > -1){
    let analisa_fraud = $("#analisa_fraud").val();
    payload = {provinsi:provinsi,kota:kota,kecamatan:kecamatan,kelurahan:kelurahan,show_per_page:show_per_page,search:search,analisa_fraud:analisa_fraud};
  }

  let params = {};
  params.url = url;
  params.data = payload;
  params.result = function(data){
      $('tbody').html('');
      $('tbody').append(data);

      // getNewUrl(window.location.href,[
      //     {key:'provinsi',value:provinsi},
      //     {key:'kota',value:kota},
      //     {key:'kelurahan',value:kelurahan},
      //     {key:'kecamatan',value:kecamatan},
      //     {key:'show_per_page',value:show_per_page},
      //     {key:'search',value:search},
      // ]);
  }
  ajaxCall(params);
}

function ajaxCall(params = null){
  let baseUrl = window.location.origin;
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
  var x = nStr.split('.');
  var x1 = x[0];
  var x2 = x.length > 1 ? ',' + x[1] : '';
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + '.' + '$2');
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


  function templatePersentaseCapres(data){
    let template = '<div class="col-lg-4 col-md-12 col-sm-12 mb-4 pkandidat'+data.id+'">'+
                        '<h5>'+data.kandidat_nama+'</h5>'+
                        '<div id="growthChart'+data.id+'"></div>'+
                        '<div class="text-center fw-semibold pt-3 mb-2">'+
                            '<img style="margin-right: 12px;width:40px;height:40px;border-radius:5px" src="/images/'+data.image+'" alt="">'+
                            '<span class="suara_total">'+addCommas(data.suara_total)+' Total Suara</span> '+
                        '</div>'+
                    '</div>';
    return template;
  }