<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>NPWPD-Login</title>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin_assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin_assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        body {
            background-color: #021027;
        }

        .container {
            width: 100%;
            height: 100%;
            overflow: hidden;
            position: relative;
        }

        .background {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            object-fit: cover;
            width: 100%;
            height: 100%;
            mask-image: radial-gradient(white 0%, white 30%, transparent 80%, transparent);
        }

        .circle-container {
            position: absolute;
            transform: translateY(-10vh);
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        .circle {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            mix-blend-mode: screen;
            background-image: radial-gradient(hsl(180, 100%, 80%), hsl(180, 100%, 80%) 10%, hsla(180, 100%, 80%, 0) 56%);
            animation: fadein-frames 200ms infinite, scale-frames 2s infinite;
        }

        @keyframes fade-frames {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes scale-frames {
            0% {
                transform: scale3d(0.4, 0.4, 1);
            }

            50% {
                transform: scale3d(2.2, 2.2, 1);
            }

            100% {
                transform: scale3d(0.4, 0.4, 1);
            }
        }

        .message {
            position: absolute;
            right: 20px;
            bottom: 10px;
            color: white;
            font-family: "Josefin Slab", serif;
            line-height: 27px;
            font-size: 18px;
            text-align: right;
            pointer-events: none;
            animation: message-frames 1.5s ease 5s forwards;
            opacity: 0;
        }

        @keyframes message-frames {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

    </style>
</head>

<body >
    {{-- <div class="container"> --}}
        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/221808/sky.jpg" class="background">
        <p class="message">All your dreams can come true<br>if you have the courage to pursue them</p>

        <!-- Loop 100 times to create the circle-container -->
        @for ($i = 1; $i <= 100; $i++)
            <div class="circle-container">
                <div class="circle"></div>
            </div>
        @endfor
    {{-- </div> --}}

    <!-- Outer Row -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">

                    <div class="col-lg-6 ">
                        <img src="{{ asset('assets/images/auth/img-01.jpg') }}" alt="Login Background" class="img-fluid">
                    </div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Buat Akun!</h1>
                            </div>
                            <form action="{{ route('register.save') }}" method="POST" class="user">
                                @csrf
                                <div class="form-group">
                                    <input name="name" type="text"
                                        class="form-control form-control-user @error('name')is-invalid @enderror"
                                        id="exampleInputName" placeholder="Name">
                                    @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input name="username" type="username"
                                        class="form-control form-control-user @error('username')is-invalid @enderror"
                                        id="username" placeholder="Username ">
                                    @error('username')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input name="password" type="password"
                                            class="form-control form-control-user @error('password')is-invalid @enderror"
                                            id="password" placeholder="Password">
                                        @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input name="password_confirmation" type="password"
                                            class="form-control form-control-user @error('password_confirmation')is-invalid @enderror"
                                            id="confirm_password" placeholder="Repeat Password">
                                        @error('password_confirmation')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Daftar
                                    </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">Sudah mempunyai Akun? Masuk!</a>
                            </div>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('admin_assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('admin_assets/js/sb-admin-2.min.js') }}"></script>
</body>

</html>
