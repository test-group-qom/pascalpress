<?php
include 'parts/layout_top.php';
include 'parts/header.php';
include 'parts/menu_top.php';
?>
<div class="container news">

  <?php include "parts/logo_min.php";?>
  
  <div class="flex--parnet">
    <div class="flex--cover">
      <img src="styles/img/cover_news.jpg" class="img--user" alt="">
    </div>
    <?php include "parts/menu_down.php";?>
    <div class="flex--items">
      <div class="flex---items">
          <div class="wrapper">
            <div class="flex--parent">
              <div class="flex--text">
                <div class="flex---right">
                      <h3 class="text">
                        جستجو
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
                <div class="flex---left">
                    <div class="flex--select">
                          <select class="select" name="">
                              <option value="">جدید ترین ها</option>
                              <option value="">جدید ترین ها</option>
                              <option value="">جدید ترین ها</option>
                          </select>
                          <img src="styles/img/angle-arrow-down.svg" class="arrow_down" alt="">
                      </div>
                </div>
              </div>
              <div class="flex---wrap" ng-controller="atricalsCtrl as parnet">
                <div class="flex--item" ng-repeat="item in parnet.items">
                  <a ui-sref="master.single_artical({id:item.id})">
                    <div class="flex--img">
                      <img ui-src="{{item.image}}" class="img--content" alt="">
                    </div>
                    <div class="flex--content">
                      <h3 class="title">عنوان اطلاعیه در اینقسمت</h3>
                      <p class="descrption">
                        خلاصه اطلاعیه ها در این قسمت دیده خواهد شدخلاصه اطلاعیه ها در این قسمت دیده خواهد شدخلاصه اطلاعیه ها در این قسمت دیده خواهد شد
                      </p>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>

</div>

<?php
include 'parts/footer.php';
include 'parts/layout_bottom.php';
?>