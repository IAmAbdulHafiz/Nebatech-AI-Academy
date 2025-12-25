<!-- AI Tutor Floating Chat Widget -->
<!-- Include this partial in layouts where AI tutor should be available -->

<div x-data="aiTutorWidget()" 
     x-init="init()"
     class="fixed bottom-6 right-6 z-50"
     @keydown.escape.window="isOpen && toggleChat()">
    
    <!-- Floating Button -->
    <button @click="toggleChat()"
            class="group relative flex items-center justify-center w-14 h-14 rounded-full shadow-lg transition-all duration-300 transform hover:scale-110"
            :class="isOpen ? 'bg-red-500 hover:bg-red-600' : 'bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700'"
            :aria-expanded="isOpen"
            aria-label="AI Tutor">
        
        <!-- Robot Icon (when closed) -->
        <svg x-show="!isOpen" class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        
        <!-- Close Icon (when open) -->
        <svg x-show="isOpen" x-cloak class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        
        <!-- Notification Badge -->
        <span x-show="unreadCount > 0 && !isOpen" x-cloak
              class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full animate-pulse">
            <span x-text="unreadCount > 9 ? '9+' : unreadCount"></span>
        </span>
        
        <!-- Tooltip -->
        <span class="absolute right-full mr-3 px-3 py-1.5 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
            <span x-text="isOpen ? 'Close AI Tutor' : 'Chat with AI Tutor'"></span>
        </span>
    </button>

    <!-- Chat Panel -->
    <div x-show="isOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 transform scale-95 translate-y-4"
         class="absolute bottom-20 right-0 w-96 max-w-[calc(100vw-2rem)] bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-violet-600 to-indigo-600 px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-semibold">AI Tutor</h3>
                    <p class="text-white/70 text-xs flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full" :class="isConnected ? 'bg-green-400' : 'bg-yellow-400'"></span>
                        <span x-text="isConnected ? 'Online' : 'Connecting...'"></span>
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <!-- Menu Button -->
                <div class="relative" x-data="{ showMenu: false }">
                    <button @click="showMenu = !showMenu" 
                            class="p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="showMenu" 
                         x-cloak
                         @click.away="showMenu = false"
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-lg shadow-lg py-1 z-50">
                        <button @click="clearChat(); showMenu = false" 
                                class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Clear Chat
                        </button>
                        <button @click="showHistory(); showMenu = false" 
                                class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            History
                        </button>
                        <hr class="my-1 border-gray-200 dark:border-gray-600">
                        <button @click="showSettings(); showMenu = false" 
                                class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Bar -->
        <div class="px-4 py-2 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
            <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-hide">
                <button @click="quickAction('explain')" 
                        class="flex-shrink-0 px-3 py-1.5 text-xs font-medium text-violet-700 dark:text-violet-300 bg-violet-100 dark:bg-violet-900/30 rounded-full hover:bg-violet-200 dark:hover:bg-violet-900/50 transition-colors flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Explain
                </button>
                <button @click="quickAction('example')" 
                        class="flex-shrink-0 px-3 py-1.5 text-xs font-medium text-indigo-700 dark:text-indigo-300 bg-indigo-100 dark:bg-indigo-900/30 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-900/50 transition-colors flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                    Example
                </button>
                <button @click="quickAction('practice')" 
                        class="flex-shrink-0 px-3 py-1.5 text-xs font-medium text-emerald-700 dark:text-emerald-300 bg-emerald-100 dark:bg-emerald-900/30 rounded-full hover:bg-emerald-200 dark:hover:bg-emerald-900/50 transition-colors flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Practice
                </button>
                <button @click="quickAction('hint')" 
                        class="flex-shrink-0 px-3 py-1.5 text-xs font-medium text-amber-700 dark:text-amber-300 bg-amber-100 dark:bg-amber-900/30 rounded-full hover:bg-amber-200 dark:hover:bg-amber-900/50 transition-colors flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    Hint
                </button>
                <button @click="quickAction('summary')" 
                        class="flex-shrink-0 px-3 py-1.5 text-xs font-medium text-pink-700 dark:text-pink-300 bg-pink-100 dark:bg-pink-900/30 rounded-full hover:bg-pink-200 dark:hover:bg-pink-900/50 transition-colors flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"/>
                    </svg>
                    Summary
                </button>
            </div>
        </div>

        <!-- Messages Area -->
        <div x-ref="messagesContainer" 
             class="h-80 overflow-y-auto p-4 space-y-4 scroll-smooth">
            
            <!-- Welcome Message -->
            <template x-if="messages.length === 0">
                <div class="text-center py-8">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-violet-100 to-indigo-100 dark:from-violet-900/30 dark:to-indigo-900/30 flex items-center justify-center">
                        <svg class="w-8 h-8 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Hello! I'm your AI Tutor</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 max-w-xs mx-auto">
                        I'm here to help you learn. Ask me anything about your lessons, or use the quick actions above!
                    </p>
                </div>
            </template>

            <!-- Message List -->
            <template x-for="(message, index) in messages" :key="index">
                <div :class="message.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="message.role === 'user' 
                        ? 'bg-violet-600 text-white rounded-2xl rounded-tr-md max-w-[85%]' 
                        : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded-2xl rounded-tl-md max-w-[85%]'"
                         class="px-4 py-3 shadow-sm">
                        
                        <!-- Message Content -->
                        <div x-html="formatMessage(message.content)" class="prose prose-sm dark:prose-invert max-w-none"></div>
                        
                        <!-- Timestamp -->
                        <p :class="message.role === 'user' ? 'text-violet-200' : 'text-gray-400 dark:text-gray-500'"
                           class="text-xs mt-2" x-text="formatTime(message.timestamp)"></p>
                        
                        <!-- Suggestions -->
                        <template x-if="message.suggestions && message.suggestions.length > 0">
                            <div class="mt-3 pt-3 border-t" :class="message.role === 'user' ? 'border-violet-500' : 'border-gray-200 dark:border-gray-600'">
                                <p class="text-xs font-medium mb-2" :class="message.role === 'user' ? 'text-violet-200' : 'text-gray-500 dark:text-gray-400'">
                                    Suggested questions:
                                </p>
                                <div class="flex flex-wrap gap-1">
                                    <template x-for="suggestion in message.suggestions" :key="suggestion">
                                        <button @click="sendMessage(suggestion)"
                                                class="text-xs px-2 py-1 rounded-full transition-colors"
                                                :class="message.role === 'user' 
                                                    ? 'bg-violet-500 hover:bg-violet-400 text-white' 
                                                    : 'bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200'">
                                            <span x-text="suggestion"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="isTyping" x-cloak class="flex justify-start">
                <div class="bg-gray-100 dark:bg-gray-700 rounded-2xl rounded-tl-md px-4 py-3">
                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                    </div>
                </div>
            </div>

            <!-- Error Message -->
            <div x-show="error" x-cloak class="flex justify-center">
                <div class="bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg px-4 py-2 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span x-text="error"></span>
                    <button @click="error = null" class="text-red-700 dark:text-red-300 hover:text-red-900 dark:hover:text-red-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <form @submit.prevent="handleSubmit()" class="flex items-end gap-2">
                <div class="flex-1 relative">
                    <textarea x-ref="messageInput"
                              x-model="inputMessage"
                              @keydown.enter.prevent="if (!$event.shiftKey) handleSubmit()"
                              placeholder="Ask me anything..."
                              rows="1"
                              class="w-full resize-none rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 px-4 py-3 pr-10 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                              :disabled="isTyping"
                              style="max-height: 120px;"></textarea>
                    
                    <!-- Character Counter -->
                    <span x-show="inputMessage.length > 200" 
                          class="absolute right-3 bottom-3 text-xs"
                          :class="inputMessage.length > 500 ? 'text-red-500' : 'text-gray-400'">
                        <span x-text="inputMessage.length"></span>/500
                    </span>
                </div>
                
                <button type="submit"
                        :disabled="!inputMessage.trim() || isTyping || inputMessage.length > 500"
                        class="flex-shrink-0 w-11 h-11 rounded-xl bg-violet-600 text-white flex items-center justify-center transition-all hover:bg-violet-700 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-violet-600">
                    <svg x-show="!isTyping" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    <svg x-show="isTyping" x-cloak class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>
            
            <!-- Usage Info -->
            <div class="mt-2 flex items-center justify-between text-xs text-gray-400">
                <span>Press Enter to send, Shift+Enter for new line</span>
                <span x-show="dailyUsage" x-text="dailyUsage + '/50 messages today'"></span>
            </div>
        </div>
    </div>
