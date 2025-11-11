<?php
$title = 'Settings';
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

<div x-data="settingsManager()">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Settings</h1>
        <p class="text-gray-600">Manage your account settings and preferences</p>
    </div>

    <!-- Settings Tabs -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px overflow-x-auto">
                <button @click="activeTab = 'account'" 
                        :class="activeTab === 'account' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap">
                    <i class="fas fa-user mr-2"></i>Account
                </button>
                <button @click="activeTab = 'security'" 
                        :class="activeTab === 'security' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap">
                    <i class="fas fa-lock mr-2"></i>Security
                </button>
                <button @click="activeTab = 'notifications'" 
                        :class="activeTab === 'notifications' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap">
                    <i class="fas fa-bell mr-2"></i>Notifications
                </button>
                <button @click="activeTab = 'preferences'" 
                        :class="activeTab === 'preferences' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap">
                    <i class="fas fa-cog mr-2"></i>Preferences
                </button>
                <button @click="activeTab = 'editor'" 
                        :class="activeTab === 'editor' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap">
                    <i class="fas fa-code mr-2"></i>Code Editor
                </button>
                <button @click="activeTab = 'danger'" 
                        :class="activeTab === 'danger' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Danger Zone
                </button>
            </nav>
        </div>

        <!-- Account Settings -->
        <div x-show="activeTab === 'account'" x-cloak class="p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Account Settings</h2>
            
            <form @submit.prevent="updateSettings">
                <div class="space-y-4 max-w-2xl">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" x-model="settings.email" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                        <p class="text-sm text-gray-500 mt-1">Your email address for login and notifications</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Account Status</label>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                                <i class="fas fa-check-circle mr-1"></i><?= ucfirst($user['status']) ?>
                            </span>
                            <span class="text-sm text-gray-600">Member since <?= date('F Y', strtotime($user['created_at'])) ?></span>
                        </div>
                    </div>

                    <button type="submit" :disabled="saving"
                            class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium disabled:opacity-50">
                        <i class="fas" :class="saving ? 'fa-spinner fa-spin' : 'fa-save'"></i>
                        <span x-text="saving ? 'Saving...' : 'Save Changes'"></span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Security Settings -->
        <div x-show="activeTab === 'security'" x-cloak class="p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Security Settings</h2>
            
            <div class="max-w-2xl space-y-6">
                <!-- Change Password -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Change Password</h3>
                    <form @submit.prevent="changePassword">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                <input type="password" x-model="passwordForm.current_password" required
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                <input type="password" x-model="passwordForm.new_password" required minlength="8"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                                <p class="text-sm text-gray-500 mt-1">Minimum 8 characters</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                <input type="password" x-model="passwordForm.confirm_password" required minlength="8"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                            <button type="submit" :disabled="changingPassword"
                                    class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium disabled:opacity-50">
                                <i class="fas" :class="changingPassword ? 'fa-spinner fa-spin' : 'fa-key'"></i>
                                <span x-text="changingPassword ? 'Changing...' : 'Change Password'"></span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Two-Factor Authentication -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-bold text-gray-900 mb-2">Two-Factor Authentication</h3>
                            <p class="text-sm text-gray-600">Add an extra layer of security to your account</p>
                        </div>
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Coming Soon</span>
                    </div>
                </div>

                <!-- Active Sessions -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Active Sessions</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-desktop text-gray-400 text-xl"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Current Session</p>
                                    <p class="text-sm text-gray-500">Windows • Chrome • <?= $_SERVER['REMOTE_ADDR'] ?? 'Unknown IP' ?></p>
                                </div>
                            </div>
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">Active</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications Settings -->
        <div x-show="activeTab === 'notifications'" x-cloak class="p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Notification Preferences</h2>
            
            <form @submit.prevent="updateSettings">
                <div class="max-w-2xl space-y-6">
                    <!-- Email Notifications -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Email Notifications</h3>
                        <div class="space-y-4">
                            <label class="flex items-center justify-between cursor-pointer">
                                <div>
                                    <p class="font-medium text-gray-900">Course Updates</p>
                                    <p class="text-sm text-gray-600">Get notified about new lessons and assignments</p>
                                </div>
                                <input type="checkbox" x-model="settings.email_notifications" class="w-5 h-5 text-primary rounded focus:ring-primary">
                            </label>
                            
                            <label class="flex items-center justify-between cursor-pointer">
                                <div>
                                    <p class="font-medium text-gray-900">Marketing Emails</p>
                                    <p class="text-sm text-gray-600">Receive news, tips, and special offers</p>
                                </div>
                                <input type="checkbox" x-model="settings.marketing_emails" class="w-5 h-5 text-primary rounded focus:ring-primary">
                            </label>
                        </div>
                    </div>

                    <!-- Push Notifications -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Push Notifications</h3>
                        <div class="space-y-4">
                            <label class="flex items-center justify-between cursor-pointer">
                                <div>
                                    <p class="font-medium text-gray-900">Browser Notifications</p>
                                    <p class="text-sm text-gray-600">Get real-time updates in your browser</p>
                                </div>
                                <input type="checkbox" x-model="settings.push_notifications" class="w-5 h-5 text-primary rounded focus:ring-primary">
                            </label>
                        </div>
                    </div>

                    <button type="submit" :disabled="saving"
                            class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium disabled:opacity-50">
                        <i class="fas" :class="saving ? 'fa-spinner fa-spin' : 'fa-save'"></i>
                        <span x-text="saving ? 'Saving...' : 'Save Preferences'"></span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Preferences -->
        <div x-show="activeTab === 'preferences'" x-cloak class="p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Preferences</h2>
            
            <form @submit.prevent="updateSettings">
                <div class="max-w-2xl space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Language</label>
                        <select x-model="settings.language" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="en">English</option>
                            <option value="es">Español</option>
                            <option value="fr">Français</option>
                            <option value="de">Deutsch</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                        <select x-model="settings.timezone" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="UTC">UTC</option>
                            <option value="America/New_York">Eastern Time (ET)</option>
                            <option value="America/Chicago">Central Time (CT)</option>
                            <option value="America/Denver">Mountain Time (MT)</option>
                            <option value="America/Los_Angeles">Pacific Time (PT)</option>
                            <option value="Europe/London">London (GMT)</option>
                            <option value="Europe/Paris">Paris (CET)</option>
                            <option value="Asia/Tokyo">Tokyo (JST)</option>
                        </select>
                    </div>

                    <button type="submit" :disabled="saving"
                            class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium disabled:opacity-50">
                        <i class="fas" :class="saving ? 'fa-spinner fa-spin' : 'fa-save'"></i>
                        <span x-text="saving ? 'Saving...' : 'Save Preferences'"></span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Editor Settings -->
        <div x-show="activeTab === 'editor'" x-cloak class="p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Code Editor Settings</h2>
            
            <form @submit.prevent="updateEditorSettings">
                <div class="max-w-4xl space-y-6">
                    <!-- Theme Selection -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Editor Theme</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <button type="button" @click="editorSettings.theme = 'github-light'" 
                                    :class="editorSettings.theme === 'github-light' ? 'ring-2 ring-primary bg-white' : 'bg-white hover:ring-2 hover:ring-gray-300'"
                                    class="p-4 rounded-lg border border-gray-200 transition text-left">
                                <div class="w-full h-16 bg-gradient-to-br from-white to-gray-100 rounded mb-2 border border-gray-200"></div>
                                <p class="text-sm font-medium">GitHub Light</p>
                                <p class="text-xs text-gray-500">Light theme</p>
                            </button>
                            <button type="button" @click="editorSettings.theme = 'monokai'" 
                                    :class="editorSettings.theme === 'monokai' ? 'ring-2 ring-primary bg-white' : 'bg-white hover:ring-2 hover:ring-gray-300'"
                                    class="p-4 rounded-lg border border-gray-200 transition text-left">
                                <div class="w-full h-16 bg-gradient-to-br from-gray-800 to-gray-900 rounded mb-2"></div>
                                <p class="text-sm font-medium">Monokai</p>
                                <p class="text-xs text-gray-500">Dark theme</p>
                            </button>
                            <button type="button" @click="editorSettings.theme = 'dracula'" 
                                    :class="editorSettings.theme === 'dracula' ? 'ring-2 ring-primary bg-white' : 'bg-white hover:ring-2 hover:ring-gray-300'"
                                    class="p-4 rounded-lg border border-gray-200 transition text-left">
                                <div class="w-full h-16 bg-gradient-to-br from-purple-900 to-gray-900 rounded mb-2"></div>
                                <p class="text-sm font-medium">Dracula</p>
                                <p class="text-xs text-gray-500">Dark theme</p>
                            </button>
                            <button type="button" @click="editorSettings.theme = 'nord'" 
                                    :class="editorSettings.theme === 'nord' ? 'ring-2 ring-primary bg-white' : 'bg-white hover:ring-2 hover:ring-gray-300'"
                                    class="p-4 rounded-lg border border-gray-200 transition text-left">
                                <div class="w-full h-16 bg-gradient-to-br from-blue-900 to-gray-800 rounded mb-2"></div>
                                <p class="text-sm font-medium">Nord</p>
                                <p class="text-xs text-gray-500">Dark theme</p>
                            </button>
                        </div>
                    </div>

                    <!-- Editor Options -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Editor Options</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Font Size -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Font Size: <span x-text="editorSettings.fontSize + 'px'" class="text-primary"></span>
                                </label>
                                <input type="range" x-model.number="editorSettings.fontSize" min="10" max="24" step="1"
                                       class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>10px</span>
                                    <span>24px</span>
                                </div>
                            </div>

                            <!-- Tab Size -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tab Size</label>
                                <select x-model.number="editorSettings.tabSize" 
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="2">2 spaces</option>
                                    <option value="4">4 spaces</option>
                                    <option value="8">8 spaces</option>
                                </select>
                            </div>

                            <!-- Default Language -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Default Language</label>
                                <select x-model="editorSettings.language" 
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="javascript">JavaScript</option>
                                    <option value="python">Python</option>
                                    <option value="html">HTML</option>
                                    <option value="css">CSS</option>
                                    <option value="php">PHP</option>
                                    <option value="sql">SQL</option>
                                    <option value="java">Java</option>
                                    <option value="cpp">C++</option>
                                </select>
                            </div>
                        </div>

                        <!-- Toggle Options -->
                        <div class="mt-6 space-y-3">
                            <label class="flex items-center justify-between cursor-pointer p-3 bg-white rounded-lg hover:bg-gray-50">
                                <div>
                                    <p class="font-medium text-gray-900">Line Numbers</p>
                                    <p class="text-sm text-gray-600">Show line numbers in the editor</p>
                                </div>
                                <input type="checkbox" x-model="editorSettings.lineNumbers" 
                                       class="w-5 h-5 text-primary rounded focus:ring-primary">
                            </label>

                            <label class="flex items-center justify-between cursor-pointer p-3 bg-white rounded-lg hover:bg-gray-50">
                                <div>
                                    <p class="font-medium text-gray-900">Line Wrapping</p>
                                    <p class="text-sm text-gray-600">Wrap long lines of code</p>
                                </div>
                                <input type="checkbox" x-model="editorSettings.lineWrapping" 
                                       class="w-5 h-5 text-primary rounded focus:ring-primary">
                            </label>

                            <label class="flex items-center justify-between cursor-pointer p-3 bg-white rounded-lg hover:bg-gray-50">
                                <div>
                                    <p class="font-medium text-gray-900">Auto Close Brackets</p>
                                    <p class="text-sm text-gray-600">Automatically close brackets and quotes</p>
                                </div>
                                <input type="checkbox" x-model="editorSettings.autoCloseBrackets" 
                                       class="w-5 h-5 text-primary rounded focus:ring-primary">
                            </label>

                            <label class="flex items-center justify-between cursor-pointer p-3 bg-white rounded-lg hover:bg-gray-50">
                                <div>
                                    <p class="font-medium text-gray-900">Indent With Tabs</p>
                                    <p class="text-sm text-gray-600">Use tabs instead of spaces for indentation</p>
                                </div>
                                <input type="checkbox" x-model="editorSettings.indentWithTabs" 
                                       class="w-5 h-5 text-primary rounded focus:ring-primary">
                            </label>
                        </div>
                    </div>

                    <!-- Preview -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Preview</h3>
                        <textarea id="editorPreview" data-language="javascript" rows="10" 
                                  class="w-full font-mono text-sm">// Sample JavaScript code
