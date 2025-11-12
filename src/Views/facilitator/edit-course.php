<?php
$title = 'Edit Course - ' . htmlspecialchars($course['title']);

// Load course categories from database
$categories = \Nebatech\Models\CourseCategory::getActive();

ob_start();
include __DIR__ . '/../partials/facilitator-sidebar.php';
$sidebarContent = ob_get_clean();
ob_start();
?>
<div x-data="{ activeTab: 'details' }">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="<?= url('/facilitator/dashboard') ?>" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($course['title']) ?></h1>
                <div class="mt-1">
                    <?php if ($course['status'] === 'published'): ?>
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Published</span>
                    <?php else: ?>
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Draft</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex gap-3">
                <?php if ($course['status'] === 'draft'): ?>
                    <form method="POST" action="<?= url('/facilitator/courses/' . $course['id'] . '/publish') ?>">
                        <?= csrf_field() ?>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition text-sm">
                            <i class="fas fa-upload mr-2"></i>Publish
                        </button>
                    </form>
                <?php endif; ?>
                <a href="<?= url('/courses/' . $course['slug']) ?>" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition text-sm">
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
                    <?= csrf_field() ?>
                    
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
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category['slug']) ?>" 
                                            <?= ($course['category_slug'] ?? '') === $category['slug'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
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
                                <!-- Module Header -->
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
                                            <button onclick="showAddLessonModal(<?= $module['id'] ?>)" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm">
                                                <i class="fas fa-plus mr-1"></i>Add Lesson
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Lessons List -->
                                <div class="p-6">
                                    <?php if (empty($module['lessons'])): ?>
                                        <p class="text-sm text-gray-500">
                                            <i class="fas fa-book mr-1"></i>
                                            No lessons yet. Click "Add Lesson" to start.
                                        </p>
                                    <?php else: ?>
                                        <div class="space-y-3">
                                            <?php foreach ($module['lessons'] as $lessonIndex => $lesson): ?>
                                                <div class="border border-gray-200 rounded-lg p-4 bg-white hover:shadow-md transition">
                                                    <div class="flex items-start justify-between">
                                                        <div class="flex-1">
                                                            <div class="flex items-center gap-3 mb-2">
                                                                <span class="bg-blue-100 text-blue-700 w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold">
                                                                    <?= $lessonIndex + 1 ?>
                                                                </span>
                                                                <h4 class="font-semibold text-gray-900"><?= htmlspecialchars($lesson['title']) ?></h4>
                                                                <?php if ($lesson['duration_minutes']): ?>
                                                                    <span class="text-xs text-gray-500">
                                                                        <i class="fas fa-clock mr-1"></i><?= $lesson['duration_minutes'] ?> min
                                                                    </span>
                                                                <?php endif; ?>
                                                            </div>
                                                            
                                                            <!-- Assignments for this lesson -->
                                                            <?php if (!empty($lesson['assignments'])): ?>
                                                                <div class="ml-11 space-y-2 mt-3">
                                                                    <?php foreach ($lesson['assignments'] as $assignment): ?>
                                                                        <div class="flex items-center gap-2 text-sm bg-green-50 border border-green-200 rounded px-3 py-2">
                                                                            <i class="fas fa-clipboard-list text-green-600"></i>
                                                                            <span class="font-medium text-green-800"><?= htmlspecialchars($assignment['title']) ?></span>
                                                                            <span class="text-green-600 ml-auto"><?= $assignment['max_score'] ?> pts</span>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        
                                                        <div class="flex gap-2 ml-4">
                                                            <button onclick="showAddAssignmentModal(<?= $lesson['id'] ?>)" 
                                                                    class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition text-xs">
                                                                <i class="fas fa-plus mr-1"></i>Assignment
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
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

    <!-- Add Lesson Modal -->
    <div id="addLessonModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <h3 class="text-2xl font-bold mb-4">Add New Lesson</h3>
            <form onsubmit="addLesson(event)">
                <input type="hidden" id="lessonModuleId">
                
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lesson Title *</label>
                    <input type="text" id="lessonTitle" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Content Type</label>
                    <select id="lessonType" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option value="text">Text/Article</option>
                        <option value="video">Video</option>
                        <option value="code">Code Example</option>
                        <option value="quiz">Quiz</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Content *</label>
                    <textarea id="lessonContent" rows="8" required
                              placeholder="Enter lesson content (supports HTML)..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Duration (minutes)</label>
                    <input type="number" id="lessonDuration" min="1" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition flex-1">
                        <i class="fas fa-plus mr-2"></i>Add Lesson
                    </button>
                    <button type="button" onclick="hideAddLessonModal()" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Assignment Modal -->
    <div id="addAssignmentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <h3 class="text-2xl font-bold mb-4">Add Assignment</h3>
            <form onsubmit="addAssignment(event)">
                <input type="hidden" id="assignmentLessonId">
                
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Assignment Title *</label>
                    <input type="text" id="assignmentTitle" required 
                           placeholder="e.g., Build a Calculator App"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description *</label>
                    <textarea id="assignmentDescription" rows="6" required
                              placeholder="Describe what students need to do..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Maximum Score</label>
                    <input type="number" id="assignmentMaxScore" value="100" min="1" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Grading Rubric (Optional)</label>
                    <textarea id="assignmentRubric" rows="4"
                              placeholder="Enter grading criteria (one per line)&#10;- Code Quality: Clean and readable code&#10;- Functionality: All features work correctly&#10;- Design: User-friendly interface"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Enter each criterion on a new line starting with a dash (-)</p>
                </div>

                <div class="mb-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" id="assignmentAiFeedback" checked
                               class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <span class="text-sm font-semibold text-gray-700">Enable AI Feedback</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1 ml-7">Students will receive instant AI-powered feedback on their submissions</p>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition flex-1">
                        <i class="fas fa-clipboard-list mr-2"></i>Add Assignment
                    </button>
                    <button type="button" onclick="hideAddAssignmentModal()" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Module Functions
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
                    description: description,
                    _token: '<?= csrf_token() ?>'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess('Module added successfully');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showError('Error: ' + (data.error || 'Failed to add module'));
                }
            })
            .catch(error => {
                showError('Error: ' + error);
            });
        }

        // Lesson Functions
        function showAddLessonModal(moduleId) {
            document.getElementById('lessonModuleId').value = moduleId;
            document.getElementById('addLessonModal').classList.remove('hidden');
        }

        function hideAddLessonModal() {
            document.getElementById('addLessonModal').classList.add('hidden');
            document.getElementById('lessonTitle').value = '';
            document.getElementById('lessonContent').value = '';
            document.getElementById('lessonDuration').value = '';
            document.getElementById('lessonType').value = 'text';
        }

        function addLesson(event) {
            event.preventDefault();
            
            const moduleId = document.getElementById('lessonModuleId').value;
            const title = document.getElementById('lessonTitle').value;
            const type = document.getElementById('lessonType').value;
            const content = document.getElementById('lessonContent').value;
            const duration = document.getElementById('lessonDuration').value;
            
            fetch('<?= url('/facilitator/modules/') ?>' + moduleId + '/lessons', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    title: title,
                    type: type,
                    content: content,
                    duration_minutes: duration,
                    _token: '<?= csrf_token() ?>'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess('Lesson added successfully');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showError('Error: ' + (data.error || 'Failed to add lesson'));
                }
            })
            .catch(error => {
                showError('Error: ' + error);
            });
        }

        // Assignment Functions
        function showAddAssignmentModal(lessonId) {
            document.getElementById('assignmentLessonId').value = lessonId;
            document.getElementById('addAssignmentModal').classList.remove('hidden');
        }

        function hideAddAssignmentModal() {
            document.getElementById('addAssignmentModal').classList.add('hidden');
            document.getElementById('assignmentTitle').value = '';
            document.getElementById('assignmentDescription').value = '';
            document.getElementById('assignmentMaxScore').value = '100';
            document.getElementById('assignmentRubric').value = '';
            document.getElementById('assignmentAiFeedback').checked = true;
        }

        function addAssignment(event) {
            event.preventDefault();
            
            const lessonId = document.getElementById('assignmentLessonId').value;
            const title = document.getElementById('assignmentTitle').value;
            const description = document.getElementById('assignmentDescription').value;
            const maxScore = document.getElementById('assignmentMaxScore').value;
            const rubric = document.getElementById('assignmentRubric').value;
            const aiFeedback = document.getElementById('assignmentAiFeedback').checked ? '1' : '0';
            
            fetch('<?= url('/facilitator/lessons/assignments') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    lesson_id: lessonId,
                    title: title,
                    description: description,
                    max_score: maxScore,
                    rubric: rubric,
                    ai_feedback_enabled: aiFeedback,
                    _token: '<?= csrf_token() ?>'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess('Assignment added successfully');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showError('Error: ' + (data.error || 'Failed to add assignment'));
                }
            })
            .catch(error => {
                showError('Error: ' + error);
            });
        }
    </script>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
