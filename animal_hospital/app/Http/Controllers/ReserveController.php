<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Reservation;
use App\Http\Requests\TestRequest;
use Validator;
use Session;

class ReserveController extends Controller
{

		// private $global_dates;
		

		public function getCalendarDates($year, $month)
			{
				$date = Carbon::parse("$year-$month-1")->locale('ja_JP');
				$last = $date->copy()->startOfWeek();
				$count = $last->diffInDays($date->copy()->endOfMonth()->endOfWeek()) + 1;
				for ($i = 0; $i < $count; $i++, $last->addDay()) {
						$dates[] = $last->copy();
				}

				return $dates;
				
			}

		public function reserve_date(Request $request)
		{
;
			$visiting_purpose = $request->visiting_purpose;		

			
			$current_date = new Carbon();
			$current_year = $current_date->year;
			$current_month = $current_date->format('m');


			$current_day = $current_date->format('d');
			

			$dates = $this->getCalendarDates($current_year,$current_month);
			
			//テーブルに登録されている予約された日付(全て)
			$reservations = Reservation::get(['reservation_date']);
			
			
			$reservations_array = $reservations->toArray();
			
			$current_reserved_date = [];
			foreach($reservations_array as $key=> $value ){
				
				$reserved_date[] = Carbon::parse($value['reservation_date']);

				if($reserved_date[$key]->month == $current_month){	

					$current_reserved_date[] = $reserved_date[$key];
				}
			}
			
			//日付ごとのデータ
			$grouped_reserved_dates = [];
			foreach($current_reserved_date as $reserved_date){
				$date = $reserved_date->format('Y-m-d');

				$grouped_reserved_dates[$date][] = $reserved_date;
			}


			// dd($grouped_reserved_dates);
			$is_reservation = [];
			foreach($grouped_reserved_dates as $key=> $value){
				$count = count($grouped_reserved_dates[$key]);
				
				if(count($grouped_reserved_dates[$key]) >= 13){

					$is_reservation[$key] = false;
				}
			}
			
		
			return view('reserve.calendar',compact('dates','current_date','current_reserved_date','is_reservation','visiting_purpose'));

		}

		public function next_reserve_date(){
			// dd('ok');
			$current_date = new Carbon();
			$next_date = $current_date->addMonth();
			$next_month_year = $next_date->year;
			$next_month = $next_date->month;
			// dd($next_month);
			//7月のカレンダーを取得
			$dates = $this->getCalendarDates($next_month_year,$next_month);

			//予約が入っている日時を取得
			$reservations = Reservation::get(['reservation_date']);
			
			$reservations_array = $reservations->toArray();
			// dd($reservations_array);

			$next_reserved_date = [];
			foreach($reservations_array as $key=> $value ){
				//Carbonオブジャクトとして取得
				$reserved_date[] = Carbon::parse($value['reservation_date']);
				if($reserved_date[$key]->month == $next_month){	

					// var_dump($reserved_date[$key]);
					//今月の予約された時間帯					
					$next_reserved_date[] = $reserved_date[$key];
				}
			}

			// dd($next_reserved_date);
			//日付ごとのデータ
			$grouped_reserved_dates = [];
			foreach($next_reserved_date as $reserved_date){
				$date = $reserved_date->format('Y-m-d');
				$grouped_reserved_dates[$date][] = $reserved_date;
			}

			// dd($grouped_reserved_dates);
			$is_reservation = [];	
			foreach($grouped_reserved_dates as $key=> $value){
				$count = count($grouped_reserved_dates[$key]);
				// dd($count);
				if(count($grouped_reserved_dates[$key]) >= 13){
					$is_reservation[$key] = false;
				}
			}
			// var_dump(count($is_reservation));
			// exit();
			return view('reserve.next_calendar',compact('dates','next_date','next_reserved_date','is_reservation'));
	
		}

