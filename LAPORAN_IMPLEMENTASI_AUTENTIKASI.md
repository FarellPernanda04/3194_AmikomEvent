# 📘 LAPORAN IMPLEMENTASI SISTEM AUTENTIKASI - AMIKOMEVENSHUB

**Modul:** Digital Bisnis [SI148]  
**Institusi:** Universitas AMIKOM Yogyakarta  
**Tanggal:** Juni 2026  
**Deskripsi:** Implementasi sistem autentikasi (Login/Logout) dengan Middleware Protection

---

## 🎯 RINGKASAN EKSEKUSI

Telah berhasil mengimplementasikan sistem autentikasi lengkap untuk aplikasi AmikomEventHub dengan:
- ✅ Database role-based access control (RBAC)
- ✅ Authentication Controller (Login/Logout)
- ✅ Custom IsAdmin Middleware
- ✅ Secure Session Management
- ✅ Route Protection dengan Middleware

---

## 📚 DASAR TEORI (Konsep yang Diimplementasikan)

### 8.3.1 Authentication via Auth Facade
```
Laravel Auth Facade → Kredensial Email + Password
                   → Hash Password Matching (bcrypt)
                   → Session Creation & Recording
                   → User Recognition Across Pages
```

### 8.3.2 Middleware sebagai "Satpam" Aplikasi
```
HTTP Request → [Middleware Auth] → Cek Session Valid?
              → [Middleware Admin] → Cek Role == 'admin'?
              → [Controller] → Proses Request
```

---

## 🛠️ IMPLEMENTASI DETAIL

### 1. MODIFIKASI TABEL USERS (Database Migration)
**File:** `database/migrations/0001_01_01_000000_create_users_table.php`

```php
// BEFORE
$table->string('role')->default('user');

// AFTER - Enum untuk type safety
$table->enum('role', ['admin', 'user'])->default('user');
```

**Alasan:** Enum lebih aman karena membatasi nilai yang diizinkan hanya 'admin' atau 'user'.

---

### 2. MEMBUAT LOGIN VIEW
**File:** `resources/views/auth/login.blade.php`

**Fitur:**
- Form dengan email & password input
- CSRF token untuk keamanan
- Error message display
- Responsive design (Tailwind CSS)
- Demo credentials untuk testing

**Elemen Form:**
```html
<form action="{{ route('admin.login.post') }}" method="POST">
    @csrf
    <input type="email" name="email" required>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
</form>
```

---

### 3. IMPLEMENTASI AUTH CONTROLLER
**File:** `app/Http/Controllers/Admin/AuthController.php`

#### Method 1: showLogin()
```php
public function showLogin() {
    return view('auth.login');
}
```
→ Menampilkan halaman form login

#### Method 2: login()
```php
public function login(Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);
    
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }
    
    return back()->withErrors([
        'email' => 'Email atau Password tidak valid',
    ])->onlyInput('email');
}
```

**Penjelasan:**
- Validasi input email & password
- `Auth::attempt()` → cocokkan kredensial dengan database
- `session()->regenerate()` → ciptakan session baru (security)
- Jika gagal → kembali ke login dengan error

#### Method 3: logout()
```php
public function logout(Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
}
```

**Penjelasan:**
- `Auth::logout()` → logout dari sistem
- `invalidate()` → hapus session lama
- `regenerateToken()` → regenerate CSRF token
- Redirect ke home page

---

### 4. CUSTOM MIDDLEWARE - IsAdmin
**File:** `app/Http/Middleware/IsAdmin.php`

```php
public function handle(Request $request, Closure $next): Response
{
    // Validasi: user sudah login DAN role = 'admin'
    if (Auth::check() && Auth::user()->role === 'admin') {
        return $next($request);
    }
    
    // Jika tidak: redirect ke login
    return redirect()->route('admin.login')
        ->with('error', 'Anda tidak memiliki akses.');
}
```

**Fungsi:**
- Mengecheck apakah user sudah login
- Mengecheck apakah role user adalah 'admin'
- Hanya admin yang bisa akses protected routes
- User biasa akan di-redirect ke login

---

### 5. REGISTRASI MIDDLEWARE
**File:** `bootstrap/app.php`

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'admin' => \App\Http\Middleware\IsAdmin::class,
    ]);
})
```

**Penjelasan:**
- Mendaftarkan custom middleware dengan alias 'admin'
- Middleware ini bisa digunakan di route groups
- Format: `Route::middleware(['auth', 'admin'])`

---

### 6. ROUTE PROTECTION
**File:** `routes/web.php`

```php
Route::prefix('admin')->name('admin.')->group(function () {
    // PUBLIC ROUTES (tanpa middleware)
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    // PROTECTED ROUTES (dengan middleware auth + admin)
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('events', AdminEventController::class);
        Route::resource('categories', CategoryController::class);
        Route::get('transactions', [TransactionController::class, 'index'])
            ->name('transactions.index');
    });
});
```

**Alur Request:**
```
1. GET /admin/login          → Tampilkan form (public)
2. POST /admin/login         → Process login (public)
3. GET /admin/dashboard      → [Middleware Auth] Cek login
                             → [Middleware Admin] Cek role
                             → Tampilkan dashboard
4. POST /admin/logout        → [Middleware Auth] Cek login
                             → Process logout
                             → Redirect home
```

---

### 7. LOGOUT BUTTON di DASHBOARD
**File:** `resources/views/layouts/admin.blade.php`

```html
<form action="{{ route('admin.logout') }}" method="POST">
    @csrf
    <button type="submit" class="...">Logout</button>
