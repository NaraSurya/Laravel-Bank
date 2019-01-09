@extends('layouts.main')
@section('title','Monthly Report')
@section('content')
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-12">
                <h5>Weekly Report</h5>
            </div>
        </div>
        <form action={{route('weeklyReport.search') }} method="post">
            @csrf
            <div class="row mt-5">
                <div class="col-3">
                    <div class="form-group d-flex">
                        <label for="date">Date</label>
                        <input type="month" name="date" class="form-control dark  mx-3" id="date">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group d-flex">
                        <label for="week">Week</label>
                        <select name="week" class="form-control dark text-white" id="week">
                            <option value="0">Minggu Pertama</option>
                            <option value="1">Minggu Kedua</option>
                            <option value="2">Minggu Ketiga</option>
                            <option value="3">Minggu Keempat</option>
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group d-flex">
                        <button type="submit" class="btn btn-md lavender">Search</button>
                    </div>
                </div>
                <div class="col-2">
                    <h6>Start Date : {{$startDate->format('Y-m-d')}}</h6>
                </div>
                <div class="col-2">
                    <h6>End Date : {{$endDate->format('Y-m-d')}}</h6>
                </div>
            </div>
        </form>
        <div class="row mt-3">
            <table class="table dark table-borderless">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>No anggota</th>
                        <th>jenis transaksi</th>
                        <th>debet</th>
                        <th>kredit</th>
                        <th>Saldo</th>
                        <th>date</th>
                    </tr>
                </thead>
                <tbody class="text-white">
                    @foreach ($deposits->sortByDesc('date') as $transaction)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$transaction->member->name}}</td>
                            <td>{{$transaction->member->member_number}}</td>
                            <td>{{$transaction->deposit_type->transaction_name}}</td>
                            @if ($transaction->_Debit() > 0)
                                <td>  Rp. {{number_format($transaction->_Debit(),0,',','.')}}</td>
                            @else
                                <td>{{$transaction->_Debit()}}</td>
                            @endif
                            @if ($transaction->_Kredit() > 0)
                                <td>  Rp. {{number_format($transaction->_Kredit(),0,',','.')}}</td>
                            @else
                                <td>{{$transaction->_Kredit()}}</td>
                            @endif
                            <td>Rp. {{number_format($transaction->member->_BalanceAt($transaction->id),0,',','.')}}</td>
                            <td>{{$transaction->date}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                {!! $deposits->links() !!}
            </div>
        </div>
    </div>
@endsection