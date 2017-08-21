
<!--header start-->
<header class="header white-bg">

    <!--logo start-->
    <a href="javascript:;" class="logo">پاسکال<span> پرس</span></a>
    <!--logo end-->

    <div class="top-nav ">
        <!--search & user info start-->
        <ul class="nav pull-left top-menu">

            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class="icon-user header-user-icon"></i>
                    <span class="username">{{ Auth::user()->name }}</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <div class="log-arrow-up"></div>
                    <!--<li><a href="{{url('/admin/edit_profile')}}"><i class=" icon-suitcase"></i>پروفایل</a></li>
                    <li><a href="{{url('/admin/config')}}"><i class="icon-cog"></i> تنظیمات</a></li>-->
                    <li><a href="{{url('/admin/logout')}}"><i class="icon-key"></i> خروج</a></li>
                </ul>
            </li>
            <!-- user login dropdown end -->
        </ul>
        <!--search & user info end-->

    </div>
</header>
<!--header end-->