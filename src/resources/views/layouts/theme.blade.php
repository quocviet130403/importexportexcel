<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @if($campus->slug === 'ho-chi-minh')
            Hồ Chí Minh
        @elseif($campus->slug === 'qui-nhon')
            Quy Nhơn
        @endif
    </title>
    <link rel="stylesheet" href="{{ asset('css/app.css?ver='.verTime()) }}">
</head>
<body>
    <style>
        body,p {
            padding: 0;
            margin: 0 !important;
        }
        p.showTextGuest {
            color: {{ $event->colorText }};
            font-size: {{ ($event->fontSize * 3) . 'px' }};
            top: {{ ($event->pointY) . '%' }};
            left: {{ ($event->pointX) . '%' }};
        }
    </style>
    <script>
        const campusId = "{{ $campus->id }}"
        const eventId = "{{ $event->id }}"
    </script>
    <div id="app">
        {{-- @yield('content') --}}
        <loader-hcm-component
            :image="`{{ $event->image }}`">
        </loader-hcm-component>
    </div>
    <script>

    </script>
    <script src="{{ url('js/app.js?ver=' . verTime()) }}"></script>
</body>
</html>
