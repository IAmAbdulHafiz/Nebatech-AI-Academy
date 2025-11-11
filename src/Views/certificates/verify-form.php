<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Certificate - Nebatech AI Academy</title>
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Simple Header -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="<?= url('/') ?>" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-xl">N</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900">Nebatech AI Academy</span>
                </a>
                <a href="<?= url('/') ?>" class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
            </div>
        </div>
    </nav>
    
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-blue-600 rounded-full mx-auto flex items-center justify-center mb-4">
                    <i class="fas fa-certificate text-white text-3xl"></i>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Verify Certificate</h1>
                <p class="text-gray-600">Enter a certificate number or ID to verify its authenticity</p>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8">
                <form action="<?= url('/verify-certificate') ?>" method="GET">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Certificate Number or ID</label>
                        <input type="text" name="id" required 
                               placeholder="e.g., NEBA-2025-01-0001-0001-ABCD or certificate UUID"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                        <p class="text-sm text-gray-500 mt-2">Enter the certificate number found on the certificate</p>
                    </div>

                    <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-lg">
                        <i class="fas fa-search mr-2"></i>Verify Certificate
                    </button>
                </form>

                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="font-bold text-gray-900 mb-3">How to Verify</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Locate the certificate number on the certificate</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Enter the number in the field above</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Click "Verify Certificate" to check authenticity</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>View certificate details if valid</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center text-gray-600">
                <p>&copy; <?= date('Y') ?> Nebatech AI Academy. All rights reserved.</p>
                <p class="mt-2 text-sm">
                    <a href="<?= url('/') ?>" class="text-blue-600 hover:underline">Home</a> • 
                    <a href="<?= url('/contact') ?>" class="text-blue-600 hover:underline">Contact</a>
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
