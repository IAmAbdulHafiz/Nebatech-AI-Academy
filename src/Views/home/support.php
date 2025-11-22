<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-violet-900 via-purple-800 to-fuchsia-700 text-white py-20 overflow-hidden">
    <!-- Digital Horizon Background -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Horizon Glow -->
        <div class="absolute bottom-0 left-0 right-0 h-96 bg-gradient-to-t from-violet-500/30 via-purple-400/10 to-transparent"></div>
        
        <!-- Geometric Light Beams -->
        <div class="absolute top-0 left-1/4 w-1 h-full bg-gradient-to-b from-violet-400/40 via-violet-400/20 to-transparent transform -skew-x-12 animate-pulse" style="animation-duration: 4s;"></div>
        <div class="absolute top-0 right-1/3 w-1 h-full bg-gradient-to-b from-purple-400/30 via-purple-400/15 to-transparent transform skew-x-12 animate-pulse" style="animation-duration: 5s;"></div>
        <div class="absolute top-0 left-2/3 w-1 h-full bg-gradient-to-b from-fuchsia-400/25 via-fuchsia-400/10 to-transparent transform -skew-x-6 animate-pulse" style="animation-duration: 3s;"></div>
        
        <!-- Glowing Orbs -->
        <div class="absolute top-20 left-10 w-96 h-96 bg-violet-500/40 rounded-full blur-3xl animate-pulse" style="animation-duration: 6s;"></div>
        <div class="absolute bottom-20 right-20 w-80 h-80 bg-purple-500/30 rounded-full blur-3xl animate-pulse" style="animation-duration: 8s;"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-fuchsia-500/20 rounded-full blur-3xl animate-pulse" style="animation-duration: 7s;"></div>
        
        <!-- Floating Support Icons -->
        <div class="absolute top-1/4 left-[10%] opacity-20 animate-float" style="animation-duration: 6s;">
            <i class="fas fa-headset text-6xl text-violet-300"></i>
        </div>
        <div class="absolute top-1/3 right-[15%] opacity-20 animate-float" style="animation-duration: 7s; animation-delay: 1s;">
            <i class="fas fa-life-ring text-6xl text-purple-300"></i>
        </div>
        <div class="absolute bottom-1/4 left-[20%] opacity-20 animate-float" style="animation-duration: 8s; animation-delay: 0.5s;">
            <i class="fas fa-hands-helping text-6xl text-fuchsia-300"></i>
        </div>
        <div class="absolute top-1/2 right-[25%] opacity-20 animate-float" style="animation-duration: 6.5s; animation-delay: 1.5s;">
            <i class="fas fa-tools text-6xl text-violet-300"></i>
        </div>
        <div class="absolute bottom-1/3 right-[10%] opacity-20 animate-float" style="animation-duration: 7.5s; animation-delay: 0.8s;">
            <i class="fas fa-check-circle text-6xl text-purple-300"></i>
        </div>
    </div>
    
    <!-- Content -->
    <div class="container mx-auto px-6 text-center relative z-10">
        <div class="inline-block bg-purple-800/60 backdrop-blur-sm px-6 py-2 rounded-full text-white text-sm font-semibold mb-6 border border-violet-400/30">
            <i class="fas fa-headset mr-2"></i>We're Here to Help
        </div>
        <h1 class="text-5xl md:text-6xl font-bold mb-6">Support Center</h1>
        <p class="text-xl text-violet-100 max-w-3xl mx-auto mb-12">
            We're here to help! Find answers, get support, and make the most of your learning experience.
        </p>
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
            <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-violet-400/20 hover:bg-white/15 transition-all">
                <div class="text-3xl font-bold"><1h</div>
                <div class="text-violet-200 text-sm">Response Time</div>
            </div>
            <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-purple-400/20 hover:bg-white/15 transition-all">
                <div class="text-3xl font-bold">24/7</div>
                <div class="text-violet-200 text-sm">Availability</div>
            </div>
            <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-fuchsia-400/20 hover:bg-white/15 transition-all">
                <div class="text-3xl font-bold">98%</div>
                <div class="text-violet-200 text-sm">Satisfaction Rate</div>
            </div>
            <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-violet-400/20 hover:bg-white/15 transition-all">
                <div class="text-3xl font-bold">5+</div>
                <div class="text-violet-200 text-sm">Support Channels</div>
            </div>
        </div>
    </div>
</section>

