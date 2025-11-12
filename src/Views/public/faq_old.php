<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> - Nebatech</title>
    <meta name="description" content="<?= htmlspecialchars($description) ?>">
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/../partials/header.php'; ?>
    
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-primary to-blue-700 text-white py-16">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl font-bold mb-4"><?= htmlspecialchars($title) ?></h1>
                <p class="text-xl text-gray-200"><?= htmlspecialchars($description) ?></p>
            </div>
        </div>
    </section>

    <!-- FAQ Content -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <?php foreach ($faqs as $faqCategory): ?>
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6 pb-3 border-b-2 border-primary">
                        <?= htmlspecialchars($faqCategory['category']) ?>
                    </h2>
                    
                    <div class="space-y-4">
                        <?php foreach ($faqCategory['questions'] as $index => $faq): ?>
                        <div class="border-2 border-gray-200 rounded-lg overflow-hidden" 
                             x-data="{ open: <?= $index === 0 ? 'true' : 'false' ?> }">
                            <button @click="open = !open" 
                                    class="w-full flex items-center justify-between p-5 bg-gray-50 hover:bg-gray-100 transition-colors text-left">
                                <span class="font-bold text-gray-800 pr-4"><?= htmlspecialchars($faq['question']) ?></span>
                                <svg class="w-6 h-6 text-primary flex-shrink-0 transition-transform" 
                                     :class="open ? 'rotate-180' : ''" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" x-collapse class="border-t border-gray-200">
                                <div class="p-5 bg-white">
                                    <p class="text-gray-700 leading-relaxed"><?= htmlspecialchars($faq['answer']) ?></p>
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

    <!-- Still Have Questions Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Still Have Questions?</h2>
                <p class="text-xl text-gray-600 mb-8">
                    Can't find the answer you're looking for? Our team is here to help.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="<?= url('/contact') ?>" 
                       class="bg-primary hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-lg transition-colors">
                        Contact Us
                    </a>
                    <a href="<?= url('/request-quote') ?>" 
                       class="bg-secondary hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-lg transition-colors">
                        Request a Quote
                    </a>
                </div>

                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <div class="text-3xl mb-3">📞</div>
                        <h3 class="font-bold text-gray-800 mb-2">Call Us</h3>
                        <p class="text-gray-600 text-sm mb-2">024 763 6080</p>
                        <p class="text-gray-600 text-sm">020 678 9600</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <div class="text-3xl mb-3">✉️</div>
                        <h3 class="font-bold text-gray-800 mb-2">Email Us</h3>
                        <p class="text-gray-600 text-sm">info@nebatech.com</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <div class="text-3xl mb-3">📍</div>
                        <h3 class="font-bold text-gray-800 mb-2">Visit Us</h3>
                        <p class="text-gray-600 text-sm">Choggu Yapalsi, Tamale</p>
                        <p class="text-gray-600 text-sm">Northern Ghana</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
