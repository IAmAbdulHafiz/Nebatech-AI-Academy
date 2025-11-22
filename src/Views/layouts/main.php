<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Nebatech AI Academy' ?> - Nebatech AI Academy</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= $description ?? 'Learn coding and IT skills with AI-powered personalized learning. Free courses in Web Development, Python, AI/ML, Cybersecurity and more. Get job-ready in weeks.' ?>">
    <meta name="keywords" content="<?= $keywords ?? 'online coding courses, learn programming, AI learning platform, free coding bootcamp, web development, python, machine learning, cybersecurity, tech education Africa' ?>">
    <meta name="author" content="Nebatech AI Academy">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= $canonical ?? base_url() ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $ogUrl ?? base_url() ?>">
    <meta property="og:title" content="<?= $ogTitle ?? 'Nebatech AI Academy - Free AI-Powered Tech Education' ?>">
    <meta property="og:description" content="<?= $ogDescription ?? 'Master coding and IT skills with our free AI-powered learning platform. Join 10,000+ students learning web development, Python, AI/ML, and more.' ?>">
    <meta property="og:image" content="<?= $ogImage ?? asset('images/og-image.jpg') ?>">
    <meta property="og:site_name" content="Nebatech AI Academy">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= $twitterUrl ?? base_url() ?>">
    <meta property="twitter:title" content="<?= $twitterTitle ?? 'Nebatech AI Academy - Free AI-Powered Tech Education' ?>">
    <meta property="twitter:description" content="<?= $twitterDescription ?? 'Master coding and IT skills with our free AI-powered learning platform. Get job-ready in weeks.' ?>">
    <meta property="twitter:image" content="<?= $twitterImage ?? asset('images/twitter-card.jpg') ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('images/apple-touch-icon.png') ?>">
    
    <!-- Preconnect to external domains for performance -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <!-- Alpine.js Collapse Plugin (must load before Alpine core) -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="<?= asset('js/theme-toggle.js') ?>"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <?php include __DIR__ . '/../partials/header.php'; ?>
    
    <main>
        <?php echo $content ?? ''; ?>
    </main>
    
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
