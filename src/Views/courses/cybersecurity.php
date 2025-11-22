<!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-red-900 via-red-700 to-red-600 text-white py-20 overflow-hidden">
        <!-- Digital Horizon Background -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Horizon Glow Effect -->
            <div class="absolute bottom-0 left-0 right-0 h-96 bg-gradient-to-t from-red-500/30 via-red-400/10 to-transparent"></div>
            <div class="absolute top-0 left-0 right-0 h-96 bg-gradient-to-b from-red-800/50 via-transparent to-transparent"></div>
            
            <!-- Geometric Light Beams -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-1/4 w-1 h-full bg-gradient-to-b from-red-400/40 via-red-400/20 to-transparent transform -skew-x-12 animate-pulse" style="animation-duration: 3s;"></div>
                <div class="absolute top-0 right-1/3 w-1 h-full bg-gradient-to-b from-red-300/30 via-red-300/10 to-transparent transform skew-x-12 animate-pulse" style="animation-duration: 4s; animation-delay: 1s;"></div>
                <div class="absolute top-0 left-2/3 w-0.5 h-full bg-gradient-to-b from-red-400/30 via-transparent to-transparent transform -skew-x-6 animate-pulse" style="animation-duration: 5s; animation-delay: 2s;"></div>
            </div>
            
            <!-- Dynamic Glowing Orbs -->
            <div class="absolute top-20 left-10 w-96 h-96 bg-red-500/40 rounded-full blur-3xl animate-pulse" style="animation-duration: 6s;"></div>
            <div class="absolute bottom-10 right-10 w-[500px] h-[500px] bg-red-400/30 rounded-full blur-3xl animate-pulse" style="animation-duration: 8s; animation-delay: 1s;"></div>
            
            <!-- Cybersecurity Icons Floating -->
            <div class="absolute top-1/4 left-[10%] opacity-20 animate-float" style="animation-duration: 6s;">
                <i class="fas fa-shield-alt text-6xl text-red-300"></i>
            </div>
            <div class="absolute top-1/3 right-[15%] opacity-20 animate-float" style="animation-duration: 7s; animation-delay: 1s;">
                <i class="fas fa-lock text-6xl text-red-200"></i>
            </div>
            <div class="absolute bottom-1/4 left-[20%] opacity-20 animate-float" style="animation-duration: 8s; animation-delay: 2s;">
                <i class="fas fa-user-secret text-6xl text-red-300"></i>
            </div>
            <div class="absolute bottom-1/3 right-[12%] opacity-20 animate-float" style="animation-duration: 6.5s; animation-delay: 0.5s;">
                <i class="fas fa-bug text-6xl text-red-200"></i>
            </div>
        </div>
        
        <!-- Content -->
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-block bg-red-800/60 backdrop-blur-sm text-red-100 px-4 py-2 rounded-full text-sm font-semibold mb-6 border border-red-400/30">
                    <i class="fas fa-shield-alt mr-2"></i>Cybersecurity
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    Master Cybersecurity
                </h1>
                <p class="text-xl md:text-2xl text-red-100 mb-8">
                    Protect systems and data with ethical hacking, penetration testing, and advanced security techniques
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#courses" class="bg-white text-red-600 px-8 py-4 rounded-lg font-semibold hover:bg-red-50 transition inline-flex items-center shadow-lg hover:shadow-xl">
                        <i class="fas fa-rocket mr-2"></i>Browse Courses
                    </a>
                    <a href="<?= url('/register') ?>" class="bg-red-800/60 backdrop-blur-sm text-white px-8 py-4 rounded-lg font-semibold hover:bg-red-800 transition inline-flex items-center border-2 border-red-400/50 shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>Get Started Free
                    </a>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-red-400/20">
                        <div class="text-3xl font-bold">22+</div>
                        <div class="text-red-200 text-sm">Modules</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-red-400/20">
                        <div class="text-3xl font-bold">9,800+</div>
                        <div class="text-red-200 text-sm">Students</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-red-400/20">
                        <div class="text-3xl font-bold">320+</div>
                        <div class="text-red-200 text-sm">Hours Content</div>
                    </div>
                    <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-red-400/20">
                        <div class="text-3xl font-bold">98%</div>
                        <div class="text-red-200 text-sm">Success Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Learning Path -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Your Cybersecurity Learning Path</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    From security fundamentals to advanced penetration testing
                </p>
            </div>

            <div class="max-w-5xl mx-auto space-y-8">
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-primary/90">
                    <div class="flex items-start gap-4">
                        <div class="bg-blue-100 text-primary w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">1</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-900">Security Fundamentals</h3>
                                <span class="bg-blue-100 text-primary px-3 py-1 rounded-full text-sm font-semibold">3-6 months</span>
                            </div>
                            <p class="text-gray-600 mb-4">Learn the foundations of cybersecurity and networking</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-blue-100 text-primary px-3 py-1 rounded-lg text-sm font-medium">Network Security</span>
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Security Basics</span>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Linux</span>
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">TCP/IP</span>
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm font-medium">Protocols</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-start gap-4">
                        <div class="bg-green-100 text-green-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">2</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-900">Offensive Security</h3>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">6-12 months</span>
                            </div>
                            <p class="text-gray-600 mb-4">Learn ethical hacking and penetration testing</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">Ethical Hacking</span>
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Penetration Testing</span>
                                <span class="bg-blue-100 text-primary px-3 py-1 rounded-lg text-sm font-medium">Metasploit</span>
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">Kali Linux</span>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Vulnerability Assessment</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                    <div class="flex items-start gap-4">
                        <div class="bg-purple-100 text-purple-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">3</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-900">Defensive Security</h3>
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">6-12 months</span>
                            </div>
                            <p class="text-gray-600 mb-4">Protect systems and respond to security incidents</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-blue-100 text-primary px-3 py-1 rounded-lg text-sm font-medium">Incident Response</span>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">SIEM</span>
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Threat Hunting</span>
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">Forensics</span>
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">Malware Analysis</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
                    <div class="flex items-start gap-4">
                        <div class="bg-orange-100 text-orange-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">4</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-900">Advanced & Certifications</h3>
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-semibold">6-12 months</span>
                            </div>
                            <p class="text-gray-600 mb-4">Specialize and earn industry certifications</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">CEH</span>
                                <span class="bg-blue-100 text-primary px-3 py-1 rounded-lg text-sm font-medium">OSCP</span>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">CISSP</span>
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Cloud Security</span>
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">Security Architecture</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Skills You'll Gain</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Become a cybersecurity professional protecting digital assets
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-red-500">
                    <div class="text-red-600 text-4xl mb-4"><i class="fas fa-user-secret"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Ethical Hacking</h3>
                    <p class="text-gray-600">Identify vulnerabilities and exploit them ethically to improve security.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-primary/90">
                    <div class="text-primary text-4xl mb-4"><i class="fas fa-network-wired"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Network Security</h3>
                    <p class="text-gray-600">Secure networks, firewalls, and implement security protocols.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-purple-500">
                    <div class="text-purple-600 text-4xl mb-4"><i class="fas fa-bug"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Penetration Testing</h3>
                    <p class="text-gray-600">Conduct security assessments and penetration tests.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-green-500">
                    <div class="text-green-600 text-4xl mb-4"><i class="fas fa-shield-virus"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Malware Analysis</h3>
                    <p class="text-gray-600">Analyze and reverse engineer malicious software.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-orange-500">
                    <div class="text-orange-600 text-4xl mb-4"><i class="fas fa-search"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Incident Response</h3>
                    <p class="text-gray-600">Respond to and recover from security breaches.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-yellow-500">
                    <div class="text-yellow-600 text-4xl mb-4"><i class="fas fa-cloud-upload-alt"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Cloud Security</h3>
                    <p class="text-gray-600">Secure cloud infrastructure and applications.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Listing -->
    <section id="courses" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Bundle Pricing Banner -->
            <div class="max-w-4xl mx-auto mb-12">
                <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-2xl p-8 text-white shadow-xl">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-2xl md:text-3xl font-bold mb-2">Complete Cybersecurity Track Bundle</h3>
                            <p class="text-red-100 mb-3">Get all 6 courses + certifications + lifetime access</p>
                            <div class="flex items-center gap-4 justify-center md:justify-start">
                                <span class="text-lg line-through text-red-200">GHS 21,500</span>
                                <span class="bg-yellow-400 text-gray-900 px-4 py-1 rounded-full font-bold text-sm">Save 28%</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-5xl font-bold mb-2">GHS 15,500</div>
                            <a href="<?= url('/courses/cybersecurity/enroll') ?>" class="inline-block bg-white text-red-600 px-8 py-3 rounded-lg font-bold hover:bg-red-50 transition shadow-lg">
                                Enroll in Bundle
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Individual Courses</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Or choose individual courses - each sold separately</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-red-600 h-48 flex items-center justify-center">
                        <i class="fas fa-user-secret text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Beginner</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(4,560)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Ethical Hacking Bootcamp</h3>
                        <p class="text-gray-600 mb-4">Complete ethical hacking course covering all CEH topics.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>100 hours</span>
                            <span><i class="fas fa-book mr-1"></i>125 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>11.2K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-red-600">GHS 3,620</div>
                            <a href="#" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-semibold">Enroll Now</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-primary/70 h-48 flex items-center justify-center">
                        <i class="fas fa-network-wired text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Beginner</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                <span class="text-gray-600 text-sm ml-1">(3,890)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Network Security Fundamentals</h3>
                        <p class="text-gray-600 mb-4">Secure networks with firewalls, VPNs, and security protocols.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>75 hours</span>
                            <span><i class="fas fa-book mr-1"></i>92 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>8.5K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-red-600">GHS 2,890</div>
                            <a href="#" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-semibold">Enroll Now</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-purple-600 h-48 flex items-center justify-center">
                        <i class="fas fa-bug text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-primary px-3 py-1 rounded-full text-sm font-semibold">Intermediate</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(3,240)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Penetration Testing Pro</h3>
                        <p class="text-gray-600 mb-4">Advanced penetration testing with Kali Linux and Metasploit.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>90 hours</span>
                            <span><i class="fas fa-book mr-1"></i>112 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>6.8K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-red-600">GHS 4,110</div>
                            <a href="#" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-semibold">Enroll Now</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-green-600 h-48 flex items-center justify-center">
                        <i class="fas fa-shield-virus text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">Advanced</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(2,180)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Malware Analysis</h3>
                        <p class="text-gray-600 mb-4">Analyze and reverse engineer malicious software.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>65 hours</span>
                            <span><i class="fas fa-book mr-1"></i>78 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>4.2K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-red-600">GHS 3,380</div>
                            <a href="#" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-semibold">Enroll Now</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-orange-600 h-48 flex items-center justify-center">
                        <i class="fas fa-search text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-primary px-3 py-1 rounded-full text-sm font-semibold">Intermediate</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                <span class="text-gray-600 text-sm ml-1">(2,940)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Incident Response & Forensics</h3>
                        <p class="text-gray-600 mb-4">Respond to security incidents and conduct digital forensics.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>70 hours</span>
                            <span><i class="fas fa-book mr-1"></i>85 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>5.6K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-red-600">GHS 3,140</div>
                            <a href="#" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-semibold">Enroll Now</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-indigo-600 h-48 flex items-center justify-center">
                        <i class="fas fa-certificate text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">Advanced</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(1,680)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">CISSP Certification Prep</h3>
                        <p class="text-gray-600 mb-4">Prepare for the CISSP certification exam.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>85 hours</span>
                            <span><i class="fas fa-book mr-1"></i>105 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>3.4K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-red-600">GHS 4,600</div>
                            <a href="#" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-semibold">Enroll Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="<?= url('/courses') ?>" class="inline-flex items-center text-red-600 hover:text-red-700 font-semibold">
                    View All Courses <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Career Outcomes -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Career Outcomes</h2>
                        <p class="text-xl text-gray-600 mb-8">
                            Cybersecurity professionals are in extreme demand. Work at:
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Security Firms</h4>
                                    <p class="text-gray-600">Protect organizations from cyber threats</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Financial Institutions</h4>
                                    <p class="text-gray-600">Secure banking and financial systems</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Government Agencies</h4>
                                    <p class="text-gray-600">Protect national security and infrastructure</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Consulting</h4>
                                    <p class="text-gray-600">Security audits and penetration testing</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-red-50 rounded-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Average Salaries</h3>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Junior Security Analyst</span>
                                    <span class="font-bold text-red-600">$60K - $85K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-green-500 h-full rounded-full" style="width: 48%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Security Engineer</span>
                                    <span class="font-bold text-red-600">$85K - $125K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-primary/90 h-full rounded-full" style="width: 68%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Senior Security Specialist</span>
                                    <span class="font-bold text-red-600">$125K - $175K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-purple-500 h-full rounded-full" style="width: 88%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Security Architect / CISO</span>
                                    <span class="font-bold text-red-600">$175K+</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-red-500 h-full rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-600 mt-6">
                            <i class="fas fa-info-circle mr-1"></i>
                            Cybersecurity professionals are among the highest paid in tech
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-red-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Become a Cybersecurity Expert?</h2>
            <p class="text-xl text-red-100 mb-8 max-w-2xl mx-auto">
                Join thousands of students protecting systems and data from cyber threats
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?= url('/register') ?>" class="bg-white text-red-600 px-8 py-4 rounded-lg font-semibold hover:bg-red-50 transition inline-flex items-center">
                    <i class="fas fa-rocket mr-2"></i>Get Started Free
                </a>
                <a href="<?= url('/contact') ?>" class="bg-red-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-red-800 transition inline-flex items-center border-2 border-red-500">
                    <i class="fas fa-comment mr-2"></i>Talk to an Advisor
                </a>
            </div>
        </div>
    </section>


