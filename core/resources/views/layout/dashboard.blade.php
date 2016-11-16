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
        $url_kartu_pengenal = $query->url_kartu_pengenal;
        $peran = $query->peran;
    }

    $query_universitas = DB::table('universitas')
            ->join('users', 'users.id', '=', 'universitas.id_users')
            ->where('universitas.id', '=', $user->universitas)
            ->get();

    foreach ($query_universitas as $query_universitas) {
     $universitas = $query_universitas->nama_depan.' '.$query_universitas->nama_belakang;
    }

    //ambil id topik terakhir yang diambil user
    $topik_terakhir = NULL;

    if (count($topik_terakhir_yang_diambil) == 0) {
        $topik_terakhir = 0;
    }else if(count($topik_terakhir_yang_diambil) > 0){
        foreach ($topik_terakhir_yang_diambil as $topik_terakhir_yang_diambil_1) {
            $topik_terakhir = $topik_terakhir_yang_diambil_1->id_topik;
        }
    }
    //echo "Topik terakhir yang diambil ".$topik_terakhir;
    /*if (count($topik_terakhir_yang_diambil) == 0) {
        $topik_terakhir = 0;
    } else {
        foreach ($topik_terakhir_yang_diambil as $topik_terakhir_yang_diambil1) {

            $topik_terakhir = $topik_terakhir_yang_diambil1->id_topik;

        }
    }*/


    //ambil nama topik terakhir yang harus dikerjakan
    $nama_topik_terakhir = NULL;
    $id_topik_terakhir = NULL;
    if($topik_terakhir == 0){
        $ambil_topik_terakhir_di_tabel = DB::table('topik')->orderBy('id','asc')->take(1)->get();


        foreach ($ambil_topik_terakhir_di_tabel as $ambil_topik_terakhir_di_tabel_1) {
            $id_topik_terakhir = $ambil_topik_terakhir_di_tabel_1->id;
        }
    }else if($topik_terakhir != 0){
        $id_topik_terakhir = $topik_terakhir+1;
    }
    $query_nama_topik_terakhir = DB::table('topik')
            ->select('nama_topik')
            ->where('id', '=', $id_topik_terakhir)
            ->get();

    foreach ($query_nama_topik_terakhir as $query_nama_topik_terakhir1) {
        $nama_topik_terakhir = $query_nama_topik_terakhir1->nama_topik;
    }
    ?>
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
                        <li></li>
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

    <br/>
    <br/>
    <br/>
    <div class="section white">
        <div class="row container">
            <?php

            if($status_konfirmasi == 1){
            ?>
            <div class="col s12">
                <div class="center-align">
                    <h5>Topik Perkuliahan</h5>
                    <p class="thin">Silahkan ikuti topik perkuliahan secara terurut berdasarkan penomoran yang tersedia
                        dan kerjakan resume
                        <br/>pada setiap topik. <b>Klik thumbnail topik</b> untuk memulai. Selamat mengerjakan!</p>
                    <br/>
                    <br/>
                </div>
                <?php
                //ambil data topik
                    $counter = 1;
                foreach ($topik as $topik1) {
                ?>
                <div class="col s12 m6 l4">
                    <div class="card">
                        <div class="card-image waves-effect waves-block waves-light">
                            <!--<img class="activator"
                                 src="{{url('/')}}/core/resources/assets/images/<?php echo $topik1->thumbnail;?>">-->
                                <img class="activator"
                                     src="<?php echo $topik1->thumbnail;?>">
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
                            <div align="center" class="thin"><b>Judul
                                    topik:</b><br/><br/><?php echo $topik1->nama_topik;?>
                            </div>


                            </span>

                            <!--<p class="valign-wrapper"><?php echo $topik1->deskripsi_singkat;?></p>-->
                            <br/>
                            <br/>
                            <div class="col s12 center-align">
                                <?php
                                //Cara cek nya topik id this di kurangi - 1 hasilnya <= topik_terakhir
                                //echo "Topik terakhir yang diambil ".$topik_terakhir;
                                $topik_terakhir_di_tabelf = NULL;
                                if($topik_terakhir == 0){
                                    $topik_terakhir_di_tabel = DB::table('topik')->orderBy('id','asc')->take(1)->get();


                                    foreach ($topik_terakhir_di_tabel as $topik_terakhir_di_tabel_1) {
                                        $topik_terakhir_di_tabelf = $topik_terakhir_di_tabel_1->id;
                                    }
                                }else if($topik_terakhir != 0){
                                    $topik_terakhir_di_tabelf = $topik_terakhir+1;
                                }

                                //echo "pengkondisian ".($topik1->id-$topik_terakhir_di_tabelf);

                                if (($topik1->id-$topik_terakhir_di_tabelf) <= 0) {
                                ?>
                                <a class="btn waves-effect waves-light red lighten-2" type="button"
                                   name="action"
                                   href="topik/<?php echo str_replace(' ', '-', strtolower($topik1->nama_topik));?>">Mulai
                                </a>
                                <?php
                                }else {
                                ?>
                                <a class="btn waves-effect waves-light red lighten-2 sweetalert-test" type="button"
                                   name="action">Mulai
                                </a>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
                <?php
                $counter++;
                }
                ?>
            </div>
            <?php
            }else {
            ?>
            <div class="col s12">
                <div class="center-align">
                    @if (count($errors) > 0)
                        <div class="row">
                            <div class="card col m12 red white-text" style="margin:1em;">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <h5>Konfirmasi</h5>
                    <?php
                    if($url_kartu_pengenal == NULL){
                    if($peran == 4){
                    ?>
                    <p class="thin">Anda belum dianggap mahasiswa <?php echo $universitas;?>.<br/> Silahkan
                        unggah foto atau scan KTM untuk melakukan konfirmasi.
                        <br/>
                        <br/>
                        <!-- Modal Trigger -->
                        <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Pilih berkas</a>

                        <!-- Modal Structure -->
                        <div id="modal1" class="modal">
                            <div class="modal-content">
                                <h5>Pilih Berkas</h5>
                    <p class="thin">Silahkan pilih berkas foto/scan KTM anda.<br/>Maksimal ukuran berkas <span
                                class="red-text">500 KB</span>.</p>
                    <form action="{{url('ktm')}}" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <div class="file-field input-field">
                            <div class="btn btn-sm">
                                <span>File</span>
                                <input type="file" name="ktm">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                        <div class="file-field input-field row" align="right">
                            <button type="submit" class="btn waves-teal waves-effect col s2 offset-s10">Kirim</button>
                        </div>

                    </form>
                </div>
            </div>
            <?php
            }else if ($peran == 2) {
            ?>
            <p class="thin">Anda belum dianggap dosen <?php echo $universitas;?>.<br/> Silahkan
                unggah foto atau scan KTP(Kartu Tanda Pengajar) untuk melakukan konfirmasi.
                <br/>
                <br/>
                <!-- Modal Trigger -->
                <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Pilih berkas</a>

                <!-- Modal Structure -->
                <div id="modal1" class="modal">
                    <div class="modal-content">
                        <h5>Pilih Berkas</h5>
            <p class="thin">Silahkan pilih berkas foto/scan KTP(Kartu Tanda Pengajar) anda.<br/>Maksimal ukuran
                berkas <span
                        class="red-text">500 KB</span>.</p>
            <form action="{{url('ktm')}}" enctype="multipart/form-data" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="file-field input-field">
                    <div class="btn btn-sm">
                        <span>File</span>
                        <input type="file" name="ktm">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
                <div class="file-field input-field row" align="right">
                    <button type="submit" class="btn waves-teal waves-effect col s2 offset-s10">Kirim</button>
                </div>

            </form>
        </div>
    </div>
    <?php
    }
    }else {
    if ($peran == 2) {
    ?>
    <p class="thin">Sedang dalam pemeriksaan bahwa anda dosen <?php echo $universitas;?>.
    <?php
    }else if ($peran == 4) {
    ?>
    <p class="thin">Sedang dalam pemeriksaan bahwa anda mahasiswa <?php echo $universitas;?>.</p>
    <?php
    }
    }
    }
    ?>
    </div>

    </div>
    <br/>
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

    $('.sweetalert-test').click(function(){
    sweetAlert({
    title: "<span class='thin'>Maaf</span>",
    text: "<span class='thin'>Anda harus mulai topik <b><?php echo $nama_topik_terakhir;?></b> terlebih dahulu.</span>",
    type: "error",
    html: true
    });
    //sweetAlert("Maaf", "Anda harus mengerjakan topik Kompetisi produk mata kuliah Pengantar Rekayasa Desain terlebih dahulu untuk mengerjakan topik ini", "error");
    });

    $(".button-collapse").sideNav({
    closeOnClick: true
    });

    });
@endsection
