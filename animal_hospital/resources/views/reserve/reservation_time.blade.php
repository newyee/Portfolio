@extends('layouts.default')

@section('title','予約時間選択')

@section('heading','予約時間選択')

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
      <i class="black_circle_svg"></i>
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
  <div class="reservation_title_letter">
  <h3>予約時間を選択してください</h3>
  <p>{{$date_display_formt}}({{$day}})&nbsp;診察時間&nbsp;10:00～18:00</p>
  </div>
  <div class="reserve_explain_box">
    <p>空き枠状況の見方</p>
    <span class="left_reserve_explain">
      <span class="is_reservation explain_blue_circle">〇</span>
      予約可能時間
    </span>
    <span class="right_reserve_explain">
      <span class="is_reservation_time">✖</span>
      空き枠なし
    </span>
  </div>
  <div class="reserve_time_list">
  @foreach(range(10, 18) as $hour)
    <div class="reserve_time_block flex">
      @foreach([['reserve_status_left', 0], ['reserve_right', 30]] as list($className, $minute))
        @if($hour === 18 && $minute === 30)
          <span>&nbsp;</span>
        @else
          <div class="{{$className}} reserve_status flex">
            <p>{{sprintf("%02d:%02d", $hour, $minute)}}</p>
            @if(in_array(sprintf("%02d:%02d", $hour, $minute), $occupied))
              <p class="no_reservation">✖</p>
            @else
              <form action="{{action('ReserveController@reserve_info')}}" method="post">  
                {{csrf_field()}}
                <input type="hidden" name="time" value="{{sprintf('%02d', $hour)}}時{{sprintf('%02d', $minute)}}分">
                <input type="hidden" name="date" type="submit" value="{{$date_display_formt}}">
                <input type="hidden" name="dayOfWeek" value="{{$day}}">
                <input class="calendar_button reserved_time_button" type="submit" value="〇">
              </form>
            @endif
          </div>
        @endif
      @endforeach
    </div>
  @endforeach
  </div>
</div>

<form class="reserved_time_back_button" action="{{ action('ReserveController@reserve_date') }}" method="post">  
      {{ csrf_field() }}
      <input type="submit" class="back_button" value="戻る">
</form>
</div>


@endsection