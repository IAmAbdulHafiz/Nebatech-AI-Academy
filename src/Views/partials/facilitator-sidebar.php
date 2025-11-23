<?php
$currentPath = $_SERVER['REQUEST_URI'];
$isActive = function($path) use ($currentPath) {
    return strpos($currentPath, $path) !== false ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100';
};
?>

<!-- Dashboard -->
<a href="<?= url('/facilitator/dashboard') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/facilitator/dashboard') ?>" title="Dashboard">
    <i class="fas fa-home w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Dashboard</span>
</a>

<!-- My Courses -->
<a href="<?= url('/facilitator/courses') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/facilitator/courses') ?>" title="My Courses">
    <i class="fas fa-book w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">My Courses</span>
</a>

<!-- Submissions -->
<a href="<?= url('/facilitator/submissions') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/facilitator/submissions') ?>" title="Submissions">
    <i class="fas fa-tasks w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Submissions</span>
    <?php if (isset($stats['pending']) && $stats['pending'] > 0): ?>
        <span class="ml-auto bg-yellow-500 text-white text-xs px-2 py-1 rounded-full font-bold" x-show="sidebarOpen"><?= $stats['pending'] ?></span>
    <?php endif; ?>
</a>

<!-- Students -->
<a href="<?= url('/facilitator/students') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/facilitator/students') ?>" title="Students">
    <i class="fas fa-user-graduate w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Students</span>
</a>

<!-- Cohorts -->
<a href="<?= url('/facilitator/cohorts') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/facilitator/cohorts') ?>" title="Cohorts">
    <i class="fas fa-user-friends w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Cohorts</span>
</a>

<!-- Divider -->
<div class="border-t border-gray-200 my-4" x-show="sidebarOpen"></div>

<!-- AI Tools -->
<a href="<?= url('/facilitator/ai-tools') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/facilitator/ai-tools') ?>" title="AI Tools">
    <i class="fas fa-robot w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">AI Tools</span>
</a>

<!-- Analytics -->
<a href="<?= url('/facilitator/analytics') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/facilitator/analytics') ?>" title="Analytics">
    <i class="fas fa-chart-line w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Analytics</span>
</a>

<!-- Divider -->
<div class="border-t border-gray-200 my-4" x-show="sidebarOpen"></div>

<!-- Profile -->
<a href="<?= url('/profile') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition text-gray-700 hover:bg-gray-100" title="Profile">
    <i class="fas fa-user w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Profile</span>
</a>

<!-- Back to Site -->
<a href="<?= url('/') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition text-gray-700 hover:bg-gray-100" title="Back to Site">
    <i class="fas fa-arrow-left w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Back to Site</span>
</a>
