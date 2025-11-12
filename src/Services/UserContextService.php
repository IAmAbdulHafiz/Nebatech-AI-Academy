<?php

namespace Nebatech\Services;

/**
 * User Context Service
 * Manages user context detection and cross-section navigation
 */
class UserContextService
{
    /**
     * Detect current section based on URL path
     */
    public static function getCurrentSection(): string
    {
        $currentPath = $_SERVER['REQUEST_URI'] ?? '/';
        
        // Academy section patterns
        $academyPatterns = [
            '/dashboard',
            '/my-',
            '/facilitator',
            '/admin',
            '/programmes',
            '/courses',
            '/applications',
            '/certificates',
            '/portfolio'
        ];
        
        foreach ($academyPatterns as $pattern) {
            if (strpos($currentPath, $pattern) !== false) {
                return 'academy';
            }
        }
        
        return 'corporate';
    }
    
    /**
     * Get user context (visitor, student, client, facilitator, admin)
     */
    public static function getUserContext(): string
    {
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            return 'visitor';
        }
        
        if (function_exists('is_admin') && is_admin()) {
            return 'admin';
        }
        
        if (function_exists('is_facilitator') && is_facilitator()) {
            return 'facilitator';
        }
        
        if (function_exists('is_student') && is_student()) {
            return 'student';
        }
        
        return 'user';
    }
    
    /**
     * Get appropriate navigation items based on context
     */
    public static function getNavigationItems(string $section, string $userContext): array
    {
        $baseItems = [
            ['label' => 'Home', 'url' => url('/'), 'icon' => 'home'],
            ['label' => 'About', 'url' => url('/about'), 'icon' => 'info-circle'],
        ];
        
        if ($section === 'corporate') {
            $baseItems[] = ['label' => 'Services', 'url' => url('/services'), 'icon' => 'briefcase'];
            $baseItems[] = ['label' => 'Training Programs', 'url' => url('/programmes'), 'icon' => 'graduation-cap'];
            $baseItems[] = ['label' => 'Projects', 'url' => url('/projects'), 'icon' => 'folder'];
        } else {
            $baseItems[] = ['label' => 'Training Programs', 'url' => url('/programmes'), 'icon' => 'graduation-cap'];
            $baseItems[] = ['label' => 'Services', 'url' => url('/services'), 'icon' => 'briefcase'];
            
            if ($userContext === 'student') {
                $baseItems[] = ['label' => 'My Dashboard', 'url' => url('/dashboard'), 'icon' => 'tachometer-alt'];
            }
        }
        
        $baseItems[] = ['label' => 'Blog', 'url' => url('/blog'), 'icon' => 'blog'];
        $baseItems[] = ['label' => 'Contact', 'url' => url('/contact'), 'icon' => 'envelope'];
        
        return $baseItems;
    }
    
    /**
     * Get cross-promotional content based on user context and current section
     */
    public static function getCrossPromotionalContent(string $section, string $userContext): array
    {
        $content = [];
        
        if ($section === 'corporate' && $userContext === 'student') {
            $content[] = [
                'type' => 'banner',
                'title' => 'Need Professional Development?',
                'message' => 'Let our experts build your project while you focus on learning',
                'cta' => 'Explore Services',
                'url' => url('/services'),
                'color' => 'blue'
            ];
        }
        
        if ($section === 'academy' && $userContext === 'visitor') {
            $content[] = [
                'type' => 'banner',
                'title' => 'Learn to Build It Yourself',
                'message' => 'Master the skills with our hands-on training programs',
                'cta' => 'Start Learning',
                'url' => url('/programmes'),
                'color' => 'green'
            ];
        }
        
        if ($userContext === 'student') {
            $content[] = [
                'type' => 'sidebar',
                'title' => 'Apply Your Skills',
                'message' => 'Ready to take on real projects? Check out our professional services',
                'cta' => 'View Opportunities',
                'url' => url('/services'),
                'color' => 'purple'
            ];
        }
        
        return $content;
    }
    
    /**
     * Get appropriate search placeholder based on context
     */
    public static function getSearchPlaceholder(string $section): string
    {
        return $section === 'academy' 
            ? 'Search courses, topics, instructors...'
            : 'Search services, solutions, projects...';
    }
    
    /**
     * Get appropriate CTA text based on context
     */
    public static function getCtaText(string $section, string $action = 'primary'): string
    {
        if ($action === 'primary') {
            return $section === 'academy' ? 'Start Learning' : 'Get Started';
        }
        
        if ($action === 'secondary') {
            return $section === 'academy' ? 'Browse Courses' : 'View Services';
        }
        
        return 'Learn More';
    }
    
    /**
     * Check if user should see cross-section navigation
     */
    public static function shouldShowCrossSectionNav(string $userContext): bool
    {
        return in_array($userContext, ['student', 'facilitator', 'admin']);
    }
    
    /**
     * Get user's primary dashboard URL based on context
     */
    public static function getPrimaryDashboardUrl(string $userContext): string
    {
        switch ($userContext) {
            case 'admin':
                return url('/admin/dashboard');
            case 'facilitator':
                return url('/facilitator/dashboard');
            case 'student':
                return url('/dashboard');
            default:
                return url('/');
        }
    }
}
