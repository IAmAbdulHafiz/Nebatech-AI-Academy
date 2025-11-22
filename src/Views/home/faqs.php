<!-- Breadcrumb -->
<div class="bg-gray-100 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
    <div class="container mx-auto px-6 py-3">
        <nav class="flex text-sm text-gray-600 dark:text-gray-400" aria-label="Breadcrumb">
            <a href="<?= url('/') ?>" class="hover:text-primary dark:hover:text-primary/80 transition-colors">Home</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 dark:text-gray-200 font-semibold">FAQs</span>
        </nav>
    </div>
</div>

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary via-primary/90 to-primary/80 text-white py-20 overflow-hidden">
    <!-- Digital Horizon Background -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Horizon Glow -->
        <div class="absolute bottom-0 left-0 right-0 h-96 bg-gradient-to-t from-white/20 to-transparent"></div>
        
        <!-- Geometric Light Beams -->
        <div class="absolute top-0 left-1/4 w-1 h-full bg-gradient-to-b from-white/20 to-transparent transform -skew-x-12 animate-pulse" style="animation-duration: 4s;"></div>
        <div class="absolute top-0 right-1/3 w-1 h-full bg-gradient-to-b from-white/20 to-transparent transform skew-x-12 animate-pulse" style="animation-duration: 5s;"></div>
        <div class="absolute top-0 left-2/3 w-1 h-full bg-gradient-to-b from-white/20 to-transparent transform -skew-x-6 animate-pulse" style="animation-duration: 3s;"></div>
        
        <!-- Glowing Orbs -->
        <div class="absolute top-20 left-10 w-96 h-96 bg-primary/40 rounded-full blur-3xl animate-pulse" style="animation-duration: 6s;"></div>
        <div class="absolute bottom-20 right-20 w-80 h-80 bg-primary/50 rounded-full blur-3xl animate-pulse" style="animation-duration: 8s;"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-primary/60 rounded-full blur-3xl animate-pulse" style="animation-duration: 7s;"></div>
        
        <!-- Floating Help Icons -->
        <div class="absolute top-1/4 left-[10%] opacity-20 animate-float" style="animation-duration: 6s;">
            <i class="fas fa-question-circle text-6xl text-white/20"></i>
        </div>
        <div class="absolute top-1/3 right-[15%] opacity-20 animate-float" style="animation-duration: 7s; animation-delay: 1s;">
            <i class="fas fa-lightbulb text-6xl text-white/20"></i>
        </div>
        <div class="absolute bottom-1/4 left-[20%] opacity-20 animate-float" style="animation-duration: 8s; animation-delay: 0.5s;">
            <i class="fas fa-book text-6xl text-white/20"></i>
        </div>
        <div class="absolute top-1/2 right-[25%] opacity-20 animate-float" style="animation-duration: 6.5s; animation-delay: 1.5s;">
            <i class="fas fa-headset text-6xl text-white/20"></i>
        </div>
        <div class="absolute bottom-1/3 right-[10%] opacity-20 animate-float" style="animation-duration: 7.5s; animation-delay: 0.8s;">
            <i class="fas fa-check-circle text-6xl text-white/20"></i>
        </div>
    </div>
    
    <!-- Content -->
    <div class="container mx-auto px-6 text-center relative z-10">
        <div class="inline-block bg-white/10 backdrop-blur-sm px-6 py-2 rounded-full text-white text-sm font-semibold mb-6 border border-white/30">
            <i class="fas fa-question-circle mr-2"></i>Help Center
        </div>
        <h1 class="text-5xl md:text-6xl font-bold mb-6">Frequently Asked Questions</h1>
        <p class="text-xl max-w-4xl mx-auto leading-relaxed mb-4 text-white/90">
            Find answers to common questions about Nebatech AI Academy, our services, and training programs
        </p>
        <p class="text-sm text-white/80 mb-12">
            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Last Updated: November 15, 2025
        </p>
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
            <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/20 hover:bg-white/15 transition-all">
                <div class="text-3xl font-bold">100+</div>
                <div class="text-white/80 text-sm">FAQs</div>
            </div>
            <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/20 hover:bg-white/15 transition-all">
                <div class="text-3xl font-bold">8</div>
                <div class="text-white/80 text-sm">Categories</div>
            </div>
            <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/20 hover:bg-white/15 transition-all">
                <div class="text-3xl font-bold">24/7</div>
                <div class="text-white/80 text-sm">Support</div>
            </div>
            <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/20 hover:bg-white/15 transition-all">
                <div class="text-3xl font-bold">95%</div>
                <div class="text-white/80 text-sm">Resolved</div>
            </div>
        </div>
    </div>
