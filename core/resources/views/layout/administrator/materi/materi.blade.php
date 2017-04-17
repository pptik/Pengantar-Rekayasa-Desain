@extends('layout.administrator.template')
@section('judul-halaman')
    <title>Materi | PRD Online Course</title>
@endsection
@section('konten')
    <div class="ui container">
        <div class="ui secondary pointing menu">
            <a class="item" href="{{url('/')}}">
                <h3>prd online course</h3>
            </a>

            <div class="right menu">
                <a class="item" href="{{url('administrator/pengguna')}}">
                    Pengguna
                </a>
                <a class="active item" href="{{url('administrator/materi')}}">
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
                    <a class="active item" href="{{url('administrator/materi/materi')}}">
                        Materi
                    </a>
                    <a class="item" href="{{url('administrator/sub_materi')}}">
                        Sub Materi
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
                            <i class="add icon"></i>
                            Tambah
                        </button>
                    </div>
                </div>
                <br/>
                <table class="ui celled table" id="materi">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th style="display: none">Id Materi</th>
                        <th>Thumbnail</th>
                        <th>Judul</th>
                        <!--<th>Deskripsi Singkat</th>-->
                        <th>Pendahuluan</th>
                        <th>Warna</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    foreach($materi as $materi){
                    ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td class="table-id-materi" style="display: none"><?php echo $materi->id;?></td>
                        <td>
                            <img class="ui small image" src="<?php echo $materi->thumbnail;?>">
                        </td>
                        <td class="table-nama"><?php echo $materi->nama_topik;?></td>
                    <!--<td><?php echo $materi->deskripsi_singkat;?></td>-->
                        <td class="table-pendahuluan">
                            <?php
                            if ($materi->pendahuluan != NULL) {
                            ?>
                            <div class="card-panel white thin">
                                <div class="center-align video-container">
                                    <iframe width="200" height="150"
                                            src="<?php echo $materi->pendahuluan;?>"
                                            frameborder="0" allowfullscreen></iframe>
                                </div>
                                </span>
                            </div>
                            <?php
                            } else {
                                echo "Belum ada video pendahuluan";
                            }
                            ?>
                        </td>
                        <td class="table-warna">
                            <?php echo $materi->class_warna;?>
                        </td>
                        <td>
                            <div class="ui relaxed grid">
                                <div class="eight column wide">
                                    <button class="circular ui icon button ubah">
                                        <i class="edit icon"></i>
                                    </button>
                                </div>

                            </div>
                        </td>
                    </tr>
                    <?php
                    $no++;
                    }
                    ?>
                    </tbody>
                </table>
                <div class="ui small modal" id="tambah-modal">

                    <div class="header">Tambah Materi</div>


                    <div class="content">
                        <div class="ui form">
                            <form action="{{url('administrator/tambah_materi')}}" method="post"
                                  enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                                <div class="field">
                                    <label>Judul</label>
                                    <input type="text" name="judul">
                                </div>

                                <!--<div class="field">
                                    <label>Deskripsi singkat</label>
                                    <textarea rows="2" name="deskripsi"></textarea>
                                </div>-->

                                <div class="field">
                                    <label>Pendahuluan</label>
                                    <input type="text" name="pendahuluan"
                                           placeholder="Link embed video youtube, contoh: https://www.youtube.com/embed/GUHhS2OdIEs">
                                </div>
                                <div class="field">
                                    <label>Warna</label>
                                    <input type="text" name="warna"
                                           placeholder="Pilih class warna di http://materializecss.com/color.html">
                                </div>
                                <div class="field">
                                    <label>Gambar kecil</label>
                                    <input type="file" name="thumbnail">
                                </div>

                                <div class="field">
                                    <button type="submit" class="ui primary button">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!--<div class="actions">

                    </div>-->


                </div>
                <div class="ui small modal" id="ubah-modal">

                    <div class="header">Ubah Materi</div>


                    <div class="content">
                        <div class="ui form">
                            <form action="{{url('administrator/ubah_materi')}}" method="post"
                                  enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                                <div class="field" style="display: none;">
                                    <label>Id materi</label>
                                    <input type="text" name="id" id="field-id">
                                </div>

                                <div class="field">
                                    <label>Judul</label>
                                    <input type="text" name="judul" id="field-judul">
                                </div>

                                <!--<div class="field">
                                    <label>Deskripsi singkat</label>
                                    <textarea rows="2" name="deskripsi"></textarea>
                                </div>-->

                                <div class="field">
                                    <label>Pendahuluan</label>
                                    <input type="text" name="pendahuluan"
                                           placeholder="Link embed video youtube, contoh: //www.youtube.com/embed/Q8TXgCzxEnw?rel=0"
                                           id="field-pendahuluan">
                                </div>
                                <div class="field">
                                    <label>Warna</label>
                                    <input type="text" name="warna"
                                           placeholder="Pilih class warna di http://materializecss.com/color.html" id="field-warna">
                                </div>
                                <div class="field">
                                    <label>Gambar kecil</label>
                                    <input type="file" name="thumbnail">
                                </div>

                                <div class="field">
                                    <button type="submit" class="ui primary button">Submit</button>
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


    $('.tambah').click(function(){

    $('#tambah-modal')
    .modal('show')
    ;

    });

    $('.ubah').click(function(){
    //Atur nilai beberapa field dengan nilai yang ada di tabel
    $('#field-id').val($(this).parents("tr").find(".table-id-materi").html());
    $('#field-judul').val($(this).parents("tr").find(".table-nama").html());
    $('#field-warna').val($(this).parents("tr").find(".table-warna").html());
    //Pengkondisian link embed

    //Akhir pengkondisian link embed

    $('#ubah-modal')
    .modal('show')
    ;

    });



    $('a').smoothScroll({
    speed:1000
    });

    $('#materi').DataTable();

    });
@endsection