<div class="container mx-auto px-4 py-12">

    <!-- Support Options -->
    <div class="grid md:grid-cols-3 gap-8 mb-16">
        <a href="<?= url('/faqs') ?>" class="bg-white dark:bg-gray-800 rounded-lg p-8 shadow-md hover:shadow-lg transition">
            <div class="w-12 h-12 bg-blue-100 dark:bg-primary/90 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-primary dark:text-primary/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">FAQs</h3>
            <p class="text-gray-600 dark:text-gray-400">Browse frequently asked questions</p>
        </a>

        <a href="<?= url('/live-chat') ?>" class="bg-white dark:bg-gray-800 rounded-lg p-8 shadow-md hover:shadow-lg transition">
            <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Live Chat</h3>
            <p class="text-gray-600 dark:text-gray-400">Chat with our support team</p>
        </a>

        <a href="mailto:support@nebatech.com" class="bg-white dark:bg-gray-800 rounded-lg p-8 shadow-md hover:shadow-lg transition">
            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Email Support</h3>
            <p class="text-gray-600 dark:text-gray-400">Send us an email anytime</p>
        </a>
    </div>

    <!-- Quick Help Topics -->
    <div class="bg-white dark:bg-gray-800 rounded-lg p-8 shadow-md mb-16">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Quick Help Topics</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-bold text-gray-900 dark:text-white mb-3">Account & Enrollment</h4>
                <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                    <li><a href="#" class="hover:text-primary dark:hover:text-primary/80">How do I create an account?</a></li>
                    <li><a href="#" class="hover:text-primary dark:hover:text-primary/80">How to enroll in a course?</a></li>
                    <li><a href="#" class="hover:text-primary dark:hover:text-primary/80">Forgot password?</a></li>
                    <li><a href="#" class="hover:text-primary dark:hover:text-primary/80">Update account information</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-gray-900 dark:text-white mb-3">Courses & Learning</h4>
                <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                    <li><a href="#" class="hover:text-primary dark:hover:text-primary/80">How to access course materials?</a></li>
                    <li><a href="#" class="hover:text-primary dark:hover:text-primary/80">Video not playing?</a></li>
                    <li><a href="#" class="hover:text-primary dark:hover:text-primary/80">Download course resources</a></li>
                    <li><a href="#" class="hover:text-primary dark:hover:text-primary/80">Get a certificate</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-gray-900 dark:text-white mb-3">Payments & Billing</h4>
                <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                    <li><a href="#" class="hover:text-primary dark:hover:text-primary/80">Payment methods accepted</a></li>
                    <li><a href="#" class="hover:text-primary dark:hover:text-primary/80">View payment history</a></li>
                    <li><a href="<?= url('/refund-policy') ?>" class="hover:text-primary dark:hover:text-primary/80">Refund policy</a></li>
                    <li><a href="#" class="hover:text-primary dark:hover:text-primary/80">Payment failed?</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-gray-900 dark:text-white mb-3">Technical Issues</h4>
                <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                    <li><a href="#" class="hover:text-primary dark:hover:text-primary/80">Browser compatibility</a></li>
                    <li><a href="#" class="hover:text-primary dark:hover:text-primary/80">Clear cache and cookies</a></li>
                    <li><a href="#" class="hover:text-primary dark:hover:text-primary/80">Mobile app issues</a></li>
                    <li><a href="#" class="hover:text-primary dark:hover:text-primary/80">Report a bug</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg p-8 text-white">
            <h3 class="text-2xl font-bold mb-4">Contact Information</h3>
            <div class="space-y-3">
                <p><strong>Email:</strong> support@nebatech.com</p>
                <p><strong>Phone:</strong> +233 24 763 6080</p>
                <p><strong>Hours:</strong> Mon-Fri, 8am-6pm GMT</p>
                <p><strong>Response Time:</strong> Within 24 hours</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg p-8 shadow-md">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Join Our Community</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Get help from fellow students and instructors:</p>
            <div class="space-y-3">
                <a href="<?= url('/community') ?>" class="block text-primary dark:text-primary/80 hover:underline">Community Forum →</a>
                <a href="https://discord.gg/nebatech" target="_blank" class="block text-primary dark:text-primary/80 hover:underline">Discord Server →</a>
                <a href="<?= url('/community/guidelines') ?>" class="block text-primary dark:text-primary/80 hover:underline">Community Guidelines →</a>
            </div>
        </div>
    </div>
</div>


