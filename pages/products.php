<?php
require __DIR__ . '/../config/bootstrap.php';
use Mpemba\Entity\Product;

$products = Product::getProducts();

?>

<!-- TopNavBar -->
 <?php include __DIR__ . '/../components/ui/navbar.php'; ?>


<main class="pt-28 pb-20 px-8 max-w-screen-2xl mx-auto">
<header class="mb-12">
<h1 class="font-headline font-black text-5xl md:text-6xl text-primary tracking-tighter mb-2">Browse Products</h1>
<p class="text-on-surface-variant max-w-lg">Discover items from all categories. Add products to the cart and continue shopping or checkout anytime.</p>
</header><!-- product listing starts -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
<!-- Cart Items List -->
<section class="lg:col-span-8 space-y-6">
<!-- Cart Item 1 -->
<div class="group bg-surface-container-lowest rounded-xl p-6 flex flex-col md:flex-row gap-6 transition-all hover:bg-white hover:shadow-xl hover:shadow-primary/5">
<div class="w-full md:w-40 h-40 rounded-lg overflow-hidden bg-surface-container-low flex-shrink-0">
<img alt="Handcrafted Ceramic Vase" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" data-alt="Minimalist handcrafted white ceramic vase with organic texture standing on a wooden pedestal in soft morning light" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAxDoQfzg51JXLMGZL-5yKSSO0OoGe-scZmcd4ezPXnTVpG14dyOZrCvw1-eB-Rq3-5xmDBm26DCfhyM-2R2oBdiklY-Hku2sVbSTWk0pSFBwWpEoKXINV55LSZtEzJJVlQ44n3DvXg3tZR80ygmzKNos4Z3-1g9TJTKPFL-A9bSvbh2igHemCx3mY1m_PrUkswwUBoH6W1SWDtmHgT_VlULt9ePuM9Kw1z-kKQJyMOz08U8RwHXoJ1gMFqNPWy0QL-03yu36cuxFc"/>
</div>
<div class="flex-grow flex flex-col justify-between">
<div class="flex justify-between items-start">
<div>
<h3 class="font-headline font-bold text-xl text-primary mb-1">Handcrafted Ceramic Vase</h3>
<p class="text-sm text-on-surface-variant mb-4">Color: Bone White | Size: Large</p>
</div>
<p class="font-headline font-bold text-xl text-primary">$120.00</p>
</div>
<div class="flex justify-between items-center">
<div class="flex items-center bg-surface-container-high rounded-full px-4 py-1">
<button class="addToCart hover:text-primary transition-colors" data-max-item="<?= 10 ?>"><span class="material-symbols-outlined text-sm">remove</span></button>
<span class="mx-4 font-bold text-primary">1</span>
<button class="hover:text-primary transition-colors"><span class="material-symbols-outlined text-sm">add</span></button>
</div>
<button class="text-error flex items-center gap-1 text-sm font-semibold hover:opacity-80 transition-opacity">
<span class="material-symbols-outlined text-lg">delete</span>
                                Remove
                            </button>
