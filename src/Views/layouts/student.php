<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title><?= $title ?? 'Student Portal - Nebatech AI Academy' ?></title>
    
    <!-- Tailwind CSS -->
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    
    <!-- Alpine.js Collapse Plugin -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js for progress charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-link {
            position: relative;
            transition: all 0.2s ease;
        }
        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 0;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border-radius: 0 4px 4px 0;
            transition: height 0.2s ease;
        }
        .sidebar-link:hover::before,
        .sidebar-link.active::before {
            height: 60%;
        }
        .sidebar-link.active {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }
        .sidebar-section {
            position: relative;
        }
        .sidebar-section::before {
            content: '';
            position: absolute;
            left: 16px;
            top: 0;
            bottom: 0;
            width: 1px;
            background: linear-gradient(to bottom, transparent, #e5e7eb 20%, #e5e7eb 80%, transparent);
        }
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: false }">
    
    <!-- Include Student Sidebar -->
    <?php include __DIR__ . '/../partials/student-sidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="lg:pl-72 min-h-screen flex flex-col">
        
        <!-- Include Student Header -->
        <?php include __DIR__ . '/../partials/student-header.php'; ?>

        <!-- Page Content -->
        <main class="flex-1 p-6 bg-gradient-to-br from-gray-50 to-gray-100/50">
            <?php if (isset($_SESSION['success'])): ?>
            <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div>
                        <p class="font-medium">Success!</p>
                        <p class="text-sm text-green-600"><?= htmlspecialchars($_SESSION['success']) ?></p>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <?php unset($_SESSION['success']); endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-exclamation text-red-600"></i>
                    </div>
                    <div>
                        <p class="font-medium">Error</p>
                        <p class="text-sm text-red-600"><?= htmlspecialchars($_SESSION['error']) ?></p>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <?php unset($_SESSION['error']); endif; ?>

            <?= $content ?? '' ?>
        </main>

        <!-- Include Student Footer -->
        <?php include __DIR__ . '/../partials/student-footer.php'; ?>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         x-cloak
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm lg:hidden z-40">
    </div>

    <!-- AI Tutor Floating Widget -->
    <?php include __DIR__ . '/../partials/ai-tutor-widget.php'; ?>

    <!-- Notifications JS -->
    <script src="<?= asset('js/notifications.js') ?>"></script>
</body>
</html>