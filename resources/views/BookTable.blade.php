<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Event / Kegiatan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }
        .event-title {
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #333;
        }
        .event-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }
        .event-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }
        .event-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        .event-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .event-card:hover .event-img {
            transform: scale(1.05);
        }
        .event-content {
            padding: 20px;
            text-align: center;
        }
        .event-content h3 {
            font-size: 22px;
            margin-bottom: 12px;
            color: #222;
        }
        .event-content p {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
            line-height: 1.6;
        }
        .btn-event {
            display: inline-block;
            background: linear-gradient(135deg, #ff4b5c, #ff6666);
            color: white;
            padding: 12px 18px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .btn-event:hover {
            background: linear-gradient(135deg, #ff333f, #ff5555);
            transform: scale(1.05);
        }
    </style>
</head>
<body>

@include('layouts.Navbar')

<div class="container">
    <h2 class="event-title">Pilih Event / Kegiatan</h2>

    <div class="event-grid">
        @foreach($events as $event)
        <div class="event-card">
        <img src="{{ asset($event->image) }}" class="event-img" alt="{{ $event->name }}">
            <div class="event-content">
                <h3>{{ $event->name }}</h3>
                <p>{{ $event->description }}</p>
                <a href="{{ route('pilih-kursi') }}" class="btn-event">Beli Tiket</a>
            </div>
        </div>
        @endforeach
    </div>
</div>

@include('layouts.footer')

</body>
</html>
