<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-yellow-900 via-orange-900 to-amber-800 text-white py-20 overflow-hidden">
    <!-- Digital Horizon Background -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Horizon Glow -->
        <div class="absolute bottom-0 left-0 right-0 h-96 bg-gradient-to-t from-yellow-500/30 via-orange-400/10 to-transparent"></div>
        
        <!-- Geometric Light Beams -->
        <div class="absolute top-0 left-1/4 w-1 h-full bg-gradient-to-b from-yellow-400/40 via-yellow-400/20 to-transparent transform -skew-x-12 animate-pulse" style="animation-duration: 4s;"></div>
        <div class="absolute top-0 right-1/3 w-1 h-full bg-gradient-to-b from-orange-400/30 via-orange-400/15 to-transparent transform skew-x-12 animate-pulse" style="animation-duration: 5s;"></div>
        <div class="absolute top-0 left-2/3 w-1 h-full bg-gradient-to-b from-amber-400/25 via-amber-400/10 to-transparent transform -skew-x-6 animate-pulse" style="animation-duration: 3s;"></div>
        
        <!-- Glowing Orbs -->
        <div class="absolute top-20 left-10 w-96 h-96 bg-yellow-500/40 rounded-full blur-3xl animate-pulse" style="animation-duration: 6s;"></div>
        <div class="absolute bottom-20 right-20 w-80 h-80 bg-orange-500/30 rounded-full blur-3xl animate-pulse" style="animation-duration: 8s;"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-amber-500/20 rounded-full blur-3xl animate-pulse" style="animation-duration: 7s;"></div>
        
        <!-- Floating Success Icons -->
        <div class="absolute top-1/4 left-[10%] opacity-20 animate-float" style="animation-duration: 6s;">
            <i class="fas fa-star text-6xl text-yellow-300"></i>
        </div>
        <div class="absolute top-1/3 right-[15%] opacity-20 animate-float" style="animation-duration: 7s; animation-delay: 1s;">
            <i class="fas fa-award text-6xl text-orange-300"></i>
        </div>
        <div class="absolute bottom-1/4 left-[20%] opacity-20 animate-float" style="animation-duration: 8s; animation-delay: 0.5s;">
            <i class="fas fa-thumbs-up text-6xl text-amber-300"></i>
        </div>
        <div class="absolute top-1/2 right-[25%] opacity-20 animate-float" style="animation-duration: 6.5s; animation-delay: 1.5s;">
            <i class="fas fa-quote-left text-6xl text-yellow-300"></i>
        </div>
        <div class="absolute bottom-1/3 right-[10%] opacity-20 animate-float" style="animation-duration: 7.5s; animation-delay: 0.8s;">
            <i class="fas fa-medal text-6xl text-orange-300"></i>
        </div>
    </div>
    
    <!-- Content -->
    <div class="container mx-auto px-6 text-center relative z-10">
        <div class="inline-block bg-orange-800/60 backdrop-blur-sm px-6 py-2 rounded-full text-white text-sm font-semibold mb-6 border border-yellow-400/30">
            <i class="fas fa-star mr-2"></i>Success Stories
        </div>
        <h1 class="text-4xl md:text-6xl font-bold mb-6">Success Stories & Testimonials</h1>
        <p class="text-xl text-yellow-100 max-w-3xl mx-auto mb-12">
            Hear from our graduates who transformed their careers through Nebatech AI Academy
        </p>
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
            <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-yellow-400/20 hover:bg-white/15 transition-all">
                <div class="text-3xl font-bold">5,000+</div>
                <div class="text-yellow-200 text-sm">Students Trained</div>
            </div>
            <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-orange-400/20 hover:bg-white/15 transition-all">
                <div class="text-3xl font-bold">92%</div>
                <div class="text-yellow-200 text-sm">Job Placement Rate</div>
            </div>
            <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-amber-400/20 hover:bg-white/15 transition-all">
                <div class="text-3xl font-bold">4.9/5</div>
                <div class="text-yellow-200 text-sm">Average Rating</div>
            </div>
            <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-yellow-400/20 hover:bg-white/15 transition-all">
                <div class="text-3xl font-bold">500+</div>
                <div class="text-yellow-200 text-sm">Companies Hiring</div>
            </div>
        </div>
    </div>
</section>

<div class="container mx-auto px-4 py-12">

    <!-- Testimonials Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php 
        $testimonials = [
            [
                'name' => 'Abdul Rahman Iddrisu',
                'role' => 'Full Stack Developer at MTN Ghana',
                'image' => 'AR',
                'rating' => 5,
                'text' => 'Nebatech AI Academy gave me the practical skills I needed. Within 3 months of completing the program, I landed my dream job at MTN. The hands-on projects were invaluable!'
            ],
            [
                'name' => 'Fatima Alhassan',
                'role' => 'Frontend Developer at Vodafone',
                'image' => 'FA',
                'rating' => 5,
                'text' => 'The instructors were exceptional and the curriculum was up-to-date with industry standards. I went from knowing nothing about coding to building complex web applications.'
            ],
            [
                'name' => 'Mohammed Salifu',
                'role' => 'AI Engineer at GIZ Ghana',
                'image' => 'MS',
                'rating' => 5,
                'text' => 'The AI and Machine Learning course opened doors I never thought possible. Now I am working on cutting-edge projects. Thank you Nebatech!'
            ],
            [
                'name' => 'Amina Zakari',
                'role' => 'Backend Developer at Stanbic Bank',
                'image' => 'AZ',
                'rating' => 5,
                'text' => 'Best investment I have made in my career. The mentorship and career support helped me transition from teaching to tech successfully.'
            ],
            [
                'name' => 'Ibrahim Sulemana',
                'role' => 'Mobile Developer - Freelancer',
                'image' => 'IS',
                'rating' => 5,
                'text' => 'Started freelancing after completing the mobile development course. Now earning 5x my previous salary. The skills are truly market-ready!'
            ],
            [
                'name' => 'Husseina Mohammed',
                'role' => 'Data Scientist at UNICEF Ghana',
                'image' => 'HM',
                'rating' => 5,
                'text' => 'The data science program was comprehensive and practical. I now use Python and ML daily in my work. Highly recommended!'
            ]
        ];

        foreach ($testimonials as $testimonial): ?>
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md hover:shadow-xl transition-shadow">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-secondary rounded-full flex items-center justify-center text-white font-bold mr-4">
                    <?= $testimonial['image'] ?>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 dark:text-white"><?= $testimonial['name'] ?></div>
                    <div class="text-sm text-gray-600 dark:text-gray-400"><?= $testimonial['role'] ?></div>
                </div>
            </div>
            <div class="flex mb-3">
                <?php for($i = 0; $i < $testimonial['rating']; $i++): ?>
                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <?php endfor; ?>
            </div>
            <p class="text-gray-600 dark:text-gray-400 italic">"<?= $testimonial['text'] ?>"</p>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- CTA Section -->
    <div class="mt-16 bg-primary text-white rounded-lg p-12 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Write Your Success Story?</h2>
        <p class="text-xl mb-8">Join thousands of successful graduates and transform your career today</p>
        <a href="<?= url('/register') ?>" class="bg-secondary hover:bg-orange-600 text-white font-bold px-8 py-4 rounded-lg inline-block transition-colors">
            Start Learning Free
        </a>
    </div>
</div>
