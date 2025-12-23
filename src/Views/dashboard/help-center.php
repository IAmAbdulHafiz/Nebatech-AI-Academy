<?php
/**
 * Student Help Center Page
 * Provides FAQs, resources, and support options for students
 */
?>

<!-- Help Center Header -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-primary via-purple-600 to-indigo-600 rounded-2xl p-8 text-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white rounded-full translate-y-1/2 -translate-x-1/2"></div>
        </div>
        
        <div class="relative z-10 max-w-3xl">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-life-ring text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold">Help Center</h1>
            </div>
            <p class="text-white/80 text-lg mb-6">
                Find answers to common questions, access learning resources, and get support when you need it.
            </p>
            
            <!-- Search Box -->
            <div class="relative max-w-xl">
                <input type="text" 
                       id="helpSearch"
                       placeholder="Search for help topics..." 
                       class="w-full px-5 py-4 pl-12 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:bg-white/20 transition">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-white/60"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Resources -->
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <?php foreach ($resources as $resource): 
        $bgColor = match($resource['color']) {
            'red' => 'bg-red-50 hover:bg-red-100',
            'blue' => 'bg-blue-50 hover:bg-blue-100',
            'green' => 'bg-green-50 hover:bg-green-100',
            'purple' => 'bg-purple-50 hover:bg-purple-100',
            default => 'bg-gray-50 hover:bg-gray-100'
        };
        $iconColor = match($resource['color']) {
            'red' => 'text-red-600 bg-red-100',
            'blue' => 'text-blue-600 bg-blue-100',
            'green' => 'text-green-600 bg-green-100',
            'purple' => 'text-purple-600 bg-purple-100',
            default => 'text-gray-600 bg-gray-100'
        };
    ?>
    <a href="<?= $resource['link'] ?>" 
       class="<?= $bgColor ?> rounded-xl p-5 transition group border border-transparent hover:border-gray-200 hover:shadow-md">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 <?= $iconColor ?> rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition">
                <i class="<?= $resource['icon'] ?> text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1"><?= htmlspecialchars($resource['title']) ?></h3>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($resource['description']) ?></p>
            </div>
        </div>
    </a>
    <?php endforeach; ?>
</div>

<!-- FAQ Sections -->
<div class="grid md:grid-cols-2 gap-6" x-data="{ openFaq: null }">
    <?php foreach ($faqCategories as $catIndex => $category): 
        $headerBg = match($category['color']) {
            'blue' => 'from-blue-500 to-blue-600',
            'green' => 'from-green-500 to-green-600',
            'yellow' => 'from-yellow-500 to-yellow-600',
            'purple' => 'from-purple-500 to-purple-600',
            default => 'from-gray-500 to-gray-600'
        };
        $accentColor = match($category['color']) {
            'blue' => 'text-blue-600 bg-blue-100',
            'green' => 'text-green-600 bg-green-100',
            'yellow' => 'text-yellow-600 bg-yellow-100',
            'purple' => 'text-purple-600 bg-purple-100',
            default => 'text-gray-600 bg-gray-100'
        };
    ?>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden faq-category">
        <!-- Category Header -->
        <div class="bg-gradient-to-r <?= $headerBg ?> p-5 flex items-center gap-4">
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                <i class="<?= $category['icon'] ?> text-white text-lg"></i>
            </div>
            <h2 class="text-xl font-bold text-white"><?= htmlspecialchars($category['title']) ?></h2>
        </div>
        
        <!-- FAQ Items -->
        <div class="divide-y divide-gray-100">
            <?php foreach ($category['faqs'] as $faqIndex => $faq): 
                $faqId = $catIndex . '-' . $faqIndex;
            ?>
            <div class="faq-item" data-question="<?= htmlspecialchars(strtolower($faq['q'])) ?>">
                <button @click="openFaq = openFaq === '<?= $faqId ?>' ? null : '<?= $faqId ?>'"
                        class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition">
                    <span class="font-medium text-gray-900 pr-4"><?= htmlspecialchars($faq['q']) ?></span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                       :class="openFaq === '<?= $faqId ?>' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="openFaq === '<?= $faqId ?>'" 
                     x-collapse
                     class="px-6 pb-4">
                    <div class="p-4 bg-gray-50 rounded-lg text-gray-600 leading-relaxed">
                        <?= htmlspecialchars($faq['a']) ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Still Need Help Section -->
<div class="mt-8 bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl p-8 text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-primary/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-purple-500/20 rounded-full blur-3xl"></div>
    
    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center">
                <i class="fas fa-headset text-3xl text-primary"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-1">Still need help?</h3>
                <p class="text-gray-400">Our support team is here to assist you with any questions.</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="<?= url('/contact') ?>" 
               class="bg-white text-gray-900 px-6 py-3 rounded-xl font-semibold hover:bg-gray-100 transition flex items-center gap-2">
                <i class="fas fa-envelope"></i>
                Contact Us
            </a>
            <a href="mailto:support@nebatech.com" 
               class="bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:bg-primary/90 transition flex items-center gap-2">
                <i class="fas fa-paper-plane"></i>
                Email Support
            </a>
        </div>
    </div>
</div>

<!-- Keyboard Shortcuts Guide -->
<div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
        <i class="fas fa-keyboard text-gray-400"></i>
        Keyboard Shortcuts
    </h2>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <kbd class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded text-sm font-mono">Ctrl + S</kbd>
            <span class="text-gray-600 text-sm">Save code in editor</span>
        </div>
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <kbd class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded text-sm font-mono">Ctrl + Enter</kbd>
            <span class="text-gray-600 text-sm">Run code</span>
        </div>
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <kbd class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded text-sm font-mono">Esc</kbd>
            <span class="text-gray-600 text-sm">Close modal/popup</span>
        </div>
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <kbd class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded text-sm font-mono">←/→</kbd>
            <span class="text-gray-600 text-sm">Previous/Next lesson</span>
        </div>
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <kbd class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded text-sm font-mono">Space</kbd>
            <span class="text-gray-600 text-sm">Play/Pause video</span>
        </div>
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <kbd class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded text-sm font-mono">F</kbd>
            <span class="text-gray-600 text-sm">Fullscreen video</span>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('helpSearch');
    const faqItems = document.querySelectorAll('.faq-item');
    const faqCategories = document.querySelectorAll('.faq-category');
    
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        
        if (query === '') {
            // Show all
            faqCategories.forEach(cat => cat.style.display = 'block');
            faqItems.forEach(item => item.style.display = 'block');
            return;
        }
        
        faqCategories.forEach(category => {
            const items = category.querySelectorAll('.faq-item');
            let hasVisibleItem = false;
            
            items.forEach(item => {
                const question = item.dataset.question || '';
                const answer = item.querySelector('.bg-gray-50')?.textContent?.toLowerCase() || '';
                
                if (question.includes(query) || answer.includes(query)) {
                    item.style.display = 'block';
                    hasVisibleItem = true;
                } else {
                    item.style.display = 'none';
                }
            });
            
            category.style.display = hasVisibleItem ? 'block' : 'none';
        });
    });
});
</script>
