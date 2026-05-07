<?php $title = 'User Details' ?>

<div class="max-w-5xl mx-auto space-y-8">
    <!-- Top Bar with Breadcrumbs & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                <a href="<?= $base_url ?>/admin/users" class="hover:text-indigo-600 transition-colors">Users</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-300">Identity Profile</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic"><?= htmlspecialchars($user['name']) ?></h1>
            <p class="text-slate-500 font-medium mt-1">Full system authorization and access profile.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="<?= $base_url ?>/admin/users/edit/<?= $user['id'] ?>" 
               class="bg-white border-2 border-slate-100 text-amber-600 hover:bg-amber-50 hover:border-amber-200 px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Modify Permissions
            </a>
            <a href="<?= $base_url ?>/admin/users" 
               class="bg-slate-900 text-white px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-xl shadow-slate-900/20 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Profile Card -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-40 h-40 bg-indigo-50/30 rounded-full -mr-20 -mt-20 transition-transform group-hover:scale-110 duration-700"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-8">
                    <div class="w-32 h-32 bg-indigo-600 rounded-[2.5rem] flex items-center justify-center text-white text-5xl font-black shadow-2xl shadow-indigo-600/30 italic overflow-hidden">
                        <?php if (!empty($user['profile_image'])): ?>
                            <img src="<?= $base_url ?>/uploads/profiles/<?= $user['profile_image'] ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <?= strtoupper(substr($user['name'], 0, 1)) ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="flex-1 text-center md:text-left space-y-4">
                        <div>
                            <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500 mb-1 flex items-center justify-center md:justify-start gap-3">
                                <span class="w-6 h-[2px] bg-indigo-500 rounded-full"></span>
                                Identity Details
                            </h3>
                            <h2 class="text-3xl font-black text-slate-900 italic tracking-tight"><?= htmlspecialchars($user['name']) ?></h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-50">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Email Endpoint</p>
                                <p class="font-bold text-slate-700"><?= htmlspecialchars($user['email']) ?></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">System Authorization</p>
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-lg uppercase tracking-widest border border-slate-200">
                                    <?= strtoupper($user['role']) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Access Log Summary (Placeholder) -->
            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
                <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-8 flex items-center gap-3">
                    <span class="w-8 h-[2px] bg-slate-200 rounded-full"></span>
                    Recent Activity
                </h3>
                
                <div class="space-y-6">
                    <div class="flex items-center gap-4 p-6 bg-slate-50/50 rounded-3xl border border-slate-50 border-dashed">
                        <div class="w-10 h-10 bg-white rounded-2xl flex items-center justify-center text-slate-400 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 0012 21a9.994 9.994 0 007.454-3.355c.95-.994 1.747-2.115 2.368-3.355A9.994 9.994 0 0012 1c-5.523 0-10 4.477-10 10 0 1.34.26 2.614.74 3.791l.028.066a10.002 10.002 0 001.991 3.12l.092.118m3.44-2.04a9.954 9.954 0 01-1.12-1.947m3.44 2.04L12 11V1" /></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-700">System Log Initialization</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">This user has no recorded login activity in the current session.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-8">
            <div class="bg-slate-900 p-8 rounded-[3rem] shadow-2xl shadow-slate-900/20 text-white relative overflow-hidden group">
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mb-16 transition-transform group-hover:scale-110 duration-700"></div>
                <div class="relative z-10">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-6">Security Metadata</h4>
                    <div class="space-y-6">
                        <div class="flex flex-col gap-1">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 leading-none">Access ID</span>
                            <span class="font-mono text-xl font-black italic tracking-tight text-indigo-400">UID-<?= str_pad($user['id'], 4, '0', STR_PAD_LEFT) ?></span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 leading-none">Authorized Since</span>
                            <span class="text-sm font-bold text-slate-300"><?= date('F d, Y', strtotime($user['created_at'])) ?></span>
                        </div>
                        <div class="pt-4 border-t border-white/5">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-500">Live Authorization</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-indigo-600 p-8 rounded-[3rem] shadow-2xl shadow-indigo-600/20 text-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-700"></div>
                <div class="relative z-10">
                    <h4 class="text-lg font-black italic mb-2 tracking-tight">System Node</h4>
                    <p class="text-indigo-100 text-sm font-medium leading-relaxed opacity-80">This identity is verified and holds <?= $user['role'] ?> permissions within the Asset Inventory environment.</p>
                </div>
            </div>
        </div>
    </div>
</div>
