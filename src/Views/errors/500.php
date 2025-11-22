<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error | Nebatech AI Academy</title>
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="min-h-screen flex items-center justify-center px-6 py-20">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Error Illustration -->
            <div class="mb-8">
                <div class="text-9xl font-bold text-red-500 opacity-20">500</div>
            </div>

            <!-- Error Icon -->
            <div class="mb-8">
                <div class="w-32 h-32 mx-auto bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-6xl text-red-500"></i>
                </div>
            </div>

            <!-- Error Message -->
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                Something Went Wrong
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">
                We're experiencing technical difficulties. Our team has been notified and is working on it.
            </p>

            <!-- Error Details (if in development mode) -->
            <?php if (isset($error) && getenv('APP_ENV') === 'development'): ?>
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6 mb-8 text-left">
                <h3 class="font-bold text-red-800 dark:text-red-400 mb-2">Error Details:</h3>
                <pre class="text-sm text-red-700 dark:text-red-300 overflow-x-auto"><?= htmlspecialchars($error) ?></pre>
            </div>
            <?php endif; ?>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                <a href="javascript:window.location.reload()" 
                   class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-sync-alt"></i>
                    <span>Try Again</span>
                </a>
                <a href="<?= url('/') ?>" 
                   class="inline-flex items-center justify-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-8 py-4 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-home"></i>
                    <span>Go Home</span>
                </a>
                <a href="<?= url('/support') ?>" 
                   class="inline-flex items-center justify-center gap-2 bg-secondary hover:bg-orange-600 text-white px-8 py-4 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-life-ring"></i>
                    <span>Get Support</span>
                </a>
            </div>

            <!-- Support Info -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Need Help?
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    If the problem persists, please contact our support team:
                </p>
                <div class="flex flex-col md:flex-row gap-4 justify-center">
                    <a href="mailto:support@nebatech.com" 
                       class="flex items-center justify-center gap-2 text-primary hover:text-primary/80 font-semibold">
                        <i class="fas fa-envelope"></i>
                        <span>support@nebatech.com</span>
                    </a>
                    <a href="tel:+233249241156" 
                       class="flex items-center justify-center gap-2 text-primary hover:text-primary/80 font-semibold">
                        <i class="fas fa-phone"></i>
                        <span>+233 24 924 1156</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
