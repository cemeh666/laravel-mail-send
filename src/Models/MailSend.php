<?php namespace LaravelModule\MailSend\Models;

class MailSend extends \Eloquent
{
	public $table = 'delivery';
	protected $guarded = ['id'];
	protected $fillable = [
		'table_name', 'table_field', 'delivery_name'
	];


	public function Validate(){
		
		
		$rules = array(
			'table_name'    => array('required'),
			'table_field'   => array('required'),
			'delivery_name' => array('required'),
		);
		$model = self::getModel();
//		dd($model);

		$validator = \Validator::make($model->toArray(), $rules);

		if ($validator->fails()) {
			return $validator;
		}
		return true;
	}
	

	public static function add_delivery($inputs, $count_emails){

		$delivery = new MailSend($inputs);

		if($delivery->Validate() === true){

			$delivery->email_count = $count_emails;

			$delivery->save();
			return $delivery;
		}

		return $delivery->Validate();
	}

}