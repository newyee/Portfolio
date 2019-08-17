@extends('layouts.default')

@section('title','情報入力')
@section('script')

<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>

  var oldtype = @json(old('animal_type'));
  $(document).ready(function(){
    // セレクトボックスの表示（リダイレクト時）
    $('select[name="animal_type"] option[value="' + oldtype + '"]').prop('selected', true);
  });

</script>

@endsection

@section('heading','情報入力')

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
      <i class="black_circle_svg"></i>
      <p>情報入力</p>
    </li>
    <li>»</li>
    <li>
      <i class="circle_svg"></i>
      <p>入力確認</p>
    </li>
    <li>»</li>
    <li>
      <i class="circle_svg"></i>
      <p>登録完了</p>
    </li>
  </ul>
  <div class="input_info_box">
    @if(count($errors) > 0)
      <div class="errors_box">
      
        <ul class="error_list">
        @foreach(array_unique($errors->all()) as $error)
          <li class="error_message">{{$error}}</li>
        @endforeach
        </ul>
      </div>
    @endif
    <h3 class="infomation_title">下記の情報を入力してください</h3>
    <form class="info_table_form" action="{{action('ReserveController@confirm_form_data')}}" method="post">
    {{ csrf_field() }}
      <input type="hidden" name="reserved_date" value="{{$reserved_date}}">
      <input type="hidden" name="reserved_dayOfWeek" value="{{$reserved_dayOfWeek}}">
      <input type="hidden" name="reserved_time" value="{{$reserved_time}}">
      
      <table class="input_info_table">
        <tr><th>来院目的</th><td>初めての来院&ensp;(初めて〇〇〇動物病院に来院さ…</td></tr>
        <tr><th>希望日時</th><td>{{$reserved_date}}({{$reserved_dayOfWeek}}){{$reserved_time}}～</td></tr>
        <tr>
          <th>飼い主様名<span class="required_check">必須</span></th>
          <td class="input_name">
            <p class="input_content_name">姓</p><input type="text" name="last_name" size="15" value="{{ old('last_name') }}">
            <p class="input_content_name">名</p><input type="text" name="first_name"size="15" value="{{old('first_name')}}">
          </td>
        </tr>
        <tr>
          <th>フリガナ<span class="required_check">必須</span></th>
          <td class="input_name_furigana">
            <p class="input_content_name_f">セイ</p><input type="text" name="last_name_furigana"size="15" value="{{old('last_name_furigana')}}" >
            <p class="input_content_name_f">メイ</p><input type="text" name="first_name_furigana"size="15" value="{{old('first_name_furigana')}}" >
          </td>
        </tr>
        <tr>
          <th>患者様名<span class="required_check">必須</span></th>
          <td class="animal_name_td"><input type="text" name="input_animal_name" size="30" name="input_animal_name" value="{{old('input_animal_name')}}"></td>
        </tr>
        <tr>
          <th>種類(犬、猫など)<span class="required_check">必須</span></th>
          <td>
            <select name="animal_type">
              <option value="犬種" selected>犬種</option>
              <option value="猫種">猫種</option>
              <option value="その他">その他</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>TEL<span class="required_check">必須</span></th>
          <td>
            <input type="tel" name="tel[]" maxlength="5" size="7" value="{{old('tel.0')}}">
            <span>ー</span>
            <input type="tel" name="tel[]" maxlength="5" size="7" value="{{old('tel.1')}}">
            <span>ー</span>
            <input type="tel" name="tel[]" maxlength="5" size="7" value="{{old('tel.2')}}">
          </td>
        </tr>
        <tr>
          <th>メールアドレス<span class="required_check">必須</span></th>
          <td class="mail_td"><input type="email" name="mail" value="{{old('mail')}}"></td>
        </tr>
        <tr>
          <th class="other_th">その他<p class="other_description"><span class="color_red">※</span>動物種名でその他を入力された方は動物種名を入力してください</p></th>
          <td class="other_td"><textarea name="other" maxlength="100"></textarea></td>
        </tr>
      </table>
        <input class="check_input_form" type="submit" value="確認する">
    </form>
    <form class="back_reserve_time" action="{{ action('ReserveController@reserve_time') }}" method="post">
      {{ csrf_field() }}
      <input type="submit" class="back_button info_back_button" value="戻る">
    </form>
  </div>
</div>
 @endsection