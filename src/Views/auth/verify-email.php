<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - Nebatech AI Academy</title>
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Logo and Title -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center space-x-2 mb-4">
                    <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center font-bold text-xl text-white">
                        N
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        <span class="text-primary">Nebatech</span>
                        <span class="text-secondary">AI</span>
                    </h1>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Email Verification</h2>
            </div>

            <!-- Verification Result -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <?php if ($success): ?>
                    <!-- Success Message -->
                    <div class="text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                            <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Verification Successful!</h3>
                        <p class="text-gray-600 mb-6"><?= htmlspecialchars($message) ?></p>
                        <a href="<?= url('/login') ?>" 
                           class="inline-block w-full px-6 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-primary-dark transition duration-200 text-center">
                            Continue to Login
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Error Message -->
                    <div class="text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                            <svg class="h-10 w-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Verification Failed</h3>
                        <p class="text-gray-600 mb-6"><?= htmlspecialchars($message) ?></p>
                        <div class="space-y-3">
                            <a href="<?= url('/login') ?>" 
                               class="inline-block w-full px-6 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-primary-dark transition duration-200 text-center">
                                Go to Login
                            </a>
                            <a href="<?= url('/register') ?>" 
                               class="inline-block w-full px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition duration-200 text-center">
                                Register New Account
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Help Text -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Need help? 
                    <a href="<?= url('/contact') ?>" class="text-primary hover:text-primary-dark font-semibold">
                        Contact Support
                    </a>
                </p>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
