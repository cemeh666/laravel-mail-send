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
            <h4 class="panel-title">Редактировать рассылку</h4>
        </div>
        <div class="panel-body">
            @include('module-send::_system_message')

            <form action="{{route('delivery_edit', $delivery->id)}}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="col-md-4">
                        <label>Название рассылки:</label>
                        <input type="text" name="delivery_name" value="{{$delivery->delivery_name}}" placeholder="Название рассылки" required class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Таблица с почтами:</label>
                        <input type="text" name="table_name" value="{{$delivery->table_name}}"  placeholder="Таблица" required class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label>Поле с почтами:</label>
                        <input type="text" name="table_field" value="{{$delivery->table_field}}"  placeholder="Поле с почтой" required class="form-control">
                    </div>

                    <div class="col-md-4 m-t-20">
                        <label for="mailer">Выберите отправителя:</label>
                            <select name="mailer" id="mailer" class="form-control">
                                @foreach(config('mail-send.mailer') as $key => $item)
                                    <option value="{{$key}}" @if($delivery->mailer == $key) selected @endif>{{$item['username']}}</option>
                                @endforeach
                            </select>
                    </div>

                <div class="col-md-4 m-t-20">
                    <label for="mailer">Выберите шаблон письма:</label>
                    <select name="template" id="mailer" class="form-control">
                        @foreach(config('mail-send.template') as $key => $item)
                            <option value="{{$key}}" @if($delivery->template == $key) selected @endif>{{$key}}</option>
                        @endforeach
                    </select>
                </div>

                    <div class="col-md-4 m-t-40">
                        <button class="btn btn-success">Сохранить</button>
                        <a href="{{route('mail_index')}}" class="btn btn-white">Отмена</a>
                    </div>

            </form>

        </div>
    </div>
@endsection