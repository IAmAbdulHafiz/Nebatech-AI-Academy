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
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">About Nebatech</h1>
            <p class="text-xl md:text-2xl text-gray-200 max-w-2xl mx-auto">
                Innovation, excellence, and a commitment to transforming technology into solutions that empower businesses and individuals
            </p>
        </div>
    </div>
</section>

<!-- Company Story Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Our Story</h2>
                <div class="w-24 h-1 bg-secondary mx-auto mb-6"></div>
            </div>
            
            <div class="prose prose-lg mx-auto text-gray-600">
                <p class="text-xl leading-relaxed mb-6">
                    Founded in 2019, Nebatech Software Solution Ltd emerged from a vision to bridge the technology gap in Northern Ghana and beyond. What started as a small team of passionate developers has grown into a comprehensive technology solutions provider, serving businesses across various industries.
                </p>
                
                <p class="text-lg leading-relaxed mb-6">
                    Our journey began with a simple mission: to make cutting-edge technology accessible to businesses of all sizes while empowering individuals through quality IT education. Today, we stand as a trusted partner for over 1000+ businesses and have trained hundreds of students in various technology disciplines.
                </p>
                
                <p class="text-lg leading-relaxed">
                    From our headquarters in Tamale, we continue to expand our reach, delivering innovative solutions that drive business growth and foster technological advancement in our communities.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Mission, Vision, Values Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Our Foundation</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                The core principles that guide everything we do at Nebatech
            </p>
            <div class="w-24 h-1 bg-secondary mx-auto mt-6"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            <!-- Mission -->
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 mx-auto shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Our Mission</h3>
                </div>
                <p class="text-gray-600 leading-relaxed text-center">
                    To empower businesses and individuals with cutting-edge technology solutions and comprehensive IT education that drives innovation, growth, and digital transformation.
                </p>
            </div>

            <!-- Vision -->
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 mx-auto shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Our Vision</h3>
                </div>
                <p class="text-gray-600 leading-relaxed text-center">
                    To be the leading technology solutions provider in West Africa, recognized for excellence in software development, IT services, and technology education.
                </p>
            </div>

            <!-- Values -->
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 mx-auto shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Our Values</h3>
                </div>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-800">Integrity:</span>
                            <span class="text-gray-600 ml-1">Honest and transparent in all dealings</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <div class="w-2 h-2 bg-orange-600 rounded-full"></div>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-800">Innovation:</span>
                            <span class="text-gray-600 ml-1">Embracing new technologies and ideas</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <div class="w-2 h-2 bg-green-600 rounded-full"></div>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-800">Excellence:</span>
                            <span class="text-gray-600 ml-1">Delivering quality in every project</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <div class="w-2 h-2 bg-purple-600 rounded-full"></div>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-800">Teamwork:</span>
                            <span class="text-gray-600 ml-1">Collaborating for collective success</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CEO Message Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-gray-50 rounded-2xl p-8 md:p-12">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="w-32 h-32 bg-primary rounded-full flex items-center justify-center text-white text-4xl font-bold flex-shrink-0">
                        AY
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Message from Our CEO</h3>
                        <blockquote class="text-lg text-gray-600 italic leading-relaxed mb-4">
                            "At Nebatech, we believe that technology should be a catalyst for growth, not a barrier. Our commitment goes beyond delivering solutions – we're building lasting partnerships and empowering the next generation of tech professionals. Every project we undertake and every student we train is a step toward a more connected and innovative future."
                        </blockquote>
                        <div class="text-gray-800">
                            <div class="font-bold text-lg">Abdul-Hafiz Yussif</div>
                            <div class="text-gray-600">Founder & CEO, Software Engineer</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Meet Our Team</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Passionate professionals dedicated to delivering excellence in every project
            </p>
            <div class="w-24 h-1 bg-secondary mx-auto mt-6"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Team Member 1 -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="p-6 text-center">
                    <div class="w-24 h-24 bg-primary rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                        AY
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Abdul-Hafiz Yussif</h3>
                    <p class="text-secondary font-semibold mb-3">Founder & CEO, Software Engineer</p>
                    <p class="text-gray-600 text-sm">
                        Visionary leader with expertise in software architecture and business strategy. Passionate about technology education and innovation.
                    </p>
                </div>
            </div>

            <!-- Team Member 2 -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="p-6 text-center">
                    <div class="w-24 h-24 bg-secondary rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                        EF
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Elsie Kufui Funkor</h3>
                    <p class="text-secondary font-semibold mb-3">Project Manager</p>
                    <p class="text-gray-600 text-sm">
                        Expert project coordinator ensuring seamless delivery of client solutions and maintaining high standards of quality.
                    </p>
                </div>
            </div>

            <!-- Team Member 3 -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="p-6 text-center">
                    <div class="w-24 h-24 bg-green-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                        AA
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Abass Nabila Alhassan</h3>
                    <p class="text-secondary font-semibold mb-3">Computer Technician</p>
                    <p class="text-gray-600 text-sm">
                        Hardware specialist providing technical support, system maintenance, and infrastructure solutions.
                    </p>
                </div>
            </div>

            <!-- Team Member 4 -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="p-6 text-center">
                    <div class="w-24 h-24 bg-purple-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                        AI
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Asana Issahaku</h3>
                    <p class="text-secondary font-semibold mb-3">UI/UX & Graphic Designer</p>
                    <p class="text-gray-600 text-sm">
                        Creative designer crafting beautiful and intuitive user experiences for web and mobile applications.
                    </p>
                </div>
            </div>

            <!-- Team Member 5 -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="p-6 text-center">
                    <div class="w-24 h-24 bg-blue-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                        MY
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Mohammed Awal Yussif</h3>
                    <p class="text-secondary font-semibold mb-3">iPhone Technician</p>
                    <p class="text-gray-600 text-sm">
                        Specialized technician providing expert iPhone and mobile device repair services with precision and care.
                    </p>
                </div>
            </div>

            <!-- Team Member 6 -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="p-6 text-center">
                    <div class="w-24 h-24 bg-pink-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                        SK
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Suhunum Khadijah</h3>
                    <p class="text-secondary font-semibold mb-3">Front Desk Officer</p>
                    <p class="text-gray-600 text-sm">
                        Customer service specialist ensuring excellent client experience and smooth office operations.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-primary text-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-4">Ready to Work with Us?</h2>
        <p class="text-xl mb-8 text-gray-200 max-w-2xl mx-auto">
            Let's discuss how we can help transform your business with innovative technology solutions.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="<?= url('/services') ?>" class="bg-secondary hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-lg transition-colors">
                View Our Services
            </a>
            <a href="<?= url('/contact') ?>" class="bg-white text-primary hover:bg-gray-100 font-bold px-8 py-3 rounded-lg transition-colors">
                Get in Touch
            </a>
        </div>
    </div>
</section>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php'; 
?>
