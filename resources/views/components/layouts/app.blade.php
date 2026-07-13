<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Google Fonts: Hanken Grotesk -->
        <link href="https://fonts.googleapis.com" rel="preconnect">
        <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&amp;display=swap" rel="stylesheet">
        <!-- Material Symbols -->
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

        <script id="tailwind-config">
         tailwind.config = {
             darkMode: "class",
             theme: {
                 extend: {
                     "colors": {
                         "surface-container-high": "#dce9ff",
                         "on-error": "#ffffff",
                         "error": "#ba1a1a",
                         "inverse-primary": "#ffb693",
                         "on-tertiary-fixed-variant": "#004b70",
                         "inverse-surface": "#213145",
                         "on-primary-fixed-variant": "#7a3000",
                         "on-secondary-container": "#6a4800",
                         "surface-bright": "#f8f9ff",
                         "secondary-fixed-dim": "#ffba38",
                         "on-tertiary": "#ffffff",
                         "background": "#f8f9ff",
                         "secondary-container": "#feb300",
                         "surface-container-lowest": "#ffffff",
                         "on-primary": "#ffffff",
                         "inverse-on-surface": "#eaf1ff",
                         "surface-tint": "#a04100",
                         "surface-dim": "#cbdbf5",
                         "primary-fixed-dim": "#ffb693",
                         "on-error-container": "#93000a",
                         "on-tertiary-fixed": "#001e30",
                         "surface": "#f8f9ff",
                         "surface-variant": "#d3e4fe",
                         "tertiary": "#006493",
                         "primary-container": "#ff6b00",
                         "primary": "#a04100",
                         "surface-container-highest": "#d3e4fe",
                         "tertiary-fixed": "#cae6ff",
                         "on-background": "#0b1c30",
                         "on-tertiary-container": "#003550",
                         "primary-fixed": "#ffdbcc",
                         "on-secondary-fixed-variant": "#604100",
                         "on-primary-container": "#572000",
                         "outline": "#8e7164",
                         "surface-container": "#e5eeff",
                         "on-primary-fixed": "#351000",
                         "tertiary-container": "#00a2eb",
                         "on-secondary-fixed": "#281900",
                         "on-secondary": "#ffffff",
                         "outline-variant": "#e2bfb0",
                         "surface-container-low": "#eff4ff",
                         "on-surface-variant": "#5a4136",
                         "error-container": "#ffdad6",
                         "secondary-fixed": "#ffdeac",
                         "secondary": "#7e5700",
                         "on-surface": "#0b1c30",
                         "tertiary-fixed-dim": "#8dcdff"
                     },
                     "borderRadius": {
                         "DEFAULT": "0.25rem",
                         "lg": "0.5rem",
                         "xl": "0.75rem",
                         "full": "9999px"
                     },
                     "spacing": {
                         "3xl": "64px",
                         "lg": "24px",
                         "margin-mobile": "16px",
                         "sm": "8px",
                         "margin-desktop": "48px",
                         "xs": "4px",
                         "xl": "32px",
                         "md": "16px",
                         "2xl": "48px",
                         "gutter": "24px",
                         "base": "4px"
                     },
                     "fontFamily": {
                         "body-lg": ["Hanken Grotesk"],
                         "headline-md": ["Hanken Grotesk"],
                         "label-md": ["Hanken Grotesk"],
                         "body-sm": ["Hanken Grotesk"],
                         "headline-lg-mobile": ["Hanken Grotesk"],
                         "headline-lg": ["Hanken Grotesk"],
                         "headline-sm": ["Hanken Grotesk"],
                         "label-sm": ["Hanken Grotesk"],
                         "body-md": ["Hanken Grotesk"]
                     },
                     "fontSize": {
                         "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                         "headline-md": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                         "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.02em", "fontWeight": "600"}],
                         "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                         "headline-lg-mobile": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "700"}],
                         "headline-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                         "headline-sm": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                         "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.04em", "fontWeight": "600"}],
                         "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
                     }
                 },
             },
         }
          </script>
        <style>
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            }
            .tonal-elevation-1 {
                background-color: #ffffff;
                border: 1px solid #E2E8F0;
                box-shadow: 0px 4px 12px rgba(0,0,0,0.05);
            }
            .data-table-header {
                background-color: #f8f9ff;
            }
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            ::-webkit-scrollbar-track {
                background: transparent;
            }
            ::-webkit-scrollbar-thumb {
                background: #dce9ff;
                border-radius: 10px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #cbd5e1;
            }
        </style>
        <title>{{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body>
        {{ $slot }}

        @livewireScripts
    </body>
</html>
