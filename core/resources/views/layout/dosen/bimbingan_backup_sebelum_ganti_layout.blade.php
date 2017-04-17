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
                        <p class="thin">Berikut daftar bimbingan yang dilakukan mahasiswa terhadap anda sebagai dosen
                            pengampu.
                            <br/>Bimbingan dibagi berdasarkan dengan nama topik yang berada pada tab.
                        </p>
                    </div>

                </div>
            </div>
            <br/>

            <div class="row">
                <br/>
                @if (count($errors) > 0)
                    <div class="card container col m12 red white-text">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <div id="modal1" class="modal">
                    <div class="modal-content">
                        <h5 class="center-align">Jawab</h5>
                        <p class="thin center-align">Silahkan menjawab pertanyaan atas bimbingan yang diajukan oleh mahasiswa.</p>
                        <form action="{{url('dosen/jawab_bimbingan')}}" method="post"
                              enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                            <div class="row">
                                Tanggal Bimbingan:
                            </div>
                            <div class="row">
                                Judul:
                            </div>
                            <div class="row">
                                Permasalahan:
                            </div>
                            <div class="row">
                                Berkas permasalahan:
                            </div>

                            <div class="file-field input-field row" align="right">
                                <button type="submit" class="btn waves-teal waves-effect col s2 offset-s10">Kirim
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="col s12">
                    <ul class="tabs" style="font-size: smaller;">
                        <?php
                        $tab_counter = 1;
                        foreach ($topik as $topik) {
                        ?>
                        <li class="tab col s3"><a
                                    href="#test<?php echo $tab_counter;?>"><?php echo $topik->nama_topik;?></a></li>
                        <?php
                        $tab_counter++;
                        }
                        ?>
                    </ul>
                </div>
                <?php
                $tab_counter2 = 1;
                foreach ($topik2 as $topik2) {
                ?>
                <div id="test<?php echo $tab_counter2;?>" class="col s12">
                    <br/>
                    <?php
                    $id_dosen = DB::table('dosen')
                            ->where('id_users', '=', $user->id)
                            ->get();

                    $id_dosen_val = NULL;
                    foreach ($id_dosen as $id_dosen) {
                        $id_dosen_val = $id_dosen->id;
                    }

                    $bimbingan_detail = DB::table('bimbingan')
                            ->where('dosen', '=', $id_dosen_val)
                            ->where('topik', '=', $tab_counter2)
                            ->orderBy('created_at', 'desc')
                            ->get();
                    ?>
                    <table class="highlight">
                        <thead>
                        <tr style="color: #58b0f5">
                            <th data-field="id" style="font-weight: lighter;">No</th>
                            <th data-field="id" style="font-weight: lighter;">Judul</th>
                            <th data-field="name" style="font-weight: lighter;">Tanggal Bimbingan</th>
                            <th data-field="price" style="font-weight: lighter;">Permasalahan</th>
                            <th data-field="price" style="font-weight: lighter;">Berkas Permasalahan</th>
                            {{--<th data-field="price" style="font-weight: lighter;">Status</th>--}}
                            <th data-field="price" style="font-weight: lighter;">Penyelesaian</th>
                            <th data-field="price" style="font-weight: lighter;">Berkas Penyelesaian</th>
                            <th data-field="price" style="font-weight: lighter;">Aksi</th>
                        </tr>
                        </thead>

                        <tbody style="font-weight: lighter;">
                        <?php
                        $no = 1;
                        foreach ($bimbingan_detail as $bimbingan_detail) {
                        ?>
                        <tr>
                            <td><?php echo $no;?></td>
                            <td><?php echo $bimbingan_detail->judul;?></td>
                            <td><?php echo $bimbingan_detail->tanggal;?></td>
                            <td><?php echo $bimbingan_detail->permasalahan;?></td>
                            <td>
                                <?php
                                if($bimbingan_detail->url_berkas_permasalahan != NULL){
                                ?>
                                <a class="waves-effect waves-light btn text-white"
                                   href="<?php echo $bimbingan_detail->url_berkas_permasalahan;?>" target="_blank">Unduh</a>
                                <?php
                                }else {
                                    echo "-";
                                }
                                ?>
                            </td>
                        {{--<td>
                            Tombol Jawab
                        </td>--}}
                        <!--<td>
                                <?php
                        if ($bimbingan_detail->status == 0) {
                            echo "<i class='material-icons tooltipped' data-position='top' data-delay='50' data-tooltip='Belum dilihat'>cancel</i>";
                        } else if ($bimbingan_detail->status == 1) {
                            echo "<i class='material-icons tooltipped' data-position='top' data-delay='50' data-tooltip='Sudah dilihat'>check_circle</i>";
                        }

                        ?>
                                </td>-->
                            <td><?php
                                if ($bimbingan_detail->penyelesaian != NULL) {
                                    $bimbingan_detail->penyelesaian;
                                } else {
                                    echo "-";
                                }
                                ?></td>
                            <td>
                                <?php
                                if($bimbingan_detail->url_berkas_penyelesaian != NULL){
                                ?>
                                <a class="waves-effect waves-light btn text-white"
                                   href="<?php echo $bimbingan_detail->url_berkas_penyelesaian;?>" target="_blank">Unduh</a>
                                <?php
                                }else {
                                    echo "-";
                                }
                                ?>


                            </td>
                            <td>
                                <!--<a class="waves-effect waves-light btn text-white"
                                   href="<?php echo $bimbingan_detail->url_berkas_penyelesaian;?>" target="_blank">Jawab</a>-->
                                <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Jawab</a>
                            </td>
                        </tr>
                        <?php
                        $no++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

                <?php
                $tab_counter2++;
                }
                ?>

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

    $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15 // Creates a dropdown of 15 years to control year
    });

    });
@endsection
