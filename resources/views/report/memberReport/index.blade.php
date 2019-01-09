@extends('layouts.main')
@section('title','Report Nasabah')
@section('content')
    <div class="container-fluid">
        <div class="row mt-3 mb-5">
            <div class="col-12">    
                <h4>Report Nasabah</h4>
            </div>
        </div>
        <form action={{route('memberReport.sort')}} method="GET">
            @csrf
            <div class="row">
                <div class="col-3 p-3 dark">
                    <div class="form-group ">
                        <label for="date">Sort By</label>
                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="sortBy">
                                <option selected disabled>Pilih</option>
                                <option @if (Session::get('sortBy') == 'Hari') {{'selected'}} @endif value="Hari" >Hari</option>
                                <option @if (Session::get('sortBy') == 'Bulan') {{'selected'}} @endif value="Bulan">Bulan</option>
                                <option @if (Session::get('sortBy') == 'Tahun') {{'selected'}} @endif value="Tahun" >Tahun</option>
                        </select>
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
                        <th>Total Debit</th>
                        <th>Total Kredit</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody class="text-white">
                        
                    @foreach ($monthlys->groupBy('member_id') as $monthly)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$monthly[0]->member->name}}</td>
                            <td>Rp. {{number_format((($monthly->where('deposit_type_id',1)->sum('nominal_transaction')) + ($monthly->where('deposit_type_id',4)->sum('nominal_transaction'))),0,',','.') }}</td>

                            <td>Rp. {{number_format((($monthly->where('deposit_type_id',2)->sum('nominal_transaction')) + ($monthly->where('deposit_type_id',3)->sum('nominal_transaction'))),0,',','.') }}</td>


                            {{-- @if ($monthly->_Debit() > 0)
                                <td>Rp. {{number_format($monthly->_Debit(),0,',','.')}}</td>
                            @else
                                <td>{{$monthly->_Debit()}}</td>    
                            @endif
                            @if ($monthly->_Kredit() > 0)
                                <td>Rp. {{number_format($monthly->_Kredit(),0,',','.')}}</td> 
                            @else
                                <td>{{$monthly->_Kredit()}}</td>
                            @endif --}}

                                                    
                            {{-- <td>Rp. {{number_format($monthly->sum('nominal_transaction'),0,',','.')}}</td> --}}
                            <td>
                                    <a class="text-white" href="/members/member/{{$monthly[0]->member->id}}"> <i class="fas fa-external-link-square-alt fa-lg text-dark-blue"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody> 
            </table>
        </div>
       
    </div>  
@endsection