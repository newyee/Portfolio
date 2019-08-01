<?php
include 'shop_class.php';

if(isset($_POST['stock_data'])){
  $shop = new shop('mysql:host=mysql1.php.xdomain.ne.jp;dbname=practice0011_ecwebsite','practice0011_a','Asdf03151');
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
    }
  }

}

if(isset($_POST['public'])){

    if($id){
      $shop->change_public_status($id);
      $success_msg = 'ステータスを変更しました';
    }else{
      $err[] = '在庫変更失敗';
    }
    
}

if(isset($_POST['private'])){
  $id = filter_input(INPUT_POST,'id');
  if($id){
    $shop->change_private_status($id);
    $success_msg = 'ステータスを変更しました';
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
  }else{
    $err[] = '在庫変更失敗';
  }

}
  

?>