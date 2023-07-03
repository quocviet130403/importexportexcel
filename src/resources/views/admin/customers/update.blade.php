@extends('adminlte::page')

@section('title', 'Update Data')
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
                Update Data
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

            <form id="frmAddPromotion" method="post" action="{{route('customer.update', $customer->id)}}">
                @method('put')
                @csrf
                <div class="form-group">
                    <label for="">First Name</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="first-name" name="first_name" value="{{ $customer->first_name }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Last Name</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="last_name" value="{{ $customer->last_name }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="email" value="{{ $customer->email }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Phone</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="phone" value="{{ $customer->phone }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Street Address</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="street_address" value="{{ $customer->street_address }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">City</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="city" value="{{ $customer->city }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">State</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="state" value="{{ $customer->state }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Country</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="country" value="{{ $customer->country }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Organization Name</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="organization_name" value="{{ $customer->organization_name }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Website</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="website" value="{{ $customer->website }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Instagram</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="instagram" value="{{ $customer->instagram }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Tiktok</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="tiktok"  value="{{ $customer->tiktok }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Twitter</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="twitter"  value="{{ $customer->twitter }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Youtube</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="youtube"  value="{{ $customer->youtube }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="last-name" name="description" value="{{ $customer->description }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Notes</label>
                    <div class="input-group mb-3">
                        <textarea type="text" class="form-control" id="last-name" name="notes">{!! $customer->notes !!}</textarea>
                    </div>
                </div>
                <div class="form-group" style="width: auto;">
                    <label for="">Choose One</label>
                    <select name="choose_one" id="" class="form-control" required>
                        <option value="">-- Choose --</option>
                        <option value="CHURCH" @if($customer->choose_one === "CHURCH") selected @endif>CHURCH</option>
                        <option value="ORGANIZATION" @if($customer->choose_one === "ORGANIZATION") selected @endif>ORGANIZATION</option>
                        <option value="INFLUENCER" @if($customer->choose_one === "INFLUENCER") selected @endif>INFLUENCER</option>
                        <option value="MEDIA" @if($customer->choose_one === "MEDIA") selected @endif>MEDIA</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Services</label>
                    @php 
                        $services = explode(',', $customer->services);
                    @endphp
                    <div class="form-service">
                        <input type="checkbox" name="services[]" id="" value="MONDAY" @if (in_array('MONDAY', $services)) checked @endif>
                        <label for="">MONDAY</label><br>
                        <input type="checkbox" name="services[]" id="" value="TUESDAY" @if (in_array('TUESDAY', $services)) checked @endif>
                        <label for="">TUESDAY</label><br>
                        <input type="checkbox" name="services[]" id="" value="WEDNESDAY" @if (in_array('WEDNESDAY', $services)) checked @endif>
                        <label for="">WEDNESDAY</label><br>
                        <input type="checkbox" name="services[]" id="" value="THURSDAY" @if (in_array('THURSDAY', $services)) checked @endif>
                        <label for="">THURSDAY</label><br>
                        <input type="checkbox" name="services[]" id="" value="FRIDAY" @if (in_array('FRIDAY', $services)) checked @endif>
                        <label for="">FRIDAY</label><br>
                        <input type="checkbox" name="services[]" id="" value="SATURDAY" @if (in_array('SATURDAY', $services)) checked @endif>
                        <label for="">SATURDAY</label><br>
                        <input type="checkbox" name="services[]" id="" value="SUNDAY" @if (in_array('SUNDAY', $services)) checked @endif>
                        <label for="">SUNDAY</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Has Supported</label>
                    @php 
                        $has_supported = explode(',', $customer->has_supported);
                    @endphp
                    <div class="form-service">
                        <input type="checkbox" name="has_supported[]" id="" value="MOVIE SCREENINGS" @if (in_array('MOVIE SCREENINGS', $has_supported)) checked @endif>
                        <label for="">MOVIE SCREENINGS</label><br>
                        <input type="checkbox" name="has_supported[]" id="" value="MEETINGS" @if (in_array('MEETINGS', $has_supported)) checked @endif>
                        <label for="">MEETINGS</label><br>
                        <input type="checkbox" name="has_supported[]" id="" value="EVENTS" @if (in_array('EVENTS', $has_supported)) checked @endif>
                        <label for="">EVENTS</label>
                    </div>
                </div>
                <a href="{{URL::previous()}}" class="btn btn-warning">BACK</a>
                <button type="submit" class="btn btn-success" style="width: 100px;margin-left: 10px">UPDATE</button>
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
