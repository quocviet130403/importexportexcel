@extends('adminlte::page')

@section('title', 'Danh sách sự kiện')


@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Danh sách sự kiện
            </h3>
            <div class="card-tools">
                <a href="{{route('event.create')}}" type="button" class="btn btn-success"
                   style="max-width: 200px">Thêm sự kiện</a>
            </div>
        </div>
        <div class="card-body">
            @if(Session::has('message'))
                <div class="alert alert-{{Session::get('level')}}">
                    {{Session::get('message')}}
                </div>
            @endif
            @if (count($events) === 0)
                <p>Hiện không có sự kiện nào</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover" id="example" style="background: #FFF">
                        <thead>
                        <tr>
                            <th class="">No</th>
                            <th>Tên</th>
                            <th>Đường dẫn</th>
                            <th>Trạng thái</th>
                            <th style="width: 200px">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td class="">{{$loop->iteration}}</td>
                                <td><a href="{{ route('guest.show', $event->id) }}">{{$event->name}}</a></td>
                                <td><a target="_blank" href="{{ url($event->campus->slug . '/' . $event->slug) }}">{{ url($event->campus->slug . '/' . $event->slug) }}</a></td>
                                <td class="">
                                    @if($event->status === 'ENABLE')
                                        <span class="text-success">Đang diễn ra</span>
                                    @else
                                        <span class="text-danger">Đóng</span>
                                    @endif
                                </td>
                                <td style="width: 200px">
                                    <a href="{{route('event.edit',$event->id)}}"
                                        class="btn btn-warning">Sửa</a>
                                    <form action="{{route('event.delete',$event->id)}}"
                                          style="display: inline-block;"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Bạn có muốn xóa sự kiện?')" class="btn btn-danger delete">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@stop

@section('js')
<script>
    $(document).ready(function () {
        $("#example").DataTable();
    });
</script>
@stop
