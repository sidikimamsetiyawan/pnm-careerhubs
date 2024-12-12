@extends('panel.layouts.app')

@section('content')

  

    <div class="pagetitle">
      <h1>Hobby</h1>
    </div>

    <section class="section">
        <div class="row">
  
          <div class="col-lg-12">
            @include('_message')
            <div class="card">
              <div class="card-body">
                
                
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="card-title">Hobby Lists</h5>
                    </div>
                    <div class="col-md-6" style="text-align: right;">
                        <a href="{{ url('panel/hobby/add')}}" class="btn btn-primary" style="margin-top: 10px;">Add</a>
                    </div>
                </div>
                <!-- Table with stripped rows -->
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Hobby Name</th>
                      <th scope="col">Date</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if ($getRecord->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">No Record</td>
                    </tr>
                    @else
                      @foreach ($getRecord as $value)
                      <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                          <td>{{ $value->hobby_name }}</td>
                          <td>{{ $value->created_at }}</td>
                          <td>
                              <a href="{{ url('panel/hobby/edit/'.$value->id) }}" class="btn btn-primary btn-sm">Edit</a>
                              <a href="{{ url('panel/hobby/delete/'.$value->id) }}" class="btn btn-danger btn-sm">Delete</a>
                          </td>
                      </tr>
                          
                      @endforeach
                    @endif
                  </tbody>
                </table>
                <!-- End Table with stripped rows -->
  
              </div>
            </div>
  
          </div>
        </div>
      </section>

  
@endsection
 

  