</div>
</div>
</div>
<!-- Cart Item 2 -->
<div class="group bg-surface-container-lowest rounded-xl p-6 flex flex-col md:flex-row gap-6 transition-all hover:bg-white hover:shadow-xl hover:shadow-primary/5">
<div class="w-full md:w-40 h-40 rounded-lg overflow-hidden bg-surface-container-low flex-shrink-0">
<img alt="Linen Throw Pillow" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" data-alt="Close-up of premium linen throw pillow in earthy ochre tone with fine stitching on a dark velvet sofa" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA45ctb3yJKdP0_SKoDIUlfBtI4h68aZ4-7AEV8cUUzjZ3FYIUk2dYC9IBsTZpZD1ABAhqPtABqba5-USYRSa64bi7jWAYaNp1zFpIMKyEhZNuba0PKR4O3CmOwUTwKpdqBGw2BvSanRBrIS4_kqg4zsLGA-zC5Bd7CnZq-pNeMxa9Nce02PKRFqVqIQiL1Hkc0aa9QWWr6G9tYnzLnqcTbMz4y1dw60lAVvqxeiZD3SjFw4p7Tp7HsqLgzckQuAhzMm4zuOGPVO60"/>
</div>
<div class="flex-grow flex flex-col justify-between">
<div class="flex justify-between items-start">
<div>
<h3 class="font-headline font-bold text-xl text-primary mb-1">Linen Throw Pillow</h3>
<p class="text-sm text-on-surface-variant mb-4">Color: Ochre | Material: French Linen</p>
</div>
<div class="text-right">
<p class="font-headline font-bold text-xl text-primary">$85.00</p>
<p class="text-xs text-secondary font-bold">In Stock</p>
</div>
</div>
<div class="flex justify-between items-center">
<div class="flex items-center bg-surface-container-high rounded-full px-4 py-1">
<button class="hover:text-primary transition-colors"><span class="material-symbols-outlined text-sm">remove</span></button>
<span class="mx-4 font-bold text-primary">2</span>
<button class="hover:text-primary transition-colors"><span class="material-symbols-outlined text-sm">add</span></button>
</div>
<button class="text-error flex items-center gap-1 text-sm font-semibold hover:opacity-80 transition-opacity">
<span class="material-symbols-outlined text-lg">delete</span>
                                Remove
                            </button>
</div>
</div>
</div>
<!-- Cart Item 3 -->
<div class="group bg-surface-container-lowest rounded-xl p-6 flex flex-col md:flex-row gap-6 transition-all hover:bg-white hover:shadow-xl hover:shadow-primary/5">
<div class="w-full md:w-40 h-40 rounded-lg overflow-hidden bg-surface-container-low flex-shrink-0">
<img alt="Premium Leather Journal" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" data-alt="Hand-bound dark brown leather journal with vintage paper edges on a rustic wooden desk with a quill pen" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB93LCbYZdHqIoWEtg3ETjEpVMa2VuIT4bClaCYlLuP4U2Xq3KZqZdMJWfE2LMu2NRpQLa4rt-5zpiymosReRetRSQjpFD3Dj2N6BBu_dF3iwUgmhctTbEoC_k0DyAoapV4_ky_iJw07tHige3AsZGP0D8BrvkDl4UAHDQgW5W7I2WKLn9K72LpvOxgGXmvvnUFrF7kU-blFb2faitXvVuk7E5-SSvNpCuzn5Z6iP3oAfT-_TwcgZXcqPywE3Aj7dxjwwULfRijm40"/>
</div>
<div class="flex-grow flex flex-col justify-between">
<div class="flex justify-between items-start">
<div>
<h3 class="font-headline font-bold text-xl text-primary mb-1">Premium Leather Journal</h3>
<p class="text-sm text-on-surface-variant mb-4">Cover: Full Grain Leather | Pages: Ruled</p>
</div>
<p class="font-headline font-bold text-xl text-primary">$45.00</p>
</div>
<div class="flex justify-between items-center">
<div class="flex items-center bg-surface-container-high rounded-full px-4 py-1">
<button class="hover:text-primary transition-colors"><span class="material-symbols-outlined text-sm">remove</span></button>
<span class="mx-4 font-bold text-primary">1</span>
<button class="hover:text-primary transition-colors"><span class="material-symbols-outlined text-sm">add</span></button>
</div>
<button class="text-error flex items-center gap-1 text-sm font-semibold hover:opacity-80 transition-opacity">
<span class="material-symbols-outlined text-lg">delete</span>
                                Remove
                            </button>
