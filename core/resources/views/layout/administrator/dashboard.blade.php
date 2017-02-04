@extends('layout.administrator.template')
@section('judul-halaman')
    <title>Dashboard | PRD Online Course</title>
@endsection
@section('konten')
    <div class="ui container">
    <div class="ui secondary pointing menu">
        <a class="active item" href="{{url('/')}}">
            <h3>prd online course</h3>
        </a>

        <div class="right menu">
            <a class="item" href="{{url('administrator/pengguna')}}">
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
    <div class="ui segment">
        Selamat datang administrator, anda bisa mulai mengatur konten PRD Online Course menggunakan menu yang tersedia pada navigasi.
    </div>

    </div>
@endsection


@section('js')
    $(document).ready(function(){

    $('a').smoothScroll({
    speed:1000
    });

    });
@endsection
