$(document).ready(function() {  

  //Slider para la busqueda

    function getSliderSettings(){
        return {
              infinite: true,
              slidesToShow: 7,
              slidesToScroll: 7,
              responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 4,
              slidesToScroll: 4,
              infinite: true
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          }
        ]
      }
     }

  // Slider de los detalles

    $('.detalles').click(function () {
       var id = $(this).val();
       var dataString = 'id=' + id;

        $.ajax({
            type: "POST",
            cache: false,
            url: "/",
            data: dataString,
            success: function(data) {
                $('.m-container').slideDown().html(data);
                $('.head-bar').slideUp();
                $('.footer').hide();
                $('.pgwSlider').slideUp();
                $('.slider-detalles').slick(getSliderSettings());
                bclose(); trailer(); movie(); play(); deta();  
            }              
        });
    });

    function deta() {
    $('.detalles-info').click(function () {
       var id = $(this).val();
       var dataString = 'id=' + id;

        $.ajax({
            type: "POST",
            cache: false,
            url: "/",
            data: dataString,
            success: function(data) {
                $('.m-container').html(data);
                $('.slider-detalles').slick(getSliderSettings());
                bclose();
                deta();
            }              
        });
    });
  }
    //Detalles de la busqueda

    function searchdetalles() {
    $('.search-detalles').click(function () {
       var id = $(this).val();
       var dataString = 'id=' + id;

        $.ajax({
            type: "POST",
            cache: false,
            url: "/",
            data: dataString,
            beforeSend: function(){
              
            },
            success: function(data) {
              $('#searchs').slideUp();
              $('.m-container').slideDown().html(data);
              $('.head-bar').slideUp();
              $('.footer').hide();
              var mediaquery = window.matchMedia("(max-width: 600px)");
              function handleOrientationChange(mediaquery) {
                if (mediaquery.matches) {
                    $('.head-bar').css('height','140px');
                    $('.navbar-form').css('padding','0');
                } else {
                    $('.head-bar').css('height','70px');
                    $('.navbar-form').css('padding','10px 15px');
                    $('.navbar-form').css('padding-bottom','0');
                    $('.navbar-form').css('padding-top','0');
                }
              }
              handleOrientationChange(mediaquery);
              mediaquery.addListener(handleOrientationChange);
            $('#searchs').slideUp();
            $('.btn-modify').html('<span class="fa fa-search"></span>');
            $('.navbar-brand').slideDown();
            formsearch.reset();
            bclose();
            movie();   
            }              
        });
    });
  }

  //Busqueda

    $('#search').keyup(function(e){

        var search = $(this).val();       
        var dataString = 'search='+search;

        if(search.length <= 0){    
            var mediaquery = window.matchMedia("(max-width: 600px)");
              function handleOrientationChange(mediaquery) {
                if (mediaquery.matches) {
                    $('.head-bar').css('height','140px');
                    $('.navbar-form').css('padding','0');
                } else {
                    $('.head-bar').css('height','70px');
                    $('.navbar-form').css('padding','10px 15px');
                    $('.navbar-form').css('padding-bottom','0');
                    $('.navbar-form').css('padding-top','0');
                }
              }
              handleOrientationChange(mediaquery);
              mediaquery.addListener(handleOrientationChange);
            $('#searchs').animate(350, "swing").slideUp();
            $('.btn-modify').html('<span class="fa fa-search"></span>');
            $('.navbar-brand').slideDown();
            $('.pgwSlider').slideDown();

            formsearch.reset();

        } else if (e.keyCode === 27) {
            var mediaquery = window.matchMedia("(max-width: 600px)");
              function handleOrientationChange(mediaquery) {
                if (mediaquery.matches) {
                    $('.head-bar').css('height','140px');
                    $('.navbar-form').css('padding','0');
                } else {
                    $('.head-bar').css('height','70px');
                    $('.navbar-form').css('padding','10px 15px');
                    $('.navbar-form').css('padding-bottom','0');
                    $('.navbar-form').css('padding-top','0');
                }
              }
              handleOrientationChange(mediaquery);
              mediaquery.addListener(handleOrientationChange);
              $('#searchs').animate(350, "swing").slideUp();
              $('.btn-modify').html('<span class="fa fa-search"></span>');
              $('.navbar-brand').slideDown();
              $('.pgwSlider').slideDown();

              formsearch.reset();

        }else{

            $.ajax({
            type: "POST",
            cache: false,
            url: "/",
            data: dataString,
            beforeSend: function(){
                $('.btn-modify').html('<div class="fa fa-circle-o-notch fa-spin fa-fw"></div>');
            },
            success: function(data) {
                var mediaquery = window.matchMedia("(max-width: 600px)");
                function handleOrientationChange(mediaquery) {
                  if (mediaquery.matches) {
                    $('.head-bar').animate(350, "swing").css('height','40px');
                  }
                }
                handleOrientationChange(mediaquery);
                mediaquery.addListener(handleOrientationChange);
                $('.navbar-form').css('padding','0');
                $('.navbar-brand').animate(100, "swing").slideUp();
                $('#searchs').animate(350, "swing").slideDown().html(data);
                $('.slider-search').slick(getSliderSettings());
                $('.pgwSlider').slideUp();
                searchdetalles();
                }              
            });
        }
        e.preventDefault();
    });

    function movie() {
    $('.movie').click(function () {

      var idmovie = $(this).val();
       var dataString = 'idmovie=' + idmovie;

        $.ajax({
            type: "POST",
            cache: false,
            url: "homepage",
            data: dataString,
            beforeSend: function(){
            },
            success: function(data) {
                $('.video-detalles').remove();
                $('.rep-movie').show().html(data);
            }              
        });
               
      })
    }

    function trailer() {
    $('.trailer').click(function () {

      var idtrailer = $(this).val();
       var dataString = 'idtrailer=' + idtrailer;

        $.ajax({
            type: "POST",
            cache: false,
            url: "homepage",
            data: dataString,
            beforeSend: function(){
            },
            success: function(data) {
                $('.rep-movie').hide();
                $('.video-detalles').remove();
                $('.rep-trailer').show().html(data);
            }              
        });
               
      })
    }

    function bclose() {
    $(".btn-close").click(function() { 
        $('.m-container').slideUp().remove();
        $('.m-busqueda').slideUp();
        $('.divs').append('<div class="m-container"></div>');
        $('.pgwSlider').slideDown();
        $('.head-bar').slideDown();
        $('.footer').show();
      });
    }

   $(".btn-serie").click(function() { 
      var id = $(this).val();
       var dataString = 'id=' + id;

        $.ajax({
            type: "POST",
            cache: false,
            url: "homepage",
            data: dataString,
            beforeSend: function(){
            },
            success: function(data) {
              var mediaquery = window.matchMedia("(max-width: 600px)");
                function handleOrientationChange(mediaquery) {
                  if (mediaquery.matches) {
                      $('.m-series').show().animate({ width: "100%" }, 400, "swing").html(data);
                  } else {
                      $('.m-series').show().animate({ width: "30%" }, 400, "swing").html(data);
                  }
                }
                handleOrientationChange(mediaquery);
                mediaquery.addListener(handleOrientationChange);
                $('.pgwSlider').slideUp();
                serieclose();
                playitem();
                capitulos();
            }              
        });

    })

   function capitulos() {
    $(".btn-capitulo").click(function() { 

       var idvideo = $(this).val();
       var dataString = 'idvideo=' + idvideo;

        $.ajax({
            type: "POST",
            cache: false,
            url: "homepage",
            data: dataString,
            beforeSend: function(){
            },
            success: function(data) {
              var mediaquery = window.matchMedia("(max-width: 600px)");
                function handleOrientationChange(mediaquery) {
                  if (mediaquery.matches) {
                      $('.m-capitulo').show().animate({ width: "100%" }, 400, "swing").html(data);
                      $('.m-series').css('display','none');
                      $('.m-capitulo').css('left','0');
                  } else {
                      $('.m-capitulo').show().animate({ width: "70%" }, 400, "swing").html(data);
                  }
                }
                handleOrientationChange(mediaquery);
                mediaquery.addListener(handleOrientationChange);
                capituloclose();
            }              
        });

    })

  }

    function serieclose() {
      $(".btn-serieclose").click(function() { 
          $('.m-series').hide();
          $('.pgwSlider').slideDown();
          $('.m-capitulo').hide().remove();
          $('.divs').append('<div class="m-capitulo"></div>');
          $("video").each(function () { this.pause() });
      })
    }

    function capituloclose() {
      $(".btn-capituloclose").click(function() { 
          $('.m-capitulo').hide().remove();
          $('.divs').append('<div class="m-capitulo"></div>');
          $("video").each(function () { this.pause() });
      })
    }

    $(".btn-movies").hover(function() {
        $( this ).css('opacity','0.5');
      }, function() {
        $( this ).css('opacity','1');
      }
    );

    function play() {
    $(".play").hover(function() {
        $( this ).css('opacity','0.5');
      }, function() {
        $( this ).css('opacity','1');
      }
    );
    }

    function playitem() {
      $(".badge-icon").hover(function() {
        $(this).html('<span class="fa fa-play" style="margin-right:15px;"></span>');
      }, function() {
        $(this).html('<span class="fa fa-play-circle" style="margin-right:15px;"></span>');
      });
    }

});

    