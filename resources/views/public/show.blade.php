<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - EventHub</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, sans-serif; background: #f9fafb; }
        .navbar { background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 1rem 2rem; }
        .hero { height: 400px; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; }
        .container { max-width: 60rem; margin: 2rem auto; padding: 0 1rem; }
        .card { background: white; border-radius: 0.5rem; padding: 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        .btn { background: #667eea; color: white; padding: 0.75rem 2rem; border-radius: 0.375rem; text-decoration: none; display: inline-block; font-weight: 600; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ route('home') }}" style="color: #667eea; font-weight: bold; font-size: 1.5rem; text-decoration: none;">🎉 EventHub</a>
    </div>

    @if($event->image)
        <img src="{{ asset('storage/' . $event->image) }}" style="width: 100%; height: 400px; object-fit: cover;" alt="{{ $event->title }}">
    @else
        <div class="hero">🎉</div>
    @endif

    <div class="container">
        <div class="card">
            <h1 style="font-size: 2rem; margin-bottom: 1rem;">{{ $event->title }}</h1>
            <p style="color: #6b7280; margin-bottom: 1rem;">{{ $event->description }}</p>
            <div style="margin: 1rem 0;">
                <strong>📅 Data:</strong> {{ $event->start_date->format('d/m/Y H:i') }}<br>
                <strong>📍 Local:</strong> {{ $event->location }}<br>
                <strong>👥 Vagas:</strong> {{ $availableSpots ?? 0 }} disponíveis
            </div>
            
            @auth
                <form action="{{ route('registrations.register', $event) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn">🎫 Participar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn">Entrar para Participar</a>
            @endauth
        </div>
    </div>
</body>
</html>