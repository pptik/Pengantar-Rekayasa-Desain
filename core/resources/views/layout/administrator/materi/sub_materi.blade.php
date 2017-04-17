@extends('layout.administrator.template')
@section('judul-halaman')
    <title>Sub Materi | PRD Online Course</title>
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
                    <a class="item" href="{{url('administrator/materi')}}">
                        Materi
                    </a>
                    <a class="active item" href="{{url('administrator/sub_materi')}}">
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
                        <th>Topik</th>
                        <th>Sub Topik</th>
                        <th>Deskripsi</th>
                        <th>Tipe</th>
                        <th>Isi</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    foreach($sub_materi as $sub_materi){
                    ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $sub_materi->nama_topik;?></td>
                        <td><?php echo $sub_materi->nama_sub_topik;?></td>
                        <td><?php echo $sub_materi->deskripsi;?></td>
                        <td>
                            <?php
                            switch ($sub_materi->tipe) {
                                case 1:
                                    echo "Teks";
                                    break;
                                case 2:
                                    echo "File";
                                    break;
                                case 3:
                                    echo "Video";
                                    break;
                            }
                            ?>
                        </td>
                        <td><?php
                            switch ($sub_materi->tipe) {
                            case 1://teks
                                echo $sub_materi->isi_sub_topik;
                                break;
                            case 2://file
                                echo "<a class='ui teal button' type='button' href='" . $sub_materi->isi_sub_topik . "' target='_blank'>Download</a>";
                                break;
                            case 3://video
                            ?>
                            <div class="card-panel white thin">
                                <div class="center-align video-container">
                                    <iframe width="200" height="150"
                                            src="<?php echo $sub_materi->isi_sub_topik;?>"
                                            frameborder="0" allowfullscreen></iframe>
                                </div>
                                </span>
                            </div>
                            <?php
                            break;
                            }
                            ?>
                        </td>
                        <td>
                            <a class="circular ui icon button hapus"
                               href="{{url('administrator/hapus_sub_materi')}}/<?php echo $sub_materi->id_sub_topik;?>"
                               onclick="return confirm('Apakah anda yakin akan menghapus sub materi ini?')">
                                <i class="delete icon"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                    $no++;
                    }
                    ?>
                    </tbody>
                </table>
                <div class="ui small modal" id="tambah-modal">

                    <div class="header">Tambah Sub Materi</div>


                    <div class="content">
                        <div class="ui form">
                            <form action="{{url('administrator/tambah_sub_materi')}}" method="post"
                                  enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                                <div class="field">
                                    <label>Topik</label>
                                    <select class="ui selection dropdown" name="topik">
                                        <option value="">-</option>
                                        <?php
                                        foreach ($materies as $materi) {
                                            ?>
                                        <option value="<?php echo $materi->id;?>"><?php echo $materi->nama_topik;?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>


                                <!--<div class="field">
                                    <label>Deskripsi singkat</label>
                                    <textarea rows="2" name="deskripsi"></textarea>
                                </div>-->

                                <div class="field">
                                    <label>Judul</label>
                                    <input type="text" name="judul"
                                           placeholder="Judul sub topik">
                                </div>

                                <div class="field">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi"></textarea>
                                </div>
                                <div class="field">
                                    <label>Tipe</label>
                                    <select class="ui selection dropdown" name="tipe" id="tipe">
                                        <option value="">-</option>
                                        <option value="1">Teks</option>
                                        <option value="2">File</option>
                                        <option value="3">Video</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <label>Isi sub materi</label>
                                    <textarea id="isi-sub-materi-teks" name="isi-sub-materi-teks" placeholder="Tulis isi materi disini" style="display: none;"></textarea>
                                    <input id="isi-sub-materi-file" type="file" name="isi-sub-materi-file" style="display: none;">
                                    <input id="isi-sub-materi-video" type="text" name="isi-sub-materi-video" placeholder="Link embed video youtube, contoh: https://www.youtube.com/embed/GUHhS2OdIEs" style="display: none;">
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
                                           placeholder="Pilih class warna di http://materializecss.com/color.html"
                                           id="field-warna">
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

    $('#tipe').change(function(){
    //alert($(this).val());
    if($(this).val() == 1){
        $('#isi-sub-materi-teks').css("display","block");
        $('#isi-sub-materi-file').css("display","none");
        $('#isi-sub-materi-video').css("display","none");
    }else if($(this).val() == 2){
    $('#isi-sub-materi-teks').css("display","none");
    $('#isi-sub-materi-file').css("display","block");
    $('#isi-sub-materi-video').css("display","none");

    }else if($(this).val() == 3){
    $('#isi-sub-materi-teks').css("display","none");
    $('#isi-sub-materi-file').css("display","none");
    $('#isi-sub-materi-video').css("display","block");


    }
    })


    $('a').smoothScroll({
    speed:1000
    });

    $('#materi').DataTable();

    });
@endsection
