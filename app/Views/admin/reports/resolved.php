<?php $title = 'Resolved Reports' ?>

<div class="space-y-8" x-data="{ 
    searchQuery: '', 
    currentPage: 1, 
    itemsPerPage: 8,
    allReports: <?= htmlspecialchars(json_encode($reports), ENT_QUOTES, 'UTF-8') ?>,
    baseUrl: '<?= $base_url ?>',
    sortField: 'reported_at',
    sortOrder: 'desc',

    toggleSort(field) {
        if (this.sortField === field) {
            this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
        } else {
            this.sortField = field;
            this.sortOrder = 'asc';
        }
    },

    get filteredReports() {
        let filtered = this.allReports.filter(r => {
            const matchesSearch = !this.searchQuery || 
                r.asset_name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                r.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                r.asset_tag.toLowerCase().includes(this.searchQuery.toLowerCase());
            return matchesSearch;
        });

        return filtered.sort((a, b) => {
            let valA = a[this.sortField];
            let valB = b[this.sortField];
            
            // Handle nulls for reported_by_name
            if (this.sortField === 'reported_by_name') {
                valA = valA || '';
                valB = valB || '';
            }

            if (valA < valB) return this.sortOrder === 'asc' ? -1 : 1;
            if (valA > valB) return this.sortOrder === 'asc' ? 1 : -1;
            return 0;
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
">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a :href="baseUrl + '/admin/reports'" class="p-3 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-indigo-600 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight italic">Resolved History</h1>
                <p class="text-slate-500 mt-1">Archive of all resolved incidents and equipment maintenance history.</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a :href="baseUrl + '/admin/report/export'" 
               class="flex items-center gap-2 px-6 py-3 bg-white border-2 border-slate-100 text-slate-600 hover:bg-slate-50 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-sm active:scale-95">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Report
            </a>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white p-4 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col md:flex-row gap-4 items-center mb-8">
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

        <div class="flex items-center gap-3 w-full md:w-auto">
            <select x-model="sortField" 
                class="bg-slate-50 border border-slate-200 text-slate-700 py-3 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 w-full md:w-48 transition-all cursor-pointer font-bold text-xs uppercase tracking-widest">
                <option value="reported_at">Sort by Date</option>
                <option value="asset_name">Sort by Asset</option>
                <option value="reported_by_name">Sort by Reporter</option>
                <option value="title">Sort by Incident</option>
            </select>
            
            <select x-model="sortOrder"
                class="bg-slate-50 border border-slate-200 text-slate-700 py-3 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 w-full md:w-40 transition-all cursor-pointer font-bold text-xs uppercase tracking-widest">
                <option value="desc">Descending</option>
                <option value="asc">Ascending</option>
            </select>
        </div>
    </div>


    <!-- Reports Table Card -->
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden min-h-[400px] flex flex-col">
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest cursor-pointer hover:text-slate-600 transition-colors" @click="toggleSort('asset_name')">
                            <div class="flex items-center gap-2">
                                Asset Target
                                <svg x-show="sortField === 'asset_name'" class="w-3 h-3" :class="sortOrder === 'asc' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3"/></svg>
                            </div>
                        </th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest cursor-pointer hover:text-slate-600 transition-colors" @click="toggleSort('fixed_by_name')">
                            <div class="flex items-center gap-2">
                                Fixed By
                                <svg x-show="sortField === 'fixed_by_name'" class="w-3 h-3" :class="sortOrder === 'asc' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3"/></svg>
                            </div>
                        </th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest cursor-pointer hover:text-slate-600 transition-colors" @click="toggleSort('title')">
                            <div class="flex items-center gap-2">
                                Incident Detail
                                <svg x-show="sortField === 'title'" class="w-3 h-3" :class="sortOrder === 'asc' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3"/></svg>
                            </div>
                        </th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right cursor-pointer hover:text-slate-600 transition-colors" @click="toggleSort('reported_at')">
                            <div class="flex items-center justify-end gap-2">
                                Resolved Date
                                <svg x-show="sortField === 'reported_at'" class="w-3 h-3" :class="sortOrder === 'asc' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3"/></svg>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <template x-if="paginatedReports.length === 0">
                        <tr>
                            <td colspan="5" class="px-8 py-32 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-200">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-bold text-slate-400 italic">No resolved reports found.</p>
                                </div>
                            </td>
                        </tr>
                    </template>

                    <template x-for="report in paginatedReports" :key="report.id">
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="flex flex-col">
                                        <span class="font-black text-slate-800 text-base group-hover:text-emerald-600 transition-colors" x-text="report.asset_name"></span>
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1" x-text="report.asset_tag"></span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6">
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
                                    <span class="font-bold text-slate-700 text-xs" x-text="report.fixed_by_name || 'System Auto'"></span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-700" x-text="report.title"></span>
                                    <span class="text-xs text-slate-400 italic truncate max-w-xs block" x-text="report.description"></span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="px-3 py-1.5 text-[10px] font-black rounded-xl uppercase tracking-[0.1em] bg-emerald-500 text-white shadow-md shadow-emerald-500/20">
                                    Resolved
                                </span>
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
                    x-text="`Archive Page ${currentPage} of ${totalPages}`"></span>
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

