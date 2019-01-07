@extends('layouts.main')
@section('title','Report Harian')
@section('content')
    <div class="container-fluid">
        <div class="row mt-3 mb-5">
            <div class="col-12">    
                <h4>Report Harian</h4>
            </div>
        </div>
        <form action={{route('dailyReport.search')}} method="GET">
            @csrf
            <div class="row">
                <div class="col-3 p-3 dark">
                    <div class="form-group ">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" name="dateNow" value={{Session::get('dailyDate')}} id="date">
                    </div>
                </div>
                <div class="col-3 p-4 dark">
                    <div class="form-group">
                        <button type="submit" class="btn btn-md lavender mt-4">Search</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row mt-3">
            <table class="table dark table-borderless">
                <thead>
                     <tr>
                        <th> No </th>
                        <th>Nama</th>
                        <th>No Anggota</th>
                        <th>Jenis Transaksi</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <th>Saldo</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody class="text-white">
                        
                    @foreach ($dailys->sortbyDesc('id') as $daily)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$daily->member->name}}</td>
                            <td>{{$daily->member->member_number}}</td>
                            <td>{{$daily->deposit_type->transaction_name}}</td>
                            @if ($daily->_Debit() > 0)
                                <td>  Rp. {{number_format($daily->_Debit(),0,',','.')}}</td>
                            @else
                                <td>{{$daily->_Debit()}}</td>
                            @endif
                            @if ($daily->_Kredit() > 0)
                                <td>  Rp. {{number_format($daily->_Kredit(),0,',','.')}}</td>
                            @else
                                <td>{{$daily->_Kredit()}}</td>
                            @endif
                            <td>Rp. {{number_format($daily->member->_BalanceAt($daily->id),0,',','.')}}</td>
                            <td>{{$daily->date}}</td>
                        </tr>
                    @endforeach
                </tbody> 
            </table>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                {!! $dailys->links() !!}
            </div>
        </div>
    </div>  
@endsection