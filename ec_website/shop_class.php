<?php

class Shop
{

  private $dbh;
  
  public function  __construct($dsn,$user,$password){
    $dbh = new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    $this->dbh = $dbh;
  }

  public function h($str){
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
  }

  public function write($user_name,$password){

    $stmt = $this->dbh->prepare("INSERT INTO user(user_name,password,created_at,updated_at)VALUES(:user_name,:password,now(),now())");
    $stmt->bindValue(':user_name',$user_name,PDO::PARAM_STR);
    $stmt->bindValue(':password',$password,PDO::PARAM_STR);
    $stmt->execute();


  }

  public function user_check($user_name){
    $stmt = $this->dbh->prepare("SELECT user_name FROM user WHERE user_name = :user_name");
    $stmt->bindValue(':user_name',$user_name,PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchALL(PDO::FETCH_ASSOC);
    if(count($result) > 0){
     return '同じユーザー名が既に登録されています'; 
    }
    return 'ok';
    
  }

  public function login_check($user_name){
    $stmt = $this->dbh->prepare(" SELECT id,password FROM user WHERE user_name = :user_name ");
    $stmt->bindValue(':user_name',$user_name,PDO::PARAM_STR);
    $stmt->execute();
    $user_info = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user_info;

  }

  public function add_item($name,$price,$img,$status){
    $stmt = $this->dbh->prepare("INSERT INTO item(name,price,img,status,created_at,updated_at) VALUES(:name,:price,:img,:status,now(),now())");
    $stmt->bindValue(':name',$name,PDO::PARAM_STR);
    $stmt->bindValue(':price',$price,PDO::PARAM_INT);
    $stmt->bindValue(':img',$img,PDO::PARAM_STR);
    $stmt->bindValue(':status',$status,PDO::PARAM_INT);
    $stmt->execute();
    $stmt = $this->dbh->prepare("SELECT id,created_at FROM item WHERE name = :name");
    $stmt->bindValue(':name',$name,PDO::PARAM_STR);
    $stmt->execute();
    $item_data = $stmt->fetch(PDO::FETCH_ASSOC);
    return $item_data;

  }

  public function add_stock($item_id,$stock,$date){
    $stmt = $this->dbh->prepare("INSERT INTO stock(item_id,stock,created_at,updated_at)VALUES(:item_id,:stock,:created_at,:updated_at)");
    $stmt->bindValue(':item_id',$item_id,PDO::PARAM_INT);
    $stmt->bindValue(':stock',$stock,PDO::PARAM_INT);
    $stmt->bindValue(':created_at',$date,PDO::PARAM_STR);
    $stmt->bindValue('updated_at',$date,PDO::PARAM_STR);
    $stmt->execute();

  }

  public function display_user(){
    $stmt = $this->dbh->prepare("SELECT user_name,created_at FROM user");
    $stmt->execute();
    $user_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $user_list;

  }

  public function check_product_name($product_name){
    $stmt = $this->dbh->prepare("SELECT name FROM item WHERE name = :name");
    $stmt->bindValue(':name',$product_name,PDO::PARAM_STR);
    $stmt->execute();
    $item_name = $stmt->fetch(PDO::FETCH_ASSOC);
    return $item_name;
  }

  public function display_product(){
    $stmt = $this->dbh->prepare("SELECT id,name,price,img,status FROM item");
    $stmt->execute();
    $product_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $product_list;

  }

  public function display_quantity(){
    $stmt = $this->dbh->prepare("SELECT item_id,stock FROM stock");
    $stmt->execute();
    $stock_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $stock_list;
  }
  
  public function change_stock($change_stock,$id){
    $stmt = $this->dbh->prepare("UPDATE stock SET stock = :change_stock WHERE item_id = :id");
    $stmt->bindValue('change_stock',$change_stock,PDO::PARAM_INT);
    $stmt->bindValue('id',$id,PDO::PARAM_INT);
    $stmt->execute();

  }

  public function change_public_status($id){
    $stmt = $this->dbh->prepare("UPDATE item SET status = 0 WHERE id = :id");
    $stmt->bindValue('id',$id,PDO::PARAM_INT);
    $stmt->execute();
  }
  public function change_private_status($id){
    $stmt = $this->dbh->prepare("UPDATE item SET status = 1 WHERE id = :id");
    $stmt->bindValue('id',$id,PDO::PARAM_INT);
    $stmt->execute();
  }

  public function delete($id){
    $stmt = $this->dbh->prepare("DELETE FROM item WHERE id = :id");
    $stmt->bindValue('id',$id,PDO::PARAM_INT);
    $stmt->execute();
    $stmt = $this->dbh->prepare("DELETE FROM stock WHERE item_id = :id");
    $stmt->bindValue('id',$id,PDO::PARAM_INT);
    $stmt->execute();
  }

  public function line_up_product(){
    $stmt = $this->dbh->prepare("SELECT id,name,price,img FROM item WHERE status = 1");
    $stmt->execute();
    $list_product = $stmt->fetchALL(PDO::FETCH_ASSOC);
    return $list_product;
  }
  public function cart_check($user_id,$product_id){
    $stmt = $this->dbh->prepare("SELECT item_id FROM cart WHERE user_id = :user_id AND item_id = :product_id");
    $stmt->bindValue('user_id',$user_id,PDO::PARAM_INT);
    $stmt->bindValue('product_id',$product_id,PDO::PARAM_INT);
    $stmt->execute();
    $cart_user_id = $stmt->fetch(PDO::FETCH_ASSOC);
    return $cart_user_id;

  }

  public function add_select_item($user_id,$product_id){
    $stmt = $this->dbh->prepare("INSERT INTO cart(user_id,item_id,amount,created_at,updated_at)VALUES(:user_id,:product_id,1,now(),now())");
    $stmt->bindValue(':user_id',$user_id,PDO::PARAM_INT);
    $stmt->bindValue(':product_id',$product_id,PDO::PARAM_INT);
    $stmt->execute();

  }

  public function update($item_id){
    $stmt = $this->dbh->prepare("UPDATE cart SET amount = amount+1,updated_at = now() WHERE item_id = :item_id");
    $stmt->bindValue(':item_id',$item_id,PDO::PARAM_INT);
    $stmt->execute();
  }

  public function cart_list($user_id){
    $stmt = $this->dbh->prepare("SELECT item_id,amount FROM cart WHERE user_id = :user_id");
    $stmt->bindValue('user_id',$user_id,PDO::PARAM_INT);
    $stmt->execute();
    $item_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $item_list;
  }

  // public function cart_item_info($item_id){
  //   $stmt = $this->dbh->prepare("SELECT item_id FROM cart WHERE item_id = :item_id");
  //   $stmt->bindValue('item_id',$item_id,PDO::PARAM_INT);
  //   $stmt->execute();
  //   $item_info = $stmt->fetch(PDO::FETCH_ASSOC);
  //   return $item_info;
  // }

  public function item_info_list($item_id){
    $stmt = $this->dbh->prepare("SELECT id,name,price,img,status FROM item WHERE id = :item_id");
    $stmt->bindValue('item_id',$item_id,PDO::PARAM_INT);
    $stmt->execute();
    $item_list = $stmt->fetch(PDO::FETCH_ASSOC);
    return $item_list;
  }

  public function delete_cart_item($user_id){
    $stmt = $this->dbh->prepare("DELETE FROM cart WHERE user_id = :user_id");
    $stmt->bindValue('user_id',$user_id,PDO::PARAM_INT);
    $stmt->execute();
  }
  public function decrease_stock($item_id){
    $stmt = $this->dbh->prepare("UPDATE stock SET stock = stock - 1,updated_at = now() WHERE item_id = :item_id");
    $stmt->bindValue('item_id',$item_id,PDO::PARAM_INT);
    $stmt->execute();
  }

  public function cart_item_delete($user_id,$item_id){
    $stmt = $this->dbh->prepare("DELETE FROM cart WHERE user_id = :user_id AND item_id = :item_id");
    $stmt->bindValue('user_id',$user_id,PDO::PARAM_INT);
    $stmt->bindValue('item_id',$item_id,PDO::PARAM_INT);
    $stmt->execute();
  }
  public function change_cart_quantity($user_id,$item_id,$quantity){
    $stmt = $this->dbh->prepare("UPDATE cart SET amount = :quantity WHERE user_id = :user_id AND item_id = :item_id");
    $stmt->bindValue('user_id',$user_id,PDO::PARAM_INT);
    $stmt->bindValue('item_id',$item_id,PDO::PARAM_INT);
    $stmt->bindValue('quantity',$quantity,PDO::PARAM_INT);
    $stmt->execute();
  }

  

}