<?php $title = 'Resolved Incident Vault' ?>

<div class="space-y-8" x-data="{
    allReports: <?= htmlspecialchars(json_encode($reports), ENT_QUOTES, 'UTF-8') ?>,
    currentPage: 1,
    itemsPerPage: 10,
    get totalPages() { return Math.ceil(this.allReports.length / this.itemsPerPage); },
    get paginatedReports() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        return this.allReports.slice(start, start + this.itemsPerPage);
    },
    nextPage() { if (this.currentPage < this.totalPages) this.currentPage++; },
    prevPage() { if (this.currentPage > 1) this.currentPage--; }
}">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                <a href="<?= $base_url ?>/staff/reports" class="hover:text-indigo-600 transition-colors">Incident Log</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-300">Resolved Vault</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic flex items-center gap-4">
                Resolved Incident Vault
                <span class="bg-indigo-50 text-indigo-600 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest border border-indigo-100 shadow-sm not-italic">Archive</span>
            </h1>
            <p class="text-slate-500 mt-1 font-medium italic">Secure storage for all completed maintenance activities and resolved technical logs.</p>
        </div>
        
        <a href="<?= $base_url ?>/staff/reports" 
           class="bg-white border-2 border-slate-100 text-slate-600 hover:bg-slate-50 hover:border-slate-200 px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-sm active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Active Logs
        </a>
    </div>

    <!-- Vault Card -->
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden relative">
        <div class="absolute top-0 right-0 w-64 h-64 bg-slate-50 rounded-full -mr-32 -mt-32 pointer-events-none"></div>
        
        <table class="w-full text-left border-collapse relative z-10">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Asset Information</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Incident History</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Closure Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <template x-for="report in paginatedReports" :key="report.id">
                    <tr class="hover:bg-slate-50/30 transition-colors group">
                        <td class="px-8 py-8">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 rounded-2xl bg-slate-50 shrink-0 border border-slate-100 shadow-inner flex items-center justify-center text-slate-300 font-black text-[10px]">
                                    <span x-text="report.asset_tag.slice(-3)"></span>
                                </div>
                                <div>
                                    <span class="font-black text-slate-800 text-base block italic" x-text="report.asset_name"></span>
                                    <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest" x-text="report.asset_tag"></span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-8">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-bold text-slate-700 text-sm italic" x-text="report.title"></span>
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
                            <span class="text-xs text-slate-400 line-clamp-2 max-w-md leading-relaxed" x-text="report.description"></span>
                        </td>
                        <td class="px-8 py-8 text-center">
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-2xl border border-emerald-100 shadow-sm shadow-emerald-100/20">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                <span class="text-[10px] font-black uppercase tracking-widest">Resolved</span>
                            </div>
                        </td>
                        <td class="px-8 py-8">
                            <div class="space-y-1">
                                <p class="text-sm font-black text-slate-700 italic" x-text="new Date(report.reported_at).toLocaleDateString(undefined, { month: 'long', day: 'numeric', year: 'numeric' })"></p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest" x-text="new Date(report.reported_at).toLocaleTimeString(undefined, { hour: '2-digit', minute: '2-digit' })"></p>
                            </div>
                        </td>
                    </tr>
                </template>
                
                <tr x-show="allReports.length === 0">
                    <td colspan="4" class="px-8 py-32 text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 text-slate-200">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 italic mb-2">Vault is Empty</h3>
                        <p class="text-sm font-medium text-slate-400 max-w-xs mx-auto">No incidents have been moved to the resolution vault yet.</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div x-show="totalPages > 1" class="p-8 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400" 
                  x-text="'Archived Entries: ' + ((currentPage - 1) * itemsPerPage + (paginatedReports.length > 0 ? 1 : 0)) + ' - ' + ((currentPage - 1) * itemsPerPage + paginatedReports.length) + ' of ' + allReports.length"></span>
            
            <div class="flex items-center gap-3">
                <button @click="prevPage()" 
                        :disabled="currentPage === 1"
                        class="px-6 py-3 bg-white border-2 border-slate-100 text-slate-900 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm disabled:opacity-30 disabled:cursor-not-allowed hover:border-indigo-600 hover:text-indigo-600">
                    Prev
                </button>
                <button @click="nextPage()" 
                        :disabled="currentPage === totalPages"
                        class="px-6 py-3 bg-white border-2 border-slate-100 text-slate-900 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm disabled:opacity-30 disabled:cursor-not-allowed hover:border-indigo-600 hover:text-indigo-600">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>
