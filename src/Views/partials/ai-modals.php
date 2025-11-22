<!-- AI Course Outline Generator Modal -->
<div id="aiCourseOutlineModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg p-8 max-w-2xl w-full">
        <h3 class="text-2xl font-bold mb-6 flex items-center gap-3">
            <i class="fas fa-robot text-green-600"></i>
            AI Course Outline Generator
        </h3>
        
        <form id="aiCourseOutlineForm" onsubmit="generateCourseOutline(event)">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Course Topic <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="topic" required 
                           placeholder="e.g., Modern JavaScript Development"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Difficulty Level
                        </label>
                        <select name="level" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Duration (Hours)
                        </label>
                        <input type="number" name="duration_hours" value="40" min="1" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Category
                    </label>
                    <select name="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                        <option value="frontend">Frontend Development</option>
                        <option value="backend">Backend Development</option>
                        <option value="fullstack">Full Stack Development</option>
                        <option value="mobile">Mobile Development</option>
                        <option value="ai">AI & Machine Learning</option>
                        <option value="data-science">Data Science</option>
                        <option value="cybersecurity">Cybersecurity</option>
                        <option value="cloud">Cloud Computing</option>
                    </select>
                </div>
                
                <div class="bg-blue-50 border-l-4 border-primary/90 p-4 rounded">
                    <p class="text-sm text-primary">
                        <i class="fas fa-info-circle mr-2"></i>
                        AI will generate a complete course outline with modules, learning objectives, and estimated durations.
                    </p>
                </div>
                
                <div class="flex gap-3 pt-4">
                    <button type="submit" 
                            class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition flex-1">
                        <i class="fas fa-magic mr-2"></i>Generate Outline
                    </button>
                    <button type="button" onclick="hideAICourseOutlineModal()" 
                            class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                        Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- AI Lesson Content Generator Modal -->
<div id="aiLessonModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg p-8 max-w-2xl w-full">
        <h3 class="text-2xl font-bold mb-6 flex items-center gap-3">
            <i class="fas fa-robot text-primary"></i>
            AI Lesson Content Generator
        </h3>
        
        <form id="aiLessonForm" onsubmit="generateLessonContent(event)">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Lesson Topic <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="topic" required 
                           placeholder="e.g., JavaScript Array Methods"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Lesson Type
                        </label>
                        <select name="lesson_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="text">Text/Reading</option>
                            <option value="video">Video</option>
                            <option value="code">Code Exercise</option>
                            <option value="quiz">Quiz</option>
                            <option value="project">Project</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Difficulty Level
                        </label>
                        <select name="level" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Learning Objectives (Optional)
                    </label>
                    <textarea name="objectives" rows="3" 
                              placeholder="Enter learning objectives, one per line"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
                    <p class="text-xs text-gray-500 mt-1">These will be converted to JSON array automatically</p>
                </div>
                
                <div class="bg-blue-50 border-l-4 border-primary/90 p-4 rounded">
                    <p class="text-sm text-primary">
                        <i class="fas fa-info-circle mr-2"></i>
                        AI will generate comprehensive lesson content including explanations, examples, and exercises.
                    </p>
                </div>
                
                <div class="flex gap-3 pt-4">
                    <button type="submit" 
                            class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary/70 transition flex-1">
                        <i class="fas fa-magic mr-2"></i>Generate Lesson
                    </button>
                    <button type="button" onclick="hideAILessonModal()" 
                            class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                        Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- AI Project Brief Generator Modal -->
<div id="aiProjectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg p-8 max-w-2xl w-full">
        <h3 class="text-2xl font-bold mb-6 flex items-center gap-3">
            <i class="fas fa-robot text-purple-600"></i>
            AI Project Brief Generator
        </h3>
        
        <form id="aiProjectForm" onsubmit="generateProjectBrief(event)">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Project Topic <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="topic" required 
                           placeholder="e.g., Build a Task Management App"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Difficulty Level
                        </label>
                        <select name="level" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                            <option value="beginner">Beginner</option>
                            <option value="intermediate" selected>Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Estimated Hours
                        </label>
                        <input type="number" name="estimated_hours" value="8" min="1" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Skills to Assess (Optional)
                    </label>
                    <input type="text" name="skills" 
                           placeholder="e.g., HTML, CSS, JavaScript, API Integration"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                    <p class="text-xs text-gray-500 mt-1">Comma-separated list of skills</p>
                </div>
                
                <div class="bg-purple-50 border-l-4 border-purple-500 p-4 rounded">
                    <p class="text-sm text-purple-700">
                        <i class="fas fa-info-circle mr-2"></i>
                        AI will generate a complete project brief with requirements, grading rubric, and starter code.
                    </p>
                </div>
                
                <div class="flex gap-3 pt-4">
                    <button type="submit" 
                            class="bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition flex-1">
                        <i class="fas fa-magic mr-2"></i>Generate Project
                    </button>
                    <button type="button" onclick="hideAIProjectModal()" 
                            class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                        Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


