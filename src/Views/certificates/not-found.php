<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Not Found - Nebatech AI Academy</title>
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-2xl w-full">
            <div class="bg-white rounded-2xl shadow-2xl p-12 text-center">
                <!-- Icon -->
                <div class="mb-6">
                    <div class="w-24 h-24 bg-red-100 rounded-full mx-auto flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-4xl"></i>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Certificate Not Found</h1>
                
                <!-- Message -->
                <div class="space-y-4 text-gray-600 mb-8">
                    <p class="text-lg">
                        The certificate you're looking for could not be found or has been revoked.
                    </p>
                    <p>
                        This could happen if:
                    </p>
                    <ul class="text-left max-w-md mx-auto space-y-2">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-circle text-xs text-gray-400 mt-2"></i>
                            <span>The certificate number or link is incorrect</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-circle text-xs text-gray-400 mt-2"></i>
                            <span>The certificate has been revoked by an administrator</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-circle text-xs text-gray-400 mt-2"></i>
                            <span>The certificate does not exist in our system</span>
                        </li>
                    </ul>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?= url('/verify-certificate') ?>" 
                       class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold shadow-lg hover:shadow-xl">
                        <i class="fas fa-search mr-2"></i>Verify Another Certificate
                    </a>
                    <a href="<?= url('/') ?>" 
                       class="px-8 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold shadow-lg hover:shadow-xl">
                        <i class="fas fa-home mr-2"></i>Go to Homepage
                    </a>
                </div>

                <!-- Help -->
                <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        If you believe this is an error, please contact our support team.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
