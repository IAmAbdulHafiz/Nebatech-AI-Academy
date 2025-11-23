<?php
$title = 'My Profile';
ob_start();
// Dynamically load sidebar based on user role
$sidebarFile = match($user['role']) {
    'admin' => 'admin-sidebar.php',
    'facilitator' => 'facilitator-sidebar.php',
    default => 'student-sidebar.php'
};
include __DIR__ . '/../partials/' . $sidebarFile;
$sidebarContent = ob_get_clean();
ob_start();
?>

<div x-data="profileManager()">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Profile</h1>
        <p class="text-gray-600">Manage your personal information and public profile</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-6">
                <!-- Avatar -->
                <div class="text-center mb-6">
                    <div class="relative inline-block">
                        <div class="w-32 h-32 rounded-full overflow-hidden bg-gradient-to-br from-primary to-blue-700 flex items-center justify-center text-white text-4xl font-bold mx-auto mb-4" id="avatarContainer">
                            <?php if (!empty($user['avatar'])): ?>
                                <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar" class="w-full h-full object-cover" id="avatarPreview">
                            <?php else: ?>
                                <span id="avatarInitials"><?= strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)) ?></span>
                            <?php endif; ?>
                        </div>
                        <button @click="$refs.avatarInput.click()" class="absolute bottom-2 right-2 w-10 h-10 bg-primary text-white rounded-full hover:bg-blue-700 transition shadow-lg">
                            <i class="fas fa-camera"></i>
                        </button>
                        <input type="file" x-ref="avatarInput" @change="uploadAvatar" accept="image/*" class="hidden">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h3>
                    <p class="text-gray-600 mb-2"><?= htmlspecialchars($user['email']) ?></p>
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                        <?= ucfirst($user['role']) ?>
                    </span>
                </div>

                <!-- Quick Stats -->
                <div class="border-t border-gray-200 pt-4">
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600"><i class="fas fa-calendar mr-2"></i>Joined</span>
                            <span class="font-medium text-gray-900"><?= date('M Y', strtotime($user['created_at'])) ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600"><i class="fas fa-check-circle mr-2"></i>Status</span>
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium"><?= ucfirst($user['status']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="lg:col-span-2">
            <form @submit.prevent="updateProfile" class="space-y-6">
                <!-- Personal Information -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Personal Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                            <input type="text" x-model="formData.first_name" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                            <input type="text" x-model="formData.last_name" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                        <input type="tel" x-model="formData.phone"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <input type="text" x-model="formData.location" placeholder="City, Country"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                        <textarea x-model="formData.bio" rows="4" placeholder="Tell us about yourself..."
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        <p class="text-sm text-gray-500 mt-1">Brief description for your profile. Max 500 characters.</p>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Social Links</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-globe text-gray-400 mr-2"></i>Website
                            </label>
                            <input type="url" x-model="formData.website" placeholder="https://yourwebsite.com"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fab fa-github text-gray-400 mr-2"></i>GitHub
                            </label>
                            <input type="text" x-model="formData.github" placeholder="username"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fab fa-linkedin text-gray-400 mr-2"></i>LinkedIn
                            </label>
                            <input type="text" x-model="formData.linkedin" placeholder="username"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fab fa-twitter text-gray-400 mr-2"></i>Twitter
                            </label>
                            <input type="text" x-model="formData.twitter" placeholder="@username"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex gap-4">
                    <button type="submit" :disabled="saving"
                            class="flex-1 px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas" :class="saving ? 'fa-spinner fa-spin' : 'fa-save'" x-show="!saving"></i>
                        <i class="fas fa-spinner fa-spin" x-show="saving"></i>
                        <span x-text="saving ? 'Saving...' : 'Save Changes'"></span>
                    </button>
                    <a href="<?= url('/dashboard') ?>" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function profileManager() {
    return {
        saving: false,
        formData: {
            first_name: '<?= htmlspecialchars($user['first_name']) ?>',
            last_name: '<?= htmlspecialchars($user['last_name']) ?>',
            phone: '<?= htmlspecialchars($user['phone'] ?? '') ?>',
            bio: '<?= htmlspecialchars($user['bio'] ?? '') ?>',
            location: '<?= htmlspecialchars($user['location'] ?? '') ?>',
            website: '<?= htmlspecialchars($user['website'] ?? '') ?>',
            github: '<?= htmlspecialchars($user['github'] ?? '') ?>',
            linkedin: '<?= htmlspecialchars($user['linkedin'] ?? '') ?>',
            twitter: '<?= htmlspecialchars($user['twitter'] ?? '') ?>'
        },

        async updateProfile() {
            this.saving = true;
            
            try {
                const params = new URLSearchParams(this.formData);
                params.append('_token', '<?= csrf_token() ?>');
                const response = await fetch('<?= url('/profile/update') ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: params
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showSuccess('Profile updated successfully!');
                } else {
                    showError('Error: ' + (data.error || 'Failed to update profile'));
                }
            } catch (error) {
                showError('Error: ' + error.message);
            } finally {
                this.saving = false;
            }
        },

        async uploadAvatar(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            const formData = new FormData();
            formData.append('avatar', file);
            formData.append('_token', '<?= csrf_token() ?>');
            
            try {
                const response = await fetch('<?= url('/profile/upload-avatar') ?>', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Update avatar preview
                    const container = document.getElementById('avatarContainer');
                    let avatarImg = document.getElementById('avatarPreview');
                    
                    if (avatarImg) {
                        // Avatar image already exists, just update src
                        avatarImg.src = data.avatar_url;
                    } else {
                        // No avatar exists, replace initials with image
                        container.innerHTML = '<img src="' + data.avatar_url + '" alt="Avatar" class="w-full h-full object-cover" id="avatarPreview">';
                    }
                    
                    showSuccess('Avatar uploaded successfully!');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showError('Error: ' + (data.error || 'Failed to upload avatar'));
                }
            } catch (error) {
                showError('Error: ' + error.message);
            }
        }
    };
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
