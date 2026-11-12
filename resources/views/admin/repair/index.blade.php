@extends('layouts.admin_layouts')
@section('title',' Car Services and Mechanic')
@section('content')
<div class="card">
        <div class="card-header">
          <h3 class="card-title">Cars under repair</h3>

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
                        Auto
                      </th>
                      <th>
                        Problem
                      </th>
                      <th style="width: 8%" class="text-center">
                        Status
                      </th>
                      <th style="width: 20%">
                      </th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($repair as $car)
                  <tr>
                      <td>
                        {{$car->id}}
                      </td>
                      <td>
                          <a>
                            {{$car->name}}
                          </a>
                          <br>
                      </td>
                      <td>
                        {{$car->car}}
                      </td>
                      <td class="project_progress">
                         {{$car->comment}}
                      </td>
                      <td class="project-state">
                        {{$car->done}}
                      </td>
                      <td style="display: flex; margin-left: 10vh;" class="project-actions text-right">
                          <a class="btn btn-primary btn-sm mr-1" href="{{route('repair.show',$car['id'])}}">
                              <i class="fas fa-folder">
                              </i>
                              View
                          </a>
                          <a class="btn btn-info btn-sm mr-1" href="{{route('repair.edit',$car['id'])}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
                          <form action="{{route('repair.destroy',$car['id'])}}" method="post">
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