@extends('layout.template')
@section('judul-halaman')
    <title>Kegiatan | PRD Online Course</title>
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

    <div class="section white">
        <div class="container row">
            <div class="center-align">
                <br/>
                <br/>
                <br/>
                <h5>Kegiatan</h5>
                <p class="thin">Berikut hasil kegiatan berupa resume yang sudah dibuat oleh mahasiswa setelah mengikuti
                    materi yang ada.</p>
            </div>
            <br/>
            <br/>
            <?php
            $counter = 1;
            foreach ($resume as $resume) {
            ?>
            <div class="col s12 m6 l4">
                <div class="card">
                    <div class="card-content">
                        <div class="center-align video-container">
                            <iframe width="853" height="480"
                                    src="<?php echo $resume->berkas_video;?>"
                                    frameborder="0" allowfullscreen></iframe>
                        </div>
                        <br/>
                        <small>
                            <div class="row">
                                <i class="tiny material-icons left">info_outline</i>
                                <?php echo $resume->nama_topik;?>
                            </div>
                            <div class="row">
                            <i class="tiny material-icons left">perm_identity</i>
                            <?php echo $resume->nama_depan . ' ' . $resume->nama_belakang;?>
                            </div>
                            <?php
                            $getUniversitas = DB::table('users')
                                    ->join('universitas', 'universitas.id_users', '=', 'users.id')
                                    ->where('universitas.id', '=', $resume->universitas)
                                    ->get();
                            foreach ($getUniversitas as $universitas) {
                                ?>
                            <div class="row">
                                <i class="tiny material-icons left">school</i>
                                <?php echo $universitas->nama_depan . ' ' . $universitas->nama_belakang;?>
                            </div>

                            <?php
                            }
                            ?>
                        </small>
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

    });
@endsection
