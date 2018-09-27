<div class="flex--menu_down">
  <div class="wrapper">
    <div class="flex--menu">

        <ul class="page-breadcrumb">
            <li>
                <a href="{{route('homepage')}}">خانه</a>
            </li>
            @for($i = 1; $i <= count(Request::segments()); $i++)
            <?php
            
                switch(Request::segment($i)){
                    case 'product':
                    case 'products':
                    case 'products-cat': $link_url = route("products-cat"); $link_title ="محصولات"; break;
                    case 'articles': $link_url = route("articles"); $link_title ="مقالات"; break;
                    case 'news': $link_url = route("news"); $link_title ="اخبار"; break;
                    case 'about': $link_url = route("about"); $link_title ="درباره ما"; break;
                    case 'contact': $link_url = route("contact"); $link_title ="تماس با ما"; break;

                    default:
                    if(is_numeric(Request::segment($i))){
                        $link_url = ""; $link_title = $page_title;
                    }
                    break;
                }
                
            ?>
                <li>
                    <a href="{{$link_url}}">{{$link_title}}</a>
                </li>
            @endfor
        </ul>

    </div>
  </div>
</div>
