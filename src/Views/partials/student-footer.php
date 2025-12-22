<?php
/**
 * Student Footer Partial
 * Contains the footer for the student portal
 */
?>

<!-- Footer -->
<footer class="bg-white/80 backdrop-blur border-t border-gray-200/50 py-4 px-6 mt-auto">
    <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 bg-primary rounded flex items-center justify-center">
                <i class="fas fa-graduation-cap text-white text-xs"></i>
            </div>
            <p>&copy; <?= date('Y') ?> Nebatech AI Academy</p>
        </div>
        <div class="flex items-center space-x-6 mt-3 md:mt-0">
            <a href="<?= url('/about') ?>" class="hover:text-primary transition">About</a>
            <a href="<?= url('/support') ?>" class="hover:text-primary transition">Help</a>
            <a href="<?= url('/privacy') ?>" class="hover:text-primary transition">Privacy</a>
            <a href="<?= url('/terms') ?>" class="hover:text-primary transition">Terms</a>
        </div>
    </div>
</footer>
