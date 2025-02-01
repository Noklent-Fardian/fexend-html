<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" defer href="../dist/css/app.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // Initialize dark mode before Alpine loads
        if (
            localStorage.getItem("darkMode") === "true" ||
            (!localStorage.getItem("darkMode") &&
                window.matchMedia("(prefers-color-scheme: dark)").matches)
        ) {
            document.documentElement.classList.add("dark");
        }
    </script>
    <style>
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--color-background);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.3s ease-out;
        }

        .dark #loading-screen {
            background-color: var(--color-background-dark);
        }

        .mobile-menu {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: var(--color-foreground);
            padding: 0.5rem;
            display: flex;
            justify-content: center;
            z-index: 50;
        }

        .dark .mobile-menu {
            background-color: var(--color-background-dark);
        }

        .mobile-menu-popup {
            position: fixed;
            bottom: 5rem;
            /* Increased to account for taller button */
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 320px;
            background-color: var(--color-foreground);
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 50;
        }

        .dark .mobile-menu-popup {
            background-color: var(--color-background-dark);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body x-data="{
    darkMode: localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches),
    sidebarOpen: window.innerWidth >= 1024,
    mobileMenuOpen: false,
    isMobile: window.innerWidth < 768,
    toggleDarkMode() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}" x-init="window.addEventListener('resize', () => {
    if (window.innerWidth < 1024) sidebarOpen = false;
    isMobile = window.innerWidth < 768;
    if (!isMobile) mobileMenuOpen = false;
});
setTimeout(() => {
    document.getElementById('loading-screen').style.opacity = '0';
    setTimeout(() => {
        document.getElementById('loading-screen').style.display = 'none';
    }, 300);
}, 500);">
    <!-- Loading Screen -->
    <div id="loading-screen" class="fixed inset-0 bg-background dark:bg-background-dark flex justify-center items-center z-[9999] transition-opacity duration-300">
        <div class="flex space-x-2">
            <div class="loading-dot"></div>
            <div class="loading-dot"></div>
            <div class="loading-dot"></div>
        </div>
    </div>

    <div class="main-content">
        <nav class="navbar-layout">
            <div class="px-3 py-3 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" class="navbar-button">
                            <!-- Tabler menu icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2 w-6 h-6 dark:text-gray-200" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="4" y1="6" x2="20" y2="6" />
                                <line x1="4" y1="12" x2="20" y2="12" />
                                <line x1="4" y1="18" x2="20" y2="18" />
                            </svg>
                        </button>
                        <span class="ml-3 text-xl font-semibold dark:text-white">Lexend Dashboard</span>
                    </div>

                    <div class="flex items-center gap-4">
                        <!-- Notifications -->
                        <button class="navbar-button relative">
                            <!-- Tabler bell icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bell w-6 h-6 dark:text-gray-200" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a1 1 0 0 0 .293 .707l1 1a1 1 0 0 1 -.707 1.707h-14a1 1 0 0 1 -.707 -1.707l1 -1a1 1 0 0 0 .293 -.707v-3a7 7 0 0 1 4 -6" />
                                <path d="M9 17h6" />
                            </svg>
                            <span class="navbar-notification-badge"></span>
                        </button>

                        <!-- Dark Mode Toggle -->
                        <button @click="toggleDarkMode()" class="navbar-button">
                            <!-- Tabler sun icon for light mode -->
                            <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sun w-6 h-6" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="12" cy="12" r="4" />
                                <path d="M3 12h1M20 12h1M12 3v1M12 20v1M5.64 5.64l.707 .707M17.657 17.657l.707 .707M5.64 18.36l.707 -.707M17.657 6.343l.707 -.707" />
                            </svg>
                            <!-- Tabler moon icon for dark mode -->
                            <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-moon w-6 h-6 dark:text-gray-200">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex mt-16">
            <!-- Icon Sidebar - Hidden on mobile, visible on tablet and up -->
            <div class="sidebar-icon">
                <div>
                    <div class="inline-flex h-16 w-16 items-center justify-center">
                        <a href="#" class="group relative flex justify-center rounded px-2 py-1.5 text-gray-500 hover:bg-primary dark:hover:bg-primary-dark dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                            </svg>
                        </a>
                    </div>

                    <div class="border-t border-gray-100 dark:border-gray-700">
                        <div class="px-2">
                            <ul class="space-y-1 border-t border-gray-100 dark:border-gray-700 pt-4">
                                <li>
                                    <a href="dashboard/dashboard.html" class="group relative flex justify-center rounded px-2 py-1.5 text-gray-500 hover:bg-primary dark:hover:bg-primary-dark dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                        <!-- Dashboard -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-home-2">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                            <path d="M10 12h4v4h-4z" />
                                        </svg>
                                    </a>
                                </li>

                                <li>
                                    <a href="elements/button.html" class="group relative flex justify-center rounded px-2 py-1.5 text-gray-500 hover:bg-primary dark:hover:bg-primary-dark dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                        <!-- Element -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-html">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                            <path d="M2 21v-6" />
                                            <path d="M5 15v6" />
                                            <path d="M2 18h3" />
                                            <path d="M20 15v6h2" />
                                            <path d="M13 21v-6l2 3l2 -3v6" />
                                            <path d="M7.5 15h3" />
                                            <path d="M9 15v6" />
                                        </svg>
                                    </a>
                                </li>

                                <li>
                                    <a href="components/accordion.html" class="group relative flex justify-center rounded px-2 py-1.5 text-gray-500 hover:bg-primary dark:hover:bg-primary-dark dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                        <!-- Component Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-components">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 12l3 3l3 -3l-3 -3z" />
                                            <path d="M15 12l3 3l3 -3l-3 -3z" />
                                            <path d="M9 6l3 3l3 -3l-3 -3z" />
                                            <path d="M9 18l3 3l3 -3l-3 -3z" />
                                        </svg>
                                    </a>
                                </li>

                                <li>
                                    <a href="pages/index.html" class="group relative flex justify-center rounded px-2 py-1.5 text-gray-500 hover:bg-primary dark:hover:bg-primary-dark dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                        <!-- Pages Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-article">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                            <path d="M7 8h10" />
                                            <path d="M7 12h10" />
                                            <path d="M7 16h10" />
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="sticky inset-x-0 bottom-0 border-t border-gray-100 dark:border-gray-700 bg-foreground dark:bg-background-dark p-2">
                    <form action="#">
                        <button type="submit" class="group relative flex w-full justify-center rounded-sm px-2 py-1.5 text-sm text-gray-500 hover:bg-primary dark:hover:bg-primary-dark dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Expanded Sidebar - Mobile overlay, normal sidebar on larger screens -->
            <div class="relative">
                <div x-show="sidebarOpen" x-transition:enter="transform transition-transform duration-200 ease-out" x-transition:enter-start="translate-x-[-100%]" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition-transform duration-200 ease-in" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-[-100%]" class="sidebar-layout">
                    <div class="px-4 py-6">
                        <ul class="space-y-1" x-data="{ selected: null }">
                            <li>
                                <a href="index.html" class="sidebar-link sidebar-link-active">Dashboard</a>
                            </li>

                            <li x-data="{ open: false, subSelected: null }">
                                <button @click="open = !open" class="sidebar-dropdown-button">
                                    <span class="text-sm font-medium">Element</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="sidebar-dropdown-icon" :class="{ 'open': open }" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <ul x-show="open" x-transition class="sidebar-dropdown">
                                    <li>
                                        <a href="elements/button.html" class="sidebar-nested-link">Button</a>
                                    </li>
                                    <li>
                                        <a href="elements/input.html" class="sidebar-nested-link">Input</a>
                                    </li>
                                </ul>
                            </li>

                            <li x-data="{ open: false, subSelected: null }">
                                <button @click="open = !open" class="sidebar-dropdown-button">
                                    <span class="text-sm font-medium">Component</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="sidebar-dropdown-icon" :class="{ 'open': open }" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <ul x-show="open" x-transition class="sidebar-dropdown">
                                    <li>
                                        <a href="components/accordion.html" class="sidebar-nested-link">Accordion</a>
                                    </li>
                                    <li>
                                        <a href="components/alert.html" class="sidebar-nested-link">Alert</a>
                                    </li>
                                    <li>
                                        <a href="components/badge.html" class="sidebar-nested-link">Badge</a>
                                    </li>
                                    <li>
                                        <a href="components/breadcrumb.html" class="sidebar-nested-link">Breadcrumb</a>
                                    </li>
                                    <li>
                                        <a href="components/dropdown.html" class="sidebar-nested-link">Dropdown</a>
                                    </li>
                                    <li>
                                        <a href="components/card.html" class="sidebar-nested-link">Card</a>
                                    </li>
                                    <li>
                                        <a href="components/table.html" class="sidebar-nested-link">Table</a>
                                    </li>
                                    <li>
                                        <a href="components/collapse.html" class="sidebar-nested-link">Collapse</a>
                                    </li>
                                    <li>
                                        <a href="components/drawer.html" class="sidebar-nested-link">Drawer</a>
                                    </li>
                                    <li>
                                        <a href="components/menu-list.html" class="sidebar-nested-link">Menu List</a>
                                    </li>
                                    <li>
                                        <a href="components/modal.html" class="sidebar-nested-link">Modal</a>
                                    </li>
                                    <li>
                                        <a href="components/pagination.html" class="sidebar-nested-link">Pagination</a>
                                    </li>
                                    <li>
                                        <a href="components/popover.html" class="sidebar-nested-link">Popover</a>
                                    </li>
                                    <li>
                                        <a href="components/tab.html" class="sidebar-nested-link">Tab</a>
                                    </li>
                                    <li>
                                        <a href="components/tooltip.html" class="sidebar-nested-link">Tooltip</a>
                                    </li>
                                </ul>
                            </li>
                            <li x-data="{ open: false }">
                                <button @click="open = !open" class="sidebar-dropdown-button">
                                    <span class="text-sm font-medium">Pages</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="sidebar-dropdown-icon" :class="{ 'open': open }" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <ul x-show="open" x-transition class="sidebar-dropdown">
                                    <li>
                                        <a href="pages/login.html" class="sidebar-nested-link">Login</a>
                                    </li>
                                    <li>
                                        <a href="pages/signup.html" class="sidebar-nested-link">Signup</a>
                                    </li>
                                    <li>
                                        <a href="pages/forgot-password.html" class="sidebar-nested-link">Forgot Password</a>
                                    </li>
                                    <li>
                                        <a href="pages/reset-password.html" class="sidebar-nested-link">Reset Password</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Backdrop for mobile -->
                <div x-show="sidebarOpen" x-transition:enter="transition-all ease-linear duration-300" x-transition:enter-start="opacity-0 backdrop-blur-none" x-transition:enter-end="opacity-100 backdrop-blur-sm" x-transition:leave="transition-all ease-linear duration-300" x-transition:leave-start="opacity-100 backdrop-blur-sm" x-transition:leave-end="opacity-0 backdrop-blur-none" class="sidebar-backdrop" @click="sidebarOpen = false"></div>
            </div>
        </div>

        <!-- Main content -->
        <main class="main-container" :class="{
            'md:ml-64': sidebarOpen,
            'md:ml-0': !sidebarOpen,
            'ml-0': true
        }">
            <div class="card card-body">
                <h1 class="text-xl md:text-2xl font-bold text-foreground-dark dark:text-foreground">
                    Dashboard
                </h1>
            </div>
        </main>
    </div>

    <!-- Mobile Bottom Menu -->
    <div x-show="isMobile" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="mobile-menu flex justify-center block lg:hidden">
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="w-24 bg-primary dark:bg-primary-dark text-white dark:text-gray-200 rounded-full p-3 shadow-lg hover:bg-primary/90 dark:hover:bg-primary-dark/90 transition-colors duration-200 flex items-center justify-center gap-2">
            <!-- Tabler menu icon -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-layout-dashboard">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M5 4h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                <path d="M5 16h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                <path d="M15 12h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                <path d="M15 4h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
            </svg>
            <span class="text-sm font-medium">Menu</span>
        </button>
    </div>

    <!-- Mobile Menu Popup -->
    <div x-show="isMobile && mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-8" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform translate-y-8" @click.away="mobileMenuOpen = false" class="mobile-menu-popup block lg:hidden">
        <div class="space-y-4 py-2">
            <!-- Settings -->
            <a href="dashboard/dashboard.html" class="flex items-center space-x-3 px-4 py-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                <!-- Dashboard -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                    <path d="M10 12h4v4h-4z" />
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Element -->
            <a href="#" class="flex items-center space-x-3 px-4 py-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-html">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                    <path d="M2 21v-6" />
                    <path d="M5 15v6" />
                    <path d="M2 18h3" />
                    <path d="M20 15v6h2" />
                    <path d="M13 21v-6l2 3l2 -3v6" />
                    <path d="M7.5 15h3" />
                    <path d="M9 15v6" />
                </svg>
                <span>Element</span>
            </a>

            <!-- Component -->
            <a href="#" class="flex items-center space-x-3 px-4 py-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-components">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 12l3 3l3 -3l-3 -3z" />
                    <path d="M15 12l3 3l3 -3l-3 -3z" />
                    <path d="M9 6l3 3l3 -3l-3 -3z" />
                    <path d="M9 18l3 3l3 -3l-3 -3z" />
                </svg>
                <span>Component</span>
            </a>

            <!-- Pages -->
            <a href="#" class="flex items-center space-x-3 px-4 py-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-article">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                    <path d="M7 8h10" />
                    <path d="M7 12h10" />
                    <path d="M7 16h10" />
                </svg>
                <span>Pages</span>
            </a>

            <!-- Divider -->
            <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>

            <!-- Logout -->
            <form action="#" class="px-2">
                <button type="submit" class="flex w-full items-center space-x-3 px-4 py-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</body>

</html>
