<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Services\PortfolioService;
use Nebatech\Middleware\AuthMiddleware;

class PortfolioController extends Controller
{
    private PortfolioService $portfolioService;

    public function __construct()
    {
        $this->portfolioService = new PortfolioService();
    }

    /**
     * Show user's portfolio
     */
    public function myPortfolio(): void
    {
        try {
            $userId = AuthMiddleware::userId();
            $user = \Nebatech\Models\User::findById($userId);
            $portfolio = $this->portfolioService->getUserPortfolio($userId);
            $stats = $this->portfolioService->getUserStats($userId);

            echo $this->view('portfolio/my-portfolio', [
                'portfolio' => $portfolio ?? [],
                'stats' => $stats ?? ['total_projects' => 0, 'public_projects' => 0, 'featured_projects' => 0],
                'user' => $user
            ]);
        } catch (\Exception $e) {
            error_log("Error in myPortfolio: " . $e->getMessage());
            $userId = AuthMiddleware::userId();
            $user = \Nebatech\Models\User::findById($userId);
            echo $this->view('portfolio/my-portfolio', [
                'portfolio' => [],
                'stats' => ['total_projects' => 0, 'public_projects' => 0, 'featured_projects' => 0],
                'user' => $user ?? []
            ]);
        }
    }

    /**
     * Show public portfolio for a user
     */
    public function viewUserPortfolio(int $userId): void
    {
        $portfolio = $this->portfolioService->getUserPortfolio($userId, true);
        
        if (empty($portfolio)) {
            $this->redirect('/?error=portfolio_not_found');
            return;
        }

        $stats = $this->portfolioService->getUserStats($userId);
        $currentUserId = AuthMiddleware::userId();
        $currentUser = \Nebatech\Models\User::findById($currentUserId);

        echo $this->view('portfolio/public-portfolio', [
            'portfolio' => $portfolio,
            'stats' => $stats,
            'userId' => $userId,
            'user' => $currentUser
        ]);
    }

    /**
     * Portfolio showcase (all public portfolios)
     */
    public function showcase(): void
    {
        try {
            $userId = AuthMiddleware::userId();
            $user = \Nebatech\Models\User::findById($userId);
            $featured = $this->portfolioService->getFeaturedPortfolios();
            $portfolios = $this->portfolioService->getPublicPortfolios();

            echo $this->view('portfolio/showcase', [
                'featured' => $featured ?? [],
                'portfolios' => $portfolios ?? [],
                'user' => $user
            ]);
        } catch (\Exception $e) {
            error_log("Error in showcase: " . $e->getMessage());
            $userId = AuthMiddleware::userId();
            $user = \Nebatech\Models\User::findById($userId);
            echo $this->view('portfolio/showcase', [
                'featured' => [],
                'portfolios' => [],
                'user' => $user ?? []
            ]);
        }
    }

    /**
     * Create portfolio entry
     */
    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/my-portfolio');
            return;
        }

        $userId = AuthMiddleware::userId();
        $submissionId = (int)($_POST['submission_id'] ?? 0);

        if (!$submissionId) {
            $this->jsonResponse(['error' => 'Submission ID required'], 400);
            return;
        }

        $data = [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'project_url' => $_POST['project_url'] ?? null,
            'thumbnail' => $_POST['thumbnail'] ?? null,
            'technologies' => $_POST['technologies'] ?? [],
            'is_public' => isset($_POST['is_public']) ? (bool)$_POST['is_public'] : true
        ];

        $portfolioId = $this->portfolioService->createFromSubmission($userId, $submissionId, $data);

        if ($portfolioId) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Portfolio entry created',
                'portfolio_id' => $portfolioId
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to create portfolio entry'], 500);
        }
    }

    /**
     * Update portfolio entry
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/my-portfolio');
            return;
        }

        $userId = AuthMiddleware::userId();
        $portfolioId = (int)($_POST['portfolio_id'] ?? 0);

        if (!$portfolioId) {
            $this->jsonResponse(['error' => 'Portfolio ID required'], 400);
            return;
        }

        $data = [
            'title' => $_POST['title'] ?? null,
            'description' => $_POST['description'] ?? null,
            'project_url' => $_POST['project_url'] ?? null,
            'thumbnail' => $_POST['thumbnail'] ?? null,
            'technologies' => $_POST['technologies'] ?? null,
            'is_public' => isset($_POST['is_public']) ? (bool)$_POST['is_public'] : null
        ];

        // Remove null values
        $data = array_filter($data, fn($value) => $value !== null);

        $success = $this->portfolioService->update($portfolioId, $userId, $data);

        if ($success) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Portfolio entry updated'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to update portfolio entry'], 500);
        }
    }

    /**
     * Delete portfolio entry
     */
    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/my-portfolio');
            return;
        }

        $userId = AuthMiddleware::userId();
        $portfolioId = (int)($_POST['portfolio_id'] ?? 0);

        if (!$portfolioId) {
            $this->jsonResponse(['error' => 'Portfolio ID required'], 400);
            return;
        }

        $success = $this->portfolioService->delete($portfolioId, $userId);

        if ($success) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Portfolio entry deleted'
            ]);
        } else {
            $this->jsonResponse(['error' => 'Failed to delete portfolio entry'], 500);
        }
    }

    /**
     * JSON response helper
     */
    protected function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
