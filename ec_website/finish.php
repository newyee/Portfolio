<?php
include 'shop_class.php';
session_start();
if(!isset($_SESSION['id'])){
  header('Location:login.php');
}

$sum = 0;
$shop = new shop('mysql:host=mysql1.php.xdomain.ne.jp;dbname=practice0011_ecwebsite','practice0011_a','Asdf03151');

if(!empty($_POST)){
  if(!empty($_SESSION['page']) && $_SESSION['page'] === true){
    unset($_SESSION['page']);
  
    $shop->delete_cart_item($_SESSION['id']);
    $item = $shop->cart_list($_SESSION['id']);

    // var_dump($_POST);
    // exit();
    $item_list = filter_input(INPUT_POST,'item_data');
    // var_dump($item_list);
    // exit();
    $item_list = json_decode($item_list,true);



    foreach($item_list as $item){
      $item_info_list[] = $shop->item_info_list($item['item_id']);
    }

    //    var_dump($item_info_list);
    //    var_dump($item_list);
    //  exit();

    for($i = 0; $i < count($item_list); $i++){
      if($item_info_list[$i]['id'] === $item_list[$i]['item_id']){
        $sum += $item_list[$i]['amount'] * $item_info_list[$i]['price'];
      }
    }

    //var_dump($sum);
    // exit();

  }
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link type="text/css" rel="stylesheet" href="./css/cart.css">

  <title>カートページ</title>
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
      <div class="cart_content">
        
        
        <p class="finish_msg">ご購入ありがとうございました</p>
  
          <div class="product_list_title">
            <span class="product_list_price">価格</span>
            <span class="product_list_num">数量</span>
          </div>

          <table class="border">
            <?php

              if(isset($item_list)):
                for($i = 0; $i < count($item_list); $i++):   
              
              
             
             ?>
            <tbody>
              <tr class="cart_table">
                <td><img src="<?= $item_info_list[$i]['img']?>" width="120px" ></td>
                <td><span class="item_name"><?= $item_info_list[$i]['name']?></span></td>
                <td align="left"><span class="item_price">￥<?= $item_info_list[$i]['price']?></span></td>
                <td><span class="finish_amount"><?= $item_list[$i]['amount'] ?></span></td>
            </tbody>
            <?php endfor;?>
            <?php endif ?>
          </table>
          <div class="sum">
            <p>合計:&emsp;<span class="sum_price">￥<?=$sum?></span></p>
          </div>



      </div> 
    
</body>
</html>