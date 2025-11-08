<?php
$user = $portfolio['user'];
$settings = $portfolio['settings'];
$items = $portfolio['items'];
$certificates = $portfolio['certificates'];
$badges = $portfolio['badges'];
$badgeStats = $portfolio['badge_stats'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?> - Portfolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .badge-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        .project-card:hover {
            transform: translateY(-3px);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="gradient-bg text-white py-20">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between mb-8">
                <a href="<?= url('/') ?>" class="text-white hover:text-gray-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Home
                </a>
                
                <?php if ($is_owner): ?>
                    <a href="<?= url('/portfolio/manage') ?>" class="bg-white text-purple-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-edit mr-2"></i>Edit Portfolio
                    </a>
                <?php endif; ?>
            </div>
            
            <div class="text-center">
                <!-- Avatar -->
                <div class="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden border-4 border-white shadow-xl">
                    <?php if (!empty($user['avatar_url'])): ?>
                        <img src="<?= htmlspecialchars($user['avatar_url']) ?>" alt="Avatar" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full bg-white text-purple-600 flex items-center justify-center text-4xl font-bold">
                            <?= strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Name & Tagline -->
                <h1 class="text-4xl font-bold mb-2">
                    <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>
                </h1>
                
                <?php if (!empty($settings['tagline'])): ?>
                    <p class="text-xl text-purple-100 mb-6"><?= htmlspecialchars($settings['tagline']) ?></p>
                <?php endif; ?>
                
                <?php if (!empty($settings['bio'])): ?>
                    <p class="text-white/90 max-w-2xl mx-auto mb-8">
                        <?= nl2br(htmlspecialchars($settings['bio'])) ?>
                    </p>
                <?php endif; ?>
                
                <!-- Stats -->
                <div class="flex justify-center gap-8 mb-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold"><?= count($items) ?></div>
                        <div class="text-purple-100">Projects</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold"><?= count($certificates) ?></div>
                        <div class="text-purple-100">Certificates</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold"><?= $badgeStats['total_badges'] ?></div>
                        <div class="text-purple-100">Badges</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold"><?= $badgeStats['total_points'] ?></div>
                        <div class="text-purple-100">Points</div>
                    </div>
                </div>
                
                <!-- Social Links -->
                <?php if ($settings['show_contact']): ?>
                    <div class="flex justify-center gap-4">
                        <?php if (!empty($settings['github_url'])): ?>
                            <a href="<?= htmlspecialchars($settings['github_url']) ?>" target="_blank" 
                               class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition">
                                <i class="fab fa-github mr-2"></i>GitHub
                            </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($settings['linkedin_url'])): ?>
                            <a href="<?= htmlspecialchars($settings['linkedin_url']) ?>" target="_blank" 
                               class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition">
                                <i class="fab fa-linkedin mr-2"></i>LinkedIn
                            </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($settings['twitter_url'])): ?>
                            <a href="<?= htmlspecialchars($settings['twitter_url']) ?>" target="_blank" 
                               class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition">
                                <i class="fab fa-twitter mr-2"></i>Twitter
                            </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($settings['website_url'])): ?>
                            <a href="<?= htmlspecialchars($settings['website_url']) ?>" target="_blank" 
                               class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition">
                                <i class="fas fa-globe mr-2"></i>Website
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-12">
        <!-- Projects Section -->
        <?php if (!empty($items)): ?>
            <section class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center">
                    <i class="fas fa-code text-purple-600 mr-3"></i>
                    Featured Projects
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($items as $item): ?>
                        <div class="project-card bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl">
                            <?php if ($item['thumbnail_path']): ?>
                                <img src="<?= htmlspecialchars($item['thumbnail_path']) ?>" alt="Project thumbnail" class="w-full h-48 object-cover">
                            <?php else: ?>
                                <div class="w-full h-48 gradient-bg flex items-center justify-center text-white text-6xl">
                                    <i class="fas fa-code"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">
                                    <?= htmlspecialchars($item['title']) ?>
                                </h3>
                                
                                <?php if ($item['description']): ?>
                                    <p class="text-gray-600 mb-4 line-clamp-2">
                                        <?= htmlspecialchars($item['description']) ?>
                                    </p>
                                <?php endif; ?>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-sm text-gray-500">
                                        <i class="fas fa-book mr-1"></i>
                                        <?= htmlspecialchars($item['course_title']) ?>
                                    </span>
                                    
                                    <?php if ($item['score'] && $item['max_score']): ?>
                                        <span class="text-sm font-semibold text-purple-600">
                                            Score: <?= round(($item['score'] / $item['max_score']) * 100) ?>%
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">
                                        <i class="fas fa-eye mr-1"></i>
                                        <?= $item['views'] ?> views
                                    </span>
                                    
                                    <a href="<?= url('/portfolio/items/' . $item['id']) ?>" 
                                       class="text-purple-600 hover:text-purple-700 font-semibold">
                                        View Project <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
        
        <!-- Badges Section -->
        <?php if ($settings['show_badges'] && !empty($badges)): ?>
            <section class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center">
                    <i class="fas fa-trophy text-yellow-500 mr-3"></i>
                    Achievements & Badges
                </h2>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($badges as $badge): ?>
                        <div class="badge-card bg-white rounded-xl shadow-md p-6 text-center transition-all duration-300">
                            <div class="text-5xl mb-3">
                                <?php if (strpos($badge['icon'], 'fa-') === 0): ?>
                                    <i class="fas <?= htmlspecialchars($badge['icon']) ?> text-purple-600"></i>
                                <?php else: ?>
                                    🏆
                                <?php endif; ?>
                            </div>
                            
                            <h3 class="font-bold text-gray-900 mb-1">
                                <?= htmlspecialchars($badge['name']) ?>
                            </h3>
                            
                            <p class="text-xs text-gray-600 mb-3">
                                <?= htmlspecialchars($badge['description']) ?>
                            </p>
                            
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-purple-600 font-semibold">
                                    <?= $badge['points'] ?> pts
                                </span>
                                <span class="text-gray-400">
                                    <?= date('M Y', strtotime($badge['earned_at'])) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
        
        <!-- Certificates Section -->
        <?php if ($settings['show_certificates'] && !empty($certificates)): ?>
            <section class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center">
                    <i class="fas fa-certificate text-blue-600 mr-3"></i>
                    Certificates
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php foreach ($certificates as $cert): ?>
                        <div class="bg-white rounded-xl shadow-md overflow-hidden border-2 border-gray-100 hover:border-purple-300 transition">
                            <div class="gradient-bg text-white p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <i class="fas fa-certificate text-5xl text-white/80"></i>
                                    <span class="bg-white/20 px-3 py-1 rounded-full text-sm">
                                        Verified
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold">
                                    <?= htmlspecialchars($cert['course_title']) ?>
                                </h3>
                            </div>
                            
                            <div class="p-6">
                                <div class="space-y-2 mb-4">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Certificate ID:</span>
                                        <span class="font-mono text-gray-900"><?= htmlspecialchars($cert['certificate_number']) ?></span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Issue Date:</span>
                                        <span class="text-gray-900"><?= date('F j, Y', strtotime($cert['issue_date'])) ?></span>
                                    </div>
                                </div>
                                
                                <div class="flex gap-2">
                                    <?php if ($is_owner && $cert['pdf_path']): ?>
                                        <a href="<?= url('/certificates/' . $cert['id'] . '/download') ?>" 
                                           class="flex-1 bg-purple-600 text-white text-center px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                                            <i class="fas fa-download mr-2"></i>Download
                                        </a>
                                    <?php endif; ?>
                                    
                                    <a href="<?= url('/certificates/verify/' . $cert['verification_code']) ?>" 
                                       class="flex-1 bg-gray-100 text-gray-700 text-center px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                                        <i class="fas fa-check-circle mr-2"></i>Verify
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
        
        <!-- Empty State -->
        <?php if (empty($items) && empty($badges) && empty($certificates)): ?>
            <div class="text-center py-20">
                <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-600 mb-2">Portfolio Coming Soon</h3>
                <p class="text-gray-500">This portfolio is still being built. Check back soon!</p>
            </div>
        <?php endif; ?>
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 mt-20">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="text-gray-400">
                Powered by <strong class="text-white">Nebatech AI Academy</strong>
            </p>
            <p class="text-sm text-gray-500 mt-2">
                Member since <?= date('F Y', strtotime($user['created_at'])) ?>
            </p>
        </div>
    </footer>
</body>
</html>
