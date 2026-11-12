@extends('layouts.admin_layouts')
@section('title',' Car Services and Mechanic')
@section('content')
<div class="card card-primary">
              <form action="{{route('client.store')}}" method="post">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label>Customer name</label>
                    <input name="name" type="text" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Role</label>
                    <input name="role" type="text" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Comment</label>
                    <input name="commentars" type="text" class="form-control">
                  </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Create response</button>
                </div>
              </form>
            </div>
@endsection