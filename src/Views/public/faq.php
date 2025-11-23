<?php 
$content = ob_start(); 
?>

<!-- Hero Section -->
<section class="bg-gradient-to-br from-primary via-blue-600 to-purple-700 text-white py-24 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-secondary rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-green-400 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>
    
    <!-- Floating Icons -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-20 text-white/20 animate-bounce" style="animation-delay: 0.5s;">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
        </div>
        <div class="absolute top-32 right-32 text-white/20 animate-bounce" style="animation-delay: 1.5s;">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z"/>
            </svg>
        </div>
        <div class="absolute bottom-32 left-32 text-white/20 animate-bounce" style="animation-delay: 2.5s;">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M7.07,18.28C7.5,17.38 8.12,16.5 8.91,15.77C9.71,15.04 10.69,14.5 11.71,14.22C12.73,13.95 13.76,13.89 14.71,14.06C15.66,14.22 16.54,14.6 17.29,15.18C16.97,16.19 16.5,17.13 15.9,17.95C15.3,18.77 14.55,19.44 13.67,19.93C12.79,20.43 11.8,20.73 10.79,20.83C9.78,20.93 8.76,20.82 7.79,20.5C7.16,19.84 7.07,18.28 7.07,18.28Z"/>
            </svg>
        </div>
    </div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-5xl mx-auto text-center">
            <!-- Enhanced Badge -->
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 text-white px-6 py-3 rounded-full text-sm font-semibold mb-8 shadow-lg">
                <svg class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M7.07,18.28C7.5,17.38 8.12,16.5 8.91,15.77C9.71,15.04 10.69,14.5 11.71,14.22C12.73,13.95 13.76,13.89 14.71,14.06C15.66,14.22 16.54,14.6 17.29,15.18C16.97,16.19 16.5,17.13 15.9,17.95C15.3,18.77 14.55,19.44 13.67,19.93C12.79,20.43 11.8,20.73 10.79,20.83C9.78,20.93 8.76,20.82 7.79,20.5C7.16,19.84 7.07,18.28 7.07,18.28Z"/>
                </svg>
                <span>Quick Answers</span>
                <span class="text-yellow-300">•</span>
                <span>Expert Support Available 24/7</span>
            </div>
            
            <!-- Main Title with Animation -->
            <h1 class="text-6xl md:text-7xl font-bold mb-8 leading-tight">
                <span class="bg-gradient-to-r from-white via-blue-100 to-purple-100 bg-clip-text text-transparent">
                    Frequently Asked
                </span>
                <br>
                <span class="text-yellow-300">Questions</span>
            </h1>
            
            <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto leading-relaxed mb-8">
                Find instant answers to common questions about Nebatech's services, training programs, and support options
            </p>
            
            <!-- Quick Search Bar -->
            <div class="max-w-2xl mx-auto" x-data="{ heroSearchTerm: '' }">
                <div class="relative">
                    <input type="text" 
                           x-model="heroSearchTerm"
                           @keydown.enter="performHeroSearch()"
                           placeholder="Search for answers..." 
                           class="w-full px-6 py-4 pl-14 pr-16 text-gray-800 bg-white/95 backdrop-blur-sm border border-white/30 rounded-2xl focus:outline-none focus:ring-4 focus:ring-white/30 focus:border-white shadow-xl text-lg">
                    <div class="absolute left-5 top-1/2 transform -translate-y-1/2">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <button @click="performHeroSearch()" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Categories & Content Container -->
