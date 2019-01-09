@extends('layouts.main')
@section('title','Annual Report')
@section('content')
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-12">
                <h5>Annual Report</h5>
            </div>
        </div>
        <form action={{route('annualReport.search') }} method="post">
            @csrf
            <div class="row mt-5">
                <div class="col-2">
                    <div class="form-group d-flex">
                        <label for="date" class="mt-2">Date</label>
                        <input type="number" min="1900" max="2900" value= @if (Session::has('annualReport'))
                            {{Session::get('annualReport')}}
                        @else
                            {{Carbon\Carbon::now()->year }}
                        @endif name="date" class="form-control dark text-white mx-3" id="date" />
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group d-flex">
                        <button type="submit" class="btn btn-md lavender">Search</button>
                    </div>
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
