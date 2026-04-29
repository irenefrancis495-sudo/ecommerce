<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Sanctuary Home | Mpemba Marketplace</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@300;400;600;700;800&amp;family=Manrope:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "inverse-primary": "#96ceeb",
                        "surface-bright": "#f8f9fb",
                        "primary-fixed-dim": "#96ceeb",
                        "surface": "#f8f9fb",
                        "on-secondary-fixed": "#2f1500",
                        "surface-variant": "#e1e2e5",
                        "outline": "#71787d",
                        "on-tertiary-fixed-variant": "#544600",
                        "surface-container-low": "#f2f4f6",
                        "on-surface": "#191c1e",
                        "on-error": "#ffffff",
                        "surface-container-highest": "#e1e2e5",
                        "on-tertiary-fixed": "#221b00",
                        "secondary-fixed": "#ffdcc3",
                        "on-tertiary": "#ffffff",
                        "on-secondary": "#ffffff",
                        "error": "#ba1a1a",
                        "tertiary-container": "#c9a900",
                        "surface-container-high": "#e7e8ea",
                        "on-secondary-container": "#713b00",
                        "on-primary-fixed-variant": "#044d65",
                        "on-secondary-fixed-variant": "#6e3900",
                        "outline-variant": "#c0c7cd",
                        "secondary-fixed-dim": "#ffb77d",
                        "surface-dim": "#d9dadc",
                        "tertiary-fixed-dim": "#e9c400",
                        "inverse-surface": "#2e3133",
                        "secondary": "#904d00",
                        "on-surface-variant": "#40484c",
                        "background": "#f8f9fb",
                        "primary-fixed": "#bfe8ff",
                        "primary": "#003345",
                        "surface-tint": "#2a657e",
                        "surface-container": "#edeef0",
                        "primary-container": "#004b63",
                        "secondary-container": "#ffa454",
                        "on-error-container": "#93000a",
                        "on-primary-fixed": "#001f2b",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#83bad6",
                        "error-container": "#ffdad6",
                        "on-background": "#191c1e",
                        "tertiary": "#705d00",
                        "surface-container-lowest": "#ffffff",
                        "tertiary-fixed": "#ffe16d",
                        "inverse-on-surface": "#f0f1f3",
                        "on-tertiary-container": "#4c3f00"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Epilogue"],
                        "display": ["Epilogue"],
                        "body": ["Manrope"],
                        "label": ["Manrope"]
                    }
                },
            },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Manrope', sans-serif; background-color: #f8f9fb; }
        h1, h2, h3 { font-family: 'Epilogue', sans-serif; }
    </style>
</head>
<body class="text-on-surface">
<?php include __DIR__ . '/../components/ui/navbar.php'; ?>
<main class="pt-32 pb-20">
<!-- Hero Section: Digital Atelier Editorial -->
<section class="max-w-7xl mx-auto px-8 mb-20">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-end">
<div class="lg:col-span-7">
<h1 class="text-5xl md:text-7xl font-extrabold tracking-tighter text-primary mb-6 leading-none">
                        Sanctuary <br/><span class="text-secondary italic font-light">Home</span>
</h1>
<p class="text-lg text-on-surface-variant max-w-xl font-body leading-relaxed">
                        Curated architectural objects and handcrafted ceramics designed to transform living spaces into meditative landscapes. Experience the intersection of heritage craft and modern minimalism.
                    </p>
