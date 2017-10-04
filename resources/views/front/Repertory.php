<?php
include 'parts/layout_top.php';
include 'parts/header.php';
include 'parts/menu_top.php';
include "parts/logo_min.php";
?>
<div class="Repertory">
  <div class="flex--descrption">
    <div class="flex---items">
      <div class="wrapper">
        <div class="flex--parent">
          <div class="flex---wrap">
            <div class="flex--item">
              <a ui-sref="master.single">
                <div class="flex--img">
                  <img src="styles/img/img-content.jpg" class="img--content" alt="">
                </div>
                <div class="flex--content">
                  <h3 class="title">عنوان اطلاعیه در این قسمت</h3>
                  <p class="descrption">لینک</p>
                </div>
              </a>
            </div>
            <div class="flex--item">
              <a ui-sref="master.single">
                <div class="flex--img">
                  <img src="styles/img/img-content.jpg" class="img--content" alt="">
                </div>
              <div class="flex--content">
                  <h3 class="title">عنوان اطلاعیه در این قسمت</h3>
              <a class="descrption">لینک</a>
            </div>
            
          </div>
          <div class="flex--item">
            <a ui-sref="master.single" href="#!/single">
              <div class="flex--img">
                <img src="styles/img/img-content.jpg" class="img--content" alt="">
              </div>
            </a><div class="flex--content"><a ui-sref="master.single">
              <h3 class="title">عنوان اطلاعیه در این قسمت</h3>
            </a><a href="#" class="descrption">لینک</a>
          </div>

        </div>
        <div class="flex--item">
          <a ui-sref="master.single">
            <div class="flex--img">
              <img src="styles/img/img-content.jpg" class="img--content" alt="">
            </div>
          </a><div class="flex--content"><a ui-sref="master.single">
            <h3 class="title">عنوان اطلاعیه در این قسمت</h3>
          </a><a href="#" class="descrption">لینک</a>
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