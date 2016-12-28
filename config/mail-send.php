<?php

return [
    // Путь по которому расположена админка
    'admin-route'   => 'admin',

    // Используемый шаблон
    'admin-layout'  => 'admin.layout.admin-layout',

    // Секция в которой размещается контент страницы
    'admin-section' => 'content',

    // Добавление почтовых ящиков для отправки
    'mailer' => [
        'yandex' => [
            'host'          => 'smtp.yandex.ru',
            'port'          => 465,
            'encryption'    => 'SSL',
            'username'      => 'chernaya-karta-ru@ya.ru',
            'password'      => 'yTD1FxdB',
            'from'          => [
                'address' => 'chernaya-karta-ru@ya.ru',
                'name'    => 'Chernaya Karta'
            ],
        ]
        //...
    ],
    'template' => [
        'Регистрация' => [
            //blade шаблон
            'name'=>'emails.register',
            'subject' => 'Mail name'
        ]
    ]
];