@extends('adminlte::page')

@section('title', 'Change Pass')
@section('css')

@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Change Pass
            </h3>
        </div>
        <div class="card-body">
            @if(Session::has('message'))
                <div class="alert alert-{{Session::get('level')}}">
                    {{Session::get('message')}}
                </div>
            @endif

            @if(count($errors)>0)
                <ol>
                    @foreach($errors->all() as $err)
                        <li class=" text-warning" style="margin-bottom: 5px">
                            {{$err}}
                        </li>
                    @endforeach
                </ol>
            @endif

            <form id="frmAddPromotion" method="post"
                  action="{{route('user.update', $user->id)}}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">Old Password</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="password-old" name="passwordOld" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">New Password (Password must be at least 8 characters, must have at least 1 special character)</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <a href="{{URL::previous()}}" class="btn btn-warning">Back</a>
                <button type="submit" class="btn btn-success" style="width: 100px;margin-left: 10px">Update</button>
            </form>
        </div>
    </div>
@stop

@section('js')
    {{-- <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('#lfm').filemanager('file');
    </script>

    <script>
        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };
        CKEDITOR.replace('content', options);
    </script> --}}
@stop
