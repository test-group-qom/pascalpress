<div class="flex--flickity" style="height: 100% !important;max-height: 501px;">
          <div class="main-carousel">
          @foreach($slides as $item)
              <div class="carousel-cell">
                @if($item->thumb != null)
                  <img src="{{asset('upload/images/' . $item->thumb )}}" class="img--user" style="height: 100% !important;max-height: 540px !important;" alt="">
                @else
                  <img src="{{asset('upload/images/no-image.png')}}" class="img--content"/>
                @endif
                <div class="overlay">
                    <div class="flex--parent">
                      <div class="flex--center">
                        <div class="flex--menu">
                                  <div class="descrption">
                                    <?php echo $item->content?>
                                  </div>
                                
                                <div class="flex--button">
                                    <a href="{{$item->property}}">
                                      <button type="button" class="button" name="button">  ادامه</button>
                                    </a>
                                </div>
                            </div>
                      </div>
                    </div>
                </div>
              </div>
          @endforeach
          </div>
</div>
