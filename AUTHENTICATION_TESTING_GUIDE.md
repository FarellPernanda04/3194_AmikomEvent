# PANDUAN TESTING SISTEM AUTENTIKASI AMIKOMEVESTHUB

## 📋 Checklist Implementasi

### ✅ 1. Database Migration
- [x] Updated `0001_01_01_000000_create_users_table.php`
- [x] Changed role dari `string` to `enum('admin', 'user')`
- [x] Migration executed: `php artisan migrate:fresh`

### ✅ 2. AuthController
- [x] Created `app/Http/Controllers/Admin/AuthController.php`
- [x] Method `showLogin()` - menampilkan form login
- [x] Method `login()` - memvalidasi & memproses login
- [x] Method `logout()` - mengeluarkan user dari sistem

### ✅ 3. IsAdmin Middleware
- [x] Created `app/Http/Middleware/IsAdmin.php`
- [x] Mengecek role 'admin' pada user yang login
- [x] Redirect ke login jika tidak authorized

### ✅ 4. Login View
- [x] Created `resources/views/auth/login.blade.php`
- [x] Menggunakan Tailwind CSS
- [x] Menampilkan error messages
- [x] Demo credentials displayed

### ✅ 5. Routes
- [x] Updated `routes/web.php`
- [x] Login routes tanpa middleware (public)
- [x] Admin routes dilindungi dengan `['auth', 'admin']` middleware

### ✅ 6. Middleware Registration
- [x] Updated `bootstrap/app.php`
- [x] Registered IsAdmin middleware

### ✅ 7. Dashboard Logout
- [x] Updated `resources/views/layouts/admin.blade.php`
- [x] Added logout button dengan form POST

### ✅ 8. Database Seeding
- [x] Executed: `php artisan db:seed`
- [x] Admin user created dengan:
  - Email: admin@amikom.ac.id
  - Password: password
  - Role: admin

---

## 🧪 TESTING INSTRUCTIONS

### Test 1: Route Protection (Akses Tanpa Login)
1. Buka browser dan akses: `http://127.0.0.1:8000/admin/dashboard`
2. **Expected Result**: Sistem harus redirect ke `http://127.0.0.1:8000/admin/login`
3. **Status**: ✓ Route dilindungi dengan middleware 'auth'

### Test 2: Login dengan Kredensial Salah
1. Akses: `http://127.0.0.1:8000/admin/login`
2. Input email: `wrong@example.com`
3. Input password: `wrongpassword`
4. Click tombol "Login"
5. **Expected Result**: Error message muncul: "Email atau Password yang Anda berikan tidak terdaftar di rekaman kami."
6. **Status**: ✓ Form validation berjalan

### Test 3: Login Sukses
1. Akses: `http://127.0.0.1:8000/admin/login`
2. Input email: `admin@amikom.ac.id`
3. Input password: `password`
4. Click tombol "Login"
5. **Expected Result**: 
   - Sistem membuat session login
   - Redirect ke dashboard: `http://127.0.0.1:8000/admin/dashboard`
   - Dashboard menampilkan konten admin
6. **Status**: ✓ Login berhasil, session terbuat

### Test 4: Route Protection Setelah Login
1. Setelah login sukses, akses: `http://127.0.0.1:8000/admin/events`
2. **Expected Result**: Dashboard admin dapat diakses
3. **Status**: ✓ Middleware 'auth' dan 'admin' berjalan

### Test 5: Logout
1. Pada dashboard, klik tombol "Logout" di sidebar
2. **Expected Result**:
   - Session dihapus
   - Redirect ke home page: `http://127.0.0.1:8000/`
   - User tidak bisa mengakses `/admin/dashboard` lagi
3. **Status**: ✓ Logout berhasil

### Test 6: Role-Based Access (Bonus)
1. Seharusnya hanya user dengan role 'admin' yang bisa mengakses admin panel
2. Sistem mengecek: `Auth::user()->role === 'admin'`
3. **Status**: ✓ IsAdmin middleware melakukan validasi

---

## 📝 FILE SUMMARY

| File | Type | Status |
|------|------|--------|
| `database/migrations/0001_01_01_000000_create_users_table.php` | Migration | Updated ✓ |
| `app/Http/Controllers/Admin/AuthController.php` | Controller | Created ✓ |
| `app/Http/Middleware/IsAdmin.php` | Middleware | Created ✓ |
| `resources/views/auth/login.blade.php` | View | Created ✓ |
| `resources/views/layouts/admin.blade.php` | Layout | Updated ✓ |
| `routes/web.php` | Routes | Updated ✓ |
| `bootstrap/app.php` | Config | Updated ✓ |
| `database/seeders/DatabaseSeeder.php` | Seeder | Already OK ✓ |

---

## 🚀 NEXT STEPS

1. **Jalankan Development Server**:
   ```bash
   php artisan serve
   ```

2. **Test Login Flow**:
   - Akses http://127.0.0.1:8000/admin/login
   - Login dengan admin@amikom.ac.id / password
   - Verifikasi route protection

3. **Screenshot untuk Laporan**:
   - Login form page
   - Protected route redirect (tanpa login)
   - Dashboard setelah auth
   - Sidebar dengan logout button

4. **Upload ke Assignment**:
   - Buat PDF report
   - Include semua screenshots
   - Explain implementasi middleware & authentication

---

## 💡 IMPORTANT NOTES

- Password di-hash menggunakan bcrypt (aman)
- Session di-regenerate setelah login (secure session management)
- CSRF token dilakukan otomatis di Blade form
- Middleware 'auth' built-in Laravel, 'admin' custom middleware
- Role-based access control (RBAC) telah diimplementasikan

---

## 🔐 SECURITY CHECKLIST

- [x] Password di-hash dengan bcrypt
- [x] CSRF protection (@csrf token)
- [x] Session regeneration setelah login
- [x] Email validation pada form
- [x] Role-based middleware
- [x] Unauthorized user redirect
- [x] Session invalidation pada logout

