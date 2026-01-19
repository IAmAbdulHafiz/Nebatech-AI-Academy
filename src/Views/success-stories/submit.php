<!-- Success Story Submission Page -->
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-purple-900 via-indigo-900 to-blue-900 text-white py-20 overflow-hidden">
        <!-- Digital Horizon Background -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Horizon Glow -->
            <div class="absolute bottom-0 left-0 right-0 h-96 bg-gradient-to-t from-purple-500/30 via-indigo-400/10 to-transparent"></div>
            
            <!-- Glowing Orbs -->
            <div class="absolute top-20 left-10 w-96 h-96 bg-purple-500/40 rounded-full blur-3xl animate-pulse" style="animation-duration: 6s;"></div>
            <div class="absolute bottom-20 right-20 w-80 h-80 bg-indigo-500/30 rounded-full blur-3xl animate-pulse" style="animation-duration: 8s;"></div>
            <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl animate-pulse" style="animation-duration: 7s;"></div>
            
            <!-- Floating Icons -->
            <div class="absolute top-1/4 left-[10%] opacity-20 animate-float" style="animation-duration: 6s;">
                <i class="fas fa-star text-6xl text-purple-300"></i>
            </div>
            <div class="absolute top-1/3 right-[15%] opacity-20 animate-float" style="animation-duration: 7s; animation-delay: 1s;">
                <i class="fas fa-trophy text-6xl text-indigo-300"></i>
            </div>
            <div class="absolute bottom-1/4 left-[20%] opacity-20 animate-float" style="animation-duration: 8s; animation-delay: 0.5s;">
                <i class="fas fa-medal text-6xl text-blue-300"></i>
            </div>
        </div>
        
        <!-- Content -->
        <div class="container mx-auto px-6 text-center relative z-10">
            <div class="inline-block bg-indigo-800/60 backdrop-blur-sm px-6 py-2 rounded-full text-white text-sm font-semibold mb-6 border border-purple-400/30">
                🌟 Your Journey Matters
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                Share Your Success Story
            </h1>
            <p class="text-xl text-purple-100 max-w-3xl mx-auto">
                Inspire others by sharing how Nebatech Software Solutions Ltd helped transform your career. 
                Your story could motivate the next generation of tech professionals!
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="container mx-auto px-6">
            <div class="max-w-2xl mx-auto">
                
                <?php if (!empty($success)): ?>
                <!-- Success Message -->
                <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 text-green-700 dark:text-green-300 px-6 py-4 rounded-lg mb-8">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span><?= htmlspecialchars($success) ?></span>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                <!-- Error Messages -->
                <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 text-red-700 dark:text-red-300 px-6 py-4 rounded-lg mb-8">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <ul class="list-disc list-inside">
                            <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($pendingStory)): ?>
                <!-- Pending Story Notice -->
                <div class="bg-yellow-100 dark:bg-yellow-900/30 border border-yellow-400 text-yellow-700 dark:text-yellow-300 px-6 py-4 rounded-lg mb-8">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="font-semibold">You already have a story pending review!</p>
                            <p class="mt-1 text-sm">Your story submitted on <?= date('M j, Y', strtotime($pendingStory['created_at'])) ?> is currently awaiting admin approval. You'll be notified once it's reviewed.</p>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                
                <!-- Submission Form -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Tell Us Your Story</h2>
                    
                    <form action="<?= url('/submit-story') ?>" method="POST" class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Your Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="<?= htmlspecialchars($old_input['name'] ?? $user['first_name'] . ' ' . $user['last_name'] ?? '') ?>"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="Your full name"
                                required
                            >
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="<?= htmlspecialchars($old_input['email'] ?? $user['email'] ?? '') ?>"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="your.email@example.com"
                                required
                            >
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">We'll notify you when your story is approved.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Current Role -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Current Role/Title
                                </label>
                                <input 
                                    type="text" 
                                    id="role" 
                                    name="role" 
                                    value="<?= htmlspecialchars($old_input['role'] ?? '') ?>"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="e.g., Frontend Developer"
                                >
                            </div>

                            <!-- Current Position/Company -->
                            <div>
                                <label for="current_position" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Company/Situation
                                </label>
                                <input 
                                    type="text" 
                                    id="current_position" 
                                    name="current_position" 
                                    value="<?= htmlspecialchars($old_input['current_position'] ?? '') ?>"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="e.g., TechCorp or Freelancing"
                                >
                            </div>
                        </div>

                        <!-- Course Completed -->
                        <div>
                            <label for="course_completed" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Course/Program Completed
                            </label>
                            <?php if (!empty($completedCourses)): ?>
                            <select 
                                id="course_completed" 
                                name="course_completed" 
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                            >
                                <option value="">Select a course you completed</option>
                                <?php foreach ($completedCourses as $course): ?>
                                <option value="<?= htmlspecialchars($course) ?>" <?= ($old_input['course_completed'] ?? '') === $course ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($course) ?>
                                </option>
                                <?php endforeach; ?>
                                <option value="other">Other / Multiple Courses</option>
                            </select>
                            <?php else: ?>
                            <input 
                                type="text" 
                                id="course_completed" 
                                name="course_completed" 
                                value="<?= htmlspecialchars($old_input['course_completed'] ?? '') ?>"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="e.g., Full Stack Web Development"
                            >
                            <?php endif; ?>
                        </div>

                        <!-- Success Story -->
                        <div>
                            <label for="testimonial" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Your Success Story <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="testimonial" 
                                name="testimonial" 
                                rows="6"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                placeholder="Share your journey - what you learned, how it helped your career, and what advice you'd give to others..."
                                required
                                minlength="50"
                                maxlength="1000"
                            ><?= htmlspecialchars($old_input['testimonial'] ?? '') ?></textarea>
                            <div class="flex justify-between mt-1">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Be specific about your achievements and transformation.</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400"><span id="charCount">0</span>/1000</p>
                            </div>
                        </div>

                        <!-- Guidelines -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">
                                <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                                Tips for a Great Story
                            </h3>
                            <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                <li>• Share specific skills you learned and how you applied them</li>
                                <li>• Mention any career transitions or promotions</li>
                                <li>• Include projects or achievements you're proud of</li>
                                <li>• Be authentic - your real experience inspires others!</li>
                            </ul>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between">
                            <a href="<?= url('/') ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to Home
                            </a>
                            <button 
                                type="submit" 
                                class="inline-flex items-center bg-primary text-white font-bold px-8 py-3 rounded-lg hover:bg-primary/80 transition-colors"
                            >
                                <i class="fas fa-paper-plane mr-2"></i>
                                Submit Your Story
                            </button>
                        </div>

                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
                            By submitting, you agree that your story may be published on our website after review.
                        </p>
                    </form>
                </div>
                <?php endif; ?>

                <!-- Why Share Section -->
                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-users text-2xl text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Inspire Others</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Your story could motivate someone to start their tech journey.</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-handshake text-2xl text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Build Your Brand</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Featured stories include links to your portfolio and social profiles.</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-gift text-2xl text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Give Back</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Help grow our community by sharing your experience.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
// Character counter
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('testimonial');
    const charCount = document.getElementById('charCount');
    
    if (textarea && charCount) {
        function updateCount() {
            charCount.textContent = textarea.value.length;
        }
        
        textarea.addEventListener('input', updateCount);
        updateCount(); // Initial count
    }
});
</script>
