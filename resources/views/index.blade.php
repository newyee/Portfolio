@extends('layouts.default')

@section('title','トップページ')

@section('heading','来院目的')

@section('content')
<div class="top_content">
  <ul class="page_list">
    <li>
      <i class="black_circle_svg"></i>
      <p>来院目的</p>
    </li>
    <li>»</li>
    <li>
      <i class=" reserve_class circle_svg"></i>
      <p>予約日選択</p>
    </li>
    <li>»</li>
    <li>
      <i class=" reserve_class circle_svg"></i>
      <p>予約時間選択</p>
    </li>
    <li>»</li>
    <li>
      <i class="circle_svg"></i>
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
  @php
  $msg_first = old('err_msg_first');
  $msg_secound = old('err_msg_secound');
  @endphp
  <div class="get_err_box">
    @isset($msg_first)
      <p class="get_err">{{$msg_first}}</p>
    @endisset
    @isset($msg_secound)
      <p class="get_err">{{$msg_secound}}</p>
    @endisset
  </div>

  <h1 class="choose_purpose">来院目的を選択してください</h1>

  <form class="index_purpose_button" method="post" action="{{action('ReserveController@reserve_date')}}">
    {{ csrf_field() }}
    <input class="choose_btn" name="visiting_purpose" type="submit" value="初めての来院(初めて〇〇病院に来院される患者様)">
    <!-- <input type="hidden" name="check_page" value="1"> -->
  </form>

  <form class="index_purpose_button" method="post" action="./login">
    {{ csrf_field() }}
    <input class="choose_btn" name="visiting_purpose" type="submit" value="診察券番号をお持ちの方">
      <!-- <input type="hidden" name="check_page" value="1"> -->
  </form>
  <!-- <a class="choose_btn" href="{{action('ReserveController@reserve_date')}}">初めての来院(初めて〇〇病院に来院される患者様)</a> -->

  <!-- <a class="choose_btn" href="#">診察券番号をお持ちの方</a> -->

</div>

@endsection
