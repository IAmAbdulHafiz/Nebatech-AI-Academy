<!-- FAQs Hero Section -->
<section class="relative bg-gradient-to-br from-[#001040] via-[#002060] to-[#003080] text-white py-20 overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-secondary rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-primary/90 rounded-full blur-3xl"></div>
    </div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <!-- Breadcrumbs -->
            <nav class="flex justify-center mb-4 text-sm">
                <ol class="flex items-center space-x-2 text-gray-300">
                    <li><a href="<?= url('/') ?>" class="hover:text-secondary transition-colors">Home</a></li>
                    <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                    <li class="text-secondary font-semibold">FAQs</li>
                </ol>
            </nav>
            
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6">
                Frequently Asked <span class="text-secondary">Questions</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-300 mb-8">
                Find answers to common questions about Nebatech AI Academy, our services, and training programs
            </p>
            
            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto" x-data="{ searchQuery: '' }">
                <div class="relative">
                    <input type="text" 
                           x-model="searchQuery"
                           @input="searchFAQs($event.target.value)"
                           placeholder="Search for answers..." 
                           class="w-full px-6 py-4 pr-12 rounded-lg bg-white/10 backdrop-blur-sm border-2 border-white/20 text-white placeholder-gray-300 focus:outline-none focus:border-secondary transition-colors">
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQs Content -->
<section class="py-16 bg-gray-50 dark:bg-gray-900" x-data="faqManager()">
    <div class="container mx-auto px-6">
        <div class="max-w-6xl mx-auto">
            
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar: Table of Contents & Actions -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">
                        <!-- Quick Actions -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 print:hidden">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                <button @click="expandAll()" class="w-full bg-primary hover:bg-primary/70 text-white px-4 py-2 rounded-lg transition-colors text-sm font-semibold flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Expand All
                                </button>
                                <button @click="collapseAll()" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors text-sm font-semibold flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                    Collapse All
                                </button>
                                <button @click="window.print()" class="w-full bg-secondary hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition-colors text-sm font-semibold flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    Print FAQs
                                </button>
                            </div>
                        </div>

                        <!-- Category Filters -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 print:hidden">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-4">Filter by Category</h3>
                            <div class="space-y-2">
                                <button @click="filterCategory('all')" 
                                        :class="activeCategory === 'all' ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                                        class="w-full px-4 py-2 rounded-lg transition-colors text-sm font-semibold text-left">
                                    All Questions (<span x-text="totalFAQs"></span>)
                                </button>
                                <button @click="filterCategory('general')" 
                                        :class="activeCategory === 'general' ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                                        class="w-full px-4 py-2 rounded-lg transition-colors text-sm font-semibold text-left">
                                    General (6)
                                </button>
                                <button @click="filterCategory('training')" 
                                        :class="activeCategory === 'training' ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                                        class="w-full px-4 py-2 rounded-lg transition-colors text-sm font-semibold text-left">
                                    Training Programs (11)
                                </button>
                                <button @click="filterCategory('support')" 
                                        :class="activeCategory === 'support' ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                                        class="w-full px-4 py-2 rounded-lg transition-colors text-sm font-semibold text-left">
                                    Technical Support (5)
                                </button>
                            </div>
                        </div>

                        <!-- Table of Contents -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 print:hidden">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-4">Jump to Section</h3>
                            <nav class="space-y-2">
                                <a href="#general" class="block text-sm text-gray-700 dark:text-gray-300 hover:text-secondary transition-colors">General Questions</a>
                                <a href="#training" class="block text-sm text-gray-700 dark:text-gray-300 hover:text-secondary transition-colors">Training Programs</a>
                                <a href="#support" class="block text-sm text-gray-700 dark:text-gray-300 hover:text-secondary transition-colors">Technical Support</a>
                            </nav>
                        </div>

                        <!-- Popular FAQs -->
                        <div class="bg-gradient-to-br from-orange-50 to-yellow-50 dark:from-gray-800 dark:to-gray-700 rounded-lg shadow-md p-6 print:hidden">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-secondary" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                Most Popular
                            </h3>
                            <div class="space-y-2 text-sm">
                                <a href="#faq-4" class="block text-gray-700 dark:text-gray-300 hover:text-secondary transition-colors">• How do I enroll?</a>
                                <a href="#faq-5" class="block text-gray-700 dark:text-gray-300 hover:text-secondary transition-colors">• Are courses free?</a>
                                <a href="#faq-6" class="block text-gray-700 dark:text-gray-300 hover:text-secondary transition-colors">• Do you offer certificates?</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    
                    <!-- Search Results Count -->
                    <div x-show="searchActive" x-cloak class="mb-6 p-4 bg-blue-50 dark:bg-primary/90/20 border border-white/20 dark:border-primary/80 rounded-lg print:hidden">
                        <p class="text-sm text-blue-800 dark:text-white/80">
                            Found <span x-text="searchResults"></span> result(s) for "<span x-text="currentSearch"></span>"
                            <button @click="clearSearch()" class="ml-2 text-secondary hover:underline font-semibold">Clear search</button>
                        </p>
                    </div>
            
            <!-- General Questions -->
            <div class="mb-12" id="general" x-show="activeCategory === 'all' || activeCategory === 'general'" data-category="general">
                <h2 class="text-3xl font-bold text-primary dark:text-white mb-6">General Questions</h2>
                <div class="space-y-4">
                    
                    <!-- FAQ 1 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-1" data-category="general" data-keywords="nebatech academy about mission what is">
                        <button @click="toggleFAQ(1)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">What is Nebatech AI Academy?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(1, 'What is Nebatech AI Academy?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(1) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(1)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                Nebatech AI Academy is a cutting-edge technology training and services company based in Tamale, Ghana. 
                                We specialize in AI-powered learning, software development, IT infrastructure, and digital skills training. 
                                Our mission is to empower individuals and businesses with the latest technology solutions and practical skills.
                            </p>
                            <!-- Feedback -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(1, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(1, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-2" data-category="general" data-keywords="location address where tamale ghana choggy yapalsi contact">
                        <button @click="toggleFAQ(2)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">Where are you located?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(2, 'Where are you located?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(2) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(2)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                We are located at Choggy Yapalsi, Tamale, Ghana. You can reach us at +233 24 763 6080 or +233 24 924 1156, 
                                or email us at info@nebatech.com.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(2, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(2, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-3" data-category="general" data-keywords="services offered mobile web development networking cctv ai training">
                        <button @click="toggleFAQ(3)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">What services do you offer?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(3, 'What services do you offer?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(3) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(3)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-3">
                                We offer a comprehensive range of technology services and training programs:
                            </p>
                            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2 mb-4">
                                <li><strong>Mobile & Web Development</strong> - Custom software solutions</li>
                                <li><strong>Networking & CCTV Installation</strong> - IT infrastructure setup</li>
                                <li><strong>Hardware & Software Repairs</strong> - Technical support</li>
                                <li><strong>AI & Machine Learning Training</strong> - Advanced tech courses</li>
                                <li><strong>Frontend & Backend Development</strong> - Full-stack training</li>
                                <li><strong>Database Administration</strong> - Data management skills</li>
                                <li><strong>Graphic Design & Video Editing</strong> - Creative skills</li>
                                <li><strong>Digital Literacy</strong> - Basic computer skills</li>
                            </ul>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(3, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(3, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 18 - NEW -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-18" data-category="general" data-keywords="office hours working time open close visit">
                        <button @click="toggleFAQ(18)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">What are your office hours?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(18, 'What are your office hours?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(18) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(18)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-3">
                                Our office is open:
                            </p>
                            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2 mb-4">
                                <li><strong>Monday - Friday:</strong> 8:00 AM - 6:00 PM</li>
                                <li><strong>Saturday:</strong> 9:00 AM - 4:00 PM</li>
                                <li><strong>Sunday:</strong> Closed (Emergency support available)</li>
                            </ul>
                            <p class="text-gray-700 dark:text-gray-300">
                                We recommend calling ahead (+233 24 924 1156) to schedule an appointment for personalized consultation or technical services.
                                For online inquiries, you can email us anytime at info@nebatech.com and we'll respond within 24 hours.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(18, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(18, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 19 - NEW -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-19" data-category="general" data-keywords="group corporate bulk discount team company organizations">
                        <button @click="toggleFAQ(19)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">Do you offer group or corporate discounts?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(19, 'Do you offer group or corporate discounts?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(19) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(19)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-3">
                                Yes! We provide special pricing for groups and corporate training:
                            </p>
                            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2 mb-4">
                                <li><strong>5-10 participants:</strong> 10% discount</li>
                                <li><strong>11-20 participants:</strong> 15% discount</li>
                                <li><strong>21+ participants:</strong> 20% discount + customized training</li>
                                <li><strong>Corporate packages:</strong> Tailored programs with flexible payment terms</li>
                            </ul>
                            <p class="text-gray-700 dark:text-gray-300">
                                We also offer on-site corporate training at your organization's premises. Contact our corporate training team for a custom quote 
                                and to discuss your specific training needs.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(19, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(19, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 20 - NEW -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-20" data-category="general" data-keywords="experience years established history track record">
                        <button @click="toggleFAQ(20)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">How long has Nebatech been in business?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(20, 'How long has Nebatech been in business?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(20) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(20)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                Nebatech has been serving the Northern Region of Ghana since our establishment, building a strong reputation for quality 
                                technology training and reliable IT services. We have successfully trained hundreds of students and supported numerous businesses 
                                with their technology needs.
                            </p>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                Our team brings decades of combined experience in software development, IT infrastructure, and technology education. 
                                We pride ourselves on staying current with the latest industry trends and maintaining strong partnerships with leading 
                                technology companies.
                            </p>
                            <p class="text-gray-700 dark:text-gray-300">
                                Our commitment to excellence and community development has made us a trusted name in tech education and services across Tamale and beyond.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(20, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(20, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Training Programs -->
            <div class="mb-12" id="training" x-show="activeCategory === 'all' || activeCategory === 'training'" data-category="training">
                <h2 class="text-3xl font-bold text-primary dark:text-white mb-6">Training Programs</h2>
                <div class="space-y-4">
                    
                    <!-- FAQ 4 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-4" data-category="training" data-keywords="enroll enrollment register how to join sign up">
                        <button @click="toggleFAQ(4)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">How do I enroll in a training program?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(4, 'How do I enroll in a training program?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(4) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(4)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                You can enroll by registering on our platform, browsing available courses, and clicking "Enroll Now" on your chosen program. 
                                You can also contact us directly via phone or email for personalized guidance on the best program for your goals.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(4, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(4, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 5 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-5" data-category="training" data-keywords="courses free cost pricing paid scholarship discount">
                        <button @click="toggleFAQ(5)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">Are the courses free?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(5, 'Are the courses free?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(5) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(5)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                Our training programs are paid courses designed to provide high-quality, professional instruction with hands-on practice 
                                and industry-recognized certifications. We offer various pricing options and may have scholarships or discounts available. 
                                Contact us for detailed pricing information.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(5, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(5, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 6 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-6" data-category="training" data-keywords="certificate certification credentials diploma validation">
                        <button @click="toggleFAQ(6)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">Do you offer certificates?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(6, 'Do you offer certificates?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(6) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(6)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                Yes! Upon successful completion of any training program, you will receive an industry-recognized certificate from 
                                Nebatech AI Academy. This certificate validates your skills and can be shared with employers or on professional networks like LinkedIn.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(6, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(6, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 7 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-7" data-category="training" data-keywords="duration length time how long weeks months training">
                        <button @click="toggleFAQ(7)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">What is the duration of training programs?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(7, 'What is the duration of training programs?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(7) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(7)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                Program duration varies depending on the course. Most programs range from 4 weeks to 6 months. 
                                Each course page provides detailed information about duration, schedule, and time commitment required.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(7, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(7, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 8 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-8" data-category="training" data-keywords="prerequisites requirements experience beginner advanced skills">
                        <button @click="toggleFAQ(8)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">Do I need prior experience?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(8, 'Do I need prior experience?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(8) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(8)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                It depends on the program. We offer beginner-friendly courses like Digital Literacy that require no prior experience, 
                                as well as advanced courses like AI & Machine Learning that may require some programming background. 
                                Check each course's prerequisites for specific requirements.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(8, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(8, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Technical Support -->
            <div class="mb-12" id="support" x-show="activeCategory === 'all' || activeCategory === 'support'" data-category="support">
                <h2 class="text-3xl font-bold text-primary dark:text-white mb-6">Technical Support</h2>
                <div class="space-y-4">
                    
                    <!-- FAQ 9 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-9" data-category="support" data-keywords="24/7 support hours availability help assistance">
                        <button @click="toggleFAQ(9)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">Do you offer 24/7 support?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(9, 'Do you offer 24/7 support?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(9) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(9)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                Yes, we provide 24/7 technical support for our clients and students. You can reach us through our contact channels, 
                                and our team will respond promptly to assist with any technical issues or questions.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(9, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(9, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 10 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-10" data-category="support" data-keywords="hardware repairs fix computer laptop server maintenance">
                        <button @click="toggleFAQ(10)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">Can you handle hardware repairs?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(10, 'Can you handle hardware repairs?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(10) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(10)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                Absolutely! We have certified experts who can repair and maintain various types of hardware including computers, 
                                laptops, servers, networking equipment, and more. Contact us for a diagnostic consultation.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(10, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(10, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 11 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-11" data-category="support" data-keywords="onsite services installation networking cctv">
                        <button @click="toggleFAQ(11)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">Do you provide on-site services?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(11, 'Do you provide on-site services?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(11) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(11)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                Yes, we offer on-site services for networking installations, CCTV setup, hardware maintenance, and technical support. 
                                We serve clients throughout Tamale and surrounding areas. Contact us to schedule an on-site visit.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(11, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(11, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 12 - NEW -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-12" data-category="training" data-keywords="payment methods how to pay mobile money cash card">
                        <button @click="toggleFAQ(12)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">What payment methods do you accept?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(12, 'What payment methods do you accept?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(12) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(12)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-3">
                                We accept multiple payment methods to make enrollment convenient for you:
                            </p>
                            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2 mb-4">
                                <li><strong>Mobile Money</strong> - MTN, Vodafone, AirtelTigo</li>
                                <li><strong>Bank Transfer</strong> - Direct transfer to our account</li>
                                <li><strong>Cash Payment</strong> - At our Choggy Yapalsi office</li>
                                <li><strong>Card Payment</strong> - Visa, Mastercard (online)</li>
                            </ul>
                            <p class="text-gray-700 dark:text-gray-300">
                                Payment plans and installment options are available for selected programs. Contact us for more details.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(12, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(12, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 13 - NEW -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-13" data-category="training" data-keywords="class schedule time when weekdays weekends evening">
                        <button @click="toggleFAQ(13)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">What are the class schedules?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(13, 'What are the class schedules?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(13) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(13)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-3">
                                We offer flexible class schedules to accommodate different lifestyles:
                            </p>
                            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2 mb-4">
                                <li><strong>Weekday Classes</strong> - Monday to Friday, 9:00 AM - 5:00 PM</li>
                                <li><strong>Evening Classes</strong> - Monday to Friday, 6:00 PM - 9:00 PM</li>
                                <li><strong>Weekend Classes</strong> - Saturday & Sunday, 10:00 AM - 4:00 PM</li>
                                <li><strong>Online Classes</strong> - Flexible timing with recorded sessions</li>
                            </ul>
                            <p class="text-gray-700 dark:text-gray-300">
                                You can choose the schedule that works best for you during enrollment. Some programs also offer self-paced learning options.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(13, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(13, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 14 - NEW -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-14" data-category="training" data-keywords="laptop computer requirements need own device">
                        <button @click="toggleFAQ(14)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">Do I need my own laptop/computer?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(14, 'Do I need my own laptop/computer?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(14) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(14)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-3">
                                For physical classes, we provide computers and all necessary equipment at our training facility. However, we recommend having your own laptop for:
                            </p>
                            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2 mb-3">
                                <li>Practice at home and complete assignments</li>
                                <li>Better learning retention through personal hands-on experience</li>
                                <li>Online classes participation</li>
                            </ul>
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>Minimum recommended specs:</strong> Intel i3 or equivalent, 4GB RAM, 128GB storage. 
                                If you need help acquiring a laptop, we can provide guidance on affordable options.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(14, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(14, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 15 - NEW -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-15" data-category="training" data-keywords="job placement career employment help internship">
                        <button @click="toggleFAQ(15)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">Do you help with job placement?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(15, 'Do you help with job placement?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(15) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(15)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-3">
                                Yes! We provide comprehensive career support including:
                            </p>
                            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2 mb-4">
                                <li><strong>Resume/CV Building</strong> - Professional profile creation</li>
                                <li><strong>Portfolio Development</strong> - Showcase your projects</li>
                                <li><strong>Interview Preparation</strong> - Mock interviews and tips</li>
                                <li><strong>Job Referrals</strong> - Connect with our partner companies</li>
                                <li><strong>Internship Opportunities</strong> - Gain real-world experience</li>
                                <li><strong>Freelance Guidance</strong> - Start your own tech business</li>
                            </ul>
                            <p class="text-gray-700 dark:text-gray-300">
                                We maintain partnerships with local and international tech companies and regularly share job openings with our graduates.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(15, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(15, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 16 - NEW -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-16" data-category="training" data-keywords="refund money back cancel guarantee policy">
                        <button @click="toggleFAQ(16)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">What is your refund policy?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(16, 'What is your refund policy?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(16) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(16)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-3">
                                We offer a satisfaction guarantee with our refund policy:
                            </p>
                            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2 mb-4">
                                <li><strong>7-Day Money-Back Guarantee</strong> - Full refund if you're not satisfied within the first 7 days</li>
                                <li><strong>Partial Refunds</strong> - Pro-rated refund if you withdraw within the first 2 weeks</li>
                                <li><strong>Course Transfer</strong> - Switch to a different program if the current one isn't right for you</li>
                                <li><strong>Medical/Emergency Cases</strong> - Special consideration for unforeseen circumstances</li>
                            </ul>
                            <p class="text-gray-700 dark:text-gray-300">
                                After 2 weeks, no refunds are provided, but you can defer to the next cohort. Please review our full terms and conditions for complete details.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(16, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(16, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 17 - NEW -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-17" data-category="training" data-keywords="online physical classroom hybrid remote virtual">
                        <button @click="toggleFAQ(17)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">Are classes online or in-person?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(17, 'Are classes online or in-person?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(17) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(17)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-3">
                                We offer three learning modes to suit your preference:
                            </p>
                            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2 mb-4">
                                <li><strong>In-Person Classes</strong> - At our Choggy Yapalsi training center with hands-on labs and equipment</li>
                                <li><strong>Online Classes</strong> - Live virtual sessions via Zoom/Google Meet with recorded playback</li>
                                <li><strong>Hybrid Model</strong> - Combination of online theory and in-person practical sessions</li>
                            </ul>
                            <p class="text-gray-700 dark:text-gray-300">
                                Most programs are available in all three modes. Online students get the same quality instruction, materials, and certification as in-person students. 
                                All classes include access to our learning management system with course materials, assignments, and community forum.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(17, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(17, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 21 - NEW -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-21" data-category="support" data-keywords="remote support online help virtual assistance troubleshooting">
                        <button @click="toggleFAQ(21)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">Can I get remote support?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(21, 'Can I get remote support?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(21) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(21)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-3">
                                Yes! We offer comprehensive remote support services:
                            </p>
                            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2 mb-4">
                                <li><strong>Remote Desktop Support</strong> - Solve issues via screen sharing</li>
                                <li><strong>Phone & WhatsApp Support</strong> - Guided troubleshooting</li>
                                <li><strong>Email Support</strong> - Detailed technical guidance</li>
                                <li><strong>Video Consultation</strong> - Live diagnosis and fixes</li>
                            </ul>
                            <p class="text-gray-700 dark:text-gray-300">
                                Remote support is available for software issues, configuration problems, training questions, and general IT guidance. 
                                For hardware problems, we'll assess remotely first and schedule an on-site visit if needed.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(21, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(21, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 22 - NEW -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden faq-item" id="faq-22" data-category="support" data-keywords="warranty guarantee coverage repairs protection">
                        <button @click="toggleFAQ(22)" 
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">Do you offer warranty on repairs?</span>
                            <div class="flex items-center gap-3">
                                <button @click.stop="shareFAQ(22, 'Do you offer warranty on repairs?')" class="text-gray-400 hover:text-secondary transition-colors print:hidden" title="Share this FAQ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                                <svg class="w-5 h-5 text-secondary transition-transform" :class="{ 'rotate-180': openFaqs.includes(22) }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaqs.includes(22)" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-300 mb-3">
                                Yes, we stand behind our work with comprehensive warranty coverage:
                            </p>
                            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2 mb-4">
                                <li><strong>Hardware Repairs:</strong> 30-90 days warranty depending on the repair type</li>
                                <li><strong>Replacement Parts:</strong> Warranty as per manufacturer specifications</li>
                                <li><strong>Software Services:</strong> 14 days support for configuration issues</li>
                                <li><strong>Installation Work:</strong> 6 months warranty on networking and CCTV installations</li>
                            </ul>
                            <p class="text-gray-700 dark:text-gray-300">
                                Our warranty covers workmanship and defects in parts we install. Physical damage, liquid damage, or misuse after repair 
                                are not covered. We provide free service for any issues arising from our work during the warranty period.
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600 print:hidden">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Was this helpful?</span>
                                <div class="flex gap-2">
                                    <button @click="submitFeedback(22, 'helpful')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Yes
                                    </button>
                                    <button @click="submitFeedback(22, 'not-helpful')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Still Have Questions? -->
            <div class="bg-gradient-to-br from-primary to-blue-900 rounded-xl p-8 text-center text-white print:hidden">
                <h3 class="text-2xl font-bold mb-4">Still Have Questions?</h3>
                <p class="text-lg mb-6">Can't find the answer you're looking for? Our team is here to help!</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?= url('/contact') ?>" class="inline-block bg-secondary hover:bg-orange-600 text-white font-semibold px-8 py-3 rounded-lg transition-colors">
                        Contact Us
                    </a>
                    <a href="tel:+233249241156" class="inline-block bg-white hover:bg-gray-100 text-primary font-semibold px-8 py-3 rounded-lg transition-colors">
                        Call +233 24 924 1156
                    </a>
                </div>
            </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- Print Styles -->
<style>
    @media print {
        .print\\:hidden {
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
        
        .sticky {
            position: relative !important;
        }
    }
    
    [x-cloak] {
        display: none !important;
    }
</style>

<script>
function faqManager() {
    return {
        openFaqs: [],
        activeCategory: 'all',
        searchActive: false,
        searchResults: 0,
        currentSearch: '',
        totalFAQs: 22,
        
        init() {
            // Check for hash in URL on load
            if (window.location.hash) {
                const faqId = window.location.hash.substring(1);
                const faqNumber = parseInt(faqId.replace('faq-', ''));
                if (!isNaN(faqNumber)) {
                    this.toggleFAQ(faqNumber);
                    setTimeout(() => {
                        document.getElementById(faqId)?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 100);
                }
            }
        },
        
        toggleFAQ(id) {
            const index = this.openFaqs.indexOf(id);
            if (index > -1) {
                this.openFaqs.splice(index, 1);
            } else {
                this.openFaqs.push(id);
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
            this.currentSearch = query;
            
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
        
        clearSearch() {
            this.searchActive = false;
            this.currentSearch = '';
            this.searchResults = 0;
            
            const faqItems = document.querySelectorAll('.faq-item');
            faqItems.forEach(item => {
                item.style.display = 'block';
            });
            
            // Clear search input
            const searchInput = document.querySelector('input[type="text"]');
            if (searchInput) searchInput.value = '';
        },
        
        submitFeedback(faqId, type) {
            // Show feedback confirmation
            const messages = {
                'helpful': 'Thank you! We\'re glad this helped you.',
                'not-helpful': 'Thanks for your feedback. We\'ll work on improving this answer.'
            };
            
            // Create toast notification
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-primary text-white px-6 py-3 rounded-lg shadow-2xl z-50 transform transition-all duration-300';
            toast.textContent = messages[type];
            document.body.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.style.transform = 'translateY(0)';
            }, 10);
            
            // Remove after 3 seconds
            setTimeout(() => {
                toast.style.transform = 'translateY(100px)';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
            
            // In production, send feedback to backend
            console.log(`FAQ ${faqId} marked as ${type}`);
        },
        
        shareFAQ(faqId, question) {
            const url = `${window.location.origin}${window.location.pathname}#faq-${faqId}`;
            
            // Check if Web Share API is supported
            if (navigator.share) {
                navigator.share({
                    title: 'Nebatech AI Academy - FAQ',
                    text: question,
                    url: url
                }).then(() => {
                    console.log('FAQ shared successfully');
                }).catch((error) => {
                    console.log('Error sharing:', error);
                    this.copyToClipboard(url);
                });
            } else {
                // Fallback: copy to clipboard
                this.copyToClipboard(url);
            }
        },
        
        copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                // Show success message
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-4 right-4 bg-secondary text-white px-6 py-3 rounded-lg shadow-2xl z-50';
                toast.innerHTML = '<div class="flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>Link copied to clipboard!</span></div>';
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(20px)';
                    setTimeout(() => toast.remove(), 300);
                }, 2500);
            }).catch(err => {
                console.error('Failed to copy:', err);
            });
        }
    }
}

// Global search function
function searchFAQs(query) {
    const component = Alpine.$data(document.querySelector('[x-data="faqManager()"]'));
    if (component) {
        component.searchFAQs(query);
    }
}
</script>


