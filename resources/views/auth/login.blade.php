<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $faviconPath = \App\Models\Setting::get('favicon', 'assets/images/favicon.png');
        $metaKeywords = \App\Models\Setting::get('meta_keywords', 'gym, fitness, membership, attendance, payments');
        $metaDescription = \App\Models\Setting::get('meta_description', 'Gym management system for memberships, attendance, and billing.');
        $metaAuthor = \App\Models\Setting::get('meta_author', 'Sky Fitness Gym');
    @endphp
    <meta name="keywords" content="{{ $metaKeywords }}">
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="author" content="{{ $metaAuthor }}">
    <link rel="icon" href="{{ asset('public/' . $faviconPath) }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('public/' . $faviconPath) }}" type="image/x-icon">
    <title>Apex Gym – Premium Gym Portal</title>

    <!-- Your existing styles + assets -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('public/assets/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/vendors/icofont.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/vendors/themify.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/vendors/flag-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/vendors/feather-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('public/assets/css/color-1.css') }}" media="screen">
    <link rel="stylesheet" href="{{ asset('public/assets/css/responsive.css') }}">

    <link href="{{ asset('public/assets/fontawesome/css/fontawesome.css')}}" rel="stylesheet" />
<link href="{{ asset('public/assets/fontawesome/css/brands.css')}}" rel="stylesheet" />
<link href="{{ asset('public/assets/fontawesome/css/solid.css')}}" rel="stylesheet" />
<link href="{{ asset('public/assets/fontawesome/css/sharp-thin.css')}}" rel="stylesheet" />
<link href="{{ asset('public/assets/fontawesome/css/sharp-duotone-thin.css')}}" rel="stylesheet" />
    @php
        $themePrimary = \App\Models\Setting::get('theme_primary', '#0f9b8e');
        $themeSecondary = \App\Models\Setting::get('theme_secondary', '#3a7bd5');
        $themeAccent = \App\Models\Setting::get('theme_accent', '#00d2ff');
        $loginHeadingColor = \App\Models\Setting::get('login_heading_color', '#ffffff');
        $barcodeEnabled = \App\Models\Setting::get('login_barcode_enabled', '1') === '1';
    @endphp
    <style>
        :root {
            --accent-1: {{ $themePrimary }};
            --accent-2: {{ $themeSecondary }};
            --accent-3: {{ $themeAccent }};
            --ink-1: #1e2330;
            --ink-2: #5b6375;
        }

        body {
            background: radial-gradient(1200px 600px at 10% 10%, rgba(0, 210, 255, 0.12), transparent 60%),
                        radial-gradient(900px 500px at 90% 10%, rgba(58, 123, 213, 0.12), transparent 55%),
                        linear-gradient(180deg, #f7f9fc 0%, #eef2f7 100%);
            min-height: 100vh;
        }

        .login-shell {
            position: relative;
            overflow: hidden;
        }

        .floating-shape {
            position: absolute;
            border-radius: 999px;
            filter: blur(0.5px);
            opacity: 0.18;
            animation: floaty 10s ease-in-out infinite;
        }

        .shape-1 {
            width: 180px;
            height: 180px;
            background: linear-gradient(135deg, var(--accent-2), var(--accent-3));
            top: 6%;
            left: 8%;
        }

        .shape-2 {
            width: 240px;
            height: 240px;
            background: linear-gradient(135deg, var(--accent-1), #7ef9ff);
            bottom: 8%;
            right: 12%;
            animation-delay: -3s;
        }

        .shape-3 {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #f1c27d, #f5853f);
            top: 55%;
            left: 45%;
            animation-delay: -6s;
        }

        @keyframes floaty {
            0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
            50% { transform: translateY(-12px) translateX(8px) rotate(2deg); }
        }

        .login-hero {
            position: relative;
            height: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 40px;
            background: linear-gradient(135deg, rgba(15, 155, 142, 0.1), rgba(58, 123, 213, 0.12));
        }

        .login-hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: url("{{ asset('public/assets/images/login/login_image.jpg') }}") center/cover no-repeat;
            opacity: 0.22;
            mix-blend-mode: multiply;
        }

        .login-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(12, 20, 32, 0.55), rgba(12, 20, 32, 0.25));
            z-index: 1;
        }

        .login-hero .hero-content {
            position: relative;
            z-index: 2;
            color: #fff;
            text-align: left;
            max-width: 520px;
            animation: fadeUp 0.8s ease both;
        }

        .login-hero h1 {
            font-size: 2.4rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 12px;
            text-shadow: 0 6px 20px rgba(0, 0, 0, 0.35);
            background: linear-gradient(90deg, var(--accent-2), var(--accent-1), var(--accent-3));
            -webkit-background-clip: text;
            background-clip: text;
            color: {{ $loginHeadingColor }};
        }

        .login-hero p {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, 0.92);
            margin-bottom: 22px;
            text-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
        }

        .login-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 999px;
            font-size: 0.85rem;
            margin-bottom: 18px;
            color: #ffffff;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        }

        .login-card {
            position: relative;
            padding: 36px 34px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            box-shadow: 0 25px 60px rgba(17, 24, 39, 0.18);
            animation: fadeUp 0.7s ease both;
        }

        .login-main h4 {
            color: var(--ink-1);
            font-weight: 700;
        }

        .login-main p {
            color: var(--ink-2);
        }

        .theme-form .form-control {
            border-radius: 12px;
            padding: 12px 14px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: none;
        }

        .theme-form .form-control:focus {
            border-color: var(--accent-2);
            box-shadow: 0 0 0 3px rgba(58, 123, 213, 0.15);
        }

        .btn-primary {
            border: none;
            border-radius: 14px;
            padding: 12px 16px;
            background: linear-gradient(90deg, var(--accent-1), var(--accent-2));
            box-shadow: 0 12px 24px rgba(15, 155, 142, 0.25);
            transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 28px rgba(58, 123, 213, 0.25);
            opacity: 0.95;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 1199px) {
            .login-hero {
                min-height: auto;
                padding: 50px 24px;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid login-shell">
        <span class="floating-shape shape-1"></span>
        <span class="floating-shape shape-2"></span>
        <span class="floating-shape shape-3"></span>
        <div class="row">
            <div class="col-xl-7 order-1">
                <div class="login-hero">
                    <div class="hero-content">
                        <div class="login-badge">
                            <i class="fa fa-heartbeat"></i>
                            <span>Sky Fitness Gym</span>
                        </div>
                        <h1>{{ \App\Models\Setting::get('login_heading', 'Train Smarter, Track Faster') }}</h1>
                        <p>{{ \App\Models\Setting::get('login_description', 'Streamline daily operations with member profiles, smart attendance, and simple billing in one place.') }}</p>
                        <div class="d-flex gap-3 align-items-center">
                            <div class="text-white-50">
                                <i class="fa fa-check-circle"></i> {{ \App\Models\Setting::get('login_bullet_1', 'Fast member check-ins') }}
                            </div>
                            <div class="text-white-50">
                                <i class="fa fa-shield"></i> {{ \App\Models\Setting::get('login_bullet_2', 'Clean, modern reports') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5 p-0">
                <div class="login-card login-dark login-bg">
                    <div>

                        <div class="login-main">

                            <!-- Show session status / success messages (e.g. after password reset) -->
                            @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                            @endif

                            <!-- Show validation errors -->
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form class="theme-form" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="text-center mb-4"> {{-- Changed to text-center and added margin-bottom --}}
                                    <a class="logo d-block" href="{{ url('/') }}">
                                        {{-- Added d-block to ensure full width centering --}}
                                        <img class="img-fluid for-light"
                                            src="{{ asset('public/' . \App\Models\Setting::get('login_logo', 'assets/images/logo/logo.png')) }}"
                                            alt="logo" style="max-width: 18% !important; margin: 0 auto;">
                                        {{-- Added margin: 0 auto --}}

                                        <img class="img-fluid for-dark"
                                            src="{{ asset('public/' . \App\Models\Setting::get('login_logo', 'assets/images/logo/logo_dark.png')) }}"
                                            alt="logo dark" style="max-width: 18% !important; margin: 0 auto;">
                                    </a>
                                </div>
                                <h4>Sign in to account</h4>
                                <p>Enter your email & password to login</p>

                                <div class="form-group">
                                    <label class="col-form-label" for="login">Email Address</label>
                                    <input class="form-control @error('login') is-invalid @enderror" type="email"
                                        name="login" id="login" value="{{ old('login') }}" required autofocus
                                        autocomplete="email" placeholder="Test@gmail.com">

                                    @error('login')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label" for="password">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control @error('password') is-invalid @enderror"
                                            type="password" name="password" id="password" required
                                            autocomplete="current-password" placeholder="*********">

                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <div class="show-hide">
                                            <span class="show"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <!-- <div class="checkbox p-0">
                                        <input id="remember" type="checkbox" name="remember">
                                        <label class="text-muted" for="remember">Remember password</label>
                                    </div>

                                    @if (Route::has('password.request'))
                                        <a class="link" href="{{ route('password.request') }}">Forgot password?</a>
                                    @endif -->

                                    <div class="text-end mt-3">
                                        <button class="btn btn-primary btn-block w-100" type="submit">
                                            Sign in
                                        </button>
                                    </div>
                                    @if ($barcodeEnabled)
                                        <div class="text-center mt-3">
                                            <button type="button" class="btn btn-outline-secondary w-100" id="barcodeLoginBtn">
                                                Login with Barcode
                                            </button>
                                        </div>
                                    @endif
                                </div>

                                <!-- Optional: Link to register if members can self-register -->
                                <!--
                                @if (Route::has('register'))
                                    <p class="mt-3 text-center">
                                        Don't have an account? <a href="{{ route('register') }}">Register</a>
                                    </p>
                                @endif
                                -->
                            </form>

                            @if ($barcodeEnabled)
                                <form method="POST" action="{{ route('login.barcode') }}" id="barcodeLoginForm">
                                    @csrf
                                    <input type="hidden" name="barcode" id="barcodeValue">
                                </form>
                            @endif

                            @error('barcode')
                            <div class="alert alert-danger mt-3">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts (keep your existing ones) -->
    <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <script src="{{ asset('public/assets/js/config.js') }}"></script>
    <script src="{{ asset('public/assets/js/script.js') }}"></script>

    <!-- Optional: Show/hide password toggle (if your template JS doesn't handle it) -->
    <script>
    document.querySelector('.show-hide .show').addEventListener('click', function() {
        let input = this.closest('.form-input').querySelector('input');
        if (input.type === 'password') {
            input.type = 'text';
            // this.textContent = 'Hide';
        } else {
            input.type = 'password';
            // this.textContent = 'Show';
        }
    });
    </script>
    @if ($barcodeEnabled)
    <script>
    const barcodeBtn = document.getElementById('barcodeLoginBtn');
    const barcodeForm = document.getElementById('barcodeLoginForm');
    const barcodeValue = document.getElementById('barcodeValue');

    const modalMarkup = `
        <div class="modal fade" id="barcodeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Scan Barcode</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-muted mb-2" id="barcodeHint">Upload a barcode image or enter the barcode manually.</div>
                        <div class="mt-3">
                            <label class="col-form-label">Enter barcode manually</label>
                            <input type="text" class="form-control" id="barcodeManualInput" placeholder="Scan or type barcode">
                        </div>
                        <div class="mt-3">
                            <label class="col-form-label">Upload barcode image / Card image</label>
                            <input type="file" class="form-control" id="barcodeImageInput" accept="image/*">
                            <small class="text-muted d-block mt-2">Upload a clear photo of the barcode to decode.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="barcodeSubmitManual">Login</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalMarkup);

    const barcodeModalEl = document.getElementById('barcodeModal');
    const barcodeModal = new bootstrap.Modal(barcodeModalEl);
    const manualInput = document.getElementById('barcodeManualInput');
    const imageInput = document.getElementById('barcodeImageInput');
    const submitManual = document.getElementById('barcodeSubmitManual');
    let lastDetected = '';
    let zxingReader;

    const stopStream = () => {
        if (zxingReader) {
            try {
                zxingReader.reset();
            } catch (e) {
                // ignore reset errors
            }
        }
    };

    const handleDetected = (value) => {
        if (!value) return;
        lastDetected = value;
        manualInput.value = value;
        barcodeValue.value = value;
        stopStream();
        barcodeModal.hide();
        barcodeForm.submit();
    };

    barcodeBtn.addEventListener('click', async () => {
        barcodeModal.show();
        manualInput.value = '';
        lastDetected = '';
        if (imageInput) {
            imageInput.value = '';
        }
        const hint = document.getElementById('barcodeHint');
        if (hint) {
            hint.textContent = 'Upload a barcode image or enter the barcode manually.';
        }
    });

    barcodeModalEl.addEventListener('hidden.bs.modal', () => {
        stopStream();
    });

    submitManual.addEventListener('click', () => {
        const value = manualInput.value.trim() || lastDetected;
        if (!value) {
            return;
        }
        barcodeValue.value = value;
        barcodeModal.hide();
        barcodeForm.submit();
    });

    if (imageInput) {
        imageInput.addEventListener('change', async (event) => {
            const file = event.target.files?.[0];
            if (!file) {
                return;
            }
            const hint = document.getElementById('barcodeHint');
            if (hint) {
                hint.textContent = 'Decoding barcode image...';
            }
            const ensureZXing = async () => {
                if (window.ZXing && window.ZXing.BrowserMultiFormatReader) {
                    return true;
                }
                const scriptId = 'zxing-script';
                if (!document.getElementById(scriptId)) {
                    const script = document.createElement('script');
                    script.id = scriptId;
                    script.src = "{{ asset('public/assets/js/vendors/zxing.min.js') }}";
                    script.async = true;
                    document.head.appendChild(script);
                    await new Promise((resolve) => {
                        script.onload = resolve;
                        script.onerror = resolve;
                    });
                }
                return !!(window.ZXing && window.ZXing.BrowserMultiFormatReader);
            };

            const ready = await ensureZXing();

            const ensureJsQR = async () => {
                if (window.jsQR) return true;
                const scriptId = 'jsqr-script';
                if (!document.getElementById(scriptId)) {
                    const script = document.createElement('script');
                    script.id = scriptId;
                    script.src = "{{ asset('public/assets/js/vendors/jsqr.js') }}";
                    script.async = true;
                    document.head.appendChild(script);
                    await new Promise((resolve) => {
                        script.onload = resolve;
                        script.onerror = resolve;
                    });
                }
                return !!window.jsQR;
            };

            const jsqrReady = await ensureJsQR();
            if (!ready && !jsqrReady) {
                if (hint) {
                    hint.textContent = 'Unable to load barcode decoder. Please type the barcode manually.';
                }
                return;
            }

            zxingReader = zxingReader || (window.ZXing ? new window.ZXing.BrowserQRCodeReader() : null);
            const imageUrl = URL.createObjectURL(file);
            const image = new Image();
            image.onload = async () => {
                try {
                    const tryDecodeJsQR = (canvasEl) => {
                        if (!window.jsQR) return null;
                        const ctx = canvasEl.getContext('2d');
                        const imageData = ctx.getImageData(0, 0, canvasEl.width, canvasEl.height);
                        const result = window.jsQR(imageData.data, canvasEl.width, canvasEl.height, {
                            inversionAttempts: 'attemptBoth'
                        });
                        return result && result.data ? result.data : null;
                    };

                    const tryDecodeImage = async (imgEl) => {
                        if (!zxingReader) return null;
                        try {
                            const res = await zxingReader.decodeFromImageElement(imgEl);
                            if (res && res.text) return res.text;
                        } catch (e) {
                            // ignore
                        }
                        return null;
                    };

                    const tryDecodeCanvas = async (canvasEl) => {
                        if (!zxingReader) return null;
                        try {
                            const res = await zxingReader.decodeFromCanvas(canvasEl);
                            if (res && res.text) return res.text;
                        } catch (e) {
                            // ignore
                        }
                        return null;
                    };

                    // First: direct image element decode (best for QR)
                    let decoded = await tryDecodeImage(image);

                    // Second: full-size canvas decode
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    canvas.width = image.naturalWidth;
                    canvas.height = image.naturalHeight;
                    ctx.drawImage(image, 0, 0);
                    if (!decoded) {
                        decoded = await tryDecodeCanvas(canvas);
                    }
                    if (!decoded && jsqrReady) {
                        decoded = tryDecodeJsQR(canvas);
                    }

                    // Third: crop lower center region and decode both ways
                    if (!decoded) {
                        const cropCanvas = document.createElement('canvas');
                        const cropCtx = cropCanvas.getContext('2d');
                        const cropWidth = Math.floor(canvas.width * 0.8);
                        const cropHeight = Math.floor(canvas.height * 0.6);
                        const cropX = Math.floor((canvas.width - cropWidth) / 2);
                        const cropY = Math.floor(canvas.height * 0.35);
                        cropCanvas.width = cropWidth;
                        cropCanvas.height = cropHeight;
                        cropCtx.drawImage(canvas, cropX, cropY, cropWidth, cropHeight, 0, 0, cropWidth, cropHeight);

                        decoded = await tryDecodeCanvas(cropCanvas);
                        if (!decoded) {
                            // Convert crop to image element
                            const cropImg = new Image();
                            cropImg.src = cropCanvas.toDataURL('image/png');
                            await new Promise((resolve) => {
                                cropImg.onload = resolve;
                                cropImg.onerror = resolve;
                            });
                            decoded = await tryDecodeImage(cropImg);
                        }
                        if (!decoded && jsqrReady) {
                            decoded = tryDecodeJsQR(cropCanvas);
                        }
                    }

                    URL.revokeObjectURL(imageUrl);
                    if (decoded) {
                        handleDetected(decoded);
                        return;
                    }

                    if (hint) {
                        hint.textContent = 'No barcode detected in the image. Please try another photo.';
                    }
                } catch (err) {
                    URL.revokeObjectURL(imageUrl);
                    if (hint) {
                        hint.textContent = 'No barcode detected in the image. Please try another photo.';
                    }
                }
            };
            image.onerror = () => {
                URL.revokeObjectURL(imageUrl);
                if (hint) {
                    hint.textContent = 'Unable to read the image. Please try another photo.';
                }
            };
            image.src = imageUrl;
        });
    }

    manualInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            submitManual.click();
        }
    });
    </script>
    @endif
</body>

</html>
