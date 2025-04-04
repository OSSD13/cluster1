@extends('Layouts.default_with_menu')

@section('content')
<div class="app-wrapper">
  <main class="app-main">
    <div class="app-content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card shadow-lg ml-0 me-auto w-100">
              <div class="card-header bg-primary text-white">
                <h3 class="mb-0">User List</h3>
              </div>
              <div class="card-body">
                <table class="table table-hover">
                  <thead class="table-light">
                    <tr>
                      <th style="width: 10%;">ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $index => $user)
                    <tr class="align-middle">
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>
                        <div class="d-flex" gap-2>
                          <a href="{{ url('/user/'.$user->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                          </a>
                          <form action="{{ route('user.delete', ['id' => $user->id]) }}" method="post" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger delete-btn">
                              <i class="fas fa-trash-alt"></i> Delete
                            </button>
                          </form>

                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="card-footer text-center">
                <p class="mb-0">Total Users: {{ count($users) }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".delete-btn").forEach((button) => {
      button.addEventListener("click", function() {
        let form = this.closest("form"); // ดึงฟอร์มที่เกี่ยวข้อง
        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Yes, delete it!"
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  });
</script>
@endsection