@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Update Customer
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
                    <form method="POST" action="{{ route('customer.update',$customer->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $customer->name }}" autocomplete="name" autofocus {{Auth::user()->role=='agent'?'disabled':''}}>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $customer->email }}" autocomplete="email" autofocus {{Auth::user()->role=='agent'?'disabled':''}}>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $customer->phone }}" autocomplete="phone" autofocus {{Auth::user()->role=='agent'?'disabled':''}}>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="agent_id" class="col-md-4 col-form-label text-md-right">{{ __('Assign Agent') }}</label>

                            <div class="col-md-6">
                                <select id="agent_id" class="form-control @error('agent_id') is-invalid @enderror" name="agent_id" value="{{ old('agent_id') }}" autocomplete="agent_id" {{Auth::user()->role=='agent'?'disabled':''}}>
                                        <option value="">Select Agent</option>
                                    @foreach ($agent as $item)
                                        <option value="{{$item->id}}"
                                        @if ($item->id==$customer->agent_id)
                                            selected
                                        @endif >{{$item->name}}</option>
                                    @endforeach


                                </select>

                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{Auth::user()->role=='admin'?'hidden-cus':''}}" >
                            <label for="status_follow_up" class="col-md-4 col-form-label text-md-right">{{ __('Status Follow Up') }}</label>

                            <div class="col-md-6">
                                <select id="status_follow_up" class="form-control @error('status_follow_up') is-invalid @enderror" name="status_follow_up" value="{{ old('status_follow_up') }}" autocomplete="status_follow_up">
                                        <option value="">Select Status Follow Up</option>
                                    @foreach ($status as $item)
                                        <option value="{{$item->id}}"
                                         >{{$item->name}}</option>
                                    @endforeach


                                </select>

                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{Auth::user()->role=='admin'?'hidden-cus':''}}">
                            <label for="remark" class="col-md-4 col-form-label text-md-right">{{ __('Add Remarks Follow Up') }}</label>

                            <div class="col-md-6">
                                <textarea id="remark" class="form-control @error('remark') is-invalid @enderror" name="remark" autocomplete="remark" cols="30" rows="10">{{ old('remark') }}</textarea>

                                @error('remark')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>

                        <table id="example" class="table table-striped table-bordered" style="width:100%;margin-top:20px">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Last Follow Up</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($statusCustomer as $item)
                                    <tr>
                                        <td>{{$item->statusDetail->name}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->remark}}</td>
                                    </tr>

                                @endforeach


                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
