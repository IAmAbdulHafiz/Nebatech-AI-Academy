<!DOCTYPE html>
<html lang="en" x-data="{ activeTab: 'details' }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course - <?= htmlspecialchars($course['title']) ?></title>
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <!-- Alpine.js Collapse Plugin (must load before Alpine core) -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="<?= url('/facilitator/dashboard') ?>" class="text-primary hover:text-primary font-semibold mb-4 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($course['title']) ?></h1>
                    <p class="text-gray-600 mt-2">
                        <span class="inline-flex items-center">
                            <?php if ($course['status'] === 'published'): ?>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Published</span>
                            <?php else: ?>
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">Draft</span>
                            <?php endif; ?>
                        </span>
                    </p>
                </div>
                <div class="flex gap-3">
                    <?php if ($course['status'] === 'draft'): ?>
                        <form method="POST" action="<?= url('/facilitator/courses/' . $course['id'] . '/publish') ?>">
                            <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                                <i class="fas fa-upload mr-2"></i>Publish Course
                            </button>
                        </form>
                    <?php endif; ?>
                    <a href="<?= url('/courses/' . $course['slug']) ?>" target="_blank" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary/70 transition">
                        <i class="fas fa-eye mr-2"></i>Preview
                    </a>
                </div>
            </div>
        </div>

        <?php if (!empty($success)): ?>
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
                <p class="text-green-700"><i class="fas fa-check-circle mr-2"></i><?= $success ?></p>
            </div>
        <?php endif; ?>

        <!-- Tabs -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex">
                    <button @click="activeTab = 'details'" 
                            :class="activeTab === 'details' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                            class="px-6 py-4 font-semibold border-b-2 transition">
                        <i class="fas fa-info-circle mr-2"></i>Course Details
                    </button>
                    <button @click="activeTab = 'curriculum'" 
                            :class="activeTab === 'curriculum' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                            class="px-6 py-4 font-semibold border-b-2 transition">
                        <i class="fas fa-list mr-2"></i>Curriculum
                    </button>
                    <button @click="activeTab = 'students'" 
                            :class="activeTab === 'students' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                            class="px-6 py-4 font-semibold border-b-2 transition">
                        <i class="fas fa-users mr-2"></i>Students
                    </button>
                </nav>
            </div>

            <!-- Course Details Tab -->
            <div x-show="activeTab === 'details'" class="p-8">
                <form method="POST" action="<?= url('/facilitator/courses/' . $course['id'] . '/edit') ?>" enctype="multipart/form-data" class="space-y-6">
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                                Course Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   required 
                                   value="<?= htmlspecialchars($course['title']) ?>"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select id="category" name="category" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                                <option value="frontend" <?= $course['category'] === 'frontend' ? 'selected' : '' ?>>Frontend Development</option>
                                <option value="backend" <?= $course['category'] === 'backend' ? 'selected' : '' ?>>Backend Development</option>
                                <option value="fullstack" <?= $course['category'] === 'fullstack' ? 'selected' : '' ?>>Full Stack Development</option>
                                <option value="mobile" <?= $course['category'] === 'mobile' ? 'selected' : '' ?>>Mobile Development</option>
                                <option value="ai" <?= $course['category'] === 'ai' ? 'selected' : '' ?>>AI & Machine Learning</option>
                                <option value="data-science" <?= $course['category'] === 'data-science' ? 'selected' : '' ?>>Data Science</option>
                                <option value="cybersecurity" <?= $course['category'] === 'cybersecurity' ? 'selected' : '' ?>>Cybersecurity</option>
                                <option value="cloud" <?= $course['category'] === 'cloud' ? 'selected' : '' ?>>Cloud Computing</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="level" class="block text-sm font-semibold text-gray-700 mb-2">
                                Difficulty Level
                            </label>
                            <select id="level" name="level"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                                <option value="beginner" <?= $course['level'] === 'beginner' ? 'selected' : '' ?>>Beginner</option>
                                <option value="intermediate" <?= $course['level'] === 'intermediate' ? 'selected' : '' ?>>Intermediate</option>
                                <option value="advanced" <?= $course['level'] === 'advanced' ? 'selected' : '' ?>>Advanced</option>
                            </select>
                        </div>

                        <div>
                            <label for="duration_hours" class="block text-sm font-semibold text-gray-700 mb-2">
                                Duration (Hours)
                            </label>
                            <input type="number" 
                                   id="duration_hours" 
                                   name="duration_hours" 
                                   min="1"
                                   value="<?= $course['duration_hours'] ?>"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Course Description
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="6"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"><?= htmlspecialchars($course['description']) ?></textarea>
                    </div>

                    <div>
                        <label for="thumbnail" class="block text-sm font-semibold text-gray-700 mb-2">
                            Course Thumbnail
                        </label>
                        <?php if ($course['thumbnail']): ?>
                            <div class="mb-3">
                                <img src="<?= asset($course['thumbnail']) ?>" alt="Current thumbnail" class="w-48 h-auto rounded">
                            </div>
                        <?php endif; ?>
                        <input type="file" 
                               id="thumbnail" 
                               name="thumbnail" 
                               accept="image/*"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <button type="submit" 
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg transition">
                            <i class="fas fa-save mr-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Curriculum Tab -->
            <div x-show="activeTab === 'curriculum'" class="p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Course Curriculum</h2>
                    <button onclick="showAddModuleModal()" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                        <i class="fas fa-plus mr-2"></i>Add Module
                    </button>
                </div>

                <?php if (empty($modules)): ?>
                    <div class="text-center py-16 bg-gray-50 rounded-lg">
                        <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600 mb-4">No modules yet. Start building your course curriculum!</p>
                        <button onclick="showAddModuleModal()" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                            <i class="fas fa-plus mr-2"></i>Add First Module
                        </button>
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($modules as $index => $module): ?>
                            <div class="border border-gray-200 rounded-lg">
                                <div class="p-6 bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <span class="bg-green-600 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold">
                                                <?= $index + 1 ?>
                                            </span>
                                            <div>
                                                <h3 class="font-bold text-lg text-gray-900"><?= htmlspecialchars($module['title']) ?></h3>
                                                <?php if ($module['description']): ?>
                                                    <p class="text-sm text-gray-600"><?= htmlspecialchars($module['description']) ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <button onclick="showAddLessonModal(<?= $module['id'] ?>)" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/70 transition text-sm">
                                                <i class="fas fa-plus mr-1"></i>Add Lesson
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <p class="text-sm text-gray-500">
                                        <i class="fas fa-book mr-1"></i>
                                        No lessons yet. Click "Add Lesson" to start.
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Students Tab -->
            <div x-show="activeTab === 'students'" class="p-8">
                <div class="text-center py-16">
                    <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600">
                        <?= $course['enrollment_count'] ?? 0 ?> student(s) enrolled in this course
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Module Modal (Simple version - you can enhance with Alpine.js) -->
    <div id="addModuleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
            <h3 class="text-2xl font-bold mb-4">Add New Module</h3>
            <form onsubmit="addModule(event)">
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Module Title</label>
                    <input type="text" id="moduleTitle" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description (Optional)</label>
                    <textarea id="moduleDescription" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition flex-1">
                        Add Module
                    </button>
                    <button type="button" onclick="hideAddModuleModal()" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showAddModuleModal() {
            document.getElementById('addModuleModal').classList.remove('hidden');
        }

        function hideAddModuleModal() {
            document.getElementById('addModuleModal').classList.add('hidden');
            document.getElementById('moduleTitle').value = '';
            document.getElementById('moduleDescription').value = '';
        }

        function addModule(event) {
            event.preventDefault();
            
            const title = document.getElementById('moduleTitle').value;
            const description = document.getElementById('moduleDescription').value;
            
            fetch('<?= url('/facilitator/courses/' . $course['id'] . '/modules') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    title: title,
                    description: description
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + (data.error || 'Failed to add module'));
                }
            })
            .catch(error => {
                alert('Error: ' + error);
            });
        }

        function showAddLessonModal(moduleId) {
            alert('Add lesson functionality will be implemented with lesson modal');
        }
    </script>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>


