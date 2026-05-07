<?php $title = 'Reports Vault' ?>

<div class="space-y-8" x-data="{ 
    searchQuery: '', 
    startDate: '',
    endDate: '',
    currentPage: 1, 
    itemsPerPage: 8,
    allReports: <?= htmlspecialchars(json_encode($reports), ENT_QUOTES, 'UTF-8') ?>,
    baseUrl: '<?= $base_url ?>',

    get filteredReports() {
        return this.allReports.filter(r => {
            const matchesSearch = !this.searchQuery || 
                r.asset_name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                r.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                r.asset_tag.toLowerCase().includes(this.searchQuery.toLowerCase());
            
            const reportDate = new Date(r.reported_at).toISOString().split('T')[0];
            const matchesStart = !this.startDate || reportDate >= this.startDate;
            const matchesEnd = !this.endDate || reportDate <= this.endDate;

            return matchesSearch && matchesStart && matchesEnd;
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
$watch('startDate', () => currentPage = 1);
$watch('endDate', () => currentPage = 1);
">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a :href="baseUrl + '/admin/reports'"
                class="p-3 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-indigo-600 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight italic">Reports Vault</h1>
                <p class="text-slate-500 mt-1">Permanent archive for all fully resolved and closed incident reports.</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a :href="baseUrl + '/admin/report/export?start_date=' + startDate + '&end_date=' + endDate" 
               class="flex items-center gap-2 px-6 py-3 bg-white border-2 border-slate-100 text-slate-600 hover:bg-slate-50 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-sm active:scale-95">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Vault
            </a>
        </div>
    </div>

    <div class="bg-white p-4 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col md:flex-row gap-4 items-center mb-8">
        <div class="relative flex-1 w-full">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" x-model="searchQuery" placeholder="Search the vault by asset, tag, or incident..."
                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-bold text-slate-700">
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2">
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">From</span>
                <input type="date" x-model="startDate" 
                       class="bg-transparent border-none text-xs font-bold text-slate-700 focus:ring-0 p-0 cursor-pointer">
            </div>
            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2">
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">To</span>
                <input type="date" x-model="endDate" 
                       class="bg-transparent border-none text-xs font-bold text-slate-700 focus:ring-0 p-0 cursor-pointer">
            </div>
        </div>
    </div>

    <!-- Reports Table Card -->
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden min-h-[400px] flex flex-col">
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Asset
                            Identity</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Reported
                            By</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Incident
                            Details</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status
                        </th>
                        <th
                            class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                            Time Reported</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <template x-if="paginatedReports.length === 0">
                        <tr>
                            <td colspan="5" class="px-8 py-32 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-200">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-bold text-slate-400 italic">Vault is empty.</p>
                                </div>
                            </td>
                        </tr>
                    </template>

                    <template x-for="report in paginatedReports" :key="report.id">
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="flex flex-col">
                                        <span class="font-black text-slate-800 text-base italic"
                                            x-text="report.asset_name"></span>
                                        <span
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1"
                                            x-text="report.asset_tag"></span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-3">
                                    <template x-if="report.reported_by_image">
                                        <img :src="baseUrl + '/uploads/profiles/' + report.reported_by_image"
                                            class="w-8 h-8 rounded-full object-cover border-2 border-white shadow-sm"
                                            alt="Reporter">
                                    </template>
                                    <template x-if="!report.reported_by_image">
                                        <div
                                            class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-400 text-[10px] font-bold border-2 border-white shadow-sm">
                                            <span
                                                x-text="report.reported_by_name ? report.reported_by_name.charAt(0) : '?'"></span>
                                        </div>
                                    </template>
                                    <span class="font-bold text-slate-700 text-xs"
                                        x-text="report.reported_by_name || 'System'"></span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-700" x-text="report.title"></span>
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
                                <span
                                    class="px-3 py-1.5 text-[10px] font-black rounded-xl uppercase tracking-[0.1em] border shadow-sm whitespace-nowrap"
                                    :style="{
                                        'Resolved':  'background-color:#0f172a; color:#ffffff; border-color:#0f172a;',
                                        'Fixed':     'background-color:#10b981; color:#ffffff; border-color:#10b981;',
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
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-700 text-xs"
                                        x-text="new Date(report.reported_at).toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' })"></span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1"
                                        x-text="new Date(report.reported_at).toLocaleTimeString(undefined, { hour: '2-digit', minute: '2-digit' })"></span>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <template x-if="totalPages > 1">
            <div class="p-8 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400"
                    x-text="`Vault Page ${currentPage} of ${totalPages}`"></span>
                <div class="flex gap-3">
                    <button @click="if(currentPage > 1) currentPage--" :disabled="currentPage === 1"
                        class="px-5 py-2.5 bg-white border border-slate-200 text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm hover:bg-slate-900 hover:text-white disabled:opacity-30">
                        Previous
                    </button>
                    <button @click="if(currentPage < totalPages) currentPage++" :disabled="currentPage === totalPages"
                        class="px-5 py-2.5 bg-white border border-slate-200 text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm hover:bg-slate-900 hover:text-white disabled:opacity-30">
                        Next
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>