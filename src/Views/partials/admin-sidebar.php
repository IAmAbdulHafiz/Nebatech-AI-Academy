<?php
$currentPath = $_SERVER['REQUEST_URI'];
$isActive = function($path) use ($currentPath) {
    return strpos($currentPath, $path) !== false ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100';
};
?>

<!-- Dashboard -->
<a href="<?= url('/admin/dashboard') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/admin/dashboard') ?>" title="Dashboard">
    <i class="fas fa-home w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Dashboard</span>
</a>

<!-- Applications -->
<a href="<?= url('/admin/applications') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/admin/applications') ?>" title="Applications">
    <i class="fas fa-file-alt w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Applications</span>
    <?php if (isset($pendingCount) && $pendingCount > 0): ?>
        <span class="ml-auto bg-yellow-500 text-white text-xs px-2 py-1 rounded-full font-bold" x-show="sidebarOpen"><?= $pendingCount ?></span>
    <?php endif; ?>
</a>

<!-- Approvals -->
<a href="<?= url('/admin/approvals') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/admin/approvals') ?>" title="Approvals">
    <i class="fas fa-check-circle w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Approvals</span>
</a>

<!-- Users -->
<a href="<?= url('/admin/users') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/admin/users') ?>" title="Users">
    <i class="fas fa-users w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Users</span>
</a>

<!-- Courses -->
<a href="<?= url('/admin/courses') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/admin/courses') ?>" title="Courses">
    <i class="fas fa-book w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Courses</span>
</a>

<!-- Cohorts -->
<a href="<?= url('/admin/cohorts') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/admin/cohorts') ?>" title="Cohorts">
    <i class="fas fa-user-friends w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Cohorts</span>
</a>

<!-- Certificates -->
<a href="<?= url('/admin/certificates') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/admin/certificates') ?>" title="Certificates">
    <i class="fas fa-certificate w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Certificates</span>
</a>

<!-- Divider -->
<div class="border-t border-gray-200 my-4" x-show="sidebarOpen"></div>

<!-- Analytics -->
<a href="<?= url('/admin/analytics') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/admin/analytics') ?>" title="Analytics">
    <i class="fas fa-chart-bar w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Analytics</span>
</a>

<!-- Settings -->
<a href="<?= url('/settings') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/admin/settings') ?>" title="Settings">
    <i class="fas fa-cog w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Settings</span>
</a>

<!-- Divider -->
<div class="border-t border-gray-200 my-4" x-show="sidebarOpen"></div>

<!-- Back to Site -->
<a href="<?= url('/') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition text-gray-700 hover:bg-gray-100" title="Back to Site">
    <i class="fas fa-arrow-left w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Back to Site</span>
</a>
