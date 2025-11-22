<div class="container mx-auto px-4 py-12">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-8 text-center">Site Map</h1>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Main Pages -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Main Pages
                </h2>
                <ul class="space-y-2">
                    <li><a href="<?= url('/') ?>" class="text-primary dark:text-primary/80 hover:underline">Home</a></li>
                    <li><a href="<?= url('/about') ?>" class="text-primary dark:text-primary/80 hover:underline">About Us</a></li>
                    <li><a href="<?= url('/courses') ?>" class="text-primary dark:text-primary/80 hover:underline">All Courses</a></li>
                    <li><a href="<?= url('/blog') ?>" class="text-primary dark:text-primary/80 hover:underline">Blog</a></li>
                    <li><a href="<?= url('/testimonials') ?>" class="text-primary dark:text-primary/80 hover:underline">Testimonials</a></li>
                    <li><a href="<?= url('/contact') ?>" class="text-primary dark:text-primary/80 hover:underline">Contact</a></li>
                </ul>
            </div>

            <!-- Courses -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Programs
                </h2>
                <ul class="space-y-2">
                    <li><a href="<?= url('/courses/frontend') ?>" class="text-primary dark:text-primary/80 hover:underline">Frontend Development</a></li>
                    <li><a href="<?= url('/courses/backend') ?>" class="text-primary dark:text-primary/80 hover:underline">Backend Development</a></li>
                    <li><a href="<?= url('/courses/fullstack') ?>" class="text-primary dark:text-primary/80 hover:underline">Full Stack Development</a></li>
                    <li><a href="<?= url('/courses/ai') ?>" class="text-primary dark:text-primary/80 hover:underline">Artificial Intelligence</a></li>
                    <li><a href="<?= url('/courses/data-science') ?>" class="text-primary dark:text-primary/80 hover:underline">Data Science</a></li>
                    <li><a href="<?= url('/courses/mobile') ?>" class="text-primary dark:text-primary/80 hover:underline">Mobile Development</a></li>
                    <li><a href="<?= url('/courses/cloud') ?>" class="text-primary dark:text-primary/80 hover:underline">Cloud Computing</a></li>
                    <li><a href="<?= url('/courses/cybersecurity') ?>" class="text-primary dark:text-primary/80 hover:underline">Cybersecurity</a></li>
                </ul>
            </div>

            <!-- Community -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Community
                </h2>
                <ul class="space-y-2">
                    <li><a href="<?= url('/community') ?>" class="text-primary dark:text-primary/80 hover:underline">Community Hub</a></li>
                    <li><a href="<?= url('/community/discussions') ?>" class="text-primary dark:text-primary/80 hover:underline">Discussions</a></li>
                    <li><a href="<?= url('/community/resources') ?>" class="text-primary dark:text-primary/80 hover:underline">Resources</a></li>
                    <li><a href="<?= url('/community/events') ?>" class="text-primary dark:text-primary/80 hover:underline">Events</a></li>
                    <li><a href="<?= url('/community/leaderboard') ?>" class="text-primary dark:text-primary/80 hover:underline">Leaderboard</a></li>
                    <li><a href="<?= url('/community/guidelines') ?>" class="text-primary dark:text-primary/80 hover:underline">Guidelines</a></li>
                    <li><a href="https://discord.gg/nebatech" target="_blank" class="text-primary dark:text-primary/80 hover:underline">Discord Server ↗</a></li>
                </ul>
            </div>

            <!-- Business -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Business
                </h2>
                <ul class="space-y-2">
                    <li><a href="<?= url('/corporate') ?>" class="text-primary dark:text-primary/80 hover:underline">Corporate Training</a></li>
                    <li><a href="<?= url('/career-services') ?>" class="text-primary dark:text-primary/80 hover:underline">Career Services</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Support
                </h2>
                <ul class="space-y-2">
                    <li><a href="<?= url('/support') ?>" class="text-primary dark:text-primary/80 hover:underline">Support Center</a></li>
                    <li><a href="<?= url('/faqs') ?>" class="text-primary dark:text-primary/80 hover:underline">FAQs</a></li>
                    <li><a href="<?= url('/live-chat') ?>" class="text-primary dark:text-primary/80 hover:underline">Live Chat</a></li>
                    <li><a href="<?= url('/accessibility') ?>" class="text-primary dark:text-primary/80 hover:underline">Accessibility</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Legal
                </h2>
                <ul class="space-y-2">
                    <li><a href="<?= url('/privacy') ?>" class="text-primary dark:text-primary/80 hover:underline">Privacy Policy</a></li>
                    <li><a href="<?= url('/terms') ?>" class="text-primary dark:text-primary/80 hover:underline">Terms of Service</a></li>
                    <li><a href="<?= url('/cookie-policy') ?>" class="text-primary dark:text-primary/80 hover:underline">Cookie Policy</a></li>
                    <li><a href="<?= url('/refund-policy') ?>" class="text-primary dark:text-primary/80 hover:underline">Refund Policy</a></li>
                    <li><a href="<?= url('/code-of-conduct') ?>" class="text-primary dark:text-primary/80 hover:underline">Code of Conduct</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

