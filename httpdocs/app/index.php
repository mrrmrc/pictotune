<?php
/**
 * PICTOTUNE APP - INTERFACCIA PRINCIPALE
 * Salva come: app/index.php
 */
session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PictoTune - Trasforma le Immagini in Musica</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #667eea;
            --primary-dark: #5a67d8;
            --secondary: #764ba2;
            --success: #48bb78;
            --danger: #f56565;
            --dark: #2d3748;
            --light: #f7fafc;
            --gray: #718096;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 24px;
            font-weight: bold;
        }

        .logo-icon {
            font-size: 32px;
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .credits-badge {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: white;
            color: var(--primary);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Main Grid */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .main-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Card */
        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        }

        .card-title {
            font-size: 20px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Upload Area */
        .upload-area {
            border: 3px dashed rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            padding: 3rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.05);
        }

        .upload-area:hover {
            border-color: white;
            background: rgba(255, 255, 255, 0.1);
        }

        .upload-area.dragover {
            border-color: var(--success);
            background: rgba(72, 187, 120, 0.1);
        }

        .upload-icon {
            font-size: 48px;
            margin-bottom: 1rem;
        }

        .upload-text {
            font-size: 18px;
            margin-bottom: 0.5rem;
        }

        .upload-subtext {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
        }

        /* Preview */
        .preview-container {
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            overflow: hidden;
            position: relative;
        }

        .preview-container img {
            max-width: 100%;
            max-height: 400px;
            border-radius: 8px;
        }

        .preview-placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        /* Analysis Panel */
        .analysis-panel {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
            display: none;
        }

        .analysis-panel.active {
            display: block;
        }

        .analysis-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .analysis-item:last-child {
            border-bottom: none;
        }

        .analysis-label {
            color: rgba(255, 255, 255, 0.7);
        }

        .analysis-value {
            font-weight: 600;
        }

        /* Audio Player */
        .audio-player {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1rem;
            display: none;
        }

        .audio-player.active {
            display: block;
        }

        .audio-controls {
            margin-bottom: 1rem;
        }

        audio {
            width: 100%;
            margin-bottom: 1rem;
        }

        /* Gallery */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .gallery-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .gallery-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .gallery-info {
            padding: 1rem;
            font-size: 14px;
        }

        .gallery-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .gallery-date {
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
        }

        /* Loading */
        .loading {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .loading.active {
            display: block;
        }

        .spinner {
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top: 3px solid white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            color: var(--dark);
            border-radius: 16px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--gray);
        }

        .modal-title {
            font-size: 24px;
            margin-bottom: 1.5rem;
            color: var(--dark);
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Messages */
        .message {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: none;
        }

        .message.active {
            display: block;
        }

        .message.success {
            background: rgba(72, 187, 120, 0.2);
            color: #22543d;
            border: 1px solid rgba(72, 187, 120, 0.5);
        }

        .message.error {
            background: rgba(245, 101, 101, 0.2);
            color: #742a2a;
            border: 1px solid rgba(245, 101, 101, 0.5);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">
            <span class="logo-icon">🎶</span>
            <span>PictoTune</span>
        </div>
        
        <nav class="nav">
            <div class="credits-badge" id="credits-display">
                <span>💎</span>
                <span id="user-credits">0</span>
                <span>Crediti</span>
            </div>
            <button class="btn btn-success" onclick="showCreditsModal()">+ Ricarica</button>
            <button class="btn btn-primary" id="login-btn" onclick="showAuthModal()">Accedi</button>
            <button class="btn btn-primary" id="profile-btn" onclick="showProfile()" style="display:none">👤</button>
        </nav>
    </header>

    <!-- Main Container -->
    <div class="container">
        <!-- Welcome Message -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-size: 36px; margin-bottom: 10px;">Trasforma le tue Foto in Musica 🎵</h1>
            <p style="font-size: 18px; opacity: 0.9;">Carica un'immagine e lascia che l'AI crei la colonna sonora perfetta</p>
        </div>

        <!-- Main Grid -->
        <div class="main-grid">
            <!-- Upload Section -->
            <div class="card">
                <h2 class="card-title">
                    <span>📸</span>
                    <span>Carica Immagine</span>
                </h2>
                
                <div class="upload-area" id="upload-area" onclick="document.getElementById('file-input').click()">
                    <div class="upload-icon">⬆️</div>
                    <div class="upload-text">Trascina qui la tua immagine</div>
                    <div class="upload-subtext">oppure clicca per selezionare</div>
                    <div class="upload-subtext" style="margin-top: 10px;">JPG, PNG, GIF • Max 10MB</div>
                </div>
                
                <input type="file" id="file-input" accept="image/*" style="display: none;">
                
                <div style="display: flex; gap: 10px; margin-top: 1rem;">
                    <button class="btn btn-primary" onclick="openCamera()" style="flex: 1;">
                        📷 Fotocamera
                    </button>
                    <button class="btn btn-primary" onclick="loadSampleImage()" style="flex: 1;">
                        🖼️ Esempio
                    </button>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="card">
                <h2 class="card-title">
                    <span>🎼</span>
                    <span>Anteprima & Generazione</span>
                </h2>
                
                <div class="preview-container" id="preview-container">
                    <div class="preview-placeholder">L'anteprima apparirà qui</div>
                </div>
                
                <div class="analysis-panel" id="analysis-panel">
                    <div class="analysis-item">
                        <span class="analysis-label">Mood rilevato:</span>
                        <span class="analysis-value" id="mood-value">-</span>
                    </div>
                    <div class="analysis-item">
                        <span class="analysis-label">Stile suggerito:</span>
                        <span class="analysis-value" id="style-value">-</span>
                    </div>
                    <div class="analysis-item">
                        <span class="analysis-label">Tempo (BPM):</span>
                        <span class="analysis-value" id="tempo-value">-</span>
                    </div>
                </div>
                
                <button class="btn btn-success" id="generate-btn" onclick="generateMusic()" style="width: 100%; margin-top: 1rem; display: none;">
                    🎵 Genera Musica (10 crediti)
                </button>
                
                <div class="loading" id="loading">
                    <div class="spinner"></div>
                    <div>Generazione in corso...</div>
                    <div style="font-size: 14px; opacity: 0.7; margin-top: 10px;">Questo potrebbe richiedere 30-60 secondi</div>
                </div>
                
                <div class="audio-player" id="audio-player">
                    <audio id="audio-element" controls></audio>
                    <div style="display: flex; gap: 10px;">
                        <button class="btn btn-primary" onclick="downloadAudio()" style="flex: 1;">
                            💾 Scarica MP3
                        </button>
                        <button class="btn btn-primary" onclick="saveToGallery()" style="flex: 1;">
                            ❤️ Salva
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Section -->
        <div class="card" style="margin-top: 2rem;">
            <h2 class="card-title">
                <span>🎨</span>
                <span>Le Mie Creazioni</span>
            </h2>
            
            <div id="gallery-container">
                <div class="empty-state">
                    <div class="empty-state-icon">🎵</div>
                    <p>Accedi per vedere le tue creazioni salvate</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Auth Modal -->
    <div class="modal" id="auth-modal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal('auth-modal')">✕</button>
            
            <!-- Login Form -->
            <div id="login-form">
                <h3 class="modal-title">Accedi a PictoTune</h3>
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" id="login-email" placeholder="email@esempio.com">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-input" id="login-password" placeholder="••••••••">
                </div>
                
                <button class="btn btn-success" onclick="doLogin()" style="width: 100%;">Accedi</button>
                
                <p style="text-align: center; margin-top: 1rem;">
                    Non hai un account? 
                    <a href="#" onclick="showRegisterForm()" style="color: var(--primary);">Registrati</a>
                </p>
            </div>
            
            <!-- Register Form -->
            <div id="register-form" style="display: none;">
                <h3 class="modal-title">Crea Account</h3>
                
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-input" id="register-username" placeholder="username">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" id="register-email" placeholder="email@esempio.com">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-input" id="register-password" placeholder="Minimo 8 caratteri">
                </div>
                
                <button class="btn btn-success" onclick="doRegister()" style="width: 100%;">Registrati</button>
                
                <p style="text-align: center; margin-top: 1rem;">
                    Hai già un account? 
                    <a href="#" onclick="showLoginForm()" style="color: var(--primary);">Accedi</a>
                </p>
            </div>
            
            <div class="message" id="auth-message"></div>
        </div>
    </div>

    <!-- Credits Modal -->
    <div class="modal" id="credits-modal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal('credits-modal')">✕</button>
            <h3 class="modal-title">💎 Ricarica Crediti</h3>
            
            <div style="display: grid; gap: 1rem;">
                <div style="padding: 1.5rem; border: 2px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.3s;"
                     onclick="purchaseCredits(50, 4.99)"
                     onmouseover="this.style.borderColor='var(--primary)'"
                     onmouseout="this.style.borderColor='#e2e8f0'">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-size: 24px; font-weight: bold;">50 Crediti</div>
                            <div style="color: var(--gray); margin-top: 5px;">5 generazioni</div>
                        </div>
                        <div style="font-size: 28px; font-weight: bold; color: var(--primary);">€4.99</div>
                    </div>
                </div>
                
                <div style="padding: 1.5rem; border: 2px solid var(--primary); border-radius: 12px; cursor: pointer; background: rgba(102,126,234,0.05);"
                     onclick="purchaseCredits(200, 14.99)">
                    <div style="position: relative;">
                        <span style="position: absolute; top: -35px; right: 0; background: var(--primary); color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">POPOLARE</span>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-size: 24px; font-weight: bold;">200 Crediti</div>
                                <div style="color: var(--gray); margin-top: 5px;">20 generazioni • Risparmia 25%</div>
                            </div>
                            <div style="font-size: 28px; font-weight: bold; color: var(--primary);">€14.99</div>
                        </div>
                    </div>
                </div>
                
                <div style="padding: 1.5rem; border: 2px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.3s;"
                     onclick="purchaseCredits(500, 29.99)"
                     onmouseover="this.style.borderColor='var(--primary)'"
                     onmouseout="this.style.borderColor='#e2e8f0'">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-size: 24px; font-weight: bold;">500 Crediti</div>
                            <div style="color: var(--gray); margin-top: 5px;">50 generazioni • Risparmia 40%</div>
                        </div>
                        <div style="font-size: 28px; font-weight: bold; color: var(--primary);">€29.99</div>
                    </div>
                </div>
            </div>
            
            <p style="text-align: center; color: var(--gray); margin-top: 1.5rem; font-size: 14px;">
                Pagamento sicuro tramite Gumroad/PayPal
            </p>
        </div>
    </div>

    <script>
        // Global variables
        let currentUser = null;
        let currentImage = null;
        let currentGeneration = null;
        const API_URL = '/api';

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            checkAuth();
            setupEventListeners();
        });

        // Event Listeners
        function setupEventListeners() {
            const fileInput = document.getElementById('file-input');
            const uploadArea = document.getElementById('upload-area');
            
            fileInput.addEventListener('change', handleFileSelect);
            
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });
            
            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('dragover');
            });
            
            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
                if (e.dataTransfer.files.length > 0) {
                    handleFile(e.dataTransfer.files[0]);
                }
            });
        }

        // Auth Functions
        function checkAuth() {
            const token = localStorage.getItem('token');
            if (token) {
                // Verify token
                fetch(API_URL + '/user/profile', {
                    headers: { 'Authorization': 'Bearer ' + token }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.user) {
                        currentUser = data.user;
                        updateUI();
                    }
                })
                .catch(err => {
                    localStorage.removeItem('token');
                });
            }
        }

        function updateUI() {
            if (currentUser) {
                document.getElementById('user-credits').textContent = currentUser.credits || 10;
                document.getElementById('login-btn').style.display = 'none';
                document.getElementById('profile-btn').style.display = 'block';
                loadGallery();
            } else {
                document.getElementById('login-btn').style.display = 'block';
                document.getElementById('profile-btn').style.display = 'none';
            }
        }

        function showAuthModal() {
            document.getElementById('auth-modal').classList.add('active');
        }

        function showRegisterForm() {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'block';
        }

        function showLoginForm() {
            document.getElementById('login-form').style.display = 'block';
            document.getElementById('register-form').style.display = 'none';
        }

        async function doLogin() {
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;
            
            try {
                const response = await fetch(API_URL + '/auth/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    localStorage.setItem('token', data.token);
                    currentUser = data.user;
                    updateUI();
                    closeModal('auth-modal');
                    showMessage('Login effettuato con successo!', 'success');
                } else {
                    showMessage(data.error || 'Credenziali non valide', 'error');
                }
            } catch (err) {
                showMessage('Errore di connessione', 'error');
            }
        }

        async function doRegister() {
            const username = document.getElementById('register-username').value;
            const email = document.getElementById('register-email').value;
            const password = document.getElementById('register-password').value;
            
            if (password.length < 8) {
                showMessage('La password deve essere di almeno 8 caratteri', 'error');
                return;
            }
            
            try {
                const response = await fetch(API_URL + '/auth/register', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ username, email, password })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showMessage('Registrazione completata! Ora puoi accedere', 'success');
                    showLoginForm();
                } else {
                    showMessage(data.error || 'Registrazione fallita', 'error');
                }
            } catch (err) {
                showMessage('Errore di connessione', 'error');
            }
        }

        function showProfile() {
            if (confirm('Vuoi disconnetterti?')) {
                localStorage.removeItem('token');
                currentUser = null;
                updateUI();
                location.reload();
            }
        }

        // File Handling
        function handleFileSelect(e) {
            const file = e.target.files[0];
            if (file) handleFile(file);
        }

        function handleFile(file) {
            if (!file.type.startsWith('image/')) {
                alert('Seleziona un file immagine valido');
                return;
            }
            
            if (file.size > 10 * 1024 * 1024) {
                alert('Il file non può superare i 10MB');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = (e) => {
                currentImage = e.target.result;
                displayImage(currentImage);
                analyzeImage();
            };
            reader.readAsDataURL(file);
        }

        function displayImage(imageSrc) {
            const container = document.getElementById('preview-container');
            container.innerHTML = `<img src="${imageSrc}" alt="Preview">`;
            document.getElementById('generate-btn').style.display = 'block';
        }

        function analyzeImage() {
            // Simulated analysis
            const moods = ['Sereno', 'Energico', 'Melanconico', 'Gioioso', 'Misterioso'];
            const styles = ['Ambient', 'Elettronica', 'Orchestrale', 'Jazz', 'Pop'];
            const tempos = [60, 90, 120, 140, 180];
            
            const randomIndex = Math.floor(Math.random() * moods.length);
            
            document.getElementById('mood-value').textContent = moods[randomIndex];
            document.getElementById('style-value').textContent = styles[randomIndex];
            document.getElementById('tempo-value').textContent = tempos[randomIndex] + ' BPM';
            
            document.getElementById('analysis-panel').classList.add('active');
        }

        function loadSampleImage() {
            // Create gradient sample image
            const canvas = document.createElement('canvas');
            canvas.width = 800;
            canvas.height = 600;
            const ctx = canvas.getContext('2d');
            
            const gradient = ctx.createLinearGradient(0, 0, 800, 600);
            gradient.addColorStop(0, '#667eea');
            gradient.addColorStop(0.5, '#764ba2');
            gradient.addColorStop(1, '#f687b3');
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, 800, 600);
            
            currentImage = canvas.toDataURL();
            displayImage(currentImage);
            analyzeImage();
        }

        async function generateMusic() {
            if (!currentUser) {
                showAuthModal();
                return;
            }
            
            if (currentUser.credits < 10) {
                showCreditsModal();
                alert('Non hai abbastanza crediti. Ricarica per continuare.');
                return;
            }
            
            const loading = document.getElementById('loading');
            const generateBtn = document.getElementById('generate-btn');
            
            loading.classList.add('active');
            generateBtn.style.display = 'none';
            
            // Simulate generation (replace with actual API call)
            setTimeout(() => {
                loading.classList.remove('active');
                
                // Simulated audio URL
                const audioUrl = '/audio/sample.mp3';
                document.getElementById('audio-element').src = audioUrl;
                document.getElementById('audio-player').classList.add('active');
                
                // Update credits
                currentUser.credits -= 10;
                updateUI();
                
                currentGeneration = {
                    id: Date.now(),
                    image: currentImage,
                    audioUrl: audioUrl,
                    mood: document.getElementById('mood-value').textContent
                };
            }, 3000);
        }

        function downloadAudio() {
            if (currentGeneration) {
                const a = document.createElement('a');
                a.href = currentGeneration.audioUrl;
                a.download = 'pictotune-' + Date.now() + '.mp3';
                a.click();
            }
        }

        function saveToGallery() {
            if (currentGeneration) {
                const gallery = JSON.parse(localStorage.getItem('gallery') || '[]');
                gallery.unshift(currentGeneration);
                localStorage.setItem('gallery', JSON.stringify(gallery));
                loadGallery();
                alert('Salvato nella tua collezione!');
            }
        }

        function loadGallery() {
            const gallery = JSON.parse(localStorage.getItem('gallery') || '[]');
            const container = document.getElementById('gallery-container');
            
            if (gallery.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-state-icon">🎵</div>
                        <p>Nessuna creazione salvata ancora</p>
                    </div>
                `;
                return;
            }
            
            container.innerHTML = `
                <div class="gallery-grid">
                    ${gallery.map(item => `
                        <div class="gallery-item">
                            <img src="${item.image}" class="gallery-image" alt="Gallery">
                            <div class="gallery-info">
                                <div class="gallery-title">${item.mood}</div>
                                <div class="gallery-date">${new Date(item.id).toLocaleDateString()}</div>
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;
        }

        function openCamera() {
            alert('Funzione fotocamera in sviluppo');
        }

        function showCreditsModal() {
            document.getElementById('credits-modal').classList.add('active');
        }

        function purchaseCredits(amount, price) {
            alert(`Reindirizzamento a Gumroad per ${amount} crediti a €${price}`);
            // Implement Gumroad integration
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        function showMessage(text, type) {
            const msg = document.getElementById('auth-message');
            msg.textContent = text;
            msg.className = 'message active ' + type;
            setTimeout(() => {
                msg.classList.remove('active');
            }, 3000);
        }
    </script>
</body>
</html>