</section>

<!-- FAQs Content -->
<section class="py-16 bg-gray-50 dark:bg-gray-800" x-data="faqManager()">
    <div class="container mx-auto px-6">
        <div class="max-w-5xl mx-auto">
            
            <!-- Search Bar -->
            <div class="mb-8">
                <div class="relative max-w-2xl mx-auto">
                    <input type="text" 
                           x-model="searchQuery"
                           @input="searchFAQs($event.target.value)"
                           @keydown.escape="clearSearch()"
                           placeholder="Search for answers... (Press ESC to clear)" 
                           class="w-full px-6 py-4 pr-12 rounded-lg bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:border-primary dark:focus:border-white/30 transition-colors shadow-md">
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <div x-show="searchActive" class="text-center mt-3">
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        Found <span class="font-bold text-primary dark:text-primary/80" x-text="searchResults"></span> result(s)
                    </span>
                    <button @click="clearSearch()" class="ml-3 text-sm text-secondary hover:text-orange-600 font-semibold">Clear Search</button>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="flex flex-wrap gap-3 justify-center mb-8">
                <button @click="expandAll()" class="bg-primary hover:bg-primary/70 text-white px-6 py-3 rounded-lg transition-colors font-semibold flex items-center gap-2 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Expand All
                </button>
                <button @click="collapseAll()" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-colors font-semibold flex items-center gap-2 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                    Collapse All
                </button>
                <button @click="filterCategory('all')" :class="activeCategory === 'all' ? 'bg-secondary text-white' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600'" class="px-6 py-3 rounded-lg transition-colors font-semibold shadow-md">
                    All (<span x-text="totalFAQs"></span>)
                </button>
                <button @click="filterCategory('general')" :class="activeCategory === 'general' ? 'bg-secondary text-white' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600'" class="px-6 py-3 rounded-lg transition-colors font-semibold shadow-md">
                    General (6)
                </button>
                <button @click="filterCategory('training')" :class="activeCategory === 'training' ? 'bg-secondary text-white' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600'" class="px-6 py-3 rounded-lg transition-colors font-semibold shadow-md">
                    Training (11)
                </button>
                <button @click="filterCategory('support')" :class="activeCategory === 'support' ? 'bg-secondary text-white' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600'" class="px-6 py-3 rounded-lg transition-colors font-semibold shadow-md">
                    Support (5)
                </button>
            </div>

            <!-- Table of Contents Sidebar for Desktop -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 mb-12">
                <div class="lg:col-span-1">
                    <div class="sticky top-24 bg-white dark:bg-gray-700 rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            Quick Navigation
                        </h3>
                        <div class="space-y-2 text-sm max-h-[600px] overflow-y-auto">
                            <a href="#general" class="block text-primary hover:text-secondary dark:text-primary/80 dark:hover:text-orange-400 transition-colors py-1">📋 General Questions (6)</a>
                            <a href="#faq-1" class="block text-gray-600 hover:text-primary dark:text-gray-400 dark:hover:text-primary/80 transition-colors py-1 pl-4">• What is Nebatech?</a>
                            <a href="#faq-2" class="block text-gray-600 hover:text-primary dark:text-gray-400 dark:hover:text-primary/80 transition-colors py-1 pl-4">• Location</a>
                            <a href="#faq-3" class="block text-gray-600 hover:text-primary dark:text-gray-400 dark:hover:text-primary/80 transition-colors py-1 pl-4">• Services</a>
                            
                            <a href="#training" class="block text-primary hover:text-secondary dark:text-primary/80 dark:hover:text-orange-400 transition-colors py-1 mt-3">🎓 Training Programs (11)</a>
                            <a href="#faq-4" class="block text-gray-600 hover:text-primary dark:text-gray-400 dark:hover:text-primary/80 transition-colors py-1 pl-4">• How to Enroll</a>
                            <a href="#faq-5" class="block text-gray-600 hover:text-primary dark:text-gray-400 dark:hover:text-primary/80 transition-colors py-1 pl-4">• Course Fees</a>
                            <a href="#faq-6" class="block text-gray-600 hover:text-primary dark:text-gray-400 dark:hover:text-primary/80 transition-colors py-1 pl-4">• Certificates</a>
                            
                            <a href="#support" class="block text-primary hover:text-secondary dark:text-primary/80 dark:hover:text-orange-400 transition-colors py-1 mt-3">🔧 Technical Support (5)</a>
                            <a href="#faq-9" class="block text-gray-600 hover:text-primary dark:text-gray-400 dark:hover:text-primary/80 transition-colors py-1 pl-4">• 24/7 Support</a>
                            <a href="#faq-10" class="block text-gray-600 hover:text-primary dark:text-gray-400 dark:hover:text-primary/80 transition-colors py-1 pl-4">• Hardware Repairs</a>
                        </div>
                    </div>
                </div>
                
                <div class="lg:col-span-3">

            <!-- General Questions -->
            <div class="mb-12" id="general" x-show="activeCategory === 'all' || activeCategory === 'general'">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 pb-3 border-b-4 border-secondary">General Questions</h2>
                <div class="space-y-4">
                    
                    <?php
                    $generalFAQs = [
                        [
                            'id' => 1,
                            'question' => 'What is Nebatech AI Academy?',
                            'answer' => 'Nebatech AI Academy is a leading technology training and service provider based in Tamale, Ghana. We specialize in AI & Machine Learning, software development, IT infrastructure, and digital skills training. Our mission is to empower individuals and businesses with cutting-edge technology solutions.',
                            'keywords' => 'nebatech about company who we are mission vision'
                        ],
                        [
                            'id' => 2,
                            'question' => 'Where are you located?',
                            'answer' => 'We are located at Choggy Yapalsi, Tamale, Ghana. You can reach us at +233 24 763 6080 or +233 24 924 1156, or email us at info@nebatech.com.',
                            'keywords' => 'location address contact where find office tamale ghana'
                        ],
                        [
                            'id' => 3,
                            'question' => 'What services do you offer?',
                            'answer' => 'We offer Mobile & Web Development, Networking & CCTV Installation, Hardware & Software Repairs, AI & Machine Learning Training, Frontend & Backend Development, Database Administration, Graphic Design & Video Editing, and Digital Literacy programs.',
                            'keywords' => 'services offered mobile web development networking cctv ai training'
                        ],
                        [
                            'id' => 18,
                            'question' => 'What are your office hours?',
                            'answer' => '<strong>Monday - Friday:</strong> 8:00 AM - 6:00 PM<br><strong>Saturday:</strong> 9:00 AM - 4:00 PM<br><strong>Sunday:</strong> Closed (Emergency support available)<br><br>We recommend calling ahead (+233 24 924 1156) to schedule an appointment.',
                            'keywords' => 'office hours working time open close visit'
                        ],
                        [
                            'id' => 19,
                            'question' => 'Do you offer group discounts?',
                            'answer' => 'Yes! We offer special discounts for group enrollments of 3 or more students. Contact us at +233 24 924 1156 or info@nebatech.com for details on bulk training packages.',
                            'keywords' => 'group discount bulk corporate team training pricing'
                        ],
                        [
                            'id' => 20,
                            'question' => 'How long have you been in business?',
                            'answer' => 'Nebatech has been serving the Northern Region of Ghana since 2018, providing quality technology training and services. We\'ve trained over 500 students and completed numerous successful projects.',
                            'keywords' => 'history experience years established since when started'
                        ]
                    ];

                    foreach ($generalFAQs as $faq): ?>
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden border border-gray-200 dark:border-gray-600 faq-item" id="faq-<?= $faq['id'] ?>" data-category="general" data-keywords="<?= $faq['keywords'] ?>">
                        <button @click="toggleFAQ(<?= $faq['id'] ?>)" 
                                class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <div class="flex-1 pr-4">
                                <span class="text-lg font-semibold text-gray-900 dark:text-white"><?= $faq['question'] ?></span>
                                <div class="flex items-center gap-4 mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                        <span x-text="faqStats[<?= $faq['id'] ?>]?.views || Math.floor(Math.random() * 500 + 100)"></span> views
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/></svg>
                                        <span x-text="faqStats[<?= $faq['id'] ?>]?.helpful || Math.floor(Math.random() * 100 + 20)"></span>
                                    </span>
                                </div>
                            </div>
                            <svg class="w-6 h-6 text-secondary transition-transform flex-shrink-0" :class="{ 'rotate-180': openFaqs.includes(<?= $faq['id'] ?>) }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="openFaqs.includes(<?= $faq['id'] ?>)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-5 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4"><?= $faq['answer'] ?></p>
                            
                            <!-- Action Buttons -->
                            <div class="flex flex-wrap items-center gap-3 mb-4">
                                <button @click="shareFAQ(<?= $faq['id'] ?>, '<?= addslashes($faq['question']) ?>')" class="flex items-center gap-2 px-4 py-2 bg-blue-100 hover:bg-blue-200 dark:bg-primary/90 dark:hover:bg-primary/80 text-primary dark:text-white/80 rounded-lg transition-colors text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                    Share
                                </button>
                                <button @click="emailFAQ(<?= $faq['id'] ?>, '<?= addslashes($faq['question']) ?>')" class="flex items-center gap-2 px-4 py-2 bg-purple-100 hover:bg-purple-200 dark:bg-purple-900 dark:hover:bg-purple-800 text-purple-700 dark:text-purple-300 rounded-lg transition-colors text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    Email
                                </button>
                            </div>
                            
                            <!-- Rating System -->
                            <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">Rate this answer:</span>
                                    <div class="flex gap-1">
                                        <template x-for="star in 5" :key="star">
                                            <button @click="rateFAQ(<?= $faq['id'] ?>, star)" 
                                                    :class="star <= (faqRatings[<?= $faq['id'] ?>] || 0) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'"
                                                    class="hover:text-yellow-400 transition-colors">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">Was this helpful?</span>
                                    <div class="flex gap-3">
                                        <button @click="submitFeedback(<?= $faq['id'] ?>, 'helpful')" class="px-5 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors font-semibold flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                            Yes
                                        </button>
                                        <button @click="submitFeedback(<?= $faq['id'] ?>, 'not-helpful')" class="px-5 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors font-semibold flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                            No
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>

            <!-- Training Programs -->
            <div class="mb-12" id="training" x-show="activeCategory === 'all' || activeCategory === 'training'">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 pb-3 border-b-4 border-secondary">Training Programs</h2>
                <div class="space-y-4">
                    
                    <?php
                    $trainingFAQs = [
                        [
                            'id' => 4,
                            'question' => 'How do I enroll in a training program?',
                            'answer' => 'Visit our office at Choggy Yapalsi, Tamale, call us at +233 24 924 1156, or email info@nebatech.com. Our team will guide you through the enrollment process, discuss payment options, and help you choose the right program.',
                            'keywords' => 'enroll enrollment register how to join sign up'
                        ],
                        [
                            'id' => 5,
                            'question' => 'Are the courses free?',
                            'answer' => 'Most of our training programs require payment. However, we occasionally offer scholarships and discounts. Contact us to learn about current promotions and payment plans.',
                            'keywords' => 'courses free cost pricing paid scholarship discount'
                        ],
                        [
                            'id' => 6,
                            'question' => 'Do you offer certificates?',
                            'answer' => 'Yes! Upon successful completion of any training program, you\'ll receive an official certificate from Nebatech AI Academy, which you can add to your portfolio and resume.',
                            'keywords' => 'certificate certification credentials diploma validation'
                        ],
                        [
                            'id' => 7,
                            'question' => 'What is the duration of training programs?',
                            'answer' => 'Program duration varies: short courses (2-4 weeks), standard programs (2-3 months), and advanced programs (4-6 months). Specific timelines are provided during enrollment.',
                            'keywords' => 'duration length time how long weeks months training'
                        ],
                        [
                            'id' => 8,
                            'question' => 'Do I need prior experience?',
                            'answer' => 'It depends on the program. We offer beginner-friendly courses like Digital Literacy that require no prior experience, as well as advanced courses like AI & Machine Learning that may require some programming background. Check each course\'s prerequisites for specific requirements.',
                            'keywords' => 'prerequisites requirements experience beginner advanced skills'
                        ],
                        [
                            'id' => 12,
                            'question' => 'What payment methods do you accept?',
                            'answer' => 'We accept cash, mobile money (MTN, Vodafone, AirtelTigo), bank transfers, and installment payment plans. Contact us for flexible payment options.',
                            'keywords' => 'payment methods mobile money cash transfer installment'
                        ],
                        [
                            'id' => 13,
                            'question' => 'Can I choose my class schedule?',
                            'answer' => 'Yes! We offer weekday, weekend, and evening classes. We also have full-time and part-time options to accommodate your work or school schedule.',
                            'keywords' => 'schedule time classes flexible weekend evening full-time'
                        ],
                        [
                            'id' => 14,
                            'question' => 'Do I need to bring my own laptop?',
                            'answer' => 'While we have computers available, we recommend bringing your own laptop for a better learning experience. This allows you to practice at home and work on projects.',
                            'keywords' => 'laptop computer equipment requirements bring own device'
                        ],
                        [
                            'id' => 15,
                            'question' => 'Do you help with job placement?',
                            'answer' => 'Yes! We provide career guidance, portfolio building, resume preparation, and connect graduates with local and international job opportunities through our network.',
                            'keywords' => 'job placement career employment opportunities work internship'
                        ],
                        [
                            'id' => 16,
                            'question' => 'What is your refund policy?',
                            'answer' => 'Refunds are available within the first week if you\'re not satisfied with the program. After that, fees are non-refundable, but you can transfer to another program.',
                            'keywords' => 'refund policy money back guarantee cancellation'
                        ],
                        [
                            'id' => 17,
                            'question' => 'Are classes online or in-person?',
                            'answer' => '<strong>In-Person:</strong> At our Choggy Yapalsi training center with hands-on labs<br><strong>Online:</strong> Live virtual sessions via Zoom/Google Meet<br><strong>Hybrid:</strong> Combination of online theory and in-person practicals<br><br>Most programs are available in all three modes with the same quality instruction.',
                            'keywords' => 'online in-person hybrid virtual zoom remote physical location'
                        ]
                    ];

                    foreach ($trainingFAQs as $faq): ?>
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden border border-gray-200 dark:border-gray-600 faq-item" id="faq-<?= $faq['id'] ?>" data-category="training" data-keywords="<?= $faq['keywords'] ?>">
                        <button @click="toggleFAQ(<?= $faq['id'] ?>)" 
                                class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <div class="flex-1 pr-4">
                                <span class="text-lg font-semibold text-gray-900 dark:text-white"><?= $faq['question'] ?></span>
                                <div class="flex items-center gap-4 mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span x-text="faqStats[<?= $faq['id'] ?>]?.views || <?= rand(50, 500) ?>"></span> views
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        <span x-text="faqStats[<?= $faq['id'] ?>]?.helpful || <?= rand(20, 100) ?>"></span> helpful
                                    </span>
                                </div>
                            </div>
                            <svg class="w-6 h-6 text-secondary transition-transform flex-shrink-0" :class="{ 'rotate-180': openFaqs.includes(<?= $faq['id'] ?>) }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="openFaqs.includes(<?= $faq['id'] ?>)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-5 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600"
                             x-init="incrementViews(<?= $faq['id'] ?>)">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4"><?= $faq['answer'] ?></p>
                            
                            <!-- Action Buttons -->
                            <div class="flex flex-wrap items-center gap-3 mb-4">
                                <button @click="shareFAQ(<?= $faq['id'] ?>, '<?= addslashes($faq['question']) ?>')" 
                                        class="px-4 py-2 bg-blue-100 hover:bg-blue-200 text-primary rounded-lg transition-colors font-semibold flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                    Share
                                </button>
                                <button @click="emailFAQ(<?= $faq['id'] ?>, '<?= addslashes($faq['question']) ?>')" 
                                        class="px-4 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded-lg transition-colors font-semibold flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    Email
                                </button>
                            </div>
                            
                            <!-- Rating and Feedback -->
                            <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-3">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">Rate this answer:</span>
                                    <div class="flex gap-1">
                                        <template x-for="star in 5" :key="star">
                                            <button @click="rateFAQ(<?= $faq['id'] ?>, star)" 
                                                    :class="star <= (faqRatings[<?= $faq['id'] ?>] || 0) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'"
                                                    class="text-2xl hover:scale-110 transition-transform focus:outline-none">★</button>
                                        </template>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">Was this helpful?</span>
                                    <div class="flex gap-3">
                                        <button @click="submitFeedback(<?= $faq['id'] ?>, 'helpful')" class="px-5 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors font-semibold flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                            Yes
                                        </button>
                                        <button @click="submitFeedback(<?= $faq['id'] ?>, 'not-helpful')" class="px-5 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors font-semibold flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                            No
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>

            <!-- Technical Support -->
            <div class="mb-12" id="support" x-show="activeCategory === 'all' || activeCategory === 'support'">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 pb-3 border-b-4 border-secondary">Technical Support</h2>
                <div class="space-y-4">
                    
                    <?php
                    $supportFAQs = [
                        [
                            'id' => 9,
                            'question' => 'Do you offer 24/7 support?',
                            'answer' => 'Yes, we provide 24/7 technical support for our clients and students. You can reach us through our contact channels, and our team will respond promptly to assist with any technical issues or questions.',
                            'keywords' => '24/7 support hours availability help assistance'
                        ],
                        [
                            'id' => 10,
                            'question' => 'Can you handle hardware repairs?',
                            'answer' => 'Absolutely! We have certified experts who can repair and maintain various types of hardware including computers, laptops, servers, networking equipment, and more. Contact us for a diagnostic consultation.',
                            'keywords' => 'hardware repairs fix computer laptop server maintenance'
                        ],
                        [
                            'id' => 11,
                            'question' => 'Do you provide on-site services?',
                            'answer' => 'Yes! We offer on-site services for networking installations, CCTV setup, hardware repairs, and system maintenance at your home or office in Tamale and surrounding areas.',
                            'keywords' => 'on-site visit home office field service installation'
                        ],
                        [
                            'id' => 21,
                            'question' => 'Can I get remote support?',
                            'answer' => '<strong>Remote Desktop Support:</strong> Solve issues via screen sharing<br><strong>Phone & WhatsApp:</strong> Guided troubleshooting<br><strong>Email Support:</strong> Detailed technical guidance<br><strong>Video Consultation:</strong> Live diagnosis<br><br>Remote support is available for software issues, configuration problems, and training questions.',
                            'keywords' => 'remote support online help virtual assistance troubleshooting'
                        ],
                        [
                            'id' => 22,
                            'question' => 'Do you offer warranty on repairs?',
                            'answer' => '<strong>Hardware Repairs:</strong> 30-90 days warranty<br><strong>Replacement Parts:</strong> Manufacturer warranty<br><strong>Software Services:</strong> 14 days support<br><strong>Installation Work:</strong> 6 months warranty<br><br>Our warranty covers workmanship and defects in parts we install.',
                            'keywords' => 'warranty guarantee coverage repairs protection'
                        ]
                    ];

                    foreach ($supportFAQs as $faq): ?>
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden border border-gray-200 dark:border-gray-600 faq-item" id="faq-<?= $faq['id'] ?>" data-category="support" data-keywords="<?= $faq['keywords'] ?>">
                        <button @click="toggleFAQ(<?= $faq['id'] ?>)" 
                                class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <div class="flex-1 pr-4">
                                <span class="text-lg font-semibold text-gray-900 dark:text-white"><?= $faq['question'] ?></span>
                                <div class="flex items-center gap-4 mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span x-text="faqStats[<?= $faq['id'] ?>]?.views || <?= rand(50, 500) ?>"></span> views
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        <span x-text="faqStats[<?= $faq['id'] ?>]?.helpful || <?= rand(20, 100) ?>"></span> helpful
                                    </span>
                                </div>
                            </div>
                            <svg class="w-6 h-6 text-secondary transition-transform flex-shrink-0" :class="{ 'rotate-180': openFaqs.includes(<?= $faq['id'] ?>) }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="openFaqs.includes(<?= $faq['id'] ?>)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-5 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600"
                             x-init="incrementViews(<?= $faq['id'] ?>)">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4"><?= $faq['answer'] ?></p>
                            
                            <!-- Action Buttons -->
                            <div class="flex flex-wrap items-center gap-3 mb-4">
                                <button @click="shareFAQ(<?= $faq['id'] ?>, '<?= addslashes($faq['question']) ?>')" 
                                        class="px-4 py-2 bg-blue-100 hover:bg-blue-200 text-primary rounded-lg transition-colors font-semibold flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                    Share
                                </button>
                                <button @click="emailFAQ(<?= $faq['id'] ?>, '<?= addslashes($faq['question']) ?>')" 
                                        class="px-4 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded-lg transition-colors font-semibold flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    Email
                                </button>
                            </div>
                            
                            <!-- Rating and Feedback -->
                            <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-3">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">Rate this answer:</span>
                                    <div class="flex gap-1">
                                        <template x-for="star in 5" :key="star">
                                            <button @click="rateFAQ(<?= $faq['id'] ?>, star)" 
                                                    :class="star <= (faqRatings[<?= $faq['id'] ?>] || 0) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'"
                                                    class="text-2xl hover:scale-110 transition-transform focus:outline-none">★</button>
                                        </template>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">Was this helpful?</span>
                                    <div class="flex gap-3">
                                        <button @click="submitFeedback(<?= $faq['id'] ?>, 'helpful')" class="px-5 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors font-semibold flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                            Yes
                                        </button>
                                        <button @click="submitFeedback(<?= $faq['id'] ?>, 'not-helpful')" class="px-5 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors font-semibold flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                            No
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>

            <!-- Contact CTA -->
            <div class="bg-gradient-to-br from-primary to-blue-900 rounded-xl p-8 md:p-12 text-center text-white shadow-xl">
                <h3 class="text-3xl font-bold mb-4">Still Have Questions?</h3>
                <p class="text-lg mb-8 max-w-2xl mx-auto">Can't find the answer you're looking for? Our team is here to help!</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?= url('/contact') ?>" class="inline-block bg-secondary hover:bg-orange-600 text-white font-bold text-lg px-8 py-4 rounded-lg transition-all transform hover:scale-105 shadow-lg">
                        Contact Us
                    </a>
                    <a href="tel:+233249241156" class="inline-block bg-white hover:bg-gray-100 text-primary font-bold text-lg px-8 py-4 rounded-lg transition-all transform hover:scale-105 shadow-lg">
                        📞 Call +233 24 924 1156
                    </a>
                    <button @click="openLiveChat()" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold text-lg px-8 py-4 rounded-lg transition-all transform hover:scale-105 shadow-lg">
                        💬 Live Chat
                    </button>
                </div>
            </div>

        </div>
    </div>
    </div>
    
    <!-- Floating Back to Top Button -->
    <button @click="scrollToTop()" 
            x-show="showBackToTop" 
            x-transition
            @scroll.window="showBackToTop = window.pageYOffset > 300"
            class="fixed bottom-6 right-6 bg-secondary hover:bg-orange-600 text-white p-4 rounded-full shadow-2xl transition-all transform hover:scale-110 z-40">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
    </button>
    
    <!-- Live Chat Widget (Hidden by default) -->
    <div x-show="liveChatOpen" 
         x-transition
         class="fixed bottom-24 right-6 w-96 bg-white dark:bg-gray-800 rounded-lg shadow-2xl z-50 overflow-hidden">
        <div class="bg-primary text-white p-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                <span class="font-bold">Live Support</span>
            </div>
            <button @click="liveChatOpen = false" class="hover:bg-primary/80 p-1 rounded">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-6 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">We're Here to Help!</h4>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Chat with our support team for instant answers</p>
            <div class="space-y-2">
                <a href="https://wa.me/233249241156" target="_blank" class="block w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition-colors">
                    WhatsApp Chat
                </a>
                <a href="tel:+233249241156" class="block w-full bg-primary hover:bg-primary/70 text-white font-bold py-3 rounded-lg transition-colors">
                    Call Us Now
                </a>
                <a href="<?= url('/contact') ?>" class="block w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 rounded-lg transition-colors">
                    Contact Form
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Print Styles -->
<style>
    @media print {
        .print\:hidden {
            display: none !important;
        }
        
        body {
            background: white !important;
        }
        
        .faq-item {
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        [x-show] {
            display: block !important;
        }
    }
</style>

<script>
function faqManager() {
    return {
        openFaqs: [],
        activeCategory: 'all',
        totalFAQs: 22,
        searchQuery: '',
        searchActive: false,
        searchResults: 0,
        showBackToTop: false,
        liveChatOpen: false,
        faqRatings: {},
        faqStats: {},
        
        init() {
            // Load stats from localStorage
            this.faqStats = JSON.parse(localStorage.getItem('faqStats')) || {};
            this.faqRatings = JSON.parse(localStorage.getItem('faqRatings')) || {};
            
            // Handle hash navigation
            if (window.location.hash) {
                const faqId = window.location.hash.substring(1);
                const faqNumber = parseInt(faqId.replace('faq-', ''));
                if (!isNaN(faqNumber)) {
                    this.toggleFAQ(faqNumber);
                    this.incrementViews(faqNumber);
                    setTimeout(() => {
                        document.getElementById(faqId)?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 100);
                }
            }
            
            // Keyboard shortcuts
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.clearSearch();
                    this.liveChatOpen = false;
                }
                if (e.ctrlKey && e.key === 'k') {
                    e.preventDefault();
                    document.querySelector('input[type="text"]')?.focus();
                }
            });
        },
        
        toggleFAQ(id) {
            const index = this.openFaqs.indexOf(id);
            if (index > -1) {
                this.openFaqs.splice(index, 1);
            } else {
                this.openFaqs.push(id);
                this.incrementViews(id);
            }
        },
        
        expandAll() {
            this.openFaqs = Array.from({length: this.totalFAQs}, (_, i) => i + 1);
        },
        
        collapseAll() {
            this.openFaqs = [];
        },
        
        filterCategory(category) {
            this.activeCategory = category;
            this.collapseAll();
        },
        
        searchFAQs(query) {
            const searchTerm = query.toLowerCase().trim();
            
            if (searchTerm.length === 0) {
                this.clearSearch();
                return;
            }
            
            this.searchActive = true;
            const faqItems = document.querySelectorAll('.faq-item');
            let matches = 0;
            
            faqItems.forEach(item => {
                const keywords = item.dataset.keywords || '';
                const question = item.querySelector('span').textContent.toLowerCase();
                const answer = item.querySelector('p')?.textContent.toLowerCase() || '';
                
                if (question.includes(searchTerm) || answer.includes(searchTerm) || keywords.includes(searchTerm)) {
                    item.style.display = 'block';
                    matches++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            this.searchResults = matches;
        },
        
        quickSearch(term) {
            this.searchQuery = term;
            this.searchFAQs(term);
            document.querySelector('input[type="text"]').value = term;
        },
        
        clearSearch() {
            this.searchActive = false;
            this.searchResults = 0;
            this.searchQuery = '';
            
            const faqItems = document.querySelectorAll('.faq-item');
            faqItems.forEach(item => {
                item.style.display = 'block';
            });
            
            const searchInput = document.querySelector('input[type="text"]');
            if (searchInput) searchInput.value = '';
        },
        
        rateFAQ(faqId, rating) {
            this.faqRatings[faqId] = rating;
            localStorage.setItem('faqRatings', JSON.stringify(this.faqRatings));
            this.showToast(`Thank you for rating this FAQ ${rating} stars!`, 'success');
        },
        
        incrementViews(faqId) {
            if (!this.faqStats[faqId]) {
                this.faqStats[faqId] = { views: 0, helpful: 0 };
            }
            this.faqStats[faqId].views++;
            localStorage.setItem('faqStats', JSON.stringify(this.faqStats));
        },
        
        submitFeedback(faqId, type) {
            if (!this.faqStats[faqId]) {
                this.faqStats[faqId] = { views: 0, helpful: 0 };
            }
            
            if (type === 'helpful') {
                this.faqStats[faqId].helpful++;
                localStorage.setItem('faqStats', JSON.stringify(this.faqStats));
            }
            
            const messages = {
                'helpful': 'Thank you! We\'re glad this helped you.',
                'not-helpful': 'Thanks for your feedback. We\'ll work on improving this answer.'
            };
            
            this.showToast(messages[type], type === 'helpful' ? 'success' : 'info');
        },
        
        shareFAQ(faqId, question) {
            const url = `${window.location.origin}${window.location.pathname}#faq-${faqId}`;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Nebatech AI Academy - FAQ',
                    text: question,
                    url: url
                }).then(() => {
                    this.showToast('FAQ shared successfully!', 'success');
                }).catch(() => {
                    this.copyToClipboard(url);
                });
            } else {
                this.copyToClipboard(url);
            }
        },
        
        emailFAQ(faqId, question) {
            const url = `${window.location.origin}${window.location.pathname}#faq-${faqId}`;
            const subject = encodeURIComponent(`FAQ: ${question}`);
            const body = encodeURIComponent(`Check out this FAQ from Nebatech AI Academy:\n\n${question}\n\n${url}`);
            window.location.href = `mailto:?subject=${subject}&body=${body}`;
        },
        
        copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                this.showToast('Link copied to clipboard!', 'success');
            }).catch(() => {
                this.showToast('Failed to copy link', 'error');
            });
        },
        
        downloadPDF() {
            this.showToast('Preparing PDF download... This feature will be available soon!', 'info');
            // In production, implement PDF generation using jsPDF or server-side solution
        },
        
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
        
        openLiveChat() {
            this.liveChatOpen = true;
        },
        
        showToast(message, type = 'info') {
            const colors = {
                success: 'bg-green-600',
                error: 'bg-red-600',
                info: 'bg-primary'
            };
            
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-2xl z-50 transform transition-all duration-300`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.transform = 'translateY(0)';
            }, 10);
            
            setTimeout(() => {
                toast.style.transform = 'translateY(100px)';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    }
}
</script>


