// Toast Notification System
const Toast = {
    container: null,
    
    init() {
        if (!this.container) {
            this.container = document.createElement('div');
            this.container.id = 'toast-container';
            this.container.className = 'fixed top-20 right-4 z-50 space-y-2 max-w-sm w-full';
            document.body.appendChild(this.container);
        }
    },
    
    show(message, type = 'info', duration = 4000) {
        this.init();
        
        const toast = document.createElement('div');
        toast.className = `transform transition-all duration-300 ease-in-out translate-x-full opacity-0`;
        
        const icons = {
            success: '<i class="fas fa-check-circle"></i>',
            error: '<i class="fas fa-exclamation-circle"></i>',
            warning: '<i class="fas fa-exclamation-triangle"></i>',
            info: '<i class="fas fa-info-circle"></i>'
        };
        
        const colors = {
            success: 'bg-green-50 border-green-500 text-green-800',
            error: 'bg-red-50 border-red-500 text-red-800',
            warning: 'bg-yellow-50 border-yellow-500 text-yellow-800',
            info: 'bg-blue-50 border-blue-500 text-blue-800'
        };
        
        toast.innerHTML = `
            <div class="${colors[type]} border-l-4 rounded-lg shadow-lg p-4 flex items-start gap-3">
                <div class="text-xl flex-shrink-0">${icons[type]}</div>
                <div class="flex-1 text-sm font-medium">${message}</div>
                <button onclick="this.closest('.transform').remove()" class="flex-shrink-0 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        this.container.appendChild(toast);
        
        // Trigger animation
        setTimeout(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
        }, 10);
        
        // Auto remove
        if (duration > 0) {
            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, duration);
        }
        
        return toast;
    },
    
    success(message, duration) {
        return this.show(message, 'success', duration);
    },
    
    error(message, duration) {
        return this.show(message, 'error', duration);
    },
    
    warning(message, duration) {
        return this.show(message, 'warning', duration);
    },
    
    info(message, duration) {
        return this.show(message, 'info', duration);
    }
};

// Modal Confirmation System
const ConfirmModal = {
    modal: null,
    
    init() {
        if (!this.modal) {
            this.modal = document.createElement('div');
            this.modal.id = 'confirm-modal';
            this.modal.className = 'hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
            this.modal.innerHTML = `
                <div class="bg-white rounded-lg max-w-md w-full p-6 transform transition-all duration-300 scale-95 opacity-0" id="confirm-modal-content">
                    <div class="flex items-start gap-4 mb-4">
                        <div id="confirm-icon" class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center text-2xl">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <div class="flex-1">
                            <h3 id="confirm-title" class="text-lg font-bold text-gray-900 mb-2">Confirm Action</h3>
                            <p id="confirm-message" class="text-gray-600"></p>
                        </div>
                    </div>
                    <div class="flex gap-3 justify-end">
                        <button id="confirm-cancel" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                            Cancel
                        </button>
                        <button id="confirm-ok" class="px-4 py-2 rounded-lg transition font-medium">
                            Confirm
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(this.modal);
            
            // Close on overlay click
            this.modal.addEventListener('click', (e) => {
                if (e.target === this.modal) {
                    this.hide(false);
                }
            });
        }
    },
    
    show(message, options = {}) {
        this.init();
        
        const {
            title = 'Confirm Action',
            confirmText = 'Confirm',
            cancelText = 'Cancel',
            type = 'warning', // warning, danger, info, success
            onConfirm = () => {},
            onCancel = () => {}
        } = options;
        
        const types = {
            warning: {
                icon: 'fa-exclamation-triangle',
                iconBg: 'bg-yellow-100 text-yellow-600',
                btnClass: 'bg-yellow-600 hover:bg-yellow-700 text-white'
            },
            danger: {
                icon: 'fa-exclamation-circle',
                iconBg: 'bg-red-100 text-red-600',
                btnClass: 'bg-red-600 hover:bg-red-700 text-white'
            },
            info: {
                icon: 'fa-info-circle',
                iconBg: 'bg-blue-100 text-blue-600',
                btnClass: 'bg-blue-600 hover:bg-blue-700 text-white'
            },
            success: {
                icon: 'fa-check-circle',
                iconBg: 'bg-green-100 text-green-600',
                btnClass: 'bg-green-600 hover:bg-green-700 text-white'
            }
        };
        
        const config = types[type] || types.warning;
        
        // Update content
        document.getElementById('confirm-title').textContent = title;
        document.getElementById('confirm-message').textContent = message;
        document.getElementById('confirm-icon').className = `flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center text-2xl ${config.iconBg}`;
        document.getElementById('confirm-icon').innerHTML = `<i class="fas ${config.icon}"></i>`;
        document.getElementById('confirm-ok').textContent = confirmText;
        document.getElementById('confirm-ok').className = `px-4 py-2 rounded-lg transition font-medium ${config.btnClass}`;
        document.getElementById('confirm-cancel').textContent = cancelText;
        
        // Set up handlers
        const handleConfirm = () => {
            this.hide(true);
            onConfirm();
        };
        
        const handleCancel = () => {
            this.hide(false);
            onCancel();
        };
        
        // Remove old listeners
        const okBtn = document.getElementById('confirm-ok');
        const cancelBtn = document.getElementById('confirm-cancel');
        const newOkBtn = okBtn.cloneNode(true);
        const newCancelBtn = cancelBtn.cloneNode(true);
        okBtn.parentNode.replaceChild(newOkBtn, okBtn);
        cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
        
        // Add new listeners
        newOkBtn.addEventListener('click', handleConfirm);
        newCancelBtn.addEventListener('click', handleCancel);
        
        // Show modal
        this.modal.classList.remove('hidden');
        setTimeout(() => {
            const content = document.getElementById('confirm-modal-content');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        // Return promise for async/await usage
        return new Promise((resolve) => {
            const okBtn = document.getElementById('confirm-ok');
            const cancelBtn = document.getElementById('confirm-cancel');
            
            const handleResolve = (result) => {
                this.hide(result);
                resolve(result);
            };
            
            okBtn.onclick = () => handleResolve(true);
            cancelBtn.onclick = () => handleResolve(false);
        });
    },
    
    hide(result) {
        const content = document.getElementById('confirm-modal-content');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            this.modal.classList.add('hidden');
        }, 300);
    }
};

// Global helper functions for backward compatibility
window.showToast = (message, type, duration) => Toast.show(message, type, duration);
window.showSuccess = (message, duration) => Toast.success(message, duration);
window.showError = (message, duration) => Toast.error(message, duration);
window.showWarning = (message, duration) => Toast.warning(message, duration);
window.showInfo = (message, duration) => Toast.info(message, duration);
window.confirmAction = (message, options) => ConfirmModal.show(message, options);

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { Toast, ConfirmModal };
}
