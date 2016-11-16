@extends('layout.administrator.template')
@section('judul-halaman')
    <title>Dashboard | PRD Online Course</title>
@endsection
@section('konten')
    <div class="ui container">
        <div class="ui secondary pointing menu">
            <a class="item" href="{{url('/')}}">
                <h3>prd online course</h3>
            </a>

            <div class="right menu">
                <a class="active item" href="{{url('administrator/pengguna')}}">
                    Pengguna
                </a>
                <a class="item" href="{{url('administrator/materi')}}">
                    Materi
                </a>
                <a class="ui item" href="{{url('logout')}}">
                    Keluar
                </a>

            </div>
        </div>
        <div class="ui grid">
            <div class="four wide column">
                <div class="ui vertical pointing menu">
                    <a class="item" href="{{url('administrator/pengguna/mahasiswa')}}">
                        Mahasiswa
                    </a>
                    <a class="item" href="{{url('administrator/pengguna/dosen')}}">
                        Dosen
                    </a>
                    <a class="active item" href="{{url('administrator/pengguna/universitas')}}">
                        Universitas
                    </a>
                </div>
            </div>
            @section('css')
                .dataTables_filter input { margin-bottom: 10px;border-radius:6px; }
            @endsection
            <div class="twelve wide column">
                @if ( Session::has('message') )
                    <div class="ui ignored success message">
                        {{ Session::get('message') }}
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div class="ui ignored negative message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="ui grid">
                    <div class="four wide column">
                        <button class="ui primary button tambah">
                            <i class="add user icon"></i>
                            Tambah
                        </button>
                    </div>
                </div>
                <div id="tambah-universitas" class="ui small modal">

                    <div class="header">Tambah Universitas</div>


                    <div class="content">
                        <div class="ui form">
                            <form action="{{url('administrator/tambah/universitas')}}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                <div class="ui grid">
                                    <div class="seven wide column">
                                        <div class="field">
                                            <label>Email</label>
                                            <input type="text" name="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="ui grid">
                                    <div class="seven wide column">
                                        <div class="field">
                                            <label>Username</label>
                                            <input type="text" name="username">
                                        </div>
                                    </div>
                                </div>
                                <div class="ui grid">
                                    <div class="seven wide column">
                                        <div class="field">
                                            <label>Nama depan</label>
                                            <input type="text" name="nama_depan">
                                        </div>
                                    </div>
                                </div>
                                <div class="ui grid">
                                    <div class="seven wide column">
                                        <div class="field">
                                            <label>Nama belakang</label>
                                            <input type="text" name="nama_belakang">
                                        </div>
                                    </div>
                                </div>
                                <div class="ui grid">
                                    <div class="five wide column">
                                        <div class="ui action input">
                                            <input type="text" placeholder="Password"
                                                   id="field-generate-password-tambah" name="password" readonly>
                                            <button class="ui button" id="button-generate-password-tambah"
                                                    type="button">Generate
                                            </button>
                                        </div>
                                    </div>
                                </div>


                                <!--<div class="field">

                                </div>-->
                                <br/>
                                <br/>
                                <div class="field">
                                    <button type="submit" class="ui primary button">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!--<div class="actions">

                    </div>-->


                </div>
                <br/>
                <table class="ui celled table" id="pengguna-mahasiswa">
                    <thead>
                    <tr>
                        <th>No</th>
                        <!--<th>Id User</th>
                        <th>Username</th>-->
                        <th style="display: none;">Id User</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    foreach($universitas as $universitas){
                    ?>
                    <tr>
                        <td><?php echo $no;?></td>
                    <!--<td class="table-id-user"><?php echo $universitas->id_user;?></td>
                        <td class="table-username"><?php echo $universitas->username;?></td>-->
                        <td class="table-id-user" style="display: none;"><?php echo $universitas->id_user;?></td>
                        <td class="table-email"><?php echo $universitas->email;?></td>
                        <td>
                            <button class="circular ui icon button reset">
                                <i class="privacy icon"></i>
                            </button>
                        </td>
                    </tr>
                    <?php
                    $no++;
                    }
                    ?>
                    </tbody>
                </table>
                <div class="ui small modal" id="reset-password">

                    <div class="header">Reset Password</div>


                    <div class="content">
                        <div class="ui form">
                            <form action="{{url('administrator/reset_password')}}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                <div class="field" style="display: none;">
                                    <label>User id</label>
                                    <input type="text" id="reset-user-id" name="reset-user-id"/>
                                </div>

                                <div class="field">
                                    <label>Email</label>
                                    <span id="reset-email"></span>
                                    <input type="hidden" id="field-reset-email" name="field-reset-email">
                                </div>

                                <div class="field">
                                    <div class="ui action input">
                                        <input type="text" placeholder="Tekan tombol generate"
                                               id="field-generate-password-reset" name="password" readonly>
                                        <button class="ui button" id="button-generate-password-reset" type="button">
                                            Generate
                                        </button>
                                    </div>
                                </div>
                                <br/>
                                <div class="field">
                                    <button type="submit" class="ui primary button">Submit</button>
                                    <div class="ui red button">Batal</div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!--<div class="actions">

                    </div>-->


                </div>
            </div>
        </div>

    </div>
@endsection


@section('js')
    $(document).ready(function(){

    $('#button-generate-password-tambah').click(function(){
    $('#field-generate-password-tambah').val(Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 8));
    });

    $('#button-generate-password-reset').click(function(){
    $('#field-generate-password-reset').val(Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 8));
    });

    $('.tambah').click(function(){
    $('#tambah-universitas').modal('show');
    });


    $('.reset').click(function(){

    //alert($(this).parents("tr").find(".table-id-user").html());

    //atur nilai dialog reset password
    $('#reset-user-id').val($(this).parents("tr").find(".table-id-user").html());
    //$('#reset-username').val($(this).parents("tr").find(".table-username").html());
    $('#reset-email').html($(this).parents("tr").find(".table-email").html());
    $('#field-reset-email').val($(this).parents("tr").find(".table-email").html());

    $('#reset-password')
    .modal('show')
    ;
    });



    $('a').smoothScroll({
    speed:1000
    });

    $('#pengguna-mahasiswa').DataTable();

    });
@endsection
