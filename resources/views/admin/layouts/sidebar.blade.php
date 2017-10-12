<!--sidebar start-->
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">

            <li class="active">
                <a class="" href="/admin/dashboard">
                    <i class="icon-dashboard"></i>
                    <span>داشبورد</span>
                </a>
            </li>

            <li>
                <a href="/admin/category" class="">
                    <i class="icon-list-ul"></i>
                    <span>دسته بندی</span>
                </a>
            </li>

            <li>
                <a href="/admin/tag" class="">
                    <i class="icon-tags"></i>
                    <span>تگ ها</span>
                </a>
            </li>

            <li>
                <a href="/admin/post" class="">
                    <i class="icon-file-text"></i>
                    <span>مطالب</span>
                </a>
            </li>

            <li>

                <form action="/admin/post" method="post">
                    {{csrf_field()}}
                    {{ method_field('GET') }}
                    <input type="hidden" name="post_type" value="1"/>
                    <button type="submit"
                            style="background:none;border:none;color:#fff;margin:0;padding:0;width: 100%; text-align: right;">
                        <a>
                            <i class="icon-file"></i>
                            <span>صفحات</span>
                        </a>
                    </button>
                </form>

            </li>

            <li>
                <form action="/admin/post" method="post">
                    {{csrf_field()}}
                    {{ method_field('GET') }}
                    <input type="hidden" name="post_type" value="2"/>
                    <button type="submit"
                            style="background:none;border:none;color:#fff;margin:0;padding:0;width: 100%; text-align: right;">
                        <a>
                            <i class="icon-shopping-cart"></i>
                            <span>محصولات</span>
                        </a>
                    </button>
                </form>

                </a>
            </li>

            <li>
                <form action="/admin/post" method="post">
                    {{csrf_field()}}
                    {{ method_field('GET') }}
                    <input type="hidden" name="post_type" value="3"/>
                    <button type="submit"
                            style="background:none;border:none;color:#fff;margin:0;padding:0;width: 100%; text-align: right;">
                        <a>
                            <i class="icon-picture"></i>
                            <span>اسلایدشو</span>
                        </a>
                    </button>
                </form>
            </li>

            <li>
                <a class="" href="/admin/contact">
                    <i class="icon-envelope"></i>
                    <span>تماس ها</span>
                </a>
            </li>

            <li>
                <a class="" href="/admin/config">
                    <i class="icon-cog"></i>
                    <span> تنظیمات </span>
                </a>
            </li>

        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
