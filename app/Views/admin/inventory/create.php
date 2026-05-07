<?php $title = 'Register Asset' ?>

<div class="max-w-5xl mx-auto" x-data="{
    createData: { name: '', asset_number: '', category_id: '', location: 'Storage', status: 'Available', model: '', serial_number: '', description: '', deployment_date: '<?= date('Y-m-d') ?>' },
    imagePreview: null
}">
    <!-- Top Bar with Breadcrumbs & Back -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                <a href="<?= $base_url ?>/admin/inventory" class="hover:text-indigo-600 transition-colors">Inventory</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-slate-300">Register New</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic">Register New Asset</h1>
            <p class="text-slate-500 font-medium mt-1">Initialize a new node into the organizational inventory system.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="<?= $base_url ?>/admin/inventory"
                class="bg-white border-2 border-slate-100 text-slate-600 hover:bg-slate-50 hover:border-slate-200 px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Cancel
            </a>
            <button form="createForm" type="submit"
                class="bg-indigo-600 text-white hover:bg-indigo-700 px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-xl shadow-indigo-600/20 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Complete Registration
            </button>
        </div>
    </div>

    <!-- Main Content Grid -->
    <form id="createForm" action="<?= $base_url ?>/admin/inventory" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column: Primary Info -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Asset Identity Section -->
            <div
                class="bg-white p-8 md:p-10 rounded-[3rem] shadow-sm border border-slate-100 relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-indigo-50/30 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-700">
                </div>

                <h3
                    class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500 mb-8 flex items-center gap-3">
                    <span class="w-8 h-[2px] bg-indigo-500 rounded-full"></span>
                    Asset Identity
                </h3>

                <div class="space-y-8">
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Display Name
                            <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" x-model="createData.name" required
                            placeholder="e.g. MacBook Pro M3"
                            class="w-full px-6 py-5 bg-slate-50/50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white outline-none font-bold text-slate-700 transition-all placeholder-slate-300">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Asset
                                Number
                                <span class="text-rose-500">*</span></label>
                            <input type="text" name="asset_number" x-model="createData.asset_number" required
                                placeholder="e.g. ASSET-2024-001"
                                class="w-full px-6 py-5 bg-slate-50/50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white outline-none font-bold text-slate-700 transition-all placeholder-slate-300">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Model /
                                Brand</label>
                            <input type="text" name="model" x-model="createData.model"
                                placeholder="e.g. Dell OptiPlex 7090"
                                class="w-full px-6 py-5 bg-slate-50/50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white outline-none font-bold text-slate-700 transition-all placeholder-slate-300">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Serial
                                Number</label>
                            <input type="text" name="serial_number" x-model="createData.serial_number"
                                placeholder="e.g. SN-123456789"
                                class="w-full px-6 py-5 bg-slate-50/50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white outline-none font-bold text-slate-700 transition-all placeholder-slate-300">
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Description
                            <span class="text-rose-500">*</span></label>
                        <textarea name="description" x-model="createData.description" required
                            placeholder="Provide a detailed description of the asset..."
                            class="w-full px-6 py-5 bg-slate-50/50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white outline-none font-bold text-slate-700 transition-all placeholder-slate-300 min-h-[120px] resize-none"></textarea>
                    </div>
                </div>
            </div>





            <!-- Lifecycle Section -->
            <div class="bg-white p-8 md:p-10 rounded-[3rem] shadow-sm border border-slate-100">
                <h3
                    class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500 mb-8 flex items-center gap-3">
                    <span class="w-8 h-[2px] bg-indigo-500 rounded-full"></span>
                    Asset Lifecycle
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Date of
                            Deployment</label>
                        <input type="date" name="deployment_date" x-model="createData.deployment_date"
                            class="w-full px-6 py-5 bg-slate-50/50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white outline-none font-bold text-slate-700 transition-all uppercase text-sm">
                    </div>
                    <div class="flex items-center">
                        <div
                            class="p-4 bg-indigo-50/50 border-2 border-indigo-100/50 rounded-2xl flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-[9px] font-bold text-indigo-700 uppercase tracking-tight leading-relaxed">
                                System will automatically generate a unique Tracking Tag and QR Code upon registration.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Classification & Status -->
        <div class="space-y-8">
            <!-- Assignment Card -->
            <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-slate-100">
                <h3
                    class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500 mb-8 flex items-center gap-3">
                    <span class="w-8 h-[2px] bg-indigo-500 rounded-full"></span>
                    Assignment
                </h3>

                <div class="space-y-6">
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Category
                            <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select name="category_id" x-model="createData.category_id" required
                                class="w-full px-6 py-5 bg-slate-50/50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-bold text-slate-900 appearance-none cursor-pointer transition-all">
                                <option value="" disabled hidden>Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Location
                            <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select name="location" x-model="createData.location" required
                                class="w-full px-6 py-5 bg-slate-50/50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-bold text-slate-900 appearance-none cursor-pointer transition-all">
                                <option value="" disabled hidden>Select Room</option>
                                <?php foreach ($rooms as $room): ?>
                                    <option value="<?= $room['name'] ?>"
                                        x-show="<?= $room['name'] === 'Storage' ? "createData.status !== 'In Use'" : 'true' ?>">
                                        <?= $room['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Health/Status Card -->
            <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-slate-100">
                <h3
                    class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500 mb-8 flex items-center gap-3">
                    <span class="w-8 h-[2px] bg-indigo-500 rounded-full"></span>
                    Initial State
                </h3>

                <div class="grid grid-cols-1 gap-3">
                    <template x-for="st in ['Available', 'In Use', 'Damaged', 'Under Repair']">
                        <label class="cursor-pointer group">
                            <input type="radio" name="status" :value="st" x-model="createData.status"
                                class="hidden peer">
                            <div
                                class="flex items-center justify-between px-6 py-4 rounded-2xl bg-slate-50/50 border-2 border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-400 peer-checked:bg-indigo-600 peer-checked:border-indigo-600 peer-checked:text-white transition-all duration-300">
                                <span x-text="st"></span>
                                <div
                                    class="w-4 h-4 rounded-full border-2 border-slate-200 flex items-center justify-center peer-checked:border-white transition-all">
                                    <div class="w-2 h-2 rounded-full bg-white scale-0 transition-transform duration-300"
                                        :class="createData.status === st ? 'scale-100' : ''"></div>
                                </div>
                            </div>
                        </label>
                    </template>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        // Reactive logic for syncing location and status
        $watch('createData.status', (val) => {
            if (val === 'Available') createData.location = 'Storage';
        });
        $watch('createData.location', (val) => {
            if (val !== 'Storage' && createData.status === 'Available') createData.status = 'In Use';
        });
    });
</script>