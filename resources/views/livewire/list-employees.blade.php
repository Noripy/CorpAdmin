

<div class="bg-background text-on-surface font-body-md min-h-screen flex overflow-hidden">
   <!-- Sidebar Navigation -->
   <aside class="hidden md:flex flex-col h-screen p-md gap-sm bg-surface-container-low border-r border-outline-variant w-64 shrink-0">
      <div class="flex items-center gap-md px-md py-lg">
         <div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center">
            <span class="material-symbols-outlined text-on-primary-container" style="font-variation-settings: 'FILL' 1;">corporate_fare</span>
         </div>
         <div>
            <h1 class="font-headline-sm text-headline-sm font-bold text-on-surface">CorpAdmin</h1>
            <p class="font-label-sm text-label-sm text-on-surface-variant">管理者コンソール</p>
         </div>
      </div>
      <nav class="flex-grow flex flex-col gap-xs mt-lg">
         <a class="flex items-center gap-md text-on-surface-variant px-md py-sm hover:bg-surface-container-high rounded-lg transition-all duration-200 ease-in-out" href="#">
         <span class="material-symbols-outlined">dashboard</span>
         <span class="font-label-md text-label-md">ダッシュボード</span>
         </a>
         <a class="flex items-center gap-md bg-primary-container text-on-primary-container rounded-lg px-md py-sm font-bold transition-all duration-200 ease-in-out" href="#">
         <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">group</span>
         <span class="font-label-md text-label-md">社員管理</span>
         </a>
      </nav>
      <div class="border-t border-outline-variant pt-sm">
         <a class="flex items-center gap-md text-on-surface-variant px-md py-sm hover:bg-surface-container-high rounded-lg transition-all" href="#">
         <span class="material-symbols-outlined">logout</span>
         <span class="font-label-md text-label-md">ログアウト</span>
         </a>
      </div>
   </aside>
   <!-- Main Content Area -->
   <main class="flex-grow flex flex-col h-screen overflow-hidden">
      <!-- Top Bar -->
      <header class="bg-surface-container-lowest flex justify-between items-center w-full px-lg py-sm border-b border-outline-variant shadow-sm shrink-0">
         <div class="flex items-center gap-xl flex-grow max-w-3xl">
            <h2 class="font-headline-sm text-headline-sm font-bold text-primary shrink-0">社員名簿</h2>
            <!-- Universal Search -->
             <!--
            <div class="relative w-full max-w-md ml-lg hidden sm:block">
               <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">search</span>
               <input class="w-full pl-10 pr-md py-2 bg-surface-container-low border border-outline-variant rounded-lg text-body-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all" placeholder="社員、ID、タグを検索..." type="text">
            </div> 