		public function reserve_time(Request $request){
			// dd($request->calendar_date);
			$reserve_date = '';
			// $request->session()->forget('');
			if(empty($request->calendar_date)){
				
				$reserve_date = $request->session()->get('reserve_date');

			}else{

				$reserve_date = $request->calendar_date;
				$request->session()->put('reserve_date',$reserve_date);

			}



			$reserved_time_list = Reservation::where('reservation_date','like',$reserve_date.'%')->pluck('reservation_date');

			

			//carbonオブジェクトに変換
			foreach($reserved_time_list as $key => $reserved_time){
				$reserved_time_list[$key] = Carbon::parse($reserved_time);
			}
			

			//予約された日にちの年月日取得
			$current_date = new Carbon();
			$reserve_date = Carbon::parse($reserve_date);
			// dd($reserve_date);
			$date_format = $reserve_date->format('Y-m-d');
			$date_display_formt = $reserve_date->format('Y年m月d日');
			

			
			$day_of_number = $reserve_date->dayOfWeek;
			

			// 予約可能時間
			$time = Carbon::parse($date_format.'10:00:00');
			// dd($time);
			for($i =0; $i < 17; $i++){
				

				if(!$time->between(Carbon::parse($date_format.'12:00:0'),Carbon::parse($date_format.'13:30:0'))){
					// var_dump($time);
					$available_time_zone[] = $time->copy();	

				}

				$time = $time->addMinutes(30);

			}


			// dd($reserved_time_list);
			$occupied = [];
			foreach($reserved_time_list as $time_list){
				foreach($available_time_zone as $time_zone){
					$time = $time_list->format('H:i');
					$time_zone_format = $time_zone->format('H:i');
					// dd($time_zone_format);
					// dd($time);
					if($time == $time_zone_format){
						$occupied[] = $time_zone_format;
					}
				}

			}

			switch($day_of_number){
				case 0:
				$day = '日';
				break;
				case 1:
				$day = '月';
				break;
				case 2:
				$day = '火';
				break;
				case 3:
				$day = '水';
				break;
				case 4: 
				$day = '木';
				break;
				case 5:
				$day = '金';
				break;
				case 6:
				$day = '土';
				break;
			}
			
			return view('reserve.reservation_time',compact('date_display_formt','day','occupied'));

		}

		public function reserve_info(Request $request){
			// dd($request->time);
			$reserved_time = $request->time;
			
			// dd()
			$reserved_date = $request->date;
			
			$reserved_dayOfWeek = $request->dayOfWeek;

			$request->session()->put(['reserved_time' => $reserved_time,'reserved_date' => $reserved_date,'reserved_dayOfWeek' => $reserved_dayOfWeek]);

			
			return view('reserve.reservation_info',compact('reserved_time','reserved_date','reserved_dayOfWeek'));
				
		}
		

			// dd($reserved_dayOfWeek);
			

		
		 function confirm_form_data(Request $request){
			
			$reserved_date = $request->reserved_date;
			$reserved_dayOfWeek = $request->reserved_dayOfWeek;
			$reserved_time = $request->reserved_time;
			

			$message = [
				'other.required_if' => '種類(犬、猫など)にその他を指定した場合は、その他の項目に動物種名を入力してください。',
				'first_name_furigana.katakana' => 'メイはカタカナで入力してください',
				'last_name_furigana.katakana' => 'セイはカタカナで入力してください',
			];
			
			$validator = Validator::make($request->all(),[
				'last_name' => 'bail|required|string|max:20',
				'first_name' => 'bail|required|string|max:20',
				'last_name_furigana' => 'bail|required|string|katakana|max:30',
				'first_name_furigana' => 'bail|required|string|katakana|max:30',
				'input_animal_name' => 'bail|required|max:50',
				'tel.*' => 'bail|required|numeric',
				'mail' => 'bail|required|email',
				'other'  => 'bail|required_if:animal_type,その他|max:100',
			],$message);

			if($validator->fails()){

				return redirect('/reserve/infomation')->withErrors($validator)->withInput();

			}

			$input_form_datas = '';
			$input_form_datas = $request->all();
			$tel = implode('-',$input_form_datas['tel']);
			
			unset($input_form_datas['tel']);
			return view('reserve.confirm',compact('input_form_datas','tel'));
		}

