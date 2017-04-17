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
                <a class="item" href="{{url('administrator/laporan')}}">
                    Laporan
                </a>
                <a class="ui item" href="{{url('logout')}}">
                    Keluar
                </a>

            </div>
        </div>
        <div class="ui grid">
            <div class="four wide column">
                <div class="ui vertical pointing menu">
                    <a class="active item" href="{{url('administrator/pengguna/mahasiswa')}}">
                        Mahasiswa
                    </a>
                    <a class="item" href="{{url('administrator/pengguna/dosen')}}">
                        Dosen
                    </a>
                    <a class="item" href="{{url('administrator/pengguna/universitas')}}">
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
                    foreach($mahasiswa as $mahasiswa){
                    ?>
                    <tr>
                        <td><?php echo $no;?></td>
                    <!--<td class="table-id-user"><?php echo $mahasiswa->id_user;?></td>
                        <td class="table-username"><?php echo $mahasiswa->username;?></td>-->
                        <td class="table-id-user" style="display: none;"><?php echo $mahasiswa->id_user;?></td>
                        <td class="table-email"><?php echo $mahasiswa->email;?></td>
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
                <div class="ui small modal">

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
                                               id="field-generate-password" name="password" readonly>
                                        <button class="ui button" id="button-generate-password" type="button">Generate
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

    $('#button-generate-password').click(function(){
    $('#field-generate-password').val(Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 8));
    });

    $('.reset').click(function(){

    //alert($(this).parents("tr").find(".table-id-user").html());

    //atur nilai dialog reset password
    $('#reset-user-id').val($(this).parents("tr").find(".table-id-user").html());
    //$('#reset-username').val($(this).parents("tr").find(".table-username").html());
    $('#reset-email').html($(this).parents("tr").find(".table-email").html());
    $('#field-reset-email').val($(this).parents("tr").find(".table-email").html());

    $('.ui.small.modal')
    .modal('show')
    ;
    });



    $('a').smoothScroll({
    speed:1000
    });

    $('#pengguna-mahasiswa').DataTable();

    });
@endsection
