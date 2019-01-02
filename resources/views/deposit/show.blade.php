@extends('layouts.main')
@section('title','transaction member')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-6 dark p-3">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <a href="{{ asset('/storage/members/'.$member->profile_picture) }}">
                            <img src="{{ asset('/storage/members/'.$member->profile_picture) }}" width="100px" height="100px"  class="rounded" alt="">
                        </a>
                    </div>
                    <div class="col-sm-12 col-md-9">
                        <div class="row">
                            <div class="col-12 d-flex">
                                <h5>Name</h5>
                                <h6 class="mx-3">{{$member->name}}</h6>
                            </div>
                            <div class="col-12 d-flex">
                                <h5>Member Number</h5>
                                <h6 class="mx-3">{{$member->member_number}}</h6>
                            </div>
                            <div class="col-12 d-flex">
                                <h5>Total Balance</h5>
                                <h6 class="mx-3">Rp.{{$member->_Balance()}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-12 text-center">
                        <a href={{route('member.show',['id'=>$member->id])}} class="btn btn-sm lavender"> more detail</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="w-100 h-100 dark">
                    <canvas id="riwayatChart">

                    </canvas>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-4 px-3 py-2 mt-5 mx-1 dark">
                <h6> Deposit Field</h6>
                <form action={{route('deposit')}} method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="deposit">nominal dalam bentul RP</label>
                        <input type="text" name="nominal_transaction" class="form-control dark text-white" value="{{ old('deposit') }}" id="deposit">
                        <input type="hidden" name="member_id" value={{$member->id}}>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-md lavender">Deposit</button>
                    </div>
                </form>
            </div>
            <div class="col-sm-12 col-md-4 px-3 py-2 mt-5 mx-1 dark">
                <h6> Withdrawal Field</h6>
                <form action={{route('withdrawal')}} method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="withdrawal">nominal dalam bentuk rp</label>
                        <input type="text" name="nominal_transaction" class="form-control dark text-white" value="{{ old('withdrawal') }}" id="withdrawal">
                        <input type="hidden" name="member_id" value={{$member->id}}>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-md lavender">Withdrawal</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-5 mb-3">
                <h5>History Transaction</h5>
            </div>
        </div>
        <div class="row">
            <table class="table table-borderless dark">
                <thead>
                    <th>#</th>
                    <th>date</th>
                    <th>type transaction</th>
                    <th>nominal transaction</th>
                    <th>balance</th>
                    <th>#</th>
                </thead>
                <tbody class="text-white">
                    @foreach ($member->deposit->sortByDesc('id') as $transaction)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$transaction->date}}</td>
                            <td>{{$transaction->deposit_type->transaction_name}}</td>
                            <td>{{$transaction->nominal_transaction}}</td>
                            <td>{{$member->_BalanceAt($transaction->id)}}</td>
                            <td>edit</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var labels = {!! json_encode($labels)  !!}
        var datas = {!! json_encode($datas) !!}
        var ctx = document.getElementById('riwayatChart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels: labels,
                datasets: [{
                    label: "History Saldo",
                    borderColor: 'rgb(27,40,247)',
                    data: datas,
                }]
            },

            // Configuration options go here
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
                
            }
        });
    </script>
@endsection