<?php
session_start();
if(!isset($_SESSION['id'])){
  header('Location:login.php');
}

include 'shop_class.php';
$err = array();
$success_msg = '';
$shop = new shop('mysql:host=mysql1.php.xdomain.ne.jp;dbname=practice0011_ecwebsite','practice0011_a','Asdf03151');
$stock = array();
$product_list = $shop->display_product();
  // var_dump($product_list);
$stock = $shop->display_quantity();
  //  var_dump($stock);
  // exit();
  

  if(empty($product_list)){
    $empty_msg = '商品が登録されていません';
  }

  if(isset($_POST['product_register'])){
    
    $product_name = filter_input(INPUT_POST,'product_name');
    $price = filter_input(INPUT_POST,'price');
    $quantity = filter_input(INPUT_POST,'quantity');
    $status = filter_input(INPUT_POST,'status');
    if(!$product_name){
      $err[] = '商品名を入力してください';
    }
    if(!$price){
      $err[] = '値段を入力してください';
    }elseif(!preg_match("/^[0-9]+$/",$price)){
      $err[] = '値段は半角数字を入力してください';
    }elseif($price > 10000){
      $err[] = '値段は一万円以下にしてください';
    }

    if(!$quantity){
      $err[] = '個数を入力して下さい';
    }elseif(!preg_match("/^[0-9]+$/",$quantity)){
      $err[] = '個数は半角数字で入力してください';
    }

       
    // var_dump($err);
    // exit();
    
    if(!empty($_FILES['img'])){

    
  
      if(!isset($_FILES['img']['error']) || is_int($_FILES['img']['tmp_name'])){
        header('Location:admin.php');
      }
  
      switch($_FILES['img']['error']){
  
        case UPLOAD_ERR_OK:
        break;
        case UPLOAD_ERR_NO_FILE:
          $err[] = 'ファイルが選択されていません';
        break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
          $err[] = 'ファイルサイズが大きすぎます';
        break;
          default:
          $err[] = 'その他のエラーが発生しました';
      }
  
      if($_FILES['img']['size'] > 1000000){
        $err[] = 'ファイルサイズが大きすぎます';
      }
      
      //ファイルが選択されていた場合、拡張子をチェック
      if(!$_FILES['img']['error'] == UPLOAD_ERR_NO_FILE){
        if(!$ext = array_search(mime_content_type($_FILES['img']['tmp_name']),
        array(
          'jpg' => 'image/jpeg',
          'png' => 'image/png',
        ),
  
        true
  
      )){
          $err[] = 'ファイル形式は、「jpg」「png」を指定してください';
        }
      }
      
  
      if(empty($err)){
  
        if(!move_uploaded_file(
          $_FILES['img']['tmp_name'],
    
          $path = sprintf('./images/%s.%s',sha1_file($_FILES['img']['tmp_name']),$ext)
          
         
  
        )){
          $err[] = 'ファイル保存時にエラーが発生しました';
        }
  
        chmod($path, 0644);
      }
      
       
      
  
      if(empty($err)){
        intval($price);
        intval($status);
        try{
          $check = $shop->check_product_name($product_name);
          // var_dump($check);
          // exit();
          if(empty($check)){

            $item_data = $shop->add_item($product_name,$price,$path,$status);
            
            $shop->add_stock($item_data['id'],$quantity,$item_data['created_at']);
            $_SESSION['success_msg'] = '商品を追加しました';
            header('Location:admin.php');
            exit();

          }else{
            $err[] = '同名の商品が既に登録されています';
            // var_dump($err);
          }
          
          


        }catch(PDOException $e){
          echo $e->getMessage();
        }
        
        
        
      }
      
    }
     
  }
  
  if(isset($_POST['stock_data'])){
    //$shop = new Shop('mysql:host=localhost;dbname=ec_website','root','12345');
    $change_stock = filter_input(INPUT_POST,'change_stock');
    $id = filter_input(INPUT_POST,'id');
    
    if(!$id){
      $err[] = '在庫変更失敗';

    }
  
    if(!$change_stock){
      $err[] = '個数を入力してください'; 
    }elseif(!preg_match("/^[0-9]+$/",$change_stock)){
      $err[] = '個数は半角数字で入力してください';
    }elseif($change_stock > 1000000000){
      $err[] = '在庫変更失敗';
    }
  
    if(empty($err)){
  
      if($change_stock){
        intval($change_stock);                      
        intval($id);
        $shop->change_stock($change_stock,$id);
        $success_msg = '在庫数を変更しました';
        $_SESSION['success_msg'] = $success_msg;

        header('Location:' . $_SERVER['PHP_SELF'],true,'301');
        exit();
      }
    }
  
  }
  
  if(isset($_POST['public'])){
    
    $id = filter_input(INPUT_POST,'id');
    if($id){
      $shop->change_public_status($id);
      $success_msg = 'ステータスを変更しました';
      $_SESSION['success_msg'] = $success_msg;
      header('Location:' . $_SERVER['PHP_SELF'],true,'301');
      exit();
    }else{
      $err[] = '在庫変更失敗';
    }
      
  }
  
  if(isset($_POST['private'])){
    $id = filter_input(INPUT_POST,'id');
    if($id){
      $shop->change_private_status($id);
      $success_msg = 'ステータスを変更しました';
      $_SESSION['success_msg'] = $success_msg;
      header('Location:' . $_SERVER['PHP_SELF'],true,'301');
      exit();
    }else{
      $err[] = '在庫変更失敗';
    }
    
  }
  
  if(isset($_POST['delete'])){
  
    $delete = filter_input(INPUT_POST,'delete');
    $id = filter_input(INPUT_POST,'id');
    
    if($id){
      $shop->delete($id);
      $success_msg = '商品を削除しました';
      $_SESSION['success_msg'] = $success_msg;
      header('Location:' . $_SERVER['PHP_SELF'],true,'301');
      exit();
    }else{
      $err[] = '在庫変更失敗'; 
    }
  
  }
    
  $product_list = $shop->display_product();
  // var_dump($product_list);
  $stock = $shop->display_quantity();
  //  var_dump($stock);
  // exit();
  
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>管理ページ</title>
  <style>
    .err{
      color:red;
    }
    .table{
      border-collapse:collapse;
      border:1px solid black;
    }
    .table th,tr, td{
      padding:10px;
    }
    .success_msg{
      color:blue;
    }
    .private_status{
      background-color:#aaaaaa;
    }
  </style>
