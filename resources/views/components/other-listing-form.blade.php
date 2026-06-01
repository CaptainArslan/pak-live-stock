<style>
.rtl-form .form-label {
    font-weight: bold;
    text-align: right;
    display: block;
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
<form action="{{ $route }}" method="POST" enctype="multipart/form-data" dir="rtl" class="rtl-form" >
    @csrf
    <input type="hidden" value="9" name="category_id">
    <div class="container" id="livestockForm">
        {{-- STEP 1 --}}
        <div class="step card shadow-lg p-4 mb-4 border-0 rounded-4" data-step="1" style="display:block;">
            <h5 class="fw-bold mb-4 border-bottom pb-2">مرحلہ 1</h5>
            <div class="row g-3">
                
                <div id="Title" class="col-md-6 col-sm-12">
                    <label class="form-label"> عنوان
                        <span class="text-danger">*</span> </label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="عنوان درج کریں" required>
                </div>
                
                <div id="quantityForsheep" class="col-md-6 col-sm-12">
                    <label class="form-label">تعداد<span class="text-danger">*</span></label>
                    <input type="number" id="quantity" name="quantity" value="1" class="form-control" min="1" placeholder="تعداد درج کریں" required>
                </div>
                
                <div id="singlePrice" class="col-12 col-md-6 col-lg-6">
                    <label class="form-label d-block mb-2">قیمت منتخب کریں
                        <span class="text-danger">*</span></label>
                    <input type="number" name="price" class="form-control" placeholder=" قیمت" required>
                </div>
                
                <div class="col-md-6 col-sm-12">
                    <label class="form-label d-block">تصاویر 
                        <span class="text-danger">*</span></label>
                
                    <div id="preview" class="d-flex flex-wrap gap-2 mb-2"></div>
                    <input type="file" id="image-input" name="images[]" multiple accept=".png, .jpg, .jpeg" style="display: none;" max="2536"/>
                    <button type="button" id="upload-trigger" class="btn btn-primary d-flex align-items-center justify-content-center" style="width: 50px;">
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
                    <textarea name="detail" class="form-control" rows="4"></textarea>
                </div>
            </div>
        </div>

        {{-- STEP 2 --}}
        <div class="step card shadow-lg p-4 mb-4 border-0 rounded-4" data-step="2" style="display:none;">
            <h5 class="fw-bold mb-4 border-bottom pb-2">مرحلہ 3</h5>
            <div class="row g-3">

                <div class="col-md-6 col-sm-12">
                    <label class="form-label">صوبہ <span class="text-danger">*</span></label>
                    <select id="province" name="province" class="form-select" required>
                        <option value="">صوبہ منتخب کریں</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->name }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 col-sm-12">
                    <label class="form-label">شہر <span class="text-danger">*</span></label>
                    <select name="city" id="city" class="form-select" required>
                        <option value="">پہلے صوبہ منتخب کریں</option>
                    </select>
                </div>

                <div class="col-md-6 col-sm-12">
                    <label class="form-label">پتہ <span class="text-danger">*</span></label>
                    <input type="text" name="address" class="form-control" required>
                </div>

                <div class="col-md-6 col-sm-12 col-sm-12">
                    <label class="form-label">رابطہ نمبر <span class="text-danger">*</span></label>
                    <input type="number" name="contact_number" class="form-control" required min="0" style="direction:ltr" required>
                </div>
            </div>
            <input type="hidden" name="is_featured" value="0">
        </div>

        {{-- Navigation Buttons --}}
        <div class="form-navigation text-center mt-4">
            <button type="button" class="previous btn btn-outline-secondary rounded-pill px-4 py-2 me-2" style="display:none;">پچھلا</button>
            <button type="button" class="next btn btn-primary rounded-pill px-4 py-2">اگلا</button>
            <button type="submit" class="submit btn btn-success rounded-pill px-4 py-2" style="display:none;" >+ اشتہار لگائیں</button>
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

    document.getElementById('province').addEventListener('change', function () {
        let provinceName = this.value;
        let citySelect = document.getElementById('city');
    
        if (provinceName) {
            fetch(`/get-cities/${provinceName}`)
                .then(response => response.json())
                .then(data => {
                    citySelect.innerHTML = '<option value="">شہر منتخب کریں</option>';
    
                    if (data.length > 0) {
                        // ✅ Sort city names using Urdu locale
                        data.sort((a, b) => a.name.localeCompare(b.name, 'ur'));
    
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


</script>
</div>
