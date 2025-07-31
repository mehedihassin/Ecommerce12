@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="login-register container">
            <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore active" id="login-tab" data-bs-toggle="tab" href="#tab-item-login"
                        role="tab" aria-controls="tab-item-login" aria-selected="true">Login</a>
                </li>
            </ul>
            <div class="tab-content pt-2" id="login_register_tab_content">
                <div class="tab-pane fade show active" id="tab-item-login" role="tabpanel" aria-labelledby="login-tab">
                    <div class="login-form">
                        <form method="POST" action="{{ route('login') }}" name="login-form" class="needs-validation"
                            novalidate="">
                            @csrf
                            <div class="form-floating mb-3">
                                <input id="login" type="text"
                                    class="form-control @error('login') is-invalid @enderror" name="login"
                                    value="{{ old('login') }}" required autocomplete="login" autofocus>
                                <label for="login">Email or Phone *</label>

                                @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="pb-3"></div>
                            <div class="form-floating mb-3 position-relative">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">
                                <label for="password">Password *</label>

                                <!-- Text toggle -->
                                <span class="position-absolute top-50 end-0 translate-middle-y me-3"
                                    style="cursor: pointer; font-size: 14px; color: #007bff;" onclick="togglePasswordText()"
                                    id="toggleText">
                                    Show
                                </span>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>



                            <button class="btn btn-primary w-100 text-uppercase" type="submit">Log In</button>

                            <div class="customer-option mt-4 text-center">
                                <span class="text-secondary">No account yet?</span>
                                <a href="{{ route('register') }}" class="btn-text js-show-register">Create Account</a> | <a
                                    href="my-account.html" class="btn-text js-show-register">My Account</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection


@push('scripts')
    <script>
        function togglePasswordText() {
            const passwordInput = document.getElementById("password");
            const toggle = document.getElementById("toggleText");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggle.textContent = "Hide";
            } else {
                passwordInput.type = "password";
                toggle.textContent = "Show";
            }
        }
    </script>
@endpush
