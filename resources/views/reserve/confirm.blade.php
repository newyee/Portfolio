@extends('layouts.default')

@section('title','情報確認')

@section('heading','情報確認')

@section('content')
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
      <i class="black_circle_svg"></i>
      <p>入力確認</p>
    </li>
    <li>»</li>
    <li>
      <i class="circle_svg"></i>
      <p>登録完了</p>
    </li>
  </ul>
  <h3 class="confirm_title">内容をご確認の上、予約登録ボタンを押してください</h3>
  <table class="confirm_table">
    
    <tr>
      <th>来院目的</th>
      <td>初めての来院&ensp;(初めて〇〇〇動物病院に来院さ…</td>
    </tr>
    <tr>
      <th>希望日時</th>
      <td>{{$input_form_datas['reserved_date']}}({{$input_form_datas['reserved_dayOfWeek']}}){{$input_form_datas['reserved_time']}}～</td>
    </tr>
    <tr>
      <th>飼い主様名</th>
      <td>{{$input_form_datas['last_name']}}&emsp;{{$input_form_datas['first_name']}}</td>
    </tr>
    <tr>
      <th>フリガナ</th>
      <td>{{$input_form_datas['last_name_furigana']}}&emsp;{{$input_form_datas['first_name_furigana']}}</td>
    </tr>
    <tr>
      <th>患者様名</th>
      <td>{{$input_form_datas['input_animal_name']}}</td>
    </tr>
    <tr>
      <th>種類(犬、猫など)</th>
      <td>{{$input_form_datas['animal_type']}}</td>
    </tr>
    <tr>
      <th>TEL</th>
      <td>{{$tel}}</td>
    </tr>
    <tr>
      <th>メールアドレス</th>
      <td>{{$input_form_datas['mail']}}</td>
    </tr>
    <tr>
      <th class="other_th">その他<p class="other_description"></th>
        <td class="other_td"><p>{{$input_form_datas['other']}}</p></td>
    </tr>

  </table>

  <div class="confirm_button_box">
  <a class="back_button confirm_back_button" href="javascript:history.back()">戻る</a>
  <form class="confirm_form" action="{{ action('ReserveController@complete_reservation') }}" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="reserve_date" value="{{$input_form_datas['reserved_date']}}">
      <input type="hidden" name="reserve_time" value="{{$input_form_datas['reserved_time']}}">
      <input type="hidden" name="reserve_dayOfWeek" value="{{$input_form_datas['reserved_dayOfWeek']}}">
      <input type="hidden" name="owner_name" value="{{$input_form_datas['last_name']}}&emsp;{{$input_form_datas['first_name']}}">
      <input type="hidden" name="owner_name_furigana" value="{{$input_form_datas['last_name_furigana']}}&emsp;{{$input_form_datas['first_name_furigana']}}">
      <input type="hidden" name="animal_name" value="{{$input_form_datas['input_animal_name']}}">
      <input type="hidden" name="animal_type" value="{{$input_form_datas['animal_type']}}">
      <input type="hidden" name="tel" value="{{$tel}}">
      <input type="hidden" name="mail" value="{{$input_form_datas['mail']}}">
      <input type="hidden" name="other" value="{{$input_form_datas['other']}}">
      <input class="registration_button" type="submit" value="予約登録する">
    </form>
  </div>
</div>

@endsection