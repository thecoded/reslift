if(!jQuery){
  alert('This plugin may not work because you have not imported jQuery before base4');
  return;
}

theBase4Vals={};


  function go1(){
     

      var $inputs = $('.base4 :input, .base4 select');

    // not sure if you wanted this, but I thought I'd add it.
    // get an associative array of just the values.
    var values = {};
    $inputs.each(function() {
        values[this.id] = $(this).val();
    });
    theBase4Vals= values;
    theBase4Vals['siteUrl']=window.location.href;
     theBase4Vals['base4Email']=$('.base4').attr('email');
     console.log('email notif will be sent to'+ theBase4Vals['base4Email'] ); 

$.getJSON( "http://thecoded.com/cloud/base4.php?callback=?",
  theBase4Vals,
   function( data ) {
  var items = [];
  console.log('jsonp complete')
})

   
      //console.log('blah!');
  }


$(document).ready(function(){
/*
    $('.base4').submit(function(){
      var values = {};
    $.each($('#myForm').serializeArray(), function(i, field) {
    values[field.name] = field.value;
    });
    theBase4Vals= values;




     $.getJSON({'url':'http://thecoded.com/cloud/base4.php?callback=?',
      'data':theBase4Vals,
      'complete':function(res){
          alert('complete!');
          //alert('Your name is '+res.fullname);
        
        }});

    })


   */



})

