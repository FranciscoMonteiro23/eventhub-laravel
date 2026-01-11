<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventHub - Descobre Eventos</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, sans-serif; background: #f9fafb; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; text-align: center; }
        .header h1 { font-size: 2.5rem; margin-bottom: 0.5rem; }
        .container { max-width: 80rem; margin: 2rem auto; padding: 0 1rem; }
        .events-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; }
        .event-card { background: white; border-radius: 0.5rem; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .event-card:hover { transform: translateY(-4px); box-shadow: 0 8px 16px rgba(0,0,0,0.15); transition: all 0.3s; }
        .event-image { width: 100%; height: 200px; object-fit: cover; }
        .event-content { padding: 1.5rem; }
        .event-title { font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem; }
        .btn { background: #667eea; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; display: inline-block; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 EventHub</h1>
        <p>Descobre os melhores eventos</p>
    </div>

    <div class="container">
        @if(isset($events) && $events->count() > 0)
            <div class="events-grid">
                @foreach($events as $event)
                    <div class="event-card">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" class="event-image" alt="{{ $event->title }}">
                        @else
                            <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; font-size: 3rem;">🎉</div>
                        @endif
                        
                        <div class="event-content">
                            <h3 class="event-title">{{ $event->title }}</h3>
                            <p style="color: #6b7280; margin-bottom: 1rem;">📍 {{ $event->location }}</p>
                            <a href="{{ route('public.event.show', $event->slug) }}" class="btn">Ver Detalhes</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="text-align: center; padding: 3rem; color: #6b7280;">Nenhum evento disponível.</p>
        @endif
    </div>
</body>
</html>