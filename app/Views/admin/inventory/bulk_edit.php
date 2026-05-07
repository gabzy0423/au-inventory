<?php $title = 'Bulk Asset Update' ?>

<div class="max-w-5xl mx-auto">
    <!-- Top Bar with Breadcrumbs & Actions -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                <a href="<?= $base_url ?>/admin/inventory" class="hover:text-indigo-600 transition-colors">Inventory</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-300">Bulk Update</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic">Batch Process</h1>
            <p class="text-slate-500 font-medium mt-1">Applying global changes to <?= count($assets) ?> selected assets.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="<?= $base_url ?>/admin/inventory" 
               class="bg-white border-2 border-slate-100 text-slate-600 hover:bg-slate-50 hover:border-slate-200 px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Cancel Process
            </a>
        </div>
    </div>

    <form action="<?= $base_url ?>/admin/inventory/bulk-update" method="POST">
        <!-- Pass IDs -->
        <?php foreach ($assets as $asset): ?>
            <input type="hidden" name="ids[]" value="<?= $asset['id'] ?>">
        <?php endforeach; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Update Form -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-8 md:p-10 rounded-[3rem] shadow-sm border border-slate-100 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50/30 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-700"></div>
                    
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500 mb-8 flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-indigo-500 rounded-full"></span>
                        Batch Configuration
                    </h3>

                    <div class="space-y-8">
                        <!-- Status Selection -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Global Status</label>
                            <select name="status" class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all appearance-none cursor-pointer">
                                <option value="">Keep Original Status</option>
                                <option value="Available">Available</option>
                                <option value="In Use">In Use</option>
                                <option value="Damaged">Damaged</option>
                                <option value="Under Repair">Under Repair</option>
                            </select>
                        </div>

                        <!-- Location Selection -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Global Location</label>
                            <select name="location" class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all appearance-none cursor-pointer">
                                <option value="">Keep Original Location</option>
                                <option>Storage</option>
                                <?php foreach ($rooms as $room): ?>
                                    <option><?= htmlspecialchars($room['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="p-6 bg-amber-50/50 border border-amber-100 rounded-2xl">
                            <div class="flex gap-3">
                                <svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <div>
                                    <p class="text-[10px] font-bold text-amber-600 uppercase tracking-widest mb-1 leading-none">Process Logic</p>
                                    <p class="text-[11px] text-amber-700 font-medium leading-relaxed">Setting status to 'Available' will automatically relocate items to Storage. Moving items to a lab will set status to 'In Use' unless marked as Damaged.</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-700 shadow-2xl shadow-indigo-600/30 transition-all active:scale-95 flex items-center justify-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Execute Batch Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Target Assets List -->
            <div class="space-y-8">
                <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-slate-100">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500 mb-8 flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-indigo-500 rounded-full"></span>
                        Target Assets
                    </h3>

                    <div class="space-y-3 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                        <?php foreach ($assets as $asset): ?>
                            <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl flex items-center gap-4 group hover:bg-white hover:border-indigo-100 transition-all">
                                <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-bold text-slate-700 text-xs truncate italic"><?= htmlspecialchars($asset['name']) ?></p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5"><?= htmlspecialchars($asset['tag']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="bg-indigo-600 p-8 rounded-[3rem] shadow-2xl shadow-indigo-600/20 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2 opacity-80">Batch Summary</h4>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-black italic"><?= count($assets) ?></span>
                        <span class="text-xs font-bold uppercase tracking-widest opacity-80">Total Nodes</span>
                    </div>
                    <p class="mt-4 text-[11px] font-medium leading-relaxed opacity-70">You are about to modify multiple inventory records. This action will be logged for administrative auditing.</p>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #cbd5e1;
}
</style>
