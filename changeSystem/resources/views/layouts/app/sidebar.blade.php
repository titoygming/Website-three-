<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <x-ts-dialog />
    <x-ts-toast />
    <flux:sidebar sticky collapsible class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.header>
            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
            <flux:sidebar.collapse />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.item icon="home" :href="route('manager.dashboard')"
                :current="request()->routeIs('manager.dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </flux:sidebar.item>

            <flux:sidebar.item icon="shopping-cart" :href="route('manager.orders')"
                :current="request()->routeIs('manager.orders')" wire:navigate>
                {{ __('Orders') }}
            </flux:sidebar.item>

            <flux:sidebar.item icon="users" :href="route('manager.users')"
                :current="request()->routeIs('manager.users')" wire:navigate>
                {{ __('Users') }}
            </flux:sidebar.item>

            <flux:sidebar.item icon="arrow-path-rounded-square" :href="route('manager.transactions')"
                :current="request()->routeIs('manager.transactions')" wire:navigate>
                {{ __('Transactions') }}
            </flux:sidebar.item>

            <flux:sidebar.item icon="wrench-screwdriver" :href="route('manager.services.home')"
                :current="request()->routeIs('manager.services.*')" wire:navigate>
                {{ __('Services') }}
            </flux:sidebar.item>

            <flux:sidebar.item icon="arrow-down-circle" :href="route('manager.recharge-requests')"
                :current="request()->routeIs('manager.recharge-requests')" wire:navigate>
                {{ __('Recharge Requests') }}
            </flux:sidebar.item>
        </flux:sidebar.nav>

        <flux:spacer />

        <x-desktop-user-menu :name="auth()->user()->name" />
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('manager.logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                        class="w-full cursor-pointer" data-test="logout-button">
                        {{ __('Log out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
</body>

</html>