<div x-data="{ 
    openFaq: null, 
    activeCategory: 'all', 
    searchTerm: '',
    
    // Method to filter FAQs based on search and category
    showFAQ(category) {
        return this.activeCategory === 'all' || this.activeCategory === category.toLowerCase();
    },
    
    // Method to get FAQ count for each category
    getFAQCount(category) {
        const faqs = document.querySelectorAll(`[data-faq-category]`);
        if (category === 'all') return faqs.length;
        
        let count = 0;
        faqs.forEach(faq => {
            if (faq.textContent.toLowerCase() === category.toLowerCase()) count++;
        });
        return count;
    }
}">
    <!-- FAQ Categories -->
    <section class="py-12 bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200">
        <div class="container mx-auto px-6">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Browse by Category</h2>
                <p class="text-gray-600">Find answers organized by topic</p>
            </div>
            
            <div class="flex flex-wrap justify-center gap-4">
                <button @click="activeCategory = 'all'; openFaq = null" 
                        :class="activeCategory === 'all' ? 'bg-gradient-to-r from-primary to-blue-600 text-white shadow-xl scale-105' : 'bg-white text-gray-700 hover:bg-gray-50 hover:shadow-lg border border-gray-200'"
                        class="px-8 py-4 rounded-2xl font-semibold transition-all duration-300 transform hover:scale-105 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    All Questions
                </button>
                <button @click="activeCategory = 'services'; openFaq = null" 
                        :class="activeCategory === 'services' ? 'bg-gradient-to-r from-primary to-blue-600 text-white shadow-xl scale-105' : 'bg-white text-gray-700 hover:bg-gray-50 hover:shadow-lg border border-gray-200'"
                        class="px-8 py-4 rounded-2xl font-semibold transition-all duration-300 transform hover:scale-105 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V6"/>
                    </svg>
                    Services
                </button>
                <button @click="activeCategory = 'training'; openFaq = null" 
                        :class="activeCategory === 'training' ? 'bg-gradient-to-r from-primary to-blue-600 text-white shadow-xl scale-105' : 'bg-white text-gray-700 hover:bg-gray-50 hover:shadow-lg border border-gray-200'"
                        class="px-8 py-4 rounded-2xl font-semibold transition-all duration-300 transform hover:scale-105 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Training
                </button>
                <button @click="activeCategory = 'general'; openFaq = null" 
                        :class="activeCategory === 'general' ? 'bg-gradient-to-r from-primary to-blue-600 text-white shadow-xl scale-105' : 'bg-white text-gray-700 hover:bg-gray-50 hover:shadow-lg border border-gray-200'"
                        class="px-8 py-4 rounded-2xl font-semibold transition-all duration-300 transform hover:scale-105 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    General
                </button>
            </div>
        </div>
    </section>

    <!-- FAQ Content -->
    <section class="py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-6">
            <div class="max-w-5xl mx-auto">
            <!-- FAQ Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1">50+</h3>
                    <p class="text-gray-600 text-sm">Questions Answered</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1">&lt; 2min</h3>
                    <p class="text-gray-600 text-sm">Average Read Time</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1">24/7</h3>
                    <p class="text-gray-600 text-sm">Support Available</p>
                </div>
            </div>

            <?php foreach ($faqs as $categoryData): ?>
            <div class="mb-16" 
                 x-show="activeCategory === 'all' || activeCategory === '<?= strtolower($categoryData['category']) ?>'"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 transform translate-y-8"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                
                <!-- Category Header -->
                <div class="text-center mb-10">
                    <div class="inline-flex items-center gap-3 bg-white px-8 py-4 rounded-2xl shadow-lg border border-gray-100 mb-6">
                        <?php 
                        $categoryIcons = [
                            'Services' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V6"/>',
                            'Training' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                            'General' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
                        ];
                        $iconPath = $categoryIcons[$categoryData['category']] ?? $categoryIcons['General'];
                        ?>
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <?= $iconPath ?>
                        </svg>
                        <h2 class="text-3xl font-bold text-gray-800"><?= htmlspecialchars($categoryData['category']) ?></h2>
                    </div>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        <?php 
                        $categoryDescriptions = [
                            'Services' => 'Learn about our software development, web design, and IT consulting services',
                            'Training' => 'Get information about our training programs, courses, and certification options',
                            'General' => 'General questions about Nebatech, policies, and getting started'
                        ];
                        echo $categoryDescriptions[$categoryData['category']] ?? 'Frequently asked questions and answers';
                        ?>
                    </p>
                </div>
                
                <!-- FAQ Items -->
                <div class="space-y-6">
                    <?php foreach ($categoryData['questions'] as $index => $qa): ?>
                        <?php $faqId = strtolower($categoryData['category']) . '_' . $index; ?>
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 overflow-hidden group" 
                         data-faq-item>
                        <button @click="openFaq = openFaq === '<?= $faqId ?>' ? null : '<?= $faqId ?>'" 
                                class="w-full px-8 py-8 text-left flex justify-between items-start hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300 rounded-2xl">
                            <div class="flex-1 pr-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-blue-600 rounded-full flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                        <span class="text-white font-bold text-sm">Q</span>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-800 text-xl mb-3 group-hover:text-primary transition-colors duration-300" 
                                            data-faq-question>
                                            <?= htmlspecialchars($qa['question']) ?>
                                        </h3>
                                        <div class="flex items-center gap-3 text-sm text-gray-500">
                                            <span class="bg-gradient-to-r from-gray-100 to-blue-50 px-3 py-1 rounded-full text-xs font-medium border" 
                                                  data-faq-category>
                                                <?= htmlspecialchars($categoryData['category']) ?>
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                2 min read
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all duration-300">
                                    <svg class="w-6 h-6 transform transition-transform duration-300" 
                                         :class="openFaq === '<?= $faqId ?>' ? 'rotate-180' : ''" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </button>
                        
                        <div x-show="openFaq === '<?= $faqId ?>'" 
                             x-collapse
                             class="px-8 pb-8">
                            <div class="pl-14 pt-4 border-t border-gray-100">
                                <div class="bg-gradient-to-r from-blue-50 to-purple-50 p-6 rounded-xl border-l-4 border-primary">
                                    <div class="flex items-start gap-4">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                                            <span class="text-white font-bold text-sm">A</span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-gray-700 leading-relaxed text-lg" data-faq-answer>
                                                <?= htmlspecialchars($qa['answer']) ?>
                                            </p>
                                            
                                            <!-- Helpful Actions -->
                                            <div class="flex items-center gap-4 mt-6 pt-4 border-t border-gray-200">
                                                <span class="text-sm text-gray-600">Was this helpful?</span>
                                                <div class="flex items-center gap-2">
                                                    <button onclick="markHelpful('<?= $faqId ?>', true)" 
                                                            class="flex items-center gap-1 px-3 py-1 bg-green-100 hover:bg-green-200 text-green-700 rounded-full text-sm transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                                        </svg>
                                                        Yes
                                                    </button>
                                                    <button onclick="markHelpful('<?= $faqId ?>', false)" 
                                                            class="flex items-center gap-1 px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded-full text-sm transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018c.163 0 .326.02.485.06L17 4m-7 10v2a2 2 0 002 2h.095c.5 0 .905-.405.905-.905 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/>
                                                        </svg>
                                                        No
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<!-- Still Have Questions Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-gradient-to-r from-primary to-blue-700 rounded-2xl p-8 md:p-12 text-white text-center">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                
                <h2 class="text-3xl font-bold mb-4">Still Have Questions?</h2>
                <p class="text-xl text-gray-200 mb-8 max-w-2xl mx-auto">
                    Can't find what you're looking for? Our team is here to help you with any questions about our services or training programs.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="<?= url('/contact') ?>" 
                       class="bg-secondary hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-lg transition-colors">
                        Contact Support
                    </a>
                    <a href="tel:024-763-6080" 
                       class="bg-white text-primary hover:bg-gray-100 font-bold px-8 py-3 rounded-lg transition-colors">
                        Call Us Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Information -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Get in Touch</h2>
            <p class="text-lg text-gray-600">Multiple ways to reach our support team</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <!-- Phone Support -->
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Phone Support</h3>
                <div class="space-y-2 mb-4">
                    <p class="text-gray-600 font-semibold">024 763 6080</p>
                    <p class="text-gray-600 font-semibold">020 678 9600</p>
                </div>
                <p class="text-sm text-gray-500">Mon-Fri, 9AM-6PM GMT</p>
            </div>

            <!-- Email Support -->
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Email Support</h3>
                <p class="text-gray-600 font-semibold mb-4">info@nebatech.com</p>
                <p class="text-sm text-gray-500">Response within 24 hours</p>
            </div>

            <!-- Office Location -->
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Visit Our Office</h3>
                <div class="space-y-1 mb-4">
                    <p class="text-gray-600">Choggu Yapalsi, Tamale</p>
                    <p class="text-gray-600">Northern Ghana</p>
                </div>
                <p class="text-sm text-gray-500">Open Mon-Fri, 9AM-6PM</p>
            </div>
        </div>
    </div>
