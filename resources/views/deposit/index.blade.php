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
                            <h5> Rp. {{number_format($balance,0,',','.')}}</h5>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body dark border-0">
                            <h5 class="card-title">Total Deposits</h5>
                            <h5> Rp. {{number_format($stats->where('deposit_type_id','1')->sum('nominal_transaction'),0,',','.')}}</h5>
                        </div>  
                        <form action="{{route('deposit.menu')}}" method="GET">
                            <input type="hidden"  value=1 name="menu">
                            <button type="submit" class="btn btn-md lavender w-100">Pilih</button>
                        </form>         
                    </div>
                    <div class="card">
                        <div class="card-body dark border-0">
                            <h5 class="card-title">Total withdrawal</h5>
                            <h5>Rp. {{number_format( $stats->where('deposit_type_id','2')->sum('nominal_transaction'),0,',','.')}}</h5>
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
                            <h5> Rp. {{number_format( $stats->where('deposit_type_id','3')->sum('nominal_transaction'),0,',','.')}}</h5>
                        </div>
                        <form action="{{route('deposit.menu')}}" method="GET">
                                <input type="hidden"  value=3 name="menu">
                                <button type="submit" class="btn btn-md lavender w-100">Pilih</button>
                        </form>
                    </div>
                    <div class="card">
                        <div class="card-body dark border-0">
                            <h5 class="card-title">Total taxs</h5>
                            <h5> Rp. {{number_format( $stats->where('deposit_type_id','4')->sum('nominal_transaction'),0,',','.')}}</h5>
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
            <div class="col-12">
            <form action="{{route('deposit.searchByDate')}}" method="GET">
                            @csrf
                            <div class="row">
                                <div class="col-3 p-3 dark">
                                    <div class="form-group ">
                                        <label for="date">Date</label>
                                    <input type="date" class="form-control" name="dateNow" value="{{Session::get('searchByDate')}}" id="date">
                                    </div>
                                </div>
                                <div class="col-3 p-4 dark">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-md lavender mt-4">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
                        <th>Action</th>
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
                            <td>
                                <form action={{route('deposit.destroy',['id'=>$transaction->id])}} method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
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