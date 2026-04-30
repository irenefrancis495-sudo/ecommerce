<?php

use Mpemba\Utils\Router;

require __DIR__ . '/config/bootstrap.php';
session_start();

?>
<!DOCTYPE html>
<<<<<<< HEAD
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Router::getPathName() ?></title>
    <link href="styles.css" rel="stylesheet">
=======

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?=  Router::getPathName() ?></title>
<link href="styles.css" rel="stylesheet">
>>>>>>> main
    <script src="assets/jquery/jquery.min.js"></script>
    <script src="assets/sweetalert2/sweetalert2.all.min.js"></script>
    <link href="assets/DataTables/datatables.min.css" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <script src="assets/tailwindcss/tailwindv3.js"></script> -->
 <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

<link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;800;900&amp;family=Manrope:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "surface-container-lowest": "#ffffff",
                    "surface-container-low": "#f2f4f6",
                    "on-background": "#191c1e",
                    "surface-dim": "#d9dadc",
                    "on-tertiary-fixed": "#221b00",
                    "tertiary-container": "#c9a900",
                    "secondary-fixed": "#ffdcc3",
                    "on-tertiary-container": "#4c3f00",
                    "secondary-container": "#ffa454",
                    "inverse-primary": "#96ceeb",
                    "on-error": "#ffffff",
                    "primary": "#003345",
                    "surface-bright": "#f8f9fb",
                    "on-secondary": "#ffffff",
                    "on-primary-fixed": "#001f2b",
                    "surface-container-high": "#e7e8ea",
                    "tertiary-fixed": "#ffe16d",
                    "on-error-container": "#93000a",
                    "on-secondary-fixed-variant": "#6e3900",
                    "inverse-on-surface": "#f0f1f3",
                    "outline-variant": "#c0c7cd",
                    "surface": "#f8f9fb",
                    "error": "#ba1a1a",
                    "surface-container": "#edeef0",
                    "inverse-surface": "#2e3133",
                    "background": "#f8f9fb",
                    "outline": "#71787d",
                    "error-container": "#ffdad6",
                    "on-tertiary": "#ffffff",
                    "primary-fixed-dim": "#96ceeb",
                    "primary-fixed": "#bfe8ff",
                    "on-surface-variant": "#40484c",
                    "secondary-fixed-dim": "#ffb77d",
                    "secondary": "#904d00",
                    "primary-container": "#004b63",
                    "on-primary-fixed-variant": "#044d65",
                    "on-secondary-container": "#713b00",
                    "surface-variant": "#e1e2e5",
                    "on-primary": "#ffffff",
                    "surface-container-highest": "#e1e2e5",
                    "surface-tint": "#2a657e",
                    "on-secondary-fixed": "#2f1500",
                    "on-tertiary-fixed-variant": "#544600",
                    "tertiary": "#705d00",
                    "on-primary-container": "#83bad6",
                    "on-surface": "#191c1e",
                    "tertiary-fixed-dim": "#e9c400"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "fontFamily": {
                    "headline": ["Epilogue"],
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
        .text- editorial-shadow {
            text-shadow: 0 4px 12px rgba(0, 51, 69, 0.1);
        }
    </style>
</head>
<body class="bg-surface font-body text-on-surface antialiased">
<?php Router::load()?>;

</body></html>
