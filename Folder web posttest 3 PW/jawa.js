alert("Anda Memasuki Website Pesawat");

// Mendapatkan elemen yang akan dikontrol
const welcomeText = document.getElementById('welcome-text');

// Kecepatan perpindahan
let moveSpeed = 20;

// Fungsi untuk menangani event keydown
document.addEventListener('keydown', function(event) {
    // Mendapatkan posisi elemen saat ini
    let top = welcomeText.offsetTop;
    let left = welcomeText.offsetLeft;

    // Memeriksa tombol panah mana yang ditekan
    switch (event.key) {
        case 'ArrowUp':
            welcomeText.style.top = (top - moveSpeed) + 'px';
            break;
        case 'ArrowDown':
            welcomeText.style.down = (top + moveSpeed) + 'px';
            break;
        case 'ArrowLeft':
            welcomeText.style.left = (left - moveSpeed) + 'px';
            break;
    }
});

// Menambahkan gaya CSS secara dinamis agar teks bisa bergerak
welcomeText.style.position = 'relative';