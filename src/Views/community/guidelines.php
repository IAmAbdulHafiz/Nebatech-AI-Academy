<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Guidelines - Nebatech AI Academy</title>
    
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="<?= asset('js/theme-toggle.js') ?>"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-3">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Community Guidelines
        </h1>
        <p class="text-gray-600 dark:text-gray-400">
            Help us maintain a respectful, inclusive, and productive community
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Introduction -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
                <div class="prose dark:prose-invert max-w-none">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Welcome to Our Community</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        Nebatech AI Academy is a place for learning, sharing, and growing together. These guidelines help ensure that our community remains a safe, welcoming, and productive space for everyone.
                    </p>
                </div>
            </div>

            <!-- Core Values -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                    <svg class="w-7 h-7 text-primary" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l2.4 7.4h7.6l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/>
                    </svg>
                    Core Values
                </h2>
                <div class="space-y-4">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Be Respectful</h3>
                            <p class="text-gray-600 dark:text-gray-400">Treat everyone with respect and kindness. No harassment, hate speech, or discrimination.</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Be Helpful</h3>
                            <p class="text-gray-600 dark:text-gray-400">Share your knowledge and help others learn. Answer questions thoughtfully and constructively.</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Stay On Topic</h3>
                            <p class="text-gray-600 dark:text-gray-400">Keep discussions relevant to AI, technology, and learning. Use appropriate categories.</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Give Credit</h3>
                            <p class="text-gray-600 dark:text-gray-400">Cite sources and give credit where it's due. Don't plagiarize or claim others' work as your own.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Do's and Don'ts -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Do's and Don'ts</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Do's -->
                    <div>
                        <h3 class="text-lg font-semibold text-green-600 dark:text-green-400 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                            </svg>
                            Do
                        </h3>
                        <ul class="space-y-3 text-gray-600 dark:text-gray-400">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                </svg>
                                Search before posting to avoid duplicates
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                </svg>
                                Write clear, descriptive titles
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                </svg>
                                Format code properly using markdown
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                </svg>
                                Mark helpful answers as solutions
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                </svg>
                                Welcome and encourage beginners
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                </svg>
                                Provide constructive feedback
                            </li>
                        </ul>
                    </div>

                    <!-- Don'ts -->
                    <div>
                        <h3 class="text-lg font-semibold text-red-600 dark:text-red-400 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                            </svg>
                            Don't
                        </h3>
                        <ul class="space-y-3 text-gray-600 dark:text-gray-400">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                                </svg>
                                Post spam or promotional content
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                                </svg>
                                Share personal or confidential information
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                                </svg>
                                Use offensive or inappropriate language
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                                </svg>
                                Demand help or be impatient
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                                </svg>
                                Cross-post the same content multiple times
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                                </svg>
                                Engage in heated arguments or trolling
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Posting Best Practices -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Posting Best Practices</h2>
                <div class="space-y-4">
                    <div class="border-l-4 border-primary/90 pl-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">For Questions</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-400 text-sm">
                            <li>• Provide context and explain what you've tried</li>
                            <li>• Include relevant code snippets or error messages</li>
                            <li>• Specify your environment (OS, versions, etc.)</li>
                            <li>• Mark the best answer as "Solution" when resolved</li>
                        </ul>
                    </div>

                    <div class="border-l-4 border-purple-500 pl-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">For Discussions</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-400 text-sm">
                            <li>• Present clear points and invite diverse perspectives</li>
                            <li>• Stay open-minded to different viewpoints</li>
                            <li>• Back up claims with sources or examples</li>
                            <li>• Keep the conversation constructive</li>
                        </ul>
                    </div>

                    <div class="border-l-4 border-green-500 pl-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">For Projects</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-400 text-sm">
                            <li>• Describe your project's purpose and features</li>
                            <li>• Share screenshots or demos when possible</li>
                            <li>• Link to repositories or live demos</li>
                            <li>• Welcome feedback and collaboration</li>
                        </ul>
                    </div>

                    <div class="border-l-4 border-yellow-500 pl-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">For Resources</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-400 text-sm">
                            <li>• Explain why the resource is valuable</li>
                            <li>• Provide context on difficulty level or prerequisites</li>
                            <li>• Tag appropriately for easy discovery</li>
                            <li>• Respect copyright and licensing</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Reporting & Moderation -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Reporting & Moderation</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    If you see content that violates these guidelines, please report it using the report button. Our moderation team will review all reports promptly.
                </p>
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 p-4 rounded">
                    <div class="flex gap-3">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white mb-1">Consequences of Violations</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Depending on the severity, violations may result in warnings, temporary suspensions, or permanent bans. We aim to be fair and will consider the context of each situation.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-4 space-y-6">
                <!-- Quick Links -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h3>
                    <div class="space-y-3">
                        <a href="<?= url('/community') ?>" 
                           class="flex items-center gap-2 text-primary hover:underline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                            Back to Community
                        </a>
                        <a href="<?= url('/community/create') ?>" 
                           class="flex items-center gap-2 text-primary hover:underline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                            Start a Discussion
                        </a>
                        <a href="<?= url('/contact') ?>" 
                           class="flex items-center gap-2 text-primary hover:underline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                            Contact Support
                        </a>
                    </div>
                </div>

                <!-- Need Help? -->
                <div class="bg-blue-50 dark:bg-primary/90/20 rounded-lg p-6">
                    <div class="flex items-start gap-3 mb-4">
                        <svg class="w-6 h-6 text-primary dark:text-primary/80 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Need Help?</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                Have questions about these guidelines? Contact our support team.
                            </p>
                            <a href="<?= url('/contact') ?>" 
                               class="inline-flex items-center gap-2 text-sm text-primary dark:text-primary/80 hover:underline">
                                Get Support
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Last Updated -->
                <div class="text-sm text-gray-500 dark:text-gray-400 text-center">
                    Last updated: November 2025
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>


