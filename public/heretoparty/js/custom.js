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


  $(".custom-file-group").each(function () {
    var inputFile = $(this).find("[type=file]");
    var fileLabel = $(this).find("label");

    inputFile.on("change", function () {
      var file = this.files[0];
      var formdata = new FormData();
      formdata.append("file", file);
      if (file.name.length >= 30) {
        fileLabel.text("File Added: " + file.name.substr(0, 30) + '..');
      } else {
        fileLabel.text("File Added : " + file.name);
      }
    });

  });


  var PageHeight = $(document).outerHeight();

  $(".auth-section").css("height", PageHeight);


  $('.brochures-slider').slick({
    dots: false,
    infinite: false,
    arrows: true,
    slidesToShow: 3,
    slidesToScroll: 3,
    autoplay: true,
    autoplaySpeed: 3000,
    responsive: [{
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

  $('.gallery-slider').slick({
    dots: false,
    infinite: false,
    arrows: true,
    slidesToShow: 3,
    slidesToScroll: 3,
    autoplay: true,
    autoplaySpeed: 3000,
    responsive: [{
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });


  document.addEventListener('touchmove', function (event) {
    if (event.scale !== 1) {
      event.preventDefault();
    }
  }, false);
})(jQuery)