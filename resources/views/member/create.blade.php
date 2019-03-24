@extends('layouts.main')
@section('title' , 'Register')
@section('action','/anggota-search')
@section('content')
    <div class="container-fluid">
        <div class="ml-3 mt-5 dark text-white p-5">
            <div class="row mb-5">
                <div class="col-3">
                    <a href={{route('member.index')}} class="btn btn-sm"><i class="fas fa-long-arrow-alt-left fa-2x"></i></a> 
                </div>
                <div class="col-9 text-right">
                    <h4>Form Pendaftaran Anggota</h4>
                </div>
            </div>
            <form action={{route('member.store')}} method="POST" enctype="multipart/form-data">
                @csrf 
                <div class="row">
                    <div class="col-sm-12 col-md-8">
                        <div class="form-group">
                            <label for="nama">Name</label>
                            <input class="form-control dark-light" type="text" name="name" id="name">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="no_ktp">KTP Number</label>
                            <input class="form-control" type="text" name="ktp_number" id="ktp_number">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat">Address</label>
                    <input class="form-control" type="text" name="address" id="address">
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="no_tlp">Phone Number</label>
                            <input class="form-control" type="text" name="phone_number" id="phone_number">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="tgl-lahir">Birth Day</label>
                            <input class="form-control" type="date" name="birth_day" id="birth_day">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div>
                            <label for="">Gender</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" value="man" name="gender" id="man" class="custom-control-input">
                                <label class="custom-control-label" for="man"> Man</label>    
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" value="women" name="gender" id="women" class="custom-control-input">
                                <label class="custom-control-label" for="women">Women</label>
                        </div>     
                    </div>
                    <div class="col-sm-12 col-md-7">
                         <div class="custom-file">
                                <input id="picture" type="file" class="{{ $errors->has('picture') ? ' is-invalid' : '' }} custom-file-input dark text-white" name="picture" value="{{ old('picture') }}" required>
                                <label class="custom-file-label dark text-white" for="picture">Choose file</label>
                            </div>
                           
                            @if ($errors->has('picture'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('picture') }}</strong>
                                </span>
                            @endif
                    </div>
                </div>
                <div class="col-12 text-right mt-5">
                    <button class="btn purple-gradient">Submit</button>
                </div>
            </form>

        </div>
    </div>
@endsection