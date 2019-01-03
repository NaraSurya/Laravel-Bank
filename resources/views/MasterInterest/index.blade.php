@extends('layouts.main')
@section('title','Master Bunga')
@section('content')
    <div class="container-fluid">
        <div class="row mt-3 mb-5">
            <div class="col-12">    
                <h4>Master Data Bunga</h4>
            </div>
        </div>
        <form action={{route('masterInterest.store')}} method="POST">
            @csrf
            <div class="row">
                <div class="col-3 p-3 dark">
                    <div class="form-group">
                        <label for="percentage">Percentage</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="percentage" placeholder="percentage Interest" id="percentage">
                    </div>
                </div>
                <div class="col-3 p-3 dark">
                    <div class="form-group ">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" name="start_date" id="start_date">
                    </div>
                </div>
                <div class="col-3 p-4 dark">
                    <div class="form-group">
                        <button type="submit" class="btn btn-md lavender mt-4">Create Master Interest</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row mt-3">
            <table class="table dark table-borderless">
                <thead>
                    <tr>
                        <th> # </th>
                        <th>Start Date</th>
                        <th>Percentage</th>
                        <th>Created at</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="text-white">
                    @foreach ($masterInterest as $interest)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$interest->start_date}}</td>
                            <td>{{$interest->percentage}}%</td>
                            <td>{{$interest->created_at}}</td>
                            <td><a href="" class="btn btn-sm btn-success">Edit</a></td>
                            <td>
                                <form action={{route('masterInterest.destroy',['id'=>$interest->id])}} method="post">
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
    </div>  
@endsection