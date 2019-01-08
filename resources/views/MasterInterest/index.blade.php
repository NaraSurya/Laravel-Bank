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
                            <td><button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#editModal" data-action="{{ action('MasterInterestController@update', ['id'=>$interest->id]) }}" data-startDate ="{{$interest->start_date}}" data-percentage="{{$interest->percentage}}" >edit</button></td>
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
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Date Interest</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form  method="POST">
                        <div class="modal-body">
                                @csrf
                                <div class="form-group">
                                    <label for="startDate" class="col-form-label">Start Date:</label>
                                    <input type="date" name="start_date" class="form-control" id="startDate">
                                </div>
                                <div class="form-group">
                                    <label for="percentage" class="col-form-label">percentage:</label>
                                    <input type="number" name="percentage" step="0.01" min="0" class="form-control" id="percentage"></input>
                                </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Change</button>
                        </div>
                </form>
                </div>
            </div>
        </div>
    </div>  
@endsection
@section('script')
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var action = button.data('action')
            var startDate = button.data('startDate')
            var percentage = button.data('percentage') 
            
            var modal = $(this)
            modal.find('form').attr('action', action)
            modal.find('#startdate').val(startDate)
            modal.find('#percentage').val(percentage)
        })
    </script>
@endsection