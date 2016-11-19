@extends('layout.template')
@section('judul-halaman')
    <title>Bimbingan | PRD Online Course</title>
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
        $universitas = $query_universitas->nama_depan . ' ' . $query_universitas->nama_belakang;
    }

    //ambil untuk penanda topik yang dipilih
    $penanda = NULL;
    foreach ($topik_dipilih as $topik_dipilih) {
        $penanda = $topik_dipilih->id;
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
        <div class="row container-bimbingan">
            <div class="row">
                <div class="col s12">
                    <div class="center-align">

                        <h5>Bimbingan</h5>
                        <p class="thin">Apabila ada yang ingin anda tanyakan kepada dosen silahkan lakukan bimbingan
                            pada menu dibawah.
                            <br/>Bimbingan dibagi berdasarkan dengan nama topik yang berada pada tab.
                        </p>
                    </div>

                </div>
            </div>
            <br/>

            <div class="row" style="padding: 0 11em 0 11em;" class='thin'>
                <div class="col s3">
                    <div class="card horizontal">
                        <div class="card-stacked">
                            <div class="card-action grey">
                                <a href="#" class="white-text" style="text-transform: capitalize;">Materi</a>
                            </div>
                            <div class="card-content" style="padding: 0;">
                                <ul class="collection" style="padding: 0;margin: 0;">
                                    {{--<li class="collection-item" style="border-left: 3px solid #2196F3;">Pengantar</li>
                                    <li class="collection-item" style="margin-left: 3px;">Set Kegiatan I</li>
                                    <li class="collection-item" style="margin-left: 3px;">Set Kegiatan II</li>
                                    <li class="collection-item" style="margin-left: 3px;">Set Kegiatan III</li>--}}
                                    <?php
                                    $topik_id = NULL;
                                    foreach ($topik as $topik){
                                    if ($topik->id == $penanda){
                                    $topik_id = $topik->id;
                                    ?>
                                    <li class="collection-item"><a
                                                href="{{url('bimbingan/materi')}}/<?php echo $topik->id;?>"
                                                style="color: red;"><?php echo $topik->nama_topik;?></a>
                                    </li>
                                    <?php
                                    }else{
                                    ?>
                                    <li class="collection-item"><a
                                                href="{{url('bimbingan/materi')}}/<?php echo $topik->id;?>"
                                                style="margin-left: 3px;"><?php echo $topik->nama_topik;?></a>
                                    </li>
                                    <?php
                                    }
                                    }
                                    ?>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col s9">
                    <div class="card horizontal">
                        <div class="card-stacked">
                            <div class="card-action grey">
                                <a href="#" class="white-text" style="text-transform: capitalize;">Daftar Bimbingan</a>
                            </div>
                            <div class="card-content" style="padding: 0em;">
                                <div class="row">

                                    <div class="col s12">

                                        @if ( Session::has('message') )
                                            <br/>
                                            <div class="chip red lighten-2 white-text thin">
                                                {{ Session::get('message') }}
                                            </div>
                                        @endif

                                        <div style="padding: 1em;">
                                            <?php
                                            $counter = 1;
                                            foreach ($bimbingan_materi as $bimbingan) {
                                            ?>
                                            <a href="#modalDetailBimbingan<?php echo $counter;?>" class="modal-trigger">

                                                <?php echo $bimbingan->judul;?>
                                                <div class="chip">
                                                    <?php
                                                    echo date('d M Y h.i.s A', strtotime($bimbingan->created_at));
                                                    //echo $bimbingan->created_at;
                                                    ?>
                                                </div>
                                                <?php
                                                if ($bimbingan->penyelesaian != NULL){

                                                ?>
                                                <i class="material-icons" style="color: green;">done</i>
                                                <?php
                                                }else {
                                                    ?>
                                                    <i class="material-icons" style="color: red;">cancel</i>
                                                <?php
                                                }
                                                ?>
                                            </a>

                                            <!-- Modal Structure -->
                                            <div id="modalDetailBimbingan<?php echo $counter;?>"
                                                 class="modal modal-fixed-footer">
                                                <div class="modal-content">
                                                    <h4><?php echo $bimbingan->judul;?></h4>
                                                    <p>
                                                        Diajukan oleh:
                                                        <br/>
                                                        <small>
                                                            <?php
                                                            //ambil nama mahasiswa
                                                            $idUniversitas = NULL;
                                                            $namaMahasiswa = NULL;

                                                            $getMahasiswa = DB::table('mahasiswa')
                                                                    ->join('users', 'users.id', '=', 'mahasiswa.id_users')
                                                                    ->where('mahasiswa.id', '=', $bimbingan->mahasiswa)
                                                                    ->get();

                                                            foreach ($getMahasiswa as $mahasiswa) {
                                                                $idUniversitas = $mahasiswa->universitas;
                                                                $namaMahasiswa = $mahasiswa->nama_depan . $mahasiswa->nama_belakang;
                                                            }

                                                            //ambil universitas
                                                            $namaUniversitas = NULL;
                                                            $getUniversitas = DB::table('universitas')
                                                                    ->join('users', 'users.id', '=', 'universitas.id_users')
                                                                    ->where('universitas.id', '=', $idUniversitas)
                                                                    ->get();

                                                            foreach ($getUniversitas as $universitas) {
                                                                $namaUniversitas = $universitas->nama_depan . ' ' . $universitas->nama_belakang;
                                                            }
                                                            echo $namaMahasiswa . ' - ' . $namaUniversitas;
                                                            ?>
                                                        </small>
                                                    </p>
                                                    <br/>
                                                    <p>
                                                        Pertanyaan:
                                                        <br/>
                                                        <small><?php echo $bimbingan->permasalahan;?></small>
                                                    </p>
                                                    <br/>
                                                    <p>
                                                        Jawaban anda:
                                                        <br/>
                                                        <textarea name="penyelesaian" class="penyelesaian">

                                                            </textarea>
                                                    </p>
                                                    <br/>
                                                    <div class="row">
                                                        <button class="waves-effect waves-light btn">kirim</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <br/>
                                            <br/>
                                            <?php
                                            $counter++;
                                            }
                                            ?>
                                        </div>
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

    $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15 // Creates a dropdown of 15 years to control year
    });

    CKEDITOR.replaceAll();

    });
@endsection
