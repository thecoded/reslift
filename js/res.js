
        //
        if(window.location.href.indexOf('www.') !=-1 || window.location.href.indexOf('restlift.c') !=-1){
            window.location = "http://reslift.com";
        }

            //current user

            var userId;

            //linkedin id
            var liId;

            //work exp from linkedIn

            var workResponse;

            //school exp from linkedIn
            var workEd;

            //personal info

            var liInfo={};

            //current value being edited
            var val;

            //current uploaded image
             var photoUrl;


            //  testing for drag and drop vars \\
               //interval for longclick
            var longClick;

            var mouseMovement= {"x":"0px", "y":"0px"};

            //interval for mousemovement

            var mouseInt;

            //draggable parent element to append to when dragging
            var appendTo;
            var containment;

            var elemBDrag;


           

            $(window).load(init);

            function init(){
                //add listeners to text

                 initC();

                 showTut();

                 

                 //linkedIn

                 custBotMobile();

                lisLinked();



                beforeFBOverlay();

                showBook();

                textEditLis();

                initSaveAllValues();

                photoUploadListener();

                waitForImage();

                updateAll();

                //getAllImages();

                removeMediaBox();

                addMediaBoxListener();

                socButOnClick();

                progressDrag();

                onTextBlur();

                emailChangeLis();

                updateEmail();

                openBookRemoveAlpha();

                //initialize carousel
              

                //detectElemMove();

                //clickClipBoard(); -> called after input field display



            }


            function custBotMobile(){

                if(parseInt($('body').css('width')) <620){
                    $('#linkedInFirst').hide();
                }
            }


            function lisLinked(){

                IN.Event.on(IN, "auth", getLinkedData);
            }

            function getLinkedData(){
                $('#cFb').attr('src', 'save.png');
                 $('#cFb').attr('onClick', 'publish()');
                 swipeIndicator();
                 setTimeout(function(){

                    
                 $('#tutorialText').click();   
                }, 3000);
                    /*
                     setTimeout(function(){

                    updateAll();
                 $('#tutorialText').click();   
                }, 2000);

                setTimeout(function(){

                    rememberAll();
                 $('#tutorialText').click();   
                }, 3000); 

*/
            
                 $('.rm-button-open').click();

                $('#linkedInFirst').hide();
                 if(typeof fbId=="undefined"){

                                    fbId=makeId();
                                  }
                                  else if(fbId=="" || fbId==null){

                                    fbId=makeId();
                                  }
                                  else{
                                    //keep fbId the same
                                    fbId=fbId;
                                  }



               

                   
                    IN.API.Profile("me")
    .fields(["firstName","headline","positions:(company,title,summary,start-date,end-date,is-current)"])
    .result(function(result) {
        workResponse= result;
    })

    IN.API.Profile("me")
    .fields(["educations:(id,school-name,field-of-study,start-date,end-date,degree)"])
    .result(function(result) {
        workEd= result['values'][0]['educations']['values'];
    })



                    IN.API.Profile("me").fields(['headline', 'id', 'firstName', 'lastName', 'location', 'pictureUrl','industry']).result(function(result) {



        liId= result['values'][0]['id'];
        liInfo= result['values'][0];


        liData={'liId':liId};
            $.ajax({
            
                url: 'cloud/api/add/getL.php',
                data:liData,
                complete:function(transport){
                    //get fbId then updateAll()
                     userDataArr = $.parseJSON(transport.responseText);
                     fbId=userDataArr['fbId'];

                     updateAll();
                    // rememberAll();


            }});
        $('#linkedInId').html(liId);
       setTimeout(function(){

            if($('#linkedMergeAgreeAsk').html()=="false" || $('#linkedMergeAgreeAsk').html()=="_____"){


             linkedMergePrompt();
        }
       }, 1000);
        

    })
                

            }

            function populateLinkedInData(){

                console.log('populating...');
            }

            function linkedMergePrompt(){

             $.prompt("Would you like to auto-fill your resume with your LinkedIn data?", {
    title: "Finish in seconds...",
    buttons: { "Yes, Auto-fill!": true, "No, Let's Wait": false },
    submit: function(e,v,m,f){
        // use e.preventDefault() to prevent closing when needed or return false. 
        // e.preventDefault(); 

        if(v==true){

            console.log('auto-filling...');
            //will auto-fill until they make manual change, then will be switch to false
             $('#linkedMergeAgree').html('true');

             //first Page

             try{
             $('#magHead').html(liInfo['firstName'] + " " +liInfo['lastName']);
             $('#myNameTitle').html(liInfo['firstName'] + " " +liInfo['lastName']);

            }
            catch(e){
                console.log('failed main headers from linked')
            }

            try{


             $('#magSub').html(liInfo['headline'].split(" at")[0].split('@')[0]);
             $('#imFrom').html("I LIVE IN");
             $('#whereFrom').html(liInfo['location']['name']);

             //second page location
             $('#myLocationTitle').html('- '+ liInfo['location']['name'] );
              $('#iCreate').html("I WORK IN");
              $('#whatCreate').html(liInfo['industry']);

               $('#iLike').html("CURRENTLY A");
               $('#iLikeWhat').html(workResponse['values'][0]['positions']['values'][0]['title']);

           }
            catch(e){
                console.log('failed main sub head 1 from linked')
            }

            try{
                $('#whatLike').html("CONSULTING");
               $('#seekWhat').html("AVAILABLE");

           }

            catch(e){
                console.log('failed second first page sub from linked')
            }

               //second page

               try{
                //for social
                $('.linkedin').attr('data','http://www.linkedin.com/profile/view?id='+liId);
              // $('#mb1 img').attr('src',liInfo['pictureUrl']);

               // $('#mb0 img').attr('src',liInfo['pictureUrl']);
                $('#whatIDo').html("a "+ liInfo['headline']);

            }
             catch(e){
                console.log('failed main image from linked')
            }

            try{
                $('#workYear1').html("since "+ workResponse['values'][0]['positions']['values'][0]['startDate']['year']);

            }

             catch(e){
                console.log('year 1 title from linked');
            }


            try{
                if(typeof workResponse['values'][0]['positions']['values'][1]['endDate'] =="undefined"){
                    workResponse['values'][0]['positions']['values'][1]['endDate']={year:"present"};

                }
                 if(typeof workResponse['values'][0]['positions']['values'][2]['endDate'] =="undefined"){
                    workResponse['values'][0]['positions']['values'][2]['endDate']={year:"present"};
                    
                }
                $('#workYear2').html(workResponse['values'][0]['positions']['values'][1]['startDate']['year']+ " - "+ workResponse['values'][0]['positions']['values'][1]['endDate']['year']);
                $('#workYear3').html(workResponse['values'][0]['positions']['values'][2]['startDate']['year']+ " - " +workResponse['values'][0]['positions']['values'][2]['endDate']['year']);

            }
             catch(e){
                console.log('failed secondary years from linked')
            }

                $('#workYear1Title').html(workResponse['values'][0]['positions']['values'][0]['title']);
                  $('#workYear1Company').html(workResponse['values'][0]['positions']['values'][0]['company']['name']);
                  $('#workYear1Desc').html(workResponse['values'][0]['positions']['values'][0]['summary']);

                  try{

                 $('#workYear2Title').html(workResponse['values'][0]['positions']['values'][1]['title']);
                  $('#workYear2Company').html(workResponse['values'][0]['positions']['values'][1]['company']['name']);
                    $('#workYear3Desc').html(workResponse['values'][0]['positions']['values'][2]['summary']);
                }

                catch(e){

                    console.log('failed year2')
                }
                try{

                  $('#workYear3Title').html(workResponse['values'][0]['positions']['values'][2]['title']);

                
                 
                  $('#workYear3Company').html(workResponse['values'][0]['positions']['values'][2]['company']['name']);

                  
                  $('#workYear2Desc').html(workResponse['values'][0]['positions']['values'][1]['summary']);
                
                }
                catch(e){

                    console.log('failed year 3 from linked');
                }

                try{

                    if(typeof workEd[0]['endDate'] == "undefined"){
                        workEd[0]['endDate']="present";
                    }
                    $('#eduYear1').html(workEd[0]['startDate']['year'] + " - " + workEd[0]['endDate']['year'] )
                     $('#eduYear1Title').html(workEd[0]['fieldOfStudy'])
                     $('#eduYear1School').html(workEd[0]['schoolName'])

                }

                catch(e){

                    console.log("failed edu 1");
                }

                try{
                    $('#eduYear2').html(workEd[1]['startDate']['year'] + " - " + workEd[1]['endDate']['year'] )
                     $('#eduYear2Title').html(workEd[1]['fieldOfStudy'])
                     $('#eduYear2School').html(workEd[1]['schoolName'])

                }

                catch(e){

                    console.log("failed edu 2");
                }

                 $('.rm-close').click();
             rememberAll();


        }

        else{

            console.log('not auto-filling...');
              $('#linkedMergeAgreeAsk').html('true');
        }
    }
});
            }


            function showTut(){
               

                setTimeout(function(){
                        $('#login').animate({'opacity':'1'});

                        if(typeof fbId == "undefined"){

                            $('#tutorialText').fadeIn();
                          
                            return;
                        }
                    
                    }, 1000);
                
            }
         


            function clickClipBoard(){
                $("#userURLBut").zclip({
                        path:'js/ZeroClipboard.swf',
                        copy:$('#userURL').val(),
                        beforeCopy:function(){
                        },
                        afterCopy:function(){
                        $(this).css('color','purple');
                       
                       $('#userURL').fadeOut();
                        setTimeout(function(){
                            $('#userURL').css({'bottom':'20px'}, 1000).fadeIn();

                        }, 1000);
                        }
                });

           }

            function detectElemMove(){


               // $('.dragElem').draggable({ containment: "parent" });
                $('.dragElem').draggable({
                    
                    start: function( event, ui) {
                        console.log(ui);
                        elemBDrag=  $(this).clone();
                        elemBDrag.appendTo('#topElem');
                        $(this).css({'opacity':'0'});
                        elemBDrag.css({'z-index':'1000000', 'top':ui.offset.top, 'left':ui.offset.left, 'max-width':$('.antiscroll-inner').css('width')});

                        elemBDrag.css({'opacity':'.75'});
                     },
                     drag: function( event, ui) {
                        console.log(ui);
                      // 
                        elemBDrag.css({'z-index':'1000000', 'top':ui.offset.top, 'left':ui.offset.left});
                       
                     },

                     stop:function(event, ui){
                        $(this).css({'opacity':'1'});
                        elemBDrag.remove();
                        elemBDrag= [];
                     }
                });

               // $( ".dragElem" ).draggable( "option", "appendTo", "body" );
               // containment = $( ".dragElem" ).draggable( "option", "containment" );
                // $( ".dragElem" ).draggable( "option", "containment", "body" );
                 /*
                $('.dragElem').on('click', function(){

                    longClick = setTimeout(function(){

                        trackMouseMove($(this));

                    },500);
                }).bind('mouseup mouseleave', function() {
    clearTimeout(longClick);
});

*/
            }



            function rearrangeElems(){


                //note: also might want to be able to do this for sub elements

                //get cloned elem position left/top (if there is one)

                //figure out where within dragElems this elem should falls

                //create array of the order with each id and whether its deleted or not

                //add to all date the elem id and number in array

                // based on array, get elem innerHrml for each in array an for each dragElem, replace html with the html from list

                //for each elem that's been deleted, hide it

                // 4- 1- 2




            }


            function trackMouseMove(heldElem){

               mouseInt=  $('body').on('mousemove', function(e){

                    console.log(e.pageX);

               })
                heldElem.on('mouseup', function(){
                    $('body').off('mousemove');

                })
            }

            function beforeFBOverlay(){
                //setTimeout(function(){
                          // $('#beforeFBOverlay').fadeIn();
                //}, 300);
             
                $('#beforeFBOverlay, #tutorialText').on('click', function(e){
                    if(typeof fbId == "undefined"){
                       

                        //fbId=null;
                         $('#cFb').animate({'width':'550px'},500, function(){$('#cFb').animate({'width':'300px'})})
                         return;
                    }
                    else if(fbId==null){

                        //in case fb becomes null
                    $('#cFb').animate({'width':'550px'},500, function(){$('#cFb').animate({'width':'300px'})});
                    return;
                    }
                    else{
                        if(fbId.length>3){

                            $('#beforeFBOverlay, #tutorialText').fadeOut();
                            return;
                        }
                    }


                   
                })
            }

                function openBookRemoveAlpha(){

                    $('.rm-button-open').on('click', function(){
                            $('#versionIcon').fadeOut();

                    });
                    $('.rm-close').on('click', function(){

                            nE = $('<div />').attr('id', 'clickUpload').css({'width':'20%', bottom:'0px', 'margin-left':'70%', 'height':'10%', color:'red', 'font-size':'15px'}).html('Click this area to edit resume background').on('mouseover', function(){$(this).remove();});
                            nE.appendTo('#magPhotoUpload');
                            setTimeout(function(){
                                    $('#clickUpload').fadeOut(1000, function(){

                                        $(this).remove();
                                    })

                            }, 7000);
                            $('#versionIcon').fadeIn();

                    });
                    
                }


            function emailChangeLis(){

                $('#myEmailTitle').on('change', function(){
                    setTimeout(function(){

                             $('.base4').attr('email', $('#myEmailTitle').text());
                    }, 1000);
                   
                })
            }

            function updateEmail(){


                              setTimeout(function(){

                             $('.base4').attr('email', $('#myEmailTitle').text());
                    }, 5000);
                   
            }

            function onTextBlur(){

                $('input').live('focus',function(){

                    $('#login, #loginBG').hide();
                });
                $('input').live('blur',function(){

                    $('#login, #loginBG').show();
                })
            }

            function progressDrag(){
                $('.progress').css({'height':'15px'})
                $(".progress").resizable({ handles: "e, w" });

                $('.progress').on('resizestop', function(e, ui){

                        console.log(ui.element.css('width'));
                        console.log($(this).attr('id'));
                        userDataArr[$(this).attr('id')]= ui.element.css('width');
                        rememberAll();

                })
            }


            function showBook(){

                $('.rm-wrapper').animate({'opacity':'1'}, 500, bookOpened);

            }

            function bookOpened(){

                    setTimeout(function(){

                        $('#spinner1').fadeOut(1000, function(){$(this).remove()});
                    }, 2000);

            }


            function textEditLis(){

                  $('.resLift').editable(saveEdit, {
         indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         onblur  : 'submit'
     });
                  return;

/*
                 $('h1,h2,h3').on('click', function(e){

                val= $(this).html();
                if(val.indexOf('<span') != -1){
                    //contains span
                    console.log(e.srcElement);
                }

                $(this).on('keydown', function(){


                })

                })

*/
            }

            function photoUploadListener(){


                $('.photoEdit').on('click', function(e){

                    if($(this).attr('id')=="magPhotoUpload"){
                        

                        oCheckX = screen.width;
                        oCheckY = screen.height;

                        if(oCheckY < 600){
                           
                              if(e.offsetY < 200 || e.offsetX < 100){

                            return;
                            }

                        }

                        else if(oCheckY < 1100){
                              if(e.offsetY < 400 || e.offsetX < 200){

                            return;
                            }


                        }
                        else{
                             if(e.offsetY < 400 || e.offsetX < 400){

                            return;
                        }
  
                        }
                       
                        

                        //alert("y= "+e.offsetY +"\n x="+ +e.offsetX );
                    }
                    currentMediaBoxEdit="main";
                    theId = $(this).attr('sec');
                    $('#photoimg').click();
                })
            }
           
            function saveEdit(value, settings) { 
     console.log($(this));
     console.log(value);
     console.log(settings);

    
        setTimeout(function(){
            rememberAll();
        },300);


     return (value);
 }

 function initSaveAllValues(){

    //testing nulls to see if this solves cross-computer desc.
    //userId= localStorage.getItem('userId');
    userId=null;
    if(userId==null){
        userId= makeId();
        //localStorage.setItem('userId', userId);

    }
 }

 //current social network being edited
