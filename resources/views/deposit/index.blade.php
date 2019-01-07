@extends('layouts.main')
@section('title','transaction')
@section('action', route('deposit.search'))
@section('content')
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-12">
                <div class="card-deck">
                    <div class="card">
                        <div class="card-body dark border-0">
                            <h5 class="card-title">Total Bank Balance</h5>
                            <h5>{{ $balance}}</h5>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body dark border-0">
                            <h5 class="card-title">Total Deposits</h5>
                            <h5>{{ $deposits->where('deposit_type_id','1')->sum('nominal_transaction')}}</h5>
                        </div>  
                        <form action="{{route('deposit.menu')}}" method="GET">
                            <input type="hidden"  value=1 name="menu">
                            <button type="submit" class="btn btn-md lavender w-100">Pilih</button>
                        </form>         
                    </div>
                    <div class="card">
                        <div class="card-body dark border-0">
                            <h5 class="card-title">Total withdrawal</h5>
                            <h5>{{ $deposits->where('deposit_type_id','2')->sum('nominal_transaction')}}</h5>
                        </div>
                        <form action="{{route('deposit.menu')}}" method="GET">
                                <input type="hidden"  value=2 name="menu">
                                <div class="text-center">
                                        <button type="submit" class="btn btn-md lavender w-100">Pilih</button>
                                </div>  
                        </form>
                    </div>
                    <div class="card">
                        <div class="card-body dark border-0">
                            <h5 class="card-title">Total interest</h5>
                            <h5>{{ $deposits->where('deposit_type_id','3')->sum('nominal_transaction')}}</h5>
                        </div>
                        <form action="{{route('deposit.menu')}}" method="GET">
                                <input type="hidden"  value=3 name="menu">
                                <button type="submit" class="btn btn-md lavender w-100">Pilih</button>
                        </form>
                    </div>
                    <div class="card">
                        <div class="card-body dark border-0">
                            <h5 class="card-title">Total taxs</h5>
                            <h5>{{ $deposits->where('deposit_type_id','4')->sum('nominal_transaction')}}</h5>
                        </div>
                        <form action="{{route('deposit.menu')}}" method="GET">
                                <input type="hidden" value=4 name="menu">
                                <button type="submit" class="btn btn-md lavender w-100">Pilih</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <table class="table table-borderless dark text-white">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>date</th>
                        <th>Member</th>
                        <th>type transaction</th>
                        <th>Nominal Transaction</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deposits->sortByDesc('id') as $transaction)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$transaction->date}}</td>
                            <td>{{$transaction->member->name}}</td>
                            <td>{{$transaction->deposit_type->transaction_name}}</td>
                            <td> Rp. {{number_format($transaction->nominal_transaction,0,',','.')}}</td>
                            <td>edit</td>
                        </tr>
                        
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                {!! $deposits->links() !!}
            </div>
        </div>
    </div>
@endsection