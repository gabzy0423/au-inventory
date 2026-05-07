<?php $title = 'Room Deployments' ?>

<div class="space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Room Deployments</h1>
            <p class="text-sm text-slate-500">Track equipment currently assigned to active laboratory sessions.</p>
        </div>
        <div class="flex gap-2">
            <span class="px-4 py-2 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-xl border border-indigo-100 italic">
                Active Deployments: <?= count($active_deployments) ?>
            </span>
        </div>
    </div>

    <!-- Usage Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <?php if (empty($active_deployments)): ?>
            <div class="col-span-full bg-white rounded-[2.5rem] border border-dashed border-slate-200 p-20 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                </div>
                <h3 class="text-slate-900 font-bold mb-1">Laboratory is Quiet</h3>
                <p class="text-slate-400 text-sm">All equipment is currently at its home location.</p>
                <a href="<?= $base_url ?>/staff/qrscanner" class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-xl text-xs font-bold hover:bg-indigo-700 transition-all">
                    Deploy Asset Now
                </a>
            </div>
        <?php else: ?>
            <?php foreach ($active_deployments as $deploy): ?>
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 hover:shadow-xl hover:shadow-indigo-500/5 transition-all group">
                <div class="flex items-center justify-between mb-6">
                    <div class="p-3 bg-indigo-600 rounded-2xl text-white group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-indigo-400 font-bold uppercase tracking-widest leading-none">Deployed to</p>
                        <p class="text-lg font-black text-slate-900"><?= $deploy['target_location'] ?></p>
                    </div>
                </div>

                <div class="space-y-4 mb-8">
                    <div>
                        <h4 class="font-bold text-slate-800"><?= $deploy['name'] ?></h4>
                        <p class="text-[10px] font-mono text-slate-400 uppercase"><?= $deploy['tag'] ?></p>
                    </div>
                    <div class="py-3 px-4 bg-slate-50 rounded-2xl border border-slate-100 italic">
                        <p class="text-[11px] text-slate-500 leading-relaxed">"<?= $deploy['purpose'] ?>"</p>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-slate-50 mb-6">
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none">Started</p>
                        <p class="text-[11px] font-bold text-slate-700 mt-1"><?= date('h:i A', strtotime($deploy['started_at'])) ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none">Home Location</p>
                        <p class="text-[11px] font-bold text-slate-700 mt-1"><?= $deploy['home_location'] ?></p>
                    </div>
                </div>

                <form action="<?= $base_url ?>/staff/usage/end/<?= $deploy['id'] ?>" method="POST">
                    <button type="submit" class="w-full py-4 bg-slate-900 hover:bg-black text-white rounded-2xl text-xs font-bold transition-all shadow-lg shadow-slate-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" /></svg>
                        Release back to home
                    </button>
                </form>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
