@extends('layouts.sidebar')
@section('title', 'User Profile')
@section('sidebarContent')

    <style>
        
        .profile-card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            padding: 40px 30px;
            max-width: 500px;
            margin: 100px auto;
        }

        .profile-title {
            font-size: 28px;
            color: #004614;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
            margin-top: 10px;
        }

        .form-control {
            border-radius: 8px;
        }

        .update-btn {
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 8px;
            margin-top: 20px;
        }

    </style>

<div class="container">
    <div class="profile-card text-center">
        <h2 class="profile-title">پروفائل اپ ڈیٹ کریں</h2>
        <form action="{{ route('phone-user.updateProfile') }}" method="POST">
            @csrf
            <div class="text-end">
                <label class="form-label">نام:</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>

                <label class="form-label">فون نمبر:</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" disabled>

                <button type="submit" class="update-btn btn btn-primary">اپ ڈیٹ</button>
            </div>
        </form>
    </div>
</div>


@endsection
