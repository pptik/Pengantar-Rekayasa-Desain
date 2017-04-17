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

$nama_topik = NULL;
$deskripsi_topik = NULL;
$class_warna = NULL;
$thumbnail = NULL;
$capaian = NULL;
$sumber_materi = NULL;
$id_topik = NULL;
$pendahuluan = NULL;
foreach ($topik as $topik1) {
    $nama_topik = $topik1->nama_topik;
    $deskripsi_topik = $topik1->deskripsi_singkat;
    $class_warna = $topik1->class_warna;
    $thumbnail = $topik1->thumbnail;
    $capaian = $topik1->capaian;
    $sumber_materi = $topik1->sumber_materi;
    $id_topik = $topik1->id;
    $pendahuluan = $topik1->pendahuluan;
}
?>
@section('judul-halaman')
    <title><?php echo $nama_topik;?> | PRD Online Course</title>
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
            <img class="activator" src="<?php echo $thumbnail;?>">
            <br/>
            <span class="white-text thin" style="font-size: 1.3em;"><?php echo $deskripsi_topik;?></span>
            <br/>
        <!--<br/>
            <a href="sub_topik/<?php echo str_replace(' ', '-', strtolower($nama_topik));?>" class="btn btn-default white black-text btn-large">Mulai</a>-->

        </div>
    </div>

    <!--<div class="section white">
        <div class="container row center-align" style="padding: 4em 0 4em 0">
            <h5>Pencapaian setelah mengikuti topik ini</h5>
            <br/>
            <p><?php echo $capaian;?></p>
        </div>
    </div>
    <div class="section white">
        <div class="container row center-align" style="padding: 0em 0 4em 0">
            <h5>Sumber Materi</h5>
            <br/>
            <p><?php echo $sumber_materi;?></p>
        </div>
    </div>-->
    <div class="section white">
        <div class="container row center-align" style="padding: 4em 0 4em 0">
            <h5>Pendahuluan</h5>
            <br/>
            <p>

                <?php
                //ambil sub_topik
                /*$query_sub_topik = DB::table('sub_topik')
                        ->select('*')
                        ->where('id_topik','=',$id_topik)
                        ->get();
                $counter = 1;
                foreach ($query_sub_topik as $query_sub_topik1) {

                    echo $counter.'. '.$query_sub_topik1->nama_sub_topik.'<br/>';
                $counter++;
                }*/
                ?>


            <div class="card-panel white thin">
                <div class="center-align video-container">
                    <iframe width="853" height="480"
                            src="<?php echo $pendahuluan;?>"
                            frameborder="0" allowfullscreen></iframe>
                </div>
                </span>
            </div>
            </p>
        </div>
    </div>

    <div class="container row center-align" style="padding: 0em 0 4em 0">
        <a href="sub_topik/<?php echo str_replace(' ', '-', strtolower($nama_topik));?>"
           class="btn btn-default <?php echo $class_warna;?> white-text btn-large">Mulai belajar</a>
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