</div>
</div>
</div>
</section>
<!-- Order Summary Sidebar -->
<aside class="lg:col-span-4 sticky top-28">
<div class="bg-surface-container-lowest rounded-xl p-8 shadow-sm">
<h2 class="font-headline font-bold text-2xl text-primary mb-8">Order Summary</h2>
<div class="space-y-4 mb-8">
<div class="flex justify-between text-on-surface-variant">
<span>Subtotal</span>
<span class="font-bold text-primary">$335.00</span>
</div>
<div class="flex justify-between text-on-surface-variant">
<span>Shipping</span>
<span class="font-bold text-primary">$15.00</span>
</div>
<div class="flex justify-between text-on-surface-variant">
<span>Tax</span>
<span class="font-bold text-primary">$26.80</span>
</div>
<div class="pt-4 mt-4 border-t border-surface-container-high flex justify-between">
<span class="text-xl font-headline font-bold text-primary">Total</span>
<span class="text-xl font-headline font-bold text-primary">$376.80</span>
</div>
</div>
<div class="space-y-4">
<button class="w-full bg-gradient-to-r from-secondary to-secondary-container text-on-secondary font-bold py-4 rounded-lg transition-all scale-102 hover:shadow-lg hover:shadow-secondary/20 flex items-center justify-center gap-2">
                            Proceed to Checkout
                            <span class="material-symbols-outlined">arrow_forward</span>
</button>
<button class="w-full bg-primary text-on-primary font-bold py-4 rounded-lg transition-all hover:bg-primary-container">
                            Continue Shopping
                        </button>
</div>
<div class="mt-8 p-4 bg-surface-container-low rounded-lg">
<div class="flex items-start gap-3">
<span class="material-symbols-outlined text-secondary">verified</span>
<p class="text-xs text-on-surface-variant">
<strong>Secure Checkout</strong><br/>
                                Your data is protected by industry-leading encryption and artisanal care.
                            </p>