var currentNetwork ="facebook";

 function socButOnClick(){

    $('.social a').on('click', function(){

        currentNetwork =$(this).attr('class');
        if(userDataArr[currentNetwork] == ""){
            theE = $('<div />').addClass('overlay1').css({"width":'100%', 'height':"100%", position:"fixed", "top":"0px", 'left':'0px', 'z-index':'3000000', 'opacity':'.85', 'background-color':'black', 'padding':'2.5%'}).html('<input type="text" style="width:90%; margin-top:20%" placeholder="your '+currentNetwork+' URL" id="soc-edit-'+currentNetwork+'"><br><button onclick="saveNetworkLink()">Save</button>')
        }
        else{
             theE = $('<div />').addClass('overlay1').css({"width":'100%', 'height':"100%", position:"fixed", "top":"0px", 'left':'0px', 'z-index':'3000000', 'opacity':'.85', 'background-color':'black', 'padding':'2.5%'}).html('<input type="text" style="width:90%; margin-top:20%" placeholder="your '+currentNetwork+' URL" id="soc-edit-'+currentNetwork+'" value="'+userDataArr[currentNetwork]+'"><br><button onclick="saveNetworkLink()">Save</button>')

        }
       

        theE.appendTo('body');
        $(':not (#soc-edit-'+currentNetwork)+")".on('click', function(){

            $(this).remove();
        })


    })
 }

 var networkVal ="";
 function saveNetworkLink(){
    networkVal = $('#soc-edit-'+currentNetwork).val();
    if(networkVal.indexOf('http')==-1){
        networkVal = "http://"+networkVal;
    }
    $('.'+currentNetwork).attr('data', networkVal);
    rememberAll();
    $('.overlay1').fadeOut();
    setTimeout(function(){
         $('.overlay1 :not input').remove();

    }, 1500);
  
 }

 function makeId()
    {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for( var i=0; i < 21; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }
 //saves all values locally and remotely for user
  function saveAllValues(){


}


function waitForImage(){

    $('#photoimg').on('change', function()    
{ 

    loadingImg="loading.gif";
   
    if(currentMediaBoxEdit.indexOf('mb')!=-1){


                $('#'+currentMediaBoxEdit + " img").attr({'src':loadingImg});
                // thisImages.push($('#preview img').attr('src'));
                //$('#doMore').show();
              
        }


        else{

                $('.cover :first').css({'background-image':'url('+loadingImg+')'});
                // thisImages.push($('#preview img').attr('src'));
                //$('#doMore').show();
              
              
           

        }
  

$("#preview").html('');
$("#preview").html('<img src="loader.gif" alt="Uploading...."/>');
$("#imageform").ajaxForm(
{
target: '#preview',
complete: function(transport){
        photoUrl = transport.responseText;

        //alert(currentMediaBoxEdit);
        if(currentMediaBoxEdit.indexOf('mb')!=-1){


                $('#'+currentMediaBoxEdit + " img").attr({'src':photoUrl});
                // thisImages.push($('#preview img').attr('src'));
                //$('#doMore').show();
                localStorage.setItem(currentMediaBoxEdit, photoUrl);
                allData[currentMediaBoxEdit]=photoUrl;
                allData[currentMediaBoxEdit+ "Pos"] = $("#"+currentMediaBoxEdit).attr('pos');
                //alert($("#"+currentMediaBoxEdit).attr('pos'));
                allData[currentMediaBoxEdit+ "Exists"] = $("#"+currentMediaBoxEdit).attr('exists');
           
                rememberAll();
        }


        else{

                $('.cover :first').css({'background-image':'url('+photoUrl+')'});
                // thisImages.push($('#preview img').attr('src'));
                //$('#doMore').show();
                localStorage.setItem('mainBG', photoUrl);
                 allData['mainBG']=photoUrl;
                 rememberAll();
           

        }
        
}
}).submit();
});
 }

var curElemToRemove;
 function removeMediaBox(){

    $('.media-box').live('mouseover', function(e){

        closeDiv = $('<div />').css({'position':'absolute', 'top':'10px', 'right':'20px', 'font-size':'20px', 'color':'black', 'z-index':'10000000'}).addClass('deleteButton').html('x');
        $('.isotope-item').append(closeDiv);
        $('.deleteButton').live('click', function(e){
        curElemToRemove= $(this);
        //alert($(this).siblings(0).attr('id'));

            $(this).siblings(0).attr('exists', 'false');
            setTimeout(function(){
                rememberAll();

            }, 10);
           
        setTimeout(function(){
            $( '.portfolio-items' ).isotope('remove',curElemToRemove.parent());
        }, 20);


            //.remove();

           
            //$(this).remove();
            //$(this)
        });
    });
     $('.isotope-item').on('mouseout', function(){
        
            setTimeout(function(){
                //$('.deleteButton').remove();

            },1000)
        
    });
 }

//global var for current photo being uploaded (eg mb1 or mb2)
 var currentMediaBoxEdit="";

  function addMediaBoxListener(){

    $('.media-box').live('click', function(e){
        
       currentMediaBoxEdit= $(this).attr('id'); 
       uploadPortPhoto(currentMediaBoxEdit);
       
    });
}

    function uploadPortPhoto(elemId){
        $('#photoimg').click();
    }

var thisPos;
var lastPos;

    //only called when element doesn't exist in dom but on server
    function createMB(mbId, mbExists, mbPos, mbTitle, mbLink, mbImg){

        
        mbId=mbId.replace("#","");
                 r = $('.isotope-item:first').clone();
        r.children(0).attr('id',mbId);
        r.children(0).attr('pos',mbPos);
        r.children(0).attr('exists',mbExists);
        r.children(0).siblings('p').attr('id', mbId+"P");
        r.children(0).siblings('h4').attr('id', mbId+"H4");

        r.children(0).siblings('p').html( mbLink);
        r.children(0).siblings('h4').html(mbTitle);


        $( '.portfolio-items' ).isotope('insert',r);
        $("#"+mbId+ " img").attr('src', mbImg);
      
        

    }

    //create new media box when user presses "add item"
 function createNewLink(){

    r = $('.isotope-item1:first').clone();

    //get the last element in isotope's position
    lastPos = $( '.portfolio-items .media-box :last').attr('pos');

    if(lastPos - lastPos!=0){
        lastPos=22;
    }
    thisPos = parseInt(lastPos)+1;
    thisElemNum = parseInt(highestMB.replace('mb','')) +1;
    highestMB = "mb"+thisElemNum;

    r.children(0).attr('id',highestMB);
    r.children(0).attr('pos',thisPos);
    r.children(0).attr('exists','true');
    r.children(0).siblings('p').attr('id', 'mb'+thisElemNum+'Link');
    r.children(0).siblings('h4').attr('id', 'mb'+thisElemNum+'Title');


    $( '.portfolio-items' ).isotope('insert',r);

    setTimeout(function(){
        textEditLis()
        rememberAll();
    }, 500);    
 }



//media boxes that have been edited

var mbs;


function getAllImages(){

    if(localStorage.getItem('mainBG') !=null){

        $('.cover :first').css({'background-image':'url('+localStorage.getItem('mainBG')+')'});

    }

    mbs={};
    for(i=0; i<100; i++){
         if(localStorage.getItem('mb'+i) !=null){

        $('#mb'+i+' img' ).attr({'src':localStorage.getItem('mb'+i)});
        allData['mb'+i] = localStorage.getItem('mb'+i) ;

        }

    }
   



}

var theVal;
var theId;

var allData={};
 function rememberAll(){

    $('#linkedMergeAgree').html('false');
     $('#linkedMergeAgreeAsk').html('true');


    //data for ajax
    allData['userId']=userId;

    allData['fbId']=fbId;

     allData['mainBG'] = $('.cover :first').css('background-image').replace("url(","").replace(')', '');



                $('.progress').each(function(index){

                        theVal = ($(this).css('width'));
                        theId =$(this).attr('id');
                        allData[theId]= theVal;
                        

                })

    $('.social a').each(function(index){

            id  = $(this).attr('class');
            val = $(this).attr('data');
            if(typeof val=="undefined"){
                val="";
            }
            allData[id]= val;
    })


    for(i=1; i<100; i++){
                        if(typeof $('#mb'+i).val() != "undefined"){
                            allData['mb'+i] = $('#mb'+i+' img').attr('src');
                            allData['mb'+i+"Pos"] = $('#mb'+i).attr('pos');
                            allData['mb'+i+"Exists"] = $('#mb'+i).attr('exists');
                         }
                    }

    $('.resLift').each(function(index){

            id  = $(this).attr('id');
            val = $(this).text();
            allData[id]= val;
            //localStorage.setItem(id, val);
           


            })

     $.ajax({
                url: 'cloud/api/add/add.php',
                data:allData,
                complete:function(transport){

                     console.log(transport.responseText);
                     //updateAll();
            }


    })
 } 

var theUId;
var userDataArr;


//latest media box by id for use by add new
var highestMB= "mb8";

 function updateAll(){

if(typeof fbId != "string" || fbId==""){
    console.log("update all cancelled. No string");
    return;
}
allDataArr = {'userId':userId, 'fbId':fbId};

 $.ajax({
                url: 'cloud/api/add/get.php',
                data:allDataArr,
                complete:function(transport){
                    console.log('parsing get');
                    userDataArr = $.parseJSON(transport.responseText);
                    console.log('finished');
                    try{

                       if(userDataArr['mainBG']){
                       
                         $('.cover :first').css({'background-image':'url('+userDataArr['mainBG']+')'});
                        }
                        console.log('FB ID made mainBG='+ fbId);  
                    }
                    catch(e){

                        console.log('FB ID='+ fbId);
                        console.log('background image not in arr');
                    }



                    
                      for(i=1; i<100; i++){
                        if(typeof userDataArr['mb'+i] != "undefined"){

                            highestMB = 'mb'+i;
                            if(userDataArr['mb'+i+"Exists"]=="true"){
                                //if the media box doesn't exist

                                if(typeof $('#mb'+i)[0] == "undefined"){
                                   
                                    createMB('#mb'+i,userDataArr['mb'+i+'Exists'], userDataArr['mb'+i+'Pos'], userDataArr['mb'+i+'Title'], userDataArr['mb'+i+'Link'], userDataArr['mb'+i] );
                                    
                                    
                                }

                                //if media box does exist
                                else{
                                          $('#mb'+i+' img').attr('src', userDataArr['mb'+i] );

                                }
                              
                            }
                            else{
                                 elemToDelete= $('#mb'+i).parent();
                                 $('#mb'+i).attr('exists', 'false');
                                  $( '.portfolio-items' ).isotope('remove',elemToDelete);

                            }
                            
                         }
                    }
                    //add listener for photos added to edit

                    textEditLis();

                       $('.social a').each(function(index){

                        id  = $(this).attr('class');
                        //console.log(id);
                        val = userDataArr[id];
                        try{
                            if(val!=""){
                            $("."+id).attr('data', val);
                            }
                        else{
                             //$("."+id).hide();

                        }

                        }
                        catch(err){

                             //$("."+id).hide();
                        }
                        
                     })



                    /*
                    try{
                        if(typeof userDataArr['mb1'] != "undefined"){
                            $('#mb1 img').attr('src', userDataArr['mb1'] );
                        }
                    }
                    catch(e){
                        console.log('mb1 not in arr');
                    }

                    */

                     $('.resLift').each(function(index){

                    id  = $(this).attr('id');

            try{
                 theUId = userDataArr[id];
               
                if(theUId !=null){
                    if(theUId == "" || theUId == " "){
                        theUId = "_____";
                    }
                    $('#'+id).html(theUId);
                }
            
            }
           
           catch(e){
                        console.log('error in update');
                    theUId = localStorage.getItem(id);
                     if(theUId !=null){
                         $('#'+id).html(theUId);
                    }
            }

            if(fbId.length<20 &&(userDataArr['magHead']=="Click to edit" || userDataArr['magHead']=="Click to Edit" || userDataArr['magHead']=="click to edit"  ) ){
                            console.log('fb name');
                            $('#magHead').html(response1['name']);
                            $('#magSub').html('Click to edit this');

                    }
                    else{
                        //console.log('magHead='+response1['name']);
                    }
                    
            
           
            


    })


    //update progress bars
     $('.progress').each(function(index){

                      
                        theId =$(this).attr('id');
                        theVal = userDataArr[theId];
                         $(this).css('width', theVal);

                })



            }});


   
 } 


function publish(){
     $('.rm-close').click();
    $('#cFb').hide();
    $('#login').append("<center><input type='text' value='http://reslift.com/"+fbId+"'  id='userURL' style='width:100%; position:absolute; top:0px'><button id='userURLBut' style='position:absolute; right:30px; width:50px; top:8px; z-index:300'>copy</button><button id='userURLBut2' style='position:absolute; right:10px; top:8px; z-index:300' onclick='clearUrl();'>x</button></center>");

        checkPublicMobile();
    //

    //wait for userURL to render
    setTimeout(function(){
        clickClipBoard();},500);

    }

    //if use clicks "Publish on mobile device, don't show copy button and nav to page on click
    function checkPublicMobile(){

        if(screen.width <640){
            $('#login input,button').remove();
            
            $('#userURL').live('focus', goToMyPage());

        }
    }

    function clearUrl(){
        $('#login input,button').remove();
         $('#cFb').fadeIn();

    }

function goToMyPage(){

   
    window.open("http://reslift.com/"+response1['id']);
}

 //FACEBOOK


 (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "https://connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));


 //array that will store our first Facebook response with the user's info
  var response1;

  //array that will store our second facebook response with the user's photos
  var response2;

  function loginUserLI(){

    carousel.next();
    $('.firstText').html("This will give you the option to import your entire LinkedIn resume & beautify it.").css('color','#00BFFF');
    $('#tutorialText').on('mouseover', function(){
        carousel.prev();
        $('.firstText').html('Sign-in for free with a social network and make a killer web resume').css('color','#FFF');;
        $('#tutorialText').off('mouseout');
    })
  }

  //function that will authenticate the user via Faabook, calling to the FB object
  function loginUser() {    
     FB.login(function(response) { }, {scope:'email, user_photos'});     
     }

     // FB object initialization
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '211071089100501', // App ID
      channelUrl : 'http://reslift.com/', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

    FB.Event.subscribe('auth.statusChange', handleStatusChange);
  };

  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));

 
    //callback function of the status change from not logged in to logged in
   function handleStatusChange(response) {
     document.body.className = response.authResponse ? 'connected' : 'not_connected';

     if (response.authResponse) {
      console.log(response);
      response1= response;
      updateUserInfo(response);
      

     }
   }


   
   var fbId;

   var shownLinkedTut="false";
   function updateUserInfo(response) {

    $('#linkedInFirst').hide();
     setTimeout(function(){

                        $('#tutorialText').fadeOut();
                           $('#beforeFBOverlay').fadeOut();
                }, 500);


     //check if user has connected their linkedin account. If not, then show then instructions and toggle option on bottom bar until they connect.s
    setTimeout(function(){


        //if user has not logged in with linkedin, toggle for user
        if(($('#linkedInId').html()== "null" || $('#linkedInId').html()== "" || $('#linkedInId').html() == "_____") && typeof liId =="undefined"){


             cInt= setInterval(function(){



                    if(whichSocial ==1){
                        carousel.next(); 
                        if(shownLinkedTut=="false"){

                            $('#beforeFBOverlay').show();
                            $('#tutorialText').show();
                            $('.firstText').html('Fill in your Reslift resume with LinkedIn data');

                            setTimeout(function(){

                                 $('#beforeFBOverlay,#tutorialText').fadeOut();
                                 shownLinkedTut="true";
                            },4000);
                        }
                        
                        whichSocial=2;
                    }
                    else{
                        carousel.prev(); 
                        whichSocial=1;
                    }

                    if(typeof liId != "undefined"){

                        clearInterval(cInt);
                         carousel.prev();
                          carousel.prev();
                        
                    }
                    

                }, 4000);


        }
        
    }, 3000);
     FB.api('/me', function(response) {
      response1 = response;
      fbId= response1['id'];


      //localStorage.setItem('fbId' ,fbId);

      updateAll();

      $('#cFb').attr('src', 'save.png');
      swipeIndicator();


      $('#cFb').attr('onClick', 'publish()');
      $('.rm-button-open').click();
      $('#versionIcon').fadeOut();
     
      //here we will create a table displaying our user's information
      // Hint: $('#someDivId').html('<table><tr><td></td><td></td></tr></table>');


     });

      FB.api('/me/photos', function(response) {
      response2= response;
      //here we will create a table displaying our user's information
      // Hint: $('#someDivId').html('<table><tr><td></td><td></td></tr></table>');
      

     });

   }


   function swipeIndicator(){
    if(parseInt($('body').css('width')) < 620){
        return;
    }
    else{
        $('#cFBSide').css('display','inline-block');
    }

   }
      

    var debug_el = $("#debug");
    function debug(text) {
        debug_el.text(text);
    }


    /**
     * requestAnimationFrame and cancel polyfill
     */
    (function() {
        var lastTime = 0;
        var vendors = ['ms', 'moz', 'webkit', 'o'];
        for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
            window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
            window.cancelAnimationFrame =
                    window[vendors[x]+'CancelAnimationFrame'] || window[vendors[x]+'CancelRequestAnimationFrame'];
        }

        if (!window.requestAnimationFrame)
            window.requestAnimationFrame = function(callback, element) {
                var currTime = new Date().getTime();
                var timeToCall = Math.max(0, 16 - (currTime - lastTime));
                var id = window.setTimeout(function() { callback(currTime + timeToCall); },
                        timeToCall);
                lastTime = currTime + timeToCall;
                return id;
            };

        if (!window.cancelAnimationFrame)
            window.cancelAnimationFrame = function(id) {
                clearTimeout(id);
            };
    }());


    /**
    * super simple carousel
    * animation between panes happens with css transitions
    */
    function Carousel(element)
    {
        var self = this;
        element = $(element);

        var container = $(">ul", element);
        var panes = $(">ul>li", element);

        var pane_width = 0;
        var pane_count = panes.length;

        var current_pane = 0;


        /**
         * initial
         */
        this.init = function() {
            setPaneDimensions();

            $(window).on("load resize orientationchange", function() {
                setPaneDimensions();
                //updateOffset();
            })
        };


        /**
         * set the pane dimensions and scale the container
         */
        function setPaneDimensions() {
            pane_width = element.width();
            panes.each(function() {
                $(this).width(pane_width);
            });
            container.width(pane_width*pane_count);
        };


        /**
         * show pane by index
         */
        this.showPane = function(index, animate) {
            // between the bounds
            index = Math.max(0, Math.min(index, pane_count-1));
            current_pane = index;

            var offset = -((100/pane_count)*current_pane);
            setContainerOffset(offset, animate);
        };


        function setContainerOffset(percent, animate) {
            container.removeClass("animate");

            if(animate) {
                container.addClass("animate");
            }

            if(Modernizr.csstransforms3d) {
                container.css("transform", "translate3d("+ percent +"%,0,0) scale3d(1,1,1)");
            }
            else if(Modernizr.csstransforms) {
                container.css("transform", "translate("+ percent +"%,0)");
            }
            else {
                var px = ((pane_width*pane_count) / 100) * percent;
                container.css("left", px+"px");
            }
        }

        this.next = function() { return this.showPane(current_pane+1, true); };
        this.prev = function() { return this.showPane(current_pane-1, true); };



        function handleHammer(ev) {
            console.log(ev);
            // disable browser scrolling
            ev.gesture.preventDefault();

            switch(ev.type) {
                case 'dragright':
                case 'dragleft':
                    // stick to the finger
                    var pane_offset = -(100/pane_count)*current_pane;
                    var drag_offset = ((100/pane_width)*ev.gesture.deltaX) / pane_count;

                    // slow down at the first and last pane
                    if((current_pane == 0 && ev.gesture.direction == "right") ||
                        (current_pane == pane_count-1 && ev.gesture.direction == "left")) {
                        drag_offset *= .4;
                    }

                    setContainerOffset(drag_offset + pane_offset);
                    break;

                case 'swipeleft':
                    self.next();
                    ev.gesture.stopDetect();
                    break;

                case 'swiperight':
                    self.prev();
                    ev.gesture.stopDetect();
                    break;

                case 'release':
                    // more then 50% moved, navigate
                    if(Math.abs(ev.gesture.deltaX) > pane_width/2) {
                        if(ev.gesture.direction == 'right') {
                            self.prev();
                        } else {
                            self.next();
                        }
                    }
                    else {
                        self.showPane(current_pane, true);
                    }
                    break;
            }
        }

        var hammertime = new Hammer(element[0], { drag_lock_to_axis: true });
        hammertime.on("release dragleft dragright swipeleft swiperight", handleHammer);
    }

    var carousel;
    var cInt;
    var whichSocial=1;
    function initC(){




            setTimeout(function(){
                 carousel = new Carousel("#carousel");
             carousel.init();
/*
                cInt= setInterval(function(){



                    if(whichSocial ==1){

                        carousel.next(); 
                        whichSocial=2;
                    }
                    else{
                        carousel.prev(); 
                        whichSocial=1;
                    }

                    if(typeof liId != "undefined"){

                        clearInterval(cInt);
                         carousel.prev();
                          carousel.prev();
                        
                    }
                    

                }, 4000);

*/

            },1000)
           
    }

    
    

