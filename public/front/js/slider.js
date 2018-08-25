class slider_home {
  constructor(slider_home) {
    this.slider_name = slider_home;
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
      autoPlay:true,
      wrapAround: true,
      draggable:true,
      rightToLeft: false,
      freeScroll: false,
      imagesLoaded: true,
      groupCells: true
    });


  }
}
$(document).ready(function(){
  new slider_home(".flex--flickity .main-carousel");
})