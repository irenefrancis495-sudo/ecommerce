<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Craveat Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F9FC; }
        .sidebar-active { background-color: #F3E8FF; color: #9333EA; border-radius: 0 50px 50px 0; }
        .glass-card { background: white; border: 1px solid #F1F5F9; box-shadow: 0 4px 20px -5px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="flex">

    <?php
    // --- MOCK DATA (No Database Needed Yet) ---
    $stats = [
        ['label' => 'Total Orders', 'val' => '450', 'icon' => 'fa-shopping-cart'],
        ['label' => 'Total Customers', 'val' => '955', 'icon' => 'fa-users'],
        ['label' => 'Total Revenue', 'val' => '$ 50 K', 'icon' => 'fa-wallet'],
        ['label' => 'Total Menu', 'val' => '250', 'icon' => 'fa-utensils'],
        ['label' => 'Total Workers', 'val' => '30', 'icon' => 'fa-user-tie'],
    ];

    $top_selling = [
        ['name' => 'King Burger', 'qty' => 100, 'img' => 'https://cdn-icons-png.flaticon.com/512/3075/3075977.png'],
        ['name' => 'Chicken Noodles', 'qty' => 150, 'img' => 'https://cdn-icons-png.flaticon.com/512/2718/2718224.png'],
        ['name' => 'Hot & Sour Soup', 'qty' => 60, 'img' => 'https://cdn-icons-png.flaticon.com/512/1046/1046748.png'],
    ];

    $isActive = $_GET['route'] ?? 'dashboard';

    $getActiveClass = function($route) use ($isActive) {
        return $isActive === $route ? 'sidebar-active' : 'text-gray-400 hover:text-purple-600 transition';
    };
    ?>

    <aside class="w-64 h-screen bg-white sticky top-0 border-r border-gray-100 flex flex-col py-8">
        <div class="px-8 mb-10">
            <h1 class="text-2xl font-black text-purple-600 tracking-tighter italic uppercase">Craveat</h1>
        </div>
        
        <nav class="flex-1 pr-6 space-y-1">
            <a href="admin-dashboard.php" class="<?php echo $getActiveClass('dashboard'); ?> flex items-center px-8 py-3 font-semibold">
                <i class="fas fa-th-large mr-4"></i> Dashboard
            </a>
            <a href="?route=analytics" class="<?php echo $getActiveClass('analytics'); ?> flex items-center px-8 py-3 font-semibold">
                <i class="fas fa-chart-line mr-4"></i> Analytics
            </a>
            <a href="?route=orders" class="<?php echo $getActiveClass('orders'); ?> flex items-center px-8 py-3 font-semibold">
                <i class="fas fa-shopping-bag mr-4"></i> Orders
            </a>
            <a href="?route=customers" class="<?php echo $getActiveClass('customers'); ?> flex items-center px-8 py-3 font-semibold">
                <i class="fas fa-user mr-4"></i> Customer
            </a>
            <a href="?route=chats" class="<?php echo $getActiveClass('chats'); ?> flex items-center px-8 py-3 font-semibold">
                <i class="fas fa-comment-dots mr-4"></i> Chats
            </a>
            <a href="?route=wallet" class="<?php echo $getActiveClass('wallet'); ?> flex items-center px-8 py-3 font-semibold">
                <i class="fas fa-wallet mr-4"></i> Wallet
            </a>
        </nav>

        <div class="px-8 border-t border-gray-50 pt-6">
            <a href="#" class="flex items-center text-gray-400 hover:text-red-500 transition">
                <i class="fas fa-sign-out-alt mr-4"></i> Logout
            </a>
        </div>
    </aside>

    <main class="flex-1 p-10">
        
        <header class="flex justify-between items-center mb-10">
            <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
            <div class="flex items-center gap-6 text-gray-400">
                <div class="flex gap-4">
                    <i class="fas fa-search cursor-pointer hover:text-purple-600"></i>
                    <i class="fas fa-bell cursor-pointer hover:text-purple-600"></i>
                    <i class="fas fa-cog cursor-pointer hover:text-purple-600"></i>
                </div>
                <div class="border-l pl-6">
                    <img src="https://i.pravatar.cc/150?u=admin" class="w-10 h-10 rounded-full border-2 border-white shadow-sm">
                </div>
            </div>
        </header>

        <div class="grid grid-cols-5 gap-6 mb-10">
            <?php foreach ($stats as $s): ?>
            <div class="glass-card p-6 rounded-2xl flex flex-col items-start">
                <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas <?php echo $s['icon']; ?>"></i>
                </div>
                <span class="text-2xl font-bold text-gray-800"><?php echo $s['val']; ?></span>
                <span class="text-[10px] uppercase font-bold tracking-widest text-gray-400"><?php echo $s['label']; ?></span>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="grid grid-cols-12 gap-6 mb-10">
            
            <div class="col-span-4 glass-card p-6 rounded-2xl">
                <div class="flex justify-between mb-6">
                    <h3 class="font-bold text-gray-700">Order Summary</h3>
                    <span class="text-xs bg-gray-50 px-2 py-1 rounded">Today <i class="fas fa-chevron-down"></i></span>
                </div>
                <div class="flex justify-around items-center">
                    <div class="text-center">
                        <div class="w-20 h-20 rounded-full border-8 border-purple-500 border-t-purple-100 flex items-center justify-center font-bold">25%</div>
                        <p class="text-[10px] mt-2 font-bold text-gray-400">ON DELIVERY</p>
                    </div>
                    <div class="text-center">
                        <div class="w-20 h-20 rounded-full border-8 border-purple-200 border-t-purple-600 flex items-center justify-center font-bold">85%</div>
                        <p class="text-[10px] mt-2 font-bold text-gray-400">DELIVERED</p>
                    </div>
                </div>
            </div>

            <div class="col-span-4 glass-card p-6 rounded-2xl">
                <h3 class="font-bold text-gray-700 mb-6">Overview</h3>
                <div class="flex items-center gap-6">
                    <div class="w-24 h-24 rounded-full border-[10px] border-purple-600 border-l-purple-200 flex items-center justify-center font-bold text-lg">52%</div>
                    <div class="text-[10px] font-bold text-gray-400 space-y-2">
                        <p><span class="w-2 h-2 rounded-full bg-purple-600 inline-block"></span> MORNING 25%</p>
                        <p><span class="w-2 h-2 rounded-full bg-purple-400 inline-block"></span> AFTERNOON 35%</p>
                        <p><span class="w-2 h-2 rounded-full bg-purple-200 inline-block"></span> EVENING 52%</p>
                    </div>
                </div>
            </div>

            <div class="col-span-4 glass-card p-6 rounded-2xl">
                <h3 class="font-bold text-gray-700 mb-6">Top Selling Items</h3>
                <div class="space-y-4">
                    <?php foreach ($top_selling as $item): ?>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <img src="<?php echo $item['img']; ?>" class="w-8 h-8 rounded bg-gray-50 p-1">
                            <span class="text-sm font-semibold text-gray-700"><?php echo $item['name']; ?></span>
                        </div>
                        <span class="text-sm font-bold text-gray-400"><?php echo $item['qty']; ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="glass-card p-8 rounded-2xl">
            <h3 class="font-bold text-gray-700 mb-8">Total Revenue</h3>
            <div class="h-40 w-full relative flex items-end justify-between px-4 overflow-hidden">
                <svg class="absolute inset-0 w-full h-full" preserveAspectRatio="none">
                    <path d="M0 100 Q 150 20 300 80 T 600 40 T 900 90 T 1200 20 L 1200 150 L 0 150 Z" fill="rgba(168, 85, 247, 0.1)" stroke="#A855F7" stroke-width="3"></path>
                </svg>
                <div class="w-full flex justify-between text-[10px] font-bold text-gray-300 uppercase relative z-10">
                    <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span><span>Aug</span><span>Sep</span><span>Oct</span><span>Nov</span><span>Dec</span>
                </div>
            </div>
        </div>

    </main>
</body>
</html>