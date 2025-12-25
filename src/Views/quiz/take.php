<?php
/**
 * Quiz Taking View
 * 
 * @var array $quiz Quiz data
 * @var array $questions Quiz questions
 * @var array $lesson Associated lesson
 * @var array $course Associated course
 */

$quizTitle = $quiz['title'] ?? 'Quiz';
$timeLimit = $quiz['time_limit_minutes'] ?? 0;
$questionCount = count($questions);

// Prepare config for JavaScript
$quizConfig = [
    'quizId' => $quiz['id'],
    'questions' => $questions,
    'timeLimit' => $timeLimit,
    'passingScore' => $quiz['passing_score'] ?? 70,
    'shuffleQuestions' => (bool)($quiz['shuffle_questions'] ?? false),
    'shuffleAnswers' => (bool)($quiz['shuffle_answers'] ?? false)
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($quizTitle) ?> | Nebatech AI Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        window.quizConfig = <?= json_encode($quizConfig, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) ?>;
        // Extract base URL from current page URL (remove /quiz/XXXX)
        window.baseUrl = window.location.pathname.replace(/\/quiz\/\d+.*$/, '');
        console.log('Current pathname:', window.location.pathname);
        console.log('Extracted baseUrl:', window.baseUrl);
    </script>
</head>
<body class="bg-gray-100 min-h-screen">

<div x-data="quizApp()" x-init="init()" class="min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 py-4 px-6 shadow-sm">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
            <div>
                <a href="<?= url('/courses/' . ($course['slug'] ?? '') . '/lesson/' . ($lesson['id'] ?? '')) ?>" 
                   class="text-gray-500 hover:text-gray-700 text-sm mb-1 inline-block">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Lesson
                </a>
                <h1 class="text-xl font-bold text-gray-900"><?= htmlspecialchars($quizTitle) ?></h1>
            </div>
            
            <!-- Timer (if time limit) -->
            <?php if ($timeLimit > 0): ?>
            <div x-show="!quizCompleted" class="flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-lg">
                <i class="fas fa-clock" :class="timeRemaining < 60 ? 'text-red-500' : 'text-gray-500'"></i>
                <span x-text="formatTime(timeRemaining)" 
                      :class="timeRemaining < 60 ? 'text-red-600 font-bold' : 'text-gray-700'"
                      class="font-mono text-lg"></span>
            </div>
            <?php endif; ?>
        </div>
    </header>

    <!-- Quiz Progress -->
    <div class="bg-white border-b border-gray-200 py-3 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-600">Question <span x-text="currentQuestionIndex + 1"></span> of <?= $questionCount ?></span>
                <span class="text-sm text-gray-600">
                    <span x-text="answeredCount"></span> answered
                </span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-indigo-600 h-2 rounded-full transition-all duration-300"
                     :style="{ width: ((currentQuestionIndex + 1) / <?= $questionCount ?> * 100) + '%' }"></div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 py-8 px-6">
        <div class="max-w-4xl mx-auto">
            
            <!-- Quiz In Progress -->
            <template x-if="!quizCompleted">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <!-- Question Display -->
                    <div class="p-8">
                        <div class="flex items-start gap-4 mb-6">
                            <span class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold flex-shrink-0"
                                  x-text="currentQuestionIndex + 1"></span>
                            <div class="flex-1">
                                <p class="text-lg text-gray-900 font-medium" x-text="currentQuestion.question_text"></p>
                                
                                <!-- Code Block (if question has code) -->
                                <template x-if="currentQuestion.question_code">
                                    <pre class="mt-4 bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto text-sm"><code x-text="currentQuestion.question_code"></code></pre>
                                </template>
                            </div>
                        </div>

                        <!-- Answer Options -->
                        <div class="space-y-3 ml-14">
                            <template x-for="(option, optionIndex) in currentQuestion.options" :key="optionIndex">
                                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-indigo-300 hover:bg-indigo-50"
                                       :class="answers[currentQuestionIndex] == optionIndex ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200'"
                                       @click.prevent="selectAnswer(optionIndex)">
                                    <input type="radio" 
                                           :name="'question_' + currentQuestionIndex"
                                           :value="optionIndex"
                                           :checked="answers[currentQuestionIndex] == optionIndex"
                                           class="hidden">
                                    <span class="w-6 h-6 rounded-full border-2 flex items-center justify-center mr-3 flex-shrink-0"
                                          :class="answers[currentQuestionIndex] == optionIndex ? 'border-indigo-500 bg-indigo-500' : 'border-gray-300'">
                                        <i x-show="answers[currentQuestionIndex] == optionIndex" 
                                           class="fas fa-check text-white text-xs"></i>
                                    </span>
                                    <span class="text-gray-700" x-text="option"></span>
                                </label>
                            </template>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="bg-gray-50 px-8 py-4 flex items-center justify-between border-t border-gray-200">
                        <button @click="previousQuestion()" 
                                :disabled="currentQuestionIndex === 0"
                                class="px-6 py-2 text-gray-600 hover:text-gray-900 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-arrow-left mr-2"></i>Previous
                        </button>

                        <template x-if="currentQuestionIndex < questions.length - 1">
                            <button @click="nextQuestion()"
                                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                                Next<i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </template>
                        
                        <template x-if="currentQuestionIndex === questions.length - 1">
                            <button @click="submitQuiz()"
                                    :disabled="answeredCount < questions.length"
                                    class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-check-circle mr-2"></i>Submit Quiz
                            </button>
                        </template>
                    </div>

                    <!-- Question Navigator -->
                    <div class="bg-white border-t border-gray-200 px-8 py-4">
                        <p class="text-sm text-gray-500 mb-3">Jump to question:</p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="(q, i) in questions" :key="i">
                                <button @click="goToQuestion(i)"
                                        class="w-10 h-10 rounded-lg font-semibold transition"
                                        :class="{
                                            'bg-indigo-600 text-white': currentQuestionIndex === i,
                                            'bg-green-100 text-green-700': answers[i] !== null && answers[i] !== undefined && currentQuestionIndex !== i,
                                            'bg-gray-100 text-gray-600 hover:bg-gray-200': (answers[i] === null || answers[i] === undefined) && currentQuestionIndex !== i
                                        }"
                                        x-text="i + 1"></button>
                            </template>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Quiz Results -->
            <template x-if="quizCompleted">
                <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                    <!-- Score Display -->
                    <div class="mb-8">
                        <div class="w-32 h-32 mx-auto mb-6 rounded-full flex items-center justify-center"
                             :class="score >= <?= $quiz['passing_score'] ?? 70 ?> ? 'bg-green-100' : 'bg-yellow-100'">
                            <span class="text-5xl font-bold"
                                  :class="score >= <?= $quiz['passing_score'] ?? 70 ?> ? 'text-green-600' : 'text-yellow-600'"
                                  x-text="score + '%'"></span>
                        </div>
                        
                        <template x-if="score >= <?= $quiz['passing_score'] ?? 70 ?>">
                            <div>
                                <h2 class="text-2xl font-bold text-green-700 mb-2">
                                    <i class="fas fa-trophy mr-2"></i>Congratulations!
                                </h2>
                                <p class="text-gray-600">You passed the quiz! Great job understanding the material.</p>
                            </div>
                        </template>
                        
                        <template x-if="score < <?= $quiz['passing_score'] ?? 70 ?>">
                            <div>
                                <h2 class="text-2xl font-bold text-yellow-700 mb-2">
                                    <i class="fas fa-book-reader mr-2"></i>Keep Learning!
                                </h2>
                                <p class="text-gray-600">You need <?= $quiz['passing_score'] ?? 70 ?>% to pass. Review the lesson and try again.</p>
                            </div>
                        </template>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 mb-8 max-w-md mx-auto">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-2xl font-bold text-gray-900" x-text="correctCount"></div>
                            <div class="text-sm text-gray-500">Correct</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-2xl font-bold text-gray-900" x-text="questions.length - correctCount"></div>
                            <div class="text-sm text-gray-500">Incorrect</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-2xl font-bold text-gray-900" x-text="questions.length"></div>
                            <div class="text-sm text-gray-500">Total</div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-center gap-4">
                        <a href="<?= url('/courses/' . ($course['slug'] ?? '') . '/lesson/' . ($lesson['id'] ?? '')) ?>" 
                           class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Lesson
                        </a>
                        <button @click="resetQuiz()"
                                class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                            <i class="fas fa-redo mr-2"></i>Try Again
                        </button>
                        <a x-show="attemptId"
                           :href="window.baseUrl + '/ai-tutor/quiz-feedback/' + attemptId"
                           class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                            <i class="fas fa-robot mr-2"></i>Get AI Feedback
                        </a>
                    </div>
                </div>
            </template>
        </div>
    </main>
</div>

<script>
function quizApp() {
    const config = window.quizConfig;
    return {
        quizId: config.quizId,
        questions: config.questions,
        timeLimit: config.timeLimit * 60, // Convert to seconds
        passingScore: config.passingScore,
        
        currentQuestionIndex: 0,
        answers: [],
        timeRemaining: config.timeLimit * 60,
        timerInterval: null,
        
        quizCompleted: false,
        score: 0,
        correctCount: 0,
        attemptId: null,
        
        init() {
            // First, parse all options JSON strings
            this.questions = this.questions.map(q => {
                let options = q.options;
                if (typeof options === 'string') {
                    try {
                        options = JSON.parse(options);
                    } catch (e) {
                        console.error('Failed to parse options:', e);
                        options = [];
                    }
                }
                return { ...q, options: options || [] };
            });
            
            // Shuffle questions if enabled
            if (config.shuffleQuestions) {
                this.questions = this.shuffleArray([...this.questions]);
            }
            
            // Shuffle answer options if enabled
            if (config.shuffleAnswers) {
                this.questions = this.questions.map(q => {
                    if (q.options && Array.isArray(q.options)) {
                        return { ...q, options: this.shuffleArray([...q.options]) };
                    }
                    return q;
                });
            }
            
            // Initialize answers array
            this.answers = new Array(this.questions.length).fill(null);
            
            // Start timer if time limit
            if (this.timeLimit > 0) {
                this.startTimer();
            }
        },
        
        get currentQuestion() {
            return this.questions[this.currentQuestionIndex];
        },
        
        get answeredCount() {
            return this.answers.filter(a => a !== null && a !== undefined).length;
        },
        
        shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        },
        
        startTimer() {
            this.timerInterval = setInterval(() => {
                this.timeRemaining--;
                if (this.timeRemaining <= 0) {
                    clearInterval(this.timerInterval);
                    this.submitQuiz();
                }
            }, 1000);
        },
        
        formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        },
        
        selectAnswer(optionIndex) {
            console.log('Selecting answer for Q' + this.currentQuestionIndex + ': optionIndex=' + optionIndex);
            this.answers[this.currentQuestionIndex] = optionIndex;
            console.log('Current answers:', JSON.stringify(this.answers));
        },
        
        previousQuestion() {
            if (this.currentQuestionIndex > 0) {
                this.currentQuestionIndex--;
            }
        },
        
        nextQuestion() {
            if (this.currentQuestionIndex < this.questions.length - 1) {
                this.currentQuestionIndex++;
            }
        },
        
        goToQuestion(index) {
            this.currentQuestionIndex = index;
        },
        
        async submitQuiz() {
            if (this.timerInterval) {
                clearInterval(this.timerInterval);
            }
            
            // Calculate score
            this.correctCount = 0;
            this.questions.forEach((question, index) => {
                const selectedAnswer = this.answers[index];
                if (selectedAnswer !== null) {
                    const options = question.options;
                    const correctAnswer = typeof question.correct_answer === 'string' 
                        ? JSON.parse(question.correct_answer) 
                        : question.correct_answer;
                    
                    if (options[selectedAnswer] === correctAnswer) {
                        this.correctCount++;
                    }
                }
            });
            
            this.score = Math.round((this.correctCount / this.questions.length) * 100);
            
            // Submit to server
            try {
                const submitUrl = window.baseUrl + '/api/quiz/submit';
                console.log('Submitting to:', submitUrl);
                const response = await fetch(submitUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        quiz_id: this.quizId,
                        answers: this.answers,
                        score: this.score,
                        time_taken: (this.timeLimit > 0 ? this.timeLimit - this.timeRemaining : 0)
                    })
                });
                
                console.log('Response status:', response.status);
                const data = await response.json();
                console.log('Response data:', data);
                if (data.success) {
                    this.attemptId = data.attempt_id;
                }
            } catch (error) {
                console.error('Failed to submit quiz:', error);
            }
            
            this.quizCompleted = true;
        },
        
        resetQuiz() {
            this.currentQuestionIndex = 0;
            this.answers = new Array(this.questions.length).fill(null);
            this.quizCompleted = false;
            this.score = 0;
            this.correctCount = 0;
            
            if (this.timeLimit > 0) {
                this.timeRemaining = this.timeLimit;
                this.startTimer();
            }
        }
    }
}
</script>

</body>
</html>
