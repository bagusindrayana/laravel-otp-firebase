<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3>OTP</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('auth.otp.post') }}" method="POST" autocomplete="off" id="form">
                            @csrf
                            <input type="hidden" name="no_hp" value="{{ @$user->no_hp }}" id="no_hp">
                            <input type="hidden" name="token" value="abcdef" id="token">
                            <div>
                                <div id="recaptcha-container" class="my-2"></div>
                                <span id="captchaStatus" style="color:red"></span>
                                <button type="button" class="btn btn-success" onclick="sendOTP()">Send OTP</button>
                            </div>
                            <div id="otp-verification" class="d-none">
                                <div class="mb-3">
                                    <label for="otp" class="form-label">OTP</label>
                                    <input type="number" name="otp" class="form-control" id="otp" placeholder="123456"
                                        aria-describedby="otp">
                                    @error('otp')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <button type="button" class="btn btn-success" onclick="verify()">Verify</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

    <script>
        var firebaseConfig = {
            apiKey: "{{ env('FIREBASE_API_KEY') }}",
            authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
            projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
            storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
            messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
            appId: "{{ env('FIREBASE_APP_ID') }}",
            measurementId: "{{ env('FIREBASE_MEASUREMENT_ID') }}"
        };
        firebase.initializeApp(firebaseConfig);
    </script>
    <script type="text/javascript">
        var kirimOtp = false;
        window.onload = function() {
            render();
        };

        function render() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
            recaptchaVerifier.render();
        }

        function sendOTP() {
            kirimOtp = true;
            if (kirimOtp) {
                $("#otp-verification").removeClass('d-none');
            }
            var number = $("#no_hp").val();
            //format phone number to +62
            number = number.replace(/^0+/, '+62');
            console.log(number);
            firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(confirmationResult) {
                console.log(confirmationResult);
                window.confirmationResult = confirmationResult;
                coderesult = confirmationResult;
                console.log(coderesult);
                // window.location.href = "{{ route('auth.otp') }}?user="+user+"&confirmationResult="+confirmationResult;
                // $("#successAuth").text("Message sent");
                // $("#successAuth").show();
            }).catch(function(error) {
                // $("#error").text(error.message);
                // $("#error").show();
                console.log(error);
                alert(error.message);
            });
        }

        function verify() {
            var code = $("#otp").val();
            coderesult.confirm(code).then(function(result) {
                var user = result.user;
                //get token
                user.getIdToken().then(function(idToken) {
                    //save token to input
                    $("#token").val(idToken);
                    //submit form
                    $("#form").submit();
                });
                
            }).catch(function(error) {
                console.log(error);
                alert(error.message);
            });
        }
    </script>
</body>

</html>
