<?php $__env->startSection('title','トップページ'); ?>

<?php $__env->startSection('heading','来院目的'); ?>

<?php $__env->startSection('content'); ?>
<div class="top_content">
  <ul class="page_list">
    <li>
      <i class="black_circle_svg"></i>
      <p>来院目的</p>
    </li>
    <li>»</li>
    <li>
      <i class=" reserve_class circle_svg"></i>
      <p>予約日選択</p>
    </li>
    <li>»</li>
    <li>
      <i class=" reserve_class circle_svg"></i>
      <p>予約時間選択</p>
    </li>
    <li>»</li>
    <li>
      <i class="circle_svg"></i>
      <p>情報入力</p>
    </li>
    <li>»</li>
    <li>
      <i class="circle_svg"></i>
      <p>入力確認</p>
    </li>
    <li>»</li>
    <li>
      <i class="circle_svg"></i>
      <p>登録完了</p>
    </li>
  </ul>
  <?php
  $msg_first = old('err_msg_first');
  $msg_secound = old('err_msg_secound');
  ?>
  <div class="get_err_box">
    <?php if(isset($msg_first)): ?>
      <p class="get_err"><?php echo e($msg_first); ?></p>
    <?php endif; ?>
    <?php if(isset($msg_secound)): ?>
      <p class="get_err"><?php echo e($msg_secound); ?></p>
    <?php endif; ?>
  </div>

  <h1 class="choose_purpose">来院目的を選択してください</h1>

  <form class="index_purpose_button" method="post" action="<?php echo e(action('ReserveController@reserve_date')); ?>">
    <?php echo e(csrf_field()); ?>

    <input class="choose_btn" name="visiting_purpose" type="submit" value="初めての来院(初めて〇〇病院に来院される患者様)">
    <!-- <input type="hidden" name="check_page" value="1"> -->
  </form>

  <form class="index_purpose_button" method="post" action="/login">
    <?php echo e(csrf_field()); ?>

    <input class="choose_btn" name="visiting_purpose" type="submit" value="診察券番号をお持ちの方">
      <!-- <input type="hidden" name="check_page" value="1"> -->
  </form>
  <!-- <a class="choose_btn" href="<?php echo e(action('ReserveController@reserve_date')); ?>">初めての来院(初めて〇〇病院に来院される患者様)</a> -->

  <!-- <a class="choose_btn" href="#">診察券番号をお持ちの方</a> -->

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\xampp\htdocs\animal_hospital\resources\views/index.blade.php ENDPATH**/ ?>