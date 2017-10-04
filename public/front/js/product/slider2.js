  class slider{
    constructor(slider) {
      this.slider_name = slider;
      this.global();
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
      $('#sliderNav2 .carousel-nav').flickity({
        asNavFor: '#slider2 .main-carousel',
        contain: true,
        pageDots: false,
        groupCells: true
      });
    }
  }
  
  $(document).ready(function(){
    new slider("#slider2 .main-carousel");
  });