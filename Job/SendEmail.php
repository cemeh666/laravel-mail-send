<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $params;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Array $params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sleep(random_int(2,5));
        $params     = $this->params;
        $address    = $params['address'];
        $name       = $params['name'];
        $email      = $params['email'];
        $subject    = $params['subject'];

        $log = "\n==========================\n";
        $log .= "Отправитель: ".$params['mailer']['username']."\n";
        $log .= "Шаблон: ".$params['template']."\n";
        $log .= "Почта: ".$email."\n";

        $transport = \Swift_SmtpTransport::newInstance($params['mailer']['host'], $params['mailer']['port'], $params['mailer']['encryption'])
            ->setUsername($params['mailer']['username'])
            ->setPassword($params['mailer']['password']);
        $mailer = \Swift_Mailer::newInstance($transport);
        $message = \Swift_Message::newInstance($subject)
            ->setFrom($address, $name)
            ->setTo(array($email))
            ->setBody(view($params['template'], $params['data']), 'text/html');

        \Log::useFiles(storage_path('/logs/mail.log'));

        try{
            $mailer->send($message);
            \Log::info($log);

        }catch (\Exception $e){
            $log .="Ошибка: ".$e->getMessage();
            \Log::warning($log);
        }
    }
}
