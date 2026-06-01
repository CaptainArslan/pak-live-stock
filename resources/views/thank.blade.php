@extends('layouts.app')
@section('title', 'Thank You - Pak Livestock')
@section('content')
<div class="container vh-50 place-center">
    <div class="card text-center">
        <div class="card-header text-center primary"> <strong>
        اشتہار کامیابی کے ساتھ اپ لوڈ ہو گیا ہے۔
        </strong></div>
        <div class="card-body text-center p-5">
            <h2 class="card-title text-center">آپ کا  بہت شکریہ</h5>
            <p class="card-text text-center pt-3">اشتہار اپ لوڈ کرنے کا شکریہ۔        </p>
            <a href="{{ route('home') }}" class="btn btn-primary pb-3">
            ہوم پیج پر جائیں
            </a>
        </div>
    </div>
</div>
@endsection