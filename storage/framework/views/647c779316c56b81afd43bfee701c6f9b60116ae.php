<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title><?php echo $__env->yieldContent('title'); ?></title>
  <link rel="stylesheet" href="/animal_hospital/public/css/styles.css">
</head>
<body>
  <header>
    <div class="header_top">
      <a class="svg_header_logo" href="<?php echo e(url('/')); ?>"></a>
      <p>〇〇〇動物病院</p>
    </div>
    <div class="clearfix vets_number">
      <p><span class="font_bold">医院TEL</span><a href="000-0000-0000">000-0000-0000</a></p>
    </div>
    <div class="purpose">
      <p><?php echo $__env->yieldContent('heading'); ?></p>
    </div>
  </header>
  <?php echo $__env->yieldContent('content'); ?>


</body>
</html><?php /**PATH C:\xampp\xampp\htdocs\animal_hospital\resources\views/layouts/default.blade.php ENDPATH**/ ?>