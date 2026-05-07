<div class="space-y-8" x-data="{ 
    showArchiveConfirm: false,
    archiveTargetId: null,
    
    allUsers: <?= htmlspecialchars(json_encode($users), ENT_QUOTES, 'UTF-8') ?>,
    searchQuery: '',
    filterRole: 'All Roles',
    currentPage: 1,
    itemsPerPage: 8,

    get totalPages() {
        return Math.ceil(this.filteredUsers.length / this.itemsPerPage) || 1;
    },

    get paginatedUsers() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const end = start + this.itemsPerPage;
        return this.filteredUsers.slice(start, end);
    },

    get filteredUsers() {
        return this.allUsers.filter(user => {
            const matchesSearch = !this.searchQuery || 
                user.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                user.email.toLowerCase().includes(this.searchQuery.toLowerCase());
            
            const matchesRole = this.filterRole === 'All Roles' || user.role.toLowerCase() === this.filterRole.toLowerCase();

            return matchesSearch && matchesRole;
        });
    },

    nextPage() {
        if (this.currentPage < this.totalPages) this.currentPage++;
    },

    prevPage() {
        if (this.currentPage > 1) this.currentPage--;
    }
} " x-init="
    $watch('searchQuery', () => currentPage = 1);
    $watch('filterRole', () => currentPage = 1);
">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight italic">System Users</h1>
            <p class="text-slate-500 mt-1 text-sm sm:text-base">Manage administrative and staff access permissions here.</p>
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
            <input type="text" x-model="searchQuery" placeholder="Search by name or email..."
                class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-bold text-slate-700 placeholder:text-slate-300 text-sm">
        </div>
        <div class="w-full lg:w-auto">
            <select x-model="filterRole"
                class="bg-slate-50 border border-slate-200 text-slate-700 py-2.5 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 w-full lg:w-48 transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest">
                <option>All Roles</option>
                <option value="admin">Administrators</option>
                <option value="staff">Staff Members</option>
            </select>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">User Profile</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">System Role</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Access ID</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Registration</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <template x-if="filteredUsers.length === 0">
                        <tr>
                            <td colspan="5" class="px-8 py-32 text-center text-slate-400">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200 shadow-inner">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    </div>
                                    <p class="font-bold italic">No user identities matched your query.</p>
                                </div>
                            </td>
                        </tr>
                    </template>

                    <template x-for="user in paginatedUsers" :key="user.id">
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-lg shadow-inner transition-transform group-hover:scale-110 overflow-hidden">
                                        <template x-if="user.profile_image">
                                            <img :src="'<?= $base_url ?>/uploads/profiles/' + user.profile_image" class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="!user.profile_image">
                                            <span x-text="user.name.charAt(0).toUpperCase()"></span>
                                        </template>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-black text-slate-800 text-base leading-tight italic" x-text="user.name"></span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5" x-text="user.email"></span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-lg uppercase tracking-widest border border-slate-200 shadow-sm" x-text="user.role"></span>
                            </td>
                            <td class="px-6 py-6 text-center font-mono text-[10px] font-black text-slate-400 uppercase tracking-widest" x-text="'UID-' + user.id.toString().padStart(4, '0')"></td>
                            <td class="px-6 py-6 text-center">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest" x-text="new Date(user.created_at).toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' })"></span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a :href="'<?= $base_url ?>/admin/users/show/' + user.id" 
                                        class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" 
                                        title="View Profile">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a :href="'<?= $base_url ?>/admin/users/edit/' + user.id" 
                                        class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" 
                                        title="Modify Permissions">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <button @click="archiveTargetId = user.id; showArchiveConfirm = true" 
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" 
                                        title="Archive User">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
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
                x-text="'Showing ' + ((currentPage - 1) * itemsPerPage + (paginatedUsers.length > 0 ? 1 : 0)) + ' to ' + ((currentPage - 1) * itemsPerPage + paginatedUsers.length) + ' of ' + filteredUsers.length + ' entries'"></span>

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

                <div class="w-20 h-20 bg-rose-50 text-rose-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-inner">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>

                <h3 class="text-2xl font-black text-slate-900 mb-2 italic">Archive Identity?</h3>
                <p class="text-sm font-medium text-slate-500 mb-8 leading-relaxed px-2">This identity will be restricted from system access and moved to the archives vault.</p>

                <div class="flex flex-col gap-3">
                    <form :action="'<?= $base_url ?>/admin/users/archive/' + archiveTargetId" method="POST">
                        <button type="submit" class="w-full py-4 bg-rose-600 text-white rounded-2xl font-bold hover:bg-rose-700 shadow-xl shadow-rose-600/30 transition-all active:scale-95 duration-200">
                            Yes, Archive It
                        </button>
                    </form>
                    <button @click="showArchiveConfirm = false" class="w-full py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition-all">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
