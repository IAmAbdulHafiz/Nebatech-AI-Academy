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

    <!-- Quote Form Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-3xl mx-auto">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="bg-green-100 border-2 border-green-500 text-green-700 px-6 py-4 rounded-lg mb-6">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span><?= htmlspecialchars($_SESSION['success']) ?></span>
                        </div>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['errors'])): ?>
                    <div class="bg-red-100 border-2 border-red-500 text-red-700 px-6 py-4 rounded-lg mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <?php foreach ($_SESSION['errors'] as $error): ?>
                                    <p><?= htmlspecialchars($error) ?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php unset($_SESSION['errors']); ?>
                <?php endif; ?>

                <div class="bg-white border-2 border-gray-200 rounded-xl p-8 shadow-lg">
                    <form action="<?= url('/request-quote') ?>" method="POST" class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" required
                                   value="<?= htmlspecialchars($_SESSION['form_data']['name'] ?? '') ?>"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors"
                                   placeholder="John Doe">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" required
                                   value="<?= htmlspecialchars($_SESSION['form_data']['email'] ?? '') ?>"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors"
                                   placeholder="john@example.com">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                Phone Number
                            </label>
                            <input type="tel" id="phone" name="phone"
                                   value="<?= htmlspecialchars($_SESSION['form_data']['phone'] ?? '') ?>"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors"
                                   placeholder="024 000 0000">
                        </div>

                        <!-- Company -->
                        <div>
                            <label for="company" class="block text-sm font-semibold text-gray-700 mb-2">
                                Company/Organization
                            </label>
                            <input type="text" id="company" name="company"
                                   value="<?= htmlspecialchars($_SESSION['form_data']['company'] ?? '') ?>"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors"
                                   placeholder="Your Company Name">
                        </div>

                        <!-- Service -->
                        <div>
                            <label for="service_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Service Interested In
                            </label>
                            <select id="service_id" name="service_id"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors">
                                <option value="">Select a service...</option>
                                <?php foreach ($services as $service): ?>
                                    <option value="<?= $service['id'] ?>" 
                                            <?= (isset($_SESSION['form_data']['service_id']) && $_SESSION['form_data']['service_id'] == $service['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($service['title']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                                Project Details <span class="text-red-500">*</span>
                            </label>
                            <textarea id="message" name="message" required rows="6"
                                      class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors resize-none"
                                      placeholder="Please describe your project requirements, timeline, budget, and any other relevant details..."><?= htmlspecialchars($_SESSION['form_data']['message'] ?? '') ?></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                    class="w-full bg-primary hover:bg-blue-700 text-white font-bold px-8 py-4 rounded-lg transition-colors">
                                Submit Quote Request
                            </button>
                        </div>

                        <p class="text-sm text-gray-600 text-center">
                            We'll review your request and get back to you within 24 hours.
                        </p>
                    </form>
                </div>
                <?php unset($_SESSION['form_data']); ?>
            </div>
        </div>
    </section>

    <!-- Why Request a Quote Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">What Happens Next?</h2>
                    <p class="text-xl text-gray-600">Our simple and transparent process</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
                        <h3 class="text-lg font-bold mb-2 text-gray-800">Submit Request</h3>
                        <p class="text-gray-600 text-sm">Fill out the form with your project details</p>
                    </div>

                    <div class="text-center">
                        <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
                        <h3 class="text-lg font-bold mb-2 text-gray-800">We Review</h3>
                        <p class="text-gray-600 text-sm">Our team analyzes your requirements</p>
                    </div>

                    <div class="text-center">
                        <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
                        <h3 class="text-lg font-bold mb-2 text-gray-800">Get Quote</h3>
                        <p class="text-gray-600 text-sm">Receive a detailed proposal and pricing</p>
                    </div>

                    <div class="text-center">
                        <div class="bg-secondary text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">4</div>
                        <h3 class="text-lg font-bold mb-2 text-gray-800">Start Project</h3>
                        <p class="text-gray-600 text-sm">Begin working on your solution</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
