<?php
function vite($entry_point) {
    // Determine dynamically if Vite dev server is running
    // A robust approach involves pinging the server or using a touch file.
    // For this demonstration, we'll try to reach it directly.
    $dev_server = 'http://localhost:5173/';
    
    // Check if the development server is running via curl
    $ch = curl_init($dev_server);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 100);
    // Suppress curl output
    $is_dev = @curl_exec($ch) !== false;
    curl_close($ch);

    if ($is_dev) {
        return '
            <script type="module" src="' . $dev_server . '@vite/client"></script>
            <script type="module" src="' . $dev_server . ltrim($entry_point, '/') . '"></script>
        ';
    } else {
        $manifestPath = __DIR__ . '/../../public/build/.vite/manifest.json';
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            if (isset($manifest[$entry_point])) {
                $file = $manifest[$entry_point]['file'];
                $css = '';
                if (isset($manifest[$entry_point]['css'])) {
                    foreach ($manifest[$entry_point]['css'] as $cssFile) {
                        $css .= '<link rel="stylesheet" href="/build/' . $cssFile . '">';
                    }
                }
                return $css . '<script type="module" src="/build/' . $file . '"></script>';
            }
        }
    }
    return '';
}
?>
<?php $base_url = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= $base_url ?>/images/logo.png">
    <title><?= htmlspecialchars($_ENV['APP_NAME'] ?? 'AU Inventory') ?></title>
    <!-- Vite Integration -->
    <?= vite('resources/js/app.js') ?>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center font-sans antialiased text-slate-800">
    
    <div class="max-w-3xl w-full mx-4 bg-white p-10 rounded-2xl shadow-xl border border-slate-100 flex flex-col items-center">
        <h1 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 mb-6 tracking-tight text-center">
            Vue-like Experience, PHP Backend
        </h1>
        <p class="text-slate-500 text-lg mb-10 text-center max-w-lg">
            Welcome to your Custom PHP MVC application. Fully equipped with **Tailwind CSS**, **Vite** HMR, and the reactive power of **Alpine.js**.
        </p>

        <!-- Alpine.js Demonstration -->
        <div x-data="{ count: 0, hover: false }" 
             @mouseenter="hover = true" 
             @mouseleave="hover = false"
             class="bg-gradient-to-br from-indigo-50 to-blue-50 p-8 rounded-xl text-center border border-indigo-100 shadow-sm w-full max-w-md transition-all duration-300"
             :class="hover ? 'shadow-md ring-2 ring-indigo-200' : ''">
             
            <h2 class="text-2xl font-bold text-indigo-900 mb-2">Alpine.js Counter</h2>
            <p class="text-indigo-600 font-medium text-sm mb-8 bg-indigo-100 inline-block px-3 py-1 rounded-full">Interactive Demo</p>
            
            <div class="flex items-center justify-center gap-8">
                <button @click="count--" class="w-14 h-14 flex items-center justify-center bg-white text-indigo-600 font-black text-2xl rounded-full shadow hover:bg-indigo-600 hover:text-white transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-indigo-300">
                    -
                </button>
                <div class="flex flex-col items-center justify-center w-20">
                    <span class="text-5xl font-black text-indigo-700 tabular-nums transition-all" x-text="count" :class="{ 'scale-110 text-blue-600': count % 5 === 0 && count !== 0 }">0</span>
                </div>
                <button @click="count++" class="w-14 h-14 flex items-center justify-center bg-indigo-600 text-white font-black text-2xl rounded-full shadow hover:bg-indigo-700 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-indigo-300">
                    +
                </button>
            </div>
            
            <div style="min-height: 24px;" class="mt-6 flex justify-center">
                <div x-show="count >= 10" x-transition.opacity.duration.500ms class="text-emerald-600 font-bold bg-emerald-100 px-4 py-1.5 rounded-full text-sm inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    You reached 10!
                </div>
            </div>
        </div>
    </div>
</body>
</html>
