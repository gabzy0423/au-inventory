<?php $title = 'Global Activity Feed' ?>

<div class="space-y-8" x-data="{
    allReports: <?= htmlspecialchars(json_encode($reports), ENT_QUOTES, 'UTF-8') ?>,
    currentPage: 1,
    itemsPerPage: 10,
    searchAsset: '',
    filterStatus: '',
    get filteredReports() {
        return this.allReports.filter(r => {
            const matchesAsset = r.asset_name.toLowerCase().includes(this.searchAsset.toLowerCase()) || 
                               r.asset_tag.toLowerCase().includes(this.searchAsset.toLowerCase());
            const matchesStatus = this.filterStatus === '' || r.status === this.filterStatus;
            return matchesAsset && matchesStatus;
        });
    },
    get totalPages() { return Math.ceil(this.filteredReports.length / this.itemsPerPage); },
    get paginatedReports() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        return this.filteredReports.slice(start, start + this.itemsPerPage);
    },
    nextPage() { if (this.currentPage < this.totalPages) this.currentPage++; },
    prevPage() { if (this.currentPage > 1) this.currentPage--; }
}">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight italic">Global Activity Feed</h1>
            <p class="text-slate-500 mt-1 font-medium italic underline decoration-amber-500/30">Live visibility of all active organizational maintenance logs.</p>
        </div>
        <div class="flex items-center gap-3">
             <div class="flex items-center gap-2 px-4 py-2 bg-emerald-50 rounded-2xl border border-emerald-100">
                 <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                 <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Live Updates</span>
             </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <input type="text" x-model="searchAsset" placeholder="Search by Asset Name or Tag..." 
                   class="w-full pl-11 pr-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-amber-500 outline-none font-bold text-slate-700 transition-all text-sm shadow-inner">
        </div>
        <select x-model="filterStatus" 
                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-amber-500 outline-none font-bold text-slate-700 transition-all text-sm shadow-inner">
            <option value="">All Statuses</option>
            <option value="Pending">Pending Approval</option>
            <option value="Approved">Approved</option>
            <option value="Under Repair">Under Repair</option>
            <option value="Fixed">Fixed</option>
            <option value="Resolved">Resolved</option>
        </select>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden min-h-[500px]">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Asset</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Incident Summary</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Reported At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <template x-for="report in paginatedReports" :key="report.id">
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-800 text-sm block italic" x-text="report.asset_name"></span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest" x-text="report.asset_tag"></span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-700 text-sm" x-text="report.title"></span>
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
                                <span class="text-xs text-slate-400 line-clamp-1" x-text="report.description"></span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-3 py-1 text-[10px] font-black uppercase rounded-lg border shadow-sm"
                                      :class="{
                                          'bg-yellow-50 text-yellow-600 border-yellow-100': report.status === 'Pending',
                                          'bg-indigo-50 text-indigo-600 border-indigo-100': report.status === 'Approved',
                                          'bg-orange-500 text-white border-orange-500 shadow-orange-500/20': report.status === 'Under Repair',
                                          'bg-emerald-500 text-white border-emerald-500 shadow-emerald-500/20': report.status === 'Fixed',
                                          'bg-slate-900 text-white border-slate-900': report.status === 'Resolved'
                                      }"
                                      x-text="report.status === 'Under Repair' ? 'In Progress' : report.status">
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <p class="text-[11px] font-bold text-slate-600" x-text="new Date(report.reported_at).toLocaleDateString()"></p>
                                <p class="text-[9px] text-slate-400 uppercase font-bold" x-text="new Date(report.reported_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})"></p>
                            </td>
                        </tr>
                    </template>
                    <template x-if="filteredReports.length === 0">
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    <p class="text-slate-400 font-bold italic tracking-tight">No active reports found in the global feed.</p>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <div x-show="totalPages > 1" class="p-8 bg-slate-50/50 border-t border-slate-50 flex items-center justify-between">
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400" 
                  x-text="'Showing ' + ((currentPage - 1) * itemsPerPage + (paginatedReports.length > 0 ? 1 : 0)) + ' to ' + ((currentPage - 1) * itemsPerPage + paginatedReports.length) + ' of ' + filteredReports.length + ' entries'"></span>
            
            <div class="flex items-center gap-3">
                <button @click="prevPage()" :disabled="currentPage === 1"
                        class="px-6 py-3 bg-white border-2 border-slate-100 text-slate-900 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm disabled:opacity-30 disabled:cursor-not-allowed hover:bg-slate-900 hover:text-white">
                    Prev
                </button>
                <button @click="nextPage()" :disabled="currentPage >= totalPages"
                        class="px-6 py-3 bg-white border-2 border-slate-100 text-slate-900 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm disabled:opacity-30 disabled:cursor-not-allowed hover:bg-slate-900 hover:text-white">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>
