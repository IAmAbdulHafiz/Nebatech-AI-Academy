<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start a Discussion - Nebatech AI Academy</title>
    
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
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Start a Discussion
        </h1>
        <p class="text-gray-600 dark:text-gray-400">
            Share your knowledge, ask questions, or start a conversation with the community
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <form id="create-post-form" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-8 space-y-6">
                <!-- Post Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                        Post Type <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <label class="relative flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary transition-colors">
                            <input type="radio" name="type" value="question" checked class="sr-only peer">
                            <div class="peer-checked:border-primary peer-checked:bg-primary/10 absolute inset-0 rounded-lg border-2"></div>
                            <div class="relative flex items-center space-x-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="font-medium text-gray-900 dark:text-white">Question</span>
                            </div>
                        </label>

                        <label class="relative flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary transition-colors">
                            <input type="radio" name="type" value="discussion" class="sr-only peer">
                            <div class="peer-checked:border-primary peer-checked:bg-primary/10 absolute inset-0 rounded-lg border-2"></div>
                            <div class="relative flex items-center space-x-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                <span class="font-medium text-gray-900 dark:text-white">Discussion</span>
                            </div>
                        </label>

                        <label class="relative flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary transition-colors">
                            <input type="radio" name="type" value="project" class="sr-only peer">
                            <div class="peer-checked:border-primary peer-checked:bg-primary/10 absolute inset-0 rounded-lg border-2"></div>
                            <div class="relative flex items-center space-x-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                <span class="font-medium text-gray-900 dark:text-white">Project</span>
                            </div>
                        </label>

                        <label class="relative flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary transition-colors">
                            <input type="radio" name="type" value="resource" class="sr-only peer">
                            <div class="peer-checked:border-primary peer-checked:bg-primary/10 absolute inset-0 rounded-lg border-2"></div>
                            <div class="relative flex items-center space-x-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                <span class="font-medium text-gray-900 dark:text-white">Resource</span>
                            </div>
                        </label>

                        <label class="relative flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary transition-colors">
                            <input type="radio" name="type" value="announcement" class="sr-only peer">
                            <div class="peer-checked:border-primary peer-checked:bg-primary/10 absolute inset-0 rounded-lg border-2"></div>
                            <div class="relative flex items-center space-x-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                <span class="font-medium text-gray-900 dark:text-white">Announcement</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select id="category" 
                            name="category_id" 
                            required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Select a category...</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>">
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Choose the most relevant category for your post
                    </p>
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           required
                           maxlength="255"
                           placeholder="e.g., How do I implement authentication in PHP?"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Be clear and specific with your title
                    </p>
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="content" 
                              name="content" 
                              required
                              rows="12"
                              placeholder="Provide details about your question, discussion topic, project, or resource. Be as specific as possible to get the best responses..."
                              class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent resize-none"></textarea>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Minimum 50 characters. You can use line breaks for formatting.
                    </p>
                </div>

                <!-- Tags -->
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tags (Optional)
                    </label>
                    <input type="text" 
                           id="tags" 
                           name="tags" 
                           placeholder="php, javascript, python (comma-separated)"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Add up to 5 tags to help others find your post
                    </p>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" 
                            onclick="window.history.back()"
                            class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white cursor-pointer">
                        Cancel
                    </button>
                    <div class="flex space-x-3">
                        <button type="button" 
                                onclick="saveDraft()"
                                class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors font-medium">
                            Save Draft
                        </button>
                        <button type="submit" 
                                class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors font-medium">
                            Publish Post
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Posting Guidelines -->
            <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-lg p-6 border border-white/20 dark:border-primary/80">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Posting Guidelines
                </h3>
                <ul class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Be clear and specific with your title</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Provide enough context and details</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Use proper formatting and tags</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Be respectful and constructive</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-red-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        <span>Avoid spam or promotional content</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-red-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        <span>Don't post duplicate questions</span>
                    </li>
                </ul>
            </div>

            <!-- Post Type Descriptions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Post Types</h3>
                <div class="space-y-4 text-sm">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white mb-1">Question</div>
                            <p class="text-gray-600 dark:text-gray-400">Ask for help or clarification on a topic</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white mb-1">Discussion</div>
                            <p class="text-gray-600 dark:text-gray-400">Start a conversation or debate on a topic</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white mb-1">Project</div>
                            <p class="text-gray-600 dark:text-gray-400">Showcase your work and get feedback</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white mb-1">Resource</div>
                            <p class="text-gray-600 dark:text-gray-400">Share useful learning materials</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white mb-1">Announcement</div>
                            <p class="text-gray-600 dark:text-gray-400">Important updates or news</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- XP Rewards -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-lg p-6 border border-yellow-200 dark:border-yellow-800">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/></svg>
                    Earn XP
                </h3>
                <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                    <li class="flex items-center justify-between">
                        <span>Create a post</span>
                        <span class="font-semibold text-yellow-600 dark:text-yellow-400">+10 XP</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span>Add a comment</span>
                        <span class="font-semibold text-yellow-600 dark:text-yellow-400">+5 XP</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span>Get your answer marked as solution</span>
                        <span class="font-semibold text-yellow-600 dark:text-yellow-400">+20 XP</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span>Share a resource</span>
                        <span class="font-semibold text-yellow-600 dark:text-yellow-400">+15 XP</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
