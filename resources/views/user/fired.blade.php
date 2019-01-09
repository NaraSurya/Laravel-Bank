@extends('layouts.main')
@section('title','Data Users Fired')
@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-6 text-center">
                <h5>Data User Fired</h5>
            </div>
        </div>
        <div class="row mt-3">
            <table class="table dark table-borderless mx-3">
                <thead>
                    <tr>
                        <th></th>
                        <th>nama</th>
                        <th>Email</th>
                        <th>User  Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                       <tr>
                            <td>
                                <a  href="{{ asset('/storage/users/'.$user->profile_picture) }}" target="_blank">
                                    <img src="{{ asset('/storage/users/'.$user->profile_picture)  }}"  class="rounded-circle" alt=""  width="35px" height="35px">
                                </a>
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email}}</td>
                            <td>{{ $user->userRole->role}}</td>
                       </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection