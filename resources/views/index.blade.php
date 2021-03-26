@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    List Customer
                    @if (Auth::user()->role=='admin')
                    <a href="{{ route('customer.create') }}" class="btn btn-success">Add Customer</a>
                    @endif

                </div>

                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th style="width: 20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customer as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->phone}}</td>
                                    <td>
                                        <div  style="display: flex !important; justify-content: space-between;">
                                            <a href="{{ route('customer.edit',$item->id) }}" class="btn btn-info">Update</a>
                                            @if (Auth::user()->role=='admin')
                                            <form action="{{ route('customer.destroy', $item->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <input id="id" name="id" hidden />
                                                <button type="submit" class="btn btn-outline-danger">Delete</button>
                                            </form>

                                            @endif


                                        </div>

                                    </td>
                                </tr>

                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true
        });
    } );
</script>

@endsection

