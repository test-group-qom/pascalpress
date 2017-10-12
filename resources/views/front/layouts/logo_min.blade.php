<script>
$(document).ready(function(){
    $(".nav-opener").click(function(){
        $(".flex--nav_top").slideToggle( "slow" );
    });
});
</script>
<div class="min--logo">
    <div class="min-humber" >
                <div class="opener-holder">
                  <div href="#" class="nav-opener"><span></span></div>
                </div>
    </div>
  <a href="/" class="link">
      <img src="{{asset('front/styles/img/logo.png')}}" class="img--logo" alt="" style='width:100%;' border="0">
      
      <h3 class="slogan">{{$config->description}}</h3>
      
  </a>
  
</div>
