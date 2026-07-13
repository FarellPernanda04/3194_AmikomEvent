# TODO - Implementasi Modul 12.4.1 s/d 12.4.3 (Webhook Midtrans & Dashboard Admin)

## Langkah
1. Buat Controller `MidtransWebhookController` untuk menerima POST webhook Midtrans dan update status transaksi.
2. Tambahkan route POST `/midtrans/callback` di `routes/web.php` menuju controller baru.
3. Bypass CSRF untuk route webhook di `bootstrap/app.php`.
4. Update `Admin\DashboardController@index()` agar menghitung rekap:
   - totalRevenue (sum total_price) untuk status settlement/success
   - ticketsSold (count) untuk status settlement/success
   - activeEvents (count event date >= now)
   - pendingOrders (count status pending)
   - recentTransactions (latest 5 dengan relasi event)
5. Update view `resources/views/admin/dashboard.blade.php` agar menggunakan variabel hasil controller (hapus dummy angka/baris).
6. Testing manual:
   - buka `/admin/dashboard` dan pastikan angka/daftar tidak error
   - lakukan pembayaran hingga sukses dan pastikan webhook mengubah status transaksi
   - (opsional) cek terminal/log yang menerima request webhook

## Status
- [x] Langkah 1
- [x] Langkah 2
- [x] Langkah 3
- [x] Langkah 4
- [x] Langkah 5
- [x] Langkah 6



