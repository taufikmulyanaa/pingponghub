<nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 flex justify-around items-center h-16 z-50">
    <?php
    $navItems = [
        ['id' => 'index', 'label' => 'Home', 'icon' => '🏠'],
        ['id' => 'discover', 'label' => 'Discover', 'icon' => '🔍'],
        ['id' => 'play', 'label' => 'Play', 'icon' => '▶️'],
        ['id' => 'ptm', 'label' => 'PTM', 'icon' => '🏢'],
        ['id' => 'profile', 'label' => 'Profile', 'icon' => '👤']
    ];
    $currentPage = basename($_SERVER['PHP_SELF'], ".php");

    foreach ($navItems as $item) {
        $isActive = ($currentPage == $item['id']) ? 'text-orange-500' : 'text-gray-500';
        echo "<a href='{$item['id']}.php' class='flex flex-col items-center justify-center w-full text-xs {$isActive} hover:text-orange-500 transition-colors'>
                <span class='text-2xl'>{$item['icon']}</span>
                <span class='mt-1 font-medium'>{$item['label']}</span>
              </a>";
    }
    ?>
</nav>