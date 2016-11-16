<!DOCTYPE html>
@yield('clear-cache')
<?php echo
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html');?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/')}}/core/resources/assets/materialize/css/materialize.min.css">
    <link rel="stylesheet" href="{{url('/')}}/core/resources/assets/css/sweetalert.css">
    <link rel="stylesheet" href="{{url('/')}}/core/resources/assets/css/jquery.dataTables.min.css">
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="{{url('/')}}/core/resources/assets/images/shortcut-icon.png">
    @yield('judul-halaman')
    <style>
        html{
            font-family: Lato;
        }
        nav{
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
        }
        .font-13{
          font-size: 14px;
        }
        .container{
            padding: 3em;
            border-radius: 0.5em;
        }
        .container-bimbingan{
            padding: 1em;
            border-radius: 0.5em;
        }
        .thin {
            font-weight: lighter;
        }
        @yield('css')
    </style>
</head>
<body>
@yield('konten')

<script src="{{url('/')}}/core/resources/assets/js/jquery.min.js"></script>
<script src="{{url('/')}}/core/resources/assets/js/materialize.min.js"></script>
<script src="{{url('/')}}/core/resources/assets/js/jquery.smooth-scroll.js"></script>
<script src="{{url('/')}}/core/resources/assets/js/sweetalert.min.js"></script>
<script src="{{url('/')}}/core/resources/assets/ckeditor/ckeditor.js"></script>
<script src="{{url('/')}}/core/resources/assets/js/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/core/resources/assets/js/jquery.lazyload.min.js"></script>
<script src="{{url('/')}}/core/resources/assets/bower_components/jquery-validation/dist/jquery.validate.min.js"></script>
<script>
    @yield('js')
</script>
</body>
</html>
