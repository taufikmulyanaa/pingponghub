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
            // Update active button state
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            
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
                
                // Add fade-in animation
                playerListContainer.classList.add('fade-in');
                
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
        header.textContent = `${filterName} Players (${count} found)`;
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
 * Show loading state in container
 */
function showLoadingState(container, message = 'Loading...') {
    container.innerHTML = `
        <div class="flex flex-col items-center justify-center p-8 text-muted-foreground">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500 mb-4"></div>
            <p class="text-sm">${message}</p>
        </div>
    `;
}

/**
 * Show error state in container
 */
function showErrorState(container, message = 'Something went wrong') {
    container.innerHTML = `
        <div class="flex flex-col items-center justify-center p-8 text-red-500">
            <i data-lucide="alert-circle" class="w-8 h-8 mb-4"></i>
            <p class="text-sm text-center">${message}</p>
            <button onclick="location.reload()" class="btn btn-secondary mt-4 text-sm">
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
    button.innerHTML = `
        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-current mr-2"></div>
        Loading...
    `;
    
    // Reset after 3 seconds (adjust as needed)
    setTimeout(() => {
        button.disabled = false;
        button.innerHTML = originalText;
    }, 3000);
}

/**
 * Format numbers with proper separators
 */
function formatNumber(num) {
    return new Intl.NumberFormat('en-US').format(num);
}

/**
 * Format currency (Indonesian Rupiah)
 */
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(amount);
}

/**
 * Format date for display
 */
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

/**
 * Format time for display
 */
function formatTime(timeString) {
    const time = new Date(`1970-01-01T${timeString}`);
    return time.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
    });
}

/**
 * Show toast notification
 */
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-strong max-w-sm transform transition-all duration-300 translate-x-full`;
    
    // Set toast color based on type
    switch (type) {
        case 'success':
            toast.className += ' bg-green-500 text-white';
            break;
        case 'error':
            toast.className += ' bg-red-500 text-white';
            break;
        case 'warning':
            toast.className += ' bg-yellow-500 text-white';
            break;
        default:
            toast.className += ' bg-blue-500 text-white';
    }
    
    toast.innerHTML = `
        <div class="flex items-center">
            <i data-lucide="info" class="w-5 h-5 mr-3"></i>
            <span class="text-sm font-medium">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4">
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
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 300);
    }, 5000);
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
 * Show tooltip
 */
function showTooltip(e) {
    const text = e.target.getAttribute('data-tooltip');
    const tooltip = document.createElement('div');
    tooltip.className = 'absolute bg-gray-900 text-white text-xs px-2 py-1 rounded shadow-lg z-50 pointer-events-none';
    tooltip.textContent = text;
    tooltip.id = 'tooltip';
    
    document.body.appendChild(tooltip);
    
    const rect = e.target.getBoundingClientRect();
    tooltip.style.left = rect.left + rect.width / 2 - tooltip.offsetWidth / 2 + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + 'px';
}

/**
 * Hide tooltip
 */
function hideTooltip() {
    const tooltip = document.getElementById('tooltip');
    if (tooltip) {
        tooltip.remove();
    }
}

// Export functions for global use
window.PingPongApp = {
    showToast,
    showNotification,
    formatNumber,
    formatCurrency,
    formatDate,
    formatTime,
    showLoadingState,
    showErrorState
};