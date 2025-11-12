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
    
    <?php 
    $content = ob_start(); 
    ?>
    
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-primary to-blue-700 text-white py-16">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl font-bold mb-4">About Nebatech</h1>
                <p class="text-xl text-gray-200">Innovation, excellence, and a commitment to transforming technology into solutions that empower businesses</p>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Our Story</h2>
                <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                    Nebatech Software Solution Ltd is a leading technology firm dedicated to providing innovative IT solutions and services. From mobile and web development to IT training and network solutions, our passion lies in transforming ideas into reality.
                </p>
                <p class="text-lg text-gray-700 leading-relaxed">
                    With a deep commitment to quality and customer satisfaction, we continue to drive excellence in every project we undertake. Our team of skilled professionals brings years of experience and expertise to deliver solutions that make a real difference.
                </p>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <div class="text-5xl mb-4">🎯</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Our Mission</h3>
                    <p class="text-gray-700 leading-relaxed">
                        To provide innovative and transformative technological solutions and training to individuals and organizations that streamline operations, foster growth, and drive success.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <div class="text-5xl mb-4">🚀</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Our Vision</h3>
                    <p class="text-gray-700 leading-relaxed">
                        To become the leading hub of innovation and technical excellence in Africa and beyond, empowering businesses and individuals with cutting-edge technology solutions.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Our Core Values</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">The principles that guide everything we do</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <div class="text-center p-6">
                    <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Integrity</h3>
                    <p class="text-gray-600">We uphold honesty and strong moral principles in every aspect of our work.</p>
                </div>

                <div class="text-center p-6">
                    <div class="bg-orange-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Innovation</h3>
                    <p class="text-gray-600">We continuously seek creative solutions and embrace new technologies.</p>
                </div>

                <div class="text-center p-6">
                    <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Excellence</h3>
                    <p class="text-gray-600">We strive for perfection in every project, delivering quality and reliability.</p>
                </div>

                <div class="text-center p-6">
                    <div class="bg-purple-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Teamwork</h3>
                    <p class="text-gray-600">Collaboration and respect drive our success and foster a positive work environment.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CEO Message Section -->
    <section class="py-16 bg-gradient-to-br from-primary to-blue-700 text-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-8">
                    <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-primary text-4xl font-bold">
                        AH
                    </div>
                    <h2 class="text-3xl font-bold mb-2">CEO Message</h2>
                    <p class="text-xl text-gray-200">Innovate. Transform. Succeed.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm p-8 rounded-xl">
                    <p class="text-lg leading-relaxed mb-4">
                        "At Nebatech Software Solution Ltd., we believe technology has the power to redefine possibilities. Our mission is to provide innovative and transformative technological solutions and training that streamline operations, foster growth, and drive success for individuals and organizations.
                    </p>
                    <p class="text-lg leading-relaxed mb-4">
                        Whether you're looking to develop a cutting-edge web or mobile application, enhance and optimize your IT infrastructure, or gain hands-on training in emerging technologies, Nebatech is your trusted partner.
                    </p>
                    <p class="text-lg leading-relaxed">
                        Let's shape the future together—one innovation at a time."
                    </p>
                    <div class="mt-6 pt-6 border-t border-white/20">
                        <p class="font-bold text-xl">Abdul-Hafiz Yussif</p>
                        <p class="text-gray-200">Founder & CEO, Software Engineer</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Meet Our Team</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Dedicated professionals committed to your success</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Team Member 1 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-primary to-blue-700 flex items-center justify-center">
                        <div class="w-32 h-32 bg-white text-primary rounded-full flex items-center justify-center text-4xl font-bold">
                            AH
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-1 text-gray-800">Abdul-Hafiz Yussif</h3>
                        <p class="text-primary font-semibold text-sm mb-3">Software Engineer</p>
                        <p class="text-gray-600 text-sm">Expert in Front-End & Back-End Development</p>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center">
                        <div class="w-32 h-32 bg-white text-green-600 rounded-full flex items-center justify-center text-4xl font-bold">
                            EF
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-1 text-gray-800">Elsie Kufui Funkor</h3>
                        <p class="text-green-600 font-semibold text-sm mb-3">Project Manager</p>
                        <p class="text-gray-600 text-sm">Expert in project management</p>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center">
                        <div class="w-32 h-32 bg-white text-purple-600 rounded-full flex items-center justify-center text-4xl font-bold">
                            AA
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-1 text-gray-800">Abass Nabila Alhassan</h3>
                        <p class="text-purple-600 font-semibold text-sm mb-3">Computer Technician</p>
                        <p class="text-gray-600 text-sm">Expert in repairing laptops and desktop computers</p>
                    </div>
                </div>

                <!-- Team Member 4 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-pink-500 to-pink-700 flex items-center justify-center">
                        <div class="w-32 h-32 bg-white text-pink-600 rounded-full flex items-center justify-center text-4xl font-bold">
                            AI
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-1 text-gray-800">Asana Issahaku</h3>
                        <p class="text-pink-600 font-semibold text-sm mb-3">UI/UX & Graphic Designer</p>
                        <p class="text-gray-600 text-sm">Passionate about crafting intuitive digital experiences</p>
                    </div>
                </div>

                <!-- Team Member 5 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-orange-500 to-orange-700 flex items-center justify-center">
                        <div class="w-32 h-32 bg-white text-secondary rounded-full flex items-center justify-center text-4xl font-bold">
                            MY
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-1 text-gray-800">Mohammed Awal Yussif</h3>
                        <p class="text-secondary font-semibold text-sm mb-3">iPhone Technician</p>
                        <p class="text-gray-600 text-sm">Specializes in iPhone repairs</p>
                    </div>
                </div>

                <!-- Team Member 6 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-teal-500 to-teal-700 flex items-center justify-center">
                        <div class="w-32 h-32 bg-white text-teal-600 rounded-full flex items-center justify-center text-4xl font-bold">
                            SK
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-1 text-gray-800">Suhunum Khadijah</h3>
                        <p class="text-teal-600 font-semibold text-sm mb-3">Front Desk Officer</p>
                        <p class="text-gray-600 text-sm">Specializes in customer care and support</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Ready to Work With Us?</h2>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Let's discuss how we can help transform your business with innovative technology solutions.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="<?= url('/request-quote') ?>" class="bg-primary hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-lg transition-colors">
                    Request a Quote
                </a>
                <a href="<?= url('/contact') ?>" class="bg-secondary hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-lg transition-colors">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
