@extends('layout.template')
@section('judul-halaman')
    <title>Daftar | PRD Online Course</title>
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
                <li><a href="register" class="blue-text thin">Daftar</a></li>
                <li><a href="daftar_topik" class="blue-text thin">Topik</a></li>
            </ul>
            <ul id="mobile-menu" class="side-nav">
                <li><a href="login" class="blue-text thin">Masuk</a></li>
                <li><a href="register" class="blue-text thin">Daftar</a></li>
                <li><a href="daftar_topik" class="blue-text thin">Topik</a></li>
            </ul>
        </div>
    </nav>

    <div class="section blue lighten-2" id="formulirPendaftaran" style="padding-bottom:2em;">
        <div class="container">
            <div class="row">
                <br/>
                <br/>
                <br/>
                <div class="row">
                    <div class="input-field col s12">
                        <h5 class="white-text thin">Ayo segera daftarkan dirimu untuk mengikuti course yang
                            tersedia!</h5>
                    </div>
                </div>
                <br/>
                <form class="col s12 m12 white" method="post" action="{{url('/registration_process')}}"
                      style="border-radius: 0.5em;padding:3em;" id="form-registrasi">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

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
                        <div class="input-field col s6 m6 l6">
                            <select name="peran">
                                <option value="" disabled selected>Peran</option>
                                <option value="2">Dosen</option>
                                <option value="4">Mahasiswa</option>
                            </select>
                        </div>
                        <div class="input-field col s6 m6 l6">
                            <select name="universitas">
                                <option value="" disabled selected>Universitas asal</option>
                                <?php
                                foreach ($universitas as $universitas) {
                                ?>
                                <option value="<?php echo $universitas->id_universitas;?>"><?php echo $universitas->universitas_nama_depan . ' ' . $universitas->universitas_nama_belakang;?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s6 m6 l6">
                            <input id="username" type="text" class="validate" name="username" autocomplete="off">
                            <label for="username">Username</label>
                        </div>
                        <div class="input-field col s6 m6 l6">

                            <input id="email" type="email" class="validate" name="email" autocomplete="off">
                            <label for="email">Email</label>

                        </div>
                    </div>


                    <div class="row">
                        <div class="input-field col s6 m6 l6">
                            <input id="password" type="password" class="validate" name="password" autocomplete="off"
                                   placeholder="Minimal 8 karakter">
                            <label for="password">Password</label>
                        </div>
                        <div class="input-field col s6 m6 l6">
                            <input id="ulangiPassword" type="password" class="validate" name="password_confirmation">
                            <label for="ulangiPassword">Tulis ulang password</label>
                        </div>
                    </div>

                    <!--<div class="row">
                        <div class="input-field col s12 m12 l12">

                        </div>
                    </div>-->

                    <!--<div class="row">
                        <div class="input-field col s12 m12 l12">

                        </div>
                    </div>-->


                    <div class="row">
                        <div class="input-field col s12">
                            <button class="btn green waves-effect waves-light yellow accent-4 thin" type="submit"
                                    name="action" id="btn-daftar">Daftar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <footer class="page-footer white">
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    <a href="{{url('/')}}"><img
                                src="{{url('/')}}/core/resources/assets/images/logoShortcutIcon.png"/></a>
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

    $('select').material_select();

    });
@endsection
