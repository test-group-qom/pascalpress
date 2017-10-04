  class slider {
    constructor(slider) {
      this.slider_name = slider;
      this.global();
      this.BindEvent();
    }
    global(){
      let $event_2      = $(this.slider_name);
      let $carousel_2   = $($event_2).flickity({
        cellAlign: 'left',
        contain: true,
        pageDots: false,
        prevNextButtons: true,
        wrapAround: false,
        //  autoPlay:true,
        draggable:false,
        rightToLeft: false,
        freeScroll: false,
        imagesLoaded: true,
        groupCells: true
      });
      $('#sliderNav1 .carousel-nav').flickity({
        asNavFor: '#slider1 .main-carousel',
        contain: true,
        pageDots: false,
        groupCells: true
      });

      let element = $("#slider2 .video");
      let plus    = 0;
      for (let i = 0; i < element.length; i++) {
        plus++;
        let AppenId = 'video' + plus;
        element.eq(i).attr("id",AppenId);
        $('#' + AppenId);
      }
    }
    BindEvent(){
      $(document).on("click", "#sliderNav2 .carousel-cell", function(i){
        let index_play   = $(this).index() + 1;
        let elem  = $('#' + "video" + index_play)[0];
        $("#slider2  #video" + index_play)[0].load();
        elem.play();
      })
      let $easyzoom = $('.easyzoom').easyZoom();
        $easyzoom.data('easyZoom');

    }
  }
  $(document).ready(function(){
    new slider("#slider1 .main-carousel");
  })