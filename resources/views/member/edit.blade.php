@extends('layouts.main')
@section('title' , 'Edit Member')
@section('action','/anggota-search')
@section('content')
    <div class="container-fluid">
        <div class="p-5 dark text-white">
            <div class="row mb-5">
                <div class="col-3">
                    <a href={{route('member.show',['id'=>$member->id])}} class="btn btn-sm"><i class="fas fa-long-arrow-alt-left fa-2x"></i></a> 
                </div>
                <div class="col-9 text-right">
                    <h4>Form Edit Anggota</h4>
                </div>
            </div>
            <form action={{route('member.update',['id'=>$member->id])}} method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT') 
                <div class="row">
                    <div class="col-sm-12 col-md-8">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input class="form-control dark-light" type="text" name="name" value="{{$member->name}}" id="name">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="ktp_number">No KTP</label>
                            <input class="form-control" type="text" name="ktp_number" value="{{$member->ktp_number}}"  id="ktp_number">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="adress">Alamat</label>
                    <input class="form-control" type="text" name="address" value="{{$member->address}}"  id="address">
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="phone_number">No Telepon</label>
                            <input class="form-control" type="text" name="phone_number" value="{{$member->phone_number}}"  id="phone_number">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="birth_day">tanggal Lahir</label>
                            <input class="form-control" type="date" name="birth_day" value="{{$member->birth_day}}"  id="birth_day">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div>
                            <label for="">Gender</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" value="man" name="gender" id="man" class="custom-control-input" @if ($member->gender == 'man') checked @endif>
                                <label class="custom-control-label" for="man"> Man</label>    
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" value="women" name="gender" id="women" class="custom-control-input"  @if ($member->gender == 'women') checked @endif>
                                <label class="custom-control-label" for="women">women</label>
                        </div>  
                    </div>
                </div>
                <div class="col-12 text-right mt-5">
                    <button class="btn purple-gradient">Submit</button>
                </div>
            </form>

        </div>
    </div>
@endsection