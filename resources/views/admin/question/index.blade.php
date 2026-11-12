@extends('layouts.admin_layouts')
@section('title','Car Services and Mechanic')
@section('content')
<div class="card">
        <div class="card-header">
          <h3 class="card-title">Ask Question</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 1%">
                        Id
                      </th>
                      <th style="width: 20%">
                        Customer name
                      </th>
                      <th style="width: 30%">
                        Phone
                      </th>
                      <th>
                        Email
                      </th>
                      <th style="width: 8%" class="text-center">
                        Message
                      </th>
                      <th style="width: 20%">
                      </th>
                  </tr>
              </thead>
              <tbody>
                    @foreach($contact as $contacts)
                  <tr>
                      <td>
                        {{$contacts->id}}
                      </td>
                      <td>
                          <a>
                            {{$contacts->name}}
                          </a>
                          <br>
                      </td>
                      <td>
                        {{$contacts->phone}}
                      </td>
                      <td style="width: 40%;" class="project_progress">
                         {{$contacts->email}}
                      </td>
                      <td style=" width: 50%; " class="project-state">
                        {{$contacts->message}}
                      </td>
                      <td style="display: flex; margin-left: 10vh;" class="project-actions text-right">
                          <form action="{{route('contact.destroy',$contacts['id'])}}" method="post">
                            @csrf
                            @method('DELETE')
                          <button class="btn btn-danger btn-sm" type="submit">
                              <i class="fas fa-trash">
                              </i>
                              Delete
                          </button>
                          </form>
                      </td>
                  </tr>
                 @endforeach
              </tbody>
          </table>
        </div>
      </div>
@endsection