-->
         </div>
         <div class="flex items-center gap-md">
            <div class="flex items-center gap-sm">
               <button class="p-2 hover:bg-surface-container-high rounded-full transition-colors cursor-pointer text-on-surface-variant">
               <span class="material-symbols-outlined">notifications</span>
               </button>
               <button class="p-2 hover:bg-surface-container-high rounded-full transition-colors cursor-pointer text-on-surface-variant">
               <span class="material-symbols-outlined">help</span>
               </button>
               <div class="h-8 w-px bg-outline-variant mx-2"></div>
               <img class="w-9 h-9 rounded-full object-cover border border-outline-variant cursor-pointer" data-alt="プロフェッショナルなエグゼクティブ女性のヘッドショット。紺のブレザーを着用。" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDmEuiuR4JHsIK2Tgnh4GmZyZBMfQneayGv4wUH-na5B5q3O3SaPFWxtTViUSaZ3oX2IJL-7qvFKxAxBIfKnR9awKIY8AaV38ph5gxA67Qm1PBdxC-MyCVjPQs0HzgBwCks-jFyJ7FPzeUNWCZzfuawdpKPY8PBUJRBGmFLgqifSZ2cq3eNmePYdCXYwwAbHQSf5rTf1FDerbKGjD99UJlviFfAIbq4xsAladGP-GTDdzMlWtbap1Te7Dp3zgh9dEEpt9Vd6BRcfvY">
            </div>
         </div>
      </header>
      <!-- Dynamic Content Scrollable Area -->
      <section class="flex-grow overflow-y-auto px-lg py-lg space-y-lg">
         <!-- Filters and Primary Action -->
         <div class="flex flex-col md:flex-row md:items-center justify-between gap-md">
            <div class="flex flex-wrap items-center gap-sm">
               <div class="group relative">
                  <select wire:model.live="department" class="flex items-center gap-xs px-md py-2 bg-surface-container-lowest border border-outline-variant rounded-lg font-label-md hover:bg-surface-container-low transition-colors">
                     <option value="">部署</option>
                     @foreach($departments as $d)
                        <option value="{{ $d }}">{{ $d }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="group relative">
                  <select wire:model.live="position" class="flex items-center gap-xs px-md py-2 bg-surface-container-lowest border border-outline-variant rounded-lg font-label-md hover:bg-surface-container-low transition-colors">
                     <option value="">役職</option>
                     @foreach($positions as $p)
                        <option value="{{ $p }}">{{ $p }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="group relative">
                  <button class="flex items-center gap-xs px-md py-2 bg-surface-container-lowest border border-outline-variant rounded-lg font-label-md hover:bg-surface-container-low transition-colors text-on-surface-variant">
                  詳細フィルタ
                  </button>
               </div>
               <button wire:click="resetFilters" class="text-primary font-label-md hover:underline px-sm">全てクリア</button>
            </div>
            <button class="flex items-center justify-center gap-sm bg-primary text-on-primary font-label-md px-xl py-3 rounded-lg shadow-md hover:shadow-lg active:scale-[0.98] transition-all">
            <span class="material-symbols-outlined">person_add</span>
            新規社員登録
            </button>
         </div>
         <!-- Employee Table Card -->
         <div class="tonal-elevation-1 rounded-xl overflow-hidden flex flex-col">
            <div class="overflow-x-auto">
               <table class="w-full text-left border-collapse">
                  <thead>
                     <tr class="data-table-header border-b border-outline-variant">
                        <th class="px-lg py-md font-label-sm text-on-surface-variant">社員ID</th>
                        <th class="px-lg py-md font-label-sm text-on-surface-variant">氏名</th>
                        <th class="px-lg py-md font-label-sm text-on-surface-variant">部署</th>
                        <th class="px-lg py-md font-label-sm text-on-surface-variant">役職</th>
                        <th class="px-lg py-md font-label-sm text-on-surface-variant">メールアドレス</th>
                        <th class="px-lg py-md font-label-sm text-on-surface-variant">ステータス</th>
                        <th class="px-lg py-md font-label-sm text-on-surface-variant text-right">操作</th>
                     </tr>
                  </thead>

                  <tbody class="divide-y divide-outline-variant">
                     @foreach($employees as $employee)
                        <tr class="hover:bg-surface-container-low transition-colors" style="opacity: 1; transform: translateY(0px); transition: 0.4s ease-out;">
                           <td class="px-lg py-md font-body-sm">{{ $employee->id }}</td>
                           <td class="px-lg py-md">
                              <div class="flex items-center gap-md">
                                 <div class="w-8 h-8 rounded-full bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed font-bold text-xs">SK</div>
                                 <span class="font-label-md">{{ $employee->name }}</span>
                              </div>
                           </td>
                           <td class="px-lg py-md font-body-sm">{{ $employee->department }}</td>
                           <td class="px-lg py-md font-body-sm">{{ $employee->position }}</td>
                           <td class="px-lg py-md font-body-sm text-on-surface-variant">{{ $employee->email }}</td>
                           <td class="px-lg py-md">
                              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                              <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>
                              {{ $employee->job_status }}
                              </span>
                           </td>
                           <td class="px-lg py-md text-right">
                              <button class="p-1 hover:text-primary transition-colors"><span class="material-symbols-outlined text-[20px]">edit</span></button>
                              <button class="p-1 hover:text-error transition-colors"><span class="material-symbols-outlined text-[20px]">delete</span></button>
                           </td>
                        </tr>
                     @endforeach
                  </tbody>

               </table>
            </div>
         </div>
      </section>
      <!-- Contextual FAB (Only for key action pages) -->
      <button class="md:hidden fixed bottom-6 right-6 w-14 h-14 bg-primary text-on-primary rounded-full shadow-2xl flex items-center justify-center active:scale-90 transition-transform z-50">
      <span class="material-symbols-outlined text-3xl">person_add</span>
      </button>
   </main>
   <script>
      // Micro-interactions and effects
      document.addEventListener('DOMContentLoaded', () => {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
               row.style.opacity = '0';
               row.style.transform = 'translateY(10px)';
               setTimeout(() => {
                  row.style.transition = 'all 0.4s ease-out';
                  row.style.opacity = '1';
                  row.style.transform = 'translateY(0)';
               }, 50 * index);
            });
      });
      
      // Search Bar Focus Effect
      const searchInput = document.querySelector('input[type="text"]');
      if (searchInput) {
            searchInput.addEventListener('focus', () => {
               searchInput.parentElement.classList.add('scale-[1.02]');
               searchInput.parentElement.style.transition = 'transform 0.2s ease-out';
            });
            searchInput.addEventListener('blur', () => {
               searchInput.parentElement.classList.remove('scale-[1.02]');
            });
      }
   </script>
</div>
