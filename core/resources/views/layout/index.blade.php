@extends('layout.template')
@section('judul-halaman')
    <title>Selamat datang di PRD Online Course</title>
@endsection
@section('konten')
    <nav>
        <div class="nav-wrapper white">
            <a href="{{url('/')}}" class="navbar-brand blue-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
                        class="bold" style="font-size: 1.5em;">prd online course</span></a>
            <a href="#" data-activates="mobile-menu" class="button-collapse"><i
                        class="material-icons black-text">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="login" class="blue-text thin">Masuk</a></li>
                <li><a href="daftar_topik" class="blue-text thin">Topik</a></li>
            </ul>
            <ul id="mobile-menu" class="side-nav">
                <li><a href="login" class="blue-text thin">Masuk</a></li>
                <li><a href="daftar_topik" class="blue-text thin">Topik</a></li>
            </ul>
        </div>
    </nav>

    <!-- Modal Login -->
    <div id="modalLogin" class="modal">
        <div class="modal-content">
            <h4>Login</h4>
            <div class="row">
                <form class="col s12">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="first_name" type="email" class="validate">
                            <label for="first_name">Email</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="last_name" type="password" class="validate">
                            <label for="last_name">Password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <button type="submit" class="btn btn-flat green white-text">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="section blue lighten-2">
        <div class="row col s12" style="padding:8em 0 2em 0;">

            <div class="col s12 m6 l5 offset-l1 container">
                <h4 class="white-text">Selamat datang</h4>
                <p class="white-text thin">Kini matakuliah PRD dapat dikerjakan dalam jaringan, ayo masuk untuk mulai
                    mengerjakan topik yang ada!</p>
                <br/>
                <br/>
                <div class="row white-text">
                    <div class="col s6 thin" align="center">
                        <i class="material-icons medium">supervisor_account</i>
                        <br/>
                        <?php echo count($siswa);?> siswa belajar disini
                    </div>
                    <div class="col s6 thin" align="center">
                        <i class="material-icons medium">view_list</i>
                        <br/>
                        <?php echo count($topik_all);?> topik tersedia
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l5">
                <form class="col s12 white" method="post" action="login_process"
                      style="border-radius: 0.5em;padding:3em;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="nama_depan" type="text" class="validate" name="email" autocomplete="off">
                            <label for="nama_depan">Email</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="nama_belakang" type="password" class="validate" name="password">
                            <label for="nama_belakang">Password</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 thin">
                            <button class="btn green waves-effect waves-light yellow accent-4" type="submit"
                                    name="action">Kirim
                            </button>
                            <br/>
                            <br/>
                            Lupa password? ajukan <a href="mailto:ilham@lskk.ee.itb.ac.id?subject=Pengajuan reset password akun PRDOC&body=Saya mengajukan pengajuan reset password akun PRD Online Course dengan username:[SILAHKAN ANDA ISI] dan email:[SILAHKAN ANDA ISI]" target="_blank">reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="section white">
        <div class="container row">
            <br/>
            <br/>
            <br/>
            <br/>
            <p class="black-text thin">Pengantar Rekayasa dan Desain atau disingkat PRD adalah salah satu mata kuliah
                wajib di <a href="https://www.itb.ac.id/" target="_blank" class="blue-text">Institut Teknologi
                    Bandung</a>. Dalam PRD online course
                ini terdiri dari beberapa topik yang harus dikerjakan
                .</p>
            <br/>
            <br/>
            <?php
                $counter = 1;
            foreach ($topik as $topik1) {
            ?>
            <div class="col s12 m6 l4">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator lazy" src="<?php echo $topik1->thumbnail;?>">
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
                        <div align="center"><?php echo $topik1->nama_topik;?></div>
                        <br/>
                        <div class="thin"><?php echo $topik1->deskripsi_singkat;?></div>
                        </span>
                    </div>
                </div>

            </div>
            <?php
            $counter++;
            }
            ?>

        </div>
        <div class="container row center">
            <a href="daftar_topik" class="blue-text thin" style="color: red;">Lihat topik selengkapnya
                &gt;&gt;</a>
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

    //$('.parallax').parallax();

    $('.dropdown-button').dropdown({
    inDuration: 300,
    outDuration: 225,
    constrain_width: false, // Does not change width of dropdown to that of the activator
    hover: true, // Activate on hover
    gutter: 0, // Spacing from edge
    belowOrigin: false, // Displays dropdown below the button
    alignment: 'left' // Displays dropdown with edge aligned to the left of button
    }
    );

    $('select').material_select();

    $('.modal-trigger').leanModal();

    $('a').smoothScroll({
    speed:1000
    });

    $(".button-collapse").sideNav({
    closeOnClick: true
    });

    $("img.lazy").lazyload({
    effect : "fadeIn"
    });


    $(".peringatan-username").css("display", "none");
    $(".peringatan-email").css("display", "none");

    $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });



    $("#username").keyup(function(){//awal keyup username

    $.ajax({
    url: 'validasi/username',
    type: 'post',
    data: {'username':$('#username').val(), '_token': $('input[name=_token]').val()},
    success: function(data){
    if(data == '1'){
    $(".peringatan-username").css("display", "");
    $("#btn-daftar").attr("disabled", true);

    }else{
    $(".peringatan-username").css("display", "none");
    if($(".peringatan-email").css("display") == "none" && $(".peringatan-username").css("display") == "none"){
    $("#btn-daftar").removeAttr("disabled");
    //alert('a');
    }

    }
    }});//akhir ajax



    });//akhir keyup username

    $("#email").keyup(function(){//awal keyup email

    $.ajax({
    url: 'validasi/email',
    type: 'post',
    data: {'email':$('#email').val(), '_token': $('input[name=_token]').val()},
    success: function(data){
    if(data == '1'){
    $(".peringatan-email").css("display", "");
    $("#btn-daftar").attr("disabled", true);
    }else{
    $(".peringatan-email").css("display", "none");
    if($(".peringatan-email").css("display") == "none" && $(".peringatan-username").css("display") == "none"){
    $("#btn-daftar").removeAttr("disabled");
    //alert('a');

    }
    }
    }});//akhir ajax


    });//akhir keyup email

    //validasi
    $("#form-registrasi").validate({
    rules: {
        // simple rule, converted to {required:true}
        username: "required",
        // compound rule
        email: {
        required: true,
        email: true
        },
        nama_depan : "required",
        nama_belakang : "required",
        password : "required",
        tulis_ulang_password : "required"
        }
    });
    //akhir validasi
    });//akhir fungsi jquery
@endsection
