<?php $title = 'Register New User' ?>

<div class="max-w-5xl mx-auto">
    <!-- Top Bar with Breadcrumbs & Actions -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                <a href="<?= $base_url ?>/admin/users" class="hover:text-indigo-600 transition-colors">Users</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-300">Authorize Node</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic">Register User</h1>
            <p class="text-slate-500 font-medium mt-1">Deploy a new administrative or staff member to the system.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="<?= $base_url ?>/admin/users" 
               class="bg-white border-2 border-slate-100 text-slate-600 hover:bg-slate-50 hover:border-slate-200 px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Discard
            </a>
        </div>
    </div>

    <form action="<?= $base_url ?>/admin/users" method="POST">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Main Form Content -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-8 md:p-10 rounded-[3rem] shadow-sm border border-slate-100 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50/30 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-700"></div>
                    
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500 mb-8 flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-indigo-500 rounded-full"></span>
                        Identity Details
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Full Name</label>
                            <input type="text" name="name" required placeholder="John Doe"
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 placeholder:text-slate-300 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Email Address</label>
                            <input type="email" name="email" required placeholder="john@example.com"
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 placeholder:text-slate-300 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">System Role</label>
                            <select name="role" class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all appearance-none cursor-pointer">
                                <option value="staff">Staff Member</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Access Password</label>
                            <input type="password" name="password" required placeholder="••••••••"
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 placeholder:text-slate-300 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                        </div>
                    </div>

                    <div class="mt-12 pt-8 border-t border-slate-50">
                        <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-700 shadow-2xl shadow-indigo-600/30 transition-all active:scale-95 flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Authorize & Register User
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right: Info Panel -->
            <div class="space-y-8">
                <div class="bg-indigo-600 p-8 rounded-[3rem] shadow-2xl shadow-indigo-600/20 text-white relative overflow-hidden group">
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="text-lg font-black italic mb-2 tracking-tight">Security Note</h4>
                        <p class="text-indigo-100 text-sm font-medium leading-relaxed opacity-80">All user accounts must have a unique email address. Administrators have full access to system configuration and reports.</p>
                    </div>
                </div>

                <div class="bg-slate-900 p-8 rounded-[3rem] shadow-2xl shadow-slate-900/20 text-white relative overflow-hidden group">
                    <div class="relative z-10">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-4">Registration Requirements</h4>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <div class="w-5 h-5 rounded-full bg-indigo-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                    <div class="w-1.5 h-1.5 rounded-full bg-indigo-400"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-400 leading-relaxed">Minimum 8 characters for password security.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-5 h-5 rounded-full bg-indigo-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                    <div class="w-1.5 h-1.5 rounded-full bg-indigo-400"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-400 leading-relaxed">System logs all user registration activities.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