</section>

<?php 
$content = ob_get_clean();
?>

<!-- Enhanced FAQ Functionality Script -->
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('faqSearch', () => ({
        searchTerm: '',
        openFaq: null,
        activeCategory: 'all',
        
        init() {
            // Auto-focus search on page load
            this.$nextTick(() => {
                const searchInput = document.querySelector('input[x-model="searchTerm"]');
                if (searchInput) {
                    searchInput.addEventListener('input', () => {
                        this.performSearch();
                    });
                }
            });
        },
        
        performSearch() {
            const term = this.searchTerm.toLowerCase();
            const faqItems = document.querySelectorAll('[data-faq-item]');
            
            faqItems.forEach(item => {
                const question = item.querySelector('[data-faq-question]')?.textContent.toLowerCase() || '';
                const answer = item.querySelector('[data-faq-answer]')?.textContent.toLowerCase() || '';
                const category = item.querySelector('[data-faq-category]')?.textContent.toLowerCase() || '';
                
                const matches = question.includes(term) || answer.includes(term) || category.includes(term);
                
                if (term === '' || matches) {
                    item.style.display = 'block';
                    // Highlight matching text
                    this.highlightText(item, term);
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show "no results" message if needed
            this.toggleNoResultsMessage();
        },
        
        highlightText(item, term) {
            if (!term) return;
            
            const questionEl = item.querySelector('[data-faq-question]');
            if (questionEl) {
                const originalText = questionEl.getAttribute('data-original-text') || questionEl.textContent;
                questionEl.setAttribute('data-original-text', originalText);
                
                const highlightedText = originalText.replace(
                    new RegExp(`(${term})`, 'gi'), 
                    '<mark class="bg-yellow-200 px-1 rounded">$1</mark>'
                );
                questionEl.innerHTML = highlightedText;
            }
        },
        
        clearSearch() {
            this.searchTerm = '';
            this.performSearch();
        },
        
        toggleNoResultsMessage() {
            const visibleItems = document.querySelectorAll('[data-faq-item]:not([style*="display: none"])');
            let noResultsEl = document.getElementById('no-results-message');
            
            if (visibleItems.length === 0 && this.searchTerm !== '') {
                if (!noResultsEl) {
                    noResultsEl = document.createElement('div');
                    noResultsEl.id = 'no-results-message';
                    noResultsEl.className = 'text-center py-12 bg-white rounded-2xl shadow-lg border border-gray-100';
                    noResultsEl.innerHTML = `
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">No results found</h3>
                        <p class="text-gray-600 mb-4">Try adjusting your search terms or browse by category</p>
                        <button onclick="Alpine.store('faq').clearSearch()" class="bg-primary hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                            Clear Search
                        </button>
                    `;
                    document.querySelector('.max-w-5xl').appendChild(noResultsEl);
                }
                noResultsEl.style.display = 'block';
            } else if (noResultsEl) {
                noResultsEl.style.display = 'none';
            }
        },
        
        // Feedback functionality
        markHelpful(faqId, helpful) {
            // Store feedback locally (could be sent to server)
            const feedback = JSON.parse(localStorage.getItem('faq_feedback') || '{}');
            feedback[faqId] = helpful;
            localStorage.setItem('faq_feedback', JSON.stringify(feedback));
            
            // Show thank you message
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = helpful ? 
                '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Thanks!' :
                '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg> Thanks for feedback!';
            
            setTimeout(() => {
                button.innerHTML = originalText;
            }, 2000);
        }
    }));
});

// Enhanced search functionality
function initFAQSearch() {
    const searchInput = document.querySelector('input[placeholder="Search for answers..."]');
    if (searchInput) {
        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                performFAQSearch(searchInput.value);
            }
        });
    }
}

