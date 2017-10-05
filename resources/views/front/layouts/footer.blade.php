<footer>
  <div class="flex--parent">
      <div class="wrapper">
          <div class="flex--wrap">
              <div class="flex---right">
                <div class="min--logo">
                  <a ui-sref="master.index" href="#">
                      <img src="{{asset('front/styles/img/logo.png')}}" class="img--logo" alt="">
                  </a>
                </div>
                <div class="flex--right">   <!-- socail -->
                  <div id="contact-info">
                   <?php echo $config->info ?>
                   </div>
                </div>
              </div>
              <div class="flex---left">
                <div class="flex--right">

                    <div class="flex--info">
                         <h3 class="title">آخرین محصولات</h3>
                          <ul id="last-products">
                            <li>
                              <img src="{{asset('upload/images/art1.png')}}" width="90" height="90" class="img--user" alt="">
                              <a href="javascript:;">عنوان محصول اینجا ...</a>
                            </li>
                            <li>
                              <img src="{{asset('upload/images/art1.png')}}" width="90" height="90" class="img--user" alt="">
                              <a href="javascript:;">عنوان محصول اینجا ...</a>
                            </li>
                            <li>
                              <img src="{{asset('upload/images/art1.png')}}" width="90" height="90" class="img--user" alt="">
                              <a href="javascript:;">عنوان محصول اینجا ...</a>
                            </li>
                            <li>
                              <img src="{{asset('upload/images/art1.png')}}" width="90" height="90" class="img--user" alt="">
                              <a href="javascript:;">عنوان محصول اینجا ...</a>
                            </li>                         
                          </ul>
                    </div>


                </div>
              </div>
          </div>
      </div>
  </div>
  <div class="flex--copy-right">
    <h3 class="title">{{$config->copyright}}</h3>
  </div>
</footer>