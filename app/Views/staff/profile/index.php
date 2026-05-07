<?php $title = 'My Profile' ?>

<?php
// Fetch fresh user data from DB to populate the form
$userModel = new \App\Models\User();
$user = $userModel->find($_SESSION['user_id']);
?>

<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight italic">Account Settings</h1>
            <p class="text-slate-500 mt-1">Manage your personal information and security credentials.</p>
        </div>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            <span class="text-sm font-bold uppercase tracking-widest">Profile updated successfully!</span>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Sidebar / Avatar -->
        <div class="md:col-span-1 space-y-6">
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm flex flex-col items-center text-center">
                <div class="w-32 h-32 rounded-full overflow-hidden bg-gradient-to-tr from-amber-500 to-orange-500 flex items-center justify-center text-white text-4xl font-black shadow-2xl shadow-amber-200">
                    <?php if (!empty($user['profile_image'])): ?>
                        <img src="<?= $base_url ?>/uploads/profiles/<?= $user['profile_image'] ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                    <?php endif; ?>
                </div>
                <div class="mt-6">
                    <h2 class="text-xl font-black text-slate-900 italic"><?= htmlspecialchars($user['name']) ?></h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-1"><?= htmlspecialchars($user['role']) ?></p>
                </div>
                <div class="mt-8 pt-8 border-t border-slate-50 w-full">
                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-4">Account Integrity</p>
                    <div class="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-100">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="text-[10px] font-black uppercase">Verified Node</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="md:col-span-2">
            <form action="<?= $base_url ?>/staff/profile/update" method="POST" enctype="multipart/form-data" class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm space-y-8">

                <div class="space-y-6">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-[0.2em] border-l-4 border-amber-500 pl-4">Personal Identification</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none font-bold text-slate-800 transition-all">
                        </div>
                        <div class="space-y-2 opacity-60 cursor-not-allowed">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address (System ID)</label>
                            <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-400 outline-none">
                        </div>
                    </div>
                </div>

                <div class="space-y-6 pt-4">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-[0.2em] border-l-4 border-orange-500 pl-4">Security Configuration</h3>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">New Password (Leave blank to keep current)</label>
                        <input type="password" name="password" placeholder="••••••••"
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none font-bold text-slate-800 transition-all">
                    </div>
                </div>

                <div class="space-y-6 pt-4">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-[0.2em] border-l-4 border-yellow-500 pl-4">Visual Identity</h3>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Upload Profile Picture</label>
                        <input type="file" name="profile_image" accept="image/*"
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-600 outline-none file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-amber-500 file:text-white hover:file:bg-amber-600 transition-all">
                        <p class="text-[10px] text-slate-400 italic mt-2 ml-1">Supported formats: JPG, PNG, WEBP. Max 2MB.</p>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-50">
                    <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[2rem] font-black uppercase tracking-[0.3em] hover:bg-black hover:shadow-2xl hover:shadow-slate-300 transition-all active:scale-[0.98] duration-200">
                        Synchronize Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
