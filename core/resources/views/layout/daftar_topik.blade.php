@extends('layout.template')
@section('judul-halaman')
    <title>Daftar topik | PRD Online Course</title>
@endsection
@section('konten')
    <nav>
        <div class="nav-wrapper white">
            <a href="{{url('/')}}" class="navbar-brand blue-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="bold" style="font-size: 1.5em;">prd online course</span></a>
            <a href="#" data-activates="mobile-menu" class="button-collapse"><i class="material-icons black-text">menu</i></a>

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

    <div class="section white">
        <div class="container row">
            <div class="center-align">
                <br/>
                <br/>
                <br/>
                <h5>Topik Perkuliahan</h5>
                <p class="thin">Topik yang terdaftar dibawah ini bisa diikuti dengan memilih <a href="login">masuk</a> apabila kamu sudah memiliki akun
                    <br/>atau <a href="register">daftar</a> apabila belum memiliki akun.</p>
                <br/>
                <br/>
            </div>
            <br/>
            <br/>
            <?php
                $counter = 1;
            foreach ($topik as $topik1) {
            ?>
            <div class="col s12 m6 l4">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="<?php echo $topik1->thumbnail;?>">
                    </div>
                    <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">

                        <div align="center" class="font-13">
                            <div class="chip">
                                <?php echo $counter;?>
                            </div>
                            <br/>
                            <?php echo $topik1->nama_topik;?>
                        </div>
                        </span>
                    </div>
                    <div class="card-reveal">
                        <div align="center">
                            <div class="chip">
                                <?php echo $counter;?>
                            </div>
                        </div>

                    <span class="card-title">
                        <i class="material-icons right">close</i></span>
                        <br/>
                        <br/>
                        <div align="center"><?php echo $topik1->nama_topik;?></div>
                        <br/>
                        <div class="thin"><?php echo $topik1->deskripsi_singkat;?></div>
                        </span>
                    </div>
                </div>

            </div>
            <?php
            $counter++;
            }
            ?>
        </div>
    </div>
    <footer class="page-footer white">
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    <a href="{{url('/')}}"><img src="{{url('/')}}/core/resources/assets/images/logoShortcutIcon.png"/></a>
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
