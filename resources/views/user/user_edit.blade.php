@extends('layouts.default_with_menu')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Edit User</h3>
                </div>
                <div class="card-body">
                    
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ url('/user/'.$user->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="mb-3 d-flex align-items-center">
                            <label class="form-label me-3" style="width: 150px;">Name:</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label class="form-label me-3" style="width: 150px;">Email:</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label class="form-label me-3" style="width: 150px;">Password:</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ url('/user') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
