@extends('admin.tema')
@section('admintitle') Ekle işlemler @endsection
@section('css')
@endsection
@section('master')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    @if(session('basarili'))
                        <div class="alert alert-success">{{session('basarili')}}</div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Site Ayarları</h4>
                            <div class="basic-form">
                                <form action="{{route('iletisimpost')}}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label>Site Başlık</label>
                                        <input type="text" class="form-control input-default" placeholder="Başlık" name="tel" value="{{$veriler->tel}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Anahtar</label>
                                        <input type="text" class="form-control input-default" placeholder="Anahtar" name="tel2" value="{{$veriler->tel2}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" class="form-control input-default" placeholder="Description" name="whatsapp" value="{{$veriler->whatsapp}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" class="form-control input-default" placeholder="Description" name="adres" value="{{$veriler->adres}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" class="form-control input-default" placeholder="Description" name="googlemaps" value="{{$veriler->googlemaps}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" class="form-control input-default" placeholder="Description" name="email" value="{{$veriler->email}}">
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" name="gonder" value="Kaydet">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- #/ container -->
        </div>
    </div>

@endsection
@section('js')
    @include('sweetalert::alert')
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
@endsection
