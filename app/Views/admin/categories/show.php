<?php $title = $category['name'] . ' Assets' ?>

<div class="max-w-5xl mx-auto">
    <!-- Top Bar -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                <a href="<?= $base_url ?>/admin/categories" class="hover:text-indigo-600 transition-colors">Categories</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-300">Browse Classification</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic"><?= htmlspecialchars($category['name']) ?></h1>
            <p class="text-slate-500 font-medium mt-1">Reviewing <?= count($assets) ?> physical assets currently categorized under this classification.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="<?= $base_url ?>/admin/categories" 
               class="bg-white border-2 border-slate-100 text-slate-600 hover:bg-slate-50 hover:border-slate-200 px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Grid
            </a>
        </div>
    </div>

    <!-- Asset List -->
    <?php if (empty($assets)): ?>
        <div class="bg-white p-20 rounded-[3.5rem] border border-slate-100 shadow-sm text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200 mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
            </div>
            <h3 class="text-2xl font-black text-slate-300 italic">No assets found.</h3>
            <p class="text-slate-400 font-medium mt-2">There are currently no items registered in this category.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($assets as $asset): ?>
                <div class="p-6 bg-white border border-slate-100 rounded-[2.5rem] shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1.5 bg-slate-50 border border-slate-100 text-slate-400 rounded-xl" x-text="'<?= $asset['tag'] ?>'"></span>
                        <?php
                        $status_colors = [
                            'Available' => 'emerald',
                            'In Use' => 'blue',
                            'Damaged' => 'rose',
                            'Under Repair' => 'amber'
                        ];
                        $c = $status_colors[$asset['status']] ?? 'slate';
                        ?>
                        <span class="bg-<?= $c ?>-50 text-<?= $c ?>-600 text-[8px] font-black uppercase tracking-widest px-3 py-1 rounded-full"><?= $asset['status'] ?></span>
                    </div>
                    <h4 class="font-bold text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors text-lg italic"><?= htmlspecialchars($asset['name']) ?></h4>
                    <div class="flex items-center gap-2 text-slate-400 mb-6">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <span class="text-xs font-bold uppercase tracking-tight"><?= htmlspecialchars($asset['location']) ?></span>
                    </div>
                    
                    <a href="<?= $base_url ?>/admin/inventory/show/<?= $asset['id'] ?>" class="w-full py-3 bg-slate-50 group-hover:bg-indigo-600 group-hover:text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] flex items-center justify-center gap-2 transition-all">
                        View Asset Identity
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
