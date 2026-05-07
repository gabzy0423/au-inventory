<?php $title = 'Rooms & Facilities' ?>

<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight italic">Rooms & Facilities</h1>
            <p class="text-slate-500 mt-1">Institutional spaces and real-time equipment distribution.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-4 py-2 bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase rounded-xl border border-indigo-100 tracking-widest">
                Nodes Tracked: <?= count($rooms) ?> Rooms
            </span>
        </div>
    </div>

    <!-- Rooms Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php foreach ($rooms as $room): 
            $color = $room['color'] ?? 'indigo';
        ?>
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-start justify-between mb-8">
                <div class="p-4 bg-<?= $color ?>-50 text-<?= $color ?>-600 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            
            <h3 class="text-2xl font-black text-slate-800 mb-1 italic"><?= htmlspecialchars($room['name']) ?></h3>
            <div class="flex items-center gap-2 mb-6">
                <span class="text-3xl font-black text-slate-900"><?= $room['item_count'] ?></span>
                <div class="flex flex-col">
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">items</span>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">active</span>
                </div>
            </div>

            <p class="text-sm text-slate-500 line-clamp-2 h-10 italic leading-relaxed"><?= htmlspecialchars($room['description'] ?: 'Institutional location for organizational assets.') ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</div>
