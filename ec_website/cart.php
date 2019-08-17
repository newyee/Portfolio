<?php

error_reporting(E_ALL);
ini_set("display_errors",1);

include 'shop_class.php';
session_start();

if(!isset($_SESSION['id'])){
  header('Location:login.php');
}

$item_info_list = [];

$shop = new shop('mysql:host=mysql1.php.xdomain.ne.jp;dbname=practice0011_ecwebsite','practice0011_a','Asdf03151');

$user_id = intval($_SESSION['id']);

if(!empty($_POST)){

  $item_id = intval($_POST['item_id']);

  if($_POST['check'] === 'delete'){

    $shop->cart_item_delete($user_id,$item_id);
    $updated_msg = '削除しました。';

  }

  if($_POST['check'] === 'amount'){

    $quantity = filter_input(INPUT_POST,'quantity');
    
    // var_dump($quantity);
    // exit();

    if(!strval($quantity) > 0){
      $err_msg = '数量が入力されていません';
      // var_dump($err_msg);
      // exit();

    }elseif(ctype_digit($quantity)){
      // echo __LINE__;
      if($quantity === '0'){
        echo __LINE__;
        $err_msg = '数値は1以上を入力してください';  
      }else{
        intval($quantity);
        $shop->change_cart_quantity($user_id,$item_id,$quantity);
        $updated_msg = '更新しました。';
      }

    }else{
      $err_msg = '数量は半角数字を入力してください';
    }
  }

}

$item_list = $shop->cart_list($user_id);
 //var_dump($item_list);


foreach($item_list as $item){
  $item_info_list[] = $shop->item_info_list($item['item_id']);
}

// var_dump($item_info_list);
// exit();



$deleted_keys = [];
if($deleted_keys = array_keys($item_info_list,false)){
  foreach($deleted_keys as $value){
    unset($item_info_list[$value]);
  }
  $item_info_list = array_values($item_info_list);
}

// var_dump($item_info_list);
// exit();



$item_info_list = array_filter($item_info_list,function($x){
  return $x['status'] != 0;
});

// var_dump($item_info_list);
// exit();

$item_list = array_filter($item_list,function($x) use($item_info_list){
  return in_array($x['item_id'],array_column($item_info_list,'id'));
});

$item_list = array_values($item_list);

$sum_price = 0;

foreach($item_list as $value){

  foreach($item_info_list as $data){

    if($value['item_id'] == $data['id']){

      $sum_price += $data['price'] * $value['amount'];

    } 
  }
}


if(count($item_info_list) == 0 ){
  $err_msg = '商品はありません';
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
      <h3 class="cart_title">ショッピングカート</h3>
      <p class="updated_msg"><?= isset($updated_msg) ? $updated_msg : ''; ?></p>
      <div class="msg">
        <?= isset($err_msg) ? $err_msg : ''; ?>
      </div>


      <?php if(count($item_info_list) > 0):?>

      <div class="product_list_title">
        <span class="product_list_price">価格</span>
        <span class="product_list_num">数量</span>
      </div>
      <div class="product_list">
        
        <table>
          <?php
            for($i = 0; $i < count($item_info_list); $i++ ): ?>

          <tbody>
            <tr class="cart_table">
            <?php 
              $item_info = $item_info_list[$i];
              $item_amount = $item_list[$i];
               
              
            
            ?>
              <td><img src="<?=$item_info['img']?>" width="120px" ></td>
              <td><span class="item_name"><?=$item_info['name']?></span></td>
              <td>
                <form action="cart.php" method="post">
                  <input type="submit" value="削除">
                  <input type="hidden" name="check" value="delete">
                  <input type="hidden" name="item_id" value="<?=$item_amount['item_id']?>">
                </form>
              </td>
              <td align="left"><span class="item_price">￥<?=$item_info['price']?></span></td>
              <td>
                <form action="cart.php" method="post">
                  <input type="text" name="quantity" value="<?=$item_amount['amount']?>" size="5">個
                  <input type="hidden" name="check" value="amount">
                  <input type="hidden" name="item_id" value="<?=$item_amount['item_id']?>">
                  
                  <input type="submit" value="変更する">
              </form>
              </td>

            </tr>
            
          </tbody>
          

          <?php endfor;?>

          </table>

          <div class="sum">
            合計 <span class="sum_price">￥<?=$sum_price?></span>
          </div>
          <form action="finish.php" method="post">
            <input class="buy_btn" type="submit" value="購入する">
            <input type="hidden" name="item_data" value="<?=htmlspecialchars(json_encode($item_list))?>">
            <input type="hidden" name="check" value="<?php echo $_SESSION['page'] = true; ?>">
          </form>

      </div>
      <?php endif;?>
      
    </div>
  </body>
  </html>