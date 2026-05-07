<header class="glass-header h-20 flex items-center sticky top-0 z-20 px-8" x-data="{ showLogoutModal: false }">
    <div class="max-w-7xl mx-auto w-full flex items-center justify-between">
        <div class="flex items-center gap-4">
            <!-- Mobile Toggle -->
            <button @click.stop="isSidebarOpen = true" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-xl transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7"/></svg>
            </button>
            <h2 class="text-xl font-bold text-slate-800 hidden sm:block">Staff Portal</h2>
            <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-black rounded-full uppercase tracking-wider">Inventory Access</span>
        </div>
        
        <div class="flex items-center gap-6">
            <?php 
                $notificationModel = new \App\Models\Notification();
                $unreadCount = $notificationModel->getUnreadCount($_SESSION['user_id']);
            ?>
            <a href="<?= $base_url ?>/staff/notifications" class="relative group p-2.5 bg-slate-50 border border-slate-100 rounded-2xl text-slate-400 hover:text-amber-600 hover:bg-amber-50 hover:border-amber-100 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <?php if ($unreadCount > 0): ?>
                    <span class="absolute top-0 right-0 -mr-1 -mt-1 w-5 h-5 bg-rose-600 text-white text-[10px] font-black rounded-full flex items-center justify-center border-2 border-white shadow-sm animate-pulse">
                        <?= $unreadCount > 9 ? '9+' : $unreadCount ?>
                    </span>
                <?php endif; ?>
            </a>

            <a href="<?= $base_url ?>/staff/profile" class="flex items-center gap-4 group hover:bg-slate-50/80 p-1.5 pr-4 rounded-2xl transition-all">
                <div class="hidden md:flex flex-col items-end">
                    <span class="text-sm font-bold text-slate-800 group-hover:text-amber-600 transition-colors"><?= $_SESSION['name'] ?? 'Staff Member' ?></span>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mt-1"><?= strtoupper($_SESSION['role'] ?? 'Department Personnel') ?></span>
                </div>
                <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-amber-500 to-orange-500 flex items-center justify-center text-white font-black shadow-lg shadow-amber-100 group-hover:scale-110 transition-transform overflow-hidden">
                    <?php if (isset($_SESSION['profile_image']) && !empty($_SESSION['profile_image'])): ?>
                        <img src="<?= $base_url ?>/uploads/profiles/<?= $_SESSION['profile_image'] ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <?= strtoupper(substr($_SESSION['name'] ?? 'S', 0, 1)) ?>
                    <?php endif; ?>
                </div>
            </a>
            <div class="h-6 w-px bg-slate-200 mx-1"></div>
            <button @click="showLogoutModal = true" class="flex items-center gap-2 text-slate-500 hover:text-red-600 transition-colors font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="hidden sm:inline">Logout</span>
            </button>
        </div>
    </div>

    <!-- LOGOUT CONFIRMATION MODAL (Archive Modal Style) -->
    <template x-teleport="body">
        <div x-show="showLogoutModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md"
            style="display: none;">

            <div @click.away="showLogoutModal = false"
                class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl relative overflow-hidden p-8 text-center">

                <div
                    class="w-20 h-20 bg-rose-50 text-rose-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-inner">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>

                <h3 class="text-2xl font-black text-slate-900 mb-2 italic">Confirm Logout?</h3>
                <p class="text-sm font-medium text-slate-500 mb-8 leading-relaxed px-2">Are you sure you want to logout? You will need to login again to access your account.</p>

                <div class="space-y-3">
                    <a href="<?= $base_url ?>/logout"
                        class="block w-full py-4 bg-rose-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-rose-700 transition-all shadow-lg shadow-rose-200 text-center">
                        Yes, Logout
                    </a>
                    <button @click="showLogoutModal = false"
                        class="w-full py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition-all">
                        No, Stay Logged In
                    </button>
                </div>
            </div>
        </div>
    </template>
</header>





