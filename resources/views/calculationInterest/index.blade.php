@extends('layouts.main')
@section('title','calculation interest')
@section('content')
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-12">
                <h5>Calculation Interest</h5>
            </div>
        </div>
        <form action={{route('calculationInterest.store')}} method="POST">
            @csrf
            <div class="row mt-5">
                <div class="col-3">
                    <div class="form-group d-flex">
                        <label for="transactionMonth">Transaction Month</label>
                        <input type="month" name="transaction_month" class="form-control mx-3" id="transactionMonth">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <button type="submit" class=" mx-3 btn btn-md lavender">Calculate Interest</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row mt-3">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Transaction Month</th>
                        <th>Transaction Year</th>
                        <th>Calculation Date</th>
                        <th>Interest</th>
                        <th>Total Interest</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody class="dark">
                    @foreach ($calculationInterest as $transaction)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$transaction->transaction_month}}</td>
                            <td>{{$transaction->transaction_year}}</td>
                            <td>{{$transaction->calculation_date}}</td>
                            <td>{{$transaction->master_interest->percentage}}</td>
                            <td>{{$transaction->_GetTotalInterest()}}</td>
                            <td>{{$transaction->user->name}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection