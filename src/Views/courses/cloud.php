<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Master Cloud Computing with AWS, Azure, Google Cloud Platform. Learn DevOps, serverless, containers, and cloud architecture.">
    <meta name="keywords" content="Cloud Computing, AWS, Azure, Google Cloud, DevOps, Kubernetes, Docker, Serverless">
    <title>Cloud Computing Courses - Nebatech AI Academy</title>
    
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <!-- Alpine.js Collapse Plugin (must load before Alpine core) -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <!-- Hero Section -->
    <section class="bg-sky-600 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-block bg-sky-700 text-sky-100 px-4 py-2 rounded-full text-sm font-semibold mb-6">
                    <i class="fas fa-cloud mr-2"></i>Cloud Computing
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    Master Cloud Computing
                </h1>
                <p class="text-xl md:text-2xl text-sky-100 mb-8">
                    Build, deploy, and manage applications on AWS, Azure, and Google Cloud Platform
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#courses" class="bg-white text-sky-600 px-8 py-4 rounded-lg font-semibold hover:bg-sky-50 transition inline-flex items-center">
                        <i class="fas fa-rocket mr-2"></i>Browse Courses
                    </a>
                    <a href="<?= url('/register') ?>" class="bg-sky-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-sky-800 transition inline-flex items-center border-2 border-sky-500">
                        <i class="fas fa-user-plus mr-2"></i>Get Started Free
                    </a>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                    <div>
                        <div class="text-3xl font-bold">26+</div>
                        <div class="text-sky-200 text-sm">Courses</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">11,200+</div>
                        <div class="text-sky-200 text-sm">Students</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">360+</div>
                        <div class="text-sky-200 text-sm">Hours Content</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">96%</div>
                        <div class="text-sky-200 text-sm">Success Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Learning Path -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Your Cloud Computing Path</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    From cloud fundamentals to advanced architecture and DevOps
                </p>
            </div>

            <div class="max-w-5xl mx-auto space-y-8">
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
                    <div class="flex items-start gap-4">
                        <div class="bg-orange-100 text-orange-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">1</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-900">Cloud Fundamentals</h3>
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-semibold">2-4 months</span>
                            </div>
                            <p class="text-gray-600 mb-4">Learn cloud computing basics and core services</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">AWS Basics</span>
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">Azure Fundamentals</span>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">GCP Intro</span>
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Cloud Concepts</span>
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm font-medium">Pricing & Cost</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-start gap-4">
                        <div class="bg-blue-100 text-blue-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">2</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-900">Core Cloud Services</h3>
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">4-8 months</span>
                            </div>
                            <p class="text-gray-600 mb-4">Master compute, storage, networking, and databases</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">EC2 / VMs</span>
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">S3 / Storage</span>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">VPC / Networking</span>
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">RDS / Databases</span>
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">IAM / Security</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                    <div class="flex items-start gap-4">
                        <div class="bg-purple-100 text-purple-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">3</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-900">DevOps & Automation</h3>
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">6-12 months</span>
                            </div>
                            <p class="text-gray-600 mb-4">Implement CI/CD, containers, and infrastructure as code</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">Docker</span>
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Kubernetes</span>
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">Terraform</span>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Jenkins</span>
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">GitLab CI/CD</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-start gap-4">
                        <div class="bg-green-100 text-green-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">4</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-900">Advanced & Certifications</h3>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">6-12 months</span>
                            </div>
                            <p class="text-gray-600 mb-4">Architect cloud solutions and earn certifications</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">AWS Solutions Architect</span>
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">Azure Architect</span>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Serverless</span>
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Microservices</span>
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">Multi-Cloud</span>
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
                    Become a cloud computing professional
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-orange-500">
                    <div class="text-orange-600 text-4xl mb-4"><i class="fab fa-aws"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">AWS Expertise</h3>
                    <p class="text-gray-600">Master Amazon Web Services and its extensive service ecosystem.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
                    <div class="text-blue-600 text-4xl mb-4"><i class="fab fa-microsoft"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Azure Mastery</h3>
                    <p class="text-gray-600">Build and manage applications on Microsoft Azure platform.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-green-500">
                    <div class="text-green-600 text-4xl mb-4"><i class="fab fa-google"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Google Cloud</h3>
                    <p class="text-gray-600">Leverage GCP services for scalable cloud applications.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-purple-500">
                    <div class="text-purple-600 text-4xl mb-4"><i class="fab fa-docker"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Containerization</h3>
                    <p class="text-gray-600">Deploy applications with Docker and orchestrate with Kubernetes.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-red-500">
                    <div class="text-red-600 text-4xl mb-4"><i class="fas fa-infinity"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">DevOps Practices</h3>
                    <p class="text-gray-600">Implement CI/CD pipelines and infrastructure automation.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-yellow-500">
                    <div class="text-yellow-600 text-4xl mb-4"><i class="fas fa-project-diagram"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Cloud Architecture</h3>
                    <p class="text-gray-600">Design scalable, reliable, and cost-effective cloud solutions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Listing -->
    <section id="courses" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Cloud Computing Courses</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Master cloud platforms and modern infrastructure</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-orange-500 h-48 flex items-center justify-center">
                        <i class="fab fa-aws text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Beginner</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(5,890)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">AWS Complete Guide</h3>
                        <p class="text-gray-600 mb-4">Master Amazon Web Services from basics to advanced concepts.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>105 hours</span>
                            <span><i class="fas fa-book mr-1"></i>130 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>13.5K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-sky-600">$159</div>
                            <a href="#" class="bg-sky-600 text-white px-6 py-2 rounded-lg hover:bg-sky-700 transition font-semibold">Enroll Now</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-blue-600 h-48 flex items-center justify-center">
                        <i class="fab fa-microsoft text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Beginner</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(4,670)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Azure Fundamentals</h3>
                        <p class="text-gray-600 mb-4">Complete Microsoft Azure training from zero to hero.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>95 hours</span>
                            <span><i class="fas fa-book mr-1"></i>118 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>10.8K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-sky-600">$149</div>
                            <a href="#" class="bg-sky-600 text-white px-6 py-2 rounded-lg hover:bg-sky-700 transition font-semibold">Enroll Now</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-red-600 h-48 flex items-center justify-center">
                        <i class="fab fa-google text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">Intermediate</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                <span class="text-gray-600 text-sm ml-1">(3,240)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Google Cloud Platform</h3>
                        <p class="text-gray-600 mb-4">Master GCP services and build scalable applications.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>85 hours</span>
                            <span><i class="fas fa-book mr-1"></i>105 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>7.2K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-sky-600">$139</div>
                            <a href="#" class="bg-sky-600 text-white px-6 py-2 rounded-lg hover:bg-sky-700 transition font-semibold">Enroll Now</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-blue-800 h-48 flex items-center justify-center">
                        <i class="fab fa-docker text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">Intermediate</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(4,120)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Docker & Kubernetes</h3>
                        <p class="text-gray-600 mb-4">Master containerization and container orchestration.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>78 hours</span>
                            <span><i class="fas fa-book mr-1"></i>95 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>9.6K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-sky-600">$129</div>
                            <a href="#" class="bg-sky-600 text-white px-6 py-2 rounded-lg hover:bg-sky-700 transition font-semibold">Enroll Now</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-purple-600 h-48 flex items-center justify-center">
                        <i class="fas fa-infinity text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">Intermediate</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(3,680)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">DevOps Complete Course</h3>
                        <p class="text-gray-600 mb-4">Master CI/CD, automation, and DevOps best practices.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>92 hours</span>
                            <span><i class="fas fa-book mr-1"></i>115 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>8.4K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-sky-600">$169</div>
                            <a href="#" class="bg-sky-600 text-white px-6 py-2 rounded-lg hover:bg-sky-700 transition font-semibold">Enroll Now</a>
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
                                <span class="text-gray-600 text-sm ml-1">(2,340)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">AWS Solutions Architect</h3>
                        <p class="text-gray-600 mb-4">Prepare for AWS Solutions Architect certification.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>110 hours</span>
                            <span><i class="fas fa-book mr-1"></i>135 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>6.8K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-sky-600">$189</div>
                            <a href="#" class="bg-sky-600 text-white px-6 py-2 rounded-lg hover:bg-sky-700 transition font-semibold">Enroll Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="<?= url('/courses') ?>" class="inline-flex items-center text-sky-600 hover:text-sky-700 font-semibold">
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
                            Cloud professionals are highly sought after. Work at:
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Cloud-Native Companies</h4>
                                    <p class="text-gray-600">Netflix, Spotify, Airbnb, and more</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Enterprise</h4>
                                    <p class="text-gray-600">Migrate and manage cloud infrastructure</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Cloud Providers</h4>
                                    <p class="text-gray-600">AWS, Microsoft, Google, and partners</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Consulting</h4>
                                    <p class="text-gray-600">Help businesses move to the cloud</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-sky-50 rounded-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Average Salaries</h3>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Junior Cloud Engineer</span>
                                    <span class="font-bold text-sky-600">$65K - $90K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-green-500 h-full rounded-full" style="width: 52%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Cloud DevOps Engineer</span>
                                    <span class="font-bold text-sky-600">$90K - $135K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-blue-500 h-full rounded-full" style="width: 72%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Senior Cloud Architect</span>
                                    <span class="font-bold text-sky-600">$135K - $190K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-purple-500 h-full rounded-full" style="width: 90%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Principal Cloud Architect</span>
                                    <span class="font-bold text-sky-600">$190K+</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-red-500 h-full rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-600 mt-6">
                            <i class="fas fa-info-circle mr-1"></i>
                            Cloud certifications significantly increase earning potential
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-sky-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Master Cloud Computing?</h2>
            <p class="text-xl text-sky-100 mb-8 max-w-2xl mx-auto">
                Join thousands of students building cloud-native applications on AWS, Azure, and GCP
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?= url('/register') ?>" class="bg-white text-sky-600 px-8 py-4 rounded-lg font-semibold hover:bg-sky-50 transition inline-flex items-center">
                    <i class="fas fa-rocket mr-2"></i>Get Started Free
                </a>
                <a href="<?= url('/contact') ?>" class="bg-sky-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-sky-800 transition inline-flex items-center border-2 border-sky-500">
                    <i class="fas fa-comment mr-2"></i>Talk to an Advisor
                </a>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
