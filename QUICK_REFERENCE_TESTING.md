# 🔗 QUICK REFERENCE - URL & ROUTES TESTING

## CREDENTIALS FOR TESTING
```
Email:    admin@amikom.ac.id
Password: password
```

---

## 📍 PUBLIC ROUTES (No Authentication Required)

| URL | Method | Action | Expected Result |
|-----|--------|--------|-----------------|
| `GET /admin/login` | GET | Show login form | Display login page |
| `POST /admin/login` | POST | Process login | Redirect to dashboard (if valid) or back with errors |
| `/` | GET | Home page | Public page accessible |

---

## 🔒 PROTECTED ROUTES (Require Authentication)

### Login Test Sequence
```
1. Try accessing without login:
   → GET /admin/dashboard
   → EXPECTED: Redirect to /admin/login (middleware catches this)

2. Go to login page:
   → GET /admin/login
   → EXPECTED: Login form displayed

3. Submit login with correct credentials:
   → Email: admin@amikom.ac.id
   → Password: password
   → EXPECTED: Redirect to /admin/dashboard

4. Access protected route after login:
   → GET /admin/dashboard
   → EXPECTED: Dashboard displayed (user is authenticated + admin role)
```

---

## 🔐 ADMIN PROTECTED ROUTES

| URL | Method | Middleware | Action |
|-----|--------|-----------|--------|
| `GET /admin/dashboard` | GET | `['auth', 'admin']` | Dashboard view |
| `GET /admin/events` | GET | `['auth', 'admin']` | Event list |
| `POST /admin/events` | POST | `['auth', 'admin']` | Create event |
| `GET /admin/events/{id}` | GET | `['auth', 'admin']` | Event detail |
| `GET /admin/events/{id}/edit` | GET | `['auth', 'admin']` | Edit event form |
| `PUT /admin/events/{id}` | PUT | `['auth', 'admin']` | Update event |
| `DELETE /admin/events/{id}` | DELETE | `['auth', 'admin']` | Delete event |
| `GET /admin/categories` | GET | `['auth', 'admin']` | Category list |
| `GET /admin/transactions` | GET | `['auth', 'admin']` | Transaction report |

---

## 🚪 LOGOUT

| URL | Method | Action | Expected Result |
|-----|--------|--------|-----------------|
| `POST /admin/logout` | POST | Process logout | Redirect to home, session cleared |

**Note:** Logout button in sidebar submits POST request (CSRF protected)

---

## 🛡️ MIDDLEWARE EXPLANATION

### Middleware Chain Flow
```
HTTP Request comes in
        ↓
[Route Matching] - Find which route
        ↓
[Middleware 'auth'] - Check if user is logged in
        ↓
        NO? → Redirect to login
        YES? → Continue
        ↓
[Middleware 'admin'] - Check if user role is 'admin'
        ↓
        NO? → Redirect to login with error
        YES? → Continue
        ↓
[Controller] - Process the request
        ↓
[Return Response] - Send response back
```

---

## 🧪 TESTING STEPS

### Step 1: Test Route Protection (Without Login)
```
1. Start server: php artisan serve
2. Open browser: http://127.0.0.1:8000/admin/dashboard
3. Expected: Redirects to http://127.0.0.1:8000/admin/login
4. Status: ✓ Route is protected by 'auth' middleware
```

### Step 2: Test Login with Wrong Credentials
```
1. On login page: http://127.0.0.1:8000/admin/login
2. Email: wrong@example.com
3. Password: wrongpassword
4. Click "Login"
5. Expected: Error message displays
   "Email atau Password yang Anda berikan tidak terdaftar di rekaman kami."
6. Status: ✓ Validation working
```

### Step 3: Test Login with Correct Credentials
```
1. On login page: http://127.0.0.1:8000/admin/login
2. Email: admin@amikom.ac.id
3. Password: password
4. Click "Login"
5. Expected: Redirects to http://127.0.0.1:8000/admin/dashboard
6. Status: ✓ Login successful, session created
```

### Step 4: Test Access Protected Routes After Login
```
1. After login, try accessing:
   - http://127.0.0.1:8000/admin/events
   - http://127.0.0.1:8000/admin/categories
   - http://127.0.0.1:8000/admin/transactions
2. Expected: All pages load successfully
3. Status: ✓ Admin user can access protected routes
```

