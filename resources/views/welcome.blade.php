<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>{{ config('app.name') }} - Order Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('landing_assets/css/style.css') }}">
</head>

<body class="bg-gray-50">

    <div id="overlay" class="overlay fixed inset-0 bg-black/50"></div>

    <aside id="sidebar" class="sidebar fixed top-0 left-0 w-72 h-full bg-white shadow-2xl z-50 flex flex-col">
        <div class="p-5 border-b flex justify-between items-center">
            <h2 class="text-xl font-bold text-orange-600">
                <img src="{{ asset('own_assets/logo/logo.png') }}" width="50%">
            </h2>
            <button id="closeSidebarBtn" class="text-gray-500 text-2xl"><i class="fas fa-times"></i></button>
        </div>
        <nav class="flex-1 p-4 space-y-3">
            <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-orange-50 transition"><i
                    class="fas fa-home w-6 text-orange-500"></i><span>Beranda</span></a>
            <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-orange-50 transition"><i
                    class="fas fa-history w-6 text-orange-500"></i><span>Pesanan</span></a>
        </nav>
        <div class="p-5 border-t bg-gray-50">
            <h3 class="font-semibold text-gray-700 mb-3"><i class="fas fa-address-card mr-2"></i>Kontak Kami</h3>
            <div class="space-y-2 text-sm text-gray-600">
                <p><i class="fab fa-whatsapp w-5 text-green-600"></i> +62 812-3456-7890</p>
                <p><i class="fas fa-phone-alt w-5 text-blue-500"></i> (021) 1234 5678</p>
                <p><i class="fas fa-envelope w-5 text-red-400"></i> halo@restoran.id</p>
                <p><i class="fas fa-map-marker-alt w-5 text-gray-600"></i> Jl. Kuliner No. 88, Jakarta</p>
            </div>
            <div class="flex mt-4 space-x-3">
                <i class="fab fa-instagram text-2xl text-pink-500"></i>
                <i class="fab fa-facebook text-2xl text-blue-700"></i>
                <i class="fab fa-tiktok text-2xl text-black"></i>
            </div>
        </div>
    </aside>

    <main class="pb-28">
        <header class="bg-white shadow-sm sticky top-0 z-20">
            <div class="container mx-auto px-4 py-4 flex items-center gap-4">
                <button id="menuToggleBtn" class="text-2xl text-orange-600 focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="text-xl font-bold text-gray-800">
                    <img src="{{ asset('own_assets/logo/logo.png') }}" width="50%">
                </h1>
            </div>
        </header>

        <div class="container mx-auto px-4 mt-4">
            <div class="w-full h-40 md:h-56 rounded-2xl overflow-hidden shadow-md">
                <img src="https://picsum.photos/id/106/1200/400" alt="Banner Makanan"
                    class="w-full h-full object-cover">
            </div>
        </div>

        <div class="container mx-auto px-4 mt-6">
            <div class="flex overflow-x-auto space-x-3 pb-2 no-scrollbar scroll-smooth" id="categoryTabs">
                <button
                    class="tab-category px-5 py-2 rounded-full border border-gray-300 bg-white text-gray-700 font-medium whitespace-nowrap transition hover:shadow flex items-center gap-2"
                    data-cat="0">
                    <img src="{{ asset('own_assets/icon/all_kategori.png') }}" class="w-5 h-5">
                    <span>Semua</span>
                </button>
                @foreach ($kategori as $kat)
                    <button
                        class="tab-category px-5 py-2 rounded-full border border-gray-300 bg-white text-gray-700 font-medium whitespace-nowrap transition hover:shadow flex items-center gap-2"
                        data-cat="{{ $kat->id }}">

                        <img src="{{ asset('storage/' . $kat->icon) }}" class="w-5 h-5">

                        <span>{{ $kat->nama_kategori }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="container mx-auto px-4 mt-6">
            <h2 id="categoryTitle" class="text-xl font-bold text-gray-800 border-l-4 border-orange-500 pl-3 mb-4">
                Makanan</h2>
            <div id="menuList" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">

            </div>
        </div>
    </main>

    <!-- FLOATING CART BUTTON -->
    <div id="floatCartBtn" class="float-cart">
        <i class="fas fa-shopping-bag text-2xl"></i>
        <span id="cartCountBadge">0</span>
    </div>

    <!-- BOTTOM SHEET OVERLAY & SHEET -->
    <div id="sheetOverlay" class="sheet-overlay"></div>
    <div id="bottomSheet" class="bottom-sheet">
        <div class="sticky top-0 bg-white rounded-t-2xl border-b px-5 py-3 flex justify-between items-center">
            <h3 class="font-bold text-lg">Tambah ke Keranjang</h3>
            <button id="closeSheetBtn" class="text-gray-500 text-2xl"><i class="fas fa-times-circle"></i></button>
        </div>
        <div class="p-5">
            <div class="flex items-center gap-4 mb-4">
                <img id="sheetMenuImg" src="" alt="preview"
                    class="w-16 h-16 rounded-xl object-cover bg-gray-100">
                <div>
                    <h4 id="sheetMenuName" class="font-bold text-gray-800">Nama Menu</h4>
                    <p id="sheetMenuPrice" class="text-orange-600 font-semibold">Rp 0</p>
                </div>
            </div>
            <div class="flex items-center justify-between bg-gray-100 rounded-full p-2 mb-6">
                <button id="qtyMinus"
                    class="w-10 h-10 rounded-full bg-white shadow text-xl font-bold text-gray-700">-</button>
                <span id="qtyValue" class="text-xl font-semibold w-12 text-center">1</span>
                <button id="qtyPlus"
                    class="w-10 h-10 rounded-full bg-white shadow text-xl font-bold text-gray-700">+</button>
            </div>
            <button id="addToCartBtn"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-2xl transition flex items-center justify-center gap-2"><i
                    class="fas fa-cart-plus"></i> Masukkan ke Keranjang</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {

            let activeCategory = null;
            let cart = [];
            let selectedMenu = null;
            let qty = 1;

            let firstTab = $('.tab-category').first();

            if (firstTab.length) {
                activeCategory = firstTab.data('cat');
                firstTab.addClass('bg-orange-500 text-white active').removeClass('bg-white text-gray-700');
                loadMenu(activeCategory);
                $('#categoryTitle').text(firstTab.text());
            }

            $(document).on('click', '.tab-category', function() {

                $('.tab-category')
                    .removeClass('bg-orange-500 text-white')
                    .addClass('bg-white text-gray-700');

                $(this)
                    .addClass('bg-orange-500 text-white')
                    .removeClass('bg-white text-gray-700');

                activeCategory = $(this).data('cat');

                $('#categoryTitle').text($(this).text());

                loadMenu(activeCategory);
            });

            function loadMenu(kategori) {

                $('#menuList').html('<div class="text-center py-5">Loading...</div>');

                $.get('/daftar-menu/load-data', {
                    kategori: kategori
                }, function(res) {

                    if (!res.data.length) {
                        $('#menuList').html(
                            '<div class="text-center py-5 text-gray-400">Menu kosong</div>');
                        return;
                    }

                    let html = '';

                    res.data.forEach(menu => {

                        let img = '/storage/default.png';

                        if (menu.foto_menus && menu.foto_menus.length > 0) {
                            img = '/storage/' + menu.foto_menus[0].foto_path;
                        }

                        html += `
                <div class="menu-card bg-white rounded-2xl shadow hover:shadow-lg overflow-hidden transition">
                    <img src="${img}" class="w-full h-36 object-cover">
                    
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800">${menu.nama_menu}</h3>
                        <p class="text-orange-600 font-semibold mt-1">
                            Rp ${formatRupiah(menu.harga)}
                        </p>

                        <button class="btn-add mt-3 w-full bg-orange-100 hover:bg-orange-200 text-orange-700 py-2 rounded-xl"
                            data-menu='${JSON.stringify(menu)}'>
                            Pesan +
                        </button>
                    </div>
                </div>
                `;
                    });

                    $('#menuList').html(html);
                });
            }

            $(document).on('click', '.btn-add', function() {

                selectedMenu = $(this).data('menu');
                qty = 1;

                $('#qtyValue').text(qty);
                $('#sheetMenuName').text(selectedMenu.nama_menu);
                $('#sheetMenuPrice').text('Rp ' + formatRupiah(selectedMenu.harga));

                let img = '/storage/default.png';
                if (selectedMenu.foto_menus && selectedMenu.foto_menus.length > 0) {
                    img = '/storage/' + selectedMenu.foto_menus[0].foto_path;
                }

                $('#sheetMenuImg').attr('src', img);

                openBottomSheet();
            });

            function openBottomSheet() {
                $('#bottomSheet').addClass('open');
                $('#sheetOverlay').addClass('active');
                $('body').css('overflow', 'hidden');
            }

            function closeBottomSheet() {
                $('#bottomSheet').removeClass('open');
                $('#sheetOverlay').removeClass('active');
                $('body').css('overflow', '');
            }

            $('#closeSheetBtn, #sheetOverlay').click(closeBottomSheet);

            $('#qtyPlus').click(function() {
                qty++;
                $('#qtyValue').text(qty);
            });

            $('#qtyMinus').click(function() {
                if (qty > 1) {
                    qty--;
                    $('#qtyValue').text(qty);
                }
            });

            $('#addToCartBtn').click(function() {

                let exist = cart.find(i => i.id === selectedMenu.id);

                if (exist) {
                    exist.qty += qty;
                } else {
                    cart.push({
                        id: selectedMenu.id,
                        nama: selectedMenu.nama_menu,
                        harga: selectedMenu.harga,
                        qty: qty
                    });
                }

                updateCart();
                closeBottomSheet();
            });

            function updateCart() {

                let total = cart.reduce((sum, i) => sum + i.qty, 0);
                $('#cartCountBadge').text(total);
            }

            $('#floatCartBtn').click(function() {

                if (!cart.length) {
                    alert('Keranjang kosong');
                    return;
                }

                let text = '🛒 Keranjang:\n\n';

                cart.forEach(i => {
                    text += `${i.nama} x${i.qty}\n`;
                });

                alert(text);
            });

            $('#menuToggleBtn').click(function() {
                $('#sidebar').addClass('open');
                $('#overlay').addClass('active');
            });

            $('#closeSidebarBtn, #overlay').click(function() {
                $('#sidebar').removeClass('open');
                $('#overlay').removeClass('active');
            });

            function formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

        });
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</body>

</html>
