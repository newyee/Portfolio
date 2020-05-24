@extends('layouts.default')

@section('title','予約日選択')

@section('heading','予約日選択')

@section('content')
<div class="top_content">
  <ul class="page_list">
    <li>
      <i class="check_circle_svg"></i>
      <p>来院目的</p>
    </li>
    <li>»</li>
    <li>
      <i class="black_circle_svg"></i>
      <p>予約日選択</p>
    </li>
    <li>»</li>
    <li>
      <i class="circle_svg"></i>
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
  <h2 class="calendar_title">予約希望日を選択してください</h2>
  <div class="reserve_explain_box">
    <p>空き枠状況の見方</p>
    <span class="left_reserve_explain">
    <span class="is_reservation explain_blue_circle">〇</span>
    予約可能日
    </span>
    <span class="right_reserve_explain">
      <span class="is_reservation">ー</span>
      予約できない日
    </span>
  </div>
  <div class="calendar_list_title">
    <form class="back_calendar" method="post" action="{{url('/reserve')}}">
      {{ csrf_field() }}
      <input type="submit" value="＜">
    </form>
    <p class="next_title_day">{{$next_date->year}}年{{$next_date->month}}月</p>  
    
  </div>

  <table class="calendar_table">
    <thead>
      <tr class="day">
      @foreach (['日', '月', '火', '水', '木', '金', '土'] as $dayOfWeek)
        @if($loop->first)
          <th class="sunday">{{ $dayOfWeek }}</th>
        @elseif($loop->last)
          <th class="saturday">{{ $dayOfWeek }}</th>
        @else
        <th>{{$dayOfWeek}}</th>
        @endif
      @endforeach
      </tr>
    </thead>
    <tbody>
    @foreach($dates as $date)
    
    @if($date->dayOfWeek == 0)
    <tr>
    @endif
        <td class="calendar_td">
          @if($date->month == $next_date->month)
          <p class="calendar_day_p">{{$date->day}}</p>
          
          @if(array_key_exists($date->format('Y-m-d'),$is_reservation))
           
              <p class="reserved_date">—</p>
              
            @else
            
              <form action="{{action('ReserveController@reserve_time')}}" method="post">
                  {{ csrf_field() }}
                  <input type="hidden" name="calendar_date" value="{{$date->format('Y-m-d')}}">
                  <input class="calendar_button" type="submit" value="〇">
              </form>

            @endif
          @endif
        </td>
     @if($date->dayOfWeek == 6)  
    </tr>
    @endif
    @endforeach
    </tbody>

  </table>

  <div class="calendar_back_button">
    <a href="javascript:history.back()" class="back_button">戻る</a>
  </div>


@endsection