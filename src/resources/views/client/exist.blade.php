<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>301</title>
    <style>
        body{
            padding:0;
        }
        .error-page{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height:100vh;
            font-family: monospace;
        }
        span{
            font-size: 400px;
        }
        h1{
            font-size: 48px;
            margin:0;
        }
        a{
            background-color: #dddddd;
            padding:10px 50px;
            color: #000000;
            border-radius: 7px;
            box-shadow: 2px 2px 10px #000000;
            cursor: pointer;
            text-decoration: none;
        }

        /* mobile responsive code */
        @media only screen and (max-width: 600px) {
            span{
            font-size: 200px!important;
            }
            h1{
                font-size: 42px!important;
            }
            .error-page p{
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="error-page">
        <span>301</span>
        <h1>QR này đã  quét</h1>
    </div>
</body>
</html>