</div>

<script>
function aiTutorWidget() {
    return {
        isOpen: false,
        isConnected: true,
        isTyping: false,
        messages: [],
        inputMessage: '',
        sessionId: null,
        unreadCount: 0,
        error: null,
        dailyUsage: null,
        
        // Context from the current page
        context: {
            lesson_id: null,
            course_id: null,
            module_id: null
        },
        
        init() {
            // Load context from page if available
            this.context.lesson_id = window.currentLessonId || null;
            this.context.course_id = window.currentCourseId || null;
            this.context.module_id = window.currentModuleId || null;
            
            // Load saved messages from localStorage
            this.loadMessages();
            
            // Check for session
            this.sessionId = localStorage.getItem('ai_tutor_session_id');
            
            // Auto-resize textarea
            this.$watch('inputMessage', () => {
                this.$nextTick(() => {
                    const textarea = this.$refs.messageInput;
                    if (textarea) {
                        textarea.style.height = 'auto';
                        textarea.style.height = Math.min(textarea.scrollHeight, 120) + 'px';
                    }
                });
            });
        },
        
        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.unreadCount = 0;
                this.$nextTick(() => {
                    this.$refs.messageInput?.focus();
                    this.scrollToBottom();
                });
            }
        },
        
        async handleSubmit() {
            if (!this.inputMessage.trim() || this.isTyping) return;
            if (this.inputMessage.length > 500) {
                this.error = 'Message is too long (max 500 characters)';
                return;
            }
            
            await this.sendMessage(this.inputMessage);
            this.inputMessage = '';
        },
        
        async sendMessage(message) {
            this.error = null;
            
            // Add user message
            this.messages.push({
                role: 'user',
                content: message,
                timestamp: new Date()
            });
            
            this.saveMessages();
            this.scrollToBottom();
            this.isTyping = true;
            
            try {
                const response = await fetch('<?= url('/test-chat-direct.php') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        message: message,
                        session_id: this.sessionId,
                        lesson_id: this.context.lesson_id,
                        course_id: this.context.course_id,
                        module_id: this.context.module_id
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Add AI response (use 'answer' from our endpoint)
                    this.messages.push({
                        role: 'assistant',
                        content: data.answer || data.response,
                        timestamp: new Date(),
                        suggestions: data.follow_up_suggestions || data.suggestions || []
                    });
                    
                    this.saveMessages();
                    
                    if (!this.isOpen) {
                        this.unreadCount++;
                    }
                } else {
                    if (data.limit_reached) {
                        this.error = 'Daily limit reached. Try again tomorrow!';
                    } else {
                        this.error = data.error || 'Failed to get response';
                    }
                }
            } catch (err) {
                console.error('AI Tutor Error:', err);
                this.error = 'Connection error. Please try again.';
            } finally {
                this.isTyping = false;
                this.scrollToBottom();
            }
        },
        
        async quickAction(action) {
            this.error = null;
            this.isTyping = true;
            
            try {
                // Map action to a message
                const actionMessages = {
                    'explain': 'Please explain this concept in detail',
                    'example': 'Can you show me a practical example?',
                    'practice': 'Generate some practice problems for me',
                    'hint': 'Give me a hint to help me understand',
                    'summary': 'Summarize what I should learn from this lesson'
                };
                const message = actionMessages[action] || action;
                
                const response = await fetch('<?= url('/test-chat-direct.php') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        message: message,
                        lesson_id: this.context.lesson_id,
                        course_id: this.context.course_id
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Add action message
                    const actionLabels = {
                        'explain': 'Explain this concept',
                        'example': 'Show me an example',
                        'practice': 'Generate practice problems',
                        'hint': 'Give me a hint',
                        'summary': 'Summarize this lesson'
                    };
                    
                    this.messages.push({
                        role: 'user',
                        content: actionLabels[action] || action,
                        timestamp: new Date()
                    });
                    
                    // Add AI response (use 'answer' from our endpoint)
                    this.messages.push({
                        role: 'assistant',
                        content: data.answer || data.response,
                        timestamp: new Date(),
                        suggestions: data.follow_up_suggestions || data.suggestions || []
                    });
                    
                    this.saveMessages();
                } else {
                    this.error = data.error || 'Failed to perform action';
                }
            } catch (err) {
                console.error('Quick Action Error:', err);
                this.error = 'Connection error. Please try again.';
            } finally {
                this.isTyping = false;
                this.scrollToBottom();
            }
        },
        
        clearChat() {
            this.messages = [];
            this.sessionId = null;
            localStorage.removeItem('ai_tutor_messages');
            localStorage.removeItem('ai_tutor_session_id');
        },
        
        showHistory() {
            // Could open a modal with full conversation history
            window.location.href = '/dashboard/ai-history';
        },
        
        showSettings() {
            // Could open a modal with AI tutor settings
            window.location.href = '/dashboard/settings#ai-tutor';
        },
        
        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.messagesContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });
        },
        
        saveMessages() {
            // Keep only last 50 messages in localStorage
            const messagesToSave = this.messages.slice(-50);
            localStorage.setItem('ai_tutor_messages', JSON.stringify(messagesToSave));
        },
        
        loadMessages() {
            try {
                const saved = localStorage.getItem('ai_tutor_messages');
                if (saved) {
                    this.messages = JSON.parse(saved).map(msg => ({
                        ...msg,
                        timestamp: new Date(msg.timestamp)
                    }));
                }
            } catch (e) {
                console.error('Error loading messages:', e);
            }
        },
        
        formatMessage(content) {
            if (!content) return '';
            
            // Convert markdown-style code blocks
            content = content.replace(/```(\w+)?\n([\s\S]*?)```/g, (match, lang, code) => {
                return `<pre class="bg-gray-800 text-gray-100 rounded-lg p-3 my-2 overflow-x-auto text-xs"><code class="language-${lang || 'text'}">${this.escapeHtml(code.trim())}</code></pre>`;
            });
            
            // Convert inline code
            content = content.replace(/`([^`]+)`/g, '<code class="bg-gray-200 dark:bg-gray-600 px-1 rounded text-sm">$1</code>');
            
            // Convert bold
            content = content.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');
            
            // Convert italic
            content = content.replace(/\*([^*]+)\*/g, '<em>$1</em>');
            
            // Convert line breaks
            content = content.replace(/\n/g, '<br>');
            
            return content;
        },
        
        escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        },
        
        formatTime(timestamp) {
            if (!timestamp) return '';
            const date = new Date(timestamp);
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }
    };
}
</script>

<style>
[x-cloak] { display: none !important; }

.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
