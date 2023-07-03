@extends('adminlte::page')

@section('title', 'Create Data')
@section('css')
    <style>
        .form-service label {
            font-weight: normal !important;
        }
    </style>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Create Data
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

            <form id="frmAddPromotion" method="post" action="{{route('customer.store')}}">
                @csrf
                <div class="form-group">
                    <label for="">First Name</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="first-name" name="first_name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Last Name</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="last_name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Phone</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="phone" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Street Address</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="street_address">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">City</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="city">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">State</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="state">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Country</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="country">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Organization Name</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="organization_name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Website</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="website">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Instagram</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="instagram">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Tiktok</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="tiktok">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Twitter</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="twitter">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Youtube</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="youtube">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="description">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Notes</label>
                    <div class="input-group mb-3">
                        <textarea type="text" class="form-control" id="last-name" name="notes"></textarea>
                    </div>
                </div>
                <div class="form-group" style="width: auto;">
                    <label for="">Choose One</label>
                    <select name="choose_one" id="" class="form-control" required>
                        <option value="">-- Choose --</option>
                        <option value="CHURCH">CHURCH</option>
                        <option value="ORGANIZATION">ORGANIZATION</option>
                        <option value="INFLUENCER">INFLUENCER</option>
                        <option value="MEDIA">MEDIA</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Services</label>
                    <div class="form-service">
                        <input type="checkbox" name="services[]" id="" value="MONDAY">
                        <label for="">MONDAY</label><br>
                        <input type="checkbox" name="services[]" id="" value="TUESDAY">
                        <label for="">TUESDAY</label><br>
                        <input type="checkbox" name="services[]" id="" value="WEDNESDAY">
                        <label for="">WEDNESDAY</label><br>
                        <input type="checkbox" name="services[]" id="" value="THURSDAY">
                        <label for="">THURSDAY</label><br>
                        <input type="checkbox" name="services[]" id="" value="FRIDAY">
                        <label for="">FRIDAY</label><br>
                        <input type="checkbox" name="services[]" id="" value="SATURDAY">
                        <label for="">SATURDAY</label><br>
                        <input type="checkbox" name="services[]" id="" value="SUNDAY">
                        <label for="">SUNDAY</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Has Supported</label>
                    <div class="form-service">
                        <input type="checkbox" name="has_supported[]" id="" value="MOVIE SCREENINGS">
                        <label for="">MOVIE SCREENINGS</label><br>
                        <input type="checkbox" name="has_supported[]" id="" value="MEETINGS">
                        <label for="">MEETINGS</label><br>
                        <input type="checkbox" name="has_supported[]" id="" value="EVENTS">
                        <label for="">EVENTS</label>
                    </div>
                </div>
                <a href="{{URL::previous()}}" class="btn btn-warning">BACK</a>
                <button type="submit" class="btn btn-success" style="width: 100px;margin-left: 10px">CREATE</button>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('#lfm').filemanager('file');
    </script>
@stop
