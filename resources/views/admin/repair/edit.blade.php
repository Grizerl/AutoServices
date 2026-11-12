@extends('layouts.admin_layouts')
@section('title',' Car Services and Mechanic')
@section('content')
<div class="card card-primary">
              <form action="{{route('repair.update',$repair->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label>Customer name</label>
                    <input name="name" type="text" class="form-control" value="{{$repair->name}}">
                  </div>
                  <div class="form-group">
                    <label>Auto</label>
                    <input name="car" type="text" class="form-control" value="{{$repair->car}}">
                  </div>
                  <div class="form-group">
                    <label>Problems with car</label>
                    <input name="problem" type="text" class="form-control" value="{{$repair->comment}}">
                  </div>
                  <div class="form-group">
                    <label>Price</label>
                    <input name="price" type="text" class="form-control" value="{{$repair->price}}">
                  </div>
                  <div class="form-group">
                    <label>Status</label>
                    <input name="done" type="text" class="form-control" value="{{$repair->done}}">
                  </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Edit date</button>
                </div>
              </form>
            </div>
@endsection