</div>
</div>
</div>
</aside>
</div>
<!-- Related Items Carousel -->
<section class="mt-24">
<div class="flex justify-between items-end mb-8">
<div>
<h2 class="font-headline font-black text-3xl text-primary tracking-tight">Complete the Look</h2>
<p class="text-on-surface-variant">Curated pairings based on your selection.</p>
</div>
<div class="flex gap-2">
<button class="w-10 h-10 rounded-full border border-outline-variant flex items-center justify-center text-primary hover:bg-surface-container-high transition-colors">
<span class="material-symbols-outlined">chevron_left</span>
</button>
<button class="w-10 h-10 rounded-full border border-outline-variant flex items-center justify-center text-primary hover:bg-surface-container-high transition-colors">
<span class="material-symbols-outlined">chevron_right</span>
</button>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
<!-- Related Item 1 -->
<div class="group bg-surface-container-lowest rounded-xl overflow-hidden hover:shadow-xl transition-all p-4">
<div class="aspect-square rounded-lg overflow-hidden bg-surface-container mb-4">
<img alt="Oak Wood Coasters" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" data-alt="Set of four circular oak wood coasters with natural grain patterns arranged on a stone countertop" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBY-Z4_rtruuvKhTvIR0pGgy-K5rjtkBNRCOZltdooy4-puRIUxuG5phvCdengYprin4WJtaZJlv-voFqm7n7yixQRX2WjamRDXsSHCbHZ8zICdszadZNb_a3LCLf3KEsU7mZppv3pfZQJ18bYxIzYlAKjGe7xA9o60z954r41QUFKpbFyewWnL-0syHEb7vltLp4btSS-xLLLpz8WHc_r3mYa_kvPE1LGSee59IcR3og-P8cUyf6WuOgV3N04Iibr4kMzAx8pyOM8"/>
</div>
<p class="text-xs font-bold text-secondary-fixed-variant uppercase tracking-widest mb-1">Accessories</p>
<h3 class="font-headline font-bold text-primary mb-1">Oak Wood Coasters</h3>
<p class="text-primary font-bold">$24.00</p>
</div>
<!-- Related Item 2 -->
<div class="group bg-surface-container-lowest rounded-xl overflow-hidden hover:shadow-xl transition-all p-4">
<div class="aspect-square rounded-lg overflow-hidden bg-surface-container mb-4">
<img alt="Soy Wax Candle" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" data-alt="Minimalist glass jar candle with soy wax and a wooden wick burning softly in a dim cozy room setting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDA3GpnV-NXNyvIfpd4QXcRnmdgg-SKFEwplQoT5X948QG2-a3gmPZBIzseyO-qhtJFkGFK1vh081PDxoAJGbuetn2nTflFU_i0ckvkfG8GOX48PIdMVxUKU1BKXDjZlnpOb4lsQRbL1Dvl0mzb3eTSJGLf2m1lwAh9fep7mq8BQsNPkPwp_MnEuzXrrtPxY5V_68IrvVe3Pzief8KCbTnEVX6hlq1zb1EGAcVgz3hPPpltsHS96MVi1xUSCUXaPq5IVapxWYK6btI"/>
</div>
<p class="text-xs font-bold text-secondary-fixed-variant uppercase tracking-widest mb-1">Home Fragrance</p>
<h3 class="font-headline font-bold text-primary mb-1">Sandalwood Candle</h3>
<p class="text-primary font-bold">$32.00</p>
</div>
<!-- Related Item 3 -->
<div class="group bg-surface-container-lowest rounded-xl overflow-hidden hover:shadow-xl transition-all p-4">
<div class="aspect-square rounded-lg overflow-hidden bg-surface-container mb-4">
<img alt="Brass Incense Burner" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" data-alt="Vintage-inspired solid brass incense burner with delicate geometric perforations emitting a thin trail of smoke" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCGJpn5e8oA6-9RUfmkBBGOY75EY85NZCI0ZvwbkV-qFWizM8QOf9oHovidPefJNWT8usQSPzsDv5rOonLPpkd9XgRbmF6arxdFcZDxiRY8VdQ9rTrkvgT1KzjLek0rrUPkRSzCztndeIcu3y0l2D46exvsosWjFVfd_Pfv7pEtqO33Fi1RG_lMM0Iv7kd8t2LnYah7YfMnTPwaDwrZQcbEqndu54XoiHIL5ByjLPK3nj7u5GkOKnN9q-nKPBBS2SprRhgxFwlMD-Q"/>
</div>
<p class="text-xs font-bold text-secondary-fixed-variant uppercase tracking-widest mb-1">Decor</p>
<h3 class="font-headline font-bold text-primary mb-1">Brass Burner</h3>
<p class="text-primary font-bold">$58.00</p>
</div>
<!-- Related Item 4 -->
<div class="group bg-surface-container-lowest rounded-xl overflow-hidden hover:shadow-xl transition-all p-4">
<div class="aspect-square rounded-lg overflow-hidden bg-surface-container mb-4">
<img alt="Felt Desktop Mat" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" data-alt="Thick grey industrial felt desk mat with clean edges and a minimal laptop and mouse setup" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCk1qNkkDmZDYlXoVh5OpL1bvc0vHZgRvQQCPcBh5M1jjI994Q2WIUtAtmLtNqVTztasWjROQ3QWgMD8A8TyMSrTnCyvu6Dq5QzV9JJGsWW23OiVNwyYhUlZmaeh1KbQw_cGMbASnTikxXl0Dd5BwQbaCbF3XaBK6uEeuUqaw_TCdKsGdsKT3i-2cISEUmw_S09vzByGjhJ8LB1b8k_hRputL7H_0JTmFcmmWEF_Z52Hpsto2Jkz1hDiZn4kFUPhbnWf_mPHz6wI44"/>
</div>
<p class="text-xs font-bold text-secondary-fixed-variant uppercase tracking-widest mb-1">Workspace</p>
<h3 class="font-headline font-bold text-primary mb-1">Wool Felt Mat</h3>
<p class="text-primary font-bold">$40.00</p>
</div>
</div>
</section>
</main>
<!-- Footer -->
<?php include __DIR__ . '/../components/ui/footer.php'; ?>

<script>
    // Add to Cart button functionality
    $('.addToCart').on('click',function(){
        const maxData = $(this).data('max-item');
        const currentCount = parseInt($(this).siblings('span').text());
        if(currentCount>maxData){return}

        $(this).siblings('span').text(currentCount+1);
    })