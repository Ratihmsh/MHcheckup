<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tes Kesehatan Mental DASS — Ariva Consulta')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: #f0f4f8;
            min-height: 100vh;
        }

        /* NAVBAR */
        .navbar-brand img {
            height: 36px;
        }

        .navbar-ariva {
            background: linear-gradient(135deg, #1a56db 0%, #1e40af 100%);
            box-shadow: 0 2px 12px rgba(26,86,219,0.15);
        }

        /* CARD */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.07);
        }

        .card-header-blue {
            background: linear-gradient(135deg, #1a56db 0%, #1e40af 100%);
            border-radius: 16px 16px 0 0 !important;
            padding: 20px 28px;
        }

        /* BUTTONS */
        .btn-primary {
            background: linear-gradient(135deg, #1a56db 0%, #1e40af 100%);
            border: none;
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 24px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1e40af 0%, #1a56db 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(26,86,219,0.3);
        }

        .btn-outline-primary {
            border-color: #1a56db;
            color: #1a56db;
            border-radius: 10px;
            font-weight: 600;
        }

        /* FORM */
        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            padding: 10px 14px;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #1a56db;
            box-shadow: 0 0 0 3px rgba(26,86,219,0.1);
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #374151;
            margin-bottom: 6px;
        }

        /* BADGE KATEGORI */
        .badge-normal     { background-color: #d1fae5; color: #065f46; }
        .badge-ringan     { background-color: #fef9c3; color: #713f12; }
        .badge-sedang     { background-color: #fed7aa; color: #7c2d12; }
        .badge-Tinggi      { background-color: #fecaca; color: #7f1d1d; }
        .badge-sangat-Tinggi { background-color: #f3e8ff; color: #4a044e; }

        .badge-kategori {
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* FOOTER */
        .footer-ariva {
            background: #1e293b;
            color: #94a3b8;
            padding: 20px 0;
            margin-top: 60px;
            font-size: 0.85rem;
        }

        /* ALERT */
        .alert {
            border-radius: 12px;
            border: none;
        }

        /* RESPONSIVE */
        @media (max-width: 576px) {
            .card-header-blue { padding: 16px 20px; }
            .card-body { padding: 20px !important; }
            .form-control, .form-select { font-size: 16px; } /* Cegah zoom di iOS */
            .btn-primary { padding: 10px 18px; font-size: 0.9rem; }
            .footer-ariva { margin-top: 40px; font-size: 0.78rem; }
        }

        @media (max-width: 768px) {
            main.py-4 { padding-top: 16px !important; padding-bottom: 16px !important; }
        }
    </style>

    @yield('styles')
</head>
<body>

    <!-- NAVBAR -->
   <nav class="navbar navbar-dark navbar-ariva py-2">
    <div class="container">
        @php
            $globalSettings = \Illuminate\Support\Facades\DB::table('settings')->first();
        @endphp
        <a class="navbar-brand" href="{{ route('landing') }}">
            <img src="{{ $globalSettings && $globalSettings->logo ? asset($globalSettings->logo) : asset('images/logo.jpg') }}" alt="{{ $globalSettings->nama_biro ?? 'Ariva Consulta' }}"
                style="height:38px; max-width:160px; object-fit:contain;">
        </a>
        <span class="text-white-50 small d-none d-sm-inline">{{ $globalSettings->nama_biro ?? 'Biro Psikologi Sidoarjo' }}</span>
    </div>
</nav>
    <!-- KONTEN -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer-ariva text-center">
        <div class="container">
            <p class="mb-0">© {{ date('Y') }} {{ $globalSettings->nama_biro ?? 'Biro Psikologi Ariva Consulta' }}. Semua hak dilindungi.</p>
        </div>
    </footer>

    <!-- Floating Chatbot Widget -->
    <div class="chatbot-container" id="chatbotContainer">
        <!-- Chat Button -->
        <button class="chatbot-btn" id="chatbotBtn" onclick="toggleChatbot()">
            <i class="bi bi-chat-dots-fill text-white fs-3"></i>
            <span class="chatbot-notification" id="chatbotNotif" style="display: none;">1</span>
        </button>

        <!-- Chat Box -->
        <div class="chatbot-box" id="chatbotBox" style="display: none;">
            <!-- Header -->
            <div class="chatbot-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="chatbot-avatar bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:36px; height:36px;">
                        <i class="bi bi-robot fs-5"></i>
                    </div>
                    <div>
                        <h6 class="text-white fw-bold mb-0" style="font-size:0.9rem;">Dr. Ariva (AI Assistant)</h6>
                        <small style="color: rgba(255,255,255,0.7); font-size: 0.72rem;"><span class="chatbot-status-dot"></span>Online</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-sm text-white p-0 border-0" onclick="resetChatbot()" title="Mulai Ulang Chat" style="font-size: 1.1rem;">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </button>
                    <button class="btn btn-sm text-white p-0 border-0" onclick="toggleChatbot()" title="Tutup Chat" style="font-size: 1.1rem;">
                        <i class="bi bi-dash-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Messages Area -->
            <div class="chatbot-messages" id="chatbotMessages">
                <div class="chat-message bot">
                    <div class="message-bubble">
                        Halo! Saya Dr. Ariva, asisten psikologis virtual Ariva Consulta Sidoarjo. Ada yang sedang ingin kamu ceritakan atau keluhkan hari ini? Saya di sini untuk mendengarkan.
                    </div>
                </div>
            </div>

            <!-- Typing Indicator -->
            <div class="chatbot-typing" id="chatbotTyping" style="display: none;">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <!-- Input Area -->
            <div class="chatbot-input-area">
                <input type="text" id="chatbotInput" placeholder="Ceritakan yang kamu rasakan..." onkeypress="handleChatEnter(event)">
                <button id="chatbotSendBtn" onclick="sendChatbotMessage()">
                    <i class="bi bi-send-fill text-primary fs-5"></i>
                </button>
            </div>
        </div>
    </div>

    <style>
        /* Chatbot Container */
        .chatbot-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 1000;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Floating Button */
        .chatbot-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1a56db 0%, #1e40af 100%);
            border: none;
            box-shadow: 0 4px 16px rgba(26,86,219,0.3);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            position: relative;
        }
        .chatbot-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(26,86,219,0.4);
        }
        
        .chatbot-notification {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #ef4444;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
        }

        /* Chat Box */
        .chatbot-box {
            width: 350px;
            height: 480px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: absolute;
            bottom: 75px;
            right: 0;
            border: 1px solid #f1f5f9;
            animation: chatBoxFadeIn 0.3s ease-out;
        }
        
        @keyframes chatBoxFadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Header */
        .chatbot-header {
            background: linear-gradient(135deg, #1a56db 0%, #1e40af 100%);
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #fff;
        }
        .chatbot-status-dot {
            display: inline-block;
            width: 6px;
            height: 6px;
            background: #10b981;
            border-radius: 50%;
            margin-right: 4px;
        }

        /* Messages Area */
        .chatbot-messages {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .chat-message {
            display: flex;
            max-width: 85%;
        }
        .chat-message.bot {
            align-self: flex-start;
        }
        .chat-message.user {
            align-self: flex-end;
        }
        .message-bubble {
            padding: 10px 14px;
            border-radius: 16px;
            font-size: 0.85rem;
            line-height: 1.5;
            white-space: pre-line;
        }
        .chat-message.bot .message-bubble {
            background: #fff;
            color: #1e293b;
            border-top-left-radius: 2px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
            border: 1px solid #f1f5f9;
        }
        .chat-message.user .message-bubble {
            background: #1a56db;
            color: #fff;
            border-top-right-radius: 2px;
        }

        /* Input Area */
        .chatbot-input-area {
            padding: 12px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 8px;
            background: #fff;
        }
        .chatbot-input-area input {
            flex: 1;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 8px 14px;
            font-size: 0.85rem;
            outline: none;
        }
        .chatbot-input-area input:focus {
            border-color: #1a56db;
        }
        .chatbot-input-area button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Typing Indicator Animation */
        .chatbot-typing {
            align-self: flex-start;
            background: #fff;
            border: 1px solid #f1f5f9;
            padding: 10px 18px;
            border-radius: 16px;
            border-top-left-radius: 2px;
            display: flex;
            gap: 4px;
            margin-left: 16px;
            margin-bottom: 12px;
            width: fit-content;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
        }
        .chatbot-typing span {
            width: 6px;
            height: 6px;
            background: #94a3b8;
            border-radius: 50%;
            animation: typing 1.4s infinite ease-in-out;
        }
        .chatbot-typing span:nth-child(2) { animation-delay: 0.2s; }
        .chatbot-typing span:nth-child(3) { animation-delay: 0.4s; }
        
        @keyframes typing {
            0%, 100%, 80% { transform: scale(0.6); opacity: 0.4; }
            40% { transform: scale(1); opacity: 1; }
        }

        /* Responsive Mobile */
        @media (max-width: 480px) {
            .chatbot-container { bottom: 16px; right: 16px; }
            .chatbot-box { width: 310px; height: 420px; bottom: 70px; }
            .chatbot-btn { width: 52px; height: 52px; }
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleChatbot() {
            const box = document.getElementById('chatbotBox');
            const notif = document.getElementById('chatbotNotif');
            if (box.style.display === 'none') {
                box.style.display = 'flex';
                notif.style.display = 'none';
                // Scroll to bottom
                const messages = document.getElementById('chatbotMessages');
                messages.scrollTop = messages.scrollHeight;
                
                // Focus input
                setTimeout(() => document.getElementById('chatbotInput').focus(), 100);
            } else {
                box.style.display = 'none';
            }
        }

        function handleChatEnter(event) {
            if (event.key === 'Enter') {
                sendChatbotMessage();
            }
        }

        function sendChatbotMessage() {
            const input = document.getElementById('chatbotInput');
            const message = input.value.trim();
            if (message === '') return;

            input.value = '';
            appendMessage('user', message);

            // Show typing indicator
            const typing = document.getElementById('chatbotTyping');
            const messagesArea = document.getElementById('chatbotMessages');
            typing.style.display = 'flex';
            messagesArea.appendChild(typing);
            messagesArea.scrollTop = messagesArea.scrollHeight;

            // CSRF Token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Send via AJAX
            fetch('{{ route("chatbot.send") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message: message })
            })
            .then(res => {
                if (!res.ok) throw new Error('Network response error');
                return res.json();
            })
            .then(data => {
                typing.style.display = 'none';
                appendMessage('bot', data.reply);
            })
            .catch(err => {
                typing.style.display = 'none';
                appendMessage('bot', 'Maaf, sepertinya ada gangguan koneksi. Mari coba mengobrol beberapa saat lagi.');
                console.error(err);
            });
        }

        function appendMessage(sender, text) {
            const messagesArea = document.getElementById('chatbotMessages');
            const wrapper = document.createElement('div');
            wrapper.className = `chat-message ${sender}`;
            
            const bubble = document.createElement('div');
            bubble.className = 'message-bubble';
            bubble.textContent = text;
            
            wrapper.appendChild(bubble);
            messagesArea.appendChild(wrapper);
            messagesArea.scrollTop = messagesArea.scrollHeight;
        }

        function resetChatbot() {
            if (!confirm('Apakah kamu ingin memulai obrolan baru dan menghapus riwayat obrolan ini?')) return;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch('{{ route("chatbot.reset") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const messagesArea = document.getElementById('chatbotMessages');
                    messagesArea.innerHTML = `
                        <div class="chat-message bot">
                            <div class="message-bubble">
                                Halo! Obrolan telah di-reset. Saya Dr. Ariva, asisten psikologis virtual Ariva Consulta Sidoarjo. Ada yang sedang ingin kamu ceritakan atau keluhkan hari ini? Saya di sini untuk mendengarkan.
                            </div>
                        </div>
                    `;
                }
            })
            .catch(err => console.error(err));
        }
    </script>
    @yield('scripts')
</body>
</html>
