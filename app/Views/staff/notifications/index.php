<?php $title = 'System Notifications' ?>

<div class="max-w-4xl mx-auto space-y-8" x-data="{ 
    currentPage: 1, 
    perPage: 5, 
    totalItems: <?= count($notifications) ?>,
    get totalPages() { return Math.ceil(this.totalItems / this.perPage); }
}">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic">Notifications</h1>
            <p class="text-slate-500 font-medium mt-1">Updates and status reminders for your reported assets.</p>
        </div>
        
        <?php if (!empty($notifications)): ?>
        <form action="<?= $base_url ?>/staff/notifications/read-all" method="POST">
            <button type="submit" 
                class="bg-white border-2 border-slate-100 text-slate-600 hover:bg-slate-50 hover:border-slate-200 px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-sm active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                Mark All as Read
            </button>
        </form>
        <?php endif; ?>
    </div>

    <!-- Notifications List -->
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col">
        <?php if (empty($notifications)): ?>
            <div class="p-20 flex flex-col items-center justify-center text-center">
                <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-3xl flex items-center justify-center mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <h3 class="text-xl font-black text-slate-900 mb-2 italic">All Caught Up!</h3>
                <p class="text-sm font-medium text-slate-500 max-w-xs mx-auto">You don't have any notifications at the moment. We'll alert you when there are updates.</p>
            </div>
        <?php else: ?>
            <div class="divide-y divide-slate-50 flex-1">
                <?php foreach ($notifications as $index => $notification): ?>
                    <div x-show="Math.floor(<?= $index ?> / perPage) === currentPage - 1" 
                         class="p-8 hover:bg-slate-50/50 transition-all group relative <?= !$notification['is_read'] ? 'bg-amber-50/20' : '' ?>">
                        <div class="flex items-start gap-6">
                            <!-- Icon / Indicator -->
                            <div class="relative">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center transition-all group-hover:scale-110 <?= !$notification['is_read'] ? 'bg-amber-100 text-amber-600 shadow-lg shadow-amber-200/50' : 'bg-slate-100 text-slate-400' ?>">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <?php if (!$notification['is_read']): ?>
                                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-amber-500 border-2 border-white rounded-full"></span>
                                <?php endif; ?>
                            </div>

                            <!-- Content -->
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-lg font-black text-slate-900 group-hover:text-amber-600 transition-colors italic leading-tight">
                                        <?= htmlspecialchars($notification['title']) ?>
                                    </h4>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-white px-3 py-1 rounded-full border border-slate-100">
                                        <?= date('M d, Y • h:i A', strtotime($notification['created_at'])) ?>
                                    </span>
                                </div>
                                <p class="text-slate-600 font-medium leading-relaxed">
                                    <?= htmlspecialchars($notification['message']) ?>
                                </p>
                                
                                <?php if (!$notification['is_read']): ?>
                                    <form action="<?= $base_url ?>/staff/notifications/read/<?= $notification['id'] ?>" method="POST" class="mt-4">
                                        <button type="submit" class="text-[10px] font-black uppercase tracking-[0.2em] text-amber-600 hover:text-amber-700 transition-all flex items-center gap-2">
                                            Mark as read
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination Controls -->
            <template x-if="totalPages > 1">
                <div class="p-8 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400"
                        x-text="`Notification Page ${currentPage} of ${totalPages}`"></span>
                    <div class="flex gap-3">
                        <button @click="if(currentPage > 1) currentPage--" :disabled="currentPage === 1"
                            class="px-5 py-2.5 bg-white border border-slate-200 text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm hover:bg-slate-900 hover:text-white disabled:opacity-30 disabled:hover:bg-white disabled:hover:text-slate-900">
                            Previous
                        </button>
                        <button @click="if(currentPage < totalPages) currentPage++" :disabled="currentPage === totalPages"
                            class="px-5 py-2.5 bg-white border border-slate-200 text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm hover:bg-slate-900 hover:text-white disabled:opacity-30 disabled:hover:bg-white disabled:hover:text-slate-900">
                            Next
                        </button>
                    </div>
                </div>
            </template>
        <?php endif; ?>
    </div>
</div>
