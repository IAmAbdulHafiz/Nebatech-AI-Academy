<?php
$currentPath = $_SERVER['REQUEST_URI'];
$isActive = function($path) use ($currentPath) {
    return strpos($currentPath, $path) !== false ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100';
};
// Exact match for dashboard to avoid matching /progress/dashboard
$isDashboardActive = function() use ($currentPath) {
    return ($currentPath === '/dashboard' || strpos($currentPath, '/dashboard?') === 0) ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100';
};
?>

<!-- Dashboard -->
<a href="<?= url('/dashboard') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isDashboardActive() ?>" title="Dashboard">
    <i class="fas fa-home w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Dashboard</span>
</a>

<!-- My Courses -->
<a href="<?= url('/my-courses') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/my-courses') ?>" title="My Courses">
    <i class="fas fa-book w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">My Courses</span>
</a>

<!-- My Cohorts -->
<a href="<?= url('/my-cohorts') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/my-cohorts') ?>" title="My Cohorts">
    <i class="fas fa-users w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">My Cohorts</span>
</a>

<!-- Progress Dashboard -->
<a href="<?= url('/progress/dashboard') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/progress') ?>" title="My Progress">
    <i class="fas fa-chart-line w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">My Progress</span>
</a>

<!-- Applications -->
<a href="<?= url('/my-applications') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/my-applications') ?>" title="My Applications">
    <i class="fas fa-file-alt w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">My Applications</span>
</a>

<!-- Portfolio -->
<a href="<?= url('/my-portfolio') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/my-portfolio') ?>" title="Portfolio">
    <i class="fas fa-briefcase w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Portfolio</span>
</a>

<!-- Certificates -->
<a href="<?= url('/my-certificates') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/my-certificates') ?>" title="Certificates">
    <i class="fas fa-certificate w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Certificates</span>
</a>

<!-- Divider -->
<div class="border-t border-gray-200 my-4" x-show="sidebarOpen"></div>

<!-- Browse Courses -->
<a href="<?= url('/courses') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/courses') ?>" title="Browse Courses">
    <i class="fas fa-search w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Browse Courses</span>
</a>

<!-- Code Playground -->
<a href="<?= url('/playground') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/playground') ?>" title="Code Playground">
    <i class="fas fa-code w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Code Playground</span>
</a>

<!-- Showcase -->
<a href="<?= url('/showcase') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition <?= $isActive('/showcase') ?>" title="Student Showcase">
    <i class="fas fa-star w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Student Showcase</span>
</a>

<!-- Divider -->
<div class="border-t border-gray-200 my-4" x-show="sidebarOpen"></div>

<!-- Profile -->
<!-- <a href="< ?= url('/profile') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition text-gray-700 hover:bg-gray-100" title="Profile">
    <i class="fas fa-user w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Profile</span>
</a> -->

<!-- Settings -->
<!-- <a href="< ?= url('/settings') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition text-gray-700 hover:bg-gray-100" title="Settings">
    <i class="fas fa-cog w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Settings</span>
</a> -->

<!-- Back to Site -->
<a href="<?= url('/') ?>" :class="sidebarOpen ? 'gap-3 px-4' : 'justify-center'" class="flex items-center py-3 rounded-lg transition text-gray-700 hover:bg-gray-100" title="Back to Site">
    <i class="fas fa-arrow-left w-5 flex-shrink-0"></i>
    <span class="font-medium whitespace-nowrap overflow-hidden" x-show="sidebarOpen">Back to Site</span>
</a>
