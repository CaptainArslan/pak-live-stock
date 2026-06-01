<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('/css/components.css') }}">
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('/css/app.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<title>Login</title>
</head>
<body>

    <section class="vh-100 gradient-form" style="background-color: #eee;place-content:center">
  <div class="container-fluid py-5 col-12 col-md-4">
        <div class="card card-primary rounded-3 text-black">
          <div class="row g-0">
            <div class="col-12">
              <div class="card-body mx-md-4">
                <div class="text-center">
                    <img src="{{ asset('/assets/images/logo.png') }}" alt="logo" width="100px">
                  <h4 class="pt-2">PAK LIVESTOCKS</h4>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Laravel Login Form -->
                <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <p><strong>Please login to your account</strong></p>

                  <!-- Email Address -->
                  <div class="form-outline mb-3">
                    <input type="email" id="email" class="form-control" name="email" placeholder="Enter your email address" required autofocus>
                    <!-- <label class="form-label" for="email">Username</label> -->
                  </div>
                  <!-- Password -->
                    <div class="form-outline mb-1 position-relative">
                      <input type="password" id="password" class="form-control" placeholder="Enter the password" name="password" required>
                      <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2 border-0" style="right:0;top:15px;" id="togglePassword">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                      </button>
                    </div>


                  <!-- Remember Me Checkbox -->
                  <div class="form-outline">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                  </div>


                  <!-- Submit Button -->
                  <div class="pt-1 pb-1">
                    <button class="btn btn-primary btn-block mb-3 me-3" type="submit">Log in</button>
                    <!--<a class="text-muted ms-3" href="{{ route('password.request') }}">Forgot password?</a>-->
                  </div>

                   <!--Register Link -->
                  <!-- <div class="d-flex align-items-center justify-content-center pb-4">-->
                  <!--  <p class="mb-0 me-2">Don't have an account?</p>-->
                  <!--  <a href="{{ route('register') }}" class="btn btn-outline-danger">Create new</a>-->
                  <!--</div> -->
                </form>
              </div>
            </div>
          </div>
    </div>
    </div>
  </section>

<script>
  document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordField = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');

    if (passwordField.type === 'password') {
      passwordField.type = 'text';
      icon.classList.remove('bi-eye-slash');
      icon.classList.add('bi-eye');
    } else {
      passwordField.type = 'password';
      icon.classList.remove('bi-eye');
      icon.classList.add('bi-eye-slash');
    }
  });
</script>
</body>
</html>
