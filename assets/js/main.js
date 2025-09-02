document.addEventListener('DOMContentLoaded', () => {
    console.log('PingPong+ App is ready!');

    // --- FITUR LIVE SEARCH UNTUK KLUB ---
    // ... (kode search klub dari sebelumnya) ...


    // --- FITUR FILTER PEMAIN DI HALAMAN DISCOVER ---
    const filterButtons = document.querySelectorAll('.player-filter-btn');
    const playerListContainer = document.getElementById('player-list-container');
    const resultsHeader = document.getElementById('player-results-header');

    if (filterButtons.length > 0 && playerListContainer && resultsHeader) {
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Update tampilan tombol aktif
                filterButtons.forEach(btn => btn.classList.remove('active-filter'));
                button.classList.add('active-filter');

                const filter = button.dataset.filter;
                
                // Tampilkan loading
                playerListContainer.innerHTML = '<p class="text-center p-4">Memuat pemain...</p>';
                
                // Panggil API
                fetch(`api/filter_players.php?filter=${filter}`)
                    .then(response => response.text())
                    .then(html => {
                        playerListContainer.innerHTML = html;
                        
                        // Update header jumlah hasil
                        const countEl = playerListContainer.querySelector('#player-count');
                        if(countEl) {
                           const count = countEl.dataset.count;
                           const filterName = button.textContent;
                           resultsHeader.textContent = `Pemain ${filterName} (${count} ditemukan)`;
                           countEl.remove(); // Hapus elemen pembawa data
                        }
                    })
                    .catch(error => {
                        console.error('Error filtering players:', error);
                        playerListContainer.innerHTML = '<p class="text-center text-red-500 p-4">Gagal memuat pemain.</p>';
                    });
            });
        });
    }
});