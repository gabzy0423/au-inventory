<?php $title = 'Staff Dashboard' ?>

<div class="space-y-8">
    <!-- Welcome Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight italic">Operations Hub</h1>
            <p class="text-slate-500 mt-1">Real-time inventory status and maintenance tracking.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?= $base_url ?>/staff/qrscanner" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-bold shadow-xl shadow-indigo-600/20 transition-all flex items-center gap-2 group">
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                Launch Scanner
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
                <span class="text-[10px] font-black text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full uppercase tracking-widest">Global</span>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-[0.15em]">Active Inventory</p>
            <p class="text-2xl font-black text-slate-900 tracking-tight italic mt-1"><?= number_format($stats['total_assets']) ?> <span class="text-sm font-bold text-slate-300 not-italic">Nodes</span></p>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="text-[10px] font-black text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full uppercase tracking-widest">Ready</span>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-[0.15em]">Available</p>
            <p class="text-2xl font-black text-slate-900 tracking-tight italic mt-1"><?= $stats['available'] ?> <span class="text-sm font-bold text-slate-300 not-italic">Nodes</span></p>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <span class="text-[10px] font-black text-rose-600 bg-rose-50 px-3 py-1 rounded-full uppercase tracking-widest">Alert</span>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-[0.15em]">Reported Issues</p>
            <p class="text-2xl font-black text-slate-900 tracking-tight italic mt-1"><?= $stats['damaged'] ?> <span class="text-sm font-bold text-slate-300 not-italic">Nodes</span></p>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <span class="text-[10px] font-black text-amber-600 bg-amber-50 px-3 py-1 rounded-full uppercase tracking-widest">Active</span>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-[0.15em]">Under Repair</p>
            <p class="text-2xl font-black text-slate-900 tracking-tight italic mt-1"><?= $stats['under_repair'] ?> <span class="text-sm font-bold text-slate-300 not-italic">Nodes</span></p>
        </div>
    </div>

    <!-- Visualizations -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm">
            <h3 class="text-sm font-black text-slate-900 italic uppercase tracking-widest mb-6 border-l-4 border-indigo-600 pl-4">Category Distribution</h3>
            <div class="relative h-64">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm">
            <h3 class="text-sm font-black text-slate-900 italic uppercase tracking-widest mb-6 border-l-4 border-emerald-600 pl-4">Location Overview</h3>
            <div class="relative h-64">
                <canvas id="locationChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bottom Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Maintenance Tasks -->
        <div class="lg:col-span-2 bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col"
             x-data="{ 
                allTasks: <?= htmlspecialchars(json_encode($maintenance_tasks), ENT_QUOTES, 'UTF-8') ?>,
                currentPage: 1,
                itemsPerPage: 5,
                get totalPages() { return Math.ceil(this.allTasks.length / this.itemsPerPage) || 1; },
                get paginatedTasks() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.allTasks.slice(start, start + this.itemsPerPage);
                }
             }">
            <div class="p-8 border-b border-slate-50 bg-slate-50/50">
                <h3 class="text-xl font-black text-slate-900 italic">Maintenance Alerts</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Pending repairs and reported issues</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Asset Node</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Reported Issue</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <template x-for="task in paginatedTasks" :key="task.id">
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-800 tracking-tight leading-none" x-text="task.asset_name"></span>
                                            <span class="text-[10px] text-slate-400 mt-1 uppercase font-bold tracking-widest" x-text="task.asset_tag"></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-slate-500 font-medium" x-text="task.title"></span>
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <span class="px-3 py-1 text-[10px] font-black rounded-full uppercase tracking-widest"
                                          :class="{
                                              'text-rose-500 bg-rose-50': task.status === 'Pending',
                                              'text-emerald-500 bg-emerald-50': task.status === 'Approved',
                                              'text-amber-500 bg-amber-50': task.status === 'Under Repair',
                                              'text-emerald-600 bg-emerald-50': task.status === 'Fixed',
                                              'text-slate-900 bg-slate-100': task.status === 'Resolved'
                                          }"
                                          x-text="task.status"></span>
                                </td>
                            </tr>
                        </template>
                        <template x-if="allTasks.length === 0">
                            <tr>
                                <td colspan="3" class="px-8 py-12 text-center text-slate-400 italic font-medium">No active maintenance tasks reported.</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Dashboard Pagination -->
            <div x-show="totalPages > 1" class="p-6 bg-slate-50/50 border-t border-slate-50 flex items-center justify-between">
                <div class="flex items-center gap-1">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest" x-text="'Page ' + currentPage + ' of ' + totalPages"></span>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="if(currentPage > 1) currentPage--" :disabled="currentPage === 1"
                            class="p-2 bg-white border border-slate-200 rounded-lg shadow-sm disabled:opacity-30 hover:bg-slate-50 transition-colors">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="if(currentPage < totalPages) currentPage++" :disabled="currentPage === totalPages"
                            class="p-2 bg-white border border-slate-200 rounded-lg shadow-sm disabled:opacity-30 hover:bg-slate-50 transition-colors">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Activity Feed -->
        <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <div class="p-8 border-b border-slate-50 bg-slate-50/50">
                <h3 class="text-xl font-black text-slate-900 italic">Recent Activity</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Your latest system interactions</p>
            </div>
            <div class="p-8 flex-1 space-y-8">
                <?php foreach ($recent_activity as $act): ?>
                <div class="flex gap-5 relative">
                    <div class="relative z-10 w-10 h-10 rounded-2xl 
                        <?= $act['type'] == 'scan' ? 'bg-indigo-50 text-indigo-600' : '' ?>
                        <?= $act['type'] == 'report' ? 'bg-rose-50 text-rose-600' : '' ?>
                        <?= $act['type'] == 'maintenance' ? 'bg-emerald-50 text-emerald-600' : '' ?>
                        flex items-center justify-center flex-shrink-0 shadow-sm">
                        
                        <?php if ($act['type'] == 'scan'): ?>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                        <?php elseif ($act['type'] == 'report'): ?>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        <?php else: ?>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <?php endif; ?>
                    </div>
                    <?php if (next($recent_activity)): ?>
                        <div class="absolute top-10 bottom-[-32px] left-[19px] w-0.5 bg-slate-50"></div>
                    <?php endif; ?>
                    <div class="flex flex-col">
                        <p class="text-sm font-black text-slate-800 tracking-tight italic"><?= $act['title'] ?></p>
                        <p class="text-xs text-slate-500 font-medium mt-0.5"><?= $act['desc'] ?></p>
                        <span class="text-[9px] text-slate-300 font-black uppercase tracking-widest mt-1"><?= $act['time'] ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Chart.defaults.font.family = 'Outfit';
    Chart.defaults.font.weight = 'bold';
    
    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categories = <?= json_encode(array_column($categories, 'name')) ?>;
    const counts = <?= json_encode(array_column($categories, 'item_count')) ?>;
    
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: categories,
            datasets: [{
                label: 'Nodes',
                data: counts,
                backgroundColor: 'rgba(99, 102, 241, 0.8)',
                borderRadius: 12,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { display: false }, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

    // Location Chart
    const locationCtx = document.getElementById('locationChart').getContext('2d');
    const locations = <?= json_encode(array_column($locations, 'location')) ?>;
    const locationCounts = <?= json_encode(array_column($locations, 'count')) ?>;

    new Chart(locationCtx, {
        type: 'doughnut',
        data: {
            labels: locations,
            datasets: [{
                data: locationCounts,
                backgroundColor: [
                    '#6366f1', '#10b981', '#f59e0b', '#f43f5e', '#8b5cf6', 
                    '#ec4899', '#06b6d4', '#f97316'
                ],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { size: 10, weight: '900' } } }
            },
            cutout: '75%'
        }
    });
});
</script>