</div>
<div class="lg:col-span-5 relative">
<div class="aspect-[4/5] overflow-hidden rounded-xl bg-surface-container-low shadow-lg">
<img class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700" data-alt="Minimalist sunlit living room with a single sculptural ceramic vase on a low oak coffee table, warm architectural shadows" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBEbZuDoWZdhIa5XSpztkcOB73aGoMa6hL3lfPXP0J6fKzUZLpfityZjnIokw1PwZroOH9Z12wYSqITVw52sd9dhYhDSFtM0g6X3UWG8euV23aivWC_YSkYVxm0EFlRKdB_O9Tyl1Wdgd-Ix_fh0Pq1gy1OwShaLweTcBze3YYrpQRIVeikRi2G-Yl0g0tW36b3HP2fwkVFW-bDkt1qGmH04DanUEBAI5Jty6JcmBV-ePxeQsygzDsOLsmxnaeio94RSPGMs74WN4I"/>
</div>
<div class="absolute -bottom-6 -left-12 hidden lg:block bg-secondary p-8 rounded-xl text-on-secondary shadow-xl max-w-[200px]">
<span class="text-xs uppercase tracking-widest font-label block mb-2 opacity-80">Season Focus</span>
<p class="font-headline font-bold text-xl leading-tight">The Earth &amp; Form Collection</p>
</div>
</div>
</div>
</section>
<!-- Filters Section -->
<section class="max-w-7xl mx-auto px-8 mb-12">
<div class="flex flex-col md:flex-row gap-8 justify-between items-start md:items-center">
<div class="flex flex-wrap gap-3">
<span class="text-sm font-bold uppercase tracking-widest text-primary/40 mr-2 flex items-center">Room</span>
<button class="px-6 py-2 rounded-full bg-primary-fixed text-on-primary-fixed font-medium text-sm transition-all hover:scale-105">All Spaces</button>
<button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-medium text-sm hover:bg-surface-container-high transition-all">Lounge</button>
<button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-medium text-sm hover:bg-surface-container-high transition-all">Dining</button>
<button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-medium text-sm hover:bg-surface-container-high transition-all">Bedroom</button>
<button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-medium text-sm hover:bg-surface-container-high transition-all">Studio</button>
</div>
<div class="flex flex-wrap gap-3">
<span class="text-sm font-bold uppercase tracking-widest text-primary/40 mr-2 flex items-center">Material</span>
<button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-medium text-sm hover:bg-surface-container-high transition-all">Raw Ceramic</button>
<button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-medium text-sm hover:bg-surface-container-high transition-all">Oak Wood</button>
<button class="px-6 py-2 rounded-full bg-surface-container-highest text-on-surface-variant font-medium text-sm hover:bg-surface-container-high transition-all">Brushed Brass</button>
</div>
</div>
</section>
<!-- Product Grid: Asymmetric Composition -->
<section class="max-w-7xl mx-auto px-8">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
<!-- Product 1 -->
<div class="flex flex-col group">
<div class="aspect-square bg-surface-container-lowest overflow-hidden mb-6 relative">
<img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Close up of a textured off-white handcrafted ceramic bowl on a neutral stone surface with harsh sunlight" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBSnf1156EQdX2MH72GtxKaR5GYEDJQfVtGmQkDF7L2gBIsCBRtg23FDBi93o83UjVbYhRbcOJcvJzHTUY4S4zx-0WwWoHvoE_8yhH6aPHe-KVCMAfrq-62taD_HLJTRLN_PXGnFHPDWEGndUiVh_jZkXhVifT_EAu_Yy66zphBuFh_2WwFbPsZaEH_cnj4xfa4U7CiMtuawwA63L4ImQX-WtZUKW282vChv7tD2A_NnXqPL1h8F2w6p6zQXEPGO1bCBaLGp5TXtkc"/>
<div class="absolute top-4 right-4 bg-white/60 backdrop-blur-md px-3 py-1 rounded-full text-[10px] uppercase tracking-widest font-bold">Limited Edition</div>
</div>
<div class="flex justify-between items-start">
<div>
<h3 class="text-lg font-bold text-primary group-hover:text-secondary transition-colors">Obsidian Rimmed Vessel</h3>
<p class="text-sm text-on-surface-variant font-body">Hand-thrown Stoneware</p>
</div>
<span class="text-lg font-headline font-bold text-primary">$124.00</span>
</div>
<button class="mt-6 w-full py-4 bg-primary text-white font-bold tracking-widest uppercase text-xs hover:bg-primary-container transition-all flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 duration-300">
                        View Piece
                        <span class="material-symbols-outlined text-sm" data-icon="arrow_forward">arrow_forward</span>
