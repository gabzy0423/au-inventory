<?php
$base_url = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= $base_url ?>/images/logo.png">
    <title><?= $title ?? 'Admin' ?> | AU Inventory</title>
    <!-- Styling & Frameworks -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sidebar-gradient {
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        }

        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="min-h-screen" x-data="{ isSidebarOpen: false }" @keydown.escape="isSidebarOpen = false">
    <div class="flex h-screen overflow-hidden relative">
        <!-- Sidebar -->
        <?php require_once __DIR__ . '/sidebar.php' ?>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <?php require_once __DIR__ . '/header.php' ?>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto px-4 sm:px-8 py-8">
                <div class="max-w-7xl mx-auto">
                    <?= $content ?? '' ?>

                    <!-- Footer -->
                    <?php require_once __DIR__ . '/footer.php' ?>
                </div>
            </main>
        </div>
    </div>
    <div id="modal-portal"></div>

    <!-- Security Notifications -->
    <?php if (isset($_GET['error']) && $_GET['error'] === 'unauthorized'): ?>
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
            x-cloak
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-y-20 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed bottom-8 z-[200] w-full max-w-md px-6" style="right: 2rem; left: auto;">
            <div
                class="bg-rose-600 text-white p-5 rounded-[2.5rem] shadow-2xl shadow-rose-600/40 flex items-center gap-5 border border-rose-500/50 backdrop-blur-xl">
                <div class="w-14 h-14 bg-white/20 rounded-3xl flex items-center justify-center shrink-0 shadow-inner">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-black text-[10px] uppercase tracking-[0.2em] opacity-80 leading-none italic">Security
                        Alert</h4>
                    <p class="text-[13px] font-black mt-1 leading-tight tracking-tight">Unauthorized Access Attempt</p>
                </div>
                <button @click="show = false" class="p-3 hover:bg-white/10 rounded-2xl transition-all active:scale-90">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    <?php endif; ?>
</body>


</html>