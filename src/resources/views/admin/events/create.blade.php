@extends('adminlte::page')

@section('title', 'Thêm sự kiện')
@section('css')

@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Thêm sự kiện
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

            <form id="frmAddPromotion" enctype="multipart/form-data" method="post" action="{{route('event.store')}}">
                @csrf
                <div class="form-group">
                    <label for="">Tên sự kiện</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                <div id="editHTMLEvent" class="d-flex" style="gap: 30px">
                    <div class="position-relative">
                        <p class="position-absolute" style="transform: translate(-50%,-50%)" id="changeText">text</p>
                        <img style="width:360px; height:640px" src="{{ url('images/image-not-found.jpg') }}" id="changeIMG" alt="">
                    </div>
                    <div class="form" style="width: 100%">
                        <div class="form-group">
                            <label for="">Hình ảnh</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" data-input="thumbnail" id="lfm">Chọn ảnh</span>
                                </div>
                                <input type="text" class="form-control" id="thumbnail" name="image" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Tọa độ hiện tên khách mời</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" id="pointX" name="pointX" placeholder="Tọa độ X" required>
                                <input type="number" class="form-control" id="pointY" name="pointY" placeholder="Tọa độ Y" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Mã màu chữ</label>
                            <div class="input-group mb-3">
                                <input type="color" class="form-control" id="colorText" name="colorText" placeholder="vd: #ffffff" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Fontsize chữ (px)</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" id="fontSize" name="fontSize" value="20" placeholder="vd: 50" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="width: auto;">
                    <label for="">Trạng thái</label>
                    <select name="status" id="" class="form-control" required>
                        <option value="ENABLE">Hoạt động</option>
                        <option value="DISABLE">Tạm dừng</option>
                    </select>
                </div>
                @if ($user->is_admin())
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" style="width: auto;">
                            <label for="">Loại</label>
                            <select name="campus_id" id="" class="form-control" required>
                                @foreach($campus as $item)
                                    <option value="{{ $item->id }}">{{ $item->campus }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @else
                    <input type="hidden" class="form-control" id="" name="campus_id" value="{{ $user->campus->is }}" required>
                @endif
                <a href="{{URL::previous()}}" class="btn btn-warning">QUAY LẠI</a>
                <button type="submit" class="btn btn-success" style="width: 100px;margin-left: 10px">CẬP NHẬT</button>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('#lfm').filemanager('file');
    </script>
    <script>
        $(document).on('change', '#thumbnail', function() {
            $('#changeIMG').attr('src', $(this).val())
        })
        $(document).on('input', '#pointX', function() {
            $('#changeText').css('left', ($(this).val() ?? 0) + '%')
        })
        $(document).on('input', '#pointY', function() {
            $('#changeText').css('top', ($(this).val() ?? 0) + '%')
        })
        $(document).on('input', '#colorText', function() {
            $('#changeText').css('color', ($(this).val() ?? '#000'))
        })
        $(document).on('input', '#fontSize', function() {
            $('#changeText').css('font-size', ($(this).val() ?? '20') + 'px')
        })
    </script>
@stop
