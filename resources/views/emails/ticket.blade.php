<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>E-Ticket - AmikomEventHub</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #4f46e5;
            margin: 0;
            padding: 40px 20px;
            color: #ffffff;
        }
        .container {
            max-width: 450px;
            margin: 0 auto;
            width: 100%;
        }
        .header-text {
            text-align: center;
            margin-bottom: 30px;
        }
        .header-text h1 {
            font-size: 28px;
            font-weight: 900;
            margin: 0 0 10px 0;
        }
        .header-text p {
            color: #e0e7ff;
            margin: 0;
        }
        .ticket-card {
            background-color: #ffffff;
            color: #0f172a;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .ticket-top {
            background-color: #eef2ff;
            padding: 30px;
            text-align: center;
            border-bottom: 2px dashed #c7d2fe;
        }
        .ticket-top p {
            color: #4f46e5;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0 0 10px 0;
        }
        .ticket-top h2 {
            font-size: 24px;
            font-weight: 900;
            margin: 0;
        }
        .ticket-body {
            padding: 30px;
        }
        .grid {
            display: block;
            width: 100%;
            margin-bottom: 20px;
        }
        .grid-item {
            display: inline-block;
            width: 45%;
            vertical-align: top;
            margin-bottom: 20px;
        }
        .label {
            color: #94a3b8;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0 0 5px 0;
        }
        .value {
            font-weight: bold;
            font-size: 16px;
            margin: 0;
        }
        .qr-section {
            background-color: #f8fafc;
            padding: 25px;
            border-radius: 20px;
            text-align: center;
            margin-top: 10px;
        }
        .qr-container {
            background-color: white;
            padding: 15px;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 15px;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
        }
        .footer {
            text-align: center;
            padding: 0 30px 30px 30px;
            color: #94a3b8;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-text">
            <h1>✓</h1>
            <p>Pembayaran Berhasil!</p>
        </div>

        <div class="ticket-card">
            <div class="ticket-top">
                <p>E-Ticket Resmi</p>
                <h2>{{ $transaction->event->title }}</h2>
            </div>

            <div class="ticket-body">
                <div class="grid">
                    <div class="grid-item">
                        <p class="label">Nama Pembeli</p>
                        <p class="value">{{ $transaction->customer_name }}</p>
                    </div>
                    <div class="grid-item">
                        <p class="label">Tanggal & Waktu</p>
                        <p class="value">{{ \Carbon\Carbon::parse($transaction->event->date)->format('d M, H:i') }}</p>
                    </div>
                </div>

                <div class="grid">
                    <div class="grid-item">
                        <p class="label">Order ID</p>
                        <p class="value">{{ $transaction->order_id }}</p>
                    </div>
                    <div class="grid-item">
                        <p class="label">Lokasi</p>
                        <p class="value">{{ $transaction->event->location }}</p>
                    </div>
                </div>

                <div class="qr-section">
                    <p class="label">Scan QR untuk Check-in</p>
                    <div class="qr-container">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($transaction->order_id) }}" alt="QR Code" style="width: 150px; height: 150px;">
                    </div>
                    <p class="value" style="color: #0f172a; font-size: 14px;">{{ $transaction->order_id }}</p>
                </div>
            </div>

            <div class="footer">
                <p>Mohon tunjukkan E-Ticket ini saat memasuki area acara.</p>
                <p>&copy; {{ date('Y') }} AmikomEventHub. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
