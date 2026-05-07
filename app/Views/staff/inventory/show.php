<?php $title = 'Asset Details' ?>

<div class="max-w-5xl mx-auto">
    <!-- Top Bar with Breadcrumbs & Actions -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                <a href="<?= $base_url ?>/staff/inventory" class="hover:text-amber-600 transition-colors">Catalog</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-slate-300">Specifications</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic"><?= htmlspecialchars($item['name']) ?>
            </h1>
            <p class="text-slate-500 font-medium mt-1">Detailed inventory analytics and health report for this asset
                node.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="<?= $base_url ?>/staff/inventory"
                class="bg-white border-2 border-slate-100 text-slate-600 hover:bg-slate-50 hover:border-slate-200 px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Catalog
            </a>
            <a href="<?= $base_url ?>/staff/report/create/<?= $item['id'] ?>"
                class="bg-rose-600 text-white hover:bg-rose-700 px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-xl shadow-rose-600/20 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Report Issue
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column: Primary Info -->
        <div class="lg:col-span-2 space-y-8">


            <!-- Asset Identity Section -->
            <div
                class="bg-white p-8 md:p-10 rounded-[3rem] shadow-sm border border-slate-100 relative overflow-hidden group">

                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-amber-50/30 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-700">
                </div>

                <h3
                    class="text-[10px] font-black uppercase tracking-[0.2em] text-amber-600 mb-8 flex items-center gap-3">
                    <span class="w-8 h-[2px] bg-amber-600 rounded-full"></span>
                    Asset Identity
                </h3>

                <div class="space-y-8">
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Display
                            Name</label>
                        <div
                            class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-black text-slate-800 italic text-xl">
                            <?= htmlspecialchars($item['name']) ?>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Asset Number</label>
                            <div
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700">
                                <?= htmlspecialchars($item['asset_number'] ?? 'N/A') ?>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Model /
                                Brand</label>
                            <div
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700">
                                <?= htmlspecialchars($item['model'] ?? 'Standard Issue') ?>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Serial
                                Number</label>
                            <div
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700">
                                <?= htmlspecialchars($item['serial_number'] ?? 'Not Recorded') ?>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Category</label>
                            <div
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700">
                                <?= htmlspecialchars($category_name ?? 'General') ?>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Location</label>
                            <div
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700">
                                <?= htmlspecialchars($item['location'] ?? 'N/A') ?>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Current Status</label>
                            <div
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700">
                                <?= htmlspecialchars($item['status'] ?? 'Available') ?>
                            </div>
                        </div>
                    </div>


                    <div class="space-y-3">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Description</label>
                        <div class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-medium text-slate-600 leading-relaxed">
                            <?= nl2br(htmlspecialchars($item['description'] ?? 'No description provided.')) ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Health History Section -->
            <div class="bg-white p-8 md:p-10 rounded-[3rem] shadow-sm border border-slate-100">
                <h3
                    class="text-[10px] font-black uppercase tracking-[0.2em] text-amber-600 mb-8 flex items-center gap-3">
                    <span class="w-8 h-[2px] bg-amber-600 rounded-full"></span>
                    Maintenance Alerts
                </h3>

                <div class="space-y-4">
                    <?php if (empty($reports)): ?>
                        <div
                            class="p-10 border-2 border-dashed border-slate-100 rounded-[2.5rem] flex flex-col items-center justify-center text-center">
                            <div
                                class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-sm font-bold text-slate-800">Operational Health: Optimal</p>
                            <p class="text-xs text-slate-400 mt-1 font-medium">No active maintenance reports found for this
                                node.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($reports as $report): ?>
                            <div
                                class="p-6 bg-slate-50 border-2 border-slate-100 rounded-3xl flex flex-col md:flex-row md:items-center justify-between gap-4 group hover:border-amber-200 transition-all">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-amber-600 shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800 italic">
                                            <?= htmlspecialchars($report['title']) ?></p>
                                        <p class="text-xs text-slate-500 font-medium line-clamp-1">
                                            <?= htmlspecialchars($report['description']) ?></p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">
                                            <?= date('M d, Y', strtotime($report['reported_at'])) ?></p>
                                    </div>
                                </div>
                                <?php
                                $rStyles = [
                                    'Pending' => 'bg-yellow-100 text-yellow-700',
                                    'Approved' => 'bg-indigo-100 text-indigo-700',
                                    'Under Repair' => 'bg-orange-500 text-white shadow-lg shadow-orange-500/20',
                                    'Fixed' => 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20',
                                    'Resolved' => 'bg-slate-900 text-white shadow-lg shadow-slate-900/20'
                                ];
                                $style = $rStyles[$report['status']] ?? 'bg-slate-100 text-slate-700';
                                ?>
                                <span
                                    class="px-4 py-1.5 <?= $style ?> text-[10px] font-black rounded-full uppercase tracking-widest self-start md:self-center">
                                    <?= $report['status'] ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Column: QR & Status -->
        <div class="space-y-8">
            <!-- History / Reports Log -->
            <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-slate-100 flex flex-col"
                 x-data="{
                    allLogs: <?= htmlspecialchars(json_encode($resolved_reports), ENT_QUOTES, 'UTF-8') ?>,
                    page: 1,
                    perPage: 3,
                    get totalPages() { return Math.ceil(this.allLogs.length / this.perPage) },
                    get pLogs() {
                        return this.allLogs.slice((this.page - 1) * this.perPage, this.page * this.perPage);
                    }
                 }">
                <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-amber-600 mb-8 flex items-center gap-3">
                    <span class="w-8 h-[2px] bg-amber-600 rounded-full"></span>
                    History / Reports Log
                </h3>

                <div class="space-y-4">
                    <template x-if="allLogs.length === 0">
                        <div class="p-8 border-2 border-dashed border-slate-100 rounded-[2.5rem] text-center">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">No resolved incidents recorded</p>
                        </div>
                    </template>
                    
                    <template x-for="log in pLogs" :key="log.id">
                        <div class="p-6 bg-slate-50 border-2 border-slate-100 rounded-3xl space-y-4">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 bg-white rounded-xl flex items-center justify-center text-emerald-500 shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-slate-800 italic" x-text="log.title"></p>
                                        <p class="text-[10px] text-slate-500 font-medium" x-text="log.description"></p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[8px] font-black uppercase rounded-full tracking-widest">Resolved</span>
                            </div>

                            <template x-if="log.resolution_details">
                                <div class="pl-11 border-l-2 border-emerald-100 py-1">
                                    <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest mb-1">Resolution Details</p>
                                    <p class="text-[11px] text-slate-600 leading-relaxed italic" x-text="log.resolution_details"></p>
                                </div>
                            </template>

                            <div class="flex items-center justify-between pt-2 border-t border-slate-200/50">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Resolved On</span>
                                    <span class="text-[10px] font-black text-slate-700 uppercase" x-text="log.resolved_at ? new Date(log.resolved_at).toLocaleDateString(undefined, {month:'short', day:'numeric', year:'numeric'}) : 'N/A'"></span>
                                </div>
                                <template x-if="log.reported_by_name">
                                    <div class="flex flex-col items-end gap-0.5">
                                        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Reported By</span>
                                        <span class="text-[10px] font-black text-slate-700 uppercase" x-text="log.reported_by_name"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Pagination Controls -->
                <template x-if="totalPages > 1">
                    <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-100">
                        <button @click="if(page > 1) page--" 
                                :disabled="page === 1"
                                :class="page === 1 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-slate-50'"
                                class="px-4 py-2 border-2 border-slate-100 rounded-xl text-[8px] font-black uppercase tracking-widest text-slate-400 transition-all flex items-center gap-2">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            Prev
                        </button>
                        <span class="text-[8px] font-black text-slate-300 uppercase tracking-widest" x-text="'Page ' + page + ' / ' + totalPages"></span>
                        <button @click="if(page < totalPages) page++" 
                                :disabled="page === totalPages"
                                :class="page === totalPages ? 'opacity-30 cursor-not-allowed' : 'hover:bg-slate-50'"
                                class="px-4 py-2 border-2 border-slate-100 rounded-xl text-[8px] font-black uppercase tracking-widest text-slate-400 transition-all flex items-center gap-2">
                            Next
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>

    </div>
</div>
</div>