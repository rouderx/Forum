<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $title;?></title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:100,200,300,400,500,600" rel="stylesheet">
    <style type="text/css">
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Josefin Sans', sans-serif;
            height: 100vh;
            margin: 0;
            min-width: 300px;
            font-size: 16px;
        }

        .links a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .full-height {
            height: 100vh;
            padding-top: 50px;
            margin-bottom: -50px;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
            font-weight: 100;
        }

        .subtitle {
            font-size: 25px;
            font-weight: 300;
        }

        .footer {
            /*position: absolute;*/
            bottom: 0;
            width: 100%;
            /* Set the fixed height of the footer here */
            height: 50px;
            line-height: 50px; /* Vertically center the text there */
            text-align: center;
        }

        .navbar-default {
            background-color: white;
            border-color: white;
        }

        .navbar-toggle {
            z-index: 10;
        }
        
        .navbar-brand {
            position: absolute;
            width: 100%;
            left: 0;
            text-align: center;
            margin:0 auto;
            font-weight: 600;
        }

        .navbar-t {
                width: 250px;
                margin: 0 auto;
                cursor: pointer;
        }

        .navbar-t:hover {
            color: #333;
        }

        .dropdown-menu>li>a {
            float: right;
        }

        .m-b {
            margin-bottom: 30px;
        }

        .m-b-s {
            margin-bottom: 10px;
        }

        .m-t {
            margin-top: 10px;
        }
        .p-a {
            padding: 10px;
        }

        .p-t {
            padding-top: 51px;
        }

        input[type="submit"] { 
            background-color: #fff;
            border: none;
            font-weight: 600;
            color: #777;
            text-transform: uppercase;
            font-size: 12px;
            height: 26px;
        }

        input[type="submit"]:hover{ 
            color: #333;
        }

        .thread:hover {
            background-color: rgba(230, 230, 230, 0.38);
            cursor: pointer;
        }

        .hover {
            display: none;
        }

        #new-q {
            display: none;
        }

        .line {
            height: 1px;
            background-color: rgba(99, 107, 111, 0.25);
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .fs-sm {
            font-size: 11px;
        }

        .bg-c-lg {
            color: #b1b1b1;
        }

        .ah > a {
            color: #6e7373;
        }

        .mh-sm {
            min-height: 120px;
        }

        .m-t-md {
            margin-top: 20px;
        }

        .fc-b1 {
            color: #b1b1b1;
        }

        .label-edit {
            font-size: 20px;
        }

        .m-t-xs {
            margin-top: 4px;
        }

        .p-pict {
            width: 120px;
            height: 120px;
            margin: 20px auto;
            border-radius: 50%;
        }

        .b-b-1-lg {
            border-bottom: 1px solid rgba(99, 107, 111, 0.45);
        }

        .b-t-1-lg {
            border-top: 1px solid rgba(99, 107, 111, 0.45);
        }

        .info {
            padding-left: 0 !important;
        }

        .fs-17 {
            font-size: 17px;
        }

        .p-t-s {
            padding-top: 10px;
        }

        .m-t-sm {
            margin-top: 10px;
        }

        .no-space-break {
            white-space:nowrap;
            text-overflow:ellipsis;
            overflow: hidden;
        }

        .warning {
            color: red;
        }

        #more {
        }

        #_more {
            padding: 10px 15px;
            width: 150px;
            margin: 0 auto;
            border: 1px solid rgba(0, 0, 0, 0.34);
            cursor: pointer;
            font-weight: 600;
        }

        @media (min-width: 768px){
            .navbar>.container .navbar-brand, .navbar>.container-fluid .navbar-brand {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>