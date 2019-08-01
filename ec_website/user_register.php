<?php
include 'shop_class.php';

$shop = new shop('mysql:host=mysql1.php.xdomain.ne.jp;dbname=practice0011_ecwebsite','practice0011_a','Asdf03151');

$success_msg = '';
$err = array();

if(!empty($_POST)){
  
  
  $user_name = filter_input(INPUT_POST,'user_name');
  $password = filter_input(INPUT_POST,'password');

  if($user_name){
    
    if(mb_strlen($user_name) > 100){
      $err[] =  'アカウント作成に失敗しました';
    }elseif(mb_strlen($user_name) < 6){
      $err[] = 'ユーザー名は６文字以上の文字を入力してください';
      
    }elseif(!preg_match("/^[a-zA-Z0-9]+$/",$user_name)){
  
      $err[] = 'ユーザー名を半角英数で入力してください';
    
    }

  }else{
    $err[] = 'ユーザー名を入力してください';
  }

  if($password){
    
    if(mb_strlen($password) > 100){
      $err[] = 'アカウント作成に失敗しました';
    }elseif(mb_strlen($password) < 6 ){
      $err[] = 'パスワードは6文字以上の文字を入力してください';
    }elseif(!preg_match("/^[a-zA-Z0-9]+$/",$password)){
      $err[] = 'パスワードは半角英数で入力してください。';
    }


  }else{
    $err[] = 'パスワードを入力してください';
  }
  

  

  if(!$err){
    $password = password_hash($password,PASSWORD_DEFAULT);

    try{

      $err[] = $shop->user_check($user_name);
      
      if(in_array('ok',$err)){
        
        $shop->write($user_name,$password);
        $success_msg = 'アカウントを作成しました';
        //エラー用の配列初期化
        $err = array();
      }

    }catch(PDOException $e){
      echo $e->getMessage();
    }

  }

}



?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link type="text/css" rel="stylesheet" href="./css/common.css">
  <title>user_regiseter</title>
  <header class="header_box">
    <a href="user_register.php" class="top_logo">
      <img class ="logo" src="./images/logo.png" alt="CodeShop">
    </a>
    <a href="cart.php">
      <img src="./images/cart.png" alt="cart">
    </a>
  </header>

  <div class="content">

      <?php if($err||$success_msg):?> 

        <div class="check_msg">

        <?php foreach($err as $msg):?>

          <p class="err"><?=$msg;?></p>

        <?php endforeach; ?>

        <p class="success_msg"><?=$success_msg;?></p>

        </div>

        <?php endif;?>
        
    
    <form class="form" method="post" action="user_register.php" >
      <p>ユーザー名(半角英数6文字以上)：<input type="text" name="user_name"></p>
      <p>パスワード(半角英数6文字以上):<input type="password" name="password"></p>
      <input type="submit" value="ユーザーを新規作成する">    
    </form>

    <a class="login_link" href="login.php">ログインページに移動する</a>
  
  </div>

</body>
</html>