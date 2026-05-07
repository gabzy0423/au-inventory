<?php $title = 'Asset Catalog' ?>

<div class="space-y-8" x-data="{ 
    allAssets: <?= htmlspecialchars(json_encode($assets), ENT_QUOTES, 'UTF-8') ?>,
    search: '',
    categoryFilter: 'All Categories',
    locationFilter: 'All Comlabs',
    statusFilter: 'All Status',
    currentPage: 1,
    itemsPerPage: 10,

    get totalPages() {
        return Math.ceil(this.filteredAssets.length / this.itemsPerPage) || 1;
    },

    get filteredAssets() {
        return this.allAssets.filter(asset => {
            const matchesSearch = !this.search || 
                asset.name.toLowerCase().includes(this.search.toLowerCase()) ||
                asset.tag.toLowerCase().includes(this.search.toLowerCase()) ||
                (asset.asset_number && asset.asset_number.toLowerCase().includes(this.search.toLowerCase())) ||
                asset.location.toLowerCase().includes(this.search.toLowerCase());
            
            const matchesCategory = this.categoryFilter === 'All Categories' || asset.category_name === this.categoryFilter;
            const matchesLocation = this.locationFilter === 'All Comlabs' || asset.location === this.locationFilter;
            const matchesStatus = this.statusFilter === 'All Status' || asset.status === this.statusFilter;

            return matchesSearch && matchesCategory && matchesLocation && matchesStatus;
        });
    },

    get paginatedAssets() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const end = start + this.itemsPerPage;
        return this.filteredAssets.slice(start, end);
    },

    nextPage() {
        if (this.currentPage < this.totalPages) this.currentPage++;
    },

    prevPage() {
        if (this.currentPage > 1) this.currentPage--;
    }
}" x-init="
    $watch('search', () => currentPage = 1);
    $watch('categoryFilter', () => currentPage = 1);
    $watch('locationFilter', () => currentPage = 1);
    $watch('statusFilter', () => currentPage = 1);
">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight italic">Asset Catalog</h1>
            <p class="text-slate-500 mt-1 font-medium text-sm sm:text-base">Search for organization equipment and track laboratory health.</p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col lg:flex-row gap-4 items-center">
        <div class="relative flex-1 w-full">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" x-model="search" placeholder="Search assets..." 
                   class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-bold text-slate-700 text-sm shadow-sm">
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full lg:w-auto">
            <select x-model="locationFilter"
                class="bg-slate-50 border border-slate-200 text-slate-700 py-2.5 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest">
                <option>All Comlabs</option>
                <?php foreach ($rooms as $room): ?>
                    <option><?= $room['name'] ?></option>
                <?php endforeach; ?>
            </select>
            <select x-model="categoryFilter"
                class="bg-slate-50 border border-slate-200 text-slate-700 py-2.5 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest">
                <option>All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option><?= $cat['name'] ?></option>
                <?php endforeach; ?>
            </select>
            <select x-model="statusFilter"
                class="bg-slate-50 border border-slate-200 text-slate-700 py-2.5 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest">
                <option>All Status</option>
                <option>Available</option>
                <option>In Use</option>
                <option>Damaged</option>
                <option>Under Repair</option>
            </select>
        </div>
    </div>

    <!-- Inventory Table Card -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">

                        <th class="px-6 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Asset Details</th>
                        <th class="px-6 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Category</th>
                        <th class="px-6 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tracking Tag</th>
                        <th class="px-6 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Location</th>
                        <th class="px-6 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <template x-for="item in paginatedAssets" :key="item.id">
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-6">
                                <span class="font-bold text-slate-800 text-sm block group-hover:text-indigo-600 transition-colors italic" x-text="item.name"></span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter" x-text="(item.asset_number || 'N/A')"></span>
                            </td>
                            <td class="px-6 py-6">
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-slate-200 shadow-sm" x-text="item.category_name || 'Uncategorized'"></span>
                            </td>
                            <td class="px-6 py-6 font-mono text-xs font-bold text-slate-400" x-text="item.tag"></td>
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-2 text-slate-500 font-bold text-xs italic">
                                    <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span x-text="item.location"></span>
                                </div>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <span class="px-3 py-1 rounded-lg border text-[9px] font-black uppercase tracking-widest whitespace-nowrap"
                                      x-text="item.status"
                                      :style="{
                                          'Available':    'background-color:#ecfdf5; color:#059669; border-color:#d1fae5;',
                                          'In Use':       'background-color:#eff6ff; color:#2563eb; border-color:#dbeafe;',
                                          'Damaged':      'background-color:#fff1f2; color:#e11d48; border-color:#ffe4e6;',
                                          'Under Repair': 'background-color:#fffbeb; color:#d97706; border-color:#fde68a;'
                                      }[item.status] || 'background-color:#f8fafc; color:#475569; border-color:#e2e8f0;'">
                                </span>
                            </td>
                            <td class="px-6 py-6 text-right">
                                <a :href="'<?= $base_url ?>/staff/inventory/show/' + item.id"
                                   class="inline-flex px-5 py-2.5 bg-slate-900 border border-slate-900 text-white rounded-xl text-[10px] font-black shadow-lg shadow-slate-200 hover:bg-black transition-all uppercase tracking-widest">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    </template>
                    <template x-if="filteredAssets.length === 0">
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <p class="text-slate-400 font-bold italic tracking-tight">No assets found matching your search.</p>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <div class="p-8 bg-slate-50/30 border-t border-slate-50 flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400" 
                  x-text="'Showing ' + ((currentPage - 1) * itemsPerPage + (paginatedAssets.length > 0 ? 1 : 0)) + ' to ' + ((currentPage - 1) * itemsPerPage + paginatedAssets.length) + ' of ' + filteredAssets.length + ' entries'"></span>
            
            <div class="flex items-center gap-2">
                <button @click="prevPage()" :disabled="currentPage === 1"
                        :class="currentPage === 1 ? 'opacity-30 cursor-not-allowed shadow-none' : 'hover:bg-slate-900 hover:text-white active:scale-95 duration-200'"
                        class="px-6 py-3 bg-white border border-slate-200 text-slate-900 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">
                    Previous
                </button>
                
                <div class="flex items-center gap-1.5 px-4">
                    <span class="text-xs font-black text-slate-900" x-text="currentPage"></span>
                    <span class="text-[10px] font-bold text-slate-300">/</span>
                    <span class="text-[10px] font-black text-slate-400" x-text="totalPages"></span>
                </div>

                <button @click="nextPage()" :disabled="currentPage >= totalPages"
                        :class="currentPage >= totalPages ? 'opacity-30 cursor-not-allowed shadow-none' : 'hover:bg-slate-900 hover:text-white active:scale-95 duration-200'"
                        class="px-6 py-3 bg-white border border-slate-200 text-slate-900 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>