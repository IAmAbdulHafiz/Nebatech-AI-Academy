<?php 
$content = ob_start(); 
?>

    <!-- Hero Section -->
    <section class="bg-primary text-white py-16">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-5xl font-bold mb-6">Blog & Resources</h1>
            <p class="text-xl max-w-3xl mx-auto">
                Learn from industry insights, tutorials, and expert advice to accelerate your tech career
            </p>
        </div>
    </section>

    <!-- Categories Filter & Articles Container -->
    <div x-data="{ category: 'all' }">
        <!-- Categories Filter -->
        <section class="py-8 bg-white border-b">
            <div class="container mx-auto px-6">
                <div class="flex flex-wrap justify-center gap-4">
                    <button @click="category = 'all'" 
                            :class="category === 'all' ? 'bg-primary text-white shadow-lg scale-105' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'" 
                            class="px-6 py-2 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                        All Articles
                    </button>
                    <button @click="category = 'tutorial'" 
                            :class="category === 'tutorial' ? 'bg-primary text-white shadow-lg scale-105' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'" 
                            class="px-6 py-2 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                        Tutorials
                    </button>
                    <button @click="category = 'career'" 
                            :class="category === 'career' ? 'bg-primary text-white shadow-lg scale-105' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'" 
                            class="px-6 py-2 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                        Career Advice
                    </button>
                    <button @click="category = 'ai'" 
                            :class="category === 'ai' ? 'bg-primary text-white shadow-lg scale-105' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'" 
                            class="px-6 py-2 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                        AI & ML
                    </button>
                    <button @click="category = 'security'" 
                            :class="category === 'security' ? 'bg-primary text-white shadow-lg scale-105' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'" 
                            class="px-6 py-2 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                        Security
                    </button>
                </div>
            </div>
        </section>

        <!-- Recent Articles Grid -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Recent Articles</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Article 1 -->
                <article class="bg-gray-50 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all" 
                         data-category="tutorial"
                         x-show="category === 'all' || category === 'tutorial'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="h-48 bg-blue-100 flex items-center justify-center">
                        <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="text-xs text-primary font-semibold mb-2">TUTORIAL • 5 MIN READ</div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">10 JavaScript Tips Every Developer Should Know</h3>
                        <p class="text-gray-600 mb-4 text-sm">Master these modern JavaScript techniques to write cleaner, more efficient code...</p>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span>Nov 6, 2025</span>
                            <span>532 views</span>
                        </div>
                        <a href="<?= url('/blog/javascript-tips-2025') ?>" class="text-primary font-semibold hover:text-blue-700">Read Article →</a>
                    </div>
                </article>

                <!-- Article 2 -->
                <article class="bg-gray-50 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all" 
                         data-category="career"
                         x-show="category === 'all' || category === 'career'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="h-48 bg-green-100 flex items-center justify-center">
                        <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="text-xs text-green-600 font-semibold mb-2">CAREER • 8 MIN READ</div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">How to Land Your First Tech Job Without a Degree</h3>
                        <p class="text-gray-600 mb-4 text-sm">A comprehensive guide to breaking into tech with portfolio projects and networking...</p>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span>Nov 5, 2025</span>
                            <span>892 views</span>
                        </div>
                        <a href="<?= url('/blog/first-tech-job-without-degree') ?>" class="text-green-600 font-semibold hover:text-green-700">Read Article →</a>
                    </div>
                </article>

                <!-- Article 3 -->
                <article class="bg-gray-50 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all" 
                         data-category="ai"
                         x-show="category === 'all' || category === 'ai'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="h-48 bg-orange-100 flex items-center justify-center">
                        <svg class="w-16 h-16 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="text-xs text-secondary font-semibold mb-2">AI & ML • 10 MIN READ</div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Getting Started with AI: A Beginner's Roadmap</h3>
                        <p class="text-gray-600 mb-4 text-sm">Learn the fundamentals of artificial intelligence and machine learning from scratch...</p>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span>Nov 4, 2025</span>
                            <span>1.1k views</span>
                        </div>
                        <a href="<?= url('/blog/ai-beginners-roadmap') ?>" class="text-secondary font-semibold hover:text-orange-600">Read Article →</a>
                    </div>
                </article>

                <!-- Article 4 -->
                <article class="bg-gray-50 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all" 
                         data-category="tutorial"
                         x-show="category === 'all' || category === 'tutorial'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="h-48 bg-purple-100 flex items-center justify-center">
                        <svg class="w-16 h-16 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="text-xs text-purple-600 font-semibold mb-2">TUTORIAL • 12 MIN READ</div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Building RESTful APIs with Node.js and Express</h3>
                        <p class="text-gray-600 mb-4 text-sm">Step-by-step guide to creating scalable backend services...</p>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span>Nov 3, 2025</span>
                            <span>678 views</span>
                        </div>
                        <a href="<?= url('/blog/nodejs-rest-api') ?>" class="text-purple-600 font-semibold hover:text-purple-700">Read Article →</a>
                    </div>
                </article>

                <!-- Article 5 -->
                <article class="bg-gray-50 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all" 
                         data-category="security"
                         x-show="category === 'all' || category === 'security'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="h-48 bg-red-100 flex items-center justify-center">
                        <svg class="w-16 h-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="text-xs text-red-600 font-semibold mb-2">SECURITY • 7 MIN READ</div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Top 10 Web Security Best Practices for 2025</h3>
                        <p class="text-gray-600 mb-4 text-sm">Protect your applications from common vulnerabilities and attacks...</p>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span>Nov 2, 2025</span>
                            <span>945 views</span>
                        </div>
                        <a href="<?= url('/blog/web-security-2025') ?>" class="text-red-600 font-semibold hover:text-red-700">Read Article →</a>
                    </div>
                </article>

                <!-- Article 6 -->
                <article class="bg-gray-50 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all" 
                         data-category="career"
                         x-show="category === 'all' || category === 'career'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="h-48 bg-yellow-100 flex items-center justify-center">
                        <svg class="w-16 h-16 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="text-xs text-yellow-600 font-semibold mb-2">CAREER • 6 MIN READ</div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">5 Skills That Will Make You a Highly Paid Developer</h3>
                        <p class="text-gray-600 mb-4 text-sm">Focus on these in-demand skills to maximize your earning potential...</p>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span>Nov 1, 2025</span>
                            <span>1.3k views</span>
                        </div>
                        <a href="<?= url('/blog/high-paying-dev-skills') ?>" class="text-yellow-600 font-semibold hover:text-yellow-700">Read Article →</a>
                    </div>
                </article>

            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-12 space-x-2">
                <button class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg hover:bg-gray-300">Previous</button>
                <button class="px-4 py-2 bg-primary text-white rounded-lg">1</button>
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">2</button>
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">3</button>
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Next</button>
            </div>
        </div>
    </section>
</div>

    <!-- Newsletter CTA -->
    <section class="py-16 bg-primary text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-4">Never Miss an Article</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Get the latest tutorials and tech insights delivered to your inbox weekly</p>
            <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
                <input type="email" placeholder="Enter your email" class="flex-1 px-6 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-secondary" required>
                <button type="submit" class="bg-secondary hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-lg transition-colors">
                    Subscribe
                </button>
            </form>
        </div>
    </section>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