### Step 5: Test Logout
```
1. On dashboard, click "Logout" button in sidebar
2. Expected: 
   - Redirects to home page: http://127.0.0.1:8000/
   - Session is invalidated
3. Status: ✓ Logout successful
```

### Step 6: Test Route Protection After Logout
```
1. After logout, try accessing dashboard again:
   http://127.0.0.1:8000/admin/dashboard
2. Expected: Redirects to login page
3. Status: ✓ Session is properly invalidated
```

---

## 📋 FILES MODIFIED/CREATED

```
✅ Created:
   - app/Http/Controllers/Admin/AuthController.php
   - app/Http/Middleware/IsAdmin.php
   - resources/views/auth/login.blade.php

✅ Updated:
   - database/migrations/0001_01_01_000000_create_users_table.php
   - routes/web.php
   - bootstrap/app.php
   - resources/views/layouts/admin.blade.php
```

---

## 🔍 DATABASE

### Users Table After Migration
```
Schema:
  - id (PRIMARY KEY)
  - name (string)
  - email (string, unique)
  - email_verified_at (timestamp, nullable)
  - password (string)
  - role (enum: 'admin' | 'user') → DEFAULT: 'user'
  - remember_token (string, nullable)
  - created_at (timestamp)
  - updated_at (timestamp)
```

### Admin User (Seeded)
```
INSERT INTO users VALUES (
  id: 1,
  name: 'Admin Amikom',
  email: 'admin@amikom.ac.id',
  password: bcrypt('password'),
  role: 'admin',
  created_at: 2026-06-07 XX:XX:XX
);
```

---

## ⚙️ KEY IMPLEMENTATIONS

### 1. Auth::attempt()
```php
// Check email & password against database
if (Auth::attempt(['email' => $email, 'password' => $password])) {
    // User authenticated - create session
}
```

### 2. session()->regenerate()
```php
// Create new session after login (security best practice)
$request->session()->regenerate();
```

### 3. Auth::check()
```php
// Check if user is logged in
if (Auth::check()) {
    // User is authenticated
}
```

### 4. Auth::user()
```php
// Get current authenticated user
$user = Auth::user();
$role = $user->role;
```

### 5. Custom Middleware
```php
if (Auth::check() && Auth::user()->role === 'admin') {
    // User is admin, allow access
    return $next($request);
}
// Not admin, redirect to login
return redirect()->route('admin.login');
```

---

## 📸 SCREENSHOTS TO CAPTURE

For your PDF report, take screenshots of:

1. **Login Page** (`/admin/login`)
   - Show the login form with email & password fields
   - Caption: "Halaman Login Admin"

2. **Route Protection Test** (Access without login)
   - Show browser URL trying to access `/admin/dashboard`
   - Show redirect to login page
   - Caption: "Middleware Auth melakukan redirect ke halaman login"

3. **Dashboard After Auth** 
   - Show successful login result
   - Show admin dashboard with all menu items
   - Caption: "Dashboard Admin setelah autentikasi sukses"

4. **Middleware & Route Config**
   - Screenshot dari `routes/web.php` showing route grouping
   - Caption: "Konfigurasi Route dengan Middleware Protection"

5. **IsAdmin Middleware Code**
   - Screenshot dari `app/Http/Middleware/IsAdmin.php`
   - Caption: "Custom Middleware untuk Role-Based Access Control"

---

## ✅ CHECKLIST

- [ ] Database migrated with enum role
- [ ] AuthController created with login/logout methods
- [ ] IsAdmin middleware created
- [ ] Middleware registered in bootstrap/app.php
- [ ] Routes protected with ['auth', 'admin'] middleware
- [ ] Login view created with form & error messages
- [ ] Admin user seeded (admin@amikom.ac.id / password)
- [ ] Logout button added to dashboard layout
- [ ] Tested route protection without login
- [ ] Tested login with wrong credentials
- [ ] Tested successful login
- [ ] Tested access to protected routes
- [ ] Tested logout functionality
- [ ] Verified session invalidation after logout

---

## 🎓 LEARNING OUTCOMES

By completing this module, you understand:
- ✓ Laravel Authentication system (Auth facade)
- ✓ Middleware as request interceptor
- ✓ Session management & regeneration
- ✓ Password hashing with bcrypt
- ✓ CSRF protection in forms
- ✓ Route grouping & middleware stacking
- ✓ Role-based access control (RBAC)
- ✓ Custom middleware creation
- ✓ Blade template error handling

---

