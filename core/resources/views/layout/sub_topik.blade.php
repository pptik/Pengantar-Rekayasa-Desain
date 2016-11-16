@extends('layout.template')
<?php
//ambil nama depan & belakang
$user = Auth::user();

$username = NULL;
$query_nama = DB::table('users')
        ->select('*')
        ->where('id', '=', $user->id)
        ->get();

foreach ($query_nama as $query_nama1) {
    $username = $query_nama1->username;
}

$id_topik = NULL;
$nama_topik = NULL;
$deskripsi_topik = NULL;
$class_warna = NULL;
foreach ($topik as $topik1) {
    $id_topik = $topik1->id;
    $nama_topik = $topik1->nama_topik;
    $deskripsi_topik = $topik1->deskripsi_singkat;
    $class_warna = $topik1->class_warna;
}
?>
@section('judul-halaman')
    <title>Sub Topik <?php echo $nama_topik;?> | PRD Online Course</title>
@endsection
@section('konten')
    <nav>
        <div class="nav-wrapper white">
            <a href="{{url('/')}}" class="navbar-brand blue-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
                        class="bold" style="font-size: 1.5em;">prd online course</span></a>
            <a href="#" data-activates="mobile-menu" class="button-collapse"><i
                        class="material-icons black-text">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="{{url('bimbingan')}}" class="blue-text thin">Bimbingan</a></li>
                <li><a href="{{url('user')}}/<?php echo $username;?>/profil" class="blue-text thin">Profil</a></li>
                <li>
                    <!-- Dropdown Trigger -->
                    <a class='dropdown-button blue-text thin' href='#' data-activates='dropdown1'>
                        <?php echo $user->username;?>
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                    <!-- Dropdown Structure -->
                    <ul id='dropdown1' class='dropdown-content'>
                        <li><a href="{{url('logout')}}">Keluar</a></li>
                    </ul>
                </li>
            </ul>
            <ul id="mobile-menu" class="side-nav">
                <li><a href="{{url('bimbingan')}}" class="blue-text thin">Bimbingan</a></li>
                <li><a href="{{url('user')}}/<?php echo $username;?>/profil" class="blue-text thin">Profil</a></li>
                <li><a href="{{url('logout')}}" class="blue-text thin">Keluar</a></li>
            </ul>
        </div>
    </nav>

    <div class="section <?php echo $class_warna;?>">
        <div class="container row center-align" style="padding: 8em 0 5em 0">

            <h2 class="white-text"><?php echo $nama_topik;?></h2>
            <div class="col s12">
                <a href="../../dashboard" class="breadcrumb">Daftar Topik</a>
                <a href="../<?php echo str_replace(' ', '-', strtolower($nama_topik));?>"
                   class="breadcrumb">Pendahuluan</a>
                <a href="#" class="breadcrumb">Sub Topik</a>
            </div>
        </div>
    </div>

    <div class="section white black-text">
        <div class="container row" style="padding: 4em 0 4em 0">
            <div class="center-align" style="margin:0 0 3em 0">
                <h5>Sub Topik</h5>
                <p class="thin">Silahkan pelajari sub topik yang tersedia. Untuk melihat isi sub topik silahkan klik
                    judul sub topik nya.<br/>
                    Tekan tombol yang berada di pojok kanan untuk mengerjakan resumenya. Selamat belajar!</p>
            </div>
            <ul class="collapsible thin" data-collapsible="accordion">
                <?php
                //ambil sub_topik
                $query_sub_topik = DB::table('sub_topik')
                        ->select('*')
                        ->where('id_topik', '=', $id_topik)
                        ->get();

                foreach ($query_sub_topik as $query_sub_topik1) {
                ?>
                <li>
                    <div class="collapsible-header active"><h5
                                class="thin"><?php echo $query_sub_topik1->nama_sub_topik;?></h5></div>
                    <div class="collapsible-body">
                        <p>
                        <?php
                        if ($query_sub_topik1->tipe == 2) {
                            echo "<a class='waves-effect waves-light btn-large' href='".$query_sub_topik1->isi_sub_topik."' target='_blank'><i class='material-icons left'>file_download</i>Unduh</a>";
                        } else if ($query_sub_topik1->tipe == 1) {
                            echo $query_sub_topik1->isi_sub_topik;
                        }
                        ?>
                        </p>
                    </div>
                </li>
                <?php
                }
                ?>
                        <!--<li>
                    <div class="collapsible-header"><h5 class="thin">Pengantar</h5></div>
                    <div class="collapsible-body">
                        <p><img class="responsive-img" src="http://ichef.bbci.co.uk/news/624/cpsprodpb/8F50/production/_89888663_gettyimages-512251810.jpg"><br/>The BBC understands that Facebook's security systems prevented Mr Zuckerberg's Instagram account from being accessed. The photos-sharing service is owned by Facebook.The passwords were encoded, but in a form that appears to have been relatively easy to unravel.The account, on.The passwords were encoded, but in a form that appears to have been relatively easy to unravel.The account, on </p>
                    </div>
                </li>-->
            </ul>

        </div>
    </div>
    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a class="btn-floating btn-large <?php echo $class_warna;?>"
           href="../laporan/<?php echo str_replace(' ', '-', strtolower($nama_topik));?>">
            <i class="large material-icons">mode_edit</i>
        </a>
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

    $('.collapsible').collapsible({
    accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
    });

    });
@endsection
