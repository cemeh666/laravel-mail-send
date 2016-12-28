<?php namespace LaravelModule\MailSend\Models;

use App\Jobs\SendEmail;

class MailSend extends \Eloquent
{
    public $table = 'delivery';
    protected $guarded = ['id'];
    protected $fillable = [
        'table_name', 'table_field', 'delivery_name', 'mailer', 'template'
    ];

    public static function get_type_fields(){
        return [
            '1' => 'Значение',
            '2' => 'Поле из базы',
            '3' => 'Исполняемый код',
        ];
    }

    public static function get_data_template($template, $record)
    {
        $data = [];
        $settings = \DB::table('settings_template')->where('tmp_name', $template)->first();
        $settings = ($settings) ? unserialize($settings->tmp_fields) : [];

        if($settings)
            foreach ($settings as $item){
                switch ($item['field_type']){
                    case 1:
                        $data[$item['field_name']] =  $item['field_value'];
                        break;
                    case 2:
                        $data[$item['field_name']] =  $record->$item['field_value'];
                        break;
                    case 3:
                        eval('$data[$item["field_name"]] ='. $item["field_value"].';');
                        break;
                }
            }

        return $data;
    }

    public function Validate(){

        $rules = array(
            'table_name'    => array('required'),
            'table_field'   => array('required'),
            'delivery_name' => array('required'),
            'mailer'        => array('required'),
            'template'      => array('required'),
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


    public static function edit_delivery($inputs, $id){

        $delivery = MailSend::where('id', $id)->first();

        $delivery->table_name    = $inputs['table_name'];
        $delivery->table_field   = $inputs['table_field'];
        $delivery->delivery_name = $inputs['delivery_name'];
        $delivery->mailer        = $inputs['mailer'];
        $delivery->template      = $inputs['template'];

        if($delivery->Validate() === true){

            $delivery->save();
            return $delivery;
        }

        return $delivery->Validate();
    }

    public static function sendMail($template, $data, $to, $subject, $mailer = '', $file = null , $replyTo = ''){
        $mailer   = config('mail-send.mailer.'.$mailer);

        \Config::set('mail', $mailer);
        try {
            \Mail::send($template, $data, function ($m) use ($to, $subject, $mailer, $file, $replyTo) {

                $m->from($mailer['from']['address'], $mailer['from']['name']);
                $m->to($to)->subject('=?utf-8?B?' . base64_encode($subject) . '?=');
                if($file){
                    $m->attachData($file['raw'], $file['name'], ['as' => $file['name'], 'mime' => $file['mime']]);
                }
                if($replyTo){
                    $m->replyTo($replyTo);
                }
            });
        } catch (\Exception $e) {
            \Log::error('Email send failed, using sendmail. [' . $to . ', ' . $subject . "]\n Error: ".$e->getMessage());
        }

    }

    public static function sendMailmass($template, $data, $to, $subject, $mailer = '', $file = null , $replyTo = ''){
        $mailer   = config('mail-send.mailer.'.$mailer);

        $params = [
            'address'   => $mailer['from']['address'],
            'name'      => $mailer['from']['name'],
            'email'     => $to,
            'subject'   => $subject,
            'mailer'    => $mailer,
            'template'  => $template,
            'data'      => $data,
        ];
        dispatch(new \App\Jobs\SendEmail($params));

    }

}