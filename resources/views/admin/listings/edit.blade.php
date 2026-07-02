@extends('layouts.admin')
<style>
    .image-preview{width: auto !important;height: auto!important;}
</style>
@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="container-fluid text-align-end">
        <h2 class="text-right">اپنی پوسٹ میں ترمیم کریں۔</h2><br><br>
        <div class="card" >
  <div class="card-body">
        <form action="{{ route('admin.listings.update', $listing->id) }}" method="POST" enctype="multipart/form-data" dir="rtl">
        @csrf
        @method('PUT')
    
        <div class="container-fluid" style="direction:rtl;">
            <div class="row mt-4">
    
                {{-- READ-ONLY FIELDS --}}
                <div class="col-md-4">
                    <label class="form-label">قسم</label>
                    <select class="form-control" disabled>
                        <option>{{ $listing->category->name ?? '---' }}</option>
                    </select>
                </div>
    
                <div class="col-md-4">
                    <label class="form-label">نسل</label>
                    <select class="form-control" disabled>
                        <option>{{ $listing->breed->name ?? '---' }}</option>
                    </select>
                </div>
    
                <div class="col-md-4">
                    <label class="form-label">عنوان</label>
                    <input type="text" class="form-control" value="{{ $listing->title }}" readonly>
                </div>
    
                <div class="col-md-4">
                    <label class="form-label">صوبہ</label>
                    <input type="text" class="form-control" value="{{ $listing->province }}" readonly>
                </div>
    
                <div class="col-md-4">
                    <label class="form-label">شہر</label>
                    <input type="text" class="form-control" value="{{ $listing->city }}" readonly>
                </div>
    
                <div class="col-md-4">
                    <label class="form-label">رابطہ نمبر</label>
                    <input type="text" class="form-control" value="{{ $listing->contact_number }}" readonly>
                </div>
    
                <div class="col-md-12">
                    <label class="form-label">پتہ</label>
                    <input type="text" class="form-control" value="{{ $listing->address }}" readonly>
                </div>
    
                <div class="col-md-12">
                    <label class="form-label">تفصیل</label>
                    <textarea class="form-control" rows="4" readonly>{{ $listing->detail }}</textarea>
                </div>
    
                @if($listing->images)
                    <div class="col-md-12 mt-3">
                        <label class="form-label">تصاویر</label><br>
                        @foreach(json_decode($listing->images) as $image)
                            <img src="{{ asset('storage/app/public/' . $image) }}" width="100px" class="me-2 mb-2">
                        @endforeach
                    </div>
                @endif
    
                {{-- ADMIN-ONLY FIELDS --}}
                <div class="col-md-3 mt-4">
                    <label for="is_sold" class="form-label d-block">فروخت شدہ</label>
                    <input type="hidden" name="is_sold" value="0">
                    <input type="checkbox" name="is_sold" value="1" {{ $listing->is_sold ? 'checked' : '' }}>
                </div>
    
                <div class="col-md-3 mt-4">
                    <label for="is_featured" class="form-label d-block">نمایاں</label>
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ $listing->is_featured ? 'checked' : '' }}>
                </div>
    
                <div class="col-md-3 mt-4" id="featured_until_div" style="{{ $listing->is_featured ? '' : 'display:none' }}">
                    <label for="featured_until" class="form-label">نمایاں ختم ہونے کی تاریخ</label>
                    <input type="date" name="featured_until" class="form-control"
                        value="{{ $listing->featured_until ? \Carbon\Carbon::parse($listing->featured_until)->toDateString() : '' }}">
                </div>
    
                <div class="col-md-3 mt-4">
                    <label for="verified" class="form-label d-block">تصدیق شدہ</label>
                    <input type="hidden" name="verified" value="0">
                    <input type="checkbox" name="verified" value="1" {{ $listing->verified ? 'checked' : '' }}>
                </div>
    
                <div class="col-md-3 mt-4">
                    <label for="warrenty" class="form-label d-block">وارنٹی</label>
                    <input type="hidden" name="warrenty" value="0">
                    <input type="checkbox" name="warrenty" value="1" {{ $listing->warrenty ? 'checked' : '' }}>
                </div>
    
                <div class="col-md-12 mt-4">
                    <button type="submit" class="btn btn-primary w-100">اپ ڈیٹ کریں</button>
                </div>
    
            </div>
        </div>
    </form>

  </div>
</div>
        
    </div>


    <script>

    document.getElementById('is_featured').addEventListener('change', function () {
        const featuredDiv = document.getElementById('featured_until_div');
        featuredDiv.style.display = this.checked ? '' : 'none';
    });
</script>

@endsection