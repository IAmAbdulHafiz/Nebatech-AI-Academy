<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Master AI & Machine Learning with Python, TensorFlow, PyTorch, Deep Learning, NLP, and Computer Vision. Build intelligent applications.">
    <meta name="keywords" content="AI, Machine Learning, Deep Learning, Neural Networks, TensorFlow, PyTorch, NLP, Computer Vision">
    <title>AI & Machine Learning Courses - Nebatech AI Academy</title>
    
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
    <section class="bg-indigo-600 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-block bg-indigo-700 text-indigo-100 px-4 py-2 rounded-full text-sm font-semibold mb-6">
                    <i class="fas fa-brain mr-2"></i>AI & Machine Learning
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    Master AI & Machine Learning
                </h1>
                <p class="text-xl md:text-2xl text-indigo-100 mb-8">
                    Build intelligent applications with Machine Learning, Deep Learning, NLP, and Computer Vision
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#courses" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold hover:bg-indigo-50 transition inline-flex items-center">
                        <i class="fas fa-rocket mr-2"></i>Browse Courses
                    </a>
                    <a href="<?= url('/register') ?>" class="bg-indigo-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-indigo-800 transition inline-flex items-center border-2 border-indigo-500">
                        <i class="fas fa-user-plus mr-2"></i>Get Started Free
                    </a>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                    <div>
                        <div class="text-3xl font-bold">30+</div>
                        <div class="text-indigo-200 text-sm">Courses</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">12,000+</div>
                        <div class="text-indigo-200 text-sm">Students</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">400+</div>
                        <div class="text-indigo-200 text-sm">Hours Content</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">99%</div>
                        <div class="text-indigo-200 text-sm">Success Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Learning Path -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Your AI/ML Learning Path</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    From fundamentals to advanced AI applications
                </p>
            </div>

            <div class="max-w-5xl mx-auto">
                <div class="space-y-8">
                    <!-- Level 1: Foundations -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                        <div class="flex items-start gap-4">
                            <div class="bg-green-100 text-green-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">
                                1
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Foundations</h3>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">3-6 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Build strong mathematical and programming foundations</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">Python</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">NumPy</span>
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">Pandas</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Statistics</span>
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm font-medium">Linear Algebra</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Level 2: Machine Learning -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                        <div class="flex items-start gap-4">
                            <div class="bg-blue-100 text-blue-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">
                                2
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Machine Learning</h3>
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">6-12 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Master classical ML algorithms and techniques</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">Scikit-learn</span>
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">Supervised Learning</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Unsupervised Learning</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Model Evaluation</span>
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">Feature Engineering</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Level 3: Deep Learning -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                        <div class="flex items-start gap-4">
                            <div class="bg-purple-100 text-purple-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">
                                3
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Deep Learning</h3>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">6-12 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Build neural networks and deep learning models</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">TensorFlow</span>
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">PyTorch</span>
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">Neural Networks</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">CNNs</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">RNNs</span>
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm font-medium">Transformers</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Level 4: Specialized AI -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
                        <div class="flex items-start gap-4">
                            <div class="bg-red-100 text-red-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">
                                4
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Specialized Applications</h3>
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">6-12 months</span>
                                </div>
                                <p class="text-gray-600 mb-4">Apply AI to specific domains and problems</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">Computer Vision</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">NLP</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Reinforcement Learning</span>
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">GANs</span>
                                    <span class="bg-pink-100 text-pink-700 px-3 py-1 rounded-lg text-sm font-medium">MLOps</span>
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
                    Master cutting-edge AI and machine learning technologies
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
                    <div class="text-blue-600 text-4xl mb-4">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Machine Learning</h3>
                    <p class="text-gray-600">Build predictive models using classification, regression, and clustering algorithms.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-purple-500">
                    <div class="text-purple-600 text-4xl mb-4">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Deep Learning</h3>
                    <p class="text-gray-600">Design and train neural networks for complex pattern recognition tasks.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-green-500">
                    <div class="text-green-600 text-4xl mb-4">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Computer Vision</h3>
                    <p class="text-gray-600">Build image recognition, object detection, and facial recognition systems.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-orange-500">
                    <div class="text-orange-600 text-4xl mb-4">
                        <i class="fas fa-language"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">NLP</h3>
                    <p class="text-gray-600">Process and understand human language with sentiment analysis and chatbots.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-red-500">
                    <div class="text-red-600 text-4xl mb-4">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Model Deployment</h3>
                    <p class="text-gray-600">Deploy ML models to production with MLOps best practices.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-yellow-500">
                    <div class="text-yellow-600 text-4xl mb-4">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Data Processing</h3>
                    <p class="text-gray-600">Clean, transform, and prepare data for machine learning pipelines.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Listing -->
    <section id="courses" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">AI & Machine Learning Courses</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Learn from beginner to advanced AI and machine learning
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <!-- Course 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-blue-600 h-48 flex items-center justify-center">
                        <i class="fab fa-python text-white text-8xl"></i>
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
                                <span class="text-gray-600 text-sm ml-1">(5,680)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Machine Learning A-Z</h3>
                        <p class="text-gray-600 mb-4">Complete ML course covering all algorithms with Python and scikit-learn.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>110 hours</span>
                            <span><i class="fas fa-book mr-1"></i>135 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>12.5K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-indigo-600">$159</div>
                            <a href="#" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-orange-600 h-48 flex items-center justify-center">
                        <div class="text-white text-6xl font-bold">TensorFlow</div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">Intermediate</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(4,230)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Deep Learning with TensorFlow</h3>
                        <p class="text-gray-600 mb-4">Build neural networks and deep learning models with TensorFlow 2.0.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>95 hours</span>
                            <span><i class="fas fa-book mr-1"></i>118 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>8.9K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-indigo-600">$179</div>
                            <a href="#" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-red-600 h-48 flex items-center justify-center">
                        <div class="text-white text-6xl font-bold">PyTorch</div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">Intermediate</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="text-gray-600 text-sm ml-1">(3,890)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">PyTorch Complete Guide</h3>
                        <p class="text-gray-600 mb-4">Master PyTorch for deep learning and neural network development.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>88 hours</span>
                            <span><i class="fas fa-book mr-1"></i>108 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>7.2K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-indigo-600">$169</div>
                            <a href="#" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 4 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-purple-600 h-48 flex items-center justify-center">
                        <i class="fas fa-eye text-white text-8xl"></i>
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
                                <span class="text-gray-600 text-sm ml-1">(2,560)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Computer Vision Mastery</h3>
                        <p class="text-gray-600 mb-4">Build image recognition and object detection systems with CNNs.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>75 hours</span>
                            <span><i class="fas fa-book mr-1"></i>92 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>5.1K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-indigo-600">$149</div>
                            <a href="#" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 5 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-green-600 h-48 flex items-center justify-center">
                        <i class="fas fa-language text-white text-8xl"></i>
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
                                <span class="text-gray-600 text-sm ml-1">(3,120)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">NLP with Transformers</h3>
                        <p class="text-gray-600 mb-4">Master natural language processing with BERT, GPT, and transformers.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>80 hours</span>
                            <span><i class="fas fa-book mr-1"></i>98 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>6.3K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-indigo-600">$189</div>
                            <a href="#" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Course 6 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-teal-600 h-48 flex items-center justify-center">
                        <i class="fas fa-robot text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">Advanced</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="text-gray-600 text-sm ml-1">(1,840)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Reinforcement Learning</h3>
                        <p class="text-gray-600 mb-4">Train AI agents to make decisions using reinforcement learning.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>65 hours</span>
                            <span><i class="fas fa-book mr-1"></i>78 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>3.5K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-indigo-600">$159</div>
                            <a href="#" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="<?= url('/courses') ?>" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-semibold">
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
                            AI/ML engineers are among the highest paid tech professionals. Work at:
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">AI Research Labs</h4>
                                    <p class="text-gray-600">OpenAI, Google DeepMind, Meta AI</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Tech Giants</h4>
                                    <p class="text-gray-600">Building AI-powered products and services</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">AI Startups</h4>
                                    <p class="text-gray-600">Innovative companies disrupting industries with AI</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Consulting</h4>
                                    <p class="text-gray-600">Help businesses implement AI solutions</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-indigo-50 rounded-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Average Salaries</h3>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Junior ML Engineer</span>
                                    <span class="font-bold text-indigo-600">$70K - $95K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-green-500 h-full rounded-full" style="width: 55%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Mid-Level ML Engineer</span>
                                    <span class="font-bold text-indigo-600">$95K - $140K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-blue-500 h-full rounded-full" style="width: 75%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Senior ML Engineer</span>
                                    <span class="font-bold text-indigo-600">$140K - $200K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-purple-500 h-full rounded-full" style="width: 90%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">AI Research Scientist</span>
                                    <span class="font-bold text-indigo-600">$200K+</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-red-500 h-full rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-600 mt-6">
                            <i class="fas fa-info-circle mr-1"></i>
                            AI/ML roles command top salaries in the tech industry
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-indigo-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Master AI & Machine Learning?</h2>
            <p class="text-xl text-indigo-100 mb-8 max-w-2xl mx-auto">
                Join thousands of students building intelligent applications with AI
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?= url('/register') ?>" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold hover:bg-indigo-50 transition inline-flex items-center">
                    <i class="fas fa-rocket mr-2"></i>Get Started Free
                </a>
                <a href="<?= url('/contact') ?>" class="bg-indigo-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-indigo-800 transition inline-flex items-center border-2 border-indigo-500">
                    <i class="fas fa-comment mr-2"></i>Talk to an Advisor
                </a>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
