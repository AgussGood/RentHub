<nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in shadow-none duration-250 rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="false">
    <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
        <nav>
            <!-- breadcrumb -->
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
                <li class="text-sm leading-normal">
                    <a class="text-white opacity-50" href="javascript:;">Pages</a>
                </li>
                <li class="text-sm pl-2 capitalize leading-normal text-white before:float-left before:pr-2 before:text-white before:content-['/']" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="mb-0 font-bold text-white capitalize">Dashboard</h6>
        </nav>

        <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
            <div class="flex items-center md:ml-auto md:pr-4">
                <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease">
                    <span class="text-sm ease leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="pl-9 text-sm focus:shadow-primary-outline ease w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow" placeholder="Type here..." />
                </div>
            </div>
            <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
                
                <!-- User Profile Dropdown with Logout -->
                <li class="relative flex items-center pr-2">
                    <a href="javascript:;" id="userDropdown" class="block p-0 text-sm text-white transition-all ease-nav-brand" aria-expanded="false">
                        <i class="cursor-pointer fa fa-user mr-1"></i>
                        <span class="hidden sm:inline font-semibold">{{ Auth::user()->name }}</span>
                    </a>

                    <ul id="userDropdownMenu" class="hidden text-sm transform-dropdown lg:shadow-3xl duration-250 min-w-44 absolute right-0 top-full mt-2 z-50 origin-top list-none rounded-lg border-0 border-solid border-transparent dark:shadow-dark-xl dark:bg-slate-850 bg-white bg-clip-padding px-2 py-4 text-left text-slate-500">
                        
                        <!-- User Info -->
                        <li class="relative mb-2">
                            <div class="px-4 py-2 border-b border-gray-200 dark:border-slate-700">
                                <p class="text-xs text-slate-400 dark:text-white/80 mb-1">Masuk Sebagai</p>
                                <p class="text-sm font-semibold dark:text-white">{{ Auth::user()->email }}</p>
                                <span class="inline-block px-2 py-1 mt-1 text-xs font-semibold text-white bg-gradient-to-tl from-blue-500 to-violet-500 rounded-full">
                                    {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </div>
                        </li>

                        <!-- Divider -->
                        <li class="relative mb-2">
                            <div class="border-t border-gray-200 dark:border-slate-700 my-2"></div>
                        </li>

                        <!-- Logout Button -->
                        <li class="relative">
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-red-50 hover:text-red-600 lg:transition-colors text-left">
                                    <div class="flex py-1 items-center">
                                        <i class="fa fa-sign-out mr-3 text-red-500"></i>
                                        <span class="text-sm font-semibold text-red-500">Logout</span>
                                    </div>
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>

                <li class="flex items-center pl-4 xl:hidden">
                    <a href="javascript:;" class="block p-0 text-sm text-white transition-all ease-nav-brand" sidenav-trigger>
                        <div class="w-4.5 overflow-hidden">
                            <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                            <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                            <i class="ease relative block h-0.5 rounded-sm bg-white transition-all"></i>
                        </div>
                    </a>
                </li>

                <li class="flex items-center px-4">
                    <a href="javascript:;" class="p-0 text-sm text-white transition-all ease-nav-brand">
                        <i fixed-plugin-button-nav class="cursor-pointer fa fa-cog"></i>
                    </a>
                </li>

                <!-- Notifications -->
                <li class="relative flex items-center pr-2">
                    <a href="javascript:;" id="notificationDropdown" class="block p-0 text-sm text-white transition-all ease-nav-brand" aria-expanded="false">
                        <i class="cursor-pointer fa fa-bell"></i>
                    </a>

                    <ul id="notificationDropdownMenu" class="hidden text-sm transform-dropdown lg:shadow-3xl duration-250 min-w-44 absolute right-0 top-full mt-2 z-50 origin-top list-none rounded-lg border-0 border-solid border-transparent dark:shadow-dark-xl dark:bg-slate-850 bg-white bg-clip-padding px-2 py-4 text-left text-slate-500">
                        
                        <li class="relative mb-2">
                            <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="javascript:;">
                                <div class="flex py-1">
                                    <div class="my-auto">
                                        <img src="{{ asset('admin/assets/img/team-2.jpg') }}" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white"><span class="font-semibold">New message</span> from Laur</h6>
                                        <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80">
                                            <i class="mr-1 fa fa-clock"></i>
                                            13 minutes ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li class="relative mb-2">
                            <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg px-4 transition-colors duration-300 hover:bg-gray-200 hover:text-slate-700" href="javascript:;">
                                <div class="flex py-1">
                                    <div class="my-auto">
                                        <img src="{{ asset('admin/assets/img/small-logos/logo-spotify.svg') }}" class="inline-flex items-center justify-center mr-4 text-sm text-white bg-gradient-to-tl from-zinc-800 to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850 h-9 w-9 max-w-none rounded-xl" />
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white"><span class="font-semibold">New album</span> by Travis Scott</h6>
                                        <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80">
                                            <i class="mr-1 fa fa-clock"></i>
                                            1 day
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li class="relative">
                            <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg px-4 transition-colors duration-300 hover:bg-gray-200 hover:text-slate-700" href="javascript:;">
                                <div class="flex py-1">
                                    <div class="inline-flex items-center justify-center my-auto mr-4 text-sm text-white transition-all duration-200 ease-nav-brand bg-gradient-to-tl from-slate-600 to-slate-300 h-9 w-9 rounded-xl">
                                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <title>credit-card</title>
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                    <g transform="translate(1716.000000, 291.000000)">
                                                        <g transform="translate(453.000000, 454.000000)">
                                                            <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                                            <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">Payment successfully completed</h6>
                                        <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80">
                                            <i class="mr-1 fa fa-clock"></i>
                                            2 days
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Dropdown shadow and animation */
    .transform-dropdown {
        transition: all 0.2s ease-in-out;
        animation: slideDown 0.2s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Logout button enhanced hover */
    button[type="submit"]:hover {
        transform: translateX(2px);
    }

    /* Badge gradient */
    .bg-gradient-to-r {
        background-image: linear-gradient(to right, var(--tw-gradient-stops));
    }

    .bg-gradient-to-br {
        background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
    }

    /* Dropdown shadow */
    .lg\:shadow-3xl {
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .shadow-lg {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    /* Smooth hover transitions */
    .group:hover {
        transition: all 0.2s ease-in-out;
    }
</style>

<script>
    // JavaScript untuk toggle dropdown
    document.addEventListener('DOMContentLoaded', function() {
        // User Dropdown
        const userDropdown = document.getElementById('userDropdown');
        const userDropdownMenu = document.getElementById('userDropdownMenu');
        
        // Notification Dropdown
        const notificationDropdown = document.getElementById('notificationDropdown');
        const notificationDropdownMenu = document.getElementById('notificationDropdownMenu');

        // Toggle User Dropdown
        if (userDropdown && userDropdownMenu) {
            userDropdown.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Close notification dropdown if open
                notificationDropdownMenu.classList.add('hidden');
                
                // Toggle user dropdown
                userDropdownMenu.classList.toggle('hidden');
            });
        }

        // Toggle Notification Dropdown
        if (notificationDropdown && notificationDropdownMenu) {
            notificationDropdown.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Close user dropdown if open
                userDropdownMenu.classList.add('hidden');
                
                // Toggle notification dropdown
                notificationDropdownMenu.classList.toggle('hidden');
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!userDropdown.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                userDropdownMenu.classList.add('hidden');
            }
            if (!notificationDropdown.contains(e.target) && !notificationDropdownMenu.contains(e.target)) {
                notificationDropdownMenu.classList.add('hidden');
            }
        });

        // Prevent dropdown from closing when clicking inside
        userDropdownMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
        
        notificationDropdownMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
</script>