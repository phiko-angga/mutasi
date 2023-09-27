
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
    
    // $("#provinsi_tujuan_id").data("select2-url",base_url+'/get-select/provinsi?exclude='+$(this).val());
    $("#provinsi_tujuan_id").data("select2-url",base_url+'/get-select/provinsi');
    $("#provinsi_tujuan_id").val("");
    initSelect2();
})

$(document).on('change','#provinsi_tujuan_id',function(e){
    $("#kota_tujuan_id").data("select2-url",base_url+'/get-select/kota?provinsi='+$(this).val());
    $("#kota_tujuan_id").val("");
    initSelect2();
})
