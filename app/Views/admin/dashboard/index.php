<?php $title = 'Dashboard' ?>

<div class="space-y-8" x-data="{
    // Pagination for Recent Assets
    recentAssets: <?= htmlspecialchars(json_encode($recent_assets), ENT_QUOTES, 'UTF-8') ?>,
    currentPage: 1,
    perPage: 5,
    get totalPages() { return Math.ceil(this.recentAssets.length / this.perPage); },
    get paginatedAssets() {
        const start = (this.currentPage - 1) * this.perPage;
        return this.recentAssets.slice(start, start + this.perPage);
    }
}">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight italic">Overview Dashboard</h1>
            <p class="text-slate-500 mt-1 text-sm sm:text-base">Welcome back. Here's what's happening with your inventory today.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Total Assets -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
                <span class="text-[10px] font-black text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full uppercase tracking-widest">Active</span>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-[0.15em]">Total Assets</p>
            <p class="text-2xl font-black text-slate-900 tracking-tight italic mt-1"><?= number_format($stats['total_assets']) ?> <span class="text-sm font-bold text-slate-300 not-italic">Nodes</span></p>
        </div>

        <!-- Under Repair -->
        <a href="<?= $base_url ?>/admin/maintenance" class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <span class="text-[10px] font-black text-amber-600 bg-amber-50 px-3 py-1 rounded-full uppercase tracking-widest">Under Repair</span>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-[0.15em]">Maintenance</p>
            <p class="text-2xl font-black text-slate-900 tracking-tight italic mt-1"><?= $stats['under_repair'] ?> <span class="text-sm font-bold text-slate-300 not-italic">Nodes</span></p>
        </a>

        <!-- Damaged -->
        <a href="<?= $base_url ?>/admin/maintenance" class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <span class="text-[10px] font-black text-rose-600 bg-rose-50 px-3 py-1 rounded-full uppercase tracking-widest">Urgent</span>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-[0.15em]">Damaged</p>
            <p class="text-2xl font-black text-slate-900 tracking-tight italic mt-1"><?= $stats['damaged'] ?> <span class="text-sm font-bold text-slate-300 not-italic">Nodes</span></p>
        </a>

        <!-- Available -->
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
    </div>

    <!-- Data Visualizations -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        <div class="bg-white p-6 sm:p-8 rounded-[2.5rem] sm:rounded-[3rem] border border-slate-100 shadow-sm">
            <h3 class="text-sm font-black text-slate-900 italic uppercase tracking-widest mb-6 border-l-4 border-indigo-600 pl-4">Asset Distribution</h3>
            <div class="relative h-56 sm:h-64">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
        <div class="bg-white p-6 sm:p-8 rounded-[2.5rem] sm:rounded-[3rem] border border-slate-100 shadow-sm">
            <h3 class="text-sm font-black text-slate-900 italic uppercase tracking-widest mb-6 border-l-4 border-emerald-600 pl-4">Category Metrics</h3>
            <div class="relative h-56 sm:h-64">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
        <div class="bg-white p-6 sm:p-8 rounded-[2.5rem] sm:rounded-[3rem] border border-slate-100 shadow-sm">
            <h3 class="text-sm font-black text-slate-900 italic uppercase tracking-widest mb-6 border-l-4 border-amber-600 pl-4">Location Density</h3>
            <div class="relative h-56 sm:h-64">
                <canvas id="locationChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tables & Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        <!-- Recently Added Assets -->
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] sm:rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 sm:p-8 border-b border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
                <div>
                    <h3 class="text-xl font-black text-slate-900 italic">Recent Registrations</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Latest nodes added to inventory</p>
                </div>
                <div class="flex items-center justify-between sm:justify-end gap-3">
                    <!-- Pagination Controls -->
                    <div class="flex items-center gap-1 bg-white border border-slate-200 rounded-xl px-2 py-1 shadow-sm" x-show="totalPages > 1">
                        <button @click="if(currentPage > 1) currentPage--" :class="currentPage === 1 ? 'opacity-30 cursor-not-allowed' : 'hover:text-indigo-600'" class="p-1 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <span class="text-[10px] font-black text-slate-400 px-2" x-text="currentPage + ' / ' + totalPages"></span>
                        <button @click="if(currentPage < totalPages) currentPage++" :class="currentPage === totalPages ? 'opacity-30 cursor-not-allowed' : 'hover:text-indigo-600'" class="p-1 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                    <a href="<?= $base_url ?>/admin/inventory" class="px-4 py-2 bg-white border border-slate-200 text-[10px] font-black text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition-all uppercase tracking-widest shadow-sm">Master List</a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[600px] sm:min-w-0">
                    <thead>
                        <tr>
                            <th class="px-6 sm:px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Asset Node</th>
                            <th class="px-4 sm:px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Category</th>
                            <th class="px-4 sm:px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 sm:px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Registered</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <template x-if="recentAssets.length === 0">
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center text-slate-400 italic font-medium">No active nodes detected in current session.</td>
                            </tr>
                        </template>
                        <template x-for="asset in paginatedAssets" :key="asset.id">
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 sm:px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-800 tracking-tight leading-none" x-text="asset.name"></span>
                                            <span class="text-[10px] text-slate-400 mt-1 uppercase font-bold tracking-widest" x-text="asset.tag"></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-4">
                                    <span class="px-2.5 py-1 bg-slate-50 text-slate-500 text-[10px] font-black rounded-lg uppercase tracking-wider" x-text="asset.category_name || 'General'"></span>
                                </td>
                                <td class="px-4 sm:px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full" :class="{
                                            'bg-green-500': asset.status === 'Available',
                                            'bg-blue-500': asset.status === 'In Use',
                                            'bg-rose-500': asset.status === 'Damaged',
                                            'bg-emerald-500': asset.status === 'Approved',
                                            'bg-amber-500': asset.status === 'Under Repair'
                                        }"></div>
                                        <span class="text-[10px] font-black uppercase tracking-widest" :class="{
                                            'text-green-500': asset.status === 'Available',
                                            'text-blue-500': asset.status === 'In Use',
                                            'text-rose-500': asset.status === 'Damaged',
                                            'text-emerald-500': asset.status === 'Approved',
                                            'text-amber-500': asset.status === 'Under Repair'
                                        }" x-text="asset.status"></span>
                                    </div>
                                </td>
                                <td class="px-6 sm:px-8 py-4 text-right">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest" x-text="new Date(asset.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })"></span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- System Activity Feed -->
        <div class="bg-white rounded-[2.5rem] sm:rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 sm:p-8 border-b border-slate-50 bg-slate-50/50">
                <h3 class="text-xl font-black text-slate-900 italic">Global Activity</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Live tracking and updates</p>
            </div>
            <div class="p-6 sm:p-8 flex-1 space-y-8">
                <?php foreach ($recent_activity as $act): ?>
                <div class="flex gap-5 relative">
                    <div class="relative z-10 w-10 h-10 rounded-2xl 
                        <?= $act['type'] == 'registration' ? 'bg-indigo-50 text-indigo-600' : '' ?>
                        <?= $act['type'] == 'qr' ? 'bg-amber-50 text-amber-600' : '' ?>
                        <?= $act['type'] == 'issue' ? 'bg-rose-50 text-rose-600' : '' ?>
                        <?= $act['type'] == 'maintenance' ? 'bg-emerald-50 text-emerald-600' : '' ?>
                        flex items-center justify-center flex-shrink-0 shadow-sm">
                        
                        <?php if ($act['type'] == 'registration'): ?>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        <?php elseif ($act['type'] == 'qr'): ?>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                        <?php elseif ($act['type'] == 'issue'): ?>
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
    
    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Available', 'In Use', 'Under Repair', 'Damaged', 'Approved'],
            datasets: [{
                data: [
                    <?= $stats['available'] ?? 0 ?>, 
                    <?= $stats['in_use'] ?? 0 ?>, 
                    <?= $stats['under_repair'] ?? 0 ?>, 
                    <?= $stats['damaged'] ?? 0 ?>,
                    <?= $stats['approved'] ?? 0 ?>
                ],
                backgroundColor: ['#22c55e', '#3b82f6', '#f59e0b', '#f43f5e', '#10b981'],
                borderWidth: 0,
                hoverOffset: 20
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
        type: 'pie',
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
            }
        }
    });
});
</script>
