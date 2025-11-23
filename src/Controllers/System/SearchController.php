<?php

namespace Nebatech\Controllers\System;

use Nebatech\Core\Controller;
use Nebatech\Services\UnifiedSearchService;
use Nebatech\Services\UserContextService;

/**
 * Search Controller
 * Handles unified search across courses, services, and content
 */
class SearchController extends Controller
{
    private $searchService;
    
    public function __construct()
    {
        parent::__construct();
        $this->searchService = new UnifiedSearchService();
    }
    
    /**
     * Main search page
     */
    public function index()
    {
        $query = $_GET['q'] ?? '';
        $filters = $this->getFiltersFromRequest();
        
        $results = [];
        $suggestions = [];
        
        if (!empty($query)) {
            $results = $this->searchService->search($query, $filters);
        } else {
            // Show popular content when no query
            $results = $this->searchService->search('', $filters);
        }
        
        // Get search suggestions for autocomplete
        if (!empty($query) && strlen($query) >= 2) {
            $suggestions = $this->searchService->getSuggestions($query);
        }
        
        $currentSection = UserContextService::getCurrentSection();
        $userContext = UserContextService::getUserContext();
        
        return $this->view('search/index', [
            'title' => !empty($query) ? "Search Results for '{$query}'" : 'Search',
            'query' => $query,
            'results' => $results,
            'suggestions' => $suggestions,
            'filters' => $filters,
            'currentSection' => $currentSection,
            'userContext' => $userContext,
            'searchPlaceholder' => UserContextService::getSearchPlaceholder($currentSection)
        ]);
    }
    
    /**
     * AJAX search suggestions
     */
    public function suggestions()
    {
        $query = $_GET['q'] ?? '';
        
        if (strlen($query) < 2) {
            return $this->json([]);
        }
        
        $suggestions = $this->searchService->getSuggestions($query);
        
        return $this->json($suggestions);
    }
    
    /**
     * AJAX search results
     */
    public function ajax()
    {
        $query = $_GET['q'] ?? '';
        $filters = $this->getFiltersFromRequest();
        
        $results = $this->searchService->search($query, $filters);
        
        return $this->json([
            'success' => true,
            'results' => $results,
            'query' => $query,
            'total' => $results['total_count']
        ]);
    }
    
    /**
     * Get related content for cross-promotion
     */
    public function related()
    {
        $contentType = $_GET['type'] ?? '';
        $contentId = (int)($_GET['id'] ?? 0);
        
        if (empty($contentType) || empty($contentId)) {
            return $this->json(['error' => 'Invalid parameters']);
        }
        
        $relatedContent = $this->searchService->getRelatedContent($contentType, $contentId);
        
        return $this->json([
            'success' => true,
            'related' => $relatedContent
        ]);
    }
    
    /**
     * Search within specific category
     */
    public function category()
    {
        $category = $_GET['category'] ?? '';
        $query = $_GET['q'] ?? '';
        
        $filters = $this->getFiltersFromRequest();
        $filters['category'] = $category;
        
        $results = $this->searchService->search($query, $filters);
        
        return $this->view('search/category', [
            'title' => "Search in " . ucfirst($category),
            'category' => $category,
            'query' => $query,
            'results' => $results,
            'filters' => $filters
        ]);
    }
    
    /**
     * Extract filters from request
     */
    private function getFiltersFromRequest(): array
    {
        return [
            'category' => $_GET['category'] ?? '',
            'service_category' => $_GET['service_category'] ?? '',
            'level' => $_GET['level'] ?? '',
            'type' => $_GET['type'] ?? '', // course, service, blog
            'price' => $_GET['price'] ?? '',
            'duration' => $_GET['duration'] ?? '',
            'featured' => isset($_GET['featured']) ? (bool)$_GET['featured'] : null
        ];
    }
}
