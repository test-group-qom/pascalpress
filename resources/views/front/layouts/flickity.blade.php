<div class="flex--flickity" style="height: 501px;">
          <div class="main-carousel">
          @foreach($news as $item)
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
                              <a href="/single_post/{{$item->id}}" >
                                <div class="flex--text">
                                        <h3 class="text">
                                      {{$item->title}}
                                          <div class="flex--line">
                                              <div class="flex--right">      <!-- right -->
                                                <span class="line"></span>
                                              </div>
                                              <div class="flex--left">          <!-- left -->
                                                <span class="line"></span>
                                              </div>
                                          </div>
                                        </h3>
                                    </div>
                                  <p class="descrption">
                                    {{$item->excerpt}}
                                  </p>
                                </a>
                                <div class="flex--button">
                                    <a href="/single_post/{{$item->id}}">
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
