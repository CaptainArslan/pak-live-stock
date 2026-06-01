@extends('layouts.app')
@section('title', 'Instructions - Pak Livestock')
@section('content')


<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <div class="card shadow-lg border-0 rounded-4" style="max-width: 800px; width: 100%; background-color: #ffffff;">
    <div class="text-center mt-4">
      <img src="{{ asset('/assets/images/logo.webp') }}" alt="Pak Livestock Logo" style="width: 120px;">
    </div>
    <div class="card-body text-end" style="direction: rtl; padding: 2rem;">
      <h2 class="fw-bold mb-4" style="font-size: 2rem; color: #004614;">اپنے اشتہار کو نمایاں کیسے بنائیں؟</h2>
        <ul class="list-unstyled" style="font-size: 1.3rem; line-height: 2;">
            <li>  اب <strong>Pak Livestock</strong> پر آپ جتنے چاہیں <strong>مفت اشتہار</strong> لگا سکتے ہیں — کوئی حد نہیں!</li>
            <li> اگر آپ چاہتے ہیں کہ آپ کا اشتہار زیادہ نمایاں ہو؟ تو صرف <strong>100 روپے روزانہ</strong> میں Feature کریں!</li>
            <li>
               <strong>ادائیگی کا طریقہ:</strong><br>
              EasyPaisa نمبر: <strong style="direction: ltr">  03488333127</strong><br>
              اکاؤنٹ ہولڈر: <strong>Ameer Hamza</strong>
            </li>
            <li> ادائیگی کے بعد EasyPaisa کی رسید یا اسکرین شاٹ نیچے اپلوڈ کریں۔</li>
            <li> آپ کا اشتہار نمایاں کرنے کے لیے رسید کی تصدیق ضروری ہے۔</li>
        </ul>
        <div class="text-center mt-4">
          <button class="btn btn-success btn-lg rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#featureModal">
            ابھی اپنا اشتہار نمایاں کریں
          </button>
        </div>

    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="featureModal" tabindex="-1" aria-labelledby="featureModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 border-0">
      <div class="modal-header bg-success text-white" style="direction:rtl">
        <h5 class="modal-title" id="featureModalLabel" style="width:100%;">اشتہار نمایاں کریں</h5>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-end" dir="rtl">
        <form action="{{ route('featured.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

            <input type="hidden" name="listing_id" value="{{ $listing->id }}">
            <input type="hidden" name="user_id" value="{{ auth('phoneUser')->user()->id }}">

          <div class="mb-3">
            <label for="days" class="form-label fw-semibold">دنوں کی تعداد درج کریں:</label>
            <input type="number" name="days" id="days" class="form-control" min="1" required>
          </div>

          <div class="mb-3">
            <div id="calculatedRupees" class="bg-light border rounded p-3 text-center fw-bold" style="font-size: 1.5em;">
              کل رقم: 0 روپے
            </div>
            <input type="hidden" name="rupes" id="rupes">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">رسید اپلوڈ کریں:</label>
            <input type="file" class="form-control" name="receipt_image" required>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">رسید بھیجیں</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const daysInput = document.getElementById('days');
    const rupesInput = document.getElementById('rupes');
    const display = document.getElementById('calculatedRupees');
    const ratePerDay = 100;

    daysInput.addEventListener('input', function () {
        const days = parseInt(this.value) || 0;
        const total = days * ratePerDay;
        rupesInput.value = total;
        display.innerText = `کل رقم: ${total} روپے`;
    });
});
</script>






@endsection
