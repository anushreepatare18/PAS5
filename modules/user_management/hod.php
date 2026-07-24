<form method="POST" action="?page=profile" id="profileContainer" class="space-y-6">
    <input type="hidden" name="update_profile" value="1">
    
    <?php if (isset($_GET['success'])): ?>
    <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline font-semibold"><i class="bi bi-check-circle-fill"></i> Profile updated successfully!</span>
    </div>
    <?php endif; ?>

    <div class="glass-panel p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-xl flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-5">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-brand-600 to-indigo-600 p-1 shadow-lg relative group">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($profile['name']); ?>&background=random&color=fff" alt="Profile Photo" class="w-full h-full rounded-[12px] object-cover">
            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white font-heading view-mode-text"><?php echo htmlspecialchars($profile['name']); ?></h2>
                <input type="text" name="profile_name" class="edit-mode-input bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-1 font-bold text-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-500 outline-none w-full max-w-xs" value="<?php echo htmlspecialchars($profile['name']); ?>">
                <p class="text-sm text-brand-600 dark:text-sky-400 font-semibold mt-1"><?php echo htmlspecialchars($profile['designation']); ?> (ECE)</p>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="button" onclick="toggleProfileEditMode()" id="btnEditProfile" class="bg-brand-100 hover:bg-brand-200 text-brand-700 dark:bg-brand-900/40 dark:hover:bg-brand-800 dark:text-sky-300 px-5 py-2.5 rounded-xl font-semibold text-sm transition-all flex items-center gap-2 border border-brand-200 dark:border-brand-800">
                <i class="bi bi-pencil-square"></i> Edit Profile
            </button>
            <button type="submit" id="btnSaveProfile" class="hidden bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all flex items-center gap-2 shadow-lg shadow-emerald-500/30 cursor-pointer">
                <i class="bi bi-check2-circle"></i> Save Changes
            </button>
        </div>
    </div>

    <!-- Personal & Professional Information Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-panel p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800/80">
            <h3 class="text-lg font-bold mb-5 font-heading flex items-center gap-2 border-b border-slate-200 dark:border-slate-700 pb-3"><i class="bi bi-person-lines-fill text-brand-500"></i> Personal Information</h3>
            <div class="space-y-4">
                <?php foreach($profile['personal'] as $label => $val): ?>
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center text-sm gap-2">
                    <span class="text-slate-500 dark:text-slate-400 font-medium"><?php echo $label; ?></span>
                    <span class="view-mode-text font-semibold text-slate-800 dark:text-slate-200"><?php echo htmlspecialchars($val); ?></span>
                    <input type="text" name="personal[<?php echo $label; ?>]" class="edit-mode-input bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-1.5 text-slate-800 dark:text-slate-200 w-full sm:w-1/2 focus:ring-2 focus:ring-brand-500 outline-none" value="<?php echo htmlspecialchars($val); ?>">
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</form>

<script>
    function toggleProfileEditMode() {
        document.getElementById('profileContainer').classList.add('is-editing');
        document.getElementById('btnEditProfile').classList.add('hidden');
        document.getElementById('btnSaveProfile').classList.remove('hidden');
    }
</script>