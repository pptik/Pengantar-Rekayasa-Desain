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
                    <h5>Pengguna</h5>
                    <p class="thin">Berikut pengguna yang sudah mendaftar ke PRD Online Course.</p>
                    <br/>
                    <br/>
                </div>

                <div class="row">
                    <div class="col s12">
                        <ul class="tabs">
                            <li class="tab col s3"><a href='{{url('universitas/mahasiswa')}}'
                                                      target="_self">Mahasiswa</a></li>
                            <li class="tab col s3"><a class="active">Dosen</a></li>
                        </ul>
                    </div>
                    <div id="test1" class="col s12 ">

                    </div>
                    <div id="test2" class="col s12">
                        <br/>
                        @if ( Session::has('berhasil') )
                            <div class="chip">
                                {{Session::get('berhasil')}}
                                <i class="close material-icons">close</i>
                            </div>
                        @endif
                        <table class="highlight" id="table_id">
                            <thead>
                            <tr class="danger">
                                <th>No</th>
                                <th>Nama</th>
                                <th>KTP</th>
                                <th>Status konfirmasi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 1;
                            foreach ($dosen as $dosen) {


                            ?>
                            <tr class="danger">
                                <td><?php echo $no;?></td>
                                <td><?php echo $dosen->username;?></td>
                                <td>
                                    <?php
                                    if ($dosen->url_kartu_pengenal != NULL) {
                                        echo "<a href='" . $dosen->url_kartu_pengenal . "' target='_blank'>Lihat</a>";
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    switch ($dosen->status_konfirmasi) {
                                    case 0;
                                    //echo "<a class='waves-effect waves-light btn' href='".{{url('konfirmasi/".$mahasiswa->id_user."')}}."'>konfirmasi sekarang</a>";
                                    ?>
                                    <a class='waves-effect waves-light btn' href='{{url("konfirmasi/dosen")}}/<?php echo $dosen->id_user;?>'>konfirmasi sekarang</a>
                                    <?php
                                    break;
                                    case 1;
                                        echo "sudah dikonfirmasi";
                                        break;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $no++;
                            }
                            ?>
                            </tbody>
                        </table>
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
                    <p class="blue-text thin">© 2016 PPTIK Institut Teknologi Bandung</p>
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

    $('ul.tabs a').on('click', function(e){
    if($(this).attr("target") ) {
    window.location = $(this).attr("href");
    }
    });

    $('#table_id').DataTable({
    "pageLength": 10
    });

    });
@endsection
