(function ($) {
  'use strict';
  AOS.init();

  var HeaderHeight = $("body").find("header").outerHeight();

  $("body").css("padding-top", HeaderHeight);


  $('select').selectpicker();

  function AddFixedClass() {
    var scroll = $(window).scrollTop();

    if (scroll >= 50) {
      $("header").addClass("fixed");
    } else {
      $("header").removeClass("fixed");
    }
  }

  $(window).scroll(function () {
    AddFixedClass();
  });

  AddFixedClass();


  document.addEventListener('touchmove', function (event) {
    if (event.scale !== 1) {
      event.preventDefault();
    }
  }, false);


     /** On Scroll Fixed Header **/

     var headerHeight = $("body").find("header").outerHeight();
     var asideWidth = $("body").find("aside").outerWidth();
     $("body").css("padding-top", headerHeight);
 
 
     var dashboardHeaderHeight = $("body.dashboard").find("header").outerHeight();
     $("body.dashboard").css("padding-top", headerHeight);
     $("body.dashboard aside").css("top", headerHeight);
     $("body.dashboard .dashboard-content-wrap").css("padding-left", asideWidth);
 
})(jQuery)



// upload multiple


$(document).ready(function() {
  var hours =0;
  var mins =0;
  var seconds =0;
  startTimer();
  // $('#start').click(function(){
  //       startTimer();
  // });
  
  // $('#stop').click(function(){
  //       clearTimeout(timex);
  // });
  
  // $('#reset').click(function(){
  //       hours =0;      mins =0;      seconds =0;
  //   $('#hours','#mins').html('00:');
  //   $('#seconds').html('00');
  // });
  
  function startTimer(){
    timex = setTimeout(function(){
        seconds++;
      if(seconds >7){seconds=0;mins++;
         if(mins>04) {
         mins=0;hours++;
           if(hours <10) {$("#hours .count-number").text('0'+hours)} else $("#hours .count-number").text(hours);
                         }
                         
      if(mins<10){                     
        $("#mins .count-number").text('0'+mins);}       
         else $("#mins .count-number").text(mins);
                     }    
      if(seconds <10) {
        $("#seconds .count-number").text('0'+seconds);} else {
        $("#seconds .count-number").text(seconds);
        }
       
      
        startTimer();
    },1000);
  }
      
    

  document.getElementById('pro-image').addEventListener('change', readImage, false);
  
  $( ".preview-images-zone" ).sortable();
  
  $(document).on('click', '.image-cancel', function() {
      let no = $(this).data('no');
      $(".preview-image.preview-show-"+no).remove();
  });
});


var num = 0;
function readImage() {
  if (window.File && window.FileList && window.FileReader) {
      var files = event.target.files; //FileList object
      var output = $(".preview-images-zone");

      for (let i = 0; i < files.length; i++) {
          var file = files[i];
          var checkdiv = $('div.preview-image').length;
         // lemit line
          if (num <= 5 || checkdiv <= 5){  
           
            var num = checkdiv;
            if (!file.type.match('image')) continue;
            
            var picReader = new FileReader();
            
            picReader.addEventListener('load', function (event) {
                var picFile = event.target;
                var html =  '<div class="preview-image preview-show-' + num + '">' +
                            '<div class="image-cancel" data-no="' + num + '"></div>' +
                            '<div class="image-zone"><img id="pro-img-' + num + '" src="' + picFile.result + '"></div>' +
                            '<div class="tools-edit-image"><a href="javascript:void(0)" data-no="' + num + '" class="btn btn-light btn-edit-image">edit</a></div>' +
                            '</div>';

                output.append(html);
                num = num + 1;
            });
        }
          picReader.readAsDataURL(file);
      }
      $("#pro-image").val('');
  } else {
      console.log('Browser not support');
  }
}

 
 