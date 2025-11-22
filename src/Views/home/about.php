<!-- Schema.org Structured Data for SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Nebatech Software Solution Ltd",
        "alternateName": "Nebatech",
        "url": "<?= url('/') ?>",
        "logo": "<?= url('/assets/images/logo.png') ?>",
        "description": "Ghana-based, expert-led technology company delivering innovative, secure, and scalable IT solutions to businesses, institutions, NGOs, and government agencies across Africa and beyond",
        "foundingDate": "2019",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Choggu Yapalsi",
            "addressLocality": "Tamale",
            "addressRegion": "Northern Region",
            "addressCountry": "GH"
        },
        "contactPoint": [{
            "@type": "ContactPoint",
            "telephone": "+233-24-763-6080",
            "contactType": "customer service",
            "availableLanguage": ["English"]
        }, {
            "@type": "ContactPoint",
            "telephone": "+233-20-678-9600",
            "contactType": "sales",
            "availableLanguage": ["English"]
        }],
        "email": "info@nebatech.com",
        "sameAs": [
            "https://www.linkedin.com/company/nebatech",
            "https://github.com/IAmAbdulHafiz"
        ],
        "founders": [{
            "@type": "Person",
            "name": "Abdul-Hafiz Yussif",
            "jobTitle": "CEO & Founder",
            "url": "https://www.linkedin.com/in/abdul-hafiz-yussif-30215b220/"
        }],
        "numberOfEmployees": {
            "@type": "QuantitativeValue",
            "value": "4+"
        },
        "areaServed": {
            "@type": "Place",
            "name": "Africa"
        }
    }
    </script>

    <!-- Breadcrumb -->
    <div class="bg-gray-100 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
        <div class="container mx-auto px-6 py-3">
            <nav class="flex text-sm text-gray-600 dark:text-gray-400" aria-label="Breadcrumb">
                <a href="<?= url('/') ?>" class="hover:text-primary dark:hover:text-primary/80 transition-colors">Home</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800 dark:text-gray-200 font-semibold">About Us</span>
            </nav>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-primary via-blue-900 to-indigo-900 text-white py-20 overflow-hidden">
        <!-- Digital Horizon Background -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Horizon Glow -->
            <div class="absolute bottom-0 left-0 right-0 h-96 bg-gradient-to-t from-blue-500/30 via-blue-400/10 to-transparent"></div>
            
            <!-- Geometric Light Beams -->
            <div class="absolute top-0 left-1/4 w-1 h-full bg-gradient-to-b from-blue-400/40 via-blue-400/20 to-transparent transform -skew-x-12 animate-pulse" style="animation-duration: 4s;"></div>
            <div class="absolute top-0 right-1/3 w-1 h-full bg-gradient-to-b from-indigo-400/30 via-indigo-400/15 to-transparent transform skew-x-12 animate-pulse" style="animation-duration: 5s;"></div>
            <div class="absolute top-0 left-2/3 w-1 h-full bg-gradient-to-b from-purple-400/25 via-purple-400/10 to-transparent transform -skew-x-6 animate-pulse" style="animation-duration: 3s;"></div>
            
            <!-- Glowing Orbs -->
            <div class="absolute top-20 left-10 w-96 h-96 bg-primary/90/40 rounded-full blur-3xl animate-pulse" style="animation-duration: 6s;"></div>
            <div class="absolute bottom-20 right-20 w-80 h-80 bg-indigo-500/30 rounded-full blur-3xl animate-pulse" style="animation-duration: 8s;"></div>
            <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-purple-500/20 rounded-full blur-3xl animate-pulse" style="animation-duration: 7s;"></div>
            
            <!-- Floating Tech Icons -->
            <div class="absolute top-1/4 left-[10%] opacity-20 animate-float" style="animation-duration: 6s;">
                <i class="fas fa-building text-6xl text-white/80"></i>
            </div>
            <div class="absolute top-1/3 right-[15%] opacity-20 animate-float" style="animation-duration: 7s; animation-delay: 1s;">
                <i class="fas fa-rocket text-6xl text-indigo-300"></i>
            </div>
            <div class="absolute bottom-1/4 left-[20%] opacity-20 animate-float" style="animation-duration: 8s; animation-delay: 0.5s;">
                <i class="fas fa-award text-6xl text-purple-300"></i>
            </div>
            <div class="absolute top-1/2 right-[25%] opacity-20 animate-float" style="animation-duration: 6.5s; animation-delay: 1.5s;">
                <i class="fas fa-handshake text-6xl text-white/80"></i>
            </div>
            <div class="absolute bottom-1/3 right-[10%] opacity-20 animate-float" style="animation-duration: 7.5s; animation-delay: 0.8s;">
                <i class="fas fa-globe-americas text-6xl text-indigo-300"></i>
            </div>
        </div>
        
        <!-- Content -->
        <div class="container mx-auto px-6 text-center relative z-10">
            <div class="inline-block bg-primary/80/60 backdrop-blur-sm px-6 py-2 rounded-full text-white text-sm font-semibold mb-6 border border-white/30/30">
                <i class="fas fa-building mr-2"></i>Our Story
            </div>
            <h1 class="text-5xl md:text-6xl font-bold mb-6">About Nebatech Software Solution Ltd</h1>
            <p class="text-xl max-w-4xl mx-auto leading-relaxed mb-12 text-white/90">
                Ghana-based, expert-led technology company delivering innovative, secure, and scalable IT solutions to businesses, institutions, NGOs, and government agencies across Africa and beyond
            </p>
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/30/20 hover:bg-white/15 transition-all">
                    <div class="text-3xl font-bold">7+</div>
                    <div class="text-white/70 text-sm">Years Experience</div>
                </div>
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-indigo-400/20 hover:bg-white/15 transition-all">
                    <div class="text-3xl font-bold">15+</div>
                    <div class="text-white/70 text-sm">Major Projects</div>
                </div>
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-purple-400/20 hover:bg-white/15 transition-all">
                    <div class="text-3xl font-bold">85%</div>
                    <div class="text-white/70 text-sm">Production Rate</div>
                </div>
                <div class="backdrop-blur-sm bg-white/10 rounded-lg p-4 border border-white/30/20 hover:bg-white/15 transition-all">
                    <div class="text-3xl font-bold">100%</div>
                    <div class="text-white/70 text-sm">Client Satisfaction</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Executive Summary -->
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-6">
            <div class="max-w-5xl mx-auto">
                <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-8 text-center">Executive Summary</h2>
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 p-8 md:p-12 rounded-2xl shadow-xl">
                    <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed mb-6">
                        <span class="font-bold text-primary dark:text-primary/80">Nebatech Software Solutions Ltd</span> is a Ghana-based, expert-led technology company delivering innovative, secure, and scalable IT solutions to businesses, institutions, NGOs, and government agencies across Africa and beyond. Founded on a strong culture of technical excellence and client-focused innovation, the company provides cutting-edge services in software and application development, UI/UX design, no-code and custom web/mobile applications, e-commerce platforms, SaaS solutions, blockchain integrations, and AI-driven business systems.
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed mb-6">
                        Our work spans diverse sectors, including <span class="font-semibold text-primary dark:text-primary/80">education, commerce, healthcare, and enterprise resource management</span>, consistently delivering measurable results that improve operational efficiency, enhance customer engagement, and create long-term value.
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed">
                        With a leadership team comprising seasoned engineers, designers, and consultants—each with extensive track records in delivering high-impact projects—Nebatech has successfully executed <span class="font-bold text-primary dark:text-primary/80">more than 15 enterprise-grade solutions</span> and numerous bespoke digital platforms, <span class="font-bold text-green-600 dark:text-green-400">over 85% of which remain in active production</span>. Our core strength lies in our multidisciplinary expertise: full-stack software engineering, secure backend systems for fintech and blockchain, user-centric product design, and strategic consulting in AI integration and digital transformation.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-16 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-800/20 p-8 rounded-2xl border-2 border-white/20 dark:border-primary/80 shadow-lg hover:shadow-2xl transition-all">
                    <div class="flex items-center mb-4">
                        <svg class="w-12 h-12 text-primary dark:text-primary/80 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200">Our Vision</h2>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed">
                        To become the leading hub of innovation and technical excellence in Africa and beyond.
                    </p>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-pink-100 dark:from-purple-900/20 dark:to-pink-800/20 p-8 rounded-2xl border-2 border-purple-200 dark:border-purple-800 shadow-lg hover:shadow-2xl transition-all">
                    <div class="flex items-center mb-4">
                        <svg class="w-12 h-12 text-purple-600 dark:text-purple-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200">Our Mission</h2>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed">
                        To provide innovative and transformative technological solutions and training to individuals and organizations that streamline operations, foster growth, and drive success.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Introduction - The Digital Revolution -->
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-6">
            <div class="max-w-5xl mx-auto">
                <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-8 text-center">Navigating the Digital Revolution</h2>
                <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
                    <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed mb-6">
                        The era of massive digital revolution of the 21st century revolves mainly around the information technology revolution. Experts allude that the advancement in information technology has proven capable of controlling the culture of every professional sector. Individuals, as well as firms, have come to succumb to the new world order where communication and information technologies redefine the practices and way of doing things in every sector.
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed mb-6">
                        More critical is the advent of <span class="font-bold text-purple-600 dark:text-purple-400">Artificial Intelligence (AI)</span> with its high-level pros and its advanced disruptive cons. This new order challenges beyond imagination, where the machine now learns human behaviour/functions and performance in fascinating ways, capable of undermining the parent human agent. Hence, machine learning algorithms displayed through crafty AI prove more challenging to understand, use, control, and subdue by human factors and agents.
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed mb-6">
                        <span class="font-bold text-primary dark:text-primary/80">Nebatech Software Solutions</span>, a Ghanaian-based expert-led IT and Software solution firm, has proven more than capable of supporting organisations in every sector of their practice. Our track record proves our mastery of the computer, IT, AI, and general software ecosystem through our delivery in the past decade of practice.
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed">
                        Understanding the challenges faced by organisations and entities, we focus critically on solutions that provide assurances of the highest regard. Specifically, in software and application development and maintenance, computer literacy development and enhancement, repairs, AI chatbot and application agency, agile capacity building and enhancement, coding as well as practical business and organisational performance tracking services.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Strategy & Approach -->
    <section class="py-16 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-4 text-center">Our Strategy & Approach</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 text-center mb-12 max-w-3xl mx-auto">
                A highly strategic yet client-centered approach that shapes our products and services
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Strategy 1 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all border-l-4 border-primary">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-primary/90/30 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-primary dark:text-primary/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">Client-Focused Understanding</h3>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        We focus on clearly understanding our clients' concerns and digital solution needs. We help clients properly conceptualize their digital needs and propose the most reliable and best-fit solutions that exceed initial propositions.
                    </p>
                </div>

                <!-- Strategy 2 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all border-l-4 border-green-600">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">Enhanced Quality</h3>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        We take clients along the process of designing and developing products that best fit their needs. This approach empowers clients to effectively manage their software, applications, and websites, ensuring sustainable solutions.
                    </p>
                </div>

                <!-- Strategy 3 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all border-l-4 border-purple-600">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">Strategic Partnership</h3>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        We build relations beyond business into the future, developing partnerships that transcend temporary gains. We support and help nurture dreams that hold much value for future generations.
                    </p>
                </div>

                <!-- Strategy 4 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all border-l-4 border-orange-600">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">Heightened Innovativeness</h3>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        Our solutions are hinged on open-mindedness, thoughtful foresight, and future-driven decisions. We aspire to move beyond ordinary tech solutions, leveraging vast experience to craft insightful, innovative solutions.
                    </p>
                </div>

                <!-- Strategy 5 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all border-l-4 border-indigo-600 md:col-span-2 lg:col-span-1">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">Value-Driven Solutions</h3>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        Our approach to client demands is built on critical considerations of value for money and return on investment (ROI). We enhance client value through the philosophy of ensuring higher returns.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Services -->
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-4 text-center">Our Comprehensive Services</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 text-center mb-12 max-w-4xl mx-auto">
                We provide a comprehensive range of IT solutions tailored to meet diverse needs across industries
            </p>
            <div class="max-w-6xl mx-auto bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-800 dark:to-gray-700 p-8 md:p-12 rounded-2xl shadow-xl">
                <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed mb-6">
                    Our expertise spans <span class="font-semibold text-primary dark:text-primary/80">UI/UX design, no-code and custom software development, web and mobile application design, e-commerce solutions, school management platforms, and digital product prototyping</span>. We also offer services in front-end and back-end development, systems integration, cloud-based deployments, IT consultancy, and managed services.
                </p>
                <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed">
                    Leveraging cutting-edge tools and technologies, including Figma, Adobe XD, Webflow, HTML, CSS, JavaScript, and various backend frameworks, we ensure the delivery of <span class="font-semibold text-green-700 dark:text-green-400">secure, scalable, and high-performance solutions</span>. Whether for small businesses, large enterprises, or institutions, our approach combines creativity, technical precision, and strategic insight to provide innovative, user-focused, and commercially viable IT services.
                </p>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-4 text-center">Our Core Leadership Team</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 text-center mb-12 max-w-3xl mx-auto">
                Seasoned engineers, designers, and consultants with extensive track records in delivering high-impact projects
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto">
                <!-- CEO - Abdul-Hafiz Yussif -->
                <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="h-56 bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center relative">
                        <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-white text-xs font-semibold">
                            CEO & Founder
                        </div>
                        <div class="w-32 h-32 bg-white text-primary rounded-full flex items-center justify-center text-5xl font-bold shadow-2xl">
                            AH
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-1 text-gray-800 dark:text-gray-200">Abdul-Hafiz Yussif</h3>
                        <p class="text-primary dark:text-primary/80 font-semibold mb-3">Founder & Chief Executive Officer</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 leading-relaxed">
                            Full-stack software engineer and SaaS architect with 7+ years of experience. Led 15+ enterprise projects with 85% in active production. Founder of Nebatech CodeCamp, mentoring 200+ aspiring developers.
                        </p>
                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 space-x-3 mb-3">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                </svg>
                                PHP, Laravel, React, Node.js
                            </span>
                        </div>
                        <div class="flex justify-center space-x-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                            <a href="https://www.linkedin.com/in/abdul-hafiz-yussif-30215b220/" target="_blank" class="text-gray-400 hover:text-primary dark:hover:text-primary/80 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                            <a href="https://github.com/IAmAbdulHafiz" target="_blank" class="text-gray-400 hover:text-primary dark:hover:text-primary/80 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- UI/UX Designer - Mukhtar Mohammed -->
                <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="h-56 bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center relative">
                        <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-white text-xs font-semibold">
                            Lead Designer
                        </div>
                        <div class="w-32 h-32 bg-white text-purple-600 rounded-full flex items-center justify-center text-5xl font-bold shadow-2xl">
                            MM
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-1 text-gray-800 dark:text-gray-200">Mukhtar Mohammed</h3>
                        <p class="text-purple-600 dark:text-purple-400 font-semibold mb-3">UI/UX Designer & No-Code Developer</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 leading-relaxed">
                            Accomplished designer with extensive experience leading digital product design for clients in Ghana, Canada, and beyond. First-class honours graduate specialized in user research and design systems.
                        </p>
                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 space-x-3 mb-3">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                                Figma, Adobe XD, Webflow
                            </span>
                        </div>
                        <div class="flex justify-center space-x-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                            <a href="https://www.linkedin.com/in/mukhtar-mohammed" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 transition-colors" aria-label="Mukhtar Mohammed LinkedIn">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Backend Engineer - Rafique Adam Cudjoe -->
                <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="h-56 bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center relative">
                        <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-white text-xs font-semibold">
                            Backend Specialist
                        </div>
                        <div class="w-32 h-32 bg-white text-green-600 rounded-full flex items-center justify-center text-5xl font-bold shadow-2xl">
                            RA
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-1 text-gray-800 dark:text-gray-200">Rafique Adam Cudjoe</h3>
                        <p class="text-green-600 dark:text-green-400 font-semibold mb-3">Backend Engineer | Fintech & Blockchain Specialist</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 leading-relaxed">
                            Skilled backend engineer delivering secure systems for fintech, blockchain, and enterprise applications. Boosted user engagement by 30% and reduced load times by 40% across international projects.
                        </p>
                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 space-x-3 mb-3">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z"/>
                                    <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z"/>
                                    <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z"/>
                                </svg>
                                Node.js, NestJS, PostgreSQL
                            </span>
                        </div>
                        <div class="flex justify-center space-x-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                            <a href="https://www.linkedin.com/in/rafique-adam-cudjoe" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors" aria-label="Rafique Adam Cudjoe LinkedIn">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Consulting Partner - Ismail Mohammed -->
                <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="h-56 bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center relative">
                        <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-white text-xs font-semibold">
                            Strategic Advisor
                        </div>
                        <div class="w-32 h-32 bg-white text-orange-600 rounded-full flex items-center justify-center text-5xl font-bold shadow-2xl">
                            IM
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-1 text-gray-800 dark:text-gray-200">Ismail Mohammed</h3>
                        <p class="text-orange-600 dark:text-orange-400 font-semibold mb-3">Consulting Partner | PhD/c, MPhil</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 leading-relaxed">
                            Brilliant consultant with extensive experience in development work, business management, IT and AI integration. Led donor-funded projects and provides strategic consulting on governance and digital transformation.
                        </p>
                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 space-x-3 mb-3">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                </svg>
                                Policy, AI Integration, Research
                            </span>
                        </div>
                        <div class="flex justify-center space-x-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                            <a href="https://www.linkedin.com/in/ismail-mohammed" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-orange-600 dark:hover:text-orange-400 transition-colors" aria-label="Ismail Mohammed LinkedIn">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Company Timeline -->
    <section class="py-16 bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-4 text-center">Our Journey</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 text-center mb-12 max-w-2xl mx-auto">
                Key milestones in our mission to transform Africa's technology landscape
            </p>
            <div class="max-w-4xl mx-auto">
                <div class="relative">
                    <!-- Timeline Line -->
                    <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-gradient-to-b from-blue-500 via-purple-500 to-orange-500 hidden md:block"></div>
                    
                    <!-- 2019 - Foundation -->
                    <div class="mb-8 flex flex-col md:flex-row items-center justify-between w-full">
                        <div class="order-1 md:w-5/12"></div>
                        <div class="z-20 flex items-center order-1 bg-primary shadow-xl w-12 h-12 rounded-full">
                            <h3 class="mx-auto font-bold text-lg text-white">1</h3>
                        </div>
                        <div class="order-1 bg-white dark:bg-gray-800 rounded-lg shadow-xl md:w-5/12 px-6 py-4">
                            <h3 class="mb-2 font-bold text-primary dark:text-primary/80 text-xl">2019 - Foundation</h3>
                            <p class="text-sm leading-snug tracking-wide text-gray-700 dark:text-gray-300">Nebatech Software Solution Ltd was established in Tamale, Ghana, with a vision to deliver innovative IT solutions across Africa.</p>
                        </div>
                    </div>

                    <!-- 2020-2021 - Early Growth -->
                    <div class="mb-8 flex flex-col md:flex-row-reverse items-center justify-between w-full">
                        <div class="order-1 md:w-5/12"></div>
                        <div class="z-20 flex items-center order-1 bg-purple-600 shadow-xl w-12 h-12 rounded-full">
                            <h3 class="mx-auto font-bold text-lg text-white">2</h3>
                        </div>
                        <div class="order-1 bg-white dark:bg-gray-800 rounded-lg shadow-xl md:w-5/12 px-6 py-4">
                            <h3 class="mb-2 font-bold text-purple-600 dark:text-purple-400 text-xl">2020-2021 - Early Growth</h3>
                            <p class="text-sm leading-snug tracking-wide text-gray-700 dark:text-gray-300">Delivered first 5 enterprise projects across education and healthcare sectors. Established technical excellence and client trust.</p>
                        </div>
                    </div>

                    <!-- 2022 - Expansion -->
                    <div class="mb-8 flex flex-col md:flex-row items-center justify-between w-full">
                        <div class="order-1 md:w-5/12"></div>
                        <div class="z-20 flex items-center order-1 bg-green-600 shadow-xl w-12 h-12 rounded-full">
                            <h3 class="mx-auto font-bold text-lg text-white">3</h3>
                        </div>
                        <div class="order-1 bg-white dark:bg-gray-800 rounded-lg shadow-xl md:w-5/12 px-6 py-4">
                            <h3 class="mb-2 font-bold text-green-600 dark:text-green-400 text-xl">2022 - Expansion</h3>
                            <p class="text-sm leading-snug tracking-wide text-gray-700 dark:text-gray-300">Launched Nebatech CodeCamp training program. Expanded services to include AI integration and blockchain solutions.</p>
                        </div>
                    </div>

                    <!-- 2023-2024 - Scale & Impact -->
                    <div class="mb-8 flex flex-col md:flex-row-reverse items-center justify-between w-full">
                        <div class="order-1 md:w-5/12"></div>
                        <div class="z-20 flex items-center order-1 bg-orange-600 shadow-xl w-12 h-12 rounded-full">
                            <h3 class="mx-auto font-bold text-lg text-white">4</h3>
                        </div>
                        <div class="order-1 bg-white dark:bg-gray-800 rounded-lg shadow-xl md:w-5/12 px-6 py-4">
                            <h3 class="mb-2 font-bold text-orange-600 dark:text-orange-400 text-xl">2023-2024 - Scale & Impact</h3>
                            <p class="text-sm leading-snug tracking-wide text-gray-700 dark:text-gray-300">Achieved 15+ enterprise projects with 85% in production. Trained 200+ developers. Expanded operations across West Africa.</p>
                        </div>
                    </div>

                    <!-- 2025 - Innovation Hub -->
                    <div class="mb-8 flex flex-col md:flex-row items-center justify-between w-full">
                        <div class="order-1 md:w-5/12"></div>
                        <div class="z-20 flex items-center order-1 bg-indigo-600 shadow-xl w-12 h-12 rounded-full">
                            <h3 class="mx-auto font-bold text-lg text-white">5</h3>
                        </div>
                        <div class="order-1 bg-white dark:bg-gray-800 rounded-lg shadow-xl md:w-5/12 px-6 py-4">
                            <h3 class="mb-2 font-bold text-indigo-600 dark:text-indigo-400 text-xl">2025 - Innovation Hub</h3>
                            <p class="text-sm leading-snug tracking-wide text-gray-700 dark:text-gray-300">Becoming Africa's leading hub for AI-driven solutions, advanced software engineering, and digital transformation consulting.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section with Animated Counters -->
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-4 text-center">Our Impact in Numbers</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 text-center mb-12 max-w-2xl mx-auto">
                Proven track record of delivering measurable results across Africa and beyond
            </p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <div class="text-center bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 p-6 rounded-2xl shadow-lg">
                    <div class="text-5xl font-bold text-primary dark:text-primary/80 mb-2">
                        <span class="counter" data-target="15">0</span>+
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 font-semibold">Enterprise Projects</div>
                    <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">Successfully Delivered</div>
                </div>
                <div class="text-center bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 p-6 rounded-2xl shadow-lg">
                    <div class="text-5xl font-bold text-green-600 dark:text-green-400 mb-2">
                        <span class="counter" data-target="85">0</span>%
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 font-semibold">In Production</div>
                    <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">Active & Operational</div>
                </div>
                <div class="text-center bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 p-6 rounded-2xl shadow-lg">
                    <div class="text-5xl font-bold text-purple-600 dark:text-purple-400 mb-2">
                        <span class="counter" data-target="200">0</span>+
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 font-semibold">Developers Trained</div>
                    <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">Through CodeCamp</div>
                </div>
                <div class="text-center bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 p-6 rounded-2xl shadow-lg">
                    <div class="text-5xl font-bold text-orange-600 dark:text-orange-400 mb-2">
                        <span class="counter" data-target="7">0</span>+
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 font-semibold">Years Experience</div>
                    <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">In Tech Solutions</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Technology Stack -->
    <section class="py-16 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-4 text-center">Our Technology Stack</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 text-center mb-12 max-w-2xl mx-auto">
                Powered by industry-leading technologies and frameworks
            </p>
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8">
                    <!-- PHP -->
                    <div class="flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-900 rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <svg class="w-16 h-16 mb-3" viewBox="0 0 256 134" xmlns="http://www.w3.org/2000/svg">
                            <g fill="#6181B6"><path d="M61.096 105.82H78.3l3.273-16.423c.67-3.376.28-5.86-1.103-7.424-1.408-1.564-3.987-2.358-7.687-2.358H64.67l-3.573 26.204zm21.828-46.967c4.256 0 7.562.936 9.868 2.793 2.28 1.856 3.232 4.813 2.843 8.833l-7.26 36.58H67.38l2.048-10.325h-9.304c-6.495 0-11.29-1.57-14.3-4.66-3.037-3.117-4.005-7.783-2.885-13.916.613-3.348 1.768-6.387 3.465-9.093 1.67-2.705 3.826-5.011 6.416-6.88 2.59-1.87 5.577-3.286 8.91-4.227 3.333-.94 6.935-1.404 10.73-1.404h7.464z"/><path d="M99.784 105.82h20.992l10.62-53.56H110.4l-10.615 53.56z"/></g>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">PHP</span>
                    </div>
                    <!-- Laravel -->
                    <div class="flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-900 rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <svg class="w-16 h-16 mb-3" viewBox="0 0 256 264" xmlns="http://www.w3.org/2000/svg"><path d="M255.856 59.62c.095.351.144.713.144 1.077v56.568c0 1.478-.79 2.843-2.073 3.578L206.45 148.18v54.18c0 1.477-.79 2.842-2.073 3.577l-100.777 58.145c-.209.12-.428.211-.655.284-.047.015-.095.025-.142.04a3.7 3.7 0 0 1-.76.144c-.124.02-.25.033-.376.04a3.7 3.7 0 0 1-.762-.069c-.126-.01-.252-.035-.377-.055-.117-.02-.234-.035-.35-.06-.13-.029-.259-.066-.387-.11-.111-.037-.222-.08-.332-.124-.124-.05-.246-.104-.368-.166a3.6 3.6 0 0 1-.344-.182c-.102-.06-.203-.12-.303-.187-.11-.073-.216-.153-.322-.235-.096-.072-.19-.146-.283-.225-.082-.07-.163-.143-.242-.217l-.203-.199a3.5 3.5 0 0 1-.225-.25c-.068-.08-.133-.162-.197-.245-.069-.092-.134-.186-.198-.281a3.5 3.5 0 0 1-.163-.283c-.053-.1-.104-.201-.152-.305a3.5 3.5 0 0 1-.12-.299c-.04-.104-.076-.21-.109-.316a3.6 3.6 0 0 1-.082-.308c-.027-.107-.051-.216-.071-.325a3.6 3.6 0 0 1-.05-.316c-.016-.11-.028-.222-.037-.334a3.7 3.7 0 0 1-.018-.332V109.705L.073 63.253C.029 63.009 0 62.76 0 62.508v-56.57c0-1.478.79-2.842 2.073-3.577L102.95.217c.284-.164.584-.298.895-.398.068-.022.138-.042.207-.06.197-.052.396-.093.598-.124.078-.012.156-.028.235-.035a4.5 4.5 0 0 1 .612-.048c.204.007.408.024.612.048.079.007.157.023.235.035.202.03.401.072.598.124.069.018.139.038.207.06.311.1.611.234.895.398L255.927 58.95c.284.165.537.364.756.594.03.032.058.067.087.1.09.105.176.214.258.327.024.033.05.064.073.098.082.118.158.24.228.366.014.026.03.05.043.077.08.148.15.3.212.457zM238.265 97.788l-46.227-26.697-22.759 13.143 46.227 26.697 22.759-13.143zm-9.48 86.45V128.21l-22.363 12.902-23.873 13.78v56.027l46.236-26.682zM215.74 80.463l-22.759 13.143 45.825 26.465 22.759-13.143L215.74 80.463zm-20.7 11.951L148.82 65.717 102.595 92.41l46.227 26.697 46.219-26.694zM8.933 111.786l38.796 22.391v-45.125l-38.796-22.39v45.124zm0-56.57v10.086L55.16 92v-10.086L8.933 55.216zm.103 95.293v10.084l38.693 22.337v-10.085l-38.693-22.336zM94.773 53.91L48.547 80.603l46.227 26.697L140.999 80.6 94.773 53.91zm0 78.184l-22.363 12.902v54.18L118.637 172.5v-54.18L94.773 132.094zm23.87 13.779l23.87-13.78v-54.18l-23.87 13.78v54.18zm23.87-68.96l46.227-26.697-46.227-26.697-46.227 26.697 46.227 26.697z" fill="#FF2D20"/></svg>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Laravel</span>
                    </div>
                    <!-- React -->
                    <div class="flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-900 rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <svg class="w-16 h-16 mb-3" viewBox="0 0 256 228" xmlns="http://www.w3.org/2000/svg"><path d="M210.483 73.824a171.5 171.5 0 0 0-8.24-2.597c.465-1.9.893-3.777 1.273-5.621 6.238-30.281 2.16-54.676-11.769-62.708-13.355-7.7-35.196.329-57.254 19.526a171.2 171.2 0 0 0-6.375 5.848 155.9 155.9 0 0 0-4.241-3.917C100.759 3.829 77.587-4.822 63.673 3.233 50.33 10.957 46.379 33.89 51.995 62.588a170.9 170.9 0 0 0 1.892 8.48c-3.28.932-6.445 1.924-9.474 2.98C17.309 83.498 0 98.307 0 113.668c0 15.865 18.582 31.778 46.812 41.427a145.5 145.5 0 0 0 6.921 2.165 167.5 167.5 0 0 0-2.01 9.138c-5.354 28.2-1.173 50.591 12.134 58.266 13.744 7.926 36.812-.22 59.273-19.855a145.6 145.6 0 0 0 5.342-4.923 168.1 168.1 0 0 0 6.92 6.314c21.758 18.722 43.246 26.282 56.54 18.586 13.731-7.949 18.194-32.003 12.4-61.268a145.2 145.2 0 0 0-1.535-6.842c1.62-.48 3.21-.974 4.76-1.488 29.348-9.723 48.443-25.443 48.443-41.52 0-15.417-17.868-30.326-45.517-39.844zm-6.365 70.984c-1.4.463-2.836.91-4.3 1.345-3.24-10.257-7.612-21.163-12.963-32.432 5.106-11 9.31-21.767 12.459-31.957 2.619.758 5.16 1.557 7.61 2.4 23.69 8.156 38.14 20.213 38.14 29.504 0 9.896-15.606 22.743-40.946 31.14zm-10.514 20.834c2.562 12.94 2.927 24.64 1.23 33.787-1.524 8.219-4.59 13.698-8.382 15.893-8.067 4.67-25.32-1.4-43.927-17.412a156.7 156.7 0 0 1-6.437-5.87c7.214-7.889 14.423-17.06 21.459-27.246 12.376-1.098 24.068-2.894 34.671-5.345.522 2.107.986 4.173 1.386 6.193zM87.276 214.515c-7.882 2.783-14.16 2.863-17.955.675-8.075-4.657-11.432-22.636-6.853-46.752a156.9 156.9 0 0 1 1.869-8.499c10.486 2.32 22.093 3.988 34.498 4.994 7.084 9.967 14.501 19.128 21.976 27.15a134.7 134.7 0 0 1-4.877 4.492c-9.933 8.682-19.886 14.842-28.658 17.94zM50.35 144.747c-12.483-4.267-22.792-9.812-29.858-15.863-6.35-5.437-9.555-10.836-9.555-15.216 0-9.322 13.897-21.212 37.076-29.293 2.813-.98 5.757-1.905 8.812-2.773 3.204 10.42 7.406 21.315 12.477 32.332-5.137 11.18-9.399 22.249-12.634 32.792a134.7 134.7 0 0 1-6.318-1.979zm12.378-84.26c-4.811-24.587-1.616-43.134 6.425-47.789 8.564-4.958 27.502 2.111 47.463 19.835a144.3 144.3 0 0 1 3.841 3.545c-7.438 7.987-14.787 17.08-21.808 26.988-12.04 1.116-23.565 2.908-34.161 5.309a160.3 160.3 0 0 1-1.76-7.887zm110.427 27.268a347.8 347.8 0 0 0-7.785-12.803c8.168 1.033 15.994 2.404 23.343 4.08-2.206 7.072-4.956 14.465-8.193 22.045a381.2 381.2 0 0 0-7.365-13.322zm-45.032-43.861c5.044 5.465 10.096 11.566 15.065 18.186a322.0 322.0 0 0 0-30.257-.006c4.974-6.559 10.069-12.652 15.192-18.18zM82.802 87.83a323.2 323.2 0 0 0-7.227 13.238c-3.184-7.553-5.909-14.98-8.134-22.152 7.304-1.634 15.093-2.97 23.209-3.984a321.5 321.5 0 0 0-7.848 12.897zm8.081 65.352c-8.385-.936-16.291-2.203-23.593-3.793 2.26-7.3 5.045-14.885 8.298-22.6a321.2 321.2 0 0 0 7.257 13.246c2.594 4.48 5.28 8.868 8.038 13.147zm37.542 31.03c-5.184-5.592-10.354-11.779-15.403-18.433 4.902.192 9.899.29 14.978.29 5.218 0 10.376-.117 15.453-.343-4.985 6.774-10.018 12.97-15.028 18.486zm52.198-57.817c3.422 7.8 6.306 15.345 8.596 22.52-7.422 1.694-15.436 3.058-23.88 4.071a382.4 382.4 0 0 0 7.859-13.026 347.4 347.4 0 0 0 7.425-13.565zm-16.898 8.101a358.6 358.6 0 0 1-12.281 19.815 329.4 329.4 0 0 1-23.444.823c-7.967 0-15.716-.248-23.178-.732a310.2 310.2 0 0 1-12.513-19.846h.001a307.4 307.4 0 0 1-10.923-20.627 310.5 310.5 0 0 1 10.89-20.637l-.001.001a307.3 307.3 0 0 1 12.413-19.761c7.613-.576 15.42-.876 23.31-.876H128c7.926 0 15.743.303 23.354.883a329.4 329.4 0 0 1 12.335 19.695 358.5 358.5 0 0 1 11.036 20.54 329.5 329.5 0 0 1-11 20.722zm22.56-122.124c8.572 4.944 11.906 24.881 6.52 51.026-.344 1.668-.73 3.367-1.15 5.09-10.622-2.452-22.155-4.275-34.23-5.408-7.034-10.017-14.323-19.124-21.64-27.008a160.8 160.8 0 0 1 5.888-5.4c18.9-16.447 36.564-22.941 44.612-18.3zM128 90.808c12.625 0 22.86 10.235 22.86 22.86s-10.235 22.86-22.86 22.86-22.86-10.235-22.86-22.86 10.235-22.86 22.86-22.86z" fill="#00D8FF"/></svg>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">React</span>
                    </div>
                    <!-- Node.js -->
                    <div class="flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-900 rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <svg class="w-16 h-16 mb-3" viewBox="0 0 256 289" xmlns="http://www.w3.org/2000/svg"><path d="M128 288.464c-3.975 0-7.685-1.06-11.13-2.915l-35.247-20.936c-5.3-2.915-2.65-3.975-1.06-4.505 7.155-2.385 8.48-2.915 15.9-7.156.796-.53 1.856-.265 2.65.265l27.032 16.166c1.06.53 2.385.53 3.18 0l105.74-61.217c1.06-.53 1.59-1.59 1.59-2.915V83.08c0-1.325-.53-2.385-1.59-2.915l-105.74-60.953c-1.06-.53-2.385-.53-3.18 0L20.405 80.166c-1.06.53-1.59 1.855-1.59 2.915v122.17c0 1.06.53 2.385 1.59 2.915l28.887 16.695c15.636 7.95 25.44-1.325 25.44-10.6V93.68c0-1.59 1.326-3.18 3.181-3.18h13.516c1.59 0 3.18 1.325 3.18 3.18v120.58c0 20.936-11.396 33.126-31.272 33.126-6.095 0-10.865 0-24.38-6.625l-27.827-15.9C4.24 220.885 0 213.465 0 205.515V83.346C0 75.396 4.24 67.976 11.13 64L116.87 2.783c6.625-3.71 15.635-3.71 22.26 0L244.87 64C251.76 67.976 256 75.132 256 83.346v122.17c0 7.95-4.24 15.37-11.13 19.345L139.13 286.08c-3.445 1.59-7.42 2.385-11.13 2.385zm32.596-84.009c-46.377 0-55.917-21.2-55.917-39.221 0-1.59 1.325-3.18 3.18-3.18h13.78c1.59 0 2.916 1.06 2.916 2.65 2.12 14.045 8.215 20.936 36.306 20.936 22.26 0 31.802-5.035 31.802-16.96 0-6.891-2.65-11.926-37.367-15.372-28.887-2.915-46.907-9.275-46.907-32.33 0-21.467 18.02-34.186 48.232-34.186 33.921 0 50.617 11.66 52.737 37.101 0 .795-.265 1.59-.795 2.385-.53.53-1.325 1.06-2.12 1.06h-13.78c-1.326 0-2.65-1.06-2.916-2.385-3.18-14.575-11.395-19.345-33.126-19.345-24.38 0-27.296 8.48-27.296 14.84 0 7.686 3.445 10.07 36.306 14.31 32.597 4.24 47.967 10.336 47.967 33.127-.265 23.321-19.345 36.571-53.002 36.571z" fill="#539E43"/></svg>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Node.js</span>
                    </div>
                    <!-- PostgreSQL -->
                    <div class="flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-900 rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <svg class="w-16 h-16 mb-3" viewBox="0 0 256 264" xmlns="http://www.w3.org/2000/svg"><path d="M255.008 158.086c-1.535-4.649-5.556-7.887-10.756-8.664-2.452-.366-5.26-.21-8.583.475-5.792 1.195-10.089 1.65-13.225 1.738 11.837-19.985 21.462-42.775 27.003-64.228 8.96-34.689 4.172-50.492-1.423-57.64C233.217 10.847 211.614.683 185.552.372c-13.903-.17-26.108 2.575-32.475 4.549-5.928-1.046-12.302-1.63-18.99-1.738-12.537-.2-23.614 2.533-33.079 8.15-5.24-1.772-13.65-4.27-23.362-5.864-22.842-3.75-41.252-.828-54.718 8.685C6.622 25.672-.937 45.684.461 73.634c.444 8.874 5.408 35.874 13.224 61.48 4.492 14.718 9.282 26.94 14.237 36.33 7.027 13.315 14.546 21.156 22.987 23.972 4.731 1.576 13.327 2.68 22.368-4.85 1.146 1.388 2.675 2.767 4.704 4.048 2.577 1.625 5.728 2.953 8.875 3.74 11.341 2.835 21.964 2.126 31.027-1.848.056 1.612.099 3.152.135 4.482.06 2.157.12 4.272.199 6.25.537 13.374 1.447 23.773 4.143 31.049.148.4.347 1.01.557 1.657 1.345 4.118 3.594 11.012 9.316 16.411 5.925 5.593 13.092 7.308 19.656 7.308 3.292 0 6.433-.432 9.188-1.022 9.82-2.105 20.973-5.311 29.041-16.799 7.628-10.86 11.336-27.217 12.007-52.99.087-.729.167-1.425.244-2.088l.16-1.362 1.797.158.463.031c10.002.456 22.232-1.665 29.743-5.154 5.935-2.754 24.954-12.795 20.476-26.351"/><path d="M237.906 160.722c-29.74 6.135-31.785-3.934-31.785-3.934 31.4-46.593 44.527-105.736 33.2-120.211-30.904-39.485-84.399-20.811-85.292-20.327l-.287.052c-5.876-1.22-12.451-1.946-19.842-2.067-13.456-.22-23.664 3.528-31.41 9.402 0 0-95.43-39.314-90.991 49.444.944 18.882 27.064 142.873 58.218 105.422 11.387-13.695 22.39-25.274 22.39-25.274 5.464 3.63 12.006 5.482 18.864 4.817l.533-.452c-.166 1.7-.09 3.363.213 5.332-8.026 8.967-5.667 10.541-21.711 13.844-16.235 3.346-6.698 9.302-.471 10.86 7.549 1.887 25.013 4.561 36.813-11.958l-.47 1.885c3.144 2.519 2.646 16.668 3.406 26.888.759 10.22.243 19.246 1.513 27.608 1.271 8.362 2.72 19.82 15.731 15.756 10.874-3.393 19.72-9.819 23.023-26.77 2.26-11.582 1.031-19.337 3.273-35.527.875-6.338 1.32-11.611 1.32-11.611l.956 10.96c1.666 19.244 4.77 33.122 10.52 42.845 4.27 7.214 9.376 14.14 17.283 14.14 5.153 0 11.954-2.221 17.843-7.848 6.312-6.026 10.222-12.681 10.484-24.828.198-9.267 1.958-11.041 2.898-20.14.756-7.314 1.516-9.711 1.516-9.711 3.786 7.254 9.309 13.512 16.433 18.922 5.395 4.1 11.78 7.127 18.783 8.899 1.67.424 3.37.762 5.1 1.012 13.002 1.883 23.676-1.135 33.036-5.617 9.36-4.483 15.564-11.086 15.564-11.086 3.787 2.554 7.45 3.778 10.68 3.778 3.23 0 5.69-1.224 7.317-3.098-.684-.345-1.29-.72-1.816-1.135a27.37 27.37 0 0 1-7.317-9.578c-5.688-11.751-3.43-26.532 5.46-43.45 8.89-16.917 24.454-31.835 47.12-44.753 0 0-22.682-3.778-41.59 4.483-18.908 8.261-36.717 20.96-52.281 38.009-2.847 3.122-5.551 6.369-8.114 9.74-1.91 2.513-3.823 5.024-5.736 7.536l-3.47 5.085c-18.907 27.766-43.36 59.85-71.267 91.933-27.908 32.084-60.767 67.667-98.582 108.073 0 0-16.25 18.908-43.36 51.166-27.11 32.257-50.971 57.51-71.267 75.418-20.296 17.907-37.204 25.168-51.166 21.69-13.962-3.478-20.297-14.063-17.908-26.532 2.389-12.469 13.962-27.908 34.258-46.815 20.296-18.907 48.204-41.768 83.962-68.878 0 0 16.25-12.47 44.158-33.764 27.908-21.293 61.766-47.403 101.561-78.488 0 0 18.907-14.859 50.97-40.969 32.064-26.11 70.878-57.508 116.443-94.713 0 0 27.11-22.681 63.158-50.97 36.048-28.29 78.486-61.767 127.69-100.562 0 0 31.086-24.454 69.899-55.851 38.814-31.397 84.65-69.021 137.533-112.559 0 0 29.697-24.454 68.51-56.85 38.814-32.396 84.65-70.02 137.533-112.558 0 0 27.11-22.682 62.258-50.971 35.148-28.29 76.098-61.767 122.692-100.562 0 0 27.11-22.682 62.258-50.971 35.148-28.29 76.098-61.767 122.692-100.562 0 0 27.11-22.682 62.258-50.971 35.148-28.29 76.098-61.767 122.692-100.562 0 0 27.11-22.682 62.258-50.971 35.148-28.29 76.098-61.767 122.692-100.562 0 0 27.11-22.682 62.258-50.971 35.148-28.29 76.098-61.767 122.692-100.562 0 0 27.11-22.682 62.258-50.971 35.148-28.29 76.098-61.767 122.692-100.562" fill="#336791"/></svg>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">PostgreSQL</span>
                    </div>
                    <!-- Tailwind CSS -->
                    <div class="flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-900 rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <svg class="w-16 h-16 mb-3" viewBox="0 0 256 154" xmlns="http://www.w3.org/2000/svg"><path d="M128 0C93.867 0 72.533 17.067 64 51.2 76.8 34.133 91.733 27.733 108.8 32c9.737 2.434 16.697 9.499 24.401 17.318C145.751 62.057 160.275 76.8 192 76.8c34.133 0 55.467-17.067 64-51.2-12.8 17.067-27.733 23.467-44.8 19.2-9.737-2.434-16.697-9.499-24.401-17.318C174.249 14.743 159.725 0 128 0zM64 76.8C29.867 76.8 8.533 93.867 0 128c12.8-17.067 27.733-23.467 44.8-19.2 9.737 2.434 16.697 9.499 24.401 17.318C81.751 138.857 96.275 153.6 128 153.6c34.133 0 55.467-17.067 64-51.2-12.8 17.067-27.733 23.467-44.8 19.2-9.737-2.434-16.697-9.499-24.401-17.318C110.249 91.543 95.725 76.8 64 76.8z" fill="#06B6D4"/></svg>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Tailwind CSS</span>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Client Testimonials -->
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-4 text-center">What Our Clients Say</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 text-center mb-12 max-w-2xl mx-auto">
                Trusted by businesses, institutions, and organizations across Africa
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Testimonial 1 -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 p-8 rounded-2xl shadow-xl relative">
                    <div class="absolute top-6 left-6 text-6xl text-white/70 dark:text-blue-900/30 font-serif">"</div>
                    <p class="text-gray-700 dark:text-gray-300 mt-8 mb-6 relative z-10 italic leading-relaxed">
                        Nebatech transformed our entire student management system. The platform they built reduced our administrative workload by 60% and improved student engagement significantly. Their expertise in education technology is unmatched.
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white font-bold text-lg">
                            D
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800 dark:text-gray-200">Dr. Kwame Mensah</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Dean, Tamale Technical University</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-gray-800 dark:to-gray-700 p-8 rounded-2xl shadow-xl relative">
                    <div class="absolute top-6 left-6 text-6xl text-purple-200 dark:text-purple-900/30 font-serif">"</div>
                    <p class="text-gray-700 dark:text-gray-300 mt-8 mb-6 relative z-10 italic leading-relaxed">
                        The e-commerce solution Nebatech delivered exceeded our expectations. Sales increased by 45% in the first quarter, and the system handles our inventory flawlessly. Outstanding technical support and innovative approach.
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            A
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800 dark:text-gray-200">Amina Suleiman</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">CEO, Northern Trade Hub</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-gradient-to-br from-green-50 to-teal-50 dark:from-gray-800 dark:to-gray-700 p-8 rounded-2xl shadow-xl relative">
                    <div class="absolute top-6 left-6 text-6xl text-green-200 dark:text-green-900/30 font-serif">"</div>
                    <p class="text-gray-700 dark:text-gray-300 mt-8 mb-6 relative z-10 italic leading-relaxed">
                        Professional, reliable, and incredibly skilled. Nebatech built our healthcare management system with precision and care. The platform has improved patient care coordination and data security remarkably.
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            E
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800 dark:text-gray-200">Dr. Esther Boateng</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Medical Director, Savannah Health</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="py-16 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-4 text-center">Our Core Values</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 text-center mb-12 max-w-2xl mx-auto">
                The principles that guide everything we do
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <!-- Excellence -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg transform hover:scale-110 transition-all">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-200">Excellence</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Delivering the highest quality solutions with technical mastery and attention to detail in every project</p>
                </div>

                <!-- Innovation -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg transform hover:scale-110 transition-all">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-200">Innovation</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Embracing cutting-edge technologies and creative approaches to solve complex business challenges</p>
                </div>

                <!-- Integrity -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-700 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg transform hover:scale-110 transition-all">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-200">Integrity</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Maintaining transparency, honesty, and ethical practices in all client relationships and projects</p>
                </div>

                <!-- Client Focus -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-orange-700 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg transform hover:scale-110 transition-all">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-200">Client Focus</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Prioritizing client success and building lasting partnerships beyond one-time transactions</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-4 text-center">Frequently Asked Questions</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 text-center mb-12 max-w-2xl mx-auto">
                Quick answers to common questions about our services
            </p>
            <div class="max-w-4xl mx-auto space-y-4" x-data="{ openFaq: 1 }">
                <!-- FAQ 1 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg">
                    <button @click="openFaq = openFaq === 1 ? null : 1" class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <span class="font-bold text-lg text-gray-800 dark:text-gray-200">What services does Nebatech offer?</span>
                        <svg class="w-6 h-6 text-primary dark:text-primary/80 transform transition-transform" :class="{ 'rotate-180': openFaq === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 1" x-transition class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            We offer comprehensive IT solutions including custom software development, web and mobile applications, e-commerce platforms, SaaS solutions, UI/UX design, blockchain integration, AI-driven systems, IT consulting, and developer training through Nebatech CodeCamp.
                        </p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg">
                    <button @click="openFaq = openFaq === 2 ? null : 2" class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <span class="font-bold text-lg text-gray-800 dark:text-gray-200">How long does a typical project take?</span>
                        <svg class="w-6 h-6 text-primary dark:text-primary/80 transform transition-transform" :class="{ 'rotate-180': openFaq === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 2" x-transition class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Project timelines vary based on complexity and scope. Small projects typically take 4-8 weeks, medium-sized applications 2-4 months, and enterprise solutions 4-8 months. We provide detailed timelines during the consultation phase and maintain transparent communication throughout development.
                        </p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg">
                    <button @click="openFaq = openFaq === 3 ? null : 3" class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <span class="font-bold text-lg text-gray-800 dark:text-gray-200">Do you provide ongoing support after project delivery?</span>
                        <svg class="w-6 h-6 text-primary dark:text-primary/80 transform transition-transform" :class="{ 'rotate-180': openFaq === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 3" x-transition class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Yes! We offer comprehensive maintenance and support packages. All projects include a warranty period with bug fixes and technical support. We also provide optional maintenance contracts for long-term support, updates, and feature enhancements.
                        </p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg">
                    <button @click="openFaq = openFaq === 4 ? null : 4" class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <span class="font-bold text-lg text-gray-800 dark:text-gray-200">What industries do you serve?</span>
                        <svg class="w-6 h-6 text-primary dark:text-primary/80 transform transition-transform" :class="{ 'rotate-180': openFaq === 4 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 4" x-transition class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            We serve diverse sectors including education, healthcare, e-commerce, fintech, blockchain, government agencies, NGOs, enterprise resource management, and more. Our multidisciplinary expertise allows us to adapt solutions to any industry's specific requirements.
                        </p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg">
                    <button @click="openFaq = openFaq === 5 ? null : 5" class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <span class="font-bold text-lg text-gray-800 dark:text-gray-200">How do I get started with a project?</span>
                        <svg class="w-6 h-6 text-primary dark:text-primary/80 transform transition-transform" :class="{ 'rotate-180': openFaq === 5 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 5" x-transition class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Simply contact us via phone (+233 24 763 6080), email (info@nebatech.com), or our contact form. We'll schedule a free consultation to understand your needs, discuss solutions, and provide a detailed proposal with timeline and cost estimates.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="py-16 bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-4 text-center">Visit Us or Get In Touch</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 text-center mb-12 max-w-2xl mx-auto">
                We're based in Tamale, Ghana, and serve clients across Africa and beyond
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Location -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl text-center">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-primary/90/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary dark:text-primary/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-200">Our Location</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Choggu Yapalsi<br>
                        Tamale, Northern Region<br>
                        Ghana, West Africa
                    </p>
                </div>

                <!-- Phone -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl text-center">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-200">Call Us</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        +233 24 763 6080<br>
                        +233 20 678 9600<br>
                        <span class="text-sm">Mon - Fri: 8AM - 6PM</span>
                    </p>
                </div>

                <!-- Email -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl text-center">
                    <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-200">Email Us</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        info@nebatech.com<br>
                        support@nebatech.com<br>
                        <span class="text-sm">24/7 Email Support</span>
                    </p>
                </div>
            </div>

            <!-- Social Media Section -->
            <div class="mt-16 text-center">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Connect With Us</h3>
                <div class="flex justify-center space-x-6">
                    <!-- Facebook -->
                    <a href="https://web.facebook.com/nebatechsoftware" target="_blank" rel="noopener noreferrer" class="group bg-white dark:bg-gray-900 p-4 rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2" aria-label="Facebook">
                        <svg class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-primary dark:group-hover:text-primary/80 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>

                    <!-- Twitter/X -->
                    <a href="https://x.com/nebatechSS" target="_blank" rel="noopener noreferrer" class="group bg-white dark:bg-gray-900 p-4 rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2" aria-label="Twitter">
                        <svg class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-black dark:group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>

                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/company/nebatech/" target="_blank" rel="noopener noreferrer" class="group bg-white dark:bg-gray-900 p-4 rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2" aria-label="LinkedIn">
                        <svg class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-primary dark:group-hover:text-primary/90 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>

                    <!-- Instagram -->
                    <a href="https://www.instagram.com/nebatechsoftwaresolution/" target="_blank" rel="noopener noreferrer" class="group bg-white dark:bg-gray-900 p-4 rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2" aria-label="Instagram">
                        <svg class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-12 text-center">Why Choose Nebatech</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <div class="text-center bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-primary/90/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary dark:text-primary/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-200">Technical Excellence</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Expert-led solutions with proven mastery in software, AI, and IT ecosystems</p>
                </div>
                <div class="text-center bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-200">Measurable Results</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Delivering efficiency improvements, cost reductions, and enhanced engagement</p>
                </div>
                <div class="text-center bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all">
                    <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-200">Client Partnership</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Building long-term relationships beyond temporary business transactions</p>
                </div>
                <div class="text-center bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all">
                    <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-200">Future-Ready</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Solutions designed with foresight for emerging technologies and AI integration</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-br from-primary via-blue-900 to-indigo-900 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to Transform Your Business?</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto leading-relaxed">
                Partner with Nebatech for innovative, secure, and scalable IT solutions that deliver measurable results and long-term value
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="<?= url('/contact') ?>" class="bg-secondary hover:bg-orange-600 text-white font-bold text-lg px-12 py-4 rounded-lg transition-all transform hover:scale-105 inline-block shadow-xl">
                    Get In Touch
                </a>
                <a href="<?= url('/services') ?>" class="bg-white hover:bg-gray-100 text-primary font-bold text-lg px-12 py-4 rounded-lg transition-all transform hover:scale-105 inline-block shadow-xl">
                    View Our Services
                </a>
            </div>
        </div>
    </section>

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-8 right-8 bg-primary hover:bg-primary/70 dark:bg-primary dark:hover:bg-primary/90 text-white w-12 h-12 rounded-full shadow-2xl flex items-center justify-center transition-all opacity-0 invisible z-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

    <!-- Counter Animation & Back to Top Script -->
    <script>
        // Animated Counter
        function animateCounter(element, target, duration = 2000) {
            let start = 0;
            const increment = target / (duration / 16);
            const timer = setInterval(() => {
                start += increment;
                if (start >= target) {
                    element.textContent = Math.ceil(target);
                    clearInterval(timer);
                } else {
                    element.textContent = Math.ceil(start);
                }
            }, 16);
        }

        // Intersection Observer for counters
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px'
        };

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                    entry.target.classList.add('counted');
                    const target = parseInt(entry.target.dataset.target);
                    animateCounter(entry.target, target);
                }
            });
        }, observerOptions);

        // Observe all counters
        document.querySelectorAll('.counter').forEach(counter => {
            counterObserver.observe(counter);
        });

        // Back to Top Button
        const backToTopButton = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.add('opacity-0', 'invisible');
                backToTopButton.classList.remove('opacity-100', 'visible');
            }
        });

        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Smooth scroll reveal animations
        const revealElements = document.querySelectorAll('section');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        revealElements.forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            revealObserver.observe(element);
        });
    </script>



