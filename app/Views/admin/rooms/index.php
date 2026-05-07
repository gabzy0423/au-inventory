<?php $title = 'Rooms & Locations' ?>

<div class="space-y-8" x-data="{ 
    showCreateModal: false,
    showArchiveModal: false,
    showArchiveConfirm: false,
    archiveTargetId: null,
    archivedRooms: [],
    loadingArchive: false,

    async fetchArchivedRooms() {
        this.loadingArchive = true;
        this.showArchiveModal = true;
        try {
            const response = await fetch('/au_inventory/public/admin/rooms/archived-api');
            this.archivedRooms = await response.json();
        } catch (error) {
            console.error('Error fetching archived rooms:', error);
        } finally {
            this.loadingArchive = false;
        }
    },

    showAssetsModal: false,
    roomAssets: [],
    loadingAssets: false,
    selectedRoomName: '',

    async fetchRoomAssets(id, name) {
        this.selectedRoomName = name;
        this.loadingAssets = true;
        this.showAssetsModal = true;
        try {
            const response = await fetch('/au_inventory/public/admin/rooms/assets/' + id);
            this.roomAssets = await response.json();
        } catch (error) {
            console.error('Error fetching room assets:', error);
        } finally {
            this.loadingAssets = false;
        }
    }
}">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight italic">Rooms & Locations</h1>
            <p class="text-slate-500 mt-1">Manage physical spaces and track asset distribution across the campus.</p>
        </div>
    </div>
    <!-- Rooms Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php foreach ($rooms as $room): 
            $color = $room['color'] ?? 'indigo';
        ?>
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-start justify-between mb-6">
                <div class="p-4 bg-<?= $color ?>-50 text-<?= $color ?>-600 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="flex gap-1">
                    <a href="<?= $base_url ?>/admin/rooms/edit/<?= $room['id'] ?>" class="p-1.5 text-slate-300 hover:text-indigo-600 transition-colors" title="Edit Room">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </a>
                    <button @click="archiveTargetId = <?= $room['id'] ?>; showArchiveConfirm = true" class="p-1.5 text-slate-300 hover:text-rose-600 transition-colors" title="Archive Room">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                    </button>
                </div>
            </div>
            
            <h3 class="text-xl font-black text-slate-800 mb-1 italic"><?= htmlspecialchars($room['name']) ?></h3>
            <div class="flex items-center gap-2 mb-4">
                <span class="text-2xl font-black text-slate-900"><?= $room['item_count'] ?></span>
                <div class="flex flex-col">
                    <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest leading-none">items</span>
                    <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest leading-none">registered</span>
                </div>
            </div>

            <p class="text-sm text-slate-500 line-clamp-2 h-10 italic"><?= htmlspecialchars($room['description'] ?: 'No description provided.') ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- ARCHIVE CONFIRMATION MODAL -->
    <template x-teleport="body">
        <div x-show="showArchiveConfirm" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
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

                <h3 class="text-2xl font-black text-slate-900 mb-2 italic">Archive Room?</h3>
                <p class="text-sm font-medium text-slate-500 mb-8 leading-relaxed">This room and all assets inside will be moved to the vault.</p>

                <div class="flex flex-col gap-3">
                    <form :action="'<?= $base_url ?>/admin/rooms/archive/' + archiveTargetId" method="POST">
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

    <!-- ROOM ASSETS MODAL -->
    <template x-teleport="body">
        <div x-show="showAssetsModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            
            <div @click.away="showAssetsModal = false" 
                 class="bg-white w-full max-w-4xl rounded-[2.5rem] shadow-2xl relative overflow-hidden flex flex-col max-h-[85vh]">
                
                <!-- Loading State -->
                <div x-show="loadingAssets" class="absolute inset-0 bg-white/80 backdrop-blur-sm z-50 flex items-center justify-center">
                    <div class="w-10 h-10 border-4 border-indigo-600/20 border-t-indigo-600 rounded-full animate-spin"></div>
                </div>

                <!-- Header -->
                <div class="px-8 pt-8 pb-6 border-b border-slate-50 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 font-black italic text-xl shadow-inner">
                            AU
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-slate-900 leading-tight italic" x-text="selectedRoomName"></h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest" x-text="roomAssets.length + ' Physical Assets'"></p>
                        </div>
                    </div>
                    <button @click="showAssetsModal = false" class="p-2 hover:bg-slate-100 rounded-full transition-colors text-slate-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <!-- Asset List -->
                <div class="flex-1 overflow-y-auto p-8">
                    <template x-if="roomAssets.length === 0">
                        <div class="py-20 text-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                            <h4 class="text-slate-400 font-bold italic">No assets currently assigned to this room.</h4>
                        </div>
                    </template>

                    <div x-show="roomAssets.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="asset in roomAssets" :key="asset.id">
                            <div class="p-5 bg-slate-50/50 border border-slate-100 rounded-2xl hover:bg-white hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                                <div class="flex justify-between items-start mb-3">
                                    <span class="text-[10px] font-black uppercase tracking-widest px-2.5 py-1 bg-white border border-slate-100 text-slate-400 rounded-lg" x-text="asset.tag"></span>
                                    <span :class="{
                                        'bg-emerald-50 text-emerald-600': asset.status === 'Available',
                                        'bg-rose-50 text-rose-600': asset.status === 'Damaged',
                                        'bg-amber-50 text-amber-600': asset.status === 'Under Repair'
                                    }" class="text-[8px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full" x-text="asset.status"></span>
                                </div>
                                <h4 class="font-bold text-slate-800 mb-1 group-hover:text-indigo-600 transition-colors" x-text="asset.name"></h4>
                                <div class="flex items-center gap-2 text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 7v10M7 7L3 3" /></svg>
                                    <span class="text-[10px] font-bold uppercase tracking-tight" x-text="asset.category_name || 'Uncategorized'"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex justify-end">
                    <button @click="showAssetsModal = false" class="px-8 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl font-bold hover:bg-slate-50 transition-all">Done Viewing</button>
                </div>
            </div>
        </div>
    </template>
</div>
