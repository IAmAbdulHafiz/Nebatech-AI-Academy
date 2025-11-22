<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Database;
use Nebatech\Core\Controller;

class SitemapController extends Controller
{
    /**
     * Generate XML sitemap
     */
    public function generate()
    {
        header('Content-Type: application/xml; charset=utf-8');
        
        $baseUrl = rtrim($_ENV['APP_URL'] ?? 'https://nebatech.com', '/');
        $currentDate = date('Y-m-d');
        
        // Start XML
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        // Static pages
        $staticPages = [
            ['url' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => '/about', 'priority' => '0.9', 'changefreq' => 'monthly'],
            ['url' => '/courses', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => '/blog', 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => '/community', 'priority' => '0.8', 'changefreq' => 'daily'],
            ['url' => '/portfolio', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/pricing', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => '/partnerships', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => '/support', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => '/contact', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => '/login', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => '/register', 'priority' => '0.6', 'changefreq' => 'monthly'],
        ];
        
        foreach ($staticPages as $page) {
            echo $this->renderUrl(
                $baseUrl . $page['url'],
                $currentDate,
                $page['changefreq'],
                $page['priority']
            );
        }
        
        // Dynamic: Blog Posts
        try {
            $posts = Database::query(
                "SELECT slug, updated_at 
                 FROM blog_posts 
                 WHERE status = 'published' 
                 ORDER BY updated_at DESC"
            );
            
            foreach ($posts as $post) {
                $lastmod = date('Y-m-d', strtotime($post['updated_at']));
                echo $this->renderUrl(
                    $baseUrl . '/blog/' . $post['slug'],
                    $lastmod,
                    'weekly',
                    '0.7'
                );
            }
        } catch (\Exception $e) {
            error_log("Sitemap blog posts error: " . $e->getMessage());
        }
        
        // Dynamic: Courses
        try {
            $courses = Database::query(
                "SELECT slug, updated_at 
                 FROM courses 
                 WHERE status = 'published' 
                 ORDER BY updated_at DESC"
            );
            
            foreach ($courses as $course) {
                $lastmod = date('Y-m-d', strtotime($course['updated_at']));
                echo $this->renderUrl(
                    $baseUrl . '/courses/' . $course['slug'],
                    $lastmod,
                    'monthly',
                    '0.8'
                );
            }
        } catch (\Exception $e) {
            error_log("Sitemap courses error: " . $e->getMessage());
        }
        
        // Dynamic: Blog Categories
        try {
            $categories = Database::query(
                "SELECT slug FROM blog_categories WHERE status = 'active'"
            );
            
            foreach ($categories as $category) {
                echo $this->renderUrl(
                    $baseUrl . '/blog?category=' . $category['slug'],
                    $currentDate,
                    'weekly',
                    '0.6'
                );
            }
        } catch (\Exception $e) {
            error_log("Sitemap categories error: " . $e->getMessage());
        }
        
        // Dynamic: Community Discussions (top level)
        try {
            $discussions = Database::query(
                "SELECT id, updated_at 
                 FROM community_posts 
                 WHERE status = 'published' 
                 ORDER BY updated_at DESC 
                 LIMIT 100"
            );
            
            foreach ($discussions as $discussion) {
                $lastmod = date('Y-m-d', strtotime($discussion['updated_at']));
                echo $this->renderUrl(
                    $baseUrl . '/community/discussion/' . $discussion['id'],
                    $lastmod,
                    'weekly',
                    '0.5'
                );
            }
        } catch (\Exception $e) {
            error_log("Sitemap discussions error: " . $e->getMessage());
        }
        
        // End XML
        echo '</urlset>';
    }
    
    /**
     * Render a single URL entry
     */
    private function renderUrl($loc, $lastmod, $changefreq, $priority)
    {
        $xml = "  <url>\n";
        $xml .= "    <loc>" . htmlspecialchars($loc) . "</loc>\n";
        $xml .= "    <lastmod>" . $lastmod . "</lastmod>\n";
        $xml .= "    <changefreq>" . $changefreq . "</changefreq>\n";
        $xml .= "    <priority>" . $priority . "</priority>\n";
        $xml .= "  </url>\n";
        
        return $xml;
    }
    
    /**
     * Generate robots.txt
     */
    public function robots()
    {
        header('Content-Type: text/plain; charset=utf-8');
        
        $baseUrl = rtrim($_ENV['APP_URL'] ?? 'https://nebatech.com', '/');
        
        echo "User-agent: *\n";
        echo "Allow: /\n";
        echo "Disallow: /admin/\n";
        echo "Disallow: /api/\n";
        echo "Disallow: /dashboard/\n";
        echo "Disallow: /login\n";
        echo "Disallow: /register\n";
        echo "\n";
        echo "Sitemap: {$baseUrl}/sitemap.xml\n";
    }
}
