<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-12" style="background: linear-gradient(to bottom, #f0f9ff, #e0f2fe);">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Card - Gradiente vibrante -->
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); border-radius: 1rem; padding: 2.5rem; margin-bottom: 2rem; color: white; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4); position: relative; overflow: hidden;">
                <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: relative; z-index: 1;">
                    <h1 style="font-size: 2.5rem; font-weight: bold; margin-bottom: 0.5rem;">
                        👋 Olá, {{ Auth::user()->name }}!
                    </h1>
                    <p style="font-size: 1.25rem; opacity: 0.95;">Bem-vindo ao teu EventHub</p>
                    <div style="margin-top: 1.5rem; display: inline-block; background: rgba(255,255,255,0.25); backdrop-filter: blur(10px); padding: 0.75rem 1.5rem; border-radius: 50px; border: 2px solid rgba(255,255,255,0.3);">
                        <span style="font-weight: 700; font-size: 1.125rem;">
                            @if(Auth::user()->role === 'admin')
                                🔑 Administrador
                            @elseif(Auth::user()->role === 'organizer')
                                📋 Organizador
                            @else
                                👤 Participante
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Stats Cards - Cores vibrantes -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <!-- Card 1 - Azul vibrante -->
                <div style="background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 1rem; padding: 2rem; color: white; box-shadow: 0 8px 25px rgba(102, 126, 234, 0.35); transform: translateY(0); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 35px rgba(102, 126, 234, 0.5)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(102, 126, 234, 0.35)'">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <div style="font-size: 3rem;">📅</div>
                        <div style="background: rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; font-weight: 600;">
                            TOTAL
                        </div>
                    </div>
                    <div style="font-size: 3rem; font-weight: bold; margin-bottom: 0.5rem;">
                        {{ \App\Models\Event::count() }}
                    </div>
                    <div style="font-size: 1.125rem; opacity: 0.9;">Total de Eventos</div>
                </div>

                <!-- Card 2 - Rosa/Roxo vibrante -->
                <div style="background: linear-gradient(135deg, #f093fb, #f5576c); border-radius: 1rem; padding: 2rem; color: white; box-shadow: 0 8px 25px rgba(240, 147, 251, 0.35); transform: translateY(0); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 35px rgba(240, 147, 251, 0.5)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(240, 147, 251, 0.35)'">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <div style="font-size: 3rem;">🎫</div>
                        <div style="background: rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; font-weight: 600;">
                            ATIVAS
                        </div>
                    </div>
                    <div style="font-size: 3rem; font-weight: bold; margin-bottom: 0.5rem;">
                        {{ Auth::user()->registrations()->count() }}
                    </div>
                    <div style="font-size: 1.125rem; opacity: 0.9;">Minhas Inscrições</div>
                </div>

                <!-- Card 3 - Laranja/Amarelo vibrante -->
                <div style="background: linear-gradient(135deg, #fa709a, #fee140); border-radius: 1rem; padding: 2rem; color: white; box-shadow: 0 8px 25px rgba(250, 112, 154, 0.35); transform: translateY(0); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 35px rgba(250, 112, 154, 0.5)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(250, 112, 154, 0.35)'">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <div style="font-size: 3rem;">🚀</div>
                        <div style="background: rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; font-weight: 600;">
                            FUTUROS
                        </div>
                    </div>
                    <div style="font-size: 3rem; font-weight: bold; margin-bottom: 0.5rem;">
                        {{ \App\Models\Event::where('start_date', '>', now())->count() }}
                    </div>
                    <div style="font-size: 1.125rem; opacity: 0.9;">Próximos Eventos</div>
                </div>
            </div>

            <!-- Quick Actions - Design moderno -->
            <div style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                <h3 style="font-size: 1.5rem; font-weight: bold; color: #1f2937; margin-bottom: 1.5rem; display: flex; align-items: center;">
                    <span style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">⚡ Ações Rápidas</span>
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Botão 1 - Gradiente azul -->
                    <a href="/" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 1.5rem; border-radius: 0.75rem; text-decoration: none; text-align: center; font-weight: 700; font-size: 1.125rem; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 0.5rem;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(102, 126, 234, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(102, 126, 234, 0.3)'">
                        <span style="font-size: 1.5rem;">🔍</span>
                        Descobrir Eventos
                    </a>

                    <!-- Botão 2 - Gradiente rosa -->
                    <a href="{{ route('registrations.my') }}" style="background: linear-gradient(135deg, #f093fb, #f5576c); color: white; padding: 1.5rem; border-radius: 0.75rem; text-decoration: none; text-align: center; font-weight: 700; font-size: 1.125rem; box-shadow: 0 4px 15px rgba(240, 147, 251, 0.3); transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 0.5rem;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(240, 147, 251, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(240, 147, 251, 0.3)'">
                        <span style="font-size: 1.5rem;">🎫</span>
                        Minhas Inscrições
                    </a>

                    <!-- Botão 3 - Gradiente laranja -->
                    <a href="{{ route('events.index') }}" style="background: linear-gradient(135deg, #fa709a, #fee140); color: white; padding: 1.5rem; border-radius: 0.75rem; text-decoration: none; text-align: center; font-weight: 700; font-size: 1.125rem; box-shadow: 0 4px 15px rgba(250, 112, 154, 0.3); transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 0.5rem;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(250, 112, 154, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(250, 112, 154, 0.3)'">
                        <span style="font-size: 1.5rem;">📅</span>
                        Ver Eventos
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>