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
            <h4 class="panel-title">Создать рассылок</h4>
        </div>
        <div class="panel-body">
            @include('module-send::_system_message')

            <form action="{{route('mail_delivery')}}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="col-md-12">
                    <div class="col-md-3">
                        <label class="news_title">Название рассылки:</label>
                        <input type="text" name="delivery_name" value="{{old('delivery_name')}}" placeholder="Название рассылки" required class="form-control">
                    </div>
                        <div class="col-md-3">
                            <label class="news_title">Таблица с почтами:</label>
                            <input type="text" name="table_name" value="{{old('table_name')}}"  placeholder="Название рассылки" required class="form-control">                                    </div>


                        <div class="col-md-3">
                            <label class="news_title">Поле с почтами:</label>
                            <input type="text" name="table_field" value="{{old('table_field')}}"  placeholder="Название рассылки" required class="form-control">                                       </div>
                    <div class="col-md-3 m-t-20">
                        <button class="btn btn-success">Сохранить</button>
                        <a href="{{route('mail_index')}}" class="btn btn-white">Отмена</a>
                    </div>
                </div>

            </form>

        </div>
    </div>
@endsection