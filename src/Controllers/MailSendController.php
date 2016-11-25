<?php   namespace LaravelModule\MailSend\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelModule\MailSend\Models\MailSend;


class MailSendController extends Controller
{

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
			return back()->withErrors($result->getMessage())->withInput();


		}

		return view('module-send::delivery');
	}
}