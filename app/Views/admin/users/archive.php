<?php $title = 'Archived Users' ?>

<div class="space-y-8" x-data="{
    searchQuery: '',
    filterRole: 'All Roles',
    users: <?= htmlspecialchars(json_encode($archivedUsers), ENT_QUOTES, 'UTF-8') ?>,
    currentPage: 1,
    itemsPerPage: 8,
    get filteredUsers() {
        return this.users.filter(u => {
            const matchesSearch = !this.searchQuery || 
                u.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                u.email.toLowerCase().includes(this.searchQuery.toLowerCase());
            
            const matchesRole = this.filterRole === 'All Roles' || u.role.toLowerCase() === this.filterRole.toLowerCase();

            return matchesSearch && matchesRole;
        });
    },
    get totalPages() {
        return Math.ceil(this.filteredUsers.length / this.itemsPerPage) || 1;
    },
    get paginatedUsers() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const end = start + this.itemsPerPage;
        return this.filteredUsers.slice(start, end);
    },
    nextPage() {
        if (this.currentPage < this.totalPages) this.currentPage++;
    },
    prevPage() {
        if (this.currentPage > 1) this.currentPage--;
    }
}" x-init="
    $watch('searchQuery', () => currentPage = 1);
    $watch('filterRole', () => currentPage = 1);
">

    <!-- Top Bar with Breadcrumbs & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                <a href="<?= $base_url ?>/admin/users" class="hover:text-indigo-600 transition-colors">Users</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-300">Archive Vault</span>
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight italic">Archived Users</h1>
            <p class="text-slate-500 font-medium mt-1">Manage deactivated accounts that are currently hidden from the active roster.</p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row gap-4 items-center">
        <div class="relative flex-1 w-full">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" x-model="searchQuery" placeholder="Search by name or email..."
                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-bold text-slate-700">
        </div>
        <div class="w-full md:w-auto">
            <select x-model="filterRole"
                class="bg-slate-50 border border-slate-200 text-slate-700 py-3 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 w-full md:w-48 transition-all cursor-pointer font-bold text-xs uppercase tracking-widest">
                <option>All Roles</option>
                <option value="admin">Administrators</option>
                <option value="staff">Staff Members</option>
            </select>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-widest">User Profile</th>
                        <th class="px-6 py-6 text-[10px] font-black uppercase text-slate-400 tracking-widest text-center">System Role</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-widest text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <template x-for="user in paginatedUsers" :key="user.id">
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 font-black text-xs uppercase shadow-inner group-hover:scale-110 transition-transform" x-text="user.name.charAt(0)"></div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 block text-sm italic" x-text="user.name"></span>
                                        <span class="text-[10px] text-slate-400 uppercase tracking-widest font-black" x-text="user.email"></span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[10px] font-black rounded-lg uppercase tracking-widest border border-slate-200/50" x-text="user.role"></span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <form :action="'<?= $base_url ?>/admin/users/restore/' + user.id" method="POST" class="inline">
                                    <button type="submit" 
                                        class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-50 text-emerald-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all shadow-sm active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        Restore
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </template>

                    <!-- Empty State -->
                    <template x-if="filteredUsers.length === 0">
                        <tr>
                            <td colspan="3" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-2 shadow-inner border border-slate-100/50">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                    </div>
                                    <h4 class="font-bold text-slate-400 text-lg tracking-tight">No archives found</h4>
                                    <p class="text-sm text-slate-400">Try adjusting your search query.</p>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <div class="p-8 bg-slate-50/30 border-t border-slate-50 flex items-center justify-between">
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400"
                x-text="'Showing ' + ((currentPage - 1) * itemsPerPage + (paginatedUsers.length > 0 ? 1 : 0)) + ' to ' + ((currentPage - 1) * itemsPerPage + paginatedUsers.length) + ' of ' + filteredUsers.length + ' entries'"></span>

            <div class="flex items-center gap-4">
                <button @click="prevPage()" :disabled="currentPage === 1"
                    :class="currentPage === 1 ? 'opacity-30 cursor-not-allowed shadow-none' : 'hover:bg-slate-900 hover:text-white active:scale-95 duration-200'"
                    class="px-6 py-3 bg-white border-2 border-slate-100 text-slate-900 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">
                    Previous
                </button>

                <div class="flex items-center gap-2 px-4 border-x-2 border-slate-100/50">
                    <span class="text-[11px] font-black text-slate-900" x-text="currentPage"></span>
                    <span class="text-[11px] font-bold text-slate-300">/</span>
                    <span class="text-[11px] font-black text-slate-400" x-text="totalPages"></span>
                </div>

                <button @click="nextPage()" :disabled="currentPage >= totalPages"
                    :class="currentPage >= totalPages ? 'opacity-30 cursor-not-allowed shadow-none' : 'hover:bg-slate-900 hover:text-white active:scale-95 duration-200'"
                    class="px-6 py-3 bg-white border-2 border-slate-100 text-slate-900 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>
</div>