function greet(name) {
    console.log(`Hello, ${name}!`);
    return true;
}

// Call the function
greet('World');</textarea>
                        <p class="text-sm text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Changes will be applied to all code editors after saving
                        </p>
                    </div>

                    <!-- Save Button -->
                    <div class="flex gap-3">
                        <button type="submit" :disabled="savingEditor"
                                class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium disabled:opacity-50">
                            <i class="fas" :class="savingEditor ? 'fa-spinner fa-spin' : 'fa-save'"></i>
                            <span x-text="savingEditor ? 'Saving...' : 'Save Editor Settings'"></span>
                        </button>
                        <button type="button" @click="resetEditorSettings"
                                class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                            <i class="fas fa-undo mr-2"></i>Reset to Defaults
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div x-show="activeTab === 'danger'" x-cloak class="p-6">
            <h2 class="text-xl font-bold text-red-900 mb-6">Danger Zone</h2>
            
            <div class="max-w-2xl space-y-6">
                <!-- Delete Account -->
                <div class="border-2 border-red-200 rounded-lg p-6 bg-red-50">
                    <h3 class="font-bold text-red-900 mb-2">Delete Account</h3>
                    <p class="text-sm text-red-700 mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                    <button @click="showDeleteModal = true" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                        <i class="fas fa-trash mr-2"></i>Delete My Account
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div x-show="showDeleteModal" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="showDeleteModal = false"
         class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div @click.stop class="bg-white rounded-lg max-w-md w-full p-6">
            <h3 class="text-xl font-bold text-red-900 mb-4">Delete Account</h3>
            <p class="text-gray-700 mb-4">This action cannot be undone. All your data will be permanently deleted.</p>
            
            <form @submit.prevent="deleteAccount">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Enter your password to confirm</label>
                    <input type="password" x-model="deleteForm.password" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>
                
                <div class="flex gap-3">
                    <button type="submit" :disabled="deleting"
                            class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium disabled:opacity-50">
                        <span x-text="deleting ? 'Deleting...' : 'Delete Account'"></span>
                    </button>
                    <button type="button" @click="showDeleteModal = false"
                            class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function settingsManager() {
    return {
        activeTab: 'account',
        saving: false,
        savingEditor: false,
        changingPassword: false,
        deleting: false,
        showDeleteModal: false,
        previewEditor: null,
        settings: {
            email: '<?= htmlspecialchars($user['email']) ?>',
            timezone: '<?= htmlspecialchars($user['timezone'] ?? 'UTC') ?>',
            language: '<?= htmlspecialchars($user['language'] ?? 'en') ?>',
            email_notifications: <?= ($user['email_notifications'] ?? 1) ? 'true' : 'false' ?>,
            push_notifications: <?= ($user['push_notifications'] ?? 0) ? 'true' : 'false' ?>,
            marketing_emails: <?= ($user['marketing_emails'] ?? 0) ? 'true' : 'false' ?>
        },
        editorSettings: {
            theme: '<?= $editorSettings['theme'] ?? 'github-light' ?>',
            fontSize: <?= $editorSettings['fontSize'] ?? 14 ?>,
            lineNumbers: <?= ($editorSettings['lineNumbers'] ?? true) ? 'true' : 'false' ?>,
            lineWrapping: <?= ($editorSettings['lineWrapping'] ?? false) ? 'true' : 'false' ?>,
            tabSize: <?= $editorSettings['tabSize'] ?? 4 ?>,
            indentWithTabs: <?= ($editorSettings['indentWithTabs'] ?? false) ? 'true' : 'false' ?>,
            autoCloseBrackets: <?= ($editorSettings['autoCloseBrackets'] ?? true) ? 'true' : 'false' ?>,
            language: '<?= $editorSettings['language'] ?? 'javascript' ?>',
            keyMap: '<?= $editorSettings['keyMap'] ?? 'default' ?>'
        },
        passwordForm: {
            current_password: '',
            new_password: '',
            confirm_password: ''
        },
        deleteForm: {
            password: ''
        },

        init() {
            // Watch for editor settings changes to update preview
            this.$watch('editorSettings', () => {
                this.updatePreviewEditor();
            }, { deep: true });

            // Initialize preview editor when editor tab is shown
            this.$watch('activeTab', (value) => {
                if (value === 'editor') {
                    setTimeout(() => this.initPreviewEditor(), 100);
                }
            });
        },

        initPreviewEditor() {
            if (this.previewEditor || !window.codeEditorManager) return;
            
            const textarea = document.getElementById('editorPreview');
            if (textarea) {
                this.previewEditor = window.codeEditorManager.initialize(textarea, this.editorSettings);
            }
        },

        updatePreviewEditor() {
            if (this.previewEditor && window.codeEditorManager) {
                this.previewEditor.updateSettings(this.editorSettings);
            }
        },

        async updateSettings() {
            this.saving = true;
            
            try {
                const params = new URLSearchParams(this.settings);
                params.append('_token', '<?= csrf_token() ?>');
                const response = await fetch('<?= url('/settings/update') ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: params
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showSuccess('Settings updated successfully!');
                } else {
                    showError('Error: ' + (data.error || 'Failed to update settings'));
                }
            } catch (error) {
                showError('Error: ' + error.message);
            } finally {
                this.saving = false;
            }
        },

        async changePassword() {
            this.changingPassword = true;
            
            try {
                const params = new URLSearchParams(this.passwordForm);
                params.append('_token', '<?= csrf_token() ?>');
                const response = await fetch('<?= url('/settings/change-password') ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: params
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showSuccess('Password changed successfully!');
                    this.passwordForm = {current_password: '', new_password: '', confirm_password: ''};
                } else {
                    showError('Error: ' + (data.error || 'Failed to change password'));
                }
            } catch (error) {
                showError('Error: ' + error.message);
            } finally {
                this.changingPassword = false;
            }
        },

        async updateEditorSettings() {
            this.savingEditor = true;
            
            try {
                const response = await fetch('<?= url('/settings/update-editor') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?= csrf_token() ?>'
                    },
                    body: JSON.stringify({ editor_settings: this.editorSettings })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showSuccess('Editor settings saved successfully!');
                    
                    // Update localStorage for immediate effect
                    if (window.codeEditorManager) {
                        window.codeEditorManager.saveSettings(this.editorSettings);
                        window.codeEditorManager.updateAllEditors(this.editorSettings);
                    }
                } else {
                    showError('Error: ' + (data.error || 'Failed to save editor settings'));
                }
            } catch (error) {
                showError('Error: ' + error.message);
            } finally {
                this.savingEditor = false;
            }
        },

        resetEditorSettings() {
            this.editorSettings = {
                theme: 'github-light',
                fontSize: 14,
                lineNumbers: true,
                lineWrapping: false,
                tabSize: 4,
                indentWithTabs: false,
                autoCloseBrackets: true,
                language: 'javascript',
                keyMap: 'default'
            };
            showSuccess('Editor settings reset to defaults');
        },

        async deleteAccount() {
            const confirmed = await confirmAction('Are you absolutely sure? This cannot be undone!', {
                title: 'Delete Account',
                confirmText: 'Delete Account',
                type: 'danger'
            });
            
            if (!confirmed) return;
            
            this.deleting = true;
            
            try {
                const params = new URLSearchParams(this.deleteForm);
                params.append('_token', '<?= csrf_token() ?>');
                const response = await fetch('<?= url('/settings/delete-account') ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: params
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showSuccess('Account deleted. You will be redirected to the homepage.');
                    setTimeout(() => window.location.href = '<?= url('/') ?>', 1500);
                } else {
                    showError('Error: ' + (data.error || 'Failed to delete account'));
                }
            } catch (error) {
                showError('Error: ' + error.message);
            } finally {
                this.deleting = false;
            }
        }
    };
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