function performFAQSearch(term) {
    // Scroll to FAQ content
    document.querySelector('.max-w-5xl').scrollIntoView({ 
        behavior: 'smooth',
        block: 'start'
    });
    
    // Set search term in Alpine component
    setTimeout(() => {
        const searchComponent = document.querySelector('[x-data*="searchTerm"]');
        if (searchComponent && searchComponent._x_dataStack) {
            searchComponent._x_dataStack[0].searchTerm = term;
            searchComponent._x_dataStack[0].performSearch();
        }
    }, 500);
}

// Hero search function
function performHeroSearch() {
    const heroInput = document.querySelector('input[x-model="heroSearchTerm"]');
    if (heroInput && heroInput.value.trim()) {
        // Scroll to FAQ content
        document.querySelector('[x-data*="activeCategory"]').scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
        
        // Set search term in the main FAQ component after scrolling
        setTimeout(() => {
            const faqContainer = document.querySelector('[x-data*="activeCategory"]');
            if (faqContainer && faqContainer._x_dataStack) {
                faqContainer._x_dataStack[0].searchTerm = heroInput.value;
                faqContainer._x_dataStack[0].activeCategory = 'all';
                // Trigger search functionality
                performFAQSearch(heroInput.value);
            }
        }, 500);
    }
}

// Global feedback function
function markHelpful(faqId, helpful) {
    // Store feedback locally (could be sent to server)
    const feedback = JSON.parse(localStorage.getItem('faq_feedback') || '{}');
    feedback[faqId] = helpful;
    localStorage.setItem('faq_feedback', JSON.stringify(feedback));
    
    // Show thank you message
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    button.innerHTML = helpful ? 
        '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Thanks!' :
        '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg> Thanks for feedback!';
    
    setTimeout(() => {
        button.innerHTML = originalText;
    }, 2000);
    
    // Optional: Send to server
    // fetch('/api/faq-feedback', {
    //     method: 'POST',
    //     headers: { 'Content-Type': 'application/json' },
    //     body: JSON.stringify({ faqId, helpful })
    // });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', initFAQSearch);
</script>

<?php include __DIR__ . '/../layouts/main.php'; ?>
