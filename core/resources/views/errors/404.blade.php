@extends('layout.template')
@section('judul-halaman')
    <title>Halaman tidak ditemukan | PRD Online Course</title>
@endsection
@section('konten')

    <div class="section blue lighten-2 white-text">
        <div class="row container">
            <div class="col s12">
                <div class="center-align">
                    <h4 class="thin">Halaman tidak ditemukan</h4>
                    <div style="margin-top: 5em;">
                        <a class="waves-effect waves-light btn white black-text thin" href="{{url('/')}}">Kembali ke halaman utama</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="page-footer white">
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    <a href="{{url('/')}}"><img
                                src="{{url('/')}}/core/resources/assets/images/logoShortcutIcon.png"/></a>
                    <p class="blue-text thin">© 2017 PPTIK Institut Teknologi Bandung</p>
                </div>
            </div>
        </div>
    </footer>


@endsection
