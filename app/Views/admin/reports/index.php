<?php $title = 'System Reports' ?>

<div class="space-y-8" x-data="{ 
    searchQuery: '', 
    currentPage: 1, 
    itemsPerPage: 8,
    allReports: <?= htmlspecialchars(json_encode($reports), ENT_QUOTES, 'UTF-8') ?>,
    baseUrl: '<?= $base_url ?>',

    filterStatus: 'All Status',

    get filteredReports() {
        return this.allReports.filter(r => {
            const matchesSearch = !this.searchQuery || 
                r.asset_name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                r.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                r.asset_tag.toLowerCase().includes(this.searchQuery.toLowerCase());
            
            const matchesStatus = this.filterStatus === 'All Status' || r.status === this.filterStatus;

            return matchesSearch && matchesStatus;
        });
    },

    get totalPages() {
        return Math.ceil(this.filteredReports.length / this.itemsPerPage) || 1;
    },

    get paginatedReports() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const end = start + this.itemsPerPage;
        return this.filteredReports.slice(start, end);
    }
} " x-init="
    $watch('searchQuery', () => currentPage = 1);
    $watch('filterStatus', () => currentPage = 1);
">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight italic">Incident Log</h1>
            <p class="text-slate-500 mt-1">Audit trail for all equipment damages and repair completions.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?= $base_url ?>/admin/reports/vault" 
               class="flex items-center gap-2 px-6 py-3 bg-white border-2 border-slate-100 text-slate-600 hover:bg-slate-50 rounded-2xl font-bold text-xs uppercase tracking-widest transition-all shadow-sm active:scale-95">
                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Report Vault
            </a>
            <a href="<?= $base_url ?>/admin/reports/resolved" 
               class="flex items-center gap-2 px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl font-bold text-xs uppercase tracking-widest transition-all shadow-lg shadow-emerald-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Resolved History
            </a>
        </div>
    </div>

    <!-- Search/Filter Bar -->
    <div
        class="bg-white p-4 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col md:flex-row gap-4 items-center mb-8">
        <div class="relative flex-1 w-full">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" x-model="searchQuery" placeholder="Search by asset name, tag, or incident title..."
                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-bold text-slate-700">
        </div>
        <div class="w-full md:w-auto">
            <select x-model="filterStatus"
                class="bg-slate-50 border border-slate-200 text-slate-700 py-3 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 w-full md:w-48 transition-all cursor-pointer font-bold text-xs uppercase tracking-widest">
                <option>All Status</option>
                <option value="Resolved">Resolved</option>
                <option value="Fixed">Fixed</option>
                <option value="Under Repair">Under Repair</option>
                <option value="Approved">Approved</option>
                <option value="Pending">Pending</option>
            </select>
        </div>
    </div>

    <!-- Reports Table Card -->
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden min-h-[400px] flex flex-col">
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Asset
                            Target</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Reported By</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Incident
                            Detail</th>
                        <th
                            class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest min-w-[120px]">
                            Status</th>
                        <th
                            class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                            Time of Report</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <template x-if="paginatedReports.length === 0">
                        <tr>
                            <td colspan="6" class="px-8 py-32 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-200">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-bold text-slate-400 italic">No active reports matched your filter.</p>
                                </div>
                            </td>
                        </tr>
                    </template>

                    <template x-for="report in paginatedReports" :key="report.id">
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-black text-slate-800 text-base group-hover:text-indigo-600 transition-colors"
                                            x-text="report.asset_name"></span>
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1"
                                            x-text="report.asset_tag"></span>
                                    </div>

                            </td>
                            <td class="px-6 py-6">
                                <!-- Reported By (Default) -->
                                <template x-if="report.status !== 'Fixed' && report.status !== 'Resolved'">
                                    <div class="flex items-center gap-3">
                                        <template x-if="report.reported_by_image">
                                            <img :src="baseUrl + '/uploads/profiles/' + report.reported_by_image" 
                                                 class="w-8 h-8 rounded-full object-cover border-2 border-white shadow-sm"
                                                 alt="Reporter">
                                        </template>
                                        <template x-if="!report.reported_by_image">
                                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-[10px] font-bold border-2 border-white shadow-sm">
                                                <span x-text="report.reported_by_name ? report.reported_by_name.charAt(0) : '?'"></span>
                                            </div>
                                        </template>
                                        <div class="flex flex-col">
                                            <span class="text-[8px] font-black uppercase tracking-tighter text-indigo-400">Reported By</span>
                                            <span class="font-bold text-slate-700 text-xs" x-text="report.reported_by_name || 'System'"></span>
                                        </div>
                                    </div>
                                </template>

                                <!-- Fixed By (If Operational) -->
                                <template x-if="report.status === 'Fixed' || report.status === 'Resolved'">
                                    <div class="flex items-center gap-3">
                                        <template x-if="report.fixed_by_image">
                                            <img :src="baseUrl + '/uploads/profiles/' + report.fixed_by_image" 
                                                 class="w-8 h-8 rounded-full object-cover border-2 border-white shadow-sm"
                                                 alt="Fixer">
                                        </template>
                                        <template x-if="!report.fixed_by_image">
                                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-[10px] font-bold border-2 border-white shadow-sm">
                                                <span x-text="report.fixed_by_name ? report.fixed_by_name.charAt(0) : '?'"></span>
                                            </div>
                                        </template>
                                        <div class="flex flex-col">
                                            <span class="text-[8px] font-black uppercase tracking-tighter text-emerald-500">Fixed By</span>
                                            <span class="font-bold text-slate-700 text-xs" x-text="report.fixed_by_name || 'System Auto'"></span>
                                        </div>
                                    </div>
                                </template>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <a :href="baseUrl + '/admin/reports/show/' + report.id" class="font-bold text-slate-700 hover:text-indigo-600 transition-colors" x-text="report.title"></a>
                                        <template x-if="report.is_duplicate == 1">
                                            <span>
                                                <template x-if="report.duplicate_type === 'duplicate'">
                                                    <span class="px-2 py-0.5 bg-rose-100 text-rose-600 text-[8px] font-black uppercase rounded-md border border-rose-200">Duplicate</span>
                                                </template>
                                                <template x-if="report.duplicate_type === 'potential'">
                                                    <span class="px-2 py-0.5 bg-amber-100 text-amber-600 text-[8px] font-black uppercase rounded-md border border-amber-200">Potential</span>
                                                </template>
                                            </span>
                                        </template>
                                    </div>
                                    <span class="text-xs text-slate-400 italic truncate max-w-xs block"
                                        x-text="report.description"></span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex items-center">
                                    <span
                                        class="px-3 py-1.5 text-[10px] font-black rounded-xl uppercase tracking-[0.1em] border shadow-sm whitespace-nowrap"
                                        :style="{
                'Resolved':  'background-color:#0f172a; color:#ffffff; border-color:#0f172a;',
                'Fixed':     'background-color:#10b981; color:#ffffff; border-color:#10b981; box-shadow:0 4px 6px -1px rgb(16 185 129 / 0.2);',
                'Under Repair': 'background-color:#fff7ed; color:#f97316; border-color:#fed7aa;',
                'Approved':  'background-color:#eef2ff; color:#4f46e5; border-color:#c7d2fe;',
                'Pending':   'background-color:#fffbeb; color:#d97706; border-color:#fde68a;',
            }[report.status] ?? 'background-color:#f8fafc; color:#64748b; border-color:#e2e8f0;'">
                                        <span x-text="{
                'Resolved':  'Resolved',
                'Fixed':     'Fixed',
                'Under Repair': 'Under Repair',
                'Approved':  'Approved',
                'Pending':   'Pending',
            }[report.status] ?? report.status"></span>
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="font-mono text-xs font-bold text-slate-400"
                                    x-text="new Date(report.reported_at).toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' })"></span>
                            </td>


                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Pagination Controls -->
        <template x-if="totalPages > 1">
            <div class="p-8 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400"
                    x-text="`Node Page ${currentPage} of ${totalPages}`"></span>
                <div class="flex gap-3">
                    <button @click="if(currentPage > 1) currentPage--" :disabled="currentPage === 1"
                        class="px-5 py-2.5 bg-white border border-slate-200 text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm hover:bg-slate-900 hover:text-white disabled:opacity-30 disabled:hover:bg-white disabled:hover:text-slate-900">
                        Previous
                    </button>
                    <button @click="if(currentPage < totalPages) currentPage++" :disabled="currentPage === totalPages"
                        class="px-5 py-2.5 bg-white border border-slate-200 text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm hover:bg-slate-900 hover:text-white disabled:opacity-30 disabled:hover:bg-white disabled:hover:text-slate-900">
                        Next
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>