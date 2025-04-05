@extends('layouts.default')

@section('content')
<div class="login-page" style="background-color: #F2F0EF;">
<div class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <!--<b>CAMP - </b>66</a>-->
            
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
            <p class="login-box-msg text-center">
                <b style="font-weight: 900; font-size: 28px;">Login</b>
                </p>
                <form action="{{ url('/login') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                    <label for="username" class="form-label">Username</label>
                        <input type="text" name="user_username" class="form-control w-100" placeholder="Username" style="border-radius: 6px;"required />
                        <div class="input-group-text bg-transparent border-0"></div>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="user_password" id="password" class="form-control" placeholder="Password" required />
                            <div class="input-group-text ">
                            <span class="bi bi-eye-slash"></span>
                            </div>
                        </div>
                    </div> -->
                    <div class="input-group mb-3">
                        <input type="password" name="user_password" id="password"  class="form-control" placeholder="Password" required />
                        <span class="input-group-text bg-white border-start-0" onclick="togglePassword()" style="cursor: pointer;">
                            <i id="eyeIcon" class="bi bi-eye-slash"></i>
                        </span>
                    </div>

                    <script>
                        function togglePassword() {
                            const passwordInput = document.getElementById("password");
                            const eyeIcon = document.getElementById("eyeIcon");

                            if (passwordInput.type === "password") {
                                passwordInput.type = "text";
                                eyeIcon.classList.remove("bi-eye-slash");
                                eyeIcon.classList.add("bi-eye");
                            } else {
                                passwordInput.type = "password";
                                eyeIcon.classList.remove("bi-eye");
                                eyeIcon.classList.add("bi-eye-slash");
                            }
                        }
                    </script>
                    
                    <!--bi bi-lock-fill-->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn" style="background-color: #3459EF; color: white; font-weight: bold" >Log In</button>
                            </div>
                        </div>
                    </div>
                </form>
                
                <!-- /.social-auth-links -->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
</div>
@endsection
