<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for <?= htmlspecialchars($program['title']) ?> - Nebatech AI Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="max-w-4xl mx-auto px-4 py-12">
        <!-- Program Header -->
        <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-xl p-8 text-white mb-8">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Apply for <?= htmlspecialchars($program['title']) ?></h1>
                    <p class="text-purple-100">Join our next cohort and start your learning journey</p>
                </div>
                <div class="text-right">
                    <div class="text-4xl mb-2">🎓</div>
                </div>
            </div>
        </div>

        <!-- Available Cohorts -->
        <?php if (!empty($cohorts)): ?>
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-users text-blue-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Available Cohorts</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <?php foreach ($cohorts as $cohort): ?>
                            <div class="mb-2">
                                <strong><?= htmlspecialchars($cohort['name']) ?></strong> 
                                - Starts <?= date('F j, Y', strtotime($cohort['start_date'])) ?>
                                (<?= $cohort['max_students'] - $cohort['current_students'] ?> seats available)
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Application Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form id="applicationForm" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="program_id" value="<?= $program['id'] ?>">

                <!-- Personal Information -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 pb-2 border-b-2 border-purple-200">
                        <i class="fas fa-user mr-2 text-purple-600"></i>
                        Personal Information
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                First Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" value="<?= htmlspecialchars($user['first_name']) ?>" disabled
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Last Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" value="<?= htmlspecialchars($user['last_name']) ?>" disabled
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="phone" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="+234 XXX XXX XXXX">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Country <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="country" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="e.g., Nigeria">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                City
                            </label>
                            <input type="text" name="city"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="e.g., Lagos">
                        </div>
                    </div>
                </div>

                <!-- Background Information -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 pb-2 border-b-2 border-purple-200">
                        <i class="fas fa-graduation-cap mr-2 text-purple-600"></i>
                        Background Information
                    </h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Employment Status <span class="text-red-500">*</span>
                            </label>
                            <select name="employment_status" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Select your employment status</option>
                                <option value="Student">Student</option>
                                <option value="Employed Full-time">Employed Full-time</option>
                                <option value="Employed Part-time">Employed Part-time</option>
                                <option value="Self-employed">Self-employed</option>
                                <option value="Unemployed">Unemployed</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Educational Background <span class="text-red-500">*</span>
                            </label>
                            <textarea name="educational_background" required rows="4"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="Tell us about your educational background (e.g., highest degree, major, relevant coursework)"></textarea>
                            <p class="mt-1 text-sm text-gray-500">Minimum 50 characters</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Why do you want to join this program? <span class="text-red-500">*</span>
                            </label>
                            <textarea name="motivation" required rows="5"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="Share your motivation for joining this program. What excites you about it?"></textarea>
                            <p class="mt-1 text-sm text-gray-500">Minimum 100 characters</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Career Goals <span class="text-red-500">*</span>
                            </label>
                            <textarea name="goals" required rows="4"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="What are your career goals? How will this program help you achieve them?"></textarea>
                            <p class="mt-1 text-sm text-gray-500">Minimum 50 characters</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                How did you hear about us? <span class="text-red-500">*</span>
                            </label>
                            <select name="referral_source" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Select an option</option>
                                <option value="Social Media">Social Media (Facebook, Twitter, Instagram)</option>
                                <option value="Google Search">Google Search</option>
                                <option value="Friend/Family Referral">Friend/Family Referral</option>
                                <option value="LinkedIn">LinkedIn</option>
                                <option value="Online Advertisement">Online Advertisement</option>
                                <option value="Blog/Article">Blog/Article</option>
                                <option value="YouTube">YouTube</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Document Uploads (Optional) -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 pb-2 border-b-2 border-purple-200">
                        <i class="fas fa-file-upload mr-2 text-purple-600"></i>
                        Supporting Documents <span class="text-sm text-gray-500 font-normal">(Optional)</span>
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                ID Document
                            </label>
                            <input type="file" name="id_document" accept=".pdf,.jpg,.jpeg,.png"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                            <p class="mt-1 text-sm text-gray-500">Upload a valid ID (PDF, JPG, PNG - Max 5MB)</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Educational Transcript
                            </label>
                            <input type="file" name="transcript" accept=".pdf"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                            <p class="mt-1 text-sm text-gray-500">Upload your transcript (PDF - Max 10MB)</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Resume/CV
                            </label>
                            <input type="file" name="resume" accept=".pdf,.doc,.docx"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                            <p class="mt-1 text-sm text-gray-500">Upload your resume (PDF, DOC, DOCX - Max 5MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="flex items-start">
                        <input type="checkbox" id="terms" required
                               class="mt-1 h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="terms" class="ml-3 text-sm text-gray-700">
                            I agree to the <a href="/terms" class="text-purple-600 hover:text-purple-700 font-medium">Terms and Conditions</a> 
                            and <a href="/privacy" class="text-purple-600 hover:text-purple-700 font-medium">Privacy Policy</a>. 
                            I understand that my application will be reviewed and I will be notified of the decision via email.
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between pt-6 border-t">
                    <a href="<?= url('/courses/' . $program['slug']) ?>" 
                       class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Course
                    </a>
                    
                    <button type="submit" id="submitBtn"
                            class="px-8 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg hover:from-purple-700 hover:to-purple-900 transition font-semibold">
                        <i class="fas fa-paper-plane mr-2"></i>Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const form = document.getElementById('applicationForm');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Validate text lengths
            const motivation = form.motivation.value;
            const educational = form.educational_background.value;
            const goals = form.goals.value;

            if (motivation.length < 100) {
                alert('Please provide at least 100 characters for your motivation');
                return;
            }

            if (educational.length < 50) {
                alert('Please provide at least 50 characters for your educational background');
                return;
            }

            if (goals.length < 50) {
                alert('Please provide at least 50 characters for your career goals');
                return;
            }

            // Disable button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Submitting...';

            // Create FormData
            const formData = new FormData(form);

            try {
                const response = await fetch('<?= url('/applications/submit') ?>', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    alert('Application submitted successfully! You will receive a confirmation email shortly.');
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        window.location.href = '<?= url('/dashboard') ?>';
                    }
                } else {
                    alert('Error: ' + data.message);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Submit Application';
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Submit Application';
            }
        });
    </script>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
