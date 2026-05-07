<?php $title = 'Maintenance Queue' ?>

<div class="space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Maintenance Queue</h1>
            <p class="text-sm text-slate-500">Active repair tickets for laboratory equipment.</p>
        </div>
        <div class="flex gap-2">
            <span class="px-4 py-2 bg-rose-50 text-rose-700 text-xs font-bold rounded-xl border border-rose-100 italic">
                Awaiting Repair: <?= count($reports) ?>
            </span>
        </div>
    </div>

    <!-- Maintenance Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if (empty($reports)): ?>
            <div class="col-span-full bg-white rounded-[2.5rem] border border-slate-100 p-20 text-center shadow-sm">
                <div
                    class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-100 text-emerald-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-slate-900 font-bold mb-1">Queue is Empty</h3>
                <p class="text-slate-400 text-sm">All laboratory systems are functioning at 100% capacity.</p>
            </div>
        <?php else: ?>
            <?php foreach ($reports as $report):
                $statusConfig = [
                    'Pending' => [
                        'iconBg' => 'background-color:#fff1f2;',
                        'iconColor' => 'color:#e11d48;',
                        'badgeBg' => 'background-color:#f43f5e; box-shadow:0 4px 6px -1px rgb(225 29 72 / 0.3);',
                        'sectionBg' => 'background-color:rgba(255,241,242,0.5); border-color:rgba(254,205,211,0.5);',
                        'labelColor' => 'color:#e11d48;',
                        'label' => 'Awaiting Technician',
                        'hoverShadow' => 'hover:shadow-rose-500/5',
                    ],
                    'Approved' => [
                        'iconBg' => 'background-color:#ecfdf5;',
                        'iconColor' => 'color:#059669;',
                        'badgeBg' => 'background-color:#10b981; box-shadow:0 4px 6px -1px rgb(5 150 105 / 0.3);',
                        'sectionBg' => 'background-color:rgba(236,253,245,0.5); border-color:rgba(167,243,208,0.5);',
                        'labelColor' => 'color:#059669;',
                        'label' => 'Approved - Waiting Repair',
                        'hoverShadow' => 'hover:shadow-emerald-500/5',
                    ],
                    'Under Repair' => [
                        'iconBg' => 'background-color:#fffbeb;',
                        'iconColor' => 'color:#d97706;',
                        'badgeBg' => 'background-color:#f59e0b; box-shadow:0 4px 6px -1px rgb(217 119 6 / 0.3);',
                        'sectionBg' => 'background-color:rgba(255,251,235,0.5); border-color:rgba(253,230,138,0.5);',
                        'labelColor' => 'color:#d97706;',
                        'label' => 'Under Repair',
                        'hoverShadow' => 'hover:shadow-amber-500/5',
                    ],
                    'Fixed' => [
                        'iconBg' => 'background-color:#ecfdf5;',
                        'iconColor' => 'color:#059669;',
                        'badgeBg' => 'background-color:#10b981; box-shadow:0 4px 6px -1px rgb(5 150 105 / 0.3);',
                        'sectionBg' => 'background-color:rgba(236,253,245,0.5); border-color:rgba(167,243,208,0.5);',
                        'labelColor' => 'color:#059669;',
                        'label' => 'Fixed',
                        'hoverShadow' => 'hover:shadow-emerald-500/5',
                    ],
                ];
                $conf = $statusConfig[$report['status']] ?? $statusConfig['Pending'];
                ?>
                <div
                    class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8 flex flex-col <?= $conf['hoverShadow'] ?> hover:shadow-xl transition-all group overflow-hidden relative">

                    <!-- Status Badge -->
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center transition-transform group-hover:rotate-12"
                            style="<?= $conf['iconBg'] ?> <?= $conf['iconColor'] ?>">
                            <?php if ($report['status'] == 'Pending'): ?>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            <?php else: ?>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            <?php endif; ?>
                        </div>
                        <span class="px-3 py-1 text-white text-[10px] font-black uppercase rounded-lg shadow-lg"
                            style="<?= $conf['badgeBg'] ?>">
                            <?= $conf['label'] ?>
                        </span>
                    </div>

                    <!-- Asset Info -->
                    <div class="mb-6">
                        <h3 class="text-lg font-black text-slate-800 leading-tight mb-1">
                            <?= $report['asset_name'] ?>
                        </h3>
                        <p class="text-xs font-mono font-bold text-slate-400">
                            <?= $report['asset_tag'] ?>
                        </p>
                    </div>

                    <!-- Issue Description -->
                    <div class="rounded-2xl p-5 mb-8 border flex-1" style="<?= $conf['sectionBg'] ?>">
                        <div class="flex items-center gap-2 mb-2">
                            <p class="text-[10px] font-black uppercase tracking-widest" style="<?= $conf['labelColor'] ?>">
                                Reported Issue</p>
                        </div>
                        <div class="flex items-center gap-2 mb-2">
                            <p class="text-sm font-bold text-slate-700">
                                <?= $report['title'] ?>
                            </p>
                            <?php if ($report['is_duplicate']): ?>
                                <?php if ($report['duplicate_type'] === 'duplicate'): ?>
                                    <span class="px-2 py-0.5 bg-rose-100 text-rose-600 text-[9px] font-black uppercase rounded-md border border-rose-200 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 bg-rose-600 rounded-full"></span>
                                        Duplicate
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 py-0.5 bg-amber-100 text-amber-600 text-[9px] font-black uppercase rounded-md border border-amber-200 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 bg-amber-600 rounded-full"></span>
                                        Potential
                                    </span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <p class="text-[11px] text-slate-500 italic leading-relaxed">"
                            <?= $report['description'] ?>"
                        </p>
                    </div>

                    <!-- Timing & Action -->
                    <div class="flex items-center justify-between pt-6 border-t border-slate-50 gap-4">
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none">Reported</p>
                            <p class="text-[11px] font-bold text-slate-600 mt-1">
                                <?= date('M jS, h:i A', strtotime($report['reported_at'])) ?>
                            </p>
                        </div>

                        <?php if ($report['status'] == 'Under Repair'): ?>
                            <form action="<?= $base_url ?>/staff/report/fix/<?= $report['id'] ?>" method="POST" class="flex-1">
                                <button type="submit"
                                    class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-[11px] font-black uppercase tracking-widest transition-all shadow-lg shadow-emerald-200 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Mark Fixed
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>