@extends('layout.template')
@section('judul-halaman')
    <?php
    $user = Auth::user();

    $nama_depan = NULL;
    $nama_belakang = NULL;
    $username = NULL;
    $email = NULL;
    $nim = NULL;
    $universitas = NULL;
    $fakultas = NULL;

    foreach ($query_nama as $query_nama1) {
        $nama_depan = $query_nama1->nama_depan;
        $nama_belakang = $query_nama1->nama_belakang;
        $email = $query_nama1->email;
        $username = $query_nama1->username;
        $nim = $query_nama1->nim;
        $universitas = $query_nama1->universitas;
        $fakultas = $query_nama1->fakultas;
    }
    ?>
    <title><?php echo $nama_depan . ' ' . $nama_belakang;?> | PRD Online Course</title>

@endsection

@section('konten')
    <nav>
        <div class="nav-wrapper white">
            <a href="{{url('/')}}" class="navbar-brand blue-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
                        class="bold" style="font-size: 1.5em;">prd online course</span></a>
            <a href="#" data-activates="mobile-menu" class="button-collapse"><i
                        class="material-icons black-text">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="{{url('user')}}/<?php echo $user->username;?>/profil" class="blue-text thin">Profil</a></li>
                <li><a href="../logout" class="blue-text thin">Keluar</a></li>
            </ul>
            <ul id="mobile-menu" class="side-nav">
                <li><a href="{{url('user')}}/<?php echo $user->username;?>/profil" class="blue-text thin">Profil</a></li>
                <li><a href="../logout" class="blue-text thin">Keluar</a></li>
            </ul>
        </div>
    </nav>
    <br/>
    <br/>
    <br/>
    <div class="section blue lighten-2">
        <div class="container row" style="padding: 2em 0 1em 0">
            <div class="row center-align">
                <div class="col s12 m12">
                    <div class="card-panel white">
                        <img class="circle responsive-img"
                             src="http://localhost/prd/core/resources/assets/user_non_admin_assets/photos/default.jpg"
                             style="height: 8em;width:8em;">
                        <br/>
                        <h5 class="blue-text">
                            <?php echo $nama_depan . " " . $nama_belakang . "<br/><h6 class='blue-text'>" . $email . "</h6>";?>
                        </h5>
                        <?php
                        //Menampilkan daftar topik yang sudah dikerjakan bila ada
                        $query_topik_sudah_dikerjakan = DB::table('mahasiswa_mengambil_topik')
                                ->join('topik', 'topik.id_topik', '=', 'mahasiswa_mengambil_topik.id_topik')
                                ->where('id_pengguna', '=', Session::get('id_pengguna'))
                                ->get();
                        if(count($query_topik_sudah_dikerjakan != 0)){

                        ?>
                        <br/>
                        <span class="thin">
                        Telah mengerjakan topik
                        </span>
                        <hr/>
                        <div class="row col s2 m6 l12">

                            <?php
                            if(count($query_topik_sudah_dikerjakan) != 0){
                            foreach ($query_topik_sudah_dikerjakan as $query_topik_sudah_dikerjakan1) {
                            ?>
                            <div class="chip"><?php echo $query_topik_sudah_dikerjakan1->nama_topik;?></div>
                            <?php
                            }
                            }else {
                                echo "-";
                            }
                            ?>

                        </div>
                        <?php
                        }
                        ?>
                        <br/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 card">
                    <ul class="collection with-header white">
                        <li class="collection-item" style="margin: 0.5em;">
                            <span class="blue-text">Username</span>
                            <br/>
                                <span class="thin">
                                <?php echo $username;?>
                                </span>
                        </li>
                        <li class="collection-item" style="margin: 0.5em;">
                            <span class="blue-text">Nama Depan</span>
                            <br/>
                                <span class="thin">
                                <?php echo $nama_depan;?>
                                </span>
                        </li>
                        <li class="collection-item" style="margin: 0.5em;">
                            <span class="blue-text">Nama Belakang</span>
                            <br/>
                                <span class="thin">
                                <?php echo $nama_belakang;?>
                                </span>
                        </li>
                        <li class="collection-item" style="margin: 0.5em;">
                            <span class="blue-text">NIM</span>
                            <br/>
                                <span class="thin">
                                <?php echo $nim;?>
                                </span>
                        </li>
                        <li class="collection-item" style="margin: 0.5em;">
                            <span class="blue-text">Universitas</span>
                            <br/>
                                <span class="thin">
                                <?php echo $universitas;?>
                                </span>
                        </li>
                        <li class="collection-item" style="margin: 0.5em;">
                            <span class="blue-text">Fakultas</span>
                            <br/>
                                <span class="thin">
                                <?php echo $fakultas;?>
                                </span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <footer class="page-footer white">
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    <a href="http://localhost/prd/"><img
                                src="http://localhost/prd/core/resources/assets/images/logoShortcutIcon.png"/></a>
                    <p class="blue-text thin">© 2016 PPTIK Institut Teknologi Bandung</p>
                </div>
            </div>
        </div>
    </footer>


@endsection

@section('js')
    $(document).ready(function(){

    $('select').material_select();

    $('.modal-trigger').leanModal();

    $('a').smoothScroll({
    speed:1000
    });

    $('.tooltipped').tooltip({delay: 50});

    $(".button-collapse").sideNav({
    closeOnClick: true
    });

    });
@endsection
