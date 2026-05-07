<?php $title = 'Submit Incident Report' ?>

<div class="max-w-4xl mx-auto">
    <!-- Top Bar -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                <a href="<?= $base_url ?>/admin/inventory" class="hover:text-indigo-600 transition-colors">Inventory</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
                <a href="<?= $base_url ?>/admin/inventory/show/<?= $item['id'] ?>" class="hover:text-indigo-600 transition-colors">Asset Details</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-slate-300">Incident Logging</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic">Submit Incident Report</h1>
            <p class="text-slate-500 font-medium mt-1">Provide detailed diagnostics for node <span class="text-rose-600 font-black">#<?= htmlspecialchars($item['tag']) ?></span></p>
        </div>
        
        <a href="<?= $base_url ?>/admin/inventory/show/<?= $item['id'] ?>" 
           class="bg-white border-2 border-slate-100 text-slate-600 hover:bg-slate-50 hover:border-slate-200 px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Cancel
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Asset Preview Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-slate-100 flex flex-col items-center group">
                <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-600 mb-8 self-start flex items-center gap-3">
                    <span class="w-8 h-[2px] bg-indigo-600 rounded-full"></span>
                    Asset Reference
                </h3>

                <div class="w-full space-y-4">
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Asset Name</p>
                        <p class="text-sm font-black text-slate-800 italic"><?= htmlspecialchars($item['name']) ?></p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tracking Tag</p>
                        <p class="text-sm font-mono font-bold text-slate-600"><?= htmlspecialchars($item['tag']) ?></p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Current Location</p>
                        <p class="text-sm font-bold text-slate-700"><?= htmlspecialchars($item['location']) ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-rose-600 p-8 rounded-[3rem] shadow-xl shadow-rose-600/20 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-8 -mt-8"></div>
                <h4 class="text-sm font-black uppercase tracking-widest mb-4 italic">Important Notice</h4>
                <p class="text-xs font-medium text-rose-50 leading-relaxed">Submitting this report as <span class="font-black">Administrator</span> will mark the asset as <span class="font-black underline">Damaged</span> immediately.</p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="lg:col-span-2">
            <div class="bg-white p-8 md:p-10 rounded-[3rem] shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-rose-50/30 rounded-full -mr-16 -mt-16"></div>
                
                <form action="<?= $base_url ?>/admin/report/store" method="POST" class="space-y-8">
                    <input type="hidden" name="asset_id" value="<?= $item['id'] ?>">
                    
                    <div class="space-y-4">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Issue Headline</label>
                        <input type="text" name="title" required 
                            placeholder="e.g. Screen Flickering, Mechanical Noise, Connectivity Issues..." 
                            class="w-full px-8 py-5 bg-slate-50 border-2 border-slate-100 rounded-3xl focus:border-rose-500 focus:bg-white outline-none font-bold text-slate-800 transition-all text-lg italic shadow-inner">
                    </div>

                    <div class="space-y-4">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Detailed Context & Diagnostics</label>
                        <textarea name="description" rows="6" required 
                            placeholder="Please provide as much detail as possible about the malfunction..."
                            class="w-full px-8 py-6 bg-slate-50 border-2 border-slate-100 rounded-[2.5rem] focus:border-rose-500 focus:bg-white outline-none font-medium text-slate-700 transition-all resize-none shadow-inner leading-relaxed"></textarea>
                    </div>

                    <div class="pt-4 flex flex-col md:flex-row gap-4">
                        <button type="submit" 
                            class="flex-1 py-5 bg-rose-600 text-white rounded-[2rem] font-black text-xs uppercase tracking-widest hover:bg-rose-700 shadow-2xl shadow-rose-600/40 transition-all flex items-center justify-center gap-3 active:scale-95 group">
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                            </svg>
                            Submit Diagnostic Log
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
