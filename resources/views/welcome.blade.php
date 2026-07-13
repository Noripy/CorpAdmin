<!DOCTYPE html>
<html class="light" lang="ja">
   <head>
      <meta charset="utf-8"/>
      <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
      <title>CorpAdminへようこそ</title>
      <!-- Tailwind CSS -->
      <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
      <!-- Material Symbols -->
      <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
      <!-- Hanken Grotesk Font -->
      <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700&amp;display=swap" rel="stylesheet"/>
      <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
      <script id="tailwind-config">
         tailwind.config = {
           darkMode: "class",
           theme: {
             extend: {
               "colors": {
                       "error-container": "#ffdad6",
                       "on-secondary-fixed": "#281900",
                       "tertiary-container": "#59a0d2",
                       "secondary-fixed-dim": "#f2be65",
                       "on-secondary": "#ffffff",
                       "inverse-on-surface": "#eaf1ff",
                       "on-primary-fixed": "#351000",
                       "primary": "#a04100",
                       "surface-variant": "#d3e4fe",
                       "on-error-container": "#93000a",
                       "status-warning-bg": "#ffedd5",
                       "secondary-container": "#ffc96f",
                       "primary-fixed-dim": "#ffb693",
                       "on-surface-variant": "#5a4136",
                       "on-background": "#0b1c30",
                       "status-success-text": "#15803d",
                       "on-primary-fixed-variant": "#7a3000",
                       "tertiary-fixed-dim": "#8dcdff",
                       "surface-dim": "#cbdbf5",
                       "surface-container-highest": "#d3e4fe",
                       "on-error": "#ffffff",
                       "secondary-fixed": "#ffdeac",
                       "on-tertiary-fixed-variant": "#004b70",
                       "error": "#ba1a1a",
                       "status-warning-text": "#c2410c",
                       "outline": "#8e7164",
                       "on-tertiary": "#ffffff",
                       "surface-low": "#eff4ff",
                       "inverse-surface": "#213145",
                       "outline-variant": "#e2bfb0",
                       "inverse-primary": "#ffb693",
                       "surface-container": "#e5eeff",
                       "tertiary": "#006493",
                       "outline-muted": "#e2bfb0",
                       "on-tertiary-container": "#003550",
                       "surface-tint": "#a04100",
                       "on-surface": "#0b1c30",
                       "surface-bg": "#f8f9ff",
                       "on-secondary-fixed-variant": "#5f4100",
                       "background": "#f8f9ff",
                       "surface-container-high": "#dce9ff",
                       "surface-container-low": "#eff4ff",
                       "surface-container-lowest": "#ffffff",
                       "on-primary-container": "#572000",
                       "on-primary": "#ffffff",
                       "primary-fixed": "#ffdbcc",
                       "on-tertiary-fixed": "#001e30",
                       "surface-bright": "#f8f9ff",
                       "primary-container": "#ff6b00",
                       "surface": "#f8f9ff",
                       "status-success-bg": "#dcfce7",
                       "tertiary-fixed": "#cae6ff",
                       "secondary": "#7e5700",
                       "on-secondary-container": "#785300"
               },
               "borderRadius": {
                       "DEFAULT": "0.125rem",
                       "lg": "0.25rem",
                       "xl": "0.5rem",
                       "full": "0.75rem"
               },
               "spacing": {
                       "sm": "8px",
                       "gutter": "24px",
                       "xl": "32px",
                       "lg": "24px",
                       "3xl": "64px",
                       "margin-mobile": "16px",
                       "margin-desktop": "48px",
                       "xs": "4px",
                       "2xl": "48px",
                       "md": "16px"
               },
               "fontFamily": {
                       "body-sm": ["Hanken Grotesk"],
                       "label-sm": ["Hanken Grotesk"],
                       "label-md": ["Hanken Grotesk"],
                       "body-md": ["Hanken Grotesk"],
                       "headline-md": ["Hanken Grotesk"],
                       "headline-sm": ["Hanken Grotesk"],
                       "headline-lg": ["Hanken Grotesk"],
                       "body-lg": ["Hanken Grotesk"]
               },
               "fontSize": {
                       "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                       "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.04em", "fontWeight": "600"}],
                       "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.02em", "fontWeight": "600"}],
                       "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                       "headline-md": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                       "headline-sm": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                       "headline-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                       "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}]
               }
             },
           },
         }
      </script>
      <style>
         .material-symbols-outlined {
         font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
         }
         body {
         font-family: 'Hanken Grotesk', sans-serif;
         background-color: #f8f9ff;
         }
         .bg-pattern {
         background-image: radial-gradient(circle at 2px 2px, #e2e8f0 1px, transparent 0);
         background-size: 40px 40px;
         }
      </style>
   </head>
   <body class="bg-surface text-on-surface overflow-x-hidden min-h-screen flex flex-col">
      <!-- TopNavBar -->
      <header class="fixed top-0 w-full z-50 flex justify-between items-center px-lg md:px-margin-desktop h-16 bg-surface-container-lowest border-b border-outline-variant shadow-sm">
         <div class="flex items-center gap-xs">
            <span class="material-symbols-outlined text-primary text-headline-sm" style="font-variation-settings: 'FILL' 1;">corporate_fare</span>
            <span class="font-headline-sm text-headline-sm font-bold text-primary">CorpAdmin</span>
         </div>
         <div class="flex items-center gap-lg">
            <div class="hidden md:flex items-center gap-md">
               <span class="font-body-md text-body-md text-on-surface-variant hover:text-primary cursor-pointer transition-colors">Help</span>
               <span class="font-body-md text-body-md text-on-surface-variant hover:text-primary cursor-pointer transition-colors">Support</span>
            </div>
            <button class="font-body-md text-body-md text-primary font-bold border-b-2 border-primary px-sm py-1 cursor-pointer active:scale-95 transition-transform">Log In</button>
         </div>
      </header>
      <!-- Main Content Canvas -->
      <main class="flex-grow flex items-center justify-center relative pt-16">
         <!-- Background Accents -->
         <div class="absolute inset-0 z-0 bg-pattern opacity-40"></div>
         <!-- Animated Background Shapes -->
         <div class="absolute top-20 left-10 w-64 h-64 bg-secondary-container opacity-10 rounded-full blur-3xl animate-pulse"></div>
         <div class="absolute bottom-20 right-10 w-96 h-96 bg-tertiary-container opacity-10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
         <!-- Welcome Card -->
         <div class="relative z-10 container mx-auto px-margin-mobile md:px-margin-desktop text-center">
            <div class="max-w-3xl mx-auto space-y-xl">
               <!-- Branding Icon -->
               <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary-fixed mb-md shadow-sm border border-outline-muted">
                  <span class="material-symbols-outlined text-primary text-[40px]" style="font-variation-settings: 'FILL' 1;">rocket_launch</span>
               </div>
               <!-- Headline -->
               <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">
                  CorpAdminへようこそ
               </h1>
               <!-- Subtext -->
               <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl mx-auto">
                  チームの管理を、もっとスマートに、もっとダイナミックに。
                  信頼性と効率性を極めた、次世代のエンタープライズ・アドミニストレーション・ツール。
               </p>
               <!-- Primary Action Button -->
               <div class="pt-lg">
                  <button class="bg-primary-container text-on-primary font-bold px-3xl py-md rounded-xl text-body-lg shadow-lg hover:shadow-xl hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-sm mx-auto group">
                    <a href="{{ route('employees.index') }}">
                     管理画面へ進む
                     <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                  </button>
               </div>
               <!-- Subtle Decorative Bento Stats (Simple Layout) -->
               <div class="grid grid-cols-1 md:grid-cols-3 gap-lg pt-2xl">
                  <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm flex flex-col items-center gap-sm hover:border-primary transition-colors cursor-default">
                     <div class="w-12 h-12 rounded-full bg-secondary-fixed flex items-center justify-center">
                        <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">speed</span>
                     </div>
                     <span class="font-label-md text-label-md text-on-surface-variant">高速なレスポンス</span>
                  </div>
                  <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm flex flex-col items-center gap-sm hover:border-primary transition-colors cursor-default">
                     <div class="w-12 h-12 rounded-full bg-tertiary-fixed flex items-center justify-center">
                        <span class="material-symbols-outlined text-tertiary" style="font-variation-settings: 'FILL' 1;">security</span>
                     </div>
                     <span class="font-label-md text-label-md text-on-surface-variant">エンタープライズ品質のセキュリティ</span>
                  </div>
                  <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm flex flex-col items-center gap-sm hover:border-primary transition-colors cursor-default">
                     <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">insights</span>
                     </div>
                     <span class="font-label-md text-label-md text-on-surface-variant">直感的なアナリティクス</span>
                  </div>
               </div>
            </div>
         </div>
      </main>
      <!-- Footer -->
      <footer class="w-full py-xl px-margin-desktop flex flex-col md:flex-row justify-between items-center gap-md bg-surface-dim border-t border-outline-variant">
         <div class="flex items-center gap-sm">
            <span class="font-label-md text-label-md font-bold text-on-surface">CorpAdmin Pro</span>
            <span class="font-label-sm text-label-sm text-on-surface-variant">© 2024 CorpAdmin Pro. Internal Use Only.</span>
         </div>
         <div class="flex items-center gap-xl">
            <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-on-surface transition-opacity duration-200" href="#">Privacy Policy</a>
            <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-on-surface transition-opacity duration-200" href="#">Terms of Service</a>
            <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-on-surface transition-opacity duration-200" href="#">Security</a>
         </div>
      </footer>
      <script>
         // Simple micro-interaction for button
         const mainBtn = document.querySelector('button');
         mainBtn.addEventListener('click', () => {
             console.log('Navigating to Dashboard...');
             // In a real app, this would route to the dashboard
         });
         
         // Add a subtle parallax effect to the background shapes
         window.addEventListener('mousemove', (e) => {
             const shapes = document.querySelectorAll('.rounded-full.blur-3xl');
             const x = (e.clientX / window.innerWidth) - 0.5;
             const y = (e.clientY / window.innerHeight) - 0.5;
             
             shapes.forEach((shape, index) => {
                 const speed = (index + 1) * 20;
                 shape.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
             });
         });
      </script>
   </body>
</html>