<?php $title = 'QR Scanner' ?>

<!-- Move script to top to ensure availability -->
<script src="https://unpkg.com/html5-qrcode"></script>

<div class="space-y-8 flex flex-col items-center" x-data="qrScanner" x-init="initScanner()">
    <!-- Header Section -->
    <div class="text-center max-w-lg">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight italic">Scan Asset Tag</h1>
        <p class="text-slate-500 mt-2 font-medium">Position the QR code within the frame to automatically view asset information.</p>
    </div>

    <!-- Scanner Interface -->
    <div class="w-full max-w-md aspect-square bg-slate-900 rounded-[3rem] shadow-2xl relative overflow-hidden border-8 border-white/10">
        <!-- Live Camera View -->
        <div id="reader" class="absolute inset-0 z-0"></div>

        <!-- Error / Loading States -->
        <div x-show="errorMessage || !window.isSecureContext" class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center bg-slate-900 z-50">
            <div class="w-16 h-16 bg-rose-500/20 text-rose-500 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m0 0v2m0-2h2m-2 0H10m4-11a4 4 0 11-8 0 4 4 0 018 0zM7 10a5 5 0 0110 0v4a5 5 0 01-10 0V10z" /></svg>
            </div>
            
            <template x-if="!window.isSecureContext">
                <div>
                    <h3 class="text-white font-black italic text-lg mb-2 tracking-tight">Insecure Context</h3>
                    <p class="text-slate-400 text-xs font-medium leading-relaxed mb-6">Camera access requires a secure (HTTPS) connection on mobile devices.</p>
                </div>
            </template>
            
            <template x-if="window.isSecureContext && errorMessage">
                <div>
                    <h3 class="text-white font-black italic text-lg mb-2">Camera Error</h3>
                    <p class="text-slate-400 text-xs font-medium leading-relaxed mb-6" x-text="errorMessage"></p>
                </div>
            </template>

            <div class="flex flex-col items-center gap-4">
                <button @click="initScanner()" class="px-8 py-3 bg-indigo-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-indigo-700 shadow-xl shadow-indigo-600/20 active:scale-95 transition-all">
                    Retry Activation
                </button>
            </div>
        </div>

        <!-- Scanning Overlay -->
        <div x-show="scanning" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none z-10">
            <div class="w-64 h-64 border-2 border-indigo-400/30 rounded-3xl relative">
                <div class="absolute -top-1 -left-1 w-8 h-8 border-t-4 border-l-4 border-indigo-400 rounded-tl-xl"></div>
                <div class="absolute -top-1 -right-1 w-8 h-8 border-t-4 border-r-4 border-indigo-400 rounded-tr-xl"></div>
                <div class="absolute -bottom-1 -left-1 w-8 h-8 border-b-4 border-l-4 border-indigo-400 rounded-bl-xl"></div>
                <div class="absolute -bottom-1 -right-1 w-8 h-8 border-b-4 border-r-4 border-indigo-400 rounded-br-xl"></div>
                <div class="absolute inset-x-0 top-0 h-0.5 bg-indigo-400/80 shadow-[0_0_15px_rgba(129,140,248,0.8)] animate-scan-staff"></div>
            </div>
            <p class="text-white/50 text-[10px] font-bold uppercase tracking-widest mt-8">Align QR code here</p>
        </div>

        <!-- Status Badge Container -->
        <div class="absolute bottom-8 inset-x-0 flex flex-col items-center gap-4 z-20">
            <div id="status-badge" class="px-4 py-1.5 bg-slate-800/80 backdrop-blur-md rounded-full text-[10px] font-bold text-slate-300 border border-white/5 flex items-center gap-2">
                <template x-if="scanning">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                        READY TO SCAN
                    </div>
                </template>
                <template x-if="!scanning && !errorMessage && window.isSecureContext">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-slate-500"></div>
                        INITIALIZING...
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Instructions Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full max-w-2xl mt-4">
        <div class="bg-indigo-50/50 p-6 rounded-[2rem] border border-indigo-100/50 flex gap-4">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-black shrink-0">1</div>
            <div>
                <h4 class="font-black text-slate-800 text-sm uppercase tracking-tight">Point & Focus</h4>
                <p class="text-xs text-slate-500 mt-1">Ensure the QR code is centered and within the frame.</p>
            </div>
        </div>
        <div class="bg-emerald-50/50 p-6 rounded-[2rem] border border-emerald-100/50 flex gap-4">
            <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white font-black shrink-0">2</div>
            <div>
                <h4 class="font-black text-slate-800 text-sm uppercase tracking-tight">Auto Sync</h4>
                <p class="text-xs text-slate-500 mt-1">The system will automatically open the asset profile.</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('qrScanner', () => ({
        scanning: false,
        hasCamera: false,
        errorMessage: '',
        html5QrCode: null,
        currentFacingMode: 'environment',
        
        async initScanner() {
            try {
                await new Promise(resolve => setTimeout(resolve, 200));
                this.html5QrCode = new Html5Qrcode('reader');
                const cameras = await Html5Qrcode.getCameras();
                if (cameras && cameras.length > 0) {
                    this.hasCamera = true;
                    this.startScanning();
                } else {
                    this.errorMessage = 'No cameras detected on this device.';
                }
            } catch (err) {
                this.errorMessage = 'Camera access denied. Please enable permissions.';
                console.error(err);
            }
        },

        async startScanning() {
            if (!this.html5QrCode) return;
            this.scanning = true;
            this.errorMessage = '';

            const config = { 
                fps: 15, 
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0
            };

            try {
                await this.html5QrCode.start(
                    { facingMode: this.currentFacingMode }, 
                    config,
                    (decodedText) => this.onScanSuccess(decodedText)
                );
            } catch (err) {
                this.errorMessage = 'Failed to start camera. Use HTTPS.';
                this.scanning = false;
            }
        },

        async stopScanning() {
            if (this.html5QrCode && this.scanning) {
                await this.html5QrCode.stop();
                this.scanning = false;
            }
        },

        onScanSuccess(decodedText) {
            this.stopScanning();
            document.getElementById('status-badge').innerHTML = 'REDIRECTING...';
            
            const cleanText = decodedText.trim();
            if (cleanText.startsWith('http')) {
                window.location.href = cleanText;
            } else {
                window.location.href = '/au_inventory/public/staff/qrscanner/lookup?tag=' + encodeURIComponent(cleanText);
            }
        }
    }));
});
</script>

<style>
    @keyframes scan-staff {
        0%, 100% { top: 0; opacity: 1; }
        50% { top: 100%; opacity: 0.5; }
    }
    .animate-scan-staff {
        animation: scan-staff 2.5s cubic-bezier(0.4, 0, 0.2, 1) infinite;
    }
    #reader video {
        object-fit: cover !important;
        width: 100% !important;
        height: 100% !important;
        border-radius: 2.5rem !important;
    }
    #reader__dashboard_section_csr, #reader__dashboard_section_fsr { display: none !important; }
</style>
