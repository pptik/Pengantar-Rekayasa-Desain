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
    <link rel="stylesheet" href="{{url('/')}}/core/resources/assets/semantic/dist/semantic.css">

    <link rel="stylesheet" href="{{url('/')}}/core/resources/assets/css/jquery.dataTables.min.css">
    <link rel="shortcut icon" href="{{url('/')}}/core/resources/assets/images/shortcut-icon.png">
    @yield('judul-halaman')
    <style>
        #footer{
            margin-top: 3em;
        }
        @yield('css')
    </style>
    <script src="{{url('/')}}/core/resources/assets/ckeditor/ckeditor.js"></script>
</head>
<body>
@yield('konten')
<div class="ui container center aligned" id="footer">
    <img src="{{url('/')}}/core/resources/assets/images/logoShortcutIcon.png">
</div>
<div class="ui container center aligned">© 2017 PPTIK Institut Teknologi Bandung</div>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="{{url('/')}}/core/resources/assets/semantic/dist/semantic.js"></script>
<script src="{{url('/')}}/core/resources/assets/js/jquery.smooth-scroll.js"></script>
<script src="{{url('/')}}/core/resources/assets/js/sweetalert.min.js"></script>

<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script src="{{url('/')}}/core/resources/assets/js/buttons.semanticui.js"></script>
<script>

    @yield('js')
</script>
</body>
</html>