</button>
</div>
<!-- Product 2 (Large Vertical) -->
<div class="flex flex-col group lg:row-span-2">
<div class="aspect-[3/4] bg-surface-container-lowest overflow-hidden mb-6">
<img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Tall minimalist wooden floor lamp with a linen shade standing in a bright corner of a modern apartment" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC8iMQdPeNzngKnnZ9L-mvOxi5YZ-N1EI77iq3Adbcky-fPeSyvkcJvaSvltyxqRptuKiX5olJ1xHpc7CiMeABOAQqCmaipS-4CTSXEVCBUehcRZLWKYzdWpu_ZnmFU5GufYMlVx1LuuK2b-dG3souZyxzvQXBKsVmQ0dM0VLkAFfUPW2DNELk4QcAgBR2g1KKSQvK1fn1Mj9wofqB6Vj506iUNOAjtk_DFErD2bDfLAijItNqhA3KKBlD7hIN7R3FhHHNBE17JDbg"/>
</div>
<div class="flex justify-between items-start">
<div>
<h3 class="text-lg font-bold text-primary group-hover:text-secondary transition-colors">Nordic Oak Luminary</h3>
<p class="text-sm text-on-surface-variant font-body">Sustainably Sourced Oak</p>
</div>
<span class="text-lg font-headline font-bold text-primary">$490.00</span>
</div>
<button class="mt-6 w-full py-4 bg-secondary text-on-secondary font-bold tracking-widest uppercase text-xs hover:scale-102 transition-all flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 duration-300">
                        Add to Collection
                        <span class="material-symbols-outlined text-sm" data-icon="add">add</span>
</button>
</div>
<!-- Product 3 -->
<div class="flex flex-col group">
<div class="aspect-square bg-surface-container-lowest overflow-hidden mb-6">
<img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Sleek black architectural chair with thin metal legs in an empty white gallery space" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD8jRBAgshCijL0zURjxWBNe5Lhm_rayTTZNCLLMpAPXw5St9KZxtP6J-mbDJl2ANNt57n8u2gN0TKOp77hwwqXVGeXCiX2we4hPB5CVGeoo0DPJNZcrZ7vbGoO4Xh1EtlPrpw1DDxlQAh6h_Tl93rFlQINsVtdoMX5JcMP6xUiVtdACQU03Ha4_7y7yfmkENgY3Kx8SuPbc1fEuoX03ThPWuj-x4jUNpHd7bGo7ckLssQct8tV06uYwVEx4GoOGshrFxrteUkNtwQ"/>
</div>
<div class="flex justify-between items-start">
<div>
<h3 class="text-lg font-bold text-primary group-hover:text-secondary transition-colors">Void Lounge Chair</h3>
<p class="text-sm text-on-surface-variant font-body">Powder Coated Steel</p>
</div>
<span class="text-lg font-headline font-bold text-primary">$1,200.00</span>
</div>
<button class="mt-6 w-full py-4 bg-primary text-white font-bold tracking-widest uppercase text-xs hover:bg-primary-container transition-all flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 duration-300">
                        Inquire
                    </button>
