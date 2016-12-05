@extends(config('mail-send.admin-layout'))

@section(config('mail-send.admin-section'))
<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Модуль рассылок</h4>
    </div>
    <div class="panel-body">
        @include('module-send::_system_message')

        <a href="{{route('mail_delivery')}}" class="btn btn-white m-t-10 m-b-10" >
            <i class="fa fa-plus text-success"></i>
            <span>Создать рассылку</span>
        </a>

        <a href="{{route('mail_template')}}" class="btn btn-white m-t-10 m-b-10" >
            <i class="fa fa-gear"></i>
            <span>Настройка шаблонов писем</span>
        </a>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Название рассылки</th>
                <th>Количество запсей</th>
                <th>Дата последнего запуска</th>
                <th>Управление</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($lists))
                @foreach($lists as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->delivery_name}}</td>
                        <td>{{$item->email_count}}</td>
                        <td>@if($item->last_active){{date('d.m.Y', $item->last_active)}} @else Ещё не запускалась @endif</td>
                        <td>
                            <a href="{{action('\LaravelModule\MailSend\Controllers\MailSendController@deliveryEdit', $item->id)}}" class="btn btn-xs btn-white">настройка</a>
                            <a href="{{action('\LaravelModule\MailSend\Controllers\MailSendController@send', $item->id)}}" class="btn btn-xs btn-success">запустить</a>
                            <a href="{{action('\LaravelModule\MailSend\Controllers\MailSendController@deliveryDelete', $item->id)}}" class="btn btn-xs btn-danger">удалить</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">Нет рассылок</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
@endsection