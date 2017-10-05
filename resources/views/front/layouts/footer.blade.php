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
                          <div class="flex--icon"> <!-- right -->
                            <img src="{{asset('front/styles/img/email-filled-closed-envelope.svg')}}" class="img--user" alt="">
                          </div>
                          <div class="flex--message">  <!-- left -->
                            <h3 class="text">
                              از آخرین  مقالات و اخبار مطلع باشید
                            </h3>
                            <h3 class="title">
                              با وارد کردن ایمیل خود آخرین اطلاعات را دریافت کنید...
                            </h3>
                          </div>
                    </div>
                    <div class="flex--input">
                      <input type="text" class="send_mail" placeholder="" name="" value="">
                      <div class="flex--submit">
                          <input type="submit" class="submit" name="" value="">
                          <img src="{{asset('front/styles/img/left-arrow-angle.svg')}}" class="icon--arrow" alt="">
                      </div>
                    </div>
                    <div class="flex--social">
                      <a href="#" class="flex--bg">
                          <img src="{{asset('front/styles/img/telegram.svg')}}" class="icon" alt="">
                      </a>
                      <a href="#" class="flex--bg">
                          <img src="{{asset('front/styles/img/instagram-logo.svg')}}" class="icon" alt="">
                      </a>

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