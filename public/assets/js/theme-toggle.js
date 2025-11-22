// Theme Toggle System
// Supports dark mode as default with toggle capability

(function() {
    'use strict';
    
    // Get theme from localStorage or default to dark
    function getTheme() {
        const stored = localStorage.getItem('theme');
        if (stored) {
            return stored;
        }
        // Default to dark theme
        return 'dark';
    }
    
    // Set theme immediately (before page renders)
    function setThemeImmediate(theme) {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
    
    // Set theme
    function setTheme(theme) {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
        
        // Update toggle button icon if it exists
        updateToggleButton(theme);
    }
    
    // Update toggle button icon
    function updateToggleButton(theme) {
        const toggleBtn = document.getElementById('theme-toggle');
        if (toggleBtn) {
            const icon = toggleBtn.querySelector('i');
            if (icon) {
                if (theme === 'dark') {
                    icon.className = 'fas fa-sun';
                } else {
                    icon.className = 'fas fa-moon';
                }
            }
        }
    }
    
    // Toggle theme
    function toggleTheme() {
        const currentTheme = getTheme();
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        setTheme(newTheme);
    }
    
    // Initialize theme on page load
    function initTheme() {
        const theme = getTheme();
        setTheme(theme);
    }
    
    // Set theme immediately to prevent flash
    setThemeImmediate(getTheme());
    
    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTheme);
    } else {
        initTheme();
    }
    
    // Expose toggle function globally
    window.toggleTheme = toggleTheme;
    
    // Add click listener when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('theme-toggle');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', toggleTheme);
        }
    });
})();
