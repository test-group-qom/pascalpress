<?php
include 'parts/layout_top.php';
include 'parts/header.php';
include 'parts/menu_top.php';
include "parts/logo_min.php";
?>

<div class="contact">
  <div class="wrapper">
    <div class="flex--contact">
      <div class="flex---right">
        <div class="items">
          <div class="item">
            <h3 class="text">ایمیل:</h3>
            <h3 class="title">آدرس: قم، ۴۵ متری صدوق، کوچه ۴۷، پلاک ۷۵</h3>
          </div>
          <div class="item">
            <h3 class="text">ایمیل:</h3>
            <h3 class="title">آدرس: قم، ۴۵ متری صدوق، کوچه ۴۷، پلاک ۷۵</h3>
          </div>
          <div class="item">
            <h3 class="text">ایمیل:</h3>
            <h3 class="title">آدرس: قم، ۴۵ متری صدوق، کوچه ۴۷، پلاک ۷۵</h3>
          </div>

        </div>
      </div>
      <div class="flex---left">
        <div class="flex--inputs">
          <div class="flex--input">
            <input class="input" placeholder="نام" name="" value="" type="text">
          </div>
          <div class="flex--input">
            <input class="input" placeholder="ادرس الکترونیکی" name="" value="" type="text">
          </div>
          <textarea name="name" placeholder="متن نظر" class="textarea" rows="8" cols="80"></textarea>
          <button type="submit" class="submit" name="button">ارسال</button>
        </div>
      </div>
    </div>
  </div>
  <div class="Map" ng-controller="MapCtrl">
    <div id="googleMap"></div>
  </div>
</div>

<?php
include 'parts/footer.php';
include 'parts/layout_bottom.php';
?>