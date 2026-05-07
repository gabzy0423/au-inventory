<div class="space-y-8" x-data="{ 
    selectedReports: [],
    showMergeModal: false,
    primaryReportId: null,
    
    toggleSelection(id) {
        if (this.selectedReports.includes(id)) {
            this.selectedReports = this.selectedReports.filter(i => i !== id);
        } else {
            this.selectedReports.push(id);
        }
    },
    
    openMerge() {
        if (this.selectedReports.length < 2) return;
        this.primaryReportId = this.selectedReports[0];
        this.showMergeModal = true;
    }
}">
    <!-- Header Area -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight italic">Maintenance Queue</h1>
            <p class="text-slate-500 mt-1 text-sm sm:text-base">Manage and track organizational asset health and repair cycles.</p>
        </div>
        <div class="flex flex-col xs:flex-row gap-3">
            <button x-show="selectedReports.length >= 2" @click="openMerge()"
                class="flex items-center justify-center px-6 py-3 bg-indigo-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-200 active:scale-95">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
                Merge (<span x-text="selectedReports.length"></span>)
            </button>
            <button
                class="flex items-center justify-center px-6 py-3 bg-white border border-slate-200 rounded-2xl text-slate-600 font-bold hover:bg-slate-50 transition-all shadow-sm active:scale-95 text-[10px] uppercase tracking-widest">
                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export
            </button>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <div
            class="bg-white p-6 sm:p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center gap-5 group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div
                class="w-12 h-12 sm:w-14 sm:h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 shadow-inner group-hover:rotate-6 transition-transform">
                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Awaiting Approval</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-900 italic leading-none">
                    <?= count(array_filter($reports, fn($r) => $r['status'] == 'Pending')) ?></p>
            </div>
        </div>
        <div
            class="bg-white p-6 sm:p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center gap-5 group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div
                class="w-12 h-12 sm:w-14 sm:h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 shadow-inner group-hover:rotate-6 transition-transform">
                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Active Repairs</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-900 italic leading-none">
                    <?= count(array_filter($reports, fn($r) => $r['status'] == 'Under Repair')) ?></p>
            </div>
        </div>
        <div
            class="bg-white p-6 sm:p-8 rounded-[2.5rem] sm:rounded-[3rem] shadow-sm border border-slate-100 flex items-center gap-5 group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div
                class="w-12 h-12 sm:w-14 sm:h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 shadow-inner group-hover:rotate-6 transition-transform">
                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Waitlisted Nodes</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-900 italic leading-none">
                    <?= count(array_filter($reports, fn($r) => $r['status'] == 'Approved')) ?></p>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden min-h-[400px]">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="w-12 px-8 py-5 border-b border-slate-100"></th>
                        <th
                            class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            Asset Identity</th>
                        <th
                            class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            Reported By</th>
                        <th
                            class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            Incident Detail</th>
                        <th
                            class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">
                            Status</th>
                        <th
                            class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if (empty($reports)): ?>
                        <tr>
                            <td colspan="6" class="px-8 py-32 text-center text-slate-400">No active maintenance tickets
                                detected in the queue.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($reports as $report): ?>
                            <?php if ($report['status'] === 'Merged')
                                continue; ?>
                            <tr class="hover:bg-slate-50/50 transition-colors group"
                                :class="selectedReports.includes(<?= $report['id'] ?>) ? 'bg-indigo-50/30' : ''">
                                <td class="px-8 py-6">
                                    <input type="checkbox" @change="toggleSelection(<?= $report['id'] ?>)"
                                        :checked="selectedReports.includes(<?= $report['id'] ?>)"
                                        class="w-5 h-5 rounded-lg border-2 border-slate-200 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer">
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <p class="font-black text-slate-800 text-base leading-tight">
                                            <?= $report['asset_name'] ?></p>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-0.5">
                                            <?= $report['asset_tag'] ?></p>
                                    </div>

                                </td>
                                <td class="px-8 py-6 italic text-xs text-slate-600">
                                    <?= htmlspecialchars($report['reported_by_name'] ?? 'System') ?></td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col max-w-xs">
                                        <div class="flex items-center gap-2">
                                            <p class="text-sm font-black text-slate-700 leading-tight"><?= $report['title'] ?>
                                            </p>
                                            <?php if ($report['is_duplicate']): ?>
                                                <?php if ($report['duplicate_type'] === 'duplicate'): ?>
                                                    <span
                                                        class="px-2 py-0.5 bg-rose-100 text-rose-600 text-[8px] font-black uppercase rounded-md border border-rose-200">Duplicate</span>
                                                <?php else: ?>
                                                    <span
                                                        class="px-2 py-0.5 bg-amber-100 text-amber-600 text-[8px] font-black uppercase rounded-md border border-amber-200">Potential</span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                        <p class="text-[11px] text-slate-400 font-medium italic mt-1 line-clamp-1">
                                            <?= $report['description'] ?></p>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <?php
                                    $currentStatus = trim($report['status']);
                                    $statusStyles = [
                                        'Pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'Approved' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                        'Under Repair' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'Fixed' => 'bg-emerald-500 text-white border-emerald-500 shadow-emerald-500/20',
                                        'Resolved' => 'bg-slate-900 text-white border-slate-900 shadow-slate-900/20',
                                    ];

                                    // Try to find matching style regardless of case
                                    $style = 'bg-slate-50 text-slate-400 border-slate-100';
                                    foreach ($statusStyles as $key => $s) {
                                        if (strcasecmp($key, $currentStatus) === 0) {
                                            $style = $s;
                                            break;
                                        }
                                    }
                                    ?>
                                    <span
                                        class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-[0.1em] border shadow-sm <?= $style ?>">
                                        <?= htmlspecialchars($currentStatus) ?>
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <?php if (strcasecmp($currentStatus, 'Pending') === 0): ?>
                                            <form action="<?= $base_url ?>/admin/report/approve/<?= $report['id'] ?>" method="POST">
                                                <button type="submit"
                                                    class="flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-[10px] font-black uppercase tracking-widest transition-all shadow-sm active:scale-95">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                            d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Approve
                                                </button>
                                            </form>
                                        <?php elseif (strcasecmp($currentStatus, 'Approved') === 0): ?>
                                            <form action="<?= $base_url ?>/admin/report/start/<?= $report['id'] ?>" method="POST">
                                                <button type="submit"
                                                    class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-[10px] font-black uppercase tracking-widest transition-all shadow-sm active:scale-95">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Repair
                                                </button>
                                            </form>
                                        <?php elseif (strcasecmp($currentStatus, 'Under Repair') === 0): ?>
                                            <div
                                                class="flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-600 rounded-lg text-[10px] font-black uppercase tracking-widest border border-amber-100 italic">
                                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                                On-going
                                            </div>

                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Merge Modal -->
    <div x-show="showMergeModal"
        class="fixed inset-0 z-[300] flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

        <div class="bg-white w-full max-w-2xl rounded-[3rem] shadow-2xl overflow-hidden border border-slate-200">
            <form action="<?= $base_url ?>/admin/report/merge" method="POST">
                <div class="p-10">
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight italic mb-4">Merge Maintenance Logs
                    </h2>
                    <p class="text-slate-500 font-medium mb-8">Select the primary report that will maintain the active
                        status. Others will be linked as duplicates.</p>

                    <div class="space-y-3 mb-10 max-h-60 overflow-y-auto pr-2">
                        <template x-for="id in selectedReports" :key="id">
                            <label
                                class="flex items-center gap-4 p-5 bg-slate-50 rounded-2xl border-2 cursor-pointer transition-all"
                                :class="primaryReportId == id ? 'border-indigo-600 bg-indigo-50' : 'border-slate-100 hover:border-indigo-200'">
                                <input type="radio" name="primary_report_id" :value="id" x-model="primaryReportId"
                                    class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-slate-300">
                                <span class="font-black text-slate-800 italic" x-text="'Report #' + id"></span>
                                <input type="hidden" name="report_ids[]" :value="id">
                            </label>
                        </template>
                    </div>

                    <div class="flex gap-4">
                        <button type="button" @click="showMergeModal = false"
                            class="flex-1 py-4 bg-white border-2 border-slate-100 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-50 transition-all">Cancel</button>
                        <button type="submit"
                            class="flex-1 py-4 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-200">Confirm
                            Merge</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>