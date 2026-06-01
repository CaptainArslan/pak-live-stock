<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - Live Stock</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    #loader {
      display: none;
      text-align: center;
      padding: 10px;
    }
    label {
      display: inline-block;
      width: 100%;
      direction: rtl;
    }
    .btn-primary {
      background-color: #004614;
      border: none !important;
    }
    .formcard {
      height: 100vh !important;
      align-items: center;
    }
  </style>
</head>
<body>
<div class="container py-5 d-flex formcard justify-content-center">
  <div class="card p-4 w-100" style="max-width: 400px;">
    <div class="text-center mb-3">
      <a href="/"><img src="{{ asset('/assets/images/logo.png') }}" style="width: 70px; height: 70px;" /></a>
    </div>
    <h4 class="text-center mb-3">صارف رجسٹر کریں۔</h4>

    <!-- Loader -->
    <div id="loader">
      <div class="spinner-border text-primary" role="status"></div>
      <p class="mt-2">براہ کرم انتظار کریں...</p>
    </div>

    <!-- Register Form -->
    <form id="register-form" action="{{ route('register-user') }}" method="POST">
      @csrf
      <label>نام:</label>
      <input type="text" name="name" class="form-control mb-2" required />

      <label>فون نمبر:</label>
      <input type="tel" id="phone" class="form-control mb-2" placeholder="03001234567" required />

      <div id="recaptcha-container" class="mb-3"></div>

      <button type="button" id="send-otp" class="btn btn-primary w-100">OTP بھیجیں</button>

      <div id="otp-section" class="mt-3 d-none">
        <label>OTP Code:</label>
        <input type="text" id="otp-code" class="form-control mb-2" placeholder="Enter OTP">
        <button type="button" id="verify-otp" class="btn btn-success w-100">OTP کی تصدیق کریں</button>
      </div>

      <!-- Hidden input to hold final verified +92 number -->
      <input type="hidden" name="phone" id="verified-phone" />
    </form>

    <div class="text-center mt-3">
      <a href="/" class="text-decoration-none text-black">← Back To Home</a>
    </div>
  </div>
</div>

<!-- Firebase SDK -->
<script src="https://www.gstatic.com/firebasejs/11.10.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/11.10.0/firebase-auth-compat.js"></script>

<script>
  const firebaseConfig = @json(config('firebase.client'));

  firebase.initializeApp(firebaseConfig);
  const auth = firebase.auth();
</script>

<script>
  let confirmationResult = null;

  const loader = document.getElementById("loader");
  const form = document.getElementById("register-form");

  // Normalize Pakistani number to +92 format
  function normalizePhoneNumber(number) {
    number = number.replace(/\D/g, ''); // Remove non-digit
    if (number.startsWith("0")) {
      return "+92" + number.slice(1);
    } else if (number.startsWith("92")) {
      return "+" + number;
    } else if (number.startsWith("3") && number.length === 10) {
      return "+92" + number;
    }
    return number;
  }

  document.getElementById("send-otp").addEventListener("click", function () {
    let phoneInput = document.getElementById("phone").value.trim();
    const formattedPhone = normalizePhoneNumber(phoneInput);
    const phoneRegex = /^\+923\d{9}$/;

    if (!phoneRegex.test(formattedPhone)) {
      Swal.fire("Invalid Number", "Enter valid number like 03001234567", "error");
      return;
    }

    loader.style.display = 'block';

    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier("recaptcha-container", {
      size: "invisible"
    });

    auth.signInWithPhoneNumber(formattedPhone, window.recaptchaVerifier)
      .then(function (result) {
        loader.style.display = 'none';
        confirmationResult = result;
        document.getElementById("otp-section").classList.remove("d-none");
        document.getElementById("verified-phone").value = formattedPhone;
        Swal.fire("OTP Sent", "Check your phone for the code.", "success");
      })
      .catch(function (error) {
        loader.style.display = 'none';
        Swal.fire("Error", error.message, "error");
      });
  });

  document.getElementById("verify-otp").addEventListener("click", function () {
    const otpCode = document.getElementById("otp-code").value.trim();
    if (!otpCode) {
      Swal.fire("Required", "Please enter the OTP.", "warning");
      return;
    }

    loader.style.display = 'block';

    confirmationResult.confirm(otpCode)
      .then(function () {
        Swal.fire("Verified", "Phone number verified successfully!", "success");
        setTimeout(() => {
          loader.style.display = 'none';
          form.submit(); // Submit the form to Laravel backend
        }, 800);
      })
      .catch(function (error) {
        loader.style.display = 'none';
        Swal.fire("Invalid OTP", "Verification failed. Try again.", "error");
      });
  });
</script>
</body>
</html>
