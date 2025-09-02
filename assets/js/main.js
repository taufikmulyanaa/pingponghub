document.addEventListener('DOMContentLoaded', () => {
    console.log('PingPong+ App initialized successfully!');

    // Initialize Lucide Icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // === LIVE SEARCH FOR CLUBS ===
    initClubSearch();
    
    // === PLAYER FILTER FUNCTIONALITY ===
    initPlayerFilters();
    
    // === NOTIFICATION SYSTEM ===
    initNotifications();
    
    // === SMOOTH SCROLLING ===
    initSmoothScrolling();
    
    // === LOADING STATES ===
    initLoadingStates();
    
    // === TOOLTIPS ===
    initTooltips();
    
    // === ANIMATIONS ===
    initAnimations();
});

/**
 * Initialize club search functionality
 */
function initClubSearch() {
    const searchInput = document.getElementById('club-search-input');
    const clubListContainer = document.getElementById('club-list-container');
    
    if (!searchInput || !clubListContainer) return;
    
    let searchTimeout;
    
    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.trim();
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        // Debounce search for better performance
        searchTimeout = setTimeout(() => {
            if (query.length === 0) {
                // Reset to show all clubs if search is empty
                location.reload();
                return;
            }
            
            if (query.length < 2) return; // Minimum 2 characters
            
            performClubSearch(query, clubListContainer);
        }, 300);
    });
}

/**
 * Perform club search API call
 */
async function performClubSearch(query, container) {
    try {
        showLoadingState(container, 'Searching clubs...');
        
        const response = await fetch(`api/search_clubs.php?q=${encodeURIComponent(query)}`);
        const html = await response.text();
        
        container.innerHTML = html;
        
        // Reinitialize icons for new content
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        
        // Add fade-in animation
        container.classList.add('fade-in');
        
    } catch (error) {
        console.error('Club search error:', error);
        showErrorState(container, 'Failed to search clubs. Please try again.');
    }
}

/**
 * Initialize player filter functionality
 */
function initPlayerFilters() {
    const filterButtons = document.querySelectorAll('.player-filter-btn, .filter-btn');
    const playerListContainer = document.getElementById('player-list-container');
    const resultsHeader = document.getElementById('player-results-header');
    
    if (filterButtons.length === 0 || !playerListContainer) return;
    
    filterButtons.forEach(button => {
        button.addEventListener('click', async () => {
            // Update active button state with animation
            filterButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.style.transform = 'scale(1)';
            });
            button.classList.add('active');
            button.style.transform = 'scale(0.95)';
            setTimeout(() => button.style.transform = 'scale(1)', 150);
            
            const filter = button.dataset.filter;
            
            try {
                showLoadingState(playerListContainer, 'Loading players...');
                
                const response = await fetch(`api/filter_players.php?filter=${filter}`);
                const html = await response.text();
                
                playerListContainer.innerHTML = html;
                
                // Update header with results count
                updateResultsHeader(playerListContainer, resultsHeader, button.textContent);
                
                // Reinitialize icons
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
                
                // Add slide-up animation
                playerListContainer.classList.add('slide-up');
                
            } catch (error) {
                console.error('Player filter error:', error);
                showErrorState(playerListContainer, 'Failed to load players. Please try again.');
            }
        });
    });
}

/**
 * Update results header with count
 */
function updateResultsHeader(container, header, filterName) {
    if (!header) return;
    
    const countEl = container.querySelector('#player-count');
    if (countEl) {
        const count = countEl.dataset.count;
        header.innerHTML = `
            <span class="font-semibold">${filterName}</span>
            <span class="text-muted-foreground font-normal">(${count} found)</span>
        `;
        countEl.remove();
    }
}

/**
 * Initialize notification system
 */
function initNotifications() {
    // Check for notification permission
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission();
    }
    
    // Initialize notification click handlers
    const notificationBtns = document.querySelectorAll('[data-notification]');
    notificationBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            showNotification(btn.dataset.notification, btn.dataset.message || 'New notification');
        });
    });
}

/**
 * Show browser notification
 */
function showNotification(title, message) {
    if ('Notification' in window && Notification.permission === 'granted') {
        new Notification(title, {
            body: message,
            icon: '/favicon.ico',
            badge: '/favicon.ico'
        });
    }
}

/**
 * Initialize smooth scrolling for anchor links
 */
function initSmoothScrolling() {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    
    anchorLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = link.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

/**
 * Initialize loading states for dynamic content
 */
function initLoadingStates() {
    const dynamicButtons = document.querySelectorAll('[data-dynamic-load]');
    
    dynamicButtons.forEach(button => {
        button.addEventListener('click', () => {
            showButtonLoading(button);
        });
    });
}

/**
 * Initialize tooltips
 */
function initTooltips() {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', showTooltip);
        element.addEventListener('mouseleave', hideTooltip);
    });
}

/**
 * Initialize animations
 */
function initAnimations() {
    // Add intersection observer for scroll animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, { threshold: 0.1 });
    
    // Observe cards and major elements
    document.querySelectorAll('.card, .tournament-card, .venue-card, .club-card').forEach(el => {
        observer.observe(el);
    });
}

