<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
</head>
<body>
  
  <div class="back_toppage_box login_back_top">
    <a class="back_toppage" href="/">＞トップページに戻る</a>
  </div>  
  <h3 class="top_login_title">〇〇〇動物病院 | ネット予約</h3>
  <div>
    <form action="#">
      {{ csrf_field() }}
      <table class="login_table">
        <tr>
          <th>飼い主様ID</th>
          <td><input type="text" name="owner_id"></td>
        </tr>
        <tr>
          <th>パスワード</th>
          <td><input type="text" name="password"></td>
        </tr>
      </table>
      <div class="save_info_box"><input type="checkbox" name="save_login_info">ログイン情報を保存</div>
      <div class="login_submit_box"><input type="submit" value="ログイン"></div>
    </form>
  </div>
  
  

</body>
</html>  
