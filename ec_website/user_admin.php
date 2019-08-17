<?php
include 'shop_class.php';

// session_start();
// if(!isset($_SESSION['id'])){
//   header('Location:login.php');
// }

$shop = new shop('mysql:host=mysql1.php.xdomain.ne.jp;dbname=practice0011_ecwebsite','practice0011_a','Asdf03151');
$user_list = $shop->display_user();
// var_dump($user_list);
// exit(); 


?>




<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザー管理</title>
  
</head>
<body>
  <h1>CodeSHOP 管理ページ</h1>
  <a href="logout.php">ログアウト</a>
  <a href="admin.php">商品管理ページ</a>
  <h2>ユーザ情報一覧</h2>
  <table border="1" cellspacing="0">
  <tbody>
    <tr>
      <th>ユーザID</th><th>登録日</th>
    </tr>
    
      <?php foreach($user_list as $row):?>
        <tr>
        <?php foreach($row as $key => $user):?>
          <td><?php echo $user ?></td>
        <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    
    </tbody>
  </table>
</body>
</html>
