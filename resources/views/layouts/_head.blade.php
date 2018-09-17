
    <title>Tamma | Food</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset ('assets/images/icons/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset ('assets/images/icons/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset ('assets/images/icons/favicon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset ('assets/images/icons/favicon-114x114.png') }}">
    <!--Loading bootstrap css-->
{{--     <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> --}}
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/jquery-ui-1.10.4.custom.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/font-awesome.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/bootstrap.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/animate.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/all.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/main.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/style-responsive.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/zabuto_calendar.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/pace.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/jquery.news-ticker.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/bootstrap-datepicker.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/dataTables.bootstrap.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/jquery.dataTables.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/toastr/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/toastr/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/select2/select2-bootstrap.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/timepicker.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/css/ladda-themeless.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/awesome-bootstrap-checkbox.css') }}">
<link href="{{ asset('css/iziToast.css') }}" rel="stylesheet">
    <style type="text/css">

        .overlay {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.6);
            z-index: 2000;
        }

        .center{
            text-align: center
        }
        .right{
            text-align: right;
        }
        .disabled_select{
            pointer-events: none;
            background-color: #eee;
        }
    </style>
