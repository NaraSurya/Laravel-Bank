@extends('layouts.main')
@section('title','transaction member')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h5>Result</h5>
            </div>
        </div>
        <div class="row">
            <table class="table bg-dark text-white table-borderless">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nama</th>
                        <th>No Anggota</th>
                        <th>Saldo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members->sortByDesc('id') as $member)
                        <tr>
                            <td>
                                 <a  href="{{ asset('/storage/members/'.$member->profile_picture) }}" target="_blank">
                                     <img src="{{ asset('/storage/members/'.$member->profile_picture) }}"  class="rounded-circle" alt="logo_simple"  width="35px" height="35px">
                                 </a>
                            </td>
                            <td>
                                {{$member->name}}
                            </td>
                            <td>
                                 {{$member->member_number}}
                             </td>
                             <td>
                                 {{$member->_Balance()}}
                             </td>
                             <td>
                                 <a class="text-white" href={{ route('deposit.show',['id'=>$member->id])}}> <i class="fas fa-external-link-square-alt fa-lg text-dark-blue"></i></a>
                             </td>
                        </tr>
                    @endforeach
                </tbody>
             </table>
        </div>
    </div>
@endsection