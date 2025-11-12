<?php 
$content = ob_start(); 
?>

<!-- Hero Section -->
<section class="bg-primary text-white py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-secondary rounded-full blur-3xl"></div>
    </div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-block bg-secondary/20 text-secondary px-4 py-2 rounded-full text-sm font-semibold mb-6">
                💰 Free Consultation • Custom Solutions • No Hidden Fees
            </div>
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">Request a Quote</h1>
            <p class="text-xl md:text-2xl text-gray-200 max-w-2xl mx-auto">
                Get a personalized quote for your IT service needs. Our experts will provide detailed pricing and recommendations.
            </p>
        </div>
    </div>
</section>

<!-- Quote Form Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Tell Us About Your Project</h2>
                        
                        <!-- Success Message -->
                        <?php if (isset($success) && $success): ?>
                        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <strong>Success!</strong>
                            </div>
                            <p class="mt-2"><?= htmlspecialchars($message ?? 'Your quote request has been submitted successfully!') ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Error Message -->
                        <?php if (isset($error) && $error): ?>
                        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <strong>Error!</strong>
                            </div>
                            <p class="mt-2"><?= htmlspecialchars($message ?? 'There was an error submitting your request. Please try again.') ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="<?= url('/request-quote') ?>" class="space-y-6">
                            <?= csrf_field() ?>
                            
                            <!-- Personal Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           value="<?= htmlspecialchars($formData['name'] ?? '') ?>"
                                           required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           value="<?= htmlspecialchars($formData['email'] ?? '') ?>"
                                           required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel" 
                                           id="phone" 
                                           name="phone" 
                                           value="<?= htmlspecialchars($formData['phone'] ?? '') ?>"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                </div>
                                
                                <div>
                                    <label for="company" class="block text-sm font-semibold text-gray-700 mb-2">Company/Organization</label>
                                    <input type="text" 
                                           id="company" 
                                           name="company" 
                                           value="<?= htmlspecialchars($formData['company'] ?? '') ?>"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                </div>
                            </div>
                            
                            <!-- Service Selection -->
                            <div>
                                <label for="service_id" class="block text-sm font-semibold text-gray-700 mb-2">Service Interest *</label>
                                <select id="service_id" 
                                        name="service_id" 
                                        required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                    <option value="">Select a service...</option>
                                    <?php foreach ($services as $service): ?>
                                    <option value="<?= $service['id'] ?>" 
                                            <?= (isset($formData['service_id']) && $formData['service_id'] == $service['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($service['title']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <!-- Project Details -->
                            <div>
                                <label for="project_description" class="block text-sm font-semibold text-gray-700 mb-2">Project Description *</label>
                                <textarea id="project_description" 
                                          name="project_description" 
                                          rows="5" 
                                          required 
                                          placeholder="Please describe your project requirements, goals, and any specific features you need..."
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors resize-vertical"><?= htmlspecialchars($formData['project_description'] ?? '') ?></textarea>
                            </div>
                            
                            <!-- Budget and Timeline -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="budget_range" class="block text-sm font-semibold text-gray-700 mb-2">Budget Range</label>
                                    <select id="budget_range" 
                                            name="budget_range" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                        <option value="">Select budget range...</option>
                                        <option value="under-5000" <?= (isset($formData['budget_range']) && $formData['budget_range'] == 'under-5000') ? 'selected' : '' ?>>Under GHS 5,000</option>
                                        <option value="5000-15000" <?= (isset($formData['budget_range']) && $formData['budget_range'] == '5000-15000') ? 'selected' : '' ?>>GHS 5,000 - 15,000</option>
                                        <option value="15000-50000" <?= (isset($formData['budget_range']) && $formData['budget_range'] == '15000-50000') ? 'selected' : '' ?>>GHS 15,000 - 50,000</option>
                                        <option value="50000-100000" <?= (isset($formData['budget_range']) && $formData['budget_range'] == '50000-100000') ? 'selected' : '' ?>>GHS 50,000 - 100,000</option>
                                        <option value="over-100000" <?= (isset($formData['budget_range']) && $formData['budget_range'] == 'over-100000') ? 'selected' : '' ?>>Over GHS 100,000</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="timeline" class="block text-sm font-semibold text-gray-700 mb-2">Preferred Timeline</label>
                                    <select id="timeline" 
                                            name="timeline" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                        <option value="">Select timeline...</option>
                                        <option value="asap" <?= (isset($formData['timeline']) && $formData['timeline'] == 'asap') ? 'selected' : '' ?>>ASAP</option>
                                        <option value="1-month" <?= (isset($formData['timeline']) && $formData['timeline'] == '1-month') ? 'selected' : '' ?>>Within 1 month</option>
                                        <option value="3-months" <?= (isset($formData['timeline']) && $formData['timeline'] == '3-months') ? 'selected' : '' ?>>Within 3 months</option>
                                        <option value="6-months" <?= (isset($formData['timeline']) && $formData['timeline'] == '6-months') ? 'selected' : '' ?>>Within 6 months</option>
                                        <option value="flexible" <?= (isset($formData['timeline']) && $formData['timeline'] == 'flexible') ? 'selected' : '' ?>>Flexible</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="pt-4">
                                <button type="submit" 
                                        class="w-full bg-secondary hover:bg-orange-600 text-white font-bold py-4 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    Submit Quote Request
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="space-y-8">
                        <!-- What Happens Next -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">What Happens Next?</h3>
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <span class="text-primary font-bold text-sm">1</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-1">Quick Review</h4>
                                        <p class="text-gray-600 text-sm">We'll review your requirements within 2 hours</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="w-8 h-8 bg-secondary/10 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <span class="text-secondary font-bold text-sm">2</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-1">Consultation Call</h4>
                                        <p class="text-gray-600 text-sm">Schedule a free 30-minute consultation</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <span class="text-green-600 font-bold text-sm">3</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-1">Detailed Proposal</h4>
                                        <p class="text-gray-600 text-sm">Receive a comprehensive quote and project plan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contact Information -->
                        <div class="bg-gradient-to-br from-primary to-blue-700 rounded-xl p-6 text-white">
                            <h3 class="text-xl font-bold mb-4">Need Immediate Help?</h3>
                            <p class="text-gray-200 mb-6">Speak directly with our experts for urgent requirements.</p>
                            
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <div>
                                        <div class="font-semibold">024 763 6080</div>
                                        <div class="font-semibold">020 678 9600</div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span>info@nebatech.com</span>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <a href="<?= url('/contact') ?>" 
                                   class="block w-full bg-white text-primary hover:bg-gray-100 font-semibold py-3 px-4 rounded-lg transition-colors text-center">
                                    Contact Us Directly
                                </a>
                            </div>
                        </div>
                        
                        <!-- Trust Indicators -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Why Choose Nebatech?</h3>
                            <div class="space-y-3">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-700 text-sm">1000+ Satisfied Clients</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-700 text-sm">5+ Years Experience</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-700 text-sm">24/7 Support Available</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-700 text-sm">Money-Back Guarantee</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>
