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
       class="w-64 sidebar-gradient text-slate-300 flex-shrink-0 flex flex-col h-full shadow-2xl overflow-y-auto fixed lg:static inset-y-0 left-0 z-[110] transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0">
    <!-- Brand -->
    <div class="h-20 flex items-center justify-between px-8 mb-4 border-b border-white/5">
        <div class="flex items-center gap-3">
            <img src="<?= $base_url ?>/images/logo.png" alt="Logo" class="w-8 h-8 object-contain">
            <span class="text-white font-bold text-lg tracking-tight">AU Inventory</span>
        </div>
        <!-- Close Button (Mobile Only) -->
        <button @click.stop="isSidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 space-y-1">
        <?php
        $current_uri = $_SERVER['REQUEST_URI'];

        // Define sub-items for Inventory
        $inventory_sub_items = [
            ['path' => '/admin/inventory', 'label' => 'All Assets'],
            ['path' => '/admin/inventory/create', 'label' => 'Register Asset'],
            ['path' => '/admin/inventory/archive', 'label' => 'Archived Assets'],
        ];

        // Define sub-items for Categories
        $category_sub_items = [
            ['path' => '/admin/categories', 'label' => 'All Categories'],
            ['path' => '/admin/categories/create', 'label' => 'Register Category'],
            ['path' => '/admin/categories/archive', 'label' => 'Archive'],
        ];

        // Define sub-items for Rooms
        $room_sub_items = [
            ['path' => '/admin/rooms', 'label' => 'All Rooms'],
            ['path' => '/admin/rooms/create', 'label' => 'Register Room'],
            ['path' => '/admin/rooms/archive', 'label' => 'Archived'],
        ];

        // Define sub-items for Users
        $user_sub_items = [
            ['path' => '/admin/users', 'label' => 'All Users'],
            ['path' => '/admin/users/create', 'label' => 'Register User'],
            ['path' => '/admin/users/archive', 'label' => 'Archived'],
        ];

        $nav_items = [
            ['path' => '/admin/dashboard', 'label' => 'Dashboard', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />'],
            [
                'label' => 'Inventory',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />',
                'sub_items' => $inventory_sub_items,
                'parent_path' => '/admin/inventory'
            ],
            [
                'label' => 'Categories',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />',
                'sub_items' => $category_sub_items,
                'parent_path' => '/admin/categories'
            ],
            [
                'label' => 'Rooms',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />',
                'sub_items' => $room_sub_items,
                'parent_path' => '/admin/rooms'
            ],
            ['path' => '/admin/maintenance', 'label' => 'Maintenance', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />'],
            ['path' => '/admin/reports', 'label' => 'Reports', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />'],
            [
                'label' => 'Users',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />',
                'sub_items' => $user_sub_items,
                'parent_path' => '/admin/users'
            ],
        ];

        foreach ($nav_items as $item):
            if (isset($item['sub_items'])) {
                $is_parent_active = strpos($current_uri, $item['parent_path']) !== false;
                ?>
                <div x-data="{ open: <?= $is_parent_active ? 'true' : 'false' ?> }">
                    <button @click="open = !open"
                        class="w-full group flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 <?= $is_parent_active ? 'bg-indigo-600/10 text-indigo-400' : 'hover:bg-white/5 hover:text-white' ?>">
                        <div class="flex items-center">
                            <svg class="mr-3 h-5 w-5 <?= $is_parent_active ? 'text-indigo-400' : 'text-slate-400 group-hover:text-white' ?>"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <?= $item['icon'] ?>
                            </svg>
                            <?= $item['label'] ?>
                        </div>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="pl-11 pr-4 py-2 space-y-1">
                        <?php foreach ($item['sub_items'] as $sub):
                            // Precise matching for sub-items
                            if ($sub['path'] === '/admin/inventory/edit') {
                                $is_sub_active = (strpos($current_uri, '/admin/inventory/edit') !== false);
                            } else {
                                $is_sub_active = ($current_uri === $base_url . $sub['path'] || $current_uri === $base_url . $sub['path'] . '/');
                                // Special case: if on edit page, "All Assets" or "All Categories" should not be active
                                if (
                                    (strpos($current_uri, '/admin/inventory/edit') !== false && $sub['path'] === '/admin/inventory') ||
                                    (strpos($current_uri, '/admin/categories/edit') !== false && $sub['path'] === '/admin/categories')
                                ) {
                                    $is_sub_active = false;
                                }
                            }
                            ?>
                            <a href="<?= $base_url . $sub['path'] ?>"
                                class="block px-4 py-2 text-xs font-medium rounded-lg transition-all duration-200 <?= $is_sub_active ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-400 hover:text-white hover:bg-white/5' ?>">
                                <?= $sub['label'] ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php
            } else {
                $is_active = (strpos($current_uri, $item['path']) !== false);
                $full_path = $base_url . $item['path'];
                ?>
                <a href="<?= $full_path ?>"
                    class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 <?= $is_active ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'hover:bg-white/5 hover:text-white' ?>">
                    <svg class="mr-3 h-5 w-5 <?= $is_active ? 'text-white' : 'text-slate-400 group-hover:text-white' ?>"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <?= $item['icon'] ?>
                    </svg>
                    <?= $item['label'] ?>
                </a>
                    <?php
            }
        endforeach;
        ?>
    </nav>

    <!-- Footer Credit -->
    <div class="p-6 mt-auto border-t border-white/5">
        <div class="px-4 py-3 bg-white/5 rounded-xl">
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1 leading-none">System Version
            </p>
            <p class="text-xs text-slate-300 font-medium leading-none">v1.2.4-stable</p>
        </div>
    </div>
</aside>