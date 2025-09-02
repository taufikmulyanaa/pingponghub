</main>
    </div>
    
    <!-- Mobile Bottom Navigation -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-card border-t border-border flex justify-around items-center h-16 z-50 shadow-strong">
        <?php
        $navItems = [
            ['id' => 'index', 'label' => 'Home', 'icon' => 'home'],
            ['id' => 'discover', 'label' => 'Discover', 'icon' => 'search'],
            ['id' => 'play', 'label' => 'Play', 'icon' => 'play'],
            ['id' => 'ptm', 'label' => 'Clubs', 'icon' => 'building'],
            ['id' => 'profile', 'label' => 'Profile', 'icon' => 'user']
        ];
        $currentPage = basename($_SERVER['PHP_SELF'], ".php");

        foreach ($navItems as $item) {
            $isActive = ($currentPage == $item['id']) ? 'text-orange-500' : 'text-muted-foreground';
            echo "<a href='{$item['id']}.php' class='flex flex-col items-center justify-center w-full text-xs {$isActive} hover:text-orange-500 transition-colors py-2'>
                    <i data-lucide='{$item['icon']}' class='w-5 h-5 mb-1'></i>
                    <span class='font-medium'>{$item['label']}</span>
                  </a>";
        }
        ?>
    </nav>

    <!-- Scripts -->
    <script src="assets/js/main.js"></script>
    
    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            // Reinitialize icons after dynamic content loads
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.addedNodes.length > 0) {
                        lucide.createIcons();
                    }
                });
            });
            
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        });
    </script>
</body>
</html>