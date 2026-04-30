<!DOCTY 
html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Mpemba Marketplace | Welcome</title>
    setTimeout(function() {
        window.location.href = 'index.php';
    }, 3000); // Redirect after 3 seconds
</script>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": 

                    "background": "#f8f9fb",
                    "on-error-container": "#93000a",
                    "surface": "#f8f9fb",
                    "secondary-container": "#ffa454",
                    "on-surface-variant": "#40484c",
                    "on-surface": "#191c1e",
                    "inverse-on-surface": "#f0f1f3",
                    "outline-variant": "#c0c7cd",
                    "on-secondary-fixed": "#2f1500",
                    "error-container": "#ffdad6",
                    "secondary-fixed-dim": "#ffb77d",
                    "inverse-surface": "#2e3133",
                    "on-primary-fixed-variant": "#044d65",
                    "tertiary-fixed-dim": "#e9c400",
                    "primary-container": "#004b63",
                    "on-tertiary-container": "#4c3f00",
                    "on-primary-fixed": "#001f2b",
                    "on-tertiary": "#ffffff",
                    "inverse-primary": "#96ceeb",
                    "surface-container-highest": "#e1e2e5",
                    "surface-bright": "#f8f9fb",
                    "tertiary-fixed": "#ffe16d",
                    "surface-tint": "#2a657e",
                    "surface-container-low": "#f2f4f6",
                    "surface-container-high": "#e7e8ea",
                    "on-secondary-fixed-variant": "#6e3900",
                    "tertiary-container": "#c9a900",
                    "on-primary": "#ffffff",
                    "secondary": "#904d00",
                    "on-secondary-container": "#713b00",
                    "on-background": "#191c1e",
                    "secondary-fixed": "#ffdcc3",
                    "on-secondary": "#ffffff",
                    "on-primary-container": "#83bad6",
                    "outline": "#71787d",
                    "on-error": "#ffffff",
                    "surface-dim": "#d9dadc",
                    "surface-variant": "#e1e2e5",
                    "error": "#ba1a1a",
                    "surface-container-lowest": "#ffffff",
                    "primary-fixed": "#bfe8ff",
                    "tertiary": "#705d00",
                    "primary": "#003345",
                    "on-tertiary-fixed-variant": "#544600",
                    "surface-container": "#edeef0",
                    "primary-fixed-dim": "#96ceeb",
                    "on-tertiary-fixed": "#221b00"
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
<style>.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24
    }
.splash-gradient {
    background: radial-gradient(circle at center, #004b63 0%, #003345 100%)
    }
.grain-texture::before {
    content: "";
    position: absolute;
    inset: 0;
    opacity: 0.03;
    pointer-events: none;
    background-image: url(https://images.unsplash.com/photo-1473187983305-f615310e7daa?w=1600&h=1200&fit=crop&crop=center)
    }
.loading-line {
    width: 80px;
    height: 1px;
    background: #904d00;
    position: relative;
    overflow: hidden
    }
.loading-line::after {
    content: "";
    position: absolute;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, #ffa454, transparent);
    animation: slide 2s infinite ease-in-out
    }
@keyframes slide {
    0% {
        left: -100%;
        } 100% {
        left: 100%;
        }
    }
.float-slow {
    animation: float 6s ease-in-out infinite
    }
@keyframes float {
    0%, 100% {
        transform: translateY(0px);
        } 50% {
        transform: translateY(-10px);
        }
    }</style>
</head>
<body class="bg-primary text-on-primary font-body overflow-hidden">
<!-- Splash Screen Container -->
<main class="relative flex flex-col items-center justify-center min-h-screen splash-gradient grain-texture px-6">
<!-- Background Atmospheric Element -->
<div class="absolute inset-0 overflow-hidden pointer-events-none">
<div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] rounded-full bg-primary-container/20 blur-[120px]"></div>
<div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-secondary/10 blur-[100px]"></div>
</div>
<!-- Identity Cluster -->
<div class="relative z-10 flex flex-col items-center text-center space-y-8 float-slow">
<!-- Branding -->
<div class="space-y-3">
<h1 class="font-headline text-5xl md:text-7xl font-extrabold tracking-tighter text-white">
                    Mpemba<span class="text-secondary-container">.</span>
</h1>
<div class="flex items-center justify-center space-x-4">
<div class="h-[1px] w-8 bg-on-primary-container/30"></div>
<p class="font-headline text-xs md:text-sm uppercase tracking-[0.4em] text-on-primary-container font-light">
                        The Art of Curation
                    </p>
<div class="h-[1px] w-8 bg-on-primary-container/30"></div>
</div>
</div>
<!-- Visual Anchor / Placeholder for high-end photography focus -->
<div class="mt-12 group">
<div class="relative w-48 h-64 md:w-56 md:h-72 bg-primary-container overflow-hidden rounded-xl shadow-2xl transition-transform duration-700 group-hover:scale-105">
<img alt="High-end curated object" class="w-full h-full object-cover opacity-80 mix-blend-luminosity grayscale hover:grayscale-0 transition-all duration-1000" src="https://images.unsplash.com/photo-1498079022511-d15614cb1c02?w=800&h=1100&fit=crop&crop=center" />
<div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent"></div>
</div>
</div>
<!-- Minimalist Loading Indicator -->
<div class="pt-12 flex flex-col items-center space-y-4">
<div class="loading-line"></div>
<span class="font-label text-[10px] tracking-widest text-on-primary-container/60 uppercase">
                    Initialising Atelier
                </span>
</div>
</div>
<!-- Discrete Branding Detail -->
<div class="absolute bottom-12 left-0 w-full flex justify-center z-10">
<div class="flex items-center space-x-2 opacity-40">
<span class="material-symbols-outlined text-[14px]">verified_user</span>
<span class="font-label text-[9px] tracking-[0.2em] uppercase">Secured Marketplace Protocol</span>
</div>
</div>
</main>
<!-- Aesthetic Border (Digital Atelier Frame) -->
<div class="fixed inset-0 pointer-events-none border-[24px] border-primary-container/10"></div>
<div class="fixed inset-0 pointer-events-none border-[1px] border-white/5 m-6"></div>
</body></html>