@extends('layout.template')
@section('clear-cache')


@endsection
@section('judul-halaman')
    <title>Masuk | PRD Online Course</title>
@endsection
@section('konten')
    <nav>
        <div class="nav-wrapper white">
            <a href="{{url('/')}}" class="navbar-brand blue-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="bold"
                                                                                                            style="font-size: 1.5em;">prd online course</span></a>
            <a href="#" data-activates="mobile-menu" class="button-collapse"><i
                        class="material-icons black-text">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="login" class="blue-text thin">Masuk</a></li>
                <li><a href="daftar_topik" class="blue-text thin">Topik</a></li>
                <li><a href="kegiatan" class="blue-text thin">Kegiatan</a></li>
            </ul>
            <ul id="mobile-menu" class="side-nav">
                <li><a href="login" class="blue-text thin">Masuk</a></li>
                <li><a href="daftar_topik" class="blue-text thin">Topik</a></li>
                <li><a href="kegiatan" class="blue-text thin">Kegiatan</a></li>
            </ul>
        </div>
    </nav>


    <div class="section blue lighten-2 black-text">
        <div class="container row">
            <br/>
            <br/>
            <br/>
            <br/>
            <h5 class="header white-text thin">Tuliskan email dan password untuk menuju akun mu</h5>
            <br/>
            <form class="col s12 white" method="post" action="login_process" style="border-radius: 0.5em;padding:3em;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    @if ( Session::has('gagal_login') )
                        <div class="chip red lighten-2 white-text thin">
                            Email atau password salah
                        </div>
                    @endif
                </div>
                @if (count($errors) > 0)
                    <div class="card container col m12 red white-text">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="input-field col s12 m6" l6>
                        <input id="first_name" type="email" name="email" class="validate">
                        <label for="first_name">Email</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                        <input id="last_name" type="password" name="password" class="validate">
                        <label for="last_name">Password</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l6">
                        <button type="submit" class="waves-effect waves-light btn yellow accent-4 thin">Kirim</button>
                    </div>
                    <br/>
                    <br/>
                    <br/>
                    <div class="col s12 black-text thin">
                        Lupa password? ajukan <a href="mailto:ilham@lskk.ee.itb.ac.id?subject=Pengajuan reset password akun PRDOC&body=Saya mengajukan pengajuan reset password akun PRD Online Course dengan username:[SILAHKAN ANDA ISI] dan email:[SILAHKAN ANDA ISI]" target="_blank">reset</a>
                    </div>
                    <br/>
                </div>
            </form>
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
@section('js')
    $(document).ready(function(){

    $(".dropdown-button").dropdown();

    $('a').smoothScroll({
    speed:1000
    });

    $(".button-collapse").sideNav({
    closeOnClick: true
    });

    });
@endsection
