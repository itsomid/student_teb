@extends('dashboard.layout.master')
@section('title', 'تغییر رمز عبور دانشجو')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">تغییر رمز عبور دانشجو: {{ $student->name }}</h5>
            <div class="mb-3">
                <small class="text-muted">شماره تماس: {{ $student->mobile }}</small>
            </div>
            
            <form action="{{ route('admin.student.change-password.update', ['student' => $student->id]) }}" method="post">
                @csrf
                @method('PATCH')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">رمز عبور جدید <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="رمز عبور جدید را وارد کنید"
                                       required
                                       minlength="8">
                                <span class="input-group-text cursor-pointer" id="password-toggle">
                                    <i class="fa-solid fa-eye-slash" id="password-icon"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">رمز عبور باید حداقل 8 کاراکتر باشد</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label">تکرار رمز عبور جدید <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="رمز عبور جدید را مجدداً وارد کنید"
                                       required
                                       minlength="8">
                                <span class="input-group-text cursor-pointer" id="password-confirmation-toggle">
                                    <i class="fa-solid fa-eye-slash" id="password-confirmation-icon"></i>
                                </span>
                            </div>
                            <small class="text-muted">رمز عبور باید با فیلد بالا مطابقت داشته باشد</small>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info" role="alert">
                            <i class="fa-solid fa-info-circle me-2"></i>
                            <strong>توجه:</strong> پس از تغییر رمز عبور، کاربر باید با رمز عبور جدید وارد شود.
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.student.index') }}" class="btn btn-secondary">
                                <i class="fa-solid fa-arrow-right me-1"></i>
                                بازگشت
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-save me-1"></i>
                                تغییر رمز عبور
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('vendor-script')
<script>
    // Toggle password visibility
    document.getElementById('password-toggle').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        } else {
            passwordField.type = 'password';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        }
    });
    
    // Toggle password confirmation visibility
    document.getElementById('password-confirmation-toggle').addEventListener('click', function() {
        const passwordConfirmationField = document.getElementById('password_confirmation');
        const passwordConfirmationIcon = document.getElementById('password-confirmation-icon');
        
        if (passwordConfirmationField.type === 'password') {
            passwordConfirmationField.type = 'text';
            passwordConfirmationIcon.classList.remove('fa-eye-slash');
            passwordConfirmationIcon.classList.add('fa-eye');
        } else {
            passwordConfirmationField.type = 'password';
            passwordConfirmationIcon.classList.remove('fa-eye');
            passwordConfirmationIcon.classList.add('fa-eye-slash');
        }
    });
    
    // Real-time password confirmation validation
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const passwordConfirmation = this.value;
        
        if (passwordConfirmation && password !== passwordConfirmation) {
            this.classList.add('is-invalid');
            if (!this.nextElementSibling || !this.nextElementSibling.classList.contains('invalid-feedback')) {
                const feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                feedback.textContent = 'رمز عبور مطابقت ندارد';
                this.parentNode.insertBefore(feedback, this.nextElementSibling);
            }
        } else {
            this.classList.remove('is-invalid');
            const feedback = this.parentNode.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.remove();
            }
        }
    });
</script>
@endsection