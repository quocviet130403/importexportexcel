@extends('adminlte::page')

@section('title', 'List Data')


@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                List Data
            </h3>
            <div class="card-tools" style="display: flex; gap: 10px">
                {{-- <form action="" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" onclick="return confirm('Confirm delete?')" class="btn btn-danger">Delete Choose</button>
                </form> --}}
                <a href="{{ route('customer.create') }}" type="button" class="btn btn-warning"
                   style="max-width: 200px">Create Data</a>
                <a href="{{ route('customer.import') }}" type="button" class="btn btn-success"
                   style="max-width: 200px">Import Excel</a>
                <a href="{{ route('customer.export') }}" type="button" class="btn btn-danger"
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
            @if (count($customers) === 0)
                <p>No data currently available</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover" id="example" style="background: #FFF">
                        <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th style="width: 200px">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td>{{ $customer->first_name}}</td>
                                <td>{{ $customer->last_name}}</td>
                                <td>{{$customer->phone}}</td>
                                <td>{{$customer->email}}</td>
                                <td style="width: 200px">
                                    <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-success mr-1">Edit</a>
                                    <form action="{{route('customer.destroy',$customer->id)}}"
                                          style="display: inline-block;"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Do you want to delete data?')" class="btn btn-danger delete">Delete</button>
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
