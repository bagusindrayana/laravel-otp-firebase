<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <style>
        .loader {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            border: 3px solid;
            border-color: #FFF #FFF transparent;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        .loader::after {
            content: '';
            box-sizing: border-box;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            border: 3px solid;
            border-color: transparent #FF3D00 #FF3D00;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            animation: rotationBack 0.5s linear infinite;
            transform-origin: center center;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes rotationBack {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(-360deg);
            }
        }

        #loader-wrapper {
            width: 100%;
            display: flex;
            position: absolute;
            height: 100%;
            margin: auto;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            justify-content: center;
            align-items: center;
            background-color: #8080808a;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3>Register</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('auth.register.post') }}" method="POST" autocomplete="off" id="form-register">
                            <div id="loader-wrapper" class="d-none">
                                <span class="loader"></span>
                            </div>
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" required class="form-control" id="name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No HP</label>
                                <input type="number" name="no_hp" required class="form-control" id="no_hp"
                                    placeholder="08xxxxxx" aria-describedby="no_hp">
                                @error('no_hp')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" required class="form-control" id="password"
                                    autocomplete="off">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" required class="form-control"
                                    id="password_confirmation" autocomplete="off">
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            
                            <div class="flex">
                                <button type="submit" class="btn btn-primary">Register</button>
                                <a href="{{ route('auth.login') }}">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</body>

</html>
