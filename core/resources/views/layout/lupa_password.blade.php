@extends('layout.template')
@section('judul-halaman')
    <title>Lupa Password | PRD Online Course</title>
@endsection
@section('konten')
    <div class="section blue lighten-2 black-text">
        <div class="container row">
            <h5 class="header white-text thin">Tuliskan email untuk mereset password</h5>
            <br/>
            <form class="col s12 white" method="post" action="lupa_password_send" style="border-radius: 0.5em;padding:3em;">
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
                    <div class="input-field col s12 m12">
                        <input id="first_name" type="email" name="email" class="validate">
                        <label for="first_name">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l6">
                        <button type="submit" class="waves-effect waves-light btn yellow accent-4 thin">Kirim</button>
                    </div>
                    <br/>
                    <br/>
                    <br/>
                </div>
            </form>
        </div>
    </div>

    <footer class="page-footer white">
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    <a href="http://localhost/prd/"><img src="http://localhost/prd/core/resources/assets/images/logoShortcutIcon.png"/></a>
                    <p class="blue-text thin">© 2016 PPTIK Institut Teknologi Bandung</p>
                </div>
            </div>
        </div>
    </footer>
@endsection
@section('js')
    $(document).ready(function(){

    $('a').smoothScroll({
    speed:1000
    });

    $(".button-collapse").sideNav({
    closeOnClick: true
    });

    });
@endsection
