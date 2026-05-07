<?php $title = 'Asset Health Logs' ?>

<div class="space-y-8" x-data="{
    allReports: <?= htmlspecialchars(json_encode($reports), ENT_QUOTES, 'UTF-8') ?>,
    search: '',
    statusFilter: 'All Status',
    currentPage: 1,
    itemsPerPage: 10,

    get filteredReports() {
        return this.allReports.filter(r => {
            const matchesSearch = !this.search || 
                r.asset_name.toLowerCase().includes(this.search.toLowerCase()) ||
                r.asset_tag.toLowerCase().includes(this.search.toLowerCase()) ||
                r.title.toLowerCase().includes(this.search.toLowerCase());
            
            const matchesStatus = this.statusFilter === 'All Status' || r.status === this.statusFilter;
            return matchesSearch && matchesStatus;
        });
    },

    get totalPages() { return Math.ceil(this.filteredReports.length / this.itemsPerPage) || 1; },
    get paginatedReports() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        return this.filteredReports.slice(start, start + this.itemsPerPage);
    },
    nextPage() { if (this.currentPage < this.totalPages) this.currentPage++; },
    prevPage() { if (this.currentPage > 1) this.currentPage--; }
}" x-init="$watch('search', () => currentPage = 1); $watch('statusFilter', () => currentPage = 1);">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight italic">Incident Log</h1>
            <p class="text-slate-500 mt-1 font-medium">Historical audit trail of all asset damage reports and repair states.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?= $base_url ?>/staff/reports/public" 
               class="bg-white border-2 border-slate-100 text-slate-600 hover:bg-slate-50 px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-sm active:scale-95">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                Global Feed
            </a>
            <a href="<?= $base_url ?>/staff/reports/vault" 
               class="bg-slate-900 text-white hover:bg-black px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-xl shadow-slate-900/20 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                Resolved Vault
            </a>
        </div>
    </div>

    <!-- Search & Filter Section -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row gap-4 items-center">
        <div class="relative flex-1 w-full">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" x-model="search" placeholder="Search by asset or issue..." 
                   class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all font-bold text-slate-700 text-sm shadow-sm">
        </div>
        <select x-model="statusFilter"
            class="w-full md:w-64 bg-slate-50 border border-slate-200 text-slate-700 py-2.5 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest">
            <option>All Status</option>
            <option>Pending</option>
            <option>Approved</option>
            <option>Under Repair</option>
            <option>Fixed</option>
            <option>Resolved</option>
        </select>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Logs</p>
            <p class="text-3xl font-black text-slate-900 italic" x-text="allReports.length"></p>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Resolved</p>
            <p class="text-3xl font-black text-emerald-600 italic" x-text="allReports.filter(r => ['Fixed', 'Resolved'].includes(r.status)).length"></p>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">In Progress</p>
            <p class="text-3xl font-black text-orange-600 italic" x-text="allReports.filter(r => ['Approved', 'Under Repair'].includes(r.status)).length"></p>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Pending</p>
            <p class="text-3xl font-black text-yellow-600 italic" x-text="allReports.filter(r => r.status === 'Pending').length"></p>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Asset Details</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Incident Note</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Timestamp</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                <template x-for="report in paginatedReports" :key="report.id">
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-6">
                                <div>
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
                                  x-text="report.status === 'Resolved' ? 'Resolved' : (report.status === 'Fixed' ? 'Fixed' : (report.status === 'Under Repair' ? 'Under Repair' : (report.status === 'Approved' ? 'Approved' : 'Pending')))">
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-[11px] font-bold text-slate-600" x-text="new Date(report.reported_at).toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' })"></p>
                            <p class="text-[10px] text-slate-400" x-text="new Date(report.reported_at).toLocaleTimeString(undefined, { hour: '2-digit', minute: '2-digit' })"></p>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <template x-if="report.status === 'Fixed'">
                                <form :action="'<?= $base_url ?>/staff/report/resolve/' + report.id" method="POST">
                                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                                        Resolve Incident
                                    </button>
                                </form>
                            </template>
                            <template x-if="report.status !== 'Fixed'">
                                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest italic">No Action</span>
                            </template>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div x-show="totalPages > 1" class="p-6 bg-slate-50/30 border-t border-slate-100 flex items-center justify-between">
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400" 
                  x-text="'Showing ' + ((currentPage - 1) * itemsPerPage + (paginatedReports.length > 0 ? 1 : 0)) + ' to ' + ((currentPage - 1) * itemsPerPage + paginatedReports.length) + ' of ' + allReports.length + ' logs'"></span>
            
            <div class="flex items-center gap-2">
                <button @click="prevPage()" 
                        :disabled="currentPage === 1"
                        :class="currentPage === 1 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-slate-900 hover:text-white'"
                        class="px-5 py-2 bg-white border border-slate-200 text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">
                    Prev
                </button>
                <button @click="nextPage()" 
                        :disabled="currentPage === totalPages"
                        :class="currentPage === totalPages ? 'opacity-30 cursor-not-allowed' : 'hover:bg-slate-900 hover:text-white'"
                        class="px-5 py-2 bg-white border border-slate-200 text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>
