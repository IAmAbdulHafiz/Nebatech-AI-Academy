<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course - Nebatech AI Academy</title>
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <!-- Alpine.js Collapse Plugin (must load before Alpine core) -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Header -->
        <div class="mb-8">
            <a href="<?= url('/facilitator/dashboard') ?>" class="text-primary hover:text-primary font-semibold mb-4 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Create New Course</h1>
            <p class="text-gray-600 mt-2">Fill in the details below to create a new course</p>
        </div>

        <!-- Course Creation Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form method="POST" action="<?= url('/facilitator/courses/create') ?>" enctype="multipart/form-data" class="space-y-6">
                
                <!-- Course Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Course Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           required 
                           value="<?= htmlspecialchars($oldInput['title'] ?? '') ?>"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                           placeholder="e.g., Complete Front-End Development Bootcamp">
                    <?php if (isset($errors['title'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $errors['title'] ?></p>
                    <?php endif; ?>
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select id="category" 
                            name="category" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent">
                        <option value="">Select a category</option>
                        <option value="frontend" <?= ($oldInput['category'] ?? '') === 'frontend' ? 'selected' : '' ?>>Frontend Development</option>
                        <option value="backend" <?= ($oldInput['category'] ?? '') === 'backend' ? 'selected' : '' ?>>Backend Development</option>
                        <option value="fullstack" <?= ($oldInput['category'] ?? '') === 'fullstack' ? 'selected' : '' ?>>Full Stack Development</option>
                        <option value="mobile" <?= ($oldInput['category'] ?? '') === 'mobile' ? 'selected' : '' ?>>Mobile Development</option>
                        <option value="ai" <?= ($oldInput['category'] ?? '') === 'ai' ? 'selected' : '' ?>>AI & Machine Learning</option>
                        <option value="data-science" <?= ($oldInput['category'] ?? '') === 'data-science' ? 'selected' : '' ?>>Data Science</option>
                        <option value="cybersecurity" <?= ($oldInput['category'] ?? '') === 'cybersecurity' ? 'selected' : '' ?>>Cybersecurity</option>
                        <option value="cloud" <?= ($oldInput['category'] ?? '') === 'cloud' ? 'selected' : '' ?>>Cloud Computing</option>
                        <option value="database" <?= ($oldInput['category'] ?? '') === 'database' ? 'selected' : '' ?>>Database Administration</option>
                        <option value="digital-literacy" <?= ($oldInput['category'] ?? '') === 'digital-literacy' ? 'selected' : '' ?>>Digital Literacy</option>
                    </select>
                    <?php if (isset($errors['category'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $errors['category'] ?></p>
                    <?php endif; ?>
                </div>

                <!-- Level -->
                <div>
                    <label for="level" class="block text-sm font-semibold text-gray-700 mb-2">
                        Difficulty Level <span class="text-red-500">*</span>
                    </label>
                    <select id="level" 
                            name="level" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent">
                        <option value="beginner" <?= ($oldInput['level'] ?? 'beginner') === 'beginner' ? 'selected' : '' ?>>Beginner</option>
                        <option value="intermediate" <?= ($oldInput['level'] ?? '') === 'intermediate' ? 'selected' : '' ?>>Intermediate</option>
                        <option value="advanced" <?= ($oldInput['level'] ?? '') === 'advanced' ? 'selected' : '' ?>>Advanced</option>
                    </select>
                </div>

                <!-- Duration -->
                <div>
                    <label for="duration_hours" class="block text-sm font-semibold text-gray-700 mb-2">
                        Estimated Duration (Hours) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="duration_hours" 
                           name="duration_hours" 
                           required 
                           min="1"
                           value="<?= htmlspecialchars($oldInput['duration_hours'] ?? '') ?>"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                           placeholder="e.g., 40">
                    <?php if (isset($errors['duration_hours'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $errors['duration_hours'] ?></p>
                    <?php endif; ?>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Course Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" 
                              name="description" 
                              required 
                              rows="6"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                              placeholder="Provide a detailed description of what students will learn in this course..."><?= htmlspecialchars($oldInput['description'] ?? '') ?></textarea>
                    <?php if (isset($errors['description'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $errors['description'] ?></p>
                    <?php endif; ?>
                </div>

                <!-- Thumbnail -->
                <div>
                    <label for="thumbnail" class="block text-sm font-semibold text-gray-700 mb-2">
                        Course Thumbnail (Optional)
                    </label>
                    <input type="file" 
                           id="thumbnail" 
                           name="thumbnail" 
                           accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">Recommended size: 1280x720px (16:9 ratio)</p>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status
                    </label>
                    <select id="status" 
                            name="status"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent">
                        <option value="draft" <?= ($oldInput['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Draft (Not visible to students)</option>
                        <option value="published" <?= ($oldInput['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published (Visible to students)</option>
                    </select>
                    <p class="text-sm text-gray-500 mt-1">You can always change this later</p>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg transition-colors">
                        <i class="fas fa-check mr-2"></i>Create Course
                    </button>
                    <a href="<?= url('/facilitator/dashboard') ?>" 
                       class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-lg transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-blue-50 border-l-4 border-primary/90 p-6 rounded">
            <div class="flex items-start">
                <i class="fas fa-lightbulb text-primary/90 text-2xl mr-3 mt-1"></i>
                <div>
                    <h3 class="font-bold text-blue-900 mb-2">Tips for Creating a Great Course</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li><i class="fas fa-check mr-2"></i>Use a clear, descriptive title that tells students what they'll learn</li>
                        <li><i class="fas fa-check mr-2"></i>Write a detailed description highlighting key learning outcomes</li>
                        <li><i class="fas fa-check mr-2"></i>Choose the appropriate difficulty level for your target audience</li>
                        <li><i class="fas fa-check mr-2"></i>Start with "Draft" status and publish when content is ready</li>
                        <li><i class="fas fa-check mr-2"></i>Use AI tools to help generate course outlines and content</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>

