<div wire:poll.4s>
    {{-- Lista de mensajes --}}
    <div id="chat-box"
         style="height: 420px; overflow-y: auto; padding: 1rem;
                background: #f8f9fa; border-radius: 12px; margin-bottom: 1rem;">

        @forelse($mensajes as $mensaje)
            @php
                $esMio = $mensaje->remitente === (auth()->user()->rol === 'centro' ? 'centro' : 'usuario');
            @endphp

            <div class="d-flex {{ $esMio ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                <div style="max-width: 70%; padding: 10px 14px; border-radius: 18px;
                            background: {{ $esMio ? '#0d6efd' : '#ffffff' }};
                            color: {{ $esMio ? '#ffffff' : '#212529' }};
                            box-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                    <p class="mb-0" style="font-size: 14px;">{{ $mensaje->mensaje }}</p>
                    <p class="mb-0 mt-1" style="font-size: 11px; opacity: 0.7;">
                        {{ \Carbon\Carbon::parse($mensaje->created_at)->format('H:i') }}
                    </p>
                </div>
            </div>
        @empty
            <p class="text-muted text-center mt-5">Aún no hay mensajes. ¡Empieza la conversación!</p>
        @endforelse
    </div>

    {{-- Input --}}
    <div class="d-flex gap-2">
        <input type="text"
               wire:model="texto"
               wire:keydown.enter="enviar"
               class="form-control"
               placeholder="Escribe un mensaje...">
        <button wire:click="enviar" class="btn btn-primary px-4">
            Enviar
        </button>
    </div>

    {{-- Auto-scroll al último mensaje --}}
    <script>
        document.addEventListener('livewire:navigated', scrollChat);
        document.addEventListener('livewire:update', scrollChat);
        function scrollChat() {
            const box = document.getElementById('chat-box');
            if (box) box.scrollTop = box.scrollHeight;
        }
        scrollChat();
    </script>
</div>
