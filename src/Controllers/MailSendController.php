<?php   namespace LaravelModule\MailSend\Controllers;

use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelModule\MailSend\Models\MailSend;
use Illuminate\Foundation\Bus\DispatchesJobs;



class MailSendController extends Controller
{
	use DispatchesJobs;
	public function index(){
		$delivery_list = MailSend::get();
		return view('module-send::index',
			['lists' => $delivery_list]);
	}
		
	public function delivery(Request $request){

		if (\Request::isMethod('post'))
		{
			try{
				$list = \DB::table($request->table_name)->pluck($request->table_field);
			}catch (\Exception $e){
				return back()->withErrors($e->getMessage())->withInput();
			}
			
			$result = MailSend::add_delivery($request->all(), count($list));
			if(isset($result->id)){
				\Session::flash('success', 'Найдено '.count($list).' записей');
				return redirect()->route('mail_index');
			}
			return back()->withErrors($result->getMessageBag())->withInput();
		}

		return view('module-send::delivery');
	}
	
	public static function deliveryEdit(Request $request, $id){
		if (\Request::isMethod('post'))
		{
			try{
				\DB::table($request->table_name)->pluck($request->table_field);
			}catch (\Exception $e){
				return back()->withErrors($e->getMessage())->withInput();
			}

			$result = MailSend::edit_delivery($request->all(), $id);
			if(isset($result->id)){
				\Session::flash('success', 'Рассылка изменена');
				return redirect()->route('mail_index');
			}
			return back()->withErrors($result->getMessageBag())->withInput();
		}

		return view('module-send::deliveryEdit',[
			'delivery' => MailSend::where('id', $id)->first()
		]);

	}

	public function deliveryDelete($id){
		MailSend::where('id', $id)->delete();
		return back();
	}


	public function send(Request $request, $id){

		$delivers = MailSend::where('id', $id)->first();
		$table = \DB::table($delivers->table_name)->first();

		$inputs = $request->all();
		if($inputs){
			dd(\DB::table($delivers->table_name)->where($inputs)->get());
		}


		return view('module-send::send',[
			'emails' =>  \DB::table($delivers->table_name)->pluck($delivers->table_field),
			'id'     =>  $id,
			'search_fields' => array_keys((array)$table)
		]);
	}

	public function sendMass(Request $request){
//		 eval('$result = $request->all();');

		$delivery = MailSend::where('id', $request->delivery_id)->first();
		$emails   = \DB::table($delivery->table_name)->get();
		$mailer   = config('mail-send.mailer.'.$delivery->mailer);
		$template = config('mail-send.template.'.$delivery->template.'.name');
		
		\Config::set('mail',$mailer);
		foreach ($emails as $email) {

			$data = MailSend::get_data_template($delivery->template, $email);
			$address = $mailer['from']['address'];
			$name = $mailer['from']['name'];
			$field = $delivery->table_field;
			$email = $email->$field;
			$subject = config('mail-send.template.'.$delivery->template.'.subject');

			$params = [
				'address'   => $address,
				'name'      => $name,
				'email'     => $email,
				'subject'   => $subject,
				'mailer'    => $mailer,
				'template'  => $template,
				'data'      => $data,
			];
				$this->dispatch(new SendEmail($params));

		}
		$delivery->last_active = time();
		$delivery->save();
		return redirect()->route('mail_index')->with('success', count($emails).' писем поставлены в очередь на отправку');

	}


	public function settingsTemplate(Request $request){

		if (\Request::isMethod('post'))
		{
			$fields = [];
			$inputs = $request->all();
			if(isset($inputs['field_name'])){
				$save = [
					'tmp_name' => $inputs['template']
				];
				foreach ($inputs['field_name'] as $key => $input){
					$fields[]=[
						'field_name'  => $input,
						'field_value' => $inputs['field_value'][$key],
						'field_type'  => $inputs['field_type'][$key],
					];
				}
				$save['tmp_fields'] = serialize($fields);

				$update = \DB::table('settings_template')->where('tmp_name', $save['tmp_name'])->update(['tmp_fields' => $save['tmp_fields']]);

				if(!$update)
					\DB::table('settings_template')->insert($save);
			}

			$settings = \DB::table('settings_template')->where('tmp_name', $request->template)->first();
			if(!empty($settings)){
				$fields = unserialize($settings->tmp_fields);
			}

			return view('module-send::settings',[
				'template' => $request->template,
				'settings' => $fields
			]);
		}


		return view('module-send::settings',[

		]);

	}
}
