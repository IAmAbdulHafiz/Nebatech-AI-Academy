<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Master Data Science with Python, R, SQL, statistics, machine learning, and data visualization. Become a data-driven decision maker.">
    <meta name="keywords" content="Data Science, Python, R, Statistics, Data Analysis, Data Visualization, Big Data, Analytics">
    <title>Data Science Courses - Nebatech AI Academy</title>
    
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
    <section class="bg-pink-600 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-block bg-pink-700 text-pink-100 px-4 py-2 rounded-full text-sm font-semibold mb-6">
                    <i class="fas fa-chart-bar mr-2"></i>Data Science
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    Master Data Science
                </h1>
                <p class="text-xl md:text-2xl text-pink-100 mb-8">
                    Extract insights from data with Python, statistics, machine learning, and visualization tools
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#courses" class="bg-white text-pink-600 px-8 py-4 rounded-lg font-semibold hover:bg-pink-50 transition inline-flex items-center">
                        <i class="fas fa-rocket mr-2"></i>Browse Courses
                    </a>
                    <a href="<?= url('/register') ?>" class="bg-pink-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-pink-800 transition inline-flex items-center border-2 border-pink-500">
                        <i class="fas fa-user-plus mr-2"></i>Get Started Free
                    </a>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                    <div>
                        <div class="text-3xl font-bold">28+</div>
                        <div class="text-pink-200 text-sm">Courses</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">10,500+</div>
                        <div class="text-pink-200 text-sm">Students</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">380+</div>
                        <div class="text-pink-200 text-sm">Hours Content</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">97%</div>
                        <div class="text-pink-200 text-sm">Success Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Learning Path -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Your Data Science Path</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    From data analysis to advanced predictive modeling
                </p>
            </div>

            <div class="max-w-5xl mx-auto space-y-8">
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-start gap-4">
                        <div class="bg-blue-100 text-blue-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">1</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-900">Foundation</h3>
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">3-6 months</span>
                            </div>
                            <p class="text-gray-600 mb-4">Master programming and statistics fundamentals</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">Python</span>
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">SQL</span>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Statistics</span>
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">Pandas</span>
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm font-medium">NumPy</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-start gap-4">
                        <div class="bg-green-100 text-green-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">2</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-900">Data Analysis</h3>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">4-8 months</span>
                            </div>
                            <p class="text-gray-600 mb-4">Analyze and visualize data effectively</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">Matplotlib</span>
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">Seaborn</span>
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Tableau</span>
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm font-medium">Power BI</span>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Excel Advanced</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                    <div class="flex items-start gap-4">
                        <div class="bg-purple-100 text-purple-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">3</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-900">Machine Learning</h3>
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">6-12 months</span>
                            </div>
                            <p class="text-gray-600 mb-4">Build predictive models and algorithms</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">Scikit-learn</span>
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">Regression</span>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Classification</span>
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Clustering</span>
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">Time Series</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
                    <div class="flex items-start gap-4">
                        <div class="bg-orange-100 text-orange-600 w-12 h-12 rounded-full flex items-center justify-center font-bold flex-shrink-0">4</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-900">Big Data & Advanced</h3>
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-semibold">6-12 months</span>
                            </div>
                            <p class="text-gray-600 mb-4">Work with large-scale data systems</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-lg text-sm font-medium">Spark</span>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm font-medium">Hadoop</span>
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">AWS</span>
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">Deep Learning</span>
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-medium">MLOps</span>
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
                    Become a complete data science professional
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
                    <div class="text-blue-600 text-4xl mb-4"><i class="fas fa-chart-line"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Data Analysis</h3>
                    <p class="text-gray-600">Clean, explore, and analyze datasets to extract insights.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-green-500">
                    <div class="text-green-600 text-4xl mb-4"><i class="fas fa-chart-pie"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Visualization</h3>
                    <p class="text-gray-600">Create compelling visualizations and dashboards.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-purple-500">
                    <div class="text-purple-600 text-4xl mb-4"><i class="fas fa-robot"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Machine Learning</h3>
                    <p class="text-gray-600">Build predictive models and algorithms.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-orange-500">
                    <div class="text-orange-600 text-4xl mb-4"><i class="fas fa-database"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">SQL & Databases</h3>
                    <p class="text-gray-600">Query and manage databases efficiently.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-red-500">
                    <div class="text-red-600 text-4xl mb-4"><i class="fas fa-calculator"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Statistics</h3>
                    <p class="text-gray-600">Apply statistical methods for data-driven decisions.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-yellow-500">
                    <div class="text-yellow-600 text-4xl mb-4"><i class="fas fa-cloud"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Big Data</h3>
                    <p class="text-gray-600">Process large-scale datasets with Spark and Hadoop.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Listing -->
    <section id="courses" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Data Science Courses</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Comprehensive data science training programs</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <!-- Course Cards (6 courses) -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-blue-600 h-48 flex items-center justify-center">
                        <i class="fab fa-python text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Beginner</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(6,240)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Data Science with Python</h3>
                        <p class="text-gray-600 mb-4">Complete Python for data science: Pandas, NumPy, and Matplotlib.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>95 hours</span>
                            <span><i class="fas fa-book mr-1"></i>115 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>14.2K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-pink-600">$139</div>
                            <a href="#" class="bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700 transition font-semibold">Enroll Now</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-purple-600 h-48 flex items-center justify-center">
                        <i class="fas fa-database text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Beginner</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                <span class="text-gray-600 text-sm ml-1">(4,890)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">SQL for Data Science</h3>
                        <p class="text-gray-600 mb-4">Master SQL queries, joins, and database management.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>50 hours</span>
                            <span><i class="fas fa-book mr-1"></i>62 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>9.5K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-pink-600">$79</div>
                            <a href="#" class="bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700 transition font-semibold">Enroll Now</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-orange-600 h-48 flex items-center justify-center">
                        <i class="fas fa-chart-bar text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">Intermediate</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(3,560)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Data Visualization Mastery</h3>
                        <p class="text-gray-600 mb-4">Create stunning dashboards with Tableau and Power BI.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>60 hours</span>
                            <span><i class="fas fa-book mr-1"></i>72 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>7.8K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-pink-600">$99</div>
                            <a href="#" class="bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700 transition font-semibold">Enroll Now</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-green-600 h-48 flex items-center justify-center">
                        <i class="fas fa-calculator text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">Intermediate</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(4,120)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Statistics for Data Science</h3>
                        <p class="text-gray-600 mb-4">Master statistical methods and hypothesis testing.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>70 hours</span>
                            <span><i class="fas fa-book mr-1"></i>85 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>8.3K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-pink-600">$109</div>
                            <a href="#" class="bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700 transition font-semibold">Enroll Now</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-red-600 h-48 flex items-center justify-center">
                        <i class="fas fa-robot text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">Advanced</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span class="text-gray-600 text-sm ml-1">(3,890)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">ML for Data Scientists</h3>
                        <p class="text-gray-600 mb-4">Build predictive models with scikit-learn and advanced algorithms.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>100 hours</span>
                            <span><i class="fas fa-book mr-1"></i>125 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>9.2K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-pink-600">$169</div>
                            <a href="#" class="bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700 transition font-semibold">Enroll Now</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="bg-yellow-600 h-48 flex items-center justify-center">
                        <i class="fas fa-fire text-white text-8xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">Advanced</span>
                            <span class="text-yellow-500">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                <span class="text-gray-600 text-sm ml-1">(2,340)</span>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Big Data with Spark</h3>
                        <p class="text-gray-600 mb-4">Process large-scale data with Apache Spark and Hadoop.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-clock mr-1"></i>80 hours</span>
                            <span><i class="fas fa-book mr-1"></i>98 lessons</span>
                            <span><i class="fas fa-users mr-1"></i>5.1K</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-pink-600">$149</div>
                            <a href="#" class="bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700 transition font-semibold">Enroll Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="<?= url('/courses') ?>" class="inline-flex items-center text-pink-600 hover:text-pink-700 font-semibold">
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
                            Data scientists are the most sought-after professionals. Work at:
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Tech Companies</h4>
                                    <p class="text-gray-600">Build data-driven products and features</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Finance & Banking</h4>
                                    <p class="text-gray-600">Risk analysis, fraud detection, trading algorithms</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Healthcare</h4>
                                    <p class="text-gray-600">Medical research and patient analytics</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Consulting</h4>
                                    <p class="text-gray-600">Help businesses make data-driven decisions</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-pink-50 rounded-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Average Salaries</h3>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Junior Data Scientist</span>
                                    <span class="font-bold text-pink-600">$65K - $90K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-green-500 h-full rounded-full" style="width: 50%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Mid-Level Data Scientist</span>
                                    <span class="font-bold text-pink-600">$90K - $130K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-blue-500 h-full rounded-full" style="width: 70%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Senior Data Scientist</span>
                                    <span class="font-bold text-pink-600">$130K - $180K</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-purple-500 h-full rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-900">Principal Data Scientist</span>
                                    <span class="font-bold text-pink-600">$180K+</span>
                                </div>
                                <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-red-500 h-full rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-600 mt-6">
                            <i class="fas fa-info-circle mr-1"></i>
                            Data scientists with ML skills earn premium salaries
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-pink-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Become a Data Scientist?</h2>
            <p class="text-xl text-pink-100 mb-8 max-w-2xl mx-auto">
                Join thousands of students extracting insights from data
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?= url('/register') ?>" class="bg-white text-pink-600 px-8 py-4 rounded-lg font-semibold hover:bg-pink-50 transition inline-flex items-center">
                    <i class="fas fa-rocket mr-2"></i>Get Started Free
                </a>
                <a href="<?= url('/contact') ?>" class="bg-pink-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-pink-800 transition inline-flex items-center border-2 border-pink-500">
                    <i class="fas fa-comment mr-2"></i>Talk to an Advisor
                </a>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
