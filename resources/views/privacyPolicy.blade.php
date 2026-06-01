@extends('layouts.app')
@section('title', 'Thank You - Pak Livestock')
@section('content')
  <style>
    body {
      background: #f9f9f9;
    }
    .privacy-policy {
      background: #fff;
      padding: 3rem 2rem;
      margin: 2rem auto;
      border-radius: 0.75rem;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
      max-width: auto;
    }
    p {
      margin-bottom: 1.2rem;
      line-height: 1.7;
    }
    .heading{
      background-color: #004614;
      color: #fff;
      padding: 20px;
    }
    .heading hr{
      width: 150px;
      color: #fff;
      font-weight: bolder;
      height: 4px;
      background-color: #fff;
    }
  </style>

  <div class="container">
    <div class="privacy-policy">
      <div class="heading mb-3">
        <h1 class="text-start"> Privacy Policy</h1>
        <hr>
      </div>
      <p>Pak Live Stock is a Free application. This service is provided by Pak Live Stock at no cost and is intended for use as-is.</p>
      <p>This Privacy Policy is intended to inform users of our policies regarding the collection, use, and disclosure of personal data when using our app. By using this app, you agree to the collection and use of information in accordance with this policy.</p>

      <h3 class="mt-4">1. Information We Collect</h3>
      <p>We collect and process the following types of data:</p>
      <ul>
        <li><strong>Personal Information:</strong> Name, email address, and phone number (if provided via registration/login using Firebase Authentication).</li>
        <li><strong>Usage Data:</strong> Information on how the app is accessed and used, including device information, session duration, clicks, and interactions.</li>
        <li><strong>Log Information:</strong> In case of app errors, we may collect log data such as IP address, device name, OS version, and error details.</li>
      </ul>

      <h3 class="mt-4">2. Third-Party Services</h3>
      <p>The app uses third-party services that may collect information used to identify you. These include:</p>
      <ul>
        <li>Firebase Authentication</li>
        <li>Firebase Analytics</li>
        <li>Firebase Crashlytics</li>
        <li>OpenAI API – Used to provide AI-based responses. Inputs may be processed according to OpenAI’s Privacy Policy.</li>
        <li>Google Play Services</li>
      </ul>
      <p>These services have their own privacy policies which govern their data practices.</p>

      <h3 class="mt-4">3. How We Use Your Information</h3>
      <ul>
        <li>Authenticate users</li>
        <li>Improve app functionality and user experience</li>
        <li>Monitor performance and diagnose issues</li>
        <li>Provide AI-enhanced features</li>
        <li>Respond to user feedback and support</li>
      </ul>

      <h3 class="mt-4">4. Data Storage and Security</h3>
      <p>All personal data is stored securely using Firebase infrastructure and industry best practices. We do not store any sensitive personal information on-device without proper encryption.</p>
      <p>Despite our best efforts, no method of transmission over the Internet is 100% secure. We recommend users exercise caution when sharing personal information.</p>

      <h3 class="mt-4">5. Cookies</h3>
      <p>This app does not use cookies directly. However, third-party services (e.g., Firebase or Google) may store cookies to enhance their services. You can manage cookie preferences through your device settings.</p>

      <h3 class="mt-4">6. User Control & Data Retention</h3>
      <p>Users can request deletion of their account and associated data by contacting us.</p>
      <p>Data is retained only as long as needed for operational, legal, or analytical purposes.</p>

      <h3 class="mt-4">7. Children’s Privacy</h3>
      <p>This app is not intended for use by children under the age of 13. We do not knowingly collect personally identifiable information from children. If you believe your child has provided us with personal data, please contact us to have it removed.</p>

      <h3 class="mt-4">8. Changes to This Privacy Policy</h3>
      <p>We may update this Privacy Policy periodically. You are advised to review this page regularly for changes. Any updates will be posted here with the updated effective date.</p>
      <p><strong>Effective date:</strong> July 10, 2025</p>

      <h3 class="mt-4">9. Contact Us</h3>
      <p>If you have any questions or concerns about this policy, contact us at:</p>
      <p>📧 Email: <a href="mailto:rizwan.ali1879400@gmail.com">rizwan.ali1879400@gmail.com</a></p>
    </div>
  </div>

@endsection