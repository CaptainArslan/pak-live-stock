@extends('layouts.app')
@section('title', 'Post Ads - Pak Livestock')
<style>
.rtl-form .form-label {
    font-weight: bold;
    text-align: right;
    display: block;
}

#preview .position-relative {
    margin: 5px;
}

.badge.bg-danger {
    font-size: 14px;
    padding: 5px 8px;
}

.rtl-form .form-control,
.rtl-form .form-select {
    border-radius: 0.5rem;
}
#preview > div {
    position: relative;
    display: inline-block;
    margin: 5px;
  }
  #preview img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #ddd;
  }
  #preview span.remove-btn {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #dc3545;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-weight: bold;
    cursor: pointer;
    user-select: none;
    font-size: 16px;
    line-height: 1;
  }

</style>

@section('content')
<div class="container">

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('phone-user.updateByUser', $listing->id) }}" method="POST" enctype="multipart/form-data" dir="rtl" class="rtl-form" >
        @csrf
        @method('PUT')
        <div class="container" id="livestockForm">
            {{-- STEP 1 --}}
            <div class="step card shadow-lg p-4 mb-4 border-0 rounded-4" data-step="1" style="display:block;">
                <h5 class="fw-bold mb-4 border-bottom pb-2">مرحلہ 1</h5>
                <div class="row g-3">
                    <div class="col-md-6 col-sm-12">
                        <label class="form-label">قسم 
                            <span class="text-danger">*</span></label>
                        <select name="category_id" id="category-select" class="form-select" disabled>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $listing->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="category_id" value="{{ $listing->category_id }}">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label>نسل</label>
                            <select class="form-control" disabled id="breed-select">
                                @foreach($breeds as $breed)
                                    <option value="{{ $breed->id }}" {{ $listing->breed_id == $breed->id ? 'selected' : '' }}>
                                        {{ $breed->name }}
                                    </option>
                                @endforeach
                            </select>
                            <!-- Hidden input to submit value -->
                            <input type="hidden" name="breed_id" value="{{ $listing->breed_id }}">
                        </div>
                    </div>
                    
                    <div id="quantityForsheep" class="col-md-6 col-sm-12">
                        <label class="form-label">تعداد 
                            <span class="text-danger">*</span></label>
                        <input type="number" id="quantity" name="quantity" value="{{$listing->quantity}}" class="form-control" min="1" placeholder="تعداد درج کریں">
                    </div>
                    
                    <div id="gender" class="col-md-6 col-sm-12">
                        <label class="form-label">جنس 
                            <span class="text-danger">*</span></label>
                        <select name="gender" class="form-select">
                            <option value="male" {{ $listing->gender == 'male' ? 'selected' : '' }}>نر</option>
                            <option value="female" {{ $listing->gender == 'female' ? 'selected' : '' }}> مادہ</option>
                            <option value="both" {{ $listing->gender == 'both' ? 'selected' : '' }} id="mixJanwar">دونوں</option>
                        </select>
                    </div>
                    
                    <div id="singlePrice" class="col-12 col-md-6 col-lg-6">
                        <label class="form-label d-block mb-2">قیمت منتخب کریں 
                            <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group mb-3 gap-2" role="group" aria-label="Price Type">
                                    <input type="radio" class="btn-check" name="price_type" id="priceTab" value="price" checked>
                                    <label class="btn btn-primary" for="priceTab"> قیمت</label>
                        
                                    <input type="hidden" name="rate_on_call" value="0">
                                    <input type="checkbox" class="btn-check rate_on_call_1" name="rate_on_call" value="1" {{ $listing->rate_on_call ? 'checked' : '' }} id="priceOnCall">
                                    <label class="btn btn-primary" for="priceOnCall">قیمت فون پر</label>

                                </div>
                            </div>
                        
                            <div class="col-md-6">
                                <div id="priceInput" class="price-input">
                                    <input type="number" value="{{ $listing->price }}" name="price" class="form-control" placeholder=" قیمت" >
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="priceFields" class="col-12 col-md-6 col-lg-6">
                        <label class="form-label d-block mb-2">قیمت منتخب کریں 
                            <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group mb-3 gap-2" role="group" aria-label="Price Type">
                                    <input type="radio" class="btn-check" name="price_type" id="totalPriceTab" value="total" >
                                    <label class="btn btn-primary" for="totalPriceTab">کل قیمت</label>
                        
                                    <input type="radio" class="btn-check" name="price_type" id="pricePerAnimalTab" value="animal">
                                    <label class="btn btn-primary" for="pricePerAnimalTab">فی پرندہ </label>
                                    
                                    <input type="checkbox" class="btn-check rate_on_call_2" value="1" {{ $listing->rate_on_call ? 'checked' : '' }} id="priceOnCall">
                                    <label class="btn btn-primary" for="priceOnCall">قیمت فون پر </label>

                        
                                </div>
                            </div>
                        
                            <div class="col-md-6">
                                <div id="totalPriceInput" class="price-input" >
                                    <input type="number" value="{{ old('total_price', $listing->total_price) }}" name="total_price" class="form-control" placeholder="کل قیمت">
                                </div>
                        
                                <div id="pricePerAnimalInput" class="price-input" style="display: none;">
                                    <input type="number" value="{{ old('price_per_animal', $listing->price_per_animal) }}" name="price_per_animal" class="form-control" placeholder="فی پرندہ">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="singleAge" class="col-md-6 col-sm-12">
                        <label class="form-label">عمر 
                            <span class="text-danger">*</span></label>
                        <div class="d-flex gap-2">
                            <select name="age_years" id="age_years" class="form-select" required>
                                <option value=""> سال منتخب کریں </option>
                                @for ($i = 0; $i <= 15; $i++)
                                    <option value="{{ $i }}" {{ old('age_years', $listing->age_years) == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
        
                            </select>
                            <select name="age_months" id="age_months" class="form-select" required>
                                <option value=""> مہینے منتخب کریں </option>
                                @for ($i = 1; $i <= 11; $i++)
                                    <option value="{{ $i }}" {{ old('age_months', $listing->age_months) == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
        
                            </select>
                        </div>
                    </div>
                    
                    <div id="ageFields" class="col-lg-12" style="display: none;">
                        <label class="form-label">عمر 
                            <span class="text-danger">*</span></label>
                        <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                            
                                    <label class="form-label"> کم سے کم سال </label>
                                    <select name="min_age_years" id="min_age_years" class="form-select" required>
                                        <option value=""> سال منتخب کریں </option>
                                        @for ($i = 0; $i <= 15; $i++)
                                            <option value="{{ $i }}" {{ (old('min_age_years', $listing->min_age_years ?? '') == $i) ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label class="form-label"> کم سے کم مہینے </label>
                                    <select name="min_age_months" id="min_age_months" class="form-select" required>
                                        <option value=""> مہینے منتخب کریں </option>
                                        @for ($i = 1; $i <= 11; $i++)
                                            <option value="{{ $i }}" {{ (old('min_age_months', $listing->min_age_months ?? '') == $i) ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                
                                    </select>
                                </div>  
                                <span id="ageYearsError" style="color:red; display:none;"> زیادہ سے زیادہ عمر کم سے کم عمر سے زیادہ یا اس کے برابر ہونے چاہئیں </span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="row">
                                
                                <div class="col-md-6 col-sm-12">
                                    
                                    <label class="form-label"> زیادہ سے زیادہ سال </label>
                                    <select name="max_age_years" id="max_age_years" class="form-select" required>
                                        <option value=""> سال منتخب کریں </option>
                                        @for ($i = 0; $i <= 15; $i++)
                                            <option value="{{ $i }}" {{ (old('max_age_years', $listing->max_age_years ?? '') == $i) ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                        
                                    <label class="form-label"> زیادہ سے زیادہ مہینے </label>
                                    <select name="max_age_months" id="max_age_months" class="form-select" required>
                                        <option value=""> مہینے منتخب کریں </option>
                                        @for ($i = 1; $i <= 11; $i++)
                                            <option value="{{ $i }}" {{ (old('max_age_months', $listing->max_age_months ?? '') == $i) ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                
                                    </select>
                                </div>  
                            </div>
                        </div>
                        </div>
                    </div>
                    
                </div>
            </div>
    
            {{-- STEP 2 --}}
            <div class="step card shadow-lg p-4 mb-4 border-0 rounded-4" data-step="2" style="display:none;">
                        <h5 class="fw-bold mb-4 border-bottom pb-2">مرحلہ 2</h5>
                        <div class="row g-3">

                            <div class="col-md-6 col-sm-12">
                                <label class="form-label">صوبہ
                                <span class="text-danger">*</span></label>
                                <select id="province" name="province" class="form-select" required>
                                    <option value="">صوبہ منتخب کریں</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->name }}"
                                            {{ old('province', $listing->province ?? '') == $province->name ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="col-md-6 col-sm-12">
                                <label class="form-label">شہر
                                <span class="text-danger">*</span></label>
                                <select name="city" id="city" class="form-select" required>
                                    <option value="{{ old('city', $listing->city ?? '') }}">
                                        {{ old('city', $listing->city ?? 'پہلے صوبہ منتخب کریں') }}
                                    </option>
                                </select>
                            </div>
                        
                            <div class="col-md-6 col-sm-12">
                                <label class="form-label">پتہ
                                <span class="text-danger">*</span></label>
                                <input type="text" name="address" class="form-control" required
                                       value="{{ old('address', $listing->address ?? '') }}">
                            </div>
                        
                            <div class="col-md-6 col-sm-12">
                                <label class="form-label">رابطہ نمبر
                                <span class="text-danger">*</span></label>
                                <input type="number" name="contact_number" class="form-control" required min="0"
                                       style="direction:ltr" value="{{ old('contact_number', $listing->contact_number ?? '') }}">
                            </div>
                        
                            <div class="col-md-6 col-sm-12">
                                <label class="form-label d-block">تصاویر
                                <span class="text-danger">*</span></label>
                            
                                {{-- Image preview container --}}
                                <div id="preview" class="d-flex flex-wrap gap-2 mb-2">
                                    @php
                                        $existingImages = is_array($listing->images) ? $listing->images : json_decode($listing->images, true);
                                    @endphp
                            
                                    @if($existingImages)
                                        @foreach($existingImages as $image)
                                            <div class="existing-image">
                                                <img src="{{ Storage::url($image) }}" alt="image"
                                                     style="width: 70px; height: 70px; object-fit: cover; border: 1px solid #ccc; border-radius: 4px;">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            
                                {{-- Hidden file input --}}
                                <input type="file" id="image-input" name="images[]" multiple accept=".png, .jpg, .jpeg" style="display: none;">
                            
                                {{-- Upload button --}}
                                <button type="button" id="upload-trigger"
                                        class="btn btn-primary d-flex align-items-center justify-content-center" style="width: 50px;">
                                    <i class="bi bi-images"></i>
                                </button>
                            
                                <small class="form-text text-muted mt-3">
                                    آپ صرف وہی تصاویر اپلوڈ کر سکتے ہیں جو PNG، JPEG یا JPG فارمیٹ میں ہوں اور جن کا سائز 2 ایم بی تک ہو۔
                                </small>
                            </div>
                            
                            <script>
                                document.getElementById("image-input").addEventListener("change", function () {
                                    const maxSizeMB = 2.5;
                                    const maxSizeBytes = maxSizeMB * 1024 * 1024;
                                    const files = this.files;

                                    for (let file of files) {
                                    if (file.size > maxSizeBytes) {
                                        alert(`File "${file.name}" exceeds ${maxSizeMB}MB limit.`);
                                        this.value = ''; // Clear input
                                        break;
                                    }
                                    }
                                });
                            </script>
                        
                            <div class="col-md-12">
                                <label class="form-label">تفصیل</label>
                                <textarea name="detail" class="form-control" rows="4">{{ old('detail', $listing->detail ?? '') }}</textarea>
                            </div>
                        
                        </div>

                        <input type="hidden" name="is_featured" value="0">
                    </div>
    
            {{-- Navigation Buttons --}}
            <div class="form-navigation text-center mt-4">
                <button type="button" class="previous btn btn-outline-secondary rounded-pill px-4 py-2 me-2" style="display:none;">پچھلا</button>
                <button type="button" class="next btn btn-primary rounded-pill px-4 py-2">اگلا</button>
                <button type="submit" class="submit btn btn-success rounded-pill px-4 py-2" style="display:none;" > اپ ڈیٹ کریں </button>
            </div>
        </div>
    </form>

    
    {{-- Script --}}
    <script>
        
        document.addEventListener('DOMContentLoaded', function () {
            let currentStep = 1;
            const steps = document.querySelectorAll('.step');
            const totalSteps = steps.length;
        
            function showStep(step) {
                steps.forEach((el, index) => {
                    el.style.display = (index + 1 === step) ? 'block' : 'none';
                });
        
                document.querySelector('.previous').style.display = step > 1 ? 'inline-block' : 'none';
                document.querySelector('.next').style.display = step < totalSteps ? 'inline-block' : 'none';
                document.querySelector('.submit').style.display = step === totalSteps ? 'inline-block' : 'none';
            }
        
            function validateStep(step) {
                const inputs = steps[step - 1].querySelectorAll('input[required], select[required], textarea[required]');
                let isValid = true;
        
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.classList.add('error');
                        input.reportValidity();
                        isValid = false;
                    } else {
                        input.classList.remove('error');
                    }
                });
        
                const visibleErrors = steps[step - 1].querySelectorAll('span[style*="display: inline"]');
                if (visibleErrors.length > 0) {
                    isValid = false;
                }
        
                return isValid;
            }
        
            document.querySelector('.next').addEventListener('click', function () {
                if (validateStep(currentStep) && currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                } else {
                    alert('براہ کرم تمام مطلوبہ فیلڈز درست طریقے سے پُر کریں۔');
                }
            });
        
            document.querySelector('.previous').addEventListener('click', function () {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
        
            showStep(currentStep);
        });
        
         document.addEventListener("DOMContentLoaded", function () {
            const categorySelect = document.getElementById("category-select");
            const container = document.getElementById("livestockForm");
            const quantityMustOne = document.getElementById("quantity");
        
            categorySelect.addEventListener("change", function () {
                const elements = container.querySelectorAll("input, select, textarea");
        
                elements.forEach(el => {
                    if (el === categorySelect) return;
        
                    if (el === quantityMustOne) {
                        el.value = '1';
                        return;
                    }
        
                    switch (el.type) {
                        case 'text':
                        case 'textarea':
                        case 'number':
                            el.value = '';
                            break;
                        case 'select-one':
                        case 'select-multiple':
                            el.selectedIndex = 0;
                            break;
                        case 'checkbox':
                        case 'radio':
                            el.checked = false;
                            break;
                        default:
                            el.value = '';
                    }
                });
            });
        });
    
        document.addEventListener("DOMContentLoaded", function () {
                const quantityInput = document.getElementById('quantity');
                const ageFields = document.getElementById('ageFields');
                const priceFields = document.getElementById('priceFields');
                const singleAge = document.getElementById('singleAge');
                const singlePrice = document.getElementById('singlePrice');
                const mixJanwar = document.getElementById('mixJanwar');
                const categorySelect = document.getElementById('category-select');
                
        
            let selectedCategoryId = parseInt(categorySelect?.value ?? 0);
        
            categorySelect.addEventListener('change', function () {
                selectedCategoryId = parseInt(categorySelect.value);
                updateFields();
            });
        
            quantityInput.addEventListener('input', updateFields);
        
            quantityInput.addEventListener('input', function () {
                if (this.value === '' || parseInt(this.value) < 1) {
                    this.value = 1;
                }
            });
        
            function updateFields() {
                const quantity = parseInt(quantityInput.value);
        
                if (quantity > 1) {
                    priceFields.style.display = 'block';
                    singlePrice.style.display = 'none';
                    mixJanwar.style.display = 'block';
                } else {
                    priceFields.style.display = 'none';
                    singlePrice.style.display = 'block';
                    mixJanwar.style.display = 'none';
                }
            }
        
            updateFields();
        });
    
        document.getElementById('category-select').addEventListener('change', function() {
            let categoryId = this.value;
            let breedSelect = document.getElementById('breed-select');
    
            if (categoryId) {
                fetch(`/breeds/by-category/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        breedSelect.innerHTML = '<option value="">منتخب کریں</option>';
                        if (data.length > 0) {
                            data.forEach(breed => {
                                breedSelect.innerHTML += `<option value="${breed.id}">${breed.name}</option>`;
                            });
                        } else {
                            breedSelect.innerHTML = '<option value="">پہلے قسم کا انتخاب کریں۔</option>';
                        }
                    })
                    .catch(error => console.error('Error fetching breeds:', error));
            } else {
                breedSelect.innerHTML = '<option value="">پہلے قسم کا انتخاب کریں۔</option>';
            }
        });
    
        document.getElementById('province').addEventListener('change', function() {
            let provinceName = this.value;
            let citySelect = document.getElementById('city');
    
            if (provinceName) {
                fetch(`/get-cities/${provinceName}`)
                    .then(response => response.json())
                    .then(data => {
                        citySelect.innerHTML = '<option value="">شہر منتخب کریں</option>';
                        if (data.length > 0) {
                            data.forEach(city => {
                                citySelect.innerHTML += `<option value="${city.name}">${city.name}</option>`;
                            });
                        } else {
                            citySelect.innerHTML = '<option value="">کوئی شہر نہیں ملا</option>';
                        }
                    })
                    .catch(error => console.error('Error fetching cities:', error));
            } else {
                citySelect.innerHTML = '<option value="">پہلے صوبہ منتخب کریں</option>';
            }
        });
        
    
       document.addEventListener("DOMContentLoaded", function () {
        const radioButtons = document.querySelectorAll('input[name="price_type"]');
        const priceInputs = {
            total: document.getElementById("totalPriceInput"),
            price: document.getElementById("priceInput"),
            animal: document.getElementById("pricePerAnimalInput")
        };
    
        const rateOnCallCheckbox = document.getElementById("priceOnCall");
    
        function updatePriceInput(selected) {
            for (const [key, element] of Object.entries(priceInputs)) {
                element.style.display = key === selected ? "block" : "none";
            }
        }
    
        function handleRateOnCallToggle() {
            const isChecked = rateOnCallCheckbox.checked;
    
            // Disable or enable price_type radios
            radioButtons.forEach(radio => {
                radio.disabled = isChecked;
            });
    
            // Hide or show price inputs
            if (isChecked) {
                for (const element of Object.values(priceInputs)) {
                    element.style.display = "none";
                }
            } else {
                const selected = document.querySelector('input[name="price_type"]:checked');
                if (selected) updatePriceInput(selected.value);
            }
        }
    
        // Attach listeners
        radioButtons.forEach(radio => {
            radio.addEventListener("change", function () {
                updatePriceInput(this.value);
            });
        });
    
        if (rateOnCallCheckbox) {
            rateOnCallCheckbox.addEventListener("change", handleRateOnCallToggle);
        }
    
        // Initial load
        const initialRadio = document.querySelector('input[name="price_type"]:checked');
        if (initialRadio) updatePriceInput(initialRadio.value);
        handleRateOnCallToggle();
    });
    
        
        
    let allFiles = [];
    
    document.addEventListener('DOMContentLoaded', function () {
        const imageInput = document.getElementById('image-input');
        const triggerBtn = document.getElementById('upload-trigger');
        const preview = document.getElementById('preview');
    
        triggerBtn.addEventListener('click', () => imageInput.click());
    
        imageInput.addEventListener('change', function () {
            Array.from(this.files).forEach(file => {
                allFiles.push(file);
    
                // Wrapper for image + remove button
                const wrapper = document.createElement('div');
                wrapper.style.position = 'relative';
                wrapper.style.display = 'inline-block';
                wrapper.style.marginRight = '10px';
    
                // Image preview
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                img.className = 'img-thumbnail';
    
                // Remove button
                const removeBtn = document.createElement('span');
                removeBtn.textContent = '×';
                removeBtn.style.position = 'absolute';
                removeBtn.style.top = '0';
                removeBtn.style.right = '0';
                removeBtn.style.background = 'red';
                removeBtn.style.color = 'white';
                removeBtn.style.borderRadius = '50%';
                removeBtn.style.cursor = 'pointer';
                removeBtn.style.padding = '2px 6px';
                removeBtn.title = 'Remove this image';
    
                removeBtn.addEventListener('click', () => {
                    // Remove from allFiles by identity
                    allFiles = allFiles.filter(f => f !== file);
                    wrapper.remove();
                    refreshFileInput();
                });
    
                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);
                preview.appendChild(wrapper);
            });
    
            refreshFileInput();
        });
    
        function refreshFileInput() {
            const dt = new DataTransfer();
            allFiles.forEach(file => dt.items.add(file));
            imageInput.files = dt.files;
        }
    });
    
    </script>
    <script>
    function validateAgeFields() {
        const minYears = document.getElementById('min_age_years');
        const maxYears = document.getElementById('max_age_years');
        const minMonths = document.getElementById('min_age_months');
        const maxMonths = document.getElementById('max_age_months');
        const yearError = document.getElementById('ageYearsError');
        const monthError = document.getElementById('ageMonthsError');
    
        function checkAgeValidity() {
            const minY = parseInt(minYears.value) || 0;
            const maxY = parseInt(maxYears.value) || 0;
            const minM = parseInt(minMonths.value) || 0;
            const maxM = parseInt(maxMonths.value) || 0;
    
            const minTotalMonths = minY * 12 + minM;
            const maxTotalMonths = maxY * 12 + maxM;
    
            if (maxTotalMonths < minTotalMonths) {
                yearError.style.display = 'inline';
                monthError.style.display = 'inline';
                maxYears.classList.add('is-invalid');
                maxMonths.classList.add('is-invalid');
            } else {
                yearError.style.display = 'none';
                monthError.style.display = 'none';
                maxYears.classList.remove('is-invalid');
                maxMonths.classList.remove('is-invalid');
            }
        }
    
        // Attach change listeners
        [minYears, maxYears, minMonths, maxMonths].forEach(el => {
            if (el) el.addEventListener('change', checkAgeValidity);
        });
    }
    
    // Call the age validation
    validateAgeFields();
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const quantityInput = document.getElementById("quantity"); // Your quantity input field
        const singleAgeFields = ["age_years", "age_months"];
        const multiAgeFields = ["min_age_years", "min_age_months", "max_age_years", "max_age_months"];
    
        function updateAgeFieldsRequirement() {
            const quantity = parseInt(quantityInput.value) || 0;
    
            if (quantity > 1) {
                // Show multi-age, hide single age
                document.getElementById("ageFields").style.display = "block";
                document.getElementById("singleAge").style.display = "none";
    
                // Remove required from single
                singleAgeFields.forEach(id => {
                    document.getElementById(id).removeAttribute("required");
                });
    
                // Add required to multi
                multiAgeFields.forEach(id => {
                    document.getElementById(id).setAttribute("required", "required");
                });
    
            } else {
                // Show single age, hide multi age
                document.getElementById("ageFields").style.display = "none";
                document.getElementById("singleAge").style.display = "block";
    
                // Add required to single
                singleAgeFields.forEach(id => {
                    document.getElementById(id).setAttribute("required", "required");
                });
    
                // Remove required from multi
                multiAgeFields.forEach(id => {
                    document.getElementById(id).removeAttribute("required");
                });
            }
        }
    
        // Initial check on page load
        updateAgeFieldsRequirement();
    
        // Update on quantity change
        quantityInput.addEventListener("input", updateAgeFieldsRequirement);
    });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const quantityInput = document.getElementById('quantity');
        const priceInput = document.querySelector('input[name="price"]');
        const totalPriceInput = document.querySelector('input[name="total_price"]');
        const pricePerAnimalInput = document.querySelector('input[name="price_per_animal"]');
        const rateOnCallCheckboxes = document.querySelectorAll('input[name="rate_on_call"]');
        const totalPriceTab = document.getElementById('totalPriceTab');
    
        function updatePriceValidation() {
            const quantity = parseInt(quantityInput?.value) || 0;
            const rateOnCall = Array.from(rateOnCallCheckboxes).some(cb => cb.checked);
    
            // Reset all required attributes first
            priceInput?.removeAttribute('required');
            totalPriceInput?.removeAttribute('required');
            pricePerAnimalInput?.removeAttribute('required');
    
            if (rateOnCall) return; // skip if rate_on_call is checked
    
            if (quantity === 1) {
                priceInput?.setAttribute('required', 'required');
            } else if (quantity > 1) {
                const selectedPriceType = document.querySelector('input[name="price_type"]:checked')?.value;
                if (selectedPriceType === 'total') {
                    totalPriceInput?.setAttribute('required', 'required');
                    totalPriceInput.style.display="block"
                } else if (selectedPriceType === 'animal') {
                    pricePerAnimalInput?.setAttribute('required', 'required');
                }
            }
        }
    
        // Bind on input changes
        quantityInput?.addEventListener('input', updatePriceValidation);
        document.querySelectorAll('input[name="price_type"]').forEach(el => {
            el.addEventListener('change', updatePriceValidation);
        });
        rateOnCallCheckboxes.forEach(el => {
            el.addEventListener('change', updatePriceValidation);
        });
    
        updatePriceValidation(); // initial call
    });
    </script>
    
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const cb1 = document.querySelector('.rate_on_call_1');
    const cb2 = document.querySelector('.rate_on_call_2');
    const hidden = document.getElementById('rate_on_call');

    function updateRateValue() {
      hidden.value = (cb1.checked || cb2.checked) ? '1' : '0';
    }

    // Set initial value
    updateRateValue();

    // Update on checkbox change
    cb1.addEventListener('change', updateRateValue);
    cb2.addEventListener('change', updateRateValue);
  });
</script>



</div>
@endsection
