@extends('auth.layout.master')
@section('title', 'ورود به پنل ادمین')
@section('content')
    <div class="medical-auth-container">
        <!-- Medical Background -->
        <div class="medical-background">
            <img src="{{ asset('assets/images/medical-bg.svg') }}" alt="Medical Background" class="bg-image">
        </div>

        <!-- Login Form Container -->
        <div class="auth-card">
            <!-- Logo Section -->
            <div class="logo-section">
                <div class="logo-container">
                    <img src="{{ asset('assets/images/logos/logo.png') }}" alt="شفا‌آموز" class="main-logo">
                </div>
                <h1 class="system-title">سیستم مدیریت آموزش پزشکی</h1>
                <h2 class="welcome-title">ورود به پنل ادمین شفا‌آموز</h2>
            </div>

            <!-- Alert Section -->
            @if (session('status'))
                <div class="alert-message error-alert">
                    <i class="alert-icon">⚠</i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Form Section -->
            <form class="login-form" action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Username Field -->
                <div class="input-group d-block">
                    <label for="username" class="input-label">
                        <i class="label-icon">📱</i>
                        شماره موبایل
                    </label>
                    <div class="input-wrapper">
                        <input type="text" class="form-input" id="username" name="username" placeholder="09xxxxxxxxx"
                            autocomplete="username" value="{{ $defaultUsername }}" required autofocus>
                        <div class="input-border"></div>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="input-group d-block">
                    <label for="password" class="input-label">
                        <i class="label-icon">🔒</i>
                        رمز عبور
                    </label>
                    <div class="input-wrapper password-wrapper">
                        <input type="password" class="form-input" id="password" name="password"
                            placeholder="رمز عبور خود را وارد کنید" value="{{ $defaultPassword }}" required>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="eye-icon" id="eyeIcon">👁</i>
                        </button>
                        <div class="input-border"></div>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="form-options">
                    <label class="checkbox-container">
                        <input type="checkbox" id="remember-me" class="checkbox-input">
                        <span class="checkbox-custom"></span>
                        <span class="checkbox-label">مرا به خاطر بسپار</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">
                    <span class="btn-text">ورود به سیستم</span>
                    <i class="btn-icon">→</i>
                </button>
            </form>

            <!-- Helper Links -->
            <div class="helper-links">
                <a href="#" class="helper-link forgot-password">
                    <i class="link-icon">🔑</i>
                    فراموشی رمز عبور
                </a>
                <a href="#" class="helper-link new-user">
                    <i class="link-icon">👤</i>
                    ثبت‌نام کاربر جدید
                </a>
            </div>

            <!-- Footer -->
            <div class="auth-footer">
                <p class="footer-text">سیستم مدیریت یادگیری شفا‌آموز</p>
                <p class="footer-subtitle">پلتفرم آموزش پزشکی نوین</p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                eyeIcon.textContent = '👁';
            }
        }

        // Add floating animation to form
        document.addEventListener('DOMContentLoaded', function() {
            const authCard = document.querySelector('.auth-card');
            authCard.style.animation = 'fadeInUp 0.8s ease-out';
        });
    </script>
@endsection
