<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Denied | Nebatech AI Academy</title>
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="min-h-screen flex items-center justify-center px-6 py-20">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Error Illustration -->
            <div class="mb-8">
                <div class="text-9xl font-bold text-yellow-500 opacity-20">403</div>
            </div>

            <!-- Error Icon -->
            <div class="mb-8">
                <div class="w-32 h-32 mx-auto bg-yellow-100 dark:bg-yellow-900/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-lock text-6xl text-yellow-500"></i>
                </div>
            </div>

            <!-- Error Message -->
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                Access Denied
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">
                You don't have permission to access this resource. This area may be restricted to certain users.
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                <a href="<?= url('/login') ?>" 
                   class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </a>
                <a href="<?= url('/') ?>" 
                   class="inline-flex items-center justify-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-8 py-4 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-home"></i>
                    <span>Go Home</span>
                </a>
                <a href="<?= url('/contact') ?>" 
                   class="inline-flex items-center justify-center gap-2 bg-secondary hover:bg-orange-600 text-white px-8 py-4 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-envelope"></i>
                    <span>Contact Support</span>
                </a>
            </div>

            <!-- Information Box -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Why am I seeing this?
                </h2>
                <div class="text-left space-y-4 text-gray-600 dark:text-gray-400">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-primary mt-1"></i>
                        <p>You may need to log in with the appropriate account</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-primary mt-1"></i>
                        <p>Your account may not have the required permissions</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-primary mt-1"></i>
                        <p>This resource may be restricted to enrolled students or staff</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-primary mt-1"></i>
                        <p>The page may have been moved or no longer exists</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
