<?php
/**
 * AI Tutor Chat Interface
 * 
 * @var array $user Current user
 * @var array $enrollments User's course enrollments
 * @var string $title Page title
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'AI Tutor') ?> | Nebatech AI Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <style>
        .chat-container {
            height: calc(100vh - 200px);
        }
        .message-bubble {
            max-width: 85%;
        }
        .typing-indicator span {
            animation: bounce 1.4s infinite ease-in-out;
        }
        .typing-indicator span:nth-child(1) { animation-delay: -0.32s; }
        .typing-indicator span:nth-child(2) { animation-delay: -0.16s; }
        @keyframes bounce {
            0%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-6px); }
        }
        .persona-card.selected {
            border-color: #6366f1;
            background: linear-gradient(135deg, #4f46e515, #6366f115);
        }
        .markdown-content code {
            background: #1e293b;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.9em;
        }
        .markdown-content pre {
            background: #1e293b;
            padding: 1rem;
            border-radius: 8px;
            overflow-x: auto;
            margin: 1rem 0;
        }
        .markdown-content pre code {
            background: none;
            padding: 0;
        }
        .markdown-content ul {
            list-style: disc;
            margin-left: 1.5rem;
        }
        .markdown-content ol {
            list-style: decimal;
            margin-left: 1.5rem;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100">
    <!-- Header -->
    <header class="bg-gray-800 border-b border-gray-700 px-6 py-4">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            <div class="flex items-center gap-4">
                <a href="/dashboard" class="text-gray-400 hover:text-white transition">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-robot text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold">AI Tutor</h1>
                        <p class="text-xs text-gray-400">Your personal learning assistant</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <!-- Course Context Selector -->
                <select id="courseContext" class="bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="">General Questions</option>
                    <?php foreach ($enrollments as $enrollment): ?>
                    <option value="<?= $enrollment['id'] ?>">
                        <?= htmlspecialchars($enrollment['title']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <div class="flex items-center gap-2 text-sm text-gray-400">
                    <img src="<?= htmlspecialchars($user['avatar'] ?? '/assets/images/default-avatar.png') ?>" 
                         alt="Avatar" class="w-8 h-8 rounded-full">
                    <span><?= htmlspecialchars($user['name'] ?? 'Student') ?></span>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto flex">
        <!-- Sidebar - Persona Selection & Quick Actions -->
        <aside class="w-72 bg-gray-800 border-r border-gray-700 p-4 hidden lg:block">
            <h3 class="text-sm font-semibold text-gray-400 uppercase mb-4">Choose Your Tutor</h3>
            <div id="personaList" class="space-y-3">
                <div class="persona-card selected p-4 bg-gray-700/50 rounded-xl border-2 border-transparent cursor-pointer transition hover:bg-gray-700" data-persona="mentor">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-2xl">👨‍🏫</span>
                        <div>
                            <div class="font-semibold text-white">Abdul-Hafiz</div>
                            <div class="text-xs text-gray-400">Your Mentor</div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400">Supportive guide who asks questions to help you think</p>
                </div>
                <div class="persona-card p-4 bg-gray-700/50 rounded-xl border-2 border-transparent cursor-pointer transition hover:bg-gray-700" data-persona="expert">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-2xl">🔬</span>
                        <div>
                            <div class="font-semibold text-white">Dr. Neba</div>
                            <div class="text-xs text-gray-400">Industry Expert</div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400">Shares real-world insights and best practices</p>
                </div>
                <div class="persona-card p-4 bg-gray-700/50 rounded-xl border-2 border-transparent cursor-pointer transition hover:bg-gray-700" data-persona="peer">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-2xl">🧑‍💻</span>
                        <div>
                            <div class="font-semibold text-white">Abubakari</div>
                            <div class="text-xs text-gray-400">Peer Tutor</div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400">Friendly helper who explains things simply</p>
                </div>
            </div>

            <hr class="border-gray-700 my-6">

            <h3 class="text-sm font-semibold text-gray-400 uppercase mb-4">Quick Actions</h3>
            <div class="space-y-2">
                <button onclick="askQuickQuestion('What should I focus on next?')" 
                        class="w-full text-left px-4 py-3 bg-gray-700/50 rounded-lg text-sm hover:bg-gray-700 transition">
                    <i class="fas fa-compass mr-2 text-indigo-400"></i>
                    Study recommendations
                </button>
                <button onclick="askQuickQuestion('Explain the main concept of this lesson')" 
                        class="w-full text-left px-4 py-3 bg-gray-700/50 rounded-lg text-sm hover:bg-gray-700 transition">
                    <i class="fas fa-lightbulb mr-2 text-yellow-400"></i>
                    Explain current topic
                </button>
                <button onclick="askQuickQuestion('Give me a practical example')" 
                        class="w-full text-left px-4 py-3 bg-gray-700/50 rounded-lg text-sm hover:bg-gray-700 transition">
                    <i class="fas fa-code mr-2 text-green-400"></i>
                    Show me an example
                </button>
                <button onclick="askQuickQuestion('What are common mistakes to avoid?')" 
                        class="w-full text-left px-4 py-3 bg-gray-700/50 rounded-lg text-sm hover:bg-gray-700 transition">
                    <i class="fas fa-exclamation-triangle mr-2 text-red-400"></i>
                    Common mistakes
                </button>
            </div>
        </aside>

        <!-- Main Chat Area -->
        <main class="flex-1 flex flex-col">
            <!-- Chat Messages -->
            <div id="chatContainer" class="chat-container overflow-y-auto p-6 space-y-6">
                <!-- Welcome Message -->
                <div class="message-bubble bg-gradient-to-br from-indigo-600/20 to-purple-600/20 border border-indigo-500/30 rounded-2xl p-6 mx-auto max-w-2xl text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-robot text-3xl text-white"></i>
                    </div>
                    <h2 class="text-xl font-semibold mb-2">Hello, <?= htmlspecialchars($user['first_name'] ?? 'there') ?>! 👋</h2>
                    <p class="text-gray-400 mb-4">
                        I'm your AI Tutor, here to help you learn and grow. Ask me anything about your courses, 
                        get hints for exercises, or explore new concepts. I'll guide you without giving away the answers!
                    </p>
                    <div class="flex flex-wrap justify-center gap-2">
                        <button onclick="askQuickQuestion('How can you help me learn?')" 
                                class="px-4 py-2 bg-gray-700 rounded-lg text-sm hover:bg-gray-600 transition">
                            How can you help?
                        </button>
                        <button onclick="askQuickQuestion('What am I currently learning?')" 
                                class="px-4 py-2 bg-gray-700 rounded-lg text-sm hover:bg-gray-600 transition">
                            My learning progress
                        </button>
                    </div>
                </div>
            </div>

            <!-- Typing Indicator (hidden by default) -->
            <div id="typingIndicator" class="hidden px-6 pb-2">
                <div class="flex items-center gap-3 text-gray-400">
                    <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-robot text-sm"></i>
                    </div>
                    <div class="typing-indicator flex gap-1">
                        <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                    </div>
                    <span class="text-sm">Thinking...</span>
                </div>
            </div>

            <!-- Input Area -->
            <div class="border-t border-gray-700 p-4 bg-gray-800">
                <form id="chatForm" class="flex gap-4 max-w-4xl mx-auto">
                    <div class="flex-1 relative">
                        <textarea id="messageInput" 
                                  placeholder="Ask me anything about your learning journey..."
                                  rows="1"
                                  class="w-full bg-gray-700 border border-gray-600 rounded-xl px-4 py-3 pr-12 focus:ring-2 focus:ring-indigo-500 focus:outline-none resize-none"
                                  onkeydown="handleKeyPress(event)"></textarea>
                        <button type="button" onclick="toggleVoiceInput()" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white transition">
                            <i class="fas fa-microphone"></i>
                        </button>
                    </div>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl font-semibold hover:from-indigo-500 hover:to-purple-500 transition flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            id="sendButton">
                        <span>Send</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
                <p class="text-center text-xs text-gray-500 mt-2">
                    AI responses are for learning purposes. Always verify important information.
                </p>
            </div>
        </main>
    </div>

    <script>
        // State
        let currentPersona = 'mentor';
        let currentCourseId = null;
        let currentLessonId = null;
        let isProcessing = false;

        // Get lesson_id from URL if present
        const urlParams = new URLSearchParams(window.location.search);
        currentLessonId = urlParams.get('lesson') ? parseInt(urlParams.get('lesson')) : null;

        // DOM Elements
        const chatContainer = document.getElementById('chatContainer');
        const messageInput = document.getElementById('messageInput');
        const chatForm = document.getElementById('chatForm');
        const typingIndicator = document.getElementById('typingIndicator');
        const sendButton = document.getElementById('sendButton');
        const courseContext = document.getElementById('courseContext');

        // Persona selection
        document.querySelectorAll('.persona-card').forEach(card => {
            card.addEventListener('click', () => {
                document.querySelectorAll('.persona-card').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                currentPersona = card.dataset.persona;
            });
        });

        // Course context change
        courseContext.addEventListener('change', (e) => {
            currentCourseId = e.target.value || null;
        });

        // Form submit
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = messageInput.value.trim();
            if (!message || isProcessing) return;
            await sendMessage(message);
        });

        // Handle Enter key
        function handleKeyPress(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                chatForm.dispatchEvent(new Event('submit'));
            }
        }

        // Quick question
        function askQuickQuestion(question) {
            messageInput.value = question;
            chatForm.dispatchEvent(new Event('submit'));
        }

        // Send message
        async function sendMessage(message) {
            if (isProcessing) return;
            isProcessing = true;

            // Add user message to chat
            addMessage(message, 'user');
            messageInput.value = '';
            messageInput.style.height = 'auto';

            // Show typing indicator
            typingIndicator.classList.remove('hidden');
            sendButton.disabled = true;
            chatContainer.scrollTop = chatContainer.scrollHeight;

            try {
                const response = await fetch('<?= url('/test-chat-direct.php') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        message: message,
                        persona: currentPersona,
                        course_id: currentCourseId,
                        lesson_id: currentLessonId
                    })
                });

                const data = await response.json();

                if (data.success) {
                    addMessage(data.answer, 'tutor', data.tutor_name);
                    
                    // Show follow-up suggestions if available
                    if (data.follow_up_suggestions && data.follow_up_suggestions.length > 0) {
                        addSuggestions(data.follow_up_suggestions);
                    }
                } else {
                    addMessage(data.error || 'Sorry, I encountered an issue. Please try again.', 'tutor', 'AI Tutor');
                }
            } catch (error) {
                console.error('Chat error:', error);
                addMessage('Sorry, I\'m having trouble connecting. Please try again.', 'tutor', 'AI Tutor');
            } finally {
                typingIndicator.classList.add('hidden');
                sendButton.disabled = false;
                isProcessing = false;
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        }

        // Add message to chat
        function addMessage(content, type, tutorName = '') {
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex ${type === 'user' ? 'justify-end' : 'justify-start'}`;

            if (type === 'user') {
                messageDiv.innerHTML = `
                    <div class="message-bubble bg-indigo-600 rounded-2xl rounded-br-md px-5 py-3">
                        <p class="text-white">${escapeHtml(content)}</p>
                    </div>
                `;
            } else {
                // Parse markdown for tutor responses
                const parsedContent = marked.parse(content);
                messageDiv.innerHTML = `
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-robot text-sm text-white"></i>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400 mb-1">${tutorName}</div>
                            <div class="message-bubble bg-gray-700 rounded-2xl rounded-tl-md px-5 py-3">
                                <div class="markdown-content text-gray-100">${parsedContent}</div>
                            </div>
                        </div>
                    </div>
                `;
            }

            chatContainer.appendChild(messageDiv);
        }

        // Add follow-up suggestions
        function addSuggestions(suggestions) {
            const suggestDiv = document.createElement('div');
            suggestDiv.className = 'flex gap-2 flex-wrap pl-11';
            
            suggestions.forEach(suggestion => {
                const btn = document.createElement('button');
                btn.className = 'px-3 py-1.5 bg-gray-700 border border-gray-600 rounded-lg text-sm hover:bg-gray-600 transition';
                btn.textContent = suggestion;
                btn.onclick = () => {
                    suggestDiv.remove();
                    askQuickQuestion(suggestion);
                };
                suggestDiv.appendChild(btn);
            });
            
            chatContainer.appendChild(suggestDiv);
        }

        // Escape HTML
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Voice input (placeholder)
        function toggleVoiceInput() {
            alert('Voice input coming soon! For now, please type your question.');
        }

        // Auto-resize textarea
        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });
    </script>
</body>
</html>
