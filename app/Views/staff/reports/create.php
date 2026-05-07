<div class="max-w-4xl mx-auto" x-data="{
    selectedAssetId: '<?= $item['id'] ?? '' ?>',
    duplicates: [],
    showDuplicateWarning: false,
    isChecking: false,
    
    async checkDuplicates() {
        if (!this.selectedAssetId) return;
        this.isChecking = true;
        try {
            const response = await fetch(`<?= $base_url ?>/api/reports/check-duplicate?asset_id=${this.selectedAssetId}`);
            this.duplicates = await response.json();
            if (this.duplicates.length > 0) {
                this.showDuplicateWarning = true;
            }
        } catch (e) {
            console.error('Failed to check duplicates');
        } finally {
            this.isChecking = false;
        }
    }
}" x-init="if(selectedAssetId) checkDuplicates()">
    <!-- Top Bar -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                <a href="<?= $base_url ?>/staff/inventory" class="hover:text-amber-600 transition-colors">Catalog</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-slate-300">Incident Logging</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic">Submit Incident Report</h1>
            <p class="text-slate-500 font-medium mt-1">Provide detailed diagnostics for node <span
                    class="text-rose-600 font-black" x-text="selectedAssetId ? '#' + selectedAssetId : '...'"></span></p>
        </div>

        <a href="<?= $base_url ?>/staff/inventory"
            class="bg-white border-2 border-slate-100 text-slate-600 hover:bg-slate-50 hover:border-slate-200 px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Cancel
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Asset Selection & Info Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-slate-100 flex flex-col items-center group">
                <h3
                    class="text-[10px] font-black uppercase tracking-[0.2em] text-amber-600 mb-8 self-start flex items-center gap-3">
                    <span class="w-8 h-[2px] bg-amber-600 rounded-full"></span>
                    Asset Reference
                </h3>

                <div class="w-full space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Target Asset</label>
                        <select name="asset_id_selector" x-model="selectedAssetId" @change="checkDuplicates()"
                                class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-amber-500 outline-none font-bold text-slate-700 transition-all text-sm shadow-inner">
                            <option value="">Select Asset...</option>
                            <?php foreach ($assets as $asset): ?>
                                <option value="<?= $asset['id'] ?>" <?= (isset($item) && $item['id'] == $asset['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($asset['tag']) ?> - <?= htmlspecialchars($asset['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div x-show="selectedAssetId" x-transition class="space-y-4 pt-4 border-t border-slate-50">
                         <!-- Potential for asset dynamic info here -->
                         <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                             <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Status Check</p>
                             <p class="text-xs font-black text-amber-600 italic" x-text="isChecking ? 'Verifying logs...' : 'Ready for diagnostics'"></p>
                         </div>
                    </div>
                </div>
            </div>

            <div class="bg-rose-600 p-8 rounded-[3rem] shadow-xl shadow-rose-600/20 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-8 -mt-8"></div>
                <h4 class="text-sm font-black uppercase tracking-widest mb-4 italic">Important Notice</h4>
                <p class="text-xs font-medium text-rose-50 leading-relaxed">Submitting this report will mark the asset
                    as <span class="font-black underline">Damaged</span> and notify the administration for maintenance
                    protocols.</p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="lg:col-span-2">
            <div class="bg-white p-8 md:p-10 rounded-[3rem] shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-rose-50/30 rounded-full -mr-16 -mt-16"></div>

                <form action="<?= $base_url ?>/staff/report/store" method="POST" class="space-y-8">
                    <input type="hidden" name="asset_id" :value="selectedAssetId">
                    <input type="hidden" name="is_potential_duplicate" x-model="duplicates.length > 0 ? 1 : 0">

                    <div class="space-y-4">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Issue
                            Headline</label>
                        <input type="text" name="title" required
                            class="w-full px-8 py-5 bg-slate-50 border-2 border-slate-100 rounded-3xl focus:border-rose-500 focus:bg-white outline-none font-bold text-slate-800 transition-all text-lg italic shadow-inner"
                            placeholder="e.g., Audio distortion in Comlab 1">
                    </div>

                    <div class="space-y-4">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Detailed
                            Context & Diagnostics</label>
                        <textarea name="description" rows="6" required
                            class="w-full px-8 py-6 bg-slate-50 border-2 border-slate-100 rounded-[2.5rem] focus:border-rose-500 focus:bg-white outline-none font-medium text-slate-700 transition-all resize-none shadow-inner leading-relaxed"
                            placeholder="Describe the issue in detail..."></textarea>
                    </div>

                    <div class="pt-4 flex flex-col md:flex-row gap-4">
                        <button type="submit" :disabled="!selectedAssetId"
                            class="flex-1 py-5 bg-rose-600 text-white rounded-[2rem] font-black text-xs uppercase tracking-widest hover:bg-rose-700 shadow-2xl shadow-rose-600/40 transition-all flex items-center justify-center gap-3 active:scale-95 group disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                            </svg>
                            Submit Diagnostic Log
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Duplicate Warning Modal -->
    <div x-show="showDuplicateWarning" 
         class="fixed inset-0 z-[200] flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        
        <div class="bg-white w-full max-w-2xl rounded-[3rem] shadow-2xl overflow-hidden border border-slate-200">
            <div class="p-10">
                <div class="w-20 h-20 bg-amber-100 rounded-[2rem] flex items-center justify-center mb-8">
                    <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                
                <h2 class="text-3xl font-black text-slate-900 tracking-tight italic mb-4">Possible Duplicate Detected</h2>
                <p class="text-slate-500 font-medium mb-8 leading-relaxed">This asset has active reports submitted within the last 2 hours. It may have already been reported by another staff member.</p>
                
                <div class="space-y-4 mb-10">
                    <template x-for="duplicate in duplicates" :key="duplicate.id">
                        <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-black text-slate-800" x-text="duplicate.title"></p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1" x-text="'By ' + duplicate.reported_by + ' • ' + duplicate.reported_at"></p>
                            </div>
                            <span class="px-3 py-1 bg-amber-50 text-amber-600 text-[10px] font-black uppercase rounded-lg border border-amber-100 shadow-sm" x-text="duplicate.status"></span>
                        </div>
                    </template>
                </div>
                
                <div class="flex flex-col md:flex-row gap-4">
                    <button @click="showDuplicateWarning = false" 
                            class="flex-1 py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-slate-200">
                        Continue Anyway
                    </button>
                    <a href="<?= $base_url ?>/staff/reports" 
                       class="flex-1 py-4 bg-white border-2 border-slate-100 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-50 text-center transition-all">
                        View Existing Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>