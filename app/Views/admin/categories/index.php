<?php $title = 'Categories' ?>

<div class="space-y-8" x-data="{ 
    showArchiveConfirm: false,
    archiveTargetId: null,
}">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight italic">Asset Categories</h1>
            <p class="text-slate-500 mt-1">Organize your inventory with logical grouping and classification.</p>
        </div>
        <div class="flex items-center gap-3">
            <!-- Action Buttons Removed -->
        </div>
</div>

<!-- Category Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php foreach ($categories as $cat): 
            $color = $cat['color'] ?? 'indigo';
        ?>
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-start justify-between mb-6">
                <div class="p-4 bg-<?= $color ?>-50 text-<?= $color ?>-600 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div class="flex gap-1">
                    <a href="<?= $base_url ?>/admin/categories/edit/<?= $cat['id'] ?>" class="p-1.5 text-slate-300 hover:text-indigo-600 transition-colors" title="Edit Category">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </a>
                    <button @click="archiveTargetId = <?= $cat['id'] ?>; showArchiveConfirm = true" class="p-1.5 text-slate-300 hover:text-rose-600 transition-colors" title="Archive Category">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                    </button>
                </div>
            </div>
            
            <h3 class="text-xl font-bold text-slate-800 mb-1"><?= $cat['name'] ?></h3>
            <div class="flex items-center gap-2">
                <span class="text-2xl font-black text-slate-400/30 group-hover:text-<?= $color ?>-600/30 transition-colors"><?= $cat['item_count'] ?></span>
                <span class="text-sm font-medium text-slate-500 tracking-tight">items registered</span>
            </div>
            
            <div class="mt-6 pt-6 border-t border-slate-50">
                <a href="<?= $base_url ?>/admin/categories/show/<?= $cat['id'] ?>" class="text-sm font-bold text-<?= $color ?>-600 hover:opacity-80 transition-opacity inline-flex items-center gap-1.5">
                    Browse Category
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>



    <!-- ARCHIVE CONFIRMATION MODAL -->
    <template x-teleport="body">
        <div x-show="showArchiveConfirm" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            
            <div @click.away="showArchiveConfirm = false" 
                 class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl relative overflow-hidden p-8 text-center">
                
                <div class="w-20 h-20 bg-rose-50 text-rose-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-inner">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>

                <h3 class="text-2xl font-black text-slate-900 mb-2 italic">Archive Category?</h3>
                <p class="text-sm font-medium text-slate-500 mb-8 leading-relaxed">This category and all its items will be moved to the vault.</p>

                <div class="flex flex-col gap-3">
                    <form :action="'<?= $base_url ?>/admin/categories/archive/' + archiveTargetId" method="POST">
                        <button type="submit" class="w-full py-4 bg-rose-600 text-white rounded-2xl font-bold hover:bg-rose-700 shadow-xl shadow-rose-600/30 transition-all active:scale-95 duration-200">
                            Yes, Archive It
                        </button>
                    </form>
                    <button @click="showArchiveConfirm = false" class="w-full py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition-all">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
