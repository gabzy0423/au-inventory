<?php $title = 'Incident Report Details' ?>

<div class="max-w-4xl mx-auto space-y-8">
    <!-- Breadcrumbs -->
    <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
        <a href="<?= $base_url ?>/admin/reports" class="hover:text-indigo-600 transition-colors">Incident Log</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-300">Report #<?= $report['id'] ?></span>
    </div>

    <!-- Badge Header -->
    <?php if ($report['is_duplicate']): ?>
        <div class="flex items-center gap-3 p-4 rounded-3xl <?= $report['duplicate_type'] === 'duplicate' ? 'bg-rose-50 border border-rose-100 text-rose-600' : 'bg-amber-50 border border-amber-100 text-amber-600' ?>">
            <span class="w-3 h-3 rounded-full animate-pulse <?= $report['duplicate_type'] === 'duplicate' ? 'bg-rose-600' : 'bg-amber-600' ?>"></span>
            <span class="text-xs font-black uppercase tracking-widest">
                <?= $report['duplicate_type'] === 'duplicate' ? 'Duplicate Report' : 'Potential Duplicate' ?>
            </span>
            <?php if ($report['merged_into_id']): ?>
                <a href="<?= $base_url ?>/admin/reports/show/<?= $report['merged_into_id'] ?>" class="ml-auto text-[10px] font-bold underline decoration-2 underline-offset-4 hover:opacity-70 transition-all">
                    View Primary Report
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden p-10 md:p-12 relative group">
        <div class="absolute top-0 right-0 w-48 h-48 bg-slate-50 rounded-full -mr-24 -mt-24 pointer-events-none transition-transform group-hover:scale-110 duration-700"></div>
        
        <div class="relative z-10 space-y-10">
            <!-- Asset Section -->
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] border border-slate-100 flex items-center justify-center text-slate-300 shadow-inner overflow-hidden shrink-0">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight italic"><?= htmlspecialchars($asset['name']) ?></h1>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1"><?= $asset['tag'] ?></p>
                </div>
                <div class="ml-auto">
                     <span class="px-5 py-2 text-[10px] font-black uppercase rounded-2xl border shadow-sm"
                          style="<?= $report['status'] === 'Fixed' || $report['status'] === 'Resolved' ? 'background-color:#ecfdf5; color:#059669; border-color:#d1fae5;' : 'background-color:#fffbeb; color:#d97706; border-color:#fef3c7;' ?>">
                        <?= $report['status'] ?>
                    </span>
                </div>
            </div>

            <hr class="border-slate-50">

            <!-- Incident Content -->
            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Incident Summary</label>
                    <div class="text-xl font-black text-slate-800 italic"><?= htmlspecialchars($report['title']) ?></div>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Full Description</label>
                    <div class="bg-slate-50/50 border-2 border-slate-100 rounded-3xl p-8 text-slate-600 font-medium leading-relaxed italic">
                        <?= nl2br(htmlspecialchars($report['description'])) ?>
                    </div>
                </div>
            </div>

            <!-- Meta Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Reported By</p>
                        <p class="font-black text-slate-800 italic"><?= htmlspecialchars($reporter['name'] ?? 'System') ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center border border-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Date & Time</p>
                        <p class="font-black text-slate-800 italic"><?= date('F j, Y @ h:i A', strtotime($report['reported_at'])) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-center gap-4">
        <a href="<?= $base_url ?>/admin/reports" class="px-8 py-4 bg-white border-2 border-slate-100 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm">
            Close View
        </a>
        <a href="<?= $base_url ?>/admin/inventory/show/<?= $asset['id'] ?>" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-200">
            View Asset Node
        </a>
    </div>
</div>
