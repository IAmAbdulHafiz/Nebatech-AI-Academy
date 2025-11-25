<!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-cyan-900 via-cyan-700 to-cyan-600 text-white py-20 overflow-hidden">
        <!-- Digital Horizon Background -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-96 bg-gradient-to-t from-cyan-500/30 via-cyan-400/10 to-transparent"></div>
            <div class="absolute top-0 left-0 right-0 h-96 bg-gradient-to-b from-cyan-800/50 via-transparent to-transparent"></div>
            
            <div class="absolute inset-0">
                <div class="absolute top-0 left-1/4 w-1 h-full bg-gradient-to-b from-cyan-400/40 via-cyan-400/20 to-transparent transform -skew-x-12 animate-pulse" style="animation-duration: 3s;"></div>
                <div class="absolute top-0 right-1/3 w-1 h-full bg-gradient-to-b from-cyan-300/30 via-cyan-300/10 to-transparent transform skew-x-12 animate-pulse" style="animation-duration: 4s; animation-delay: 1s;"></div>
                <div class="absolute top-0 left-2/3 w-0.5 h-full bg-gradient-to-b from-cyan-400/30 via-transparent to-transparent transform -skew-x-6 animate-pulse" style="animation-duration: 5s; animation-delay: 2s;"></div>
            </div>
            
            <div class="absolute top-20 left-10 w-96 h-96 bg-cyan-500/40 rounded-full blur-3xl animate-pulse" style="animation-duration: 6s;"></div>
            <div class="absolute bottom-10 right-10 w-[500px] h-[500px] bg-cyan-400/30 rounded-full blur-3xl animate-pulse" style="animation-duration: 8s; animation-delay: 1s;"></div>
            
            <div class="absolute top-1/4 left-[10%] opacity-20 animate-float" style="animation-duration: 6s;">
                <i class="fas fa-network-wired text-6xl text-white/80"></i>
            </div>
            <div class="absolute top-1/3 right-[15%] opacity-20 animate-float" style="animation-duration: 7s; animation-delay: 1s;">
                <i class="fas fa-globe text-6xl text-white/70"></i>
            </div>
            <div class="absolute bottom-1/4 left-[20%] opacity-20 animate-float" style="animation-duration: 8s; animation-delay: 2s;">
                <i class="fas fa-wifi text-6xl text-white/80"></i>
            </div>
            <div class="absolute bottom-1/3 right-[12%] opacity-20 animate-float" style="animation-duration: 6.5s; animation-delay: 0.5s;">
                <i class="fas fa-server text-6xl text-white/70"></i>
            </div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-block bg-cyan-800/60 backdrop-blur-sm text-cyan-100 px-4 py-2 rounded-full text-sm font-semibold mb-6 border border-cyan-400/30">
                    <i class="fas fa-network-wired mr-2"></i>Networking Engineering
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    Master Networking Engineering
                </h1>
                <p class="text-xl md:text-2xl text-white/90 mb-8">
                    Learn to design, configure, and manage enterprise networks with Cisco, routing, switching, and security
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#courses" class="bg-white text-cyan-600 px-8 py-4 rounded-lg font-semibold hover:bg-cyan-50 transition inline-flex items-center shadow-lg hover:shadow-xl">
                        <i class="fas fa-rocket mr-2"></i>Get Started
                    </a>
                    <a href="<?= url('/register') ?>" class="bg-cyan-800/60 backdrop-blur-sm text-white px-8 py-4 rounded-lg font-semibold hover:bg-cyan-800 transition inline-flex items-center border-2 border-cyan-400/50 shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>Enroll Free
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-cyan-400/20">
                        <div class="text-3xl font-bold">10+</div>
                        <div class="text-cyan-200 text-sm">Modules</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-cyan-400/20">
                        <div class="text-3xl font-bold">3,800+</div>
                        <div class="text-cyan-200 text-sm">Students</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-cyan-400/20">
                        <div class="text-3xl font-bold">35+</div>
                        <div class="text-cyan-200 text-sm">Hours Content</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-cyan-400/20">
                        <div class="text-3xl font-bold">91%</div>
                        <div class="text-cyan-200 text-sm">Success Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Learning Path -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Your Learning Path</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Follow our structured curriculum from networking fundamentals to enterprise infrastructure
                </p>
            </div>

            <div class="max-w-5xl mx-auto">
                <div class="space-y-8">
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                        <div class="flex items-start gap-4">
                            <div class="bg-green-100 text-green-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">
                                1
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Beginner Level</h3>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">2-3 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Master networking fundamentals and basic configurations</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-cyan-100 text-cyan-700 px-3 py-1 rounded-lg text-sm font-medium">Network Basics</span>
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">TCP/IP</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Subnetting</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Basic Routing</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                        <div class="flex items-start gap-4">
                            <div class="bg-blue-100 text-blue-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">
                                2
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Intermediate Level</h3>
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">3-4 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Advanced routing and switching configurations</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm font-medium">Cisco IOS</span>
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">VLANs</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Routing Protocols</span>
                                    <span class="bg-pink-100 text-pink-700 px-3 py-1 rounded-lg text-sm font-medium">Network Security</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                        <div class="flex items-start gap-4">
                            <div class="bg-purple-100 text-purple-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">
                                3
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Advanced Level</h3>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">4-5 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Enterprise networking and infrastructure management</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-cyan-100 text-cyan-700 px-3 py-1 rounded-lg text-sm font-medium">BGP/OSPF</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">SD-WAN</span>
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">Firewall</span>
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">Wireless</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills You'll Gain -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Skills You'll Gain</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Develop in-demand networking skills that employers are looking for
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-cyan-600">
                    <div class="text-cyan-600 text-4xl mb-4">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Network Design</h3>
                    <p class="text-gray-600">Design efficient and scalable network topologies for enterprises.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-green-500">
                    <div class="text-green-600 text-4xl mb-4">
                        <i class="fas fa-route"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Routing & Switching</h3>
                    <p class="text-gray-600">Master Cisco routing protocols and switching configurations.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-purple-500">
                    <div class="text-purple-600 text-4xl mb-4">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Performance Optimization</h3>
                    <p class="text-gray-600">Optimize network performance with QoS and traffic management.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-yellow-500">
                    <div class="text-yellow-600 text-4xl mb-4">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Network Security</h3>
                    <p class="text-gray-600">Implement firewalls, VPNs, and security protocols for networks.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-red-500">
                    <div class="text-red-600 text-4xl mb-4">
                        <i class="fas fa-wifi"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Wireless Networks</h3>
                    <p class="text-gray-600">Design and configure enterprise wireless infrastructure.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-orange-500">
                    <div class="text-orange-600 text-4xl mb-4">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Network Troubleshooting</h3>
                    <p class="text-gray-600">Diagnose and resolve network issues with industry tools.</p>
                </div>
            </div>
        </div>
    
    <!-- Courses Listing -->
    <section id="courses" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Bundle Pricing Banner -->
            <div class="max-w-4xl mx-auto mb-12">
                <div class="bg-gradient-to-r from-cyan-600 to-cyan-700 rounded-2xl p-8 text-white shadow-xl">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-2xl md:text-3xl font-bold mb-2">Complete Networking Track Bundle</h3>
                            <p class="text-white/90 mb-3">Get all 4 courses + CCNA prep + lifetime access</p>
                            <div class="flex items-center gap-4 justify-center md:justify-start">
                                <span class="text-lg line-through text-white/70">GHS 5,800</span>
                                <span class="bg-green-500 text-white px-4 py-1 rounded-full font-bold text-sm">Save 45%</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-5xl font-bold mb-2">GHS 3,190</div>
                            <a href="<?= url('/courses/networking/enroll') ?>" class="inline-block bg-white text-cyan-600 px-8 py-3 rounded-lg font-bold hover:bg-cyan-50 transition shadow-lg">
                                Enroll in Bundle
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Individual Courses</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Or choose individual courses - each sold separately
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <!-- Course 1: Network Fundamentals -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-cyan-600 h-48 flex items-center justify-center">
                        <i class="fas fa-network-wired text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Beginner</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(2,950)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Network Fundamentals</h3>
                        <p class="text-gray-600 mb-4">Learn TCP/IP, OSI model, and network fundamentals.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>30 hours</span>
                            <span><i class="fas fa-book mr-1"></i>35 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>3.5K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-primary">GHS 980</div>
                            <a href="#" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/70 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 2: Cisco Routing -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-blue-600 h-48 flex items-center justify-center">
                        <i class="fas fa-server text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-primary px-3 py-1 rounded-full text-sm font-semibold">Intermediate</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(2,680)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Cisco CCNA Routing</h3>
                        <p class="text-gray-600 mb-4">Master Cisco IOS, routing protocols, and VLANs.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>40 hours</span>
                            <span><i class="fas fa-book mr-1"></i>45 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>3.2K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-primary">GHS 1,650</div>
                            <a href="#" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/70 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 3: Network Security -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-red-600 h-48 flex items-center justify-center">
                        <i class="fas fa-shield-alt text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">Advanced</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(2,420)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Network Security</h3>
                        <p class="text-gray-600 mb-4">Secure networks with firewalls, VPNs, and IDS.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>45 hours</span>
                            <span><i class="fas fa-book mr-1"></i>50 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>2.9K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-primary">GHS 1,890</div>
                            <a href="#" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/70 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="<?= url('/courses') ?>" class="inline-flex items-center text-cyan-600 hover:text-cyan-700 font-semibold">
                    View All Courses <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Career Outcomes -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Career Outcomes</h2>
                        <p class="text-xl text-gray-600 mb-8">
                            Network engineers are critical to IT infrastructure. Our graduates work at:
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Telecommunications</h4>
                                    <p class="text-gray-600">ISPs, telecom companies, network service providers</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Enterprise IT</h4>
                                    <p class="text-gray-600">Large corporations managing network infrastructure</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Cloud Providers</h4>
                                    <p class="text-gray-600">AWS, Azure, Google Cloud network operations</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Consulting</h4>
                                    <p class="text-gray-600">Design and implement networks for multiple clients</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-cyan-50 rounded-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Average Salaries</h3>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Junior Network Engineer</span>
                                    <span class="font-bold text-cyan-600">$55K - $75K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-green-500 h-full rounded-full" style="width: 50%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Network Engineer</span>
                                    <span class="font-bold text-cyan-600">$75K - $105K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-cyan-500 h-full rounded-full" style="width: 70%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Senior Network Engineer</span>
                                    <span class="font-bold text-cyan-600">$105K - $150K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-purple-500 h-full rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Network Architect</span>
                                    <span class="font-bold text-cyan-600">$150K+</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-red-500 h-full rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-600 mt-6">
                            <i class="fas fa-info-circle mr-1"></i>
                            Cisco certifications significantly boost earning potential
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-cyan-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Become a Network Engineer?</h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                Join thousands learning networking engineering with Nebatech AI Academy
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?= url('/register') ?>" class="bg-white text-cyan-600 px-8 py-4 rounded-lg font-semibold hover:bg-cyan-50 transition inline-flex items-center">
                    <i class="fas fa-rocket mr-2"></i>Get Started Free
                </a>
                <a href="<?= url('/contact') ?>" class="bg-cyan-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-cyan-800 transition inline-flex items-center border-2 border-cyan-500">
                    <i class="fas fa-comment mr-2"></i>Talk to an Advisor
                </a>
            </div>
        </div>
    </section>