// Form submission
document.getElementById('create-post-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const data = {
        type: formData.get('type'),
        category_id: formData.get('category_id'),
        title: formData.get('title'),
        content: formData.get('content'),
        tags: formData.get('tags') ? formData.get('tags').split(',').map(t => t.trim()).filter(t => t) : []
    };
    
    // Validation
    if (!data.category_id) {
        alert('Please select a category');
        return;
    }
    
    if (data.title.length < 10) {
        alert('Title must be at least 10 characters long');
        return;
    }
    
    if (data.content.length < 50) {
        alert('Description must be at least 50 characters long');
        return;
    }
    
    if (data.tags.length > 5) {
        alert('You can add up to 5 tags only');
        return;
    }
    
    try {
        const response = await fetch('<?= url('/community/create') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            window.location.href = result.redirect;
        } else {
            alert(result.message || 'Failed to create post');
        }
    } catch (error) {
        console.error('Error creating post:', error);
        alert('Failed to create post. Please try again.');
    }
});

// Save draft with server backup
async function saveDraft() {
    const formData = new FormData(document.getElementById('create-post-form'));
    const draft = {
        type: formData.get('type'),
        category_id: formData.get('category_id'),
        title: formData.get('title'),
        content: formData.get('content'),
        tags: formData.get('tags'),
        timestamp: new Date().toISOString()
    };
    
    // Save to localStorage
    localStorage.setItem('community_post_draft', JSON.stringify(draft));
    
    // Save to server
    try {
        const response = await fetch('/api/drafts/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(draft)
        });
        
        if (response.ok) {
            showToast('Draft saved successfully!', 'success');
        } else {
            showToast('Draft saved locally only', 'info');
        }
    } catch (error) {
        showToast('Draft saved locally only', 'info');
    }
}

// Auto-save every 30 seconds
let autoSaveInterval = setInterval(() => {
    const title = document.getElementById('title')?.value;
    const content = document.getElementById('content')?.value;
    if (title || content) {
        saveDraft();
    }
}, 30000);

// Load draft on page load
window.addEventListener('DOMContentLoaded', () => {
    const draft = localStorage.getItem('community_post_draft');
    if (draft) {
        const data = JSON.parse(draft);
        if (confirm('You have an unsaved draft. Would you like to continue editing it?')) {
            document.querySelector(`input[name="type"][value="${data.type}"]`).checked = true;
            document.getElementById('category').value = data.category_id;
            document.getElementById('title').value = data.title;
            document.getElementById('content').value = data.content;
            document.getElementById('tags').value = data.tags;
        } else {
            localStorage.removeItem('community_post_draft');
        }
    }
});

// Clear draft on successful submission
window.addEventListener('beforeunload', (e) => {
    // Only warn if form has content
    const form = document.getElementById('create-post-form');
    const title = form.querySelector('#title').value;
    const content = form.querySelector('#content').value;
    
    if ((title || content) && !window.formSubmitted) {
        e.preventDefault();
        e.returnValue = '';
    }
});
</script>

<style>
/* Custom radio button styling */
input[type="radio"]:checked + div {
    border-color: #3b82f6;
    background-color: rgba(59, 130, 246, 0.1);
}
</style>

<?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>

