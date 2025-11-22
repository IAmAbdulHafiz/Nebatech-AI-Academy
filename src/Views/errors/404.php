<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | Nebatech AI Academy</title>
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <?php include __DIR__ . '/partials/header.php'; ?>

    <div class="min-h-screen flex items-center justify-center px-6 py-20">
        <div class="max-w-2xl mx-auto text-center">
            <!-- 404 Illustration -->
            <div class="mb-8">
                <div class="text-9xl font-bold text-primary opacity-20">404</div>
            </div>

            <!-- Error Icon -->
            <div class="mb-8">
                <div class="w-32 h-32 mx-auto bg-primary/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-search text-6xl text-primary"></i>
                </div>
            </div>

            <!-- Error Message -->
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                Page Not Found
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">
                Sorry, we couldn't find the page you're looking for. It might have been moved or deleted.
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                <a href="<?= url('/') ?>" 
                   class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-home"></i>
                    <span>Go Home</span>
                </a>
                <a href="<?= url('/courses') ?>" 
                   class="inline-flex items-center justify-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-8 py-4 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Browse Courses</span>
                </a>
                <a href="<?= url('/contact') ?>" 
                   class="inline-flex items-center justify-center gap-2 bg-secondary hover:bg-orange-600 text-white px-8 py-4 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-envelope"></i>
                    <span>Contact Us</span>
                </a>
            </div>

            <!-- Helpful Links -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                    You might be interested in:
                </h2>
                <div class="grid md:grid-cols-2 gap-6 text-left">
                    <a href="<?= url('/courses') ?>" 
                       class="flex items-start gap-4 p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                        <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-primary/20 transition-colors">
                            <i class="fas fa-book-open text-2xl text-primary"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1 group-hover:text-primary transition-colors">
                                Our Courses
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Explore our comprehensive tech courses
                            </p>
                        </div>
                    </a>

                    <a href="<?= url('/blog') ?>" 
                       class="flex items-start gap-4 p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                        <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-primary/20 transition-colors">
                            <i class="fas fa-newspaper text-2xl text-primary"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1 group-hover:text-primary transition-colors">
                                Blog & Resources
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Read articles and tutorials
                            </p>
                        </div>
                    </a>

                    <a href="<?= url('/community') ?>" 
                       class="flex items-start gap-4 p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                        <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-primary/20 transition-colors">
                            <i class="fas fa-users text-2xl text-primary"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1 group-hover:text-primary transition-colors">
                                Community
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Connect with fellow learners
                            </p>
                        </div>
                    </a>

                    <a href="<?= url('/faqs') ?>" 
                       class="flex items-start gap-4 p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                        <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-primary/20 transition-colors">
                            <i class="fas fa-question-circle text-2xl text-primary"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1 group-hover:text-primary transition-colors">
                                FAQs
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Find answers to common questions
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Search Box -->
            <div class="mt-12">
                <form action="<?= url('/search') ?>" method="GET" class="max-w-xl mx-auto">
                    <div class="relative">
                        <input type="text" 
                               name="q" 
                               placeholder="Search for courses, articles, or resources..." 
                               class="w-full px-6 py-4 pr-12 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-primary focus:outline-none">
                        <button type="submit" 
                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-primary hover:bg-primary/90 text-white p-3 rounded-lg transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
