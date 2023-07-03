@extends('adminlte::page')

@section('title', 'Danh sách khách mời')


@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Danh sách khách mời
            </h3>
            <div class="card-tools" style="display: flex; gap: 10px">
                <form action="{{ route('guest.deleteAll', $event->id) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" onclick="return confirm('Xác nhận xóa?')" class="btn btn-danger">Xóa tất cả</button>
                </form>
                <a href="{{route('guest.create.import', $event->id)}}" type="button" class="btn btn-success"
                   style="max-width: 200px">Import Excel</a>
                <a href="{{route('guest.export', Str::slug($event->name))}}" type="button" class="btn btn-success"
                   style="max-width: 200px">Export Excel</a>
                {{-- <a href="{{route('guest.downloadQRCode', $event->id)}}" type="button" class="btn btn-warning"
                   style="max-width: 200px">Download All QRCode</a> --}}
            </div>
        </div>
        <div class="card-body">
            @if(Session::has('message'))
                <div class="alert alert-{{Session::get('level')}}">
                    {{Session::get('message')}}
                </div>
            @endif
            @if (count($guests) === 0)
                <p>Hiện không có Danh sách khách mời nào</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover" id="example" style="background: #FFF">
                        <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Tên</th>
                            <th>MSSV</th>
                            <th class="text-center">Trạng thái</th>
                            <th style="width: 200px">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($guests as $guest)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td>{{ $guest->fullname}}</td>
                                <td>{{$guest->mssv}}</td>
                                <td class="text-center">
                                    @if($guest->status === 'JOINED')
                                        <span class="text-success">Đã tham gia</span>
                                    @else
                                        <span class="text-danger">Chưa tham gia</span>
                                    @endif
                                </td>
                                <td style="width: 270px">
                                    <a href="{{ route('guest.edit', $guest->id) }}" class="btn btn-success mr-1">Sửa</a>
                                    <form action="{{route('guest.update',$guest->id)}}"
                                        style="display: inline-block;"
                                        class="mr-1"
                                        method="POST">
                                      @csrf
                                      @method('PUT')
                                      <input type="hidden" name="status" value="{{ $guest->status === 'JOINED' ? 'NONE' : 'JOINED' }}">
                                      <button type="submit" onclick="return confirm('Bạn có muốn đổi trạng thái?')" class="btn btn-warning change-status">Đổi trạng thái</button>
                                    </form>
                                    <form action="{{route('guest.destroy',$guest->id)}}"
                                          style="display: inline-block;"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Bạn có muốn xóa khách mời?')" class="btn btn-danger delete">Xóa</button>
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
