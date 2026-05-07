<!-- Mobile Overlay -->
<div x-show="isSidebarOpen" 
     x-cloak
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click.stop="isSidebarOpen = false"
     class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[100] lg:hidden"
     style="display: none;">
</div>

<aside :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       x-cloak
       class="w-64 sidebar-staff text-slate-300 flex-shrink-0 flex flex-col h-full shadow-2xl overflow-y-auto fixed lg:static inset-y-0 left-0 z-[110] transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0">
    
    <!-- Brand -->
    <div class="h-20 flex items-center justify-between px-8 mb-4 border-b border-white/5">
        <div class="flex items-center gap-3">
            <img src="<?= $base_url ?>/images/logo.png" alt="Logo" class="w-8 h-8 object-contain">
            <span class="text-white font-bold text-lg tracking-tight">AU Inventory</span>
        </div>
        <!-- Close Button (Mobile Only) -->
        <button @click.stop="isSidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 space-y-1">
        <?php
        $current_uri = $_SERVER['REQUEST_URI'];
        $nav_items = [
            ['path' => '/staff/dashboard', 'label' => 'Overview', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />'],
            ['path' => '/staff/inventory', 'label' => 'Asset Catalog', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />'],
            ['path' => '/staff/maintenance', 'label' => 'Maintenance Queue', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />'],
            ['path' => '/staff/rooms', 'label' => 'Rooms', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />'],
            ['path' => '/staff/reports', 'label' => 'Incident Reports', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />'],
            ['path' => '/staff/qrscanner', 'label' => 'QR Scanner', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />'],
        ];

        foreach ($nav_items as $item):
            $is_active = strpos($current_uri, $item['path']) !== false;
            $full_path = $base_url . $item['path'];
        ?>
            <a href="<?= $full_path ?>" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 <?= $is_active ? 'bg-amber-600 text-white shadow-lg shadow-amber-600/20' : 'hover:bg-white/5 hover:text-white' ?>">
                <svg class="mr-3 h-5 w-5 <?= $is_active ? 'text-white' : 'text-slate-400 group-hover:text-white' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <?= $item['icon'] ?>
                </svg>
                <?= $item['label'] ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <!-- Footer Credit -->
    <div class="p-6 mt-auto border-t border-white/5">
        <div class="px-4 py-3 bg-white/5 rounded-xl">
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1 leading-none">Internal Access</p>
            <p class="text-xs text-slate-300 font-medium leading-none">Staff Node-1</p>
        </div>
    </div>
</aside>
