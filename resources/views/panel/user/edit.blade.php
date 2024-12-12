@extends('panel.layouts.app')

@section('content')

  

    <div class="pagetitle">
      <h1>Edit User</h1>
    </div>

    <section class="section">
        <div class="row">
          <div class="col-lg-8">
  
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Form Edit User</h5>
  
                <!-- General Form Elements -->
                <form action="" method="POST">
                    {{ csrf_field() }}
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                      <input type="text" name="name" value="{{ $getRecord->name }}" class="form-control" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" name="email" value="{{ $getRecord->email }}" class="form-control" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                      <input type="password" name="password" class="form-control">
                      (Do you want to change your password? If yes, please fill it in. Otherwise, leave it as is.)
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Role</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="role_id" required>
                        @foreach ($getRole as $value)
                            <option {{ ($getRecord->role_id == $value->id) ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Hobby</label>
                    <div class="col-sm-10">
                      <select class="form-select" multiple name="hobby_id">
                        @foreach ($getHobby as $key)
                          <option value="{{ $key->id }}">{{ $key->hobby_name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
  
                  <div class="row mb-3">
                    <div class="col-sm-12" style="text-align: right;">
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                  </div>
  
                </form><!-- End General Form Elements -->
  
              </div>
            </div>
  
          </div>
        </div>
      </section>

  
@endsection
 

  