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
            <h4 class="panel-title">Запуск рассылки</h4>
        </div>
        <div class="panel-body">
            @include('module-send::_system_message')
<a href="{{route('mail_index')}}" class="btn btn-xs btn-white">< назад</a>


            <form action="{{route('mail_send', $id)}}" method="get">

                <a href="#search" class="btn btn-white btn-xs col-md-offset-2 col-md-8 m-b-10" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapseExample"> Поиск </a>
                <div class="collapse" id="search" aria-expanded="true">
                    @foreach($search_fields as $item)
                        <div class="form-group col-md-3">
                            <label>{{$item}}</label>
                            <input type="text" class="form-control" name="{{$item}}" value="">
                        </div>
                    @endforeach
                    <div class="form-group col-md-12 text-center">
                        <button class="btn btn-success" type="submit">Фильтровать</button>
                    </div>
                </div>
            </form>

            <form action="{{route('send_mass')}}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="delivery_id" value="{{ $id }}">
                <div class="form-group col-md-2">
                    <button class="btn btn-success" type="submit">Отправить</button>
                </div>
            </form>


            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Почта</th>
                    <th>Управление</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($emails as $key => $item)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$item}}</td>
                            <td>
                                <a href="">отправить</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection