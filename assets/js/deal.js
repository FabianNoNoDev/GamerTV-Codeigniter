/* Penny Auction for Codeigniter */ 

// Generic Tick Timer
var  TICK_TIME = 1000;
// Generic Item list


$(function() {
    
     var event_id = $('#active_item_list').attr('event-data');
     var singe_item_id =  $('.single_deal_box').attr('item-data');
    
    //console.log(event_id);
    
    if(typeof event_id != 'undefined')
        {
           auto_update_event(event_id);    
        }
        
     if(typeof singe_item_id != 'undefined')
        {
          auto_update_item(singe_item_id);
        }    
    // Launch Auto Update
     
    
});


$( document ).on( 'click', 'button', function() {
    
   if($(this).attr('data')==="deal_button") 
   {
    var item_id =  $(this).closest('.productbox').attr('item-data');
    deal_add_cart(item_id);
    }
});



function auto_update_item(singe_item_id)
{
   var item_id = singe_item_id;
   
   deal_item_update(item_id);
   setTimeout("auto_update_item("+item_id+")",TICK_TIME);
}

function auto_update_event(event_id)
{
   var event_id = event_id;

   deal_event_update(event_id);
   setTimeout("auto_update_event("+event_id+")",TICK_TIME);
   
   //console.log(item_list[0].data.id);
   
}



function deal_item_update(item_id)
{

    var item_id = item_id;

   $.ajax({
    url: ''+window.baseurl+'ajax/deal_single_item/'+item_id+'',
    type: "GET",
    dataType: 'json', 
    success: function(data)
    {
      
      update_item(data);
       
    },
    error: function (data)
    {
      console.log("Error");
    }
        });  
}

function deal_event_update(event_id)
{

    var event_id = event_id;

   $.ajax({
    url: ''+window.baseurl+'ajax/deal_item_list/'+event_id+'',
    type: "GET",
    dataType: 'json', 
    success: function(data)
    {
      for(var k in data) {
            new deal_item(data[k]);
         }  
    },
    error: function (data)
    {
      console.log("Error");
    }
        });  
}




function deal_add_cart(id,count)
{
    var result = "";
    var id;
    var count;
    
    var post_data = {id:id,count:count};
    
   $.ajax({
    url: ''+window.baseurl+'ajax/deal_add_cart/',
    type: "POST",
    data: post_data,
    dataType: 'json', 
    success: function(data)
    {
      var response = JSON.parse(data);  
      var handling = new Response_handler(response);
      handling.action();
      
      //console.log("fos");
      
    },
    error: function (data)
    {
      //console.log("Error");
      // TODO Error MSG!
    }
        });  
}

function elapsepad(d) {
    return (d < 10) ? '0' + d.toString() : d.toString();
     }


function second_to_string(time)
{
    if(time<=0)
    {
      return "0:00";  
    }
    
    var seconds = Math.round(time % 60);

           time = Math.floor(time / 60);

             var minutes = Math.round(time % 60);

               time = Math.floor(time / 60);

                 var hours = Math.round(time % 24);

                     var days = Math.floor(time / 24);

                       if(days>0){
                       var string_ido = elapsepad(days)+" Nap "+elapsepad(hours)+":"+elapsepad(minutes)+":"+elapsepad(seconds);
                       }
                       else if(hours>0)
                       {
                       var string_ido = hours+":"+elapsepad(minutes)+":"+elapsepad(seconds);   
                       }
                       else
                       {
                        var string_ido = elapsepad(minutes)+":"+elapsepad(seconds);      
                       }   
    
    return string_ido;
    
}



function countdown(time, element) {

    if(time<0)
    {
      return;  
    }  
    var timeleft_main= Math.abs(time); 
    
    var element = element;

                var mycountdown = setInterval(function() {
                        
                        var timeleft = timeleft_main;
                        
                                    element.html(second_to_string(timeleft));

                if (timeleft_main <= 0) {
                    clearInterval(mycountdown);
                }
                else
                {
                 timeleft_main--;
                }
                }, 1000);
 }
 
 
       $('.countdown').each(function() {
            var time = $(this).attr('data'); 
            $(this).html(second_to_string(time));
           countdown(time,$(this));
        });
        
     
// 3rd Party Code
function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + '')
    .replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
    .split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '')
    .length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1)
      .join('0');
  }
  return s.join(dec);
}
        