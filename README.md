## Laravel Login & Register with OTP Firebase

### Instalation
- Clone this repository
- Run `composer install`
- copy `.env.example` to `.env`
- fill database configuration in `.env`
- `php artisan key:generate`
- `php artisan migrate`
- generate firebase private key credentials json file in [firebase console](https://console.firebase.google.com/) and download in menu Project Settings -> Service Accounts
- put the file in `storage/app/` directory
- change `GOOGLE_APPLICATION_CREDENTIALS` in `.env` with the file name
- add or open existing app in [firebase console](https://console.firebase.google.com/) and open Project Settings -> General
- copy all config value from "SDK setup and configuration" to `.env`
  - ```
    GOOGLE_APPLICATION_CREDENTIALS=
    FIREBASE_API_KEY=
    FIREBASE_AUTH_DOMAIN=
    FIREBASE_PROJECT_ID=
    FIREBASE_STORAGE_BUCKET=
    FIREBASE_MESSAGING_SENDER_ID=
    FIREBASE_APP_ID=
    FIREBASE_MEASUREMENT_ID=
    ``` 
- `php artisan serve`

### Route
- `/` : Home/Welcome
- `/login` : Login
- `/register` : Register
- `/otp` : Send & Verify OTP
- `/logout` : Logout
- `/dashboard` : Dashboard after login