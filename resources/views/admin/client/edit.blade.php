@extends('layouts.admin_layouts')
@section('title',' Car Services and Mechanic')
@section('content')
<div class="card card-primary">
              <form action="{{route('client.update',$client->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label>Customer name</label>
                    <input name="name" type="text" class="form-control" value="{{$client->name}}">
                  </div>
                  <div class="form-group">
                    <label>Role</label>
                    <input name="role" type="text" class="form-control" value="{{$client->role}}">
                  </div>
                  <div class="form-group">
                    <label>Comment</label>
                    <input name="commentars" type="text" class="form-control" value="{{$client->commentars}}">
                  </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Edit date</button>
                </div>
              </form>
            </div>
@endsection