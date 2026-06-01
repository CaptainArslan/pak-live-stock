@extends('layouts.sidebar')
@section('title', 'User Dashboard')


@section('sidebarContent')

    <style>

        .welcome-card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            padding: 40px 30px;
            max-width: 500px;
            margin: 100px auto;
        }

        .welcome-title {
            font-size: 32px;
            color: #28a745;
            font-weight: bold;
        }

        .welcome-subtitle {
            font-size: 22px;
            color: #333;
        }

        .logout-btn {
            color: #fff;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .logout-btn:hover {
            background-color: #03b436;
        }
    </style>

<div class="container">
    <div class="welcome-card text-center">
        <h2 class="welcome-title">!خوش آمدید</h2>
        <p class="welcome-subtitle">{{ auth('phoneUser')->user()->name }} صاحب</p>
        <p><strong>فون نمبر:</strong> {{ auth('phoneUser')->user()->phone }}</p>
        <p class="mt-3">ہمیں خوشی ہے کہ آپ ہمارے پلیٹ فارم پر موجود ہیں۔ یہاں سے آپ اپنی معلومات دیکھ سکتے ہیں، اشتہارات پوسٹ کر سکتے ہیں اور مزید!</p>

        <form method="POST" action="{{ route('phone-user.logout') }}">
            @csrf
            <button type="submit" class="logout-btn btn btn-primary">لاگ آؤٹ</button>
        </form>
    </div>
</div>


@endsection

