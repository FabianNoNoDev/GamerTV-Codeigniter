
var item_list = [];


function deal_item(item_data){

    this.data = item_data;
    this.data.current_price = number_format(this.data.current_price, 0, '.','.')+" Ft";

   if(this.get_id(this.data.id) == null)
   {
      this.key = this.data.id;
      this.create_item();
      return;
   }
   else
   {
     this.update_data();  
   }    
   
}

deal_item.prototype.update_timer = function()
{
           var time = this.data.start_in_sec; 
           
            var termek = $("[item-data="+this.data.id+"]");  
    
            termek.find('.bluefooter').html(second_to_string(time));
           
             if(termek.find('.banner.blue.open').length===0)
             {    
             countdown(time,termek.find('.bluefooter'));
             termek.find('.banner.blue').addClass('open');
             }
                     
}


deal_item.prototype.get_id = function(id)
{
    for (var index = 0, len = item_list.length; index < len; ++index) {
       if(item_list[index].data.id == id)
       {
           return index;
       }
    }
    return null;
}

deal_item.prototype.replace_item = function(){
      
    $( "#active_item_list" ).append(this.draw_list_box());
    item_list.push(this);
    this.update_data();  
}

deal_item.prototype.remove_item = function(){
      
    $( "#active_item_list" ).append(this.draw_list_box());
    item_list.push(this);
    this.update_data();  
}


deal_item.prototype.create_item = function(){
      
    $( "#active_item_list" ).append(this.draw_list_box());
    item_list.push(this);
    this.update_data();  
}


deal_item.prototype.update_data = function()
{

    var termek = $("[item-data="+this.data.id+"]");  
    
    termek.find('.current_price').html(this.data.current_price);

    if(this.data.status===1)
    {
      termek.find('.banner.red').removeClass('open');   
      termek.find('.banner.blue').removeClass('open');   
    }    

    if(this.data.status&4)
    {
     termek.find('.banner.red').addClass('open'); 
    }
    
    if(this.data.status&2 && this.data.start_in_sec>0)
    {
     this.update_timer();
    }
    
}


deal_item.prototype.draw_list_box = function()
{
  var result = '<div  class="col-sm-6 col-xs-12 col-md-3">'
                        +'<div event-data="'+this.data.event_id+'" item-data="'+this.data.id+'" class="productbox">'
                        +'<a href="'+window.baseurl+'deal/'+this.data.id+'"   >  <div class="imgthumb img-responsive">'
                                            +'<img class="img-responsive" src="'+window.baseurl+'products/525x420.jpg">'
                                               +'<div class="banner red">'
                                                            +'<div class="bannerheader red">'+window.sitelang.auction_end+'</div>'
                                                            +'<div class="bannerfooter">'
                                                               + '<div class="bannerfootergrey">'+window.sitelang.this_deal_is+'</div>'
                                                               + '<div class="bannerfootercolor red uppercase">'+window.sitelang.gone+'!</div>'
                                                           + '</div>'
                                              +  '</div>'
                                              +  '<div class="banner blue">'
                                                 +       '<div class="bannerheader blue">'+window.sitelang.auction_new_round+'</div>'
                                                  +      '<div class="bannerfooter">'
                                                  +          '<div class="bannerfootergrey">'+window.sitelang.this_deal_is+'</div>'
                                                  +          '<div class="bannerfootercolor blue uppercase bluefooter">'           
                                                  +          '</div>'
                                                  +      '</div>'
                                             +  '</div>'
                                   + '</div>'
                             +   '<div class="box-header" data="'+this.data.id+'">'
                                +   this.data.name
                                +   '</div> </a>'
                                +    '<div class="caption">'
                                  +      ''+window.sitelang.retail_price+': '+this.data.retail+' Ft'
                                  +              '<h2 class="pull-right current_price">'+this.data.current_price+'</h2>'
                                  +      '<p>'
                                  +        '<button data="deal_button" item-buy-id="'+this.data.id+'" type="button" class="deal_button uppercase">'+window.sitelang.buy_now_deal+'!</button>'
                                   +     '</p>'
                                 +   '</div>'
                        +  '</div>'
                    +'</div>'
                +'</div>';

             // console.log(result);

    return result;
};