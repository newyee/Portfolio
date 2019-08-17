<?php
include 'shop_class.php';
session_start();

if(isset($_SESSION['id'])){
  // var_dump($_SESSION['id']);
  // exit();
  header('Location:top.php');
  exit();
}

$shop = new shop('mysql:host=mysql1.php.xdomain.ne.jp;dbname=practice0011_ecwebsite','practice0011_a','Asdf03151');

$err = [];

 

if($_POST){
  $user_name = filter_input(INPUT_POST,'user_name');
  $password = filter_input(INPUT_POST,'password');

  if(!$user_name){
    $err[] = 'ユーザー名を入力してください';
  }
  if(!$password){
    $err[] = 'パスワードを入力してください';
  }

  if(!count($err) > 0){

    if($user_name == 'admin' && $password == 'admin' ){
      $_SESSION['id'] = 'admin';
      // var_dump('ok');
      // exit();
      header('Location:admin.php');
      exit();
    }

    //var_dump($user_name);
    $user_info = $shop->login_check($user_name);

    if(!empty($user_info)){   
      
      
      if(password_verify($password,$user_info['password'])){
        setcookie('name',$user_name,time() + 60 * 60 * 24 * 30);
        $_SESSION['id'] = $user_info['id'];  

        //echo 'top.phpへ遷移';
        header('Location:top.php'); 
        exit();

      }else{
        $err[] = 'ユーザー名あるいはパスワードが違います';  
      }   

    }else{
      $err[] = 'ユーザー名あるいはパスワードが違います';
      
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

</head>
<body>
  <header class="header_box">
    <a href="user_register.php">
      <img class ="logo" src="./images/logo.png" alt="CodeShop">
    </a>
    <a href="cart.php">
      <img src="./images/cart.png" alt="cart">
    </a>
  </header>

  <div class="content">
  <p class="color_red">
      ※ユーザー名、パスワードに「admin」と入力した場合は、管理ページにログインできます。
    </p>
      <?php if($err):?>
        <div class="check_msg">
          <?php foreach($err as $msg): ?>

            <span class="err"><?=$msg;?></span>

          <?php endforeach;?>
        </div>

        <?php endif;?>
        

    <form class="form" method="post" action="login.php" >
      <p>ユーザー名:<input type="text" name="user_name" placeholder="ユーザー名"></p>
      <p>パスワード:<input type="password" name="password" placeholder="パスワード"></p>
      <input type="submit" value="ログイン">    
    </form>


    <a class="login_link" href="user_register.php">ユーザー新規作成</a>
  
  </div>

</body>
</html>