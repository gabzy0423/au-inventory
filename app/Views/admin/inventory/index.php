<?php $title = 'Inventory Management' ?>

<div class="space-y-8" x-data="{ 
    showArchiveConfirm: false,
    archiveTargetId: null,
    
    // Dynamic Filtering State
    allAssets: <?= htmlspecialchars(json_encode($assets), ENT_QUOTES, 'UTF-8') ?>,
    searchQuery: '',
    filterLocation: 'All Comlabs',
    filterCategory: 'All Categories',
    filterStatus: 'All Status',
    currentPage: 1,
    itemsPerPage: 8,

    get totalPages() {
        return Math.ceil(this.filteredAssets.length / this.itemsPerPage) || 1;
    },

    get paginatedAssets() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const end = start + this.itemsPerPage;
        return this.filteredAssets.slice(start, end);
    },

    get filteredAssets() {
        return this.allAssets.filter(asset => {
            const matchesSearch = !this.searchQuery || 
                asset.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                asset.tag.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                (asset.asset_number && asset.asset_number.toLowerCase().includes(this.searchQuery.toLowerCase())) ||
                asset.location.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                (asset.category_name && asset.category_name.toLowerCase().includes(this.searchQuery.toLowerCase()));
            
            const matchesLocation = this.filterLocation === 'All Comlabs' || asset.location === this.filterLocation;
            const matchesCategory = this.filterCategory === 'All Categories' || asset.category_name === this.filterCategory;
            const matchesStatus = this.filterStatus === 'All Status' || asset.status === this.filterStatus;

            return matchesSearch && matchesLocation && matchesCategory && matchesStatus;
        });
    },

    nextPage() {
        if (this.currentPage < this.totalPages) this.currentPage++;
    },

    prevPage() {
        if (this.currentPage > 1) this.currentPage--;
    },

    selectedIds: [],

    toggleSelectAll() {
        if (this.selectedIds.length === this.paginatedAssets.length) {
            this.selectedIds = [];
        } else {
            this.selectedIds = this.paginatedAssets.map(a => a.id);
        }
    }
} " x-init="
    // 1. Restore state from sessionStorage if it exists
    const savedState = JSON.parse(sessionStorage.getItem('inventory_state'));
    if (savedState) {
        searchQuery = savedState.searchQuery || '';
        filterLocation = savedState.filterLocation || 'All Comlabs';
        filterCategory = savedState.filterCategory || 'All Categories';
        filterStatus = savedState.filterStatus || 'All Status';
        currentPage = savedState.currentPage || 1;
    }

    // 2. Handle URL Hash for auto-paging
    if (window.location.hash.startsWith('#asset-')) {
        const targetId = parseInt(window.location.hash.split('-')[1]);
        const targetIndex = filteredAssets.findIndex(a => a.id == targetId);
        if (targetIndex !== -1) {
            currentPage = Math.floor(targetIndex / itemsPerPage) + 1;
            setTimeout(() => {
                const el = document.getElementById('asset-' + targetId);
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 500);
        }
    }

    // 3. Reset page on filter changes
    $watch('searchQuery', () => { currentPage = 1; selectedIds = []; });
    $watch('filterLocation', () => { currentPage = 1; selectedIds = []; });
    $watch('filterCategory', () => { currentPage = 1; selectedIds = []; });
    $watch('filterStatus', () => { currentPage = 1; selectedIds = []; });
" x-effect="sessionStorage.setItem('inventory_state', JSON.stringify({ searchQuery, filterLocation, filterCategory, filterStatus, currentPage }))">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight italic">Asset Inventory</h1>
            <p class="text-slate-500 mt-1 text-sm sm:text-base">Manage and track all organizational assets from a single interface.</p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col lg:flex-row gap-4 items-center">
        <div class="relative flex-1 w-full">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" x-model="searchQuery" placeholder="Search assets..."
                class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-bold text-slate-700 text-sm">
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full lg:w-auto">
            <select x-model="filterLocation"
                class="bg-slate-50 border border-slate-200 text-slate-700 py-2.5 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest">
                <option>All Comlabs</option>
                <?php foreach ($rooms as $room): ?>
                    <option><?= $room['name'] ?></option>
                <?php endforeach; ?>
            </select>
            <select x-model="filterCategory"
                class="bg-slate-50 border border-slate-200 text-slate-700 py-2.5 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest">
                <option>All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option><?= $cat['name'] ?></option>
                <?php endforeach; ?>
            </select>
            <select x-model="filterStatus"
                class="bg-slate-50 border border-slate-200 text-slate-700 py-2.5 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest">
                <option>All Status</option>
                <option>Available</option>
                <option>In Use</option>
                <option>Damaged</option>
                <option>Under Repair</option>
            </select>
        </div>
    </div>

    <!-- Bulk Actions Floating Bar -->
    <template x-if="selectedIds.length > 0">
        <div class="fixed bottom-8 left-1/2 -translate-x-1/2 z-[100] w-full max-w-2xl px-4">
            <div
                class="bg-slate-900 text-white rounded-3xl shadow-2xl p-4 flex items-center justify-between border border-white/10 backdrop-blur-xl bg-slate-900/90">
                <div class="flex items-center gap-4 pl-4">
                    <div class="flex flex-col">
                        <span class="text-xl font-black italic tracking-tight" x-text="selectedIds.length"></span>
                        <span class="text-[8px] font-bold uppercase tracking-widest text-slate-400">Assets
                            Selected</span>
                    </div>
                    <div class="h-8 w-px bg-white/10 mx-2"></div>
                    <p class="text-xs font-bold text-slate-300">Apply batch updates to these items</p>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="selectedIds = []"
                        class="px-6 py-3 hover:bg-white/5 rounded-2xl text-xs font-bold uppercase tracking-widest transition-all">Deselect</button>

                    <form action="<?= $base_url ?>/admin/inventory/bulk-edit" method="POST" class="inline">
                        <template x-for="id in selectedIds">
                            <input type="hidden" name="ids[]" :value="id">
                        </template>
                        <button type="submit"
                            class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-indigo-600/20 active:scale-95">Continue
                            to Bulk Update</button>
                    </form>
                </div>
            </div>
        </div>
    </template>

    <!-- Main Inventory Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 w-16 text-center">
                            <input type="checkbox" @click="toggleSelectAll()"
                                :checked="selectedIds.length === paginatedAssets.length && paginatedAssets.length > 0"
                                class="w-5 h-5 rounded-lg border-2 border-slate-200 text-indigo-600 focus:ring-indigo-500/20 transition-all cursor-pointer">
                        </th>

                        <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest">Asset Details
                        </th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest">Tracking Tag
                        </th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest">Location</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest">Category</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">
                            Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <!-- Empty State -->
                    <template x-if="filteredAssets.length === 0">
                        <tr>
                            <td colspan="7" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-400 tracking-tight">No assets found</h3>
                                    <p class="text-sm text-slate-400">No assets match your current search or filter
                                        criteria.</p>
                                    <button
                                        @click="searchQuery = ''; filterLocation = 'All Comlabs'; filterCategory = 'All Categories'; filterStatus = 'All Status';"
                                        class="mt-4 px-6 py-2 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all">Clear
                                        All Filters</button>
                                </div>
                            </td>
                        </tr>
                    </template>

                    <!-- Dynamic Asset Rows -->
                    <template x-for="item in paginatedAssets" :key="item.id">
                        <tr :id="'asset-' + item.id" 
                            class="hover:bg-slate-50/50 transition-colors group"
                            :class="window.location.hash === '#asset-' + item.id ? 'bg-indigo-50/50 ring-2 ring-indigo-500/20' : ''">
                            <td class="px-8 py-6 text-center">
                                <input type="checkbox" :value="item.id" x-model="selectedIds"
                                    class="w-5 h-5 rounded-lg border-2 border-slate-200 text-indigo-600 focus:ring-indigo-500/20 transition-all cursor-pointer">
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex flex-col">
                                    <span class="font-black text-slate-800 text-lg leading-tight"
                                        x-text="item.name"></span>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs text-slate-400 font-bold uppercase tracking-widest" x-text="item.asset_number || 'NO-ASSET-#'"></span>
                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                        <span class="text-xs text-slate-400" x-text="'ID: #' + item.id"></span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6 font-mono text-sm font-bold text-slate-400" x-text="item.tag"></td>
                            <td class="px-6 py-6 font-medium text-slate-500">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span x-text="item.location"></span>
                                </div>
                            </td>
                            <td class="px-6 py-6 font-medium text-slate-500">
                                <span
                                    class="px-2.5 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-lg uppercase tracking-wider"
                                    x-text="item.category_name"></span>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex justify-center">
                                    <span
                                        class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-[0.1em] border shadow-sm whitespace-nowrap"
                                        x-text="item.status" :style="{
                'Available':    'background-color:#f0fdf4; color:#15803d; border-color:#bbf7d0;',
                'In Use':       'background-color:#eff6ff; color:#1d4ed8; border-color:#bfdbfe;',
                'Damaged':      'background-color:#fff1f2; color:#be123c; border-color:#fecdd3;',
                'Under Repair': 'background-color:#fff7ed; color:#f97316; border-color:#fed7aa;',
            }[item.status] ?? 'background-color:#f8fafc; color:#64748b; border-color:#e2e8f0;'">
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a :href="'<?= $base_url ?>/admin/inventory/show/' + item.id"
                                        class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                        title="View Details">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a :href="'<?= $base_url ?>/admin/inventory/edit/' + item.id"
                                        class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all"
                                        title="Edit Asset">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <button @click="archiveTargetId = item.id; showArchiveConfirm = true"
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all"
                                        title="Archive Asset">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <div class="p-6 bg-white border-t border-slate-50 flex items-center justify-between">
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400"
                x-text="'Showing ' + ((currentPage - 1) * itemsPerPage + (paginatedAssets.length > 0 ? 1 : 0)) + ' to ' + ((currentPage - 1) * itemsPerPage + paginatedAssets.length) + ' of ' + filteredAssets.length + ' entries'"></span>

            <div class="flex items-center gap-2">
                <button @click="prevPage()" :disabled="currentPage === 1"
                    :class="currentPage === 1 ? 'opacity-30 cursor-not-allowed shadow-none' : 'hover:bg-slate-900 hover:text-white active:scale-95 duration-200'"
                    class="px-5 py-2.5 bg-white border border-slate-200 text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">
                    Previous
                </button>

                <div class="flex items-center gap-1 px-2 border-x border-slate-100">
                    <span class="text-[10px] font-black text-slate-900" x-text="currentPage"></span>
                    <span class="text-[10px] font-bold text-slate-300">/</span>
                    <span class="text-[10px] font-black text-slate-400" x-text="totalPages"></span>
                </div>

                <button @click="nextPage()" :disabled="currentPage >= totalPages"
                    :class="currentPage >= totalPages ? 'opacity-30 cursor-not-allowed shadow-none' : 'hover:bg-slate-900 hover:text-white active:scale-95 duration-200'"
                    class="px-5 py-2.5 bg-white border border-slate-200 text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">
                    Next
                </button>
            </div>
        </div>
    </div>







    <!-- ARCHIVE CONFIRMATION MODAL -->
    <template x-teleport="body">
        <div x-show="showArchiveConfirm" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md"
            style="display: none;">

            <div @click.away="showArchiveConfirm = false"
                class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl relative overflow-hidden p-8 text-center">

                <div
                    class="w-20 h-20 bg-rose-50 text-rose-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-inner">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>

                <h3 class="text-2xl font-black text-slate-900 mb-2 italic">Archive Asset?</h3>
                <p class="text-sm font-medium text-slate-500 mb-8 leading-relaxed">This item will be hidden from the
                    active inventory and moved to the vault.</p>

                <div class="flex flex-col gap-3">
                    <form :action="'<?= $base_url ?>/admin/inventory/archive/' + archiveTargetId" method="POST">
                        <button type="submit"
                            class="w-full py-4 bg-rose-600 text-white rounded-2xl font-bold hover:bg-rose-700 shadow-xl shadow-rose-600/30 transition-all active:scale-95 duration-200">
                            Yes, Archive It
                        </button>
                    </form>
                    <button @click="showArchiveConfirm = false"
                        class="w-full py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition-all">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>