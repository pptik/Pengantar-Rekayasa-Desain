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
    <title>Resume <?php echo $nama_topik;?> | PRD Online Course</title>
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
                <a href="../sub_topik/<?php echo str_replace(' ', '-', strtolower($nama_topik));?>" class="breadcrumb">Sub
                    Topik</a>
                <a href="#" class="breadcrumb">Resume</a>
            </div>
        </div>
    </div>

    <div class="section white black-text">
        <div class="container row" style="padding: 8em 0 5em 0">
            <div class="center-align" style="margin:0 0 3em 0">
                <h5>Resume</h5>
                <p class="thin">Hasil resume dari pembelajaran topik <b><?php echo $nama_topik;?></b> yang kamu
                    ikuti, ditampilkan pada panel di bawah ini.<br/>
                    Resume berupa video yang mengikuti aturan youtube. Selamat mengerjakan!</p>
                <br/>

                <!-- cek status display label button dan kalau udah ada di tampung ke variabel untuk ditampilkan-->
                <?php
                $resume = NULL;
                $berkas_file = NULL;
                $berkas_video = NULL;

                $status_pengerjaan = DB::table('resume_topik')
                        ->where('id_topik', '=', $id_topik)
                        ->where('id_pengguna', '=', Session::get('id_pengguna'))
                        ->get();

                if(count($status_pengerjaan) == 0){
                ?>
                <a href="../laporan/ubah/<?php echo str_replace(' ', '-', strtolower($nama_topik));?>"
                   class="waves-effect waves-light btn btn-large <?php echo $class_warna;?>">Cantumkan link</a>
                <?php
                }else {
                foreach ($status_pengerjaan as $status_pengerjaan1) {

                }
                $resume = $status_pengerjaan1->resume;
                $berkas_file = $status_pengerjaan1->berkas_file;
                $berkas_video = $status_pengerjaan1->berkas_video;
                ?>
                <a href="../laporan/ubah/<?php echo str_replace(' ', '-', strtolower($nama_topik));?>"
                   class="waves-effect waves-light btn btn-large <?php echo $class_warna;?>" target="_blank">Perbaharui link</a>
                <?php
                }
                ?>
                        <!-- akhir cek status display label button-->

            </div>
            <div class="row">
                <div class="col s12">
                    <div class="card-panel white thin">
                        @if ( Session::has('berhasil_upload_video') )
                            <div class="chip red lighten-2 white-text thin">
                                Video berhasil diperbaharui
                            </div>
                            <br/>
                            <br/>
                        @endif
                        @if ( Session::has('berhasil_upload_berkas') )
                            <div class="chip red lighten-2 white-text thin">
                                Berkas berhasil diperbaharui
                            </div>
                            <br/>
                            <br/>
                        @endif
                        @if ( Session::has('berhasil_resume') )
                            <div class="chip red lighten-2 white-text thin">
                                Resume berhasil diperbaharui
                            </div>
                            <br/>
                            <br/>
                        @endif
                        <?php
                        if($berkas_video != NULL){
                        ?>
                        <div class="center-align video-container">
                            <iframe width="853" height="480"
                                    src="http://localhost/prd/core/resources/assets/user_non_admin_assets/videos/<?php echo $berkas_video;?>"
                                    frameborder="0" allowfullscreen></iframe>
                        </div>
                        <?php
                        }else {
                        ?>
                        <b>Resume video belum di upload</b>
                        <?php
                        }
                        ?>
                        <hr/>
                        <?php
                        if($resume != NULL){
                            echo $resume;
                        }else{
                        ?>
                        <b>Resume belum dibuat</b>
                        <?php
                        }
                        ?>
                        <hr/>
                        <?php
                        if($berkas_file != NULL){
                            echo "<a href='http://localhost/prd/core/resources/assets/user_non_admin_assets/files/" . $berkas_file . "' target='_blank' class='valign-wrapper'><i class='material-icons'>file_download</i> Unduh berkas</a>";
                        }else{
                        ?>
                        <b>Tidak ada berkas resume</b>
                        <?php
                        }
                        ?>
                        </span>
                    </div>
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

    $('.collapsible').collapsible({
    accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
    });

    });
@endsection
