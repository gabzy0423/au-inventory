<?php $title = 'Update Category' ?>

<style>
    /* Local override for light theme consistency */
    body { background-color: #f8fafc !important; color: #1e293b; }
    main { background-color: #f8fafc !important; }
</style>

<div class="max-w-5xl mx-auto" x-data="{
    editData: <?= htmlspecialchars(json_encode($category), ENT_QUOTES, 'UTF-8') ?>
}">
    <!-- Top Bar with Breadcrumbs & Back -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                <a href="<?= $base_url ?>/admin/categories" class="hover:text-indigo-600 transition-colors">Categories</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-slate-300">Update Existing</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic">Update Category</h1>
            <p class="text-slate-500 font-medium mt-1">Modify the classification parameters for "<?= htmlspecialchars($category['name']) ?>".</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="<?= $base_url ?>/admin/categories"
                class="bg-white border-2 border-slate-100 text-slate-600 hover:bg-slate-50 hover:border-slate-200 px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Cancel
            </a>
            <button form="editForm" type="submit"
                class="bg-amber-600 text-white hover:bg-amber-700 px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-xl shadow-amber-600/20 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
                Save Changes
            </button>
        </div>
    </div>

    <!-- Form Content -->
    <form id="editForm" action="<?= $base_url ?>/admin/categories/update/<?= $category['id'] ?>" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Primary Info (2/3) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Category Identity Section -->
            <div class="bg-white p-8 md:p-10 rounded-[3rem] shadow-sm border border-slate-100 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50/50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-700"></div>
                
                <div class="flex items-center gap-3 mb-8 relative z-10">
                    <span class="w-8 h-[2px] bg-amber-600 rounded-full"></span>
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-amber-600">Category Identity</h3>
                </div>

                <div class="space-y-4 relative z-10">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">
                        Classification Name <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" x-model="editData.name" required
                        placeholder="e.g. Computing devices, Lab equipment"
                        class="w-full px-8 py-6 bg-slate-50/50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-600 focus:bg-white outline-none font-bold text-slate-700 transition-all placeholder-slate-300 text-lg">
                </div>
            </div>

            <!-- Impact Analysis Note -->
            <div class="p-6 bg-amber-50/30 border-2 border-amber-100/50 rounded-2xl flex items-start gap-4">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-amber-600 shadow-sm flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-amber-700 uppercase tracking-widest mb-1">Impact Analysis</p>
                    <p class="text-[11px] text-amber-600/80 leading-relaxed font-medium">
                        Changing the name or color will take effect immediately across all associated assets and reports. Ensure consistency with organizational standards.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Column: Visual Theme (1/3) -->
        <div class="space-y-8">
            <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-8 relative z-10">
                    <span class="w-8 h-[2px] bg-amber-600 rounded-full"></span>
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-amber-600">Visual Theme</h3>
                </div>

                <div class="space-y-8">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1 text-center block">Identity Color</p>

                    <div class="grid grid-cols-2 gap-4">
                        <?php
                        $colors = [
                            'indigo' => ['label' => 'Indigo', 'hex' => 'bg-indigo-500'],
                            'blue'   => ['label' => 'Blue', 'hex' => 'bg-blue-500'],
                            'emerald'=> ['label' => 'Emerald', 'hex' => 'bg-emerald-500'],
                            'amber'  => ['label' => 'Amber', 'hex' => 'bg-amber-500'],
                            'rose'   => ['label' => 'Rose', 'hex' => 'bg-rose-500'],
                            'slate'  => ['label' => 'Slate', 'hex' => 'bg-slate-500'],
                        ];
                        foreach ($colors as $val => $info):
                        ?>
                        <label class="cursor-pointer group flex flex-col items-center gap-3">
                            <input type="radio" name="color" value="<?= $val ?>" class="hidden peer" x-model="editData.color">
                            <div class="w-full h-16 rounded-2xl <?= $info['hex'] ?> border-4 border-white shadow-lg peer-checked:ring-4 peer-checked:ring-<?= $val ?>-500/30 peer-checked:scale-105 transition-all flex items-center justify-center group-hover:scale-105 active:scale-95">
                                <svg class="w-6 h-6 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest group-hover:text-slate-700 transition-colors">
                                <?= $val ?>
                            </span>
                        </label>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-8 p-4 bg-amber-50/30 border border-amber-100 rounded-2xl">
                        <p class="text-[9px] font-bold text-amber-600 uppercase tracking-tight text-center leading-relaxed">
                            The selected color will be used for markers and highlighting in the dashboard.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

