# Backend Integration Guide

## Required Laravel API Endpoints

### Authentication Endpoints

#### 1. Register User
```
POST /api/register
Content-Type: application/json

Request Body:
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}

Success Response (201):
{
  "success": true,
  "message": "Registration successful"
}

Error Response (422):
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "email": ["The email has already been taken."]
  }
}
```

#### 2. Login User
```
POST /api/login
Content-Type: application/json

Request Body:
{
  "email": "john@example.com",
  "password": "password123"
}

Success Response (200):
{
  "success": true,
  "token": "1|abc123...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "is_admin": false,
    "phone": "+1234567890",
    "address": "123 Main St",
    "city": "New York",
    "state": "NY",
    "pincode": "10001",
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z"
  }
}

Error Response (401):
{
  "success": false,
  "message": "Invalid credentials"
}
```

#### 3. Logout User
```
POST /api/logout
Authorization: Bearer {token}

Success Response (200):
{
  "success": true,
  "message": "Logged out successfully"
}
```

#### 4. Get Authenticated User
```
GET /api/user
Authorization: Bearer {token}

Success Response (200):
{
  "success": true,
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "is_admin": false,
    "phone": "+1234567890",
    "address": "123 Main St",
    "city": "New York",
    "state": "NY",
    "pincode": "10001",
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z"
  }
}

Error Response (401):
{
  "success": false,
  "message": "Unauthenticated"
}
```

#### 5. Update User Profile
```
PUT /api/user/profile
Authorization: Bearer {token}
Content-Type: application/json

Request Body:
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "+1234567890",
  "address": "123 Main St",
  "city": "New York",
  "state": "NY",
  "pincode": "10001"
}

Success Response (200):
{
  "success": true,
  "message": "Profile updated successfully",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "is_admin": false,
    "phone": "+1234567890",
    "address": "123 Main St",
    "city": "New York",
    "state": "NY",
    "pincode": "10001",
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z"
  }
}

Error Response (422):
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "email": ["The email has already been taken."]
  }
}
```

#### 6. Forgot Password
```
POST /api/forgot-password
Content-Type: application/json

Request Body:
{
  "email": "john@example.com"
}

Success Response (200):
{
  "success": true,
  "message": "Password reset link sent to your email"
}

Error Response (404):
{
  "success": false,
  "message": "User not found"
}
```

## Database Schema Requirements

### Users Table
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    phone VARCHAR(20) NULL,
    address TEXT NULL,
    city VARCHAR(100) NULL,
    state VARCHAR(100) NULL,
    pincode VARCHAR(10) NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Laravel Migration
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('password');
            $table->string('phone', 20)->nullable()->after('is_admin');
            $table->text('address')->nullable()->after('phone');
            $table->string('city', 100)->nullable()->after('address');
            $table->string('state', 100)->nullable()->after('city');
            $table->string('pincode', 10)->nullable()->after('state');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_admin', 'phone', 'address', 'city', 'state', 'pincode']);
        });
    }
};
```

## Laravel Controller Example

### AuthController.php
```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);
    }

    public function user(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $request->user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
        ]);

        $user->update($request->only([
            'name', 'email', 'phone', 'address', 'city', 'state', 'pincode'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'user' => $user->fresh(),
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        // Send password reset email here
        // Password::sendResetLink($request->only('email'));

        return response()->json([
            'success' => true,
            'message' => 'Password reset link sent to your email',
        ]);
    }
}
```

## Routes Configuration

### api.php
```php
<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user/profile', [AuthController::class, 'updateProfile']);
});
```

## CORS Configuration

### config/cors.php
```php
<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:5173'], // Your Vue dev server
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
```

## Sanctum Configuration

### config/sanctum.php
```php
<?php

return [
    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:5173,127.0.0.1,127.0.0.1:8000,::1',
        env('APP_URL') ? ','.parse_url(env('APP_URL'), PHP_URL_HOST) : ''
    ))),

    'guard' => ['web'],

    'expiration' => null,

    'middleware' => [
        'verify_csrf_token' => App\Http\Middleware\VerifyCsrfToken::class,
        'encrypt_cookies' => App\Http\Middleware\EncryptCookies::class,
    ],
];
```

## Testing with Postman/Insomnia

### 1. Register
```
POST http://127.0.0.1:8000/api/register
Content-Type: application/json

{
  "name": "Test User",
  "email": "test@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

### 2. Login
```
POST http://127.0.0.1:8000/api/login
Content-Type: application/json

{
  "email": "test@example.com",
  "password": "password123"
}

// Save the token from response
```

### 3. Get User
```
GET http://127.0.0.1:8000/api/user
Authorization: Bearer {your-token-here}
```

### 4. Update Profile
```
PUT http://127.0.0.1:8000/api/user/profile
Authorization: Bearer {your-token-here}
Content-Type: application/json

{
  "name": "Updated Name",
  "phone": "+1234567890",
  "address": "123 Main St",
  "city": "New York",
  "state": "NY",
  "pincode": "10001"
}
```

## Admin User Seeder

### database/seeders/AdminSeeder.php
```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@rufarsfoods.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'phone' => '+1234567890',
            'address' => '123 Admin Street',
            'city' => 'New York',
            'state' => 'NY',
            'pincode' => '10001',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'phone' => '+0987654321',
            'address' => '456 User Avenue',
            'city' => 'Los Angeles',
            'state' => 'CA',
            'pincode' => '90001',
            'email_verified_at' => now(),
        ]);
    }
}
```

## Environment Variables

### .env
```env
APP_URL=http://127.0.0.1:8000
FRONTEND_URL=http://localhost:5173

SANCTUM_STATEFUL_DOMAINS=localhost:5173,127.0.0.1:5173
SESSION_DOMAIN=localhost
```

## Troubleshooting

### CORS Issues
- Check `config/cors.php` has correct frontend URL
- Ensure `withCredentials: true` in axios config
- Verify Sanctum stateful domains include frontend URL

### 401 Unauthorized
- Check token is being sent in Authorization header
- Verify token hasn't expired
- Ensure user exists and is authenticated

### Profile Not Updating
- Check validation rules in controller
- Verify all fields are fillable in User model
- Check database columns exist

### Admin Access Denied
- Verify `is_admin` column exists in users table
- Check user has `is_admin = true` in database
- Ensure middleware checks `is_admin` flag
