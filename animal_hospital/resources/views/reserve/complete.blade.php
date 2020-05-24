@extends('layouts.default')

@section('title','予約完了')

@section('heading','予約完了')

@section('content')
<div class="back_toppage_box">
  <a class="back_toppage" href="/">＞トップページに戻る</a>
</div>
<div class="top_content">
  <ul class="page_list">
    <li>
      <i class="check_circle_svg"></i>
      <p>来院目的</p>
    </li>
    <li>»</li>
    <li>
      <i class="check_circle_svg"></i>
      <p>予約日選択</p>
    </li>
    <li>»</li>
    <li>
      <i class="check_circle_svg"></i>
      <p>予約時間選択</p>
    </li>
    <li>»</li>
    <li>
      <i class="check_circle_svg"></i>
      <p>情報入力</p>
    </li>
    <li>»</li>
    <li>
      <i class="check_circle_svg"></i>
      <p>入力確認</p>
    </li>
    <li>»</li>
    <li>
      <i class="check_circle_svg"></i>
      <p>登録完了</p>
    </li>
  </ul>
  <div class="complete_message">
    <h3>以下の内容で予約が完了しました！</h3>
  </div>
  <table class="confirm_table complete_table">
    
    <tr>
      <th>来院目的</th>
      <td>初めての来院&ensp;(初めて〇〇〇動物病院に来院さ…</td>
    </tr>
    <tr>
      <th>希望日時</th>
      <td>{{$reserve_date}}({{$reserve_dayOfWeek}}){{$reserve_time}}～</td>
    </tr>
    <tr>
      <th>飼い主様名</th>
      <td>{{$owner_name}}</td>
    </tr>
    <tr>
      <th>フリガナ</th>
      <td>{{$owner_name_furigana}}</td>
    </tr>
    <tr>
      <th>患者様名</th>
      <td>{{$animal_name}}</td>
    </tr>
    <tr>
      <th>種類(犬、猫など)</th>
      <td>{{$animal_type}}</td>
    </tr>
    <tr>
      <th>TEL</th>
      <td>{{$tel}}</td>
    </tr>
    <tr>
      <th>メールアドレス</th>
      <td>{{$mail}}</td>
    </tr>
    <tr>
      <th class="other_th">その他<p class="other_description"></th>
        <td class="other_td"><p>{{$other}}</p></td>
    </tr>

  </table>

</div>
@endsection