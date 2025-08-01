<!-- Navbar (se mantiene igual) -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl
        {{ str_contains(Request::url(), 'virtual-reality') == true ? ' mt-3 mx-3 bg-primary' : '' }}" id="navbarBlur"
        data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-black" href="javascript:;">Inicio</a></li>
                <li class="breadcrumb-item text-sm text-black active" aria-current="page">{{ $title }}</li>
            </ol>
            <h6 class="font-weight-bolder text-black mb-0">{{ $title }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <!-- Botón del Asistente en Navbar -->
                
                
            </div>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <form role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="nav-link text-black font-weight-bold px-0">
                            <i class="fa fa-user me-sm-1"></i>
                            <span class="d-sm-inline d-none">Salir</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->

<!-- Chatbot Flotante Mejorado -->
<!-- Chatbot Flotante Mejorado -->


<script>
    // Mostrar / Ocultar chatbot con el botón del navbar
    document.getElementById('chatbot-trigger-nav').addEventListener('click', () => {
        const container = document.getElementById('chatbot-container');
        container.classList.toggle('d-none');
    });

    // Cerrar chatbot con la "X"
    document.getElementById('close-chatbot').addEventListener('click', () => {
        document.getElementById('chatbot-container').classList.add('d-none');
    });

    // Función para enviar pregunta y mostrar respuesta
    document.getElementById('send-chatbot').addEventListener('click', () => {
        const preguntaEl = document.getElementById('preguntaChat');
        const pregunta = preguntaEl.value.trim();
        const chatBody = document.getElementById('chat-body');

        if (!pregunta) return;

        // Mostrar pregunta en chat
        const mensajeUsuario = document.createElement('div');
        mensajeUsuario.innerHTML = `<strong>Tú:</strong> ${pregunta}`;
        mensajeUsuario.classList.add('mb-2');
        chatBody.appendChild(mensajeUsuario);
        preguntaEl.value = '';
        chatBody.scrollTop = chatBody.scrollHeight;

        // Petición a backend
        fetch('/chat-ia', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ pregunta })
        })
        .then(res => res.json())
        .then(data => {
            const mensajeIA = document.createElement('div');
            mensajeIA.innerHTML = `<strong>IA:</strong> ${data.respuesta}`;
            mensajeIA.classList.add('mb-3');
            chatBody.appendChild(mensajeIA);
            chatBody.scrollTop = chatBody.scrollHeight;
        })
        .catch(() => {
            const errorMsg = document.createElement('div');
            errorMsg.innerHTML = `<strong>IA:</strong> ❌ Error al conectar con el servidor.`;
            errorMsg.classList.add('text-danger', 'mb-3');
            chatBody.appendChild(errorMsg);
            chatBody.scrollTop = chatBody.scrollHeight;
        });
    });
</script>

