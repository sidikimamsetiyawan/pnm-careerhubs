@extends('panel.layouts.app')

@section('content')

  

    <div class="pagetitle">
      <h1>Edit Hobby</h1>
    </div>

    <section class="section">
        <div class="row">
          <div class="col-lg-5">
  
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Form Hobby</h5>
  
                <!-- General Form Elements -->
                <form action="" method="POST">
                    {{ csrf_field() }}
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Hobby</label>
                    <div class="col-sm-10">
                      <input type="text" name="hobby_name" value="{{ $getRecord->hobby_name }}" class="form-control" required>
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
 

  