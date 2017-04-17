@extends('layout.template')
@section('judul-halaman')
    <title>Dashboard | PRD Online Course</title>
@endsection
@section('konten')
    <?php
    //ambil nama depan & belakang
    $user = Auth::user();
    $username = NULL;
    $status_konfirmasi = NULL;
    $universitas = NULL;
    $url_kartu_pengenal = NULL;
    $peran = NULL;

    $query = DB::table('users')
            ->select('*')
            ->join('universitas', 'universitas.id', '=', 'users.universitas')
            ->where('users.id', '=', $user->id)
            ->get();

    foreach ($query as $query) {
        $username = $query->username;
        $status_konfirmasi = $query->status_konfirmasi;
        $universitas = $query->nama;
        $url_kartu_pengenal = $query->url_kartu_pengenal;
        $peran = $query->peran;
    }

    ?>
    <nav>
        <div class="nav-wrapper white">
            <a href="{{url('/')}}" class="navbar-brand blue-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
                        class="bold" style="font-size: 1.5em;">prd online course</span></a>
            <a href="#" data-activates="mobile-menu" class="button-collapse"><i
                        class="material-icons black-text">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
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
                <li><a href="{{url('user')}}/<?php echo $username;?>/profil" class="blue-text thin">Profil</a></li>
                <li><a href="{{url('logout')}}" class="blue-text thin">Keluar</a></li>
            </ul>
        </div>
    </nav>

    <br/>
    <br/>
    <br/>
    <div class="section white">
        <div class="row container">

            <div class="col s12">
                <div class="center-align">
                    <h5>Menu Universitas</h5>
                    <p class="thin">Silahkan manfaatkan menu di bawah ini
                        <br/>untuk mengatur civitas universitas anda di website PRD Online Course.</p>
                    <br/>
                    <br/>
                </div>

                <div class="col s12 m6 l4">
                    <div class="card">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="activator" src="{{url('/')}}//core/resources/assets/images/user.png">
                        </div>
                        <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">

                        <div align="center" class="font-13">
                            <?php echo "Pengguna";?>
                        </div>
                        </span>
                        </div>
                        <div class="card-reveal">


                    <span class="card-title">
                        <i class="material-icons right">close</i></span>
                            <br/>
                            <br/>
                            <div align="center" class="thin"><h6>Pengguna</h6>
                                <br/><br/><?php echo "Atur pengguna mahasiswa dan dosen di universitas anda.";?>
                            </div>


                            </span>

                            <!--<p class="valign-wrapper"><?php echo "deskripsi singkat";?></p>-->
                            <br/>
                            <br/>
                            <div class="col s12 center-align">
                                <a class="btn waves-effect waves-light red lighten-2 sweetalert-test" type="button"
                                   name="action" href="{{url('universitas/mahasiswa')}}">Atur
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

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

    $('select').material_select();

    $('.modal-trigger').leanModal({dismissible: true});

    $('a').smoothScroll({
    speed:1000
    });

    $('.tooltipped').tooltip({delay: 50});

    $(".button-collapse").sideNav({
    closeOnClick: true
    });

    });
@endsection
