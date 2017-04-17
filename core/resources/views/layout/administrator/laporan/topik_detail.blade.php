@extends('layout.administrator.template')
@section('judul-halaman')
    <title>Laporan | PRD Online Course</title>
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
                <a class="item" href="{{url('administrator/materi')}}">
                    Materi
                </a>
                <a class="active item" href="{{url('administrator/laporan')}}">
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
                    <a class="item" href="{{url('administrator/laporan')}}">
                        Pilih Topik
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

                <table class="ui celled table" id="reports" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Asal Universitas</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Link tugas</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    foreach($reports as $report){
                    ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td>
                            <?php
                            $universitas = DB::table('users')
                                    ->join('universitas', 'universitas.id_users', '=', 'users.id')
                                    ->where('universitas.id', '=', $report->universitas)
                                    ->first();

                            echo $universitas->nama_depan . ' ', $universitas->nama_belakang;
                            ?>
                        </td>
                        <td><?php echo $report->nim;?></td>
                        <td><?php echo $report->nama_depan . ' ' . $report->nama_belakang;?></td>
                        <td><a href="<?php echo $report->berkas_video;?>" target="_blank">Lihat</a></td>
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

    $('#reports').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'print', 'pdf'
        ]
    });

    });
@endsection
