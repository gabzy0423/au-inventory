<?php $title = 'Update User' ?>

<div class="max-w-5xl mx-auto">
    <!-- Top Bar with Breadcrumbs & Actions -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                <a href="<?= $base_url ?>/admin/users" class="hover:text-indigo-600 transition-colors">Users</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-300">Modification</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic">Update User</h1>
            <p class="text-slate-500 font-medium mt-1">Modify account details or system permissions for <?= htmlspecialchars($user['name']) ?>.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="<?= $base_url ?>/admin/users" 
               class="bg-white border-2 border-slate-100 text-slate-600 hover:bg-slate-50 hover:border-slate-200 px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Cancel
            </a>
        </div>
    </div>

    <form action="<?= $base_url ?>/admin/users/update/<?= $user['id'] ?>" method="POST">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Main Form Content -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-8 md:p-10 rounded-[3rem] shadow-sm border border-slate-100 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50/30 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-700"></div>
                    
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500 mb-8 flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-indigo-500 rounded-full"></span>
                        Account Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Full Name</label>
                            <input type="text" name="name" required value="<?= htmlspecialchars($user['name']) ?>"
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 placeholder:text-slate-300 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Email Address</label>
                            <input type="email" name="email" required value="<?= htmlspecialchars($user['email']) ?>"
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 placeholder:text-slate-300 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">System Role</label>
                            <select name="role" class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all appearance-none cursor-pointer">
                                <option value="staff" <?= $user['role'] === 'staff' ? 'selected' : '' ?>>Staff Member</option>
                                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Administrator</option>
                            </select>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Reset Password <span class="lowercase">(Leave blank to keep)</span></label>
                            <input type="password" name="password" placeholder="••••••••"
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 placeholder:text-slate-300 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                        </div>
                    </div>

                    <div class="mt-12 pt-8 border-t border-slate-50">
                        <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-700 shadow-2xl shadow-indigo-600/30 transition-all active:scale-95 flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Save Account Changes
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right: Account Status -->
            <div class="space-y-8">
                <div class="bg-slate-900 p-8 rounded-[3rem] shadow-2xl shadow-slate-900/20 text-white relative overflow-hidden group">
                    <div class="relative z-10">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-4">Account Integrity</h4>
                        <div class="p-6 bg-white/5 rounded-3xl border border-white/5">
                            <p class="text-xs font-bold text-slate-400 leading-relaxed mb-4">This account was registered on <?= date('M d, Y', strtotime($user['created_at'] ?? 'now')) ?>.</p>
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-500">Active Node</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
