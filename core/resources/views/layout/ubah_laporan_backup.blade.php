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

$resume = NULL;
foreach ($resume_topik as $resume_topik1) {
    $resume = $resume_topik1->resume;
}
?>
@section('judul-halaman')
    <title>Ubah Resume <?php echo $nama_topik;?> | PRD Online Course</title>
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
                <a href="../../../dashboard" class="breadcrumb">Daftar Topik</a>
                <a href="../../<?php echo str_replace(' ', '-', strtolower($nama_topik));?>"
                   class="breadcrumb">Pendahuluan</a>
                <a href="../../sub_topik/<?php echo str_replace(' ', '-', strtolower($nama_topik));?>"
                   class="breadcrumb">Sub
                    Topik</a>
                <a href="../<?php echo str_replace(' ', '-', strtolower($nama_topik));?>" class="breadcrumb">Resume</a>
                <a href="#" class="breadcrumb">Ubah Resume</a>
            </div>
        </div>
    </div>

    <div class="section white black-text">
        <div class="container row" style="padding: 8em 0 5em 0">
            <div class="center-align" style="margin:0 0 3em 0">
                <div class="col s12">
                    <ul class="tabs">
                        <li class="tab col s3 "><a class="active" href="#video">Video</a></li>
                        <li class="tab col s3"><a href="#resume">Resume</a></li>
                        <li class="tab col s3"><a href="#berkas">Berkas</a></li>
                    </ul>
                </div>
                <div id="video" class="col s12 center-align">
                    <br/>

                    Video yang diupload bertekstensi .mp4&nbsp;(maksimal ukuran 10 MB)

                    <form action="../../../resume/video" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <input type="hidden" name="id_topik" value="<?php echo $id_topik;?>"/>
                        <div class="file-field input-field">
                            <div class="btn <?php echo $class_warna;?>">
                                <span>Pilih berkas video</span>
                                <input type="file" name="video">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                        <div class="file-field input-field">
                            <button type="submit" class="waves-effect waves-light btn blue lighten-2">Kirim</button>
                        </div>
                    </form>
                </div>
                <div id="resume" class="col s12">
                    <form action="../../../resume/resume" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <input type="hidden" name="id_topik" value="<?php echo $id_topik;?>"/>
                    <textarea name="editor1" id="editor1" rows="10" cols="80"><?php echo $resume;?></textarea>
                        <div class="file-field input-field">
                            <button type="submit" class="waves-effect waves-light btn blue lighten-2">Kirim</button>
                        </div>
                    </form>
                </div>
                <div id="berkas" class="col s12">
                    <br/>
                    Berkas lampiran resume&nbsp;(maksimal ukuran 10 MB)
                    <form action="../../../resume/berkas" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <input type="hidden" name="id_topik" value="<?php echo $id_topik;?>"/>
                        <div class="file-field input-field">
                            <div class="btn <?php echo $class_warna;?>">
                                <span>Pilih berkas lampiran resume</span>
                                <input type="file" name="berkas">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                        <div class="file-field input-field">
                            <button type="submit" class="waves-effect waves-light btn blue lighten-2">Kirim</button>
                        </div>
                    </form>
                </div>
                </textarea>
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

    CKEDITOR.replace( 'editor1' );

    $('ul.tabs').tabs();

    });
@endsection
