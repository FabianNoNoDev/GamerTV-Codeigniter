
$(document).ready(function() {
  $('#page_content').summernote(
  {
  minHeight: 300,             // set minimum height of editor
  maxHeight: null,             // set maximum height of editor
  focus: true         
  });
  
  if(window.pages==1){
  get_pages();}
  
  if(window.twitch==1)
  {    
  get_twitch_banned();
  get_twitch_groups();
  get_twitch_custom_list();
  }
  
});

$('body').on('click', 'a', function() {
    if($(this).data('pagedelete'))
    {  
      delete_pages($(this).data('pagedelete'));  
    }
    if($(this).data('twitchunban'))
    {
       twitch_unban($(this).data('twitchunban')); 
    }
    if($(this).data('twitchgroupdelete'))
    {
       delete_twitch_group($(this).data('twitchgroupdelete')); 
    }
    if($(this).data('twitchcustomdelete'))
    {
       delete_custom_twitch($(this).data('twitchcustomdelete')); 
    }
});


function twitch_unban(id)
{
    var result = "";
    var id;
    
   $.ajax({
    url: '//'+location.hostname+'/ajax/twitch_unban/'+id,
    dataType: 'json', 
    success: function()
    {
      get_twitch_banned();  
    }
        });  
}


function delete_custom_twitch(name)
{
    var result = "";
    var id;
    
   $.ajax({
    url: '//'+location.hostname+'/ajax/delete_custom_twitch/'+name,
    dataType: 'json', 
    success: function()
    {
      get_twitch_custom_list();  
    }
        });  
}

function delete_twitch_group(id)
{
    var result = "";
    var id;
    
   $.ajax({
    url: '//'+location.hostname+'/ajax/delete_twitch_group/'+id,
    dataType: 'json', 
    success: function()
    {
      get_twitch_groups();  
    }
        });  
}


function delete_pages(id)
{
    var result = "";
    var id;
    
   $.ajax({
    url: '//'+location.hostname+'/ajax/delete_page/'+id,
    dataType: 'json', 
    success: function()
    {
      get_pages();  
    }
        });  
}


function get_twitch_custom_list()
{
    var result = "";
    
   $.ajax({
    url: '//'+location.hostname+'/ajax/twitch_custom_list',
    dataType: 'json', 
    success: function(data) {
        $.each(data, function(index, item) {
           result += "<tr> <td>"+item.name+"</td><td><a role='button' class='btn btn-danger btn-xs' data-twitchcustomdelete="+item.name+" >Delete</a> </td></tr>";
        });
        $('#twitch_custom_table').html(result);
    }
    });  
}


function get_twitch_groups()
{
    var result = "";
    
   $.ajax({
    url: '//'+location.hostname+'/ajax/twitch_group_list',
    dataType: 'json', 
    success: function(data) {
        $.each(data, function(index, item) {
           result += "<tr> <td>"+item.name+"</td><td><a role='button' class='btn btn-danger btn-xs' data-twitchgroupdelete="+item.id+" >Delete</a> </td></tr>";
        });
        $('#twitch_group_table').html(result);
    }
        });  
}



function get_twitch_banned()
{
    var result = "";
    
   $.ajax({
    url: '//'+location.hostname+'/ajax/banned_twitch',
    dataType: 'json', 
    success: function(data) {
        $.each(data, function(index, item) {
           result += "<tr> <td>"+item.ban_name+"</td><td><a role='button' class='btn btn-danger btn-xs' data-twitchunban="+item.ban_name+" >Unban</a> </td></tr>";
        });
        $('#twitch_ban_table').html(result);
    }
        });  
}



function get_pages()
{
    var result = "";
    
   $.ajax({
    url: '//'+location.hostname+'/ajax/page_list',
    dataType: 'json', 
    success: function(data) {
        $.each(data, function(index, item) {
           if(item.parent_id=="0")
           {
             parent = " (Parent)";  
           }
           else
           {
             parent = "";  
           }    
           result += "<tr> <td>"+item.title+parent+"</td><td> <a role='button' class='btn btn-primary btn-xs' href='//"+location.hostname+"/acp/page_manager/"+item.slug+"'>Edit</a> <a role='button' class='btn btn-danger btn-xs' data-pagedelete="+item.id+" >Delete</a> </td></tr>";
        });
        $('#pages_table').html(result);
    }
        });  
}