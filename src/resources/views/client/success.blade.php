<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thành công</title>
</head>
<body>
    <style>
        body {
            background-color: #000;
        }
        img{
            width: 100%;
            height: auto;
            object-fit: contain;
        }
        .popup__welcome-detail {
            height: 100%;
            text-align: start;
            color: #fff;
            font-weight: bold;
            font-size: 14px;
            padding: 10px 18%;
        }
        .popup__welcome-detail p:first-child{
            font-size: 20px;
            margin: 0;
        }
    </style>
    <img src="{{ url('/images/checkin.png') }}" alt="welcome">
    <div class="popup__welcome-detail">
        <p>Detail</p>
        <p>Name: {{ $data['fullname'] }}</p>
        <p>studentID: {{ $data['mssv'] ?? "Không có" }}</p>
        <p>Event: Talkshow "AI RESEARCH FOR</p>
        <p>EDUCATION TECHNOLOGY"</p>
    </div>
</body>
</html>
