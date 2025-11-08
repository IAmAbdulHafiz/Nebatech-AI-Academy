<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Nebatech AI Academy</title>
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <!-- Alpine.js Collapse Plugin (must load before Alpine core) -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <!-- Hero Section -->
    <section class="bg-primary text-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-5xl font-bold mb-6">About Nebatech AI Academy</h1>
            <p class="text-xl max-w-3xl mx-auto">
                Empowering the next generation of tech professionals through AI-powered, hands-on learning experiences
            </p>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <div class="bg-blue-50 p-8 rounded-2xl border-2 border-blue-100">
                    <div class="text-5xl mb-4">🎯</div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Mission</h2>
                    <p class="text-gray-700 text-lg">
                        To democratize quality tech education by providing free, AI-powered learning experiences that enable anyone, anywhere to acquire in-demand IT skills and transform their careers.
                    </p>
                </div>
                <div class="bg-orange-50 p-8 rounded-2xl border-2 border-orange-100">
                    <div class="text-5xl mb-4">🚀</div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Vision</h2>
                    <p class="text-gray-700 text-lg">
                        To be the leading AI-powered learning platform globally, bridging the tech skills gap and creating a million tech professionals by 2030.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-4xl font-bold text-gray-800 mb-8 text-center">Our Story</h2>
                <div class="bg-white p-8 rounded-2xl shadow-lg">
                    <p class="text-gray-700 text-lg mb-6">
                        Nebatech AI Academy was founded with a simple yet powerful belief: quality tech education should be accessible to everyone, regardless of their background or financial situation.
                    </p>
                    <p class="text-gray-700 text-lg mb-6">
                        We recognized that traditional education systems were failing to keep pace with the rapidly evolving tech industry. Students were graduating with outdated skills, bootcamps were expensive and inaccessible, and self-learning was often frustrating and ineffective.
                    </p>
                    <p class="text-gray-700 text-lg mb-6">
                        By combining artificial intelligence, competency-based learning, and hands-on projects, we created a platform that adapts to each student's unique learning style and pace. Our AI tutors provide 24/7 support, instant feedback, and personalized guidance - something previously only available to those who could afford expensive private tutoring.
                    </p>
                    <p class="text-gray-700 text-lg">
                        Today, over 10,000 students from across the globe are learning with us, building real projects, and launching successful tech careers. And we're just getting started.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-gray-800 mb-12 text-center">Our Core Values</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">🌍</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Accessibility</h3>
                    <p class="text-gray-600">Free, quality education for everyone, everywhere</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">💡</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Innovation</h3>
                    <p class="text-gray-600">Leveraging AI to revolutionize learning experiences</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">🎓</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Excellence</h3>
                    <p class="text-gray-600">Maintaining high standards in curriculum and support</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">🤝</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Community</h3>
                    <p class="text-gray-600">Building a supportive global learning community</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-gray-800 mb-4 text-center">Meet Our Leadership Team</h2>
            <p class="text-xl text-gray-600 text-center mb-12 max-w-2xl mx-auto">
                Experienced professionals passionate about transforming tech education
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Team Member 1 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all">
                    <div class="h-64 bg-blue-100 flex items-center justify-center">
                        <div class="w-40 h-40 bg-primary text-white rounded-full flex items-center justify-center text-5xl font-bold">
                            AH
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-2xl font-bold mb-1">Abdul Hafiz</h3>
                        <p class="text-primary font-semibold mb-3">Founder & CEO</p>
                        <p class="text-gray-600 text-sm mb-4">
                            Visionary leader with 15+ years in EdTech and AI. Former Google engineer passionate about democratizing education.
                        </p>
                        <div class="flex justify-center space-x-3">
                            <a href="#" class="text-gray-400 hover:text-primary">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-primary">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all">
                    <div class="h-64 bg-green-100 flex items-center justify-center">
                        <div class="w-40 h-40 bg-green-600 text-white rounded-full flex items-center justify-center text-5xl font-bold">
                            SK
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-2xl font-bold mb-1">Sarah Kwame</h3>
                        <p class="text-green-600 font-semibold mb-3">Chief Technology Officer</p>
                        <p class="text-gray-600 text-sm mb-4">
                            AI specialist and full-stack architect. PhD in Machine Learning from Stanford. Built AI systems at Amazon.
                        </p>
                        <div class="flex justify-center space-x-3">
                            <a href="#" class="text-gray-400 hover:text-green-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-green-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all">
                    <div class="h-64 bg-orange-100 flex items-center justify-center">
                        <div class="w-40 h-40 bg-secondary text-white rounded-full flex items-center justify-center text-5xl font-bold">
                            JM
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-2xl font-bold mb-1">John Mensah</h3>
                        <p class="text-secondary font-semibold mb-3">Head of Education</p>
                        <p class="text-gray-600 text-sm mb-4">
                            Curriculum design expert with 12+ years experience. Former lead instructor at top coding bootcamps.
                        </p>
                        <div class="flex justify-center space-x-3">
                            <a href="#" class="text-gray-400 hover:text-secondary">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-secondary">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-gray-800 mb-12 text-center">Our Impact in Numbers</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-5xl mx-auto">
                <div class="text-center">
                    <div class="text-5xl font-bold text-primary mb-2">10,000+</div>
                    <div class="text-gray-600">Active Students</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-primary mb-2">50+</div>
                    <div class="text-gray-600">Expert Courses</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-primary mb-2">95%</div>
                    <div class="text-gray-600">Success Rate</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-primary mb-2">30+</div>
                    <div class="text-gray-600">Countries</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-primary text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">Ready to Start Your Journey?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Join thousands of students learning with AI-powered personalized education</p>
            <a href="<?= url('/register') ?>" class="bg-secondary hover:bg-orange-600 text-white font-bold text-lg px-12 py-4 rounded-lg transition-all transform hover:scale-105 inline-block shadow-xl">
                Get Started Free
            </a>
        </div>
    </section>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