</div>
<!-- Product 4 -->
<div class="flex flex-col group">
<div class="aspect-square bg-surface-container-lowest overflow-hidden mb-6 relative">
<img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Set of three organic-shaped clay bud vases in shades of terracotta and cream on a minimalist shelf" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCQWIYoesf9Robt2M2KHFsPQIleAMoJ8MjQPcVDQT7tvXwAvmM0b4KcNCnQYUQT7R7oj6peBtfzQvPj4YZz7jsNg3st03ZNRBocaC-cbGoHkDdvYybXzqSQEiCQneWKSzohDmwW9CvudV5dbetXfjU3cQ1AcJ2v71FH1xn5LepnvwC7BhLoKgouQI8qjgzyWabWAotjbE92iF4-X49OwT--V1fFCRELObYJWjdq-XraMTysT6epLxVcVibPqg5o8FcE508E_xGqSTg"/>
</div>
<div class="flex justify-between items-start">
<div>
<h3 class="text-lg font-bold text-primary group-hover:text-secondary transition-colors">Triptych Bud Vases</h3>
<p class="text-sm text-on-surface-variant font-body">Hand-sculpted Clay</p>
</div>
<span class="text-lg font-headline font-bold text-primary">$85.00</span>
</div>
</div>
<!-- Product 5 -->
<div class="flex flex-col group">
<div class="aspect-square bg-surface-container-lowest overflow-hidden mb-6">
<img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Detail of a minimalist linen throw blanket with raw edges draped over a wooden bench" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBcLfop4v1vFwsaydNLMoBV-wyTt5Cfr7eX4-sJOLKDcxO_OMTLfYc3A73vb2fguUzcZIwUieQLkY0c5fpntM93QEEjVS4HUb9-XMEosFwTkn7IDIBP_6Q7ScChM1gVrEJ-fd8dYU2VC24uyHorMqXxSUIJXH9u3kGiGhbyWaXWeGcdadMYamSvC9PKDQSd1dtozGsJtJ9u8fW6Zg_-avglYufExDlJpMijotDbYNttxy8tsB8ZPG_q8Md6tfwys4OQQJ6n0pBF_vQ"/>
</div>
<div class="flex justify-between items-start">
<div>
<h3 class="text-lg font-bold text-primary group-hover:text-secondary transition-colors">Raw Edge Linen Throw</h3>
<p class="text-sm text-on-surface-variant font-body">100% Organic Linen</p>
</div>
<span class="text-lg font-headline font-bold text-primary">$110.00</span>
</div>
</div>
</div>
</section>
<!-- CTA Section -->
<section class="max-w-7xl mx-auto px-8 mt-40">
<div class="bg-primary-container rounded-xl p-12 md:p-20 relative overflow-hidden text-center md:text-left flex flex-col md:flex-row items-center gap-12">
<div class="relative z-10 max-w-2xl">
<span class="text-primary-fixed uppercase tracking-widest font-bold text-xs mb-4 block">Personal Consultation</span>
<h2 class="text-4xl md:text-5xl font-bold text-on-primary-container font-headline mb-6">Create your bespoke living sanctuary</h2>
<p class="text-on-primary-container opacity-80 mb-8 text-lg">Work with our interior curators to select the perfect architectural pieces for your space.</p>
<button class="px-10 py-4 bg-secondary text-white font-bold rounded-lg hover:scale-105 transition-all shadow-lg">Book Studio Tour</button>
</div>
<div class="w-full md:w-1/3 aspect-square rounded-full overflow-hidden border-8 border-white/10 relative z-10">
<img class="w-full h-full object-cover" data-alt="Interior designer looking at architectural blueprints and ceramic samples in a sun-drenched minimalist studio" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA5A7M1sW9q4AhHx8_ylgxavsxo70Q3Yw2fcfqikGW5XZGlipjDFZqc7R51tmQLaHMjsxi0BkpZ2aFCvLCkaFVBgwgtq60jebqCqPNgKPqFKvyaGc3VzXx6puAJrsMmcRhmzWPBcBCf6lCP_Y_arRS7J52XHJakOxexYdlEu8R4WZuvgw3S2xLUe6wTNbA8P25-fsCgQTc55nDkKL855wGJdWTjDXpCyOjmwPtcHZ7J2d8R3ldBGnCHMwC89015Kp-HRQt-kxFBLAc"/>
</div>
<!-- Abstract Texture Background -->
<div class="absolute -right-20 -top-20 w-96 h-96 bg-secondary/10 rounded-full blur-3xl"></div>
<div class="absolute -left-20 -bottom-20 w-96 h-96 bg-primary/20 rounded-full blur-3xl"></div>
</div>
</section>
</main>
<?php include __DIR__ . '/../components/ui/footer.php'; ?>
</body></html>