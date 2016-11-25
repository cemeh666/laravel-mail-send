<?php $success = \Session::get('success', null); ?>
@if (isset($errors) && count($errors) > 0)
    <div class="alert alert-danger fade in m-b-15">
        <strong>Error!</strong>                    <span class="close" data-dismiss="alert">×</span>

        <ul class="uk-list uk-list-line" >
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if ($success)

    <div class="alert alert-success fade in m-b-15">
        <strong>{{$success}}!</strong>                    <span class="close" data-dismiss="alert">×</span>
    </div>
@endif