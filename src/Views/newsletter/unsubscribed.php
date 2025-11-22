<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unsubscribed | Nebatech AI Academy</title>
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="min-h-screen flex items-center justify-center px-6 py-20">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Success Icon -->
            <div class="mb-8">
                <div class="w-32 h-32 mx-auto bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-6xl text-green-500"></i>
                </div>
            </div>

            <!-- Message -->
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                You've Been Unsubscribed
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">
                <?php if (isset($email)): ?>
                    <strong><?= htmlspecialchars($email) ?></strong> has been removed from our newsletter list.
                <?php else: ?>
                    You have been successfully unsubscribed from our newsletter.
                <?php endif; ?>
            </p>

            <!-- Feedback Box -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    We're Sorry to See You Go
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    We'd love to hear your feedback. What made you unsubscribe?
                </p>
                
                <!-- Feedback Form -->
                <form action="<?= url('/newsletter/feedback') ?>" method="POST" class="space-y-4">
                    <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>">
                    
                    <div class="space-y-2 text-left">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="reason[]" value="too_frequent" class="w-5 h-5 text-primary">
                            <span class="text-gray-700 dark:text-gray-300">Too many emails</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="reason[]" value="not_relevant" class="w-5 h-5 text-primary">
                            <span class="text-gray-700 dark:text-gray-300">Content not relevant</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="reason[]" value="never_signed_up" class="w-5 h-5 text-primary">
                            <span class="text-gray-700 dark:text-gray-300">Never signed up</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="reason[]" value="other" class="w-5 h-5 text-primary">
                            <span class="text-gray-700 dark:text-gray-300">Other reason</span>
                        </label>
                    </div>
                    
                    <textarea name="comments" 
                              placeholder="Additional comments (optional)" 
                              class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary" 
                              rows="4"></textarea>
                    
                    <button type="submit" 
                            class="bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                        Submit Feedback
                    </button>
                </form>
            </div>

            <!-- Re-subscribe Option -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                    Changed Your Mind?
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    You can resubscribe anytime to get the latest updates on AI, courses, and opportunities.
                </p>
                <form action="<?= url('/newsletter/subscribe') ?>" method="POST" class="flex gap-2">
                    <input type="email" 
                           name="email" 
                           value="<?= htmlspecialchars($email ?? '') ?>"
                           placeholder="Enter your email" 
                           required
                           class="flex-1 px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary">
                    <input type="hidden" name="source" value="unsubscribe_page">
                    <button type="submit" 
                            class="bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-lg font-semibold transition-colors whitespace-nowrap">
                        Subscribe Again
                    </button>
                </form>
            </div>

            <!-- Navigation -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?= url('/') ?>" 
                   class="inline-flex items-center justify-center gap-2 text-primary hover:text-primary/80 font-semibold">
                    <i class="fas fa-home"></i>
                    <span>Back to Homepage</span>
                </a>
                <a href="<?= url('/courses') ?>" 
                   class="inline-flex items-center justify-center gap-2 text-primary hover:text-primary/80 font-semibold">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Browse Courses</span>
                </a>
                <a href="<?= url('/blog') ?>" 
                   class="inline-flex items-center justify-center gap-2 text-primary hover:text-primary/80 font-semibold">
                    <i class="fas fa-blog"></i>
                    <span>Read Our Blog</span>
                </a>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
