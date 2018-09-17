
// Define Response Handler Class
function Response_handler(json_array){

   this.data = json_array;
   
   console.log(this.data);
   
}

Response_handler.prototype.action = function()
{

  console.log(this.data.type);
  
   if(this.data.type === "error")
   {
     if(this.data.redirect)
        {
          window.location.replace(''+window.baseurl+this.data.redirect+'');      
              console.log("Error/Action");
        }  
        
     //alert(this.data.text);  
   }
   
   if(this.data.type === "success")
   {
      if(this.data.redirect)
        {
          window.location.replace(''+window.baseurl+this.data.redirect+'');      
        }
       
   }
   
   
   
};
    





// Add methods like this.  All Person objects will be able to invoke this
Response_handler.prototype.error = function(){
    alert("" + this.name);
};

// Instantiate new objects with 'new'
//var person = new Person("Bob", "M");

// Invoke methods like this
//person.speak(); // alerts "Howdy, my name is Bob"