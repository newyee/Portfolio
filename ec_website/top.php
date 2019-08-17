<?php
session_start();
include 'shop_class.php';

// var_dump($_SESSION['id']);
// exit();
if(empty($_SESSION['id'])){
  // var_dump('ok');
  // exit();
  header('Location:login.php');
  exit();
}
// $success_msg = $_SESSION['success_msg'];
// $_SESSION['success_msg'] = '';

$shop = new shop('mysql:host=mysql1.php.xdomain.ne.jp;dbname=practice0011_ecwebsite','practice0011_a','Asdf03151');
$product_list = $shop->line_up_product();
// var_dump($product_list);
// exit();
$stock_list =$shop->display_quantity();
$success_msg = '';
if (isset($_SESSION['success_msg'])) {
  $success_msg = $_SESSION['success_msg'];

  // 一度表示したら捨てる

  unset($_SESSION['success_msg']);
}



if(!empty($_POST)){
  //var_dump($_POST);
  // exit();
  
  $user_id = intval($_SESSION['id']);   
  $product_name = $_POST['name'];
  
  $img = $_POST['img'];
  $price = $_POST['price'];
  $product_id = intval($_POST['product_id']);

  //var_dump($product_id);
  //exit();
  
  $item_check = $shop->cart_check($user_id,$product_id);
  // var_dump($item_check);
  // exit();


  
  if(!$item_check){
    // try{
      $shop->add_select_item($user_id,$product_id);
      $shop->decrease_stock($product_id);
    // }catch(PDOException $e){
    //   echo $e->getMessage();
    // }
    
    // echo __LINE__;
    // exit();
    $_SESSION['success_msg'] = 'カートに登録しました';
    header('Location:'.$_SERVER["SCRIPT_NAME"]);
    //exit();
    

  }else{
    $shop->update($product_id);
    $shop->decrease_stock($product_id);
    // echo __LINE__ . PHP_EOL;
    $_SESSION['success_msg'] = 'カートに登録しました';
  //  var_dump($_SESSION['success_msg']);
    header('Location:'.$_SERVER["SCRIPT_NAME"]);
    exit();
    
    
  }

}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link type="text/css" rel="stylesheet" href="./css/top.css">
  <title>トップページ</title>
</head>
<body>
  <header class="header_box">
    <a href="top.php" class="top_logo">
      <img class="logo" src="./images/logo.png" alt="CodeShop">
    </a>
    

    <p class="user_name">
      ユーザー名:<?php echo $_COOKIE['name']; ?>
    </p>
    <a href="cart.php">
      <img src="./images/cart.png">
    </a>
    <a href="logout.php" class="logout">
      ログアウト
    </a>
  </header>
  <?php if(isset($_POST)):?>
      <p class="success_msg"><?= $success_msg ?></p>
  <?php endif;?>

  <div class="content">
 
  

    <?php 
      if(empty($product_list)):?>
        <p class="product_empty_err">商品はありません</p>
    <?php endif; ?>

    <?php for($i = 0; $i < count($product_list); $i++): ?>
    <?php
      $list = $product_list[$i];
      $stock = $stock_list[$i];
      // var_dump($list['id']);
    ?>

    <div class="content_list">
      <img src="<?=$list['img']?>" width="300px" height="300px">
      <div class="wrap_content">

        <p class="item_name"><?=$list['name']?></p>
        <!-- <?php var_dump($list['item_id']); ?> -->
        
        <p>￥<?=$list['price']?></p>
      </div>
      <?php if($stock['stock'] > 0): ?>
      <form action="top.php" method="post">  
        <input id="cart_btn" type="submit" value="カートに入れる" class="cart_send">
        <input type="hidden" name="name" value="<?=$list['name']?>">
        <input type="hidden" name="img" value="<?=$list['img']?>">
        <input type="hidden" name="price" value="<?=$list['price']?>">
        <input type="hidden" name="product_id" value="<?=$list['id']?>">
        <input type="hidden" name="user_id" value="<?=$_SESSION['id']?>">
      <?php else: ?>
        <p class="err_msg"> 売り切れ</p>
      <?php endif;?>
      </form>
    </div>
    
    <?php endfor;?>

  </div>


</body>
</html>
