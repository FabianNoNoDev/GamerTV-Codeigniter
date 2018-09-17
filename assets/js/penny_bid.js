/* Penny Auction for Codeigniter */ 



$( "button" ).click(function()
{   
   if($(this).attr('data')==="bid_button") 
   {
    var itemname = $(this).closest('.productbox').find('.winner').html();
    var item_id =  $(this).closest('.productbox').find('.box-header').attr('data');
    console.log($(this));   
    console.log(itemname);
    console.log(item_id);
    bid_item(item_id);
    }
   
});



function bid_item(id)
{
    var result = "";
    var id;
    
    var bid_data = {id:id};
    
   $.ajax({
    url: '//'+location.hostname+'/ajax/bid_item/',
    type: "POST",
    data: bid_data,
    dataType: 'json', 
    success: function(data)
    {
      console.log(data);  
    },
    error: function (data)
    {
      console.log("Error");
    }
        });  
}

function elapsepad(d) {
    return (d < 10) ? '0' + d.toString() : d.toString();
     }

function countdown(time, element) {

    var timeleft_main= Math.abs(time); 
    
    var element = element;

                var mycountdown = setInterval(function() {
                        
                        var timeleft = timeleft_main;
                        
                         var seconds = Math.round(timeleft % 60);

                                timeleft = Math.floor(timeleft / 60);

                                  var minutes = Math.round(timeleft % 60);

                                    timeleft = Math.floor(timeleft / 60);

                                      var hours = Math.round(timeleft % 24);

                                          var days = Math.floor(timeleft / 24);

                                            if(days>0){
                                            var string_ido = elapsepad(days)+" Nap "+elapsepad(hours)+":"+elapsepad(minutes)+":"+elapsepad(seconds);
                                            }
                                            else if(hours>0)
                                            {
                                            var string_ido = hours+":"+elapsepad(minutes)+":"+elapsepad(seconds);   
                                            }
                                            else
                                            {
                                             var string_ido = hours+":"+elapsepad(minutes)+":"+elapsepad(seconds);      
                                            }

                                    element.html(string_ido);

                if (timeleft_main === 0) {
                    clearInterval(mycountdown);
                    //call your function
                }
                else {
                    timeleft_main--;
                   }
                }, 1000);
 }
 
 
       $('.countdown').each(function() {
            var time = $(this).attr('data'); 
           countdown(time,$(this));
        });