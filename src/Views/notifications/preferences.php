<?php require_once __DIR__ . '/../layouts/main.php'; ?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-bell text-purple-600"></i>
                Notification Preferences
            </h1>
            <p class="text-gray-600">Manage how you receive notifications from Nebatech AI Academy</p>
        </div>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="mb-6 p-4 rounded-lg <?= $_SESSION['flash_type'] === 'success' ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-red-50 text-red-800 border border-red-200' ?>">
                <i class="fas fa-<?= $_SESSION['flash_type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?> mr-2"></i>
                <?= $_SESSION['flash_message'] ?>
            </div>
            <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
        <?php endif; ?>

        <form action="/notifications/update" method="POST" class="space-y-6">
            <!-- Master Toggle -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-start">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">Email Notifications</h3>
                        <p class="text-sm text-gray-600">Receive email notifications from Nebatech AI Academy</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="email_enabled" class="sr-only peer" <?= $preferences['email_enabled'] ? 'checked' : '' ?>>
                        <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-purple-600"></div>
                    </label>
                </div>
            </div>

            <!-- Notification Types -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-list-check text-purple-600 mr-2"></i>
                        Notification Types
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Choose which types of notifications you want to receive</p>
                </div>

                <div class="divide-y divide-gray-200">
                    <!-- Grades -->
                    <div class="p-6 flex items-start justify-between hover:bg-gray-50 transition">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-graduation-cap text-primary"></i>
                                <h4 class="font-semibold text-gray-900">Grades & Feedback</h4>
                            </div>
                            <p class="text-sm text-gray-600">Get notified when assignments are graded or feedback is available</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer ml-4">
                            <input type="checkbox" name="grades" class="sr-only peer" <?= $preferences['grades'] ? 'checked' : '' ?>>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <!-- Enrollment -->
                    <div class="p-6 flex items-start justify-between hover:bg-gray-50 transition">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-user-plus text-green-600"></i>
                                <h4 class="font-semibold text-gray-900">Enrollment & Courses</h4>
                            </div>
                            <p class="text-sm text-gray-600">Receive confirmations when you enroll in new courses</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer ml-4">
                            <input type="checkbox" name="enrollment" class="sr-only peer" <?= $preferences['enrollment'] ? 'checked' : '' ?>>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                    </div>

                    <!-- Certificates -->
                    <div class="p-6 flex items-start justify-between hover:bg-gray-50 transition">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-certificate text-yellow-600"></i>
                                <h4 class="font-semibold text-gray-900">Certificates & Badges</h4>
                            </div>
                            <p class="text-sm text-gray-600">Get notified when you earn certificates and achievement badges</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer ml-4">
                            <input type="checkbox" name="certificates" class="sr-only peer" <?= $preferences['certificates'] ? 'checked' : '' ?>>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-600"></div>
                        </label>
                    </div>

                    <!-- Announcements -->
                    <div class="p-6 flex items-start justify-between hover:bg-gray-50 transition">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-bullhorn text-orange-600"></i>
                                <h4 class="font-semibold text-gray-900">Announcements</h4>
                            </div>
                            <p class="text-sm text-gray-600">Stay updated with important platform announcements and updates</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer ml-4">
                            <input type="checkbox" name="announcements" class="sr-only peer" <?= $preferences['announcements'] ? 'checked' : '' ?>>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600"></div>
                        </label>
                    </div>

                    <!-- Reminders -->
                    <div class="p-6 flex items-start justify-between hover:bg-gray-50 transition">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-clock text-indigo-600"></i>
                                <h4 class="font-semibold text-gray-900">Reminders</h4>
                            </div>
                            <p class="text-sm text-gray-600">Receive reminders about deadlines and upcoming assignments</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer ml-4">
                            <input type="checkbox" name="reminders" class="sr-only peer" <?= $preferences['reminders'] ? 'checked' : '' ?>>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>

                    <!-- Marketing -->
                    <div class="p-6 flex items-start justify-between hover:bg-gray-50 transition">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-envelope text-purple-600"></i>
                                <h4 class="font-semibold text-gray-900">Marketing & Promotions</h4>
                            </div>
                            <p class="text-sm text-gray-600">Receive news about new courses, features, and special offers</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer ml-4">
                            <input type="checkbox" name="marketing" class="sr-only peer" <?= $preferences['marketing'] ? 'checked' : '' ?>>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Digest Frequency -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-calendar-alt text-purple-600 mr-2"></i>
                    Email Frequency
                </h3>
                <p class="text-sm text-gray-600 mb-4">Choose how often you want to receive email notifications</p>

                <div class="space-y-3">
                    <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition <?= $preferences['digest_frequency'] === 'immediate' ? 'border-purple-600 bg-purple-50' : 'border-gray-200' ?>">
                        <input type="radio" name="digest_frequency" value="immediate" class="mt-1 text-purple-600 focus:ring-purple-500" <?= $preferences['digest_frequency'] === 'immediate' ? 'checked' : '' ?>>
                        <div class="ml-3">
                            <div class="font-semibold text-gray-900">Immediate</div>
                            <div class="text-sm text-gray-600">Receive emails as soon as notifications occur</div>
                        </div>
                    </label>

                    <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition <?= $preferences['digest_frequency'] === 'daily' ? 'border-purple-600 bg-purple-50' : 'border-gray-200' ?>">
                        <input type="radio" name="digest_frequency" value="daily" class="mt-1 text-purple-600 focus:ring-purple-500" <?= $preferences['digest_frequency'] === 'daily' ? 'checked' : '' ?>>
                        <div class="ml-3">
                            <div class="font-semibold text-gray-900">Daily Digest</div>
                            <div class="text-sm text-gray-600">Receive a summary of all notifications once per day</div>
                        </div>
                    </label>

                    <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition <?= $preferences['digest_frequency'] === 'weekly' ? 'border-purple-600 bg-purple-50' : 'border-gray-200' ?>">
                        <input type="radio" name="digest_frequency" value="weekly" class="mt-1 text-purple-600 focus:ring-purple-500" <?= $preferences['digest_frequency'] === 'weekly' ? 'checked' : '' ?>>
                        <div class="ml-3">
                            <div class="font-semibold text-gray-900">Weekly Digest</div>
                            <div class="text-sm text-gray-600">Receive a summary of all notifications once per week</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">
                <a href="/dashboard" class="text-gray-600 hover:text-gray-900 transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Dashboard
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all shadow-md hover:shadow-lg">
                    <i class="fas fa-save mr-2"></i>
                    Save Preferences
                </button>
            </div>
        </form>
    </div>
</div>