/**
 * Show loading state in container
 */
function showLoadingState(container, message = 'Loading...') {
    container.innerHTML = `
        <div class="flex flex-col items-center justify-center p-12 text-muted-foreground">
            <div class="relative">
                <div class="animate-spin rounded-full h-12 w-12 border-4 border-orange-200"></div>
                <div class="animate-spin rounded-full h-12 w-12 border-4 border-orange-500 border-t-transparent absolute top-0 left-0" style="animation-delay: 0.15s"></div>
            </div>
            <p class="text-sm mt-4 font-medium">${message}</p>
        </div>
    `;
}

/**
 * Show error state in container
 */
function showErrorState(container, message = 'Something went wrong') {
    container.innerHTML = `
        <div class="flex flex-col items-center justify-center p-12 text-red-500">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <i data-lucide="alert-circle" class="w-8 h-8"></i>
            </div>
            <h4 class="text-lg font-semibold text-foreground mb-2">Oops!</h4>
            <p class="text-sm text-center text-muted-foreground mb-6">${message}</p>
            <button onclick="location.reload()" class="btn btn-secondary">
                <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i>
                Try Again
            </button>
        </div>
    `;
    
    // Reinitialize icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

/**
 * Show loading state for buttons
 */
function showButtonLoading(button) {
    const originalText = button.innerHTML;
    button.disabled = true;
    button.classList.add('opacity-70');
    button.innerHTML = `
        <div class="flex items-center">
            <div class="animate-spin rounded-full h-4 w-4 border-2 border-current border-t-transparent mr-2"></div>
            <span>Loading...</span>
        </div>
    `;
    
    // Reset after 3 seconds
    setTimeout(() => {
        button.disabled = false;
        button.classList.remove('opacity-70');
        button.innerHTML = originalText;
        
        // Reinitialize icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }, 3000);
}

/**
 * Show tooltip
 */
function showTooltip(e) {
    const text = e.target.getAttribute('data-tooltip');
    const tooltip = document.createElement('div');
    tooltip.className = 'fixed bg-gray-900 text-white text-xs px-3 py-2 rounded-lg shadow-lg z-50 pointer-events-none max-w-xs';
    tooltip.textContent = text;
    tooltip.id = 'tooltip';
    
    document.body.appendChild(tooltip);
    
    const rect = e.target.getBoundingClientRect();
    const tooltipRect = tooltip.getBoundingClientRect();
    
    // Position tooltip
    let left = rect.left + rect.width / 2 - tooltipRect.width / 2;
    let top = rect.top - tooltipRect.height - 8;
    
    // Keep tooltip within viewport
    if (left < 8) left = 8;
    if (left + tooltipRect.width > window.innerWidth - 8) {
        left = window.innerWidth - tooltipRect.width - 8;
    }
    if (top < 8) {
        top = rect.bottom + 8;
    }
    
    tooltip.style.left = left + 'px';
    tooltip.style.top = top + 'px';
    
    // Add fade-in animation
    tooltip.style.opacity = '0';
    tooltip.style.transform = 'translateY(4px)';
    setTimeout(() => {
        tooltip.style.transition = 'opacity 0.2s, transform 0.2s';
        tooltip.style.opacity = '1';
        tooltip.style.transform = 'translateY(0)';
    }, 10);
}

/**
 * Hide tooltip
 */
function hideTooltip() {
    const tooltip = document.getElementById('tooltip');
    if (tooltip) {
        tooltip.style.opacity = '0';
        tooltip.style.transform = 'translateY(4px)';
        setTimeout(() => tooltip.remove(), 200);
    }
}

/**
 * Show toast notification
 */
function showToast(message, type = 'info', duration = 5000) {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-strong max-w-sm transform transition-all duration-300 translate-x-full`;
    
    // Set toast color based on type
    const toastTypes = {
        success: 'bg-green-500 text-white',
        error: 'bg-red-500 text-white',
        warning: 'bg-yellow-500 text-white',
        info: 'bg-blue-500 text-white'
    };
    
    const toastIcons = {
        success: 'check-circle',
        error: 'alert-circle',
        warning: 'alert-triangle',
        info: 'info'
    };
    
    toast.className += ` ${toastTypes[type] || toastTypes.info}`;
    
    toast.innerHTML = `
        <div class="flex items-center">
            <i data-lucide="${toastIcons[type] || toastIcons.info}" class="w-5 h-5 mr-3 flex-shrink-0"></i>
            <span class="text-sm font-medium pr-8">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="absolute top-2 right-2 p-1 hover:bg-black/10 rounded">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Initialize icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Slide in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 300);
    }, duration);
}

// Export functions for global use
window.PingPongApp = {
    showToast,
    showNotification,
    formatNumber: (num) => new Intl.NumberFormat('en-US').format(num),
    formatCurrency: (amount) => new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(amount),
    formatDate: (dateString) => new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    }),
    formatTime: (timeString) => {
        const time = new Date(`1970-01-01T${timeString}`);
        return time.toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        });
    },
    showLoadingState,
    showErrorState
};