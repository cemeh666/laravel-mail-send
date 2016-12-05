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
            <h4 class="panel-title">Настройка шаблонов</h4>
        </div>
        <div class="panel-body">
            @include('module-send::_system_message')
<a href="{{route('mail_index')}}" class="btn btn-xs btn-white">< назад</a>

            @if(isset($template))
                <h4>
                    Настройка шаблона <b>{{$template}}</b>
                    <a class="btn btn-xs btn-white" id="add_field"><i class="fa fa-plus text-success"></i> Добавить поле</a>
                </h4>
                <form action="{{route('mail_template')}}" class="form-horizontal" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="template" value="{{$template}}">

                    <table class="table">
                        <tr>
                            <th>
                                Название поля:
                            </th>
                            <th>
                                Значение поля:
                            </th>
                            <th>
                                Тип:
                            </th>
                        </tr>
                        @if(!empty($settings))
                            @foreach($settings as $item)
                                <tr class="clone">
                                    <td>
                                        <input type="text" name="field_name[]" placeholder="Название поля" class="form-control"
                                               value="{{$item['field_name']}}">
                                    </td>
                                    <td>
                                        <input type="text" name="field_value[]" placeholder="Значение поля" class="form-control"
                                               value="{{$item['field_value']}}">
                                    </td>
                                    <td>
                                        <select name="field_type[]" class="form-control">
                                            @foreach(\LaravelModule\MailSend\Models\MailSend::get_type_fields() as $key => $type)
                                                <option value="{{$key}}" @if($key == $item['field_type']) selected @endif>
                                                    {{$type}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <a class="del_field">удалить поле</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                                <tr class="clone">
                                    <td>
                                        <input type="text" name="field_name[]" placeholder="Название поля" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="field_value[]" placeholder="Значение поля" class="form-control">
                                    </td>
                                    <td>
                                        <select name="field_type[]" class="form-control">
                                            <option value="1">
                                                Значение
                                            </option>
                                            <option value="2">
                                                Поле из базы
                                            </option>
                                            <option value="3">
                                                Исполняемый код
                                            </option>
                                        </select>
                                        <a class="del_field">удалить поле</a>
                                    </td>
                                </tr>
                        @endif



                    </table>
                    <div class="form-group col-md-2">
                        <button class="btn btn-success" type="submit">Сохранить</button>
                    </div>
                </form>
            @else
                <form action="{{route('mail_template')}}" class="form-horizontal" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group col-md-5">
                        <label class="col-md-6 control-label" for="mailer">Выберите шаблон:</label>
                        <div class="col-md-6">
                            <select name="template" id="mailer" class="form-control">
                                @foreach(config('mail-send.template') as $key => $item)
                                    <option value="{{$key}}">{{$key}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <button class="btn btn-success" type="submit">Настроить</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <script>
        $("#add_field").click(function(){
            $('.clone').clone().appendTo('.table');
        });

        $("table").on('click','.del_field',function(){
//            console.log($(this));
            $(this).closest('tr').remove();
//            $('.clone').detach();
        })
    </script>
@endsection