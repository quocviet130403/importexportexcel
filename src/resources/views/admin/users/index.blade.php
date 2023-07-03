@extends('adminlte::page')

@section('title', 'List User')


@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                List User
            </h3>
            <div class="card-tools">
                <a href="{{route('user.create')}}" type="button" class="btn btn-success"
                   style="max-width: 200px">Create User</a>
            </div>
        </div>
        <div class="card-body">
            @if(Session::has('message'))
                <div class="alert alert-{{Session::get('level')}}">
                    {{Session::get('message')}}
                </div>
            @endif
            @if (count($users) === 0)
                <p>There are currently no employees</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover" id="example" style="background: #FFF">
                        <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td>{{ $user->name}}</td>
                                <td>{{ $user->email}}</td>
                                <td>
                                    @if (Auth::user()->id !== $user->id)
                                    <form action="{{route('user.destroy',$user->id)}}"
                                        style="display: inline-block;"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Do you want to delete user?')" class="btn btn-danger delete">Xóa</button>
                                    </form>
                                    @endif
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