</head>
<body>
  <h1>CodeSHOP 管理ページ</h1>
  <a href="logout.php">ログアウト</a>
  <a href="user_admin.php">ユーザー管理ページ</a>
  <?php if(isset($empty_msg)):?>
    <p class="err"><?=$empty_msg;?></p>
  <?php endif;?>

  <?php if(isset($_SESSION['success_msg'])): ?>
    <p class="success_msg"><?=$_SESSION['success_msg'];?></p>
  <?php unset($_SESSION['success_msg']); endif; ?>

  <?php if(count($err) > 0) : ?>
    <?php foreach($err as $msg): ?>

      <p class="err"><?= $msg; ?></p>

    <?php endforeach; ?>

  <?php endif; ?>

  
  <hr>
  <h2>商品の登録</h2>
  <form action="admin.php" method="post" enctype="multipart/form-data">
    <p>商品名:<input type="text" name="product_name"></p>
    <p>値段:<input type="text" name="price"></p>
    <p>個数:<input type="text"name="quantity"></p>
    <p>商品画像:<input type="file" name = "img"></p>
    <p>ステータス:  
      <select name="status" >
        <option value="1" label="公開" selected>公開</option>
        <option value="0" label="非公開">非公開</option>
      </select>
    </p>

    <input type="submit" value="商品を登録する">
    <input type="hidden" name="product_register" value="1">
  
  </form>

  <hr>
  <h2>商品画像の一覧・変更</h2>
  <table class="table" border="1">
    <tbody>
      <tr>
        <th>商品画像</th>
        <th>商品名</th>
        <th>価格</th>
        <th>在庫数</th>
        <th>ステータス</th>
        <th>操作</th>
      </tr>
      <?php foreach($product_list as $item_data):  ?>
      <?php foreach($stock as $stock_data):?>
      <tr class="<?php if($item_data['status'] == 0){ echo 'private_status';}?>">  
        <?php if($item_data['id'] === $stock_data['item_id']): ?>        
          <td><img src="<?php echo $item_data['img']?>" height="125px"> </td> 
          <td><?=$item_data['name'] ?></td>
          <td><?= $item_data['price']?></td>
          <td>
            <form action="admin.php" method="post">
              <input type="text" name="change_stock" value="<?=$stock_data['stock']?>">
              <input type="hidden" name="id" value="<?php  echo $stock_data['item_id']?>">
              <input type="hidden" name="stock_data" value="1"> 

              <input type="submit" value="変更する">
            </form>
          </td>
          <td>
            <?php if($item_data['status'] == 1): ?>
            <form action="admin.php" method="post">
              <input type="submit" name="public" value="公開→非公開にする">
              <input type="hidden" name="id" value="<?php echo $item_data['id']; ?>">
              
            </form>
            <?php elseif($item_data['status'] == 0):?>

              <form action="admin.php" method="post">
                <input type="submit" name="private" value="非公開→公開する">
                <input type="hidden" name="id" value="<?php echo $item_data['id']; ?>">
                
              </form>


            <?php endif; ?>

            <td>
              <form action="admin.php" method="post">
                <input type="submit" name="delete" value="削除する">
                <input type="hidden" name="id" value="<?php echo $item_data['id'] ?>">
                <!-- <?php var_dump($item_data['id'])?> -->
              </form>
            </td>
          </td>
          <?php endif;?>  
        </tr>
    <?php endforeach;?>
    <?php endforeach;?>
    </tbody>

  </table>
</body>
</html>