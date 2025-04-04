
@extends('layouts.default')

@section('content')
    <div class="register-page">
        <div class="register-box">
            <div class="register-logo">
               <b>CAMP -</b> 66 </a>
            </div>
            <!-- /.register-logo -->
            <div class="card">
                <div class="card-body register-card-body">
                    <p class="register-box-msg">Register a new membership</p>
                    <form action="{{ url('/register') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="name" id="name" oninput="return checkname();" class="form-control" placeholder="Full Name" />
                            <div class="input-group-text"><span class="bi bi-person"></span></div>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">
                                กรุณาระบุข้อมูล ชื่อ-นามสกุล
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" name="email" id="email" oninput="return checkemail();" class="form-control" placeholder="Email" />
                            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">
                                กรุณาระบุอีเมล หรือ กรอกอีเมลให้ถูกต้อง
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password" id="password" oninput="return checkPassword();" class="form-control" placeholder="Password" />
                            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                            <div class="valid-feedback">
                                รหัสผ่านปลอดภัยมาก เยี่ยมจริงๆ
                            </div>
                            <div class="invalid-feedback">
                                กรุณาระบุรหัสผ่าน หรือ รหัสผ่าน ต้องมีตัวพิมพ์เล็กพิมพ์ใหญ่อย่างน้อย 8 ตัวอักษร
                            </div>
                        </div>
                        <!--begin::Row-->
                        <div class="row">
                            <div class="col-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                                    <label class="form-check-label" for="flexCheckDefault">
                                        I agree to the <a href="#">terms</a>
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <div class="d-grid gap-2" onclick="return checkValue();">
                                    <button type="submit" class="btn btn-primary">Sign In</button>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!--end::Row-->
                    </form>
                    <!--<button type="button" class="btn" onclick="clickme()">TEST JS</button>-->
                    <!-- /.social-auth-links -->
                    <p class="mb-0">
                        <a href="login.html" class="text-center"> I already have a membership </a>
                    </p>
                </div>
                <!-- /.register-card-body -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function checkname() {
            $('#name').removeClass('is-invalid');
            $('#name').removeClass('is-valid');
            let name = document.getElementById('name');
            // let email = document.getElementById('email');
            if (name.value == '') {
                $('#name').addClass('is-invalid'); //error
            } else {
                $('#name').addClass('is-valid'); //ok
            }
            return true;
        }

        function checkemail() {
            let email = $('#email');
            let emailValue = email.val().trim();
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z]+\.[a-zA-Z]{2,}$/;

            email.removeClass('is-invalid is-valid');

            if (emailValue === '') {
                email.addClass('is-invalid'); // ถ้าข้อมูลว่าง ขึ้น Invalid
                return false;
            } else if (!emailPattern.test(emailValue)) {
                email.addClass('is-invalid'); // ถ้า Format ไม่ถูกต้อง ขึ้น Invalid
                return false;
            } else {
                email.addClass('is-valid'); // ถ้าถูกต้อง ขึ้น Valid
                return true;
            }
        }

        function checkPassword() {
            let password = $('#password');
            let passwordValue = password.val().trim();
            const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

            password.removeClass('is-invalid is-valid');

            if (passwordValue === '') {
                password.addClass('is-invalid'); // ถ้าข้อมูลว่าง ขึ้น Invalid
                return false;
            } else if (!passwordPattern.test(passwordValue)) {
                password.addClass('is-invalid'); // ถ้า Format ไม่ถูกต้อง ขึ้น Invalid
                return false;
            } else {
                password.addClass('is-valid'); // ถ้าถูกต้อง ขึ้น Valid
                return true;
            }
        }

        function checkValue() {
            let checkbox = document.getElementById("flexCheckDefault");
            if (!checkbox.checked){
                alert("🚨 Please check the checkbox");
                return false;
            }
        }
</script>
@endsection
