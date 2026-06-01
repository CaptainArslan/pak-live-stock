@extends('layouts.admin')

@section('content')
    <h2>Edit Phone User</h2>
    <form action="{{ route('phone-users.update', $user->id) }}" method="POST" class="form-group">
        @csrf @method('PUT')
        <div class="card-body">
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3 bolder">Name: </label>
              <div class="col-sm-12 col-md-7">
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3 bolder">Phone: </label>
              <div class="col-sm-12 col-md-7">
                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" required>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
              <div class="col-sm-12 col-md-7">
                <button type="submit" class="btn btn-primary mt-2">Update</button>
              </div>
            </div>
        </div>
    </form>
@endsection