		function complete_reservation(Request $request){	
			return redirect('/reserve/complete/display')->withInput($request->all());
			dd($request->all());
			$reserve_date = $request->reserve_date;
			
			$reserve_time = $request->reserve_time;
			$reserved_date_insert = $reserve_date . $reserve_time;
			$reserve_dayOfWeek = $request->reserve_dayOfWeek;
			// dd($reserve_dayOfWeek);
			$owner_name = $request->owner_name;
			// dd($owner_name);
			$owner_name_furigana = $request->owner_name_furigana;
			
			// dd($owner_name_furigana	);
			$animal_type = $request->animal_type;
			$animal_name = $request->animal_name;
			$tel = $request->tel;
			$mail = $request->mail;
			
			$other = $request->other;
		
			
			$reserved_date_insert = str_replace(['年','月','日','時','分'],['-','-',' ', ':' , ''],$reserved_date_insert);

			$reservation_record = Reservation::create(
				['reservation_date' => $reserved_date_insert,'owner_name' => $owner_name,'owner_name_furigana' => $owner_name_furigana,
					'animal_name' => $animal_name,'animal_type' => $animal_type,'tel' => $tel,'mailaddress' => $mail,'other' => $other
			]);
			
			 return redirect('/reserve/complete/display')->withInput($request->all());
		}
		
			
		
		public function complete_display(Request $request){
			$datas = $request->old();
			// dd($datas);	
			if(!empty($datas)){
				// dd('ok');
				extract($datas);
				$reserved_date_insert = $reserve_date . $reserve_time;
				// dd($reserved_date_insert);
				$reserved_date_insert = str_replace(['年','月','日','時','分'],['-','-',' ', ':' , ''],$reserved_date_insert);

				// dd($reserved_date_insert);
				$dupulicate_data = [];
				$dupulicate_data = Reservation::where('reservation_date', 'like', '%' . $reserved_date_insert . '%')->get()->toArray();

				if(!empty($dupulicate_data)){
					$err_msg = ['err_msg_first' => '認証に失敗しました','err_msg_secound' => '初めからやり直してください'];
					return redirect('/')->withInput($err_msg);
				}

				$reservation_record = Reservation::create(
					['reservation_date' => $reserved_date_insert,'owner_name' => $owner_name,'owner_name_furigana' => $owner_name_furigana,
						'animal_name' => $animal_name,'animal_type' => $animal_type,'tel' => $tel,'mailaddress' => $mail,'other' => $other
				]);
				// dd($reserve_date);
				return view('reserve.complete',compact(
					'reserve_date','reserve_dayOfWeek','reserve_time','owner_name','owner_name_furigana','animal_type',
					'animal_name','tel','mail','other'
				));
				
			}else{
				// dd('ok');	
				return redirect('/');
			}
			return redirect('/');
			// dd($datas);
		}	

		public function redirect_index(Request $request){

			$err_msg = ['err_msg_first' => '認証に失敗しました','err_msg_secound' => '初めからやり直してください'];

			$reserved_time = $request->session()->get('reserved_time');
			$reserved_date = $request->session()->get('reserved_date');
			$reserved_dayOfWeek = $request->session()->get('reserved_dayOfWeek');

			if(!empty($reserved_time) && !empty($reserved_date) && !empty($reserved_dayOfWeek)){
				return view('reserve.reservation_info',compact('reserved_date','reserved_time','reserved_dayOfWeek'));
			}else{
				return redirect('/')->withInput($err_msg);
			}

		}

}