</form>
```

**Catatan:** POST method untuk keamanan (CSRF protection)

---

### 8. DATABASE SEEDING
**File:** `database/seeders/DatabaseSeeder.php`

```php
User::create([
    'name' => 'Admin Amikom',
    'email' => 'admin@amikom.ac.id',
    'password' => bcrypt('password'),
    'role' => 'admin',
]);
```

**Hasil:**
```
Email: admin@amikom.ac.id
Password: password (di-hash dengan bcrypt)
Role: admin
```

---

## 🧪 TESTING & VERIFIKASI

### Test Case 1: Route Protection (Tanpa Login)
**Action:** Akses `/admin/dashboard` tanpa login
```
HTTP GET /admin/dashboard
     ↓
[Middleware 'auth'] → Cek Auth::check()?
     ↓ NO
Redirect ke /admin/login
```

**Expected:** ✅ Redirect ke login page

---

### Test Case 2: Login Gagal
**Action:** Login dengan email/password salah
```
Form submit dengan:
- email: wrong@example.com
- password: wrongpassword

Auth::attempt($credentials) → FALSE
↓
Kembali ke login dengan error message
```

**Expected:** ✅ Error: "Email atau Password tidak valid"

---

### Test Case 3: Login Sukses
**Action:** Login dengan credentials benar
```
Form submit dengan:
- email: admin@amikom.ac.id  
- password: password

Auth::attempt($credentials) → TRUE
↓
session()->regenerate() → Session baru terbuat
↓
Redirect ke /admin/dashboard
```

**Expected:** ✅ Dashboard admin terbuka, session recorded

---

### Test Case 4: Access Protected Route
**Action:** Setelah login, akses `/admin/events`
```
GET /admin/events
     ↓
[Middleware 'auth'] → Cek Auth::check()? YES ✓
     ↓
[Middleware 'admin'] → Cek Auth::user()->role === 'admin'? YES ✓
     ↓
[Controller] → Process request
```

**Expected:** ✅ Admin panel accessible

---

### Test Case 5: Logout
**Action:** Click logout button
```
POST /admin/logout
     ↓
Auth::logout() → Hapus session
↓
session()->invalidate() → Invalidate semua session
↓
Redirect ke home /
```

**Expected:** ✅ Session dihapus, redirect home

---

### Test Case 6: Route Protection Setelah Logout
**Action:** Akses `/admin/dashboard` setelah logout
```
GET /admin/dashboard
     ↓
[Middleware 'auth'] → Cek Auth::check()? NO
     ↓
Redirect ke /admin/login
```

**Expected:** ✅ Redirect ke login (session invalid)

---

## 📊 HASIL IMPLEMENTASI

| Komponen | Status | File |
|----------|--------|------|
| Database Migration (Enum Role) | ✅ | `database/migrations/0001_01_01_000000_create_users_table.php` |
| Login View | ✅ | `resources/views/auth/login.blade.php` |
| Auth Controller | ✅ | `app/Http/Controllers/Admin/AuthController.php` |
| IsAdmin Middleware | ✅ | `app/Http/Middleware/IsAdmin.php` |
| Route Protection | ✅ | `routes/web.php` |
| Middleware Registration | ✅ | `bootstrap/app.php` |
| Admin Layout Update | ✅ | `resources/views/layouts/admin.blade.php` |
| Database Seeding | ✅ | `database/seeders/DatabaseSeeder.php` |

---

## 🔐 SECURITY IMPLEMENTATION

| Fitur | Implementasi |
|-------|--------------|
| Password Hashing | bcrypt via `bcrypt()` function |
| CSRF Protection | @csrf token di form |
| Session Security | session()->regenerate() setelah login |
| Email Validation | HTML5 + Laravel validation |
| Role-Based Access | IsAdmin middleware |
| Unauthorized Redirect | Middleware → redirect ke login |
| Session Invalidation | logout() method menghapus session |
| CSRF Token Regeneration | session()->regenerateToken() di logout |

---

## 📝 CATATAN PENTING

1. **Enum Role** → Type-safe, lebih baik dari string
2. **Middleware Alias** → Registered di bootstrap/app.php (Laravel 11 style)
3. **CSRF Protection** → Otomatis di setiap form Laravel
4. **Session Regenerate** → Security best practice setelah login
5. **Custom Middleware** → IsAdmin mengecek role user
6. **Error Messages** → User-friendly bahasa Indonesia
7. **Route Grouping** → Prefix & middleware untuk organisasi

---

## 🚀 CARA TESTING

1. **Start Server:**
   ```bash
   php artisan serve
   ```

2. **Akses Login:**
   ```
   http://127.0.0.1:8000/admin/login
   ```

3. **Test Akses Tanpa Login:**
   ```
   http://127.0.0.1:8000/admin/dashboard
   → Should redirect to login
   ```

4. **Login dengan Credentials:**
   - Email: `admin@amikom.ac.id`
   - Password: `password`

5. **Test Protected Routes:**
   ```
   http://127.0.0.1:8000/admin/dashboard
   http://127.0.0.1:8000/admin/events
   http://127.0.0.1:8000/admin/categories
   ```

6. **Test Logout:**
   - Click "Logout" button di sidebar
   - Should redirect to home page
   - Try accessing dashboard → redirect to login

---

## ✨ NILAI TAMBAH (BONUS FEATURES)

1. ✅ Custom IsAdmin Middleware → Role-based access control
2. ✅ Middleware Alias Registration → Proper middleware setup
3. ✅ Session Regeneration → Enhanced security
4. ✅ Error Messages → User-friendly feedback
5. ✅ Logout Button → Easy access in dashboard
6. ✅ Enum Role → Type-safe role management

---

**Status:** ✅ IMPLEMENTASI SELESAI  
**Semua Requirement Terpenuhi**

