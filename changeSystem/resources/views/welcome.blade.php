<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('Welcome') }} - {{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;900&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Cart drawer transition */
        [x-cloak] {
            display: none !important;
        }

        .cart-drawer-enter {
            transform: translateX(100%);
        }

        .cart-drawer-enter-active {
            transition: transform 0.35s cubic-bezier(0.32, 0.72, 0, 1);
        }

        .cart-drawer-enter-to {
            transform: translateX(0);
        }

        .cart-drawer-leave {
            transform: translateX(0);
        }

        .cart-drawer-leave-active {
            transition: transform 0.3s cubic-bezier(0.32, 0.72, 0, 1);
        }

        .cart-drawer-leave-to {
            transform: translateX(100%);
        }

        /* Toast notification */
        @keyframes toast-in {
            from {
                opacity: 0;
                transform: translateY(1rem) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes toast-out {
            from {
                opacity: 1;
                transform: translateY(0) scale(1);
            }

            to {
                opacity: 0;
                transform: translateY(-0.5rem) scale(0.95);
            }
        }

        .toast-enter {
            animation: toast-in 0.25s ease forwards;
        }

        .toast-exit {
            animation: toast-out 0.25s ease forwards;
        }

        /* Cart badge pulse */
        @keyframes badge-pop {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.4);
            }

            100% {
                transform: scale(1);
            }
        }

        .badge-pop {
            animation: badge-pop 0.3s ease;
        }

        /* Item remove animation */
        @keyframes item-remove {
            from {
                opacity: 1;
                max-height: 200px;
                margin-bottom: 0.75rem;
            }

            to {
                opacity: 0;
                max-height: 0;
                margin-bottom: 0;
                overflow: hidden;
            }
        }

        .item-removing {
            animation: item-remove 0.3s ease forwards;
        }

        @theme {
            --color-inverse-on-surface: #f1effa;
            --color-surface-bright: #fbf8ff;
            --color-on-primary-fixed: #001a42;
            --color-on-primary: #ffffff;
            --color-on-primary-fixed-variant: #004395;
            --color-on-tertiary-container: #fffbff;
            --color-surface-tint: #005ac2;
            --color-secondary: #495e8a;
            --color-outline-variant: #c2c6d6;
            --color-surface-container-low: #f4f2fd;
            --color-surface-dim: #dad9e3;
            --color-primary-fixed: #d8e2ff;
            --color-background: #fbf8ff;
            --color-outline: #727785;
            --color-tertiary: #924700;
            --color-on-secondary: #ffffff;
            --color-tertiary-fixed: #ffdcc6;
            --color-surface-container: #eeedf7;
            --color-error: #ba1a1a;
            --color-on-background: #1a1b22;
            --color-on-error: #ffffff;
            --color-tertiary-fixed-dim: #ffb786;
            --color-surface-container-highest: #e3e1ec;
            --color-on-primary-container: #fefcff;
            --color-tertiary-container: #b75b00;
            --color-on-tertiary-fixed-variant: #723600;
            --color-surface-variant: #e3e1ec;
            --color-error-container: #ffdad6;
            --color-secondary-fixed: #d8e2ff;
            --color-on-tertiary: #ffffff;
            --color-primary-fixed-dim: #adc6ff;
            --color-on-surface-variant: #424754;
            --color-primary: #0058be;
            --color-surface-container-high: #e8e7f1;
            --color-surface: #fbf8ff;
            --color-on-error-container: #93000a;
            --color-on-secondary-container: #405682;
            --color-secondary-container: #b6ccff;
            --color-surface-container-lowest: #ffffff;
            --color-on-tertiary-fixed: #311400;
            --color-secondary-fixed-dim: #b1c6f9;
            --color-inverse-surface: #2f3038;
            --color-on-secondary-fixed: #001a42;
            --color-on-surface: #1a1b22;
            --color-inverse-primary: #adc6ff;
            --color-primary-container: #2170e4;
            --color-on-secondary-fixed-variant: #304671;

            /* RADIUS */
            --radius: 0.25rem;
            --radius-lg: 0.5rem;
            --radius-xl: 1.5rem;
            --radius-full: 9999px;

            /* FONTS */
            --font-headline: "Space Grotesk", sans-serif;
            --font-body: "Inter", sans-serif;
            --font-label: "Inter", sans-serif;
        }
    </style>
    @fluxAppearance

    @vite(['resources/css/app.css'])
</head>

<body class="bg-background text-on-background font-body selection:bg-primary selection:text-white" x-data x-cloak>

    <!--
=======================================================================
  ALPINE.JS CART — LARAVEL / LIVEWIRE INTEGRATION GUIDE
=======================================================================

  ① ALPINE STORE  →  Alpine.store('cart') holds client-side state.
     Sync with server on: addItem(), removeItem(), updateQty(), clear().

  ② LARAVEL API ENDPOINTS (suggested):
     POST   /api/cart/items            → add item
     DELETE /api/cart/items/{id}       → remove item
     PATCH  /api/cart/items/{id}       → update qty
     GET    /api/cart                  → fetch cart (on page load)
     DELETE /api/cart                  → clear cart
     POST   /api/cart/checkout         → place order

  ③ LIVEWIRE: dispatch events from Alpine with:
     $dispatch('cart:item-added', { product })
     $dispatch('cart:updated', { items, total })
     Listen in Livewire component: #[On('cart:item-added')]

  ④ CSRF: Include meta[name=csrf-token] and pass as X-CSRF-TOKEN header.
     Example: headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }

=======================================================================
-->
    <!-- =====================================================================
     ALPINE STORE — Cart global state
     ===================================================================== -->
    <script>
        document.addEventListener('alpine:init', () => {

            Alpine.store('cart', {

                // ─── State ────────────────────────────────────────────────────────
                open: false,
                items: [], // { id, name, platform, price, image, qty, type }
                loading: false, // true while waiting for API response
                toasts: [], // { id, message, type }
                _toastSeq: 0,
                _badgePop: false,

                // ─── Computed ─────────────────────────────────────────────────────
                get count() {
                    return this.items.reduce((s, i) => s + i.qty, 0);
                },
                get subtotal() {
                    return this.items.reduce((s, i) => s + i.price * i.qty, 0);
                },
                get isEmpty() {
                    return this.items.length === 0;
                },

                // ─── Actions ──────────────────────────────────────────────────────

                /**
                 * Add a product to the cart.
                 * Hook: POST /api/cart/items
                 * Livewire: $dispatch('cart:item-added', { product })
                 */
                async addItem(product) {
                    const existing = this.items.find(i => i.id === product.id);
                    if (existing) {
                        existing.qty++;
                    } else {
                        this.items.push({
                            ...product,
                            qty: 1
                        });
                    }

                    this._popBadge();
                    this._toast(`"${product.name}" adicionado ao carrinho`, 'success');

                    // ── Laravel API call (uncomment to activate) ──────────────────
                    // try {
                    //     this.loading = true;
                    //     await fetch('/api/cart/items', {
                    //         method: 'POST',
                    //         headers: {
                    //             'Content-Type': 'application/json',
                    //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    //             'Accept': 'application/json',
                    //         },
                    //         body: JSON.stringify({ product_id: product.id, qty: 1 }),
                    //     });
                    // } catch (e) {
                    //     console.error('[NexaVault Cart] addItem failed:', e);
                    //     this._toast('Erro ao adicionar produto', 'error');
                    // } finally {
                    //     this.loading = false;
                    // }

                    // ── Livewire emit (uncomment if using Livewire) ───────────────
                    // window.dispatchEvent(new CustomEvent('cart:item-added', { detail: { product } }));
                },

                /**
                 * Remove item from cart.
                 * Hook: DELETE /api/cart/items/{id}
                 */
                async removeItem(id) {
                    this.items = this.items.filter(i => i.id !== id);

                    // ── Laravel API call ──────────────────────────────────────────
                    // try {
                    //     await fetch(`/api/cart/items/${id}`, {
                    //         method: 'DELETE',
                    //         headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    //     });
                    // } catch (e) { console.error('[NexaVault Cart] removeItem failed:', e); }
                },

                /**
                 * Update item quantity.
                 * Hook: PATCH /api/cart/items/{id}
                 */
                async updateQty(id, delta) {
                    const item = this.items.find(i => i.id === id);
                    if (!item) return;
                    const newQty = item.qty + delta;
                    if (newQty <= 0) {
                        this.removeItem(id);
                        return;
                    }
                    item.qty = newQty;

                    // ── Laravel API call ──────────────────────────────────────────
                    // try {
                    //     await fetch(`/api/cart/items/${id}`, {
                    //         method: 'PATCH',
                    //         headers: {
                    //             'Content-Type': 'application/json',
                    //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    //         },
                    //         body: JSON.stringify({ qty: newQty }),
                    //     });
                    // } catch (e) { console.error('[NexaVault Cart] updateQty failed:', e); }
                },

                /**
                 * Clear entire cart.
                 * Hook: DELETE /api/cart
                 */
                async clear() {
                    this.items = [];
                    // await fetch('/api/cart', { method: 'DELETE', headers: { 'X-CSRF-TOKEN': ... } });
                },

                /**
                 * Proceed to checkout.
                 * Hook: POST /api/cart/checkout  or  Livewire redirect
                 */
                async checkout() {
                    if (this.isEmpty) return;
                    this.loading = true;
                    // await fetch('/api/cart/checkout', { method: 'POST', ... });
                    // Or: window.location.href = '/checkout';
                    // Or: Livewire.navigate('/checkout');
                    await new Promise(r => setTimeout(r, 900)); // simulate
                    this._toast('A redirecionar para o checkout…', 'info');
                    this.loading = false;
                },

                /**
                 * Fetch cart from server on page load.
                 * Hook: GET /api/cart
                 */
                async fetchFromServer() {
                    // try {
                    //     const res = await fetch('/api/cart', { headers: { 'Accept': 'application/json' } });
                    //     const data = await res.json();
                    //     this.items = data.items ?? [];
                    // } catch (e) { console.error('[NexaVault Cart] fetchFromServer failed:', e); }
                },

                // ─── Helpers ──────────────────────────────────────────────────────
                toggleDrawer() {
                    this.open = !this.open;
                },
                openDrawer() {
                    this.open = true;
                },
                closeDrawer() {
                    this.open = false;
                },

                _popBadge() {
                    this._badgePop = false;
                    this.$nextTick(() => {
                        this._badgePop = true;
                    });
                },

                _toast(message, type = 'info') {
                    const id = ++this._toastSeq;
                    this.toasts.push({
                        id,
                        message,
                        type,
                        exiting: false
                    });
                    setTimeout(() => {
                        const t = this.toasts.find(t => t.id === id);
                        if (t) t.exiting = true;
                        setTimeout(() => {
                            this.toasts = this.toasts.filter(t => t.id !== id);
                        }, 300);
                    }, 3000);
                },

                _toastIcon(type) {
                    return {
                        success: 'check_circle',
                        error: 'error',
                        info: 'info'
                    } [type] ?? 'info';
                },
                _toastColor(type) {
                    return {
                        success: 'text-green-400',
                        error: 'text-red-400',
                        info: 'text-blue-400'
                    } [type] ?? 'text-blue-400';
                },

                _fmt(val) {
                    return new Intl.NumberFormat('pt-MZ', {
                        style: 'currency',
                        currency: 'MZN'
                    }).format(val);
                },
            });

            // Fetch from server on load
            // Alpine.store('cart').fetchFromServer();
        });
    </script>

    <!-- =====================================================================
     TOAST NOTIFICATIONS
     ===================================================================== -->
    <div class="fixed top-20 right-6 z-[100] flex flex-col gap-2 pointer-events-none" x-data aria-live="polite">
        <template x-for="toast in $store.cart.toasts" :key="toast.id">
            <div class="flex items-center gap-3 bg-zinc-900 border border-zinc-700 rounded-xl px-4 py-3 shadow-2xl shadow-black/30 min-w-[260px] max-w-xs pointer-events-auto"
                :class="toast.exiting ? 'toast-exit' : 'toast-enter'">
                <span class="material-symbols-outlined text-lg" :class="$store.cart._toastColor(toast.type)"
                    x-text="$store.cart._toastIcon(toast.type)"></span>
                <span class="text-white text-sm font-medium leading-snug" x-text="toast.message"></span>
            </div>
        </template>
    </div>

    <!-- =====================================================================
     CART DRAWER OVERLAY + PANEL
     ===================================================================== -->
    <div x-data x-cloak>
        <!-- Backdrop -->
        <div x-show="$store.cart.open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-[60] bg-black/60 backdrop-blur-sm"
            @click="$store.cart.closeDrawer()"></div>

        <!-- Panel -->
        <aside x-show="$store.cart.open" x-transition:enter="transition ease-[cubic-bezier(0.32,0.72,0,1)] duration-350"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-[cubic-bezier(0.32,0.72,0,1)] duration-300"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
            class="fixed right-0 top-0 h-full w-full max-w-[420px] z-[70] bg-zinc-950 shadow-2xl flex flex-col"
            @keydown.escape.window="$store.cart.closeDrawer()" role="dialog" aria-modal="true"
            aria-label="Carrinho de compras">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-5 border-b border-zinc-800 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-blue-500">shopping_bag</span>
                    <h2 class="font-headline text-lg font-black text-white tracking-tight">Carrinho</h2>
                    <span x-show="!$store.cart.isEmpty"
                        class="bg-blue-600 text-white text-[11px] font-black px-2 py-0.5 rounded-full"
                        x-text="$store.cart.count"></span>
                </div>
                <button @click="$store.cart.closeDrawer()"
                    class="p-2 text-zinc-400 hover:text-white hover:bg-zinc-800 rounded-lg transition-colors"
                    aria-label="Fechar carrinho">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Loading bar -->
            <div x-show="$store.cart.loading" class="h-0.5 bg-zinc-800 flex-shrink-0">
                <div class="h-full bg-blue-600 animate-pulse w-full"></div>
            </div>

            <!-- Items -->
            <div class="flex-1 overflow-y-auto hide-scrollbar px-6 py-4 space-y-3">

                <!-- Empty state -->
                <div x-show="$store.cart.isEmpty"
                    class="flex flex-col items-center justify-center h-full gap-4 py-16 text-center">
                    <div class="w-20 h-20 rounded-full bg-zinc-800/60 flex items-center justify-center">
                        <span class="material-symbols-outlined text-4xl text-zinc-600">shopping_cart</span>
                    </div>
                    <p class="text-zinc-400 font-semibold text-sm">O teu carrinho está vazio</p>
                    <p class="text-zinc-600 text-xs max-w-[200px]">Adiciona produtos do marketplace para começar</p>
                    <button @click="$store.cart.closeDrawer()"
                        class="mt-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm rounded-full transition-colors">
                        Explorar Marketplace
                    </button>
                </div>

                <!-- Cart items -->
                <template x-for="item in $store.cart.items" :key="item.id">
                    <div class="flex gap-4 bg-zinc-900 rounded-xl p-3.5 border border-zinc-800 hover:border-zinc-700 transition-colors group"
                        x-data="{ removing: false }" :class="{ 'item-removing': removing }">
                        <!-- Thumbnail -->
                        <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-zinc-800">
                            <template x-if="item.image">
                                <img :src="item.image" :alt="item.name" class="w-full h-full object-cover" />
                            </template>
                            <template x-if="!item.image">
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="material-symbols-outlined text-zinc-600 text-2xl">games</span>
                                </div>
                            </template>
                        </div>

                        <!-- Info -->
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] text-zinc-500 font-bold uppercase tracking-widest mb-0.5"
                                x-text="item.platform"></p>
                            <h4 class="text-sm font-black text-white truncate" x-text="item.name"></h4>
                            <p class="text-blue-400 font-black text-sm mt-1" x-text="$store.cart._fmt(item.price)"></p>

                            <!-- Qty controls -->
                            <div class="flex items-center gap-2 mt-2">
                                <button @click="$store.cart.updateQty(item.id, -1)"
                                    class="w-6 h-6 rounded-md bg-zinc-800 hover:bg-zinc-700 text-white flex items-center justify-center transition-colors text-sm font-bold"
                                    :disabled="$store.cart.loading" aria-label="Diminuir quantidade">−</button>
                                <span class="text-white font-black text-sm w-5 text-center" x-text="item.qty"></span>
                                <button @click="$store.cart.updateQty(item.id, +1)"
                                    class="w-6 h-6 rounded-md bg-zinc-800 hover:bg-zinc-700 text-white flex items-center justify-center transition-colors text-sm font-bold"
                                    :disabled="$store.cart.loading" aria-label="Aumentar quantidade">+</button>
                                <span class="ml-auto text-zinc-500 text-xs font-bold"
                                    x-text="$store.cart._fmt(item.price * item.qty)"></span>
                            </div>
                        </div>

                        <!-- Remove -->
                        <button @click="removing = true; setTimeout(() => $store.cart.removeItem(item.id), 280)"
                            class="opacity-0 group-hover:opacity-100 self-start p-1.5 text-zinc-600 hover:text-red-400 hover:bg-red-400/10 rounded-lg transition-all"
                            aria-label="Remover item">
                            <span class="material-symbols-outlined text-base">delete</span>
                        </button>
                    </div>
                </template>
            </div>

            <!-- Footer: summary + actions -->
            <div x-show="!$store.cart.isEmpty" class="border-t border-zinc-800 px-6 py-5 flex-shrink-0 space-y-4">

                <!-- Order summary -->
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-zinc-400">
                        <span>Subtotal (<span x-text="$store.cart.count"></span> itens)</span>
                        <span x-text="$store.cart._fmt($store.cart.subtotal)"></span>
                    </div>
                    <div class="flex justify-between text-zinc-400">
                        <span>Entrega digital</span>
                        <span class="text-green-400 font-bold">Grátis</span>
                    </div>
                    <div class="flex justify-between text-white font-black text-base pt-2 border-t border-zinc-800">
                        <span>Total</span>
                        <span class="text-blue-400" x-text="$store.cart._fmt($store.cart.subtotal)"></span>
                    </div>
                </div>

                <!-- Checkout button -->
                <button @click="$store.cart.checkout()" :disabled="$store.cart.loading"
                    class="w-full py-4 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 disabled:opacity-60 disabled:cursor-wait text-white font-black rounded-xl transition-all flex items-center justify-center gap-2 shadow-lg shadow-blue-900/30">
                    <template x-if="!$store.cart.loading">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">lock</span>
                            Finalizar Compra
                        </span>
                    </template>
                    <template x-if="$store.cart.loading">
                        <span class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            A processar…
                        </span>
                    </template>
                </button>

                <!-- Clear cart -->
                <button @click="$store.cart.clear()"
                    class="w-full py-2.5 text-zinc-500 hover:text-red-400 text-xs font-bold uppercase tracking-widest transition-colors rounded-lg hover:bg-red-400/5">
                    Limpar carrinho
                </button>
            </div>
        </aside>
    </div>


    <!-- =====================================================================
     TOP NAV BAR (Fixed)
     ===================================================================== -->
    <nav class="fixed top-0 w-full z-50 bg-zinc-900 shadow-2xl shadow-black/20">
        <div class="flex justify-between items-center h-16 px-6 max-w-[1920px] mx-auto">
            <div class="flex items-center gap-8">
                <a class="text-2xl font-black text-white tracking-tighter hover:scale-105 transition-transform flex items-center"
                    href="#">
                    RIBE<span class="text-blue-600">R</span>I
                </a>
                <div class="hidden md:flex items-center gap-6">
                    <a class="text-blue-400 font-bold border-b-2 border-blue-600 pb-1 font-body text-sm"
                        href="#">Marketplace</a>
                </div>
            </div>
            <div class="flex items-center gap-4">

                <!-- Cart button with live badge -->
                <div class="relative" x-data>
                    <button @click="$store.cart.toggleDrawer()"
                        class="p-2 text-zinc-300 hover:text-white transition-all hover:bg-zinc-800 rounded-lg"
                        aria-label="Abrir carrinho">
                        <span class="material-symbols-outlined">shopping_cart</span>
                    </button>
                    <!-- Badge -->
                    <span x-show="$store.cart.count > 0" x-text="$store.cart.count > 99 ? '99+' : $store.cart.count"
                        :class="$store.cart._badgePop ? 'badge-pop' : ''"
                        @animationend="$store.cart._badgePop = false"
                        class="absolute -top-1 -right-1 bg-blue-600 text-white text-[10px] font-black min-w-[18px] h-[18px] px-1 flex items-center justify-center rounded-full pointer-events-none"></span>
                </div>

                <button class="p-2 text-zinc-300 hover:text-white transition-all hover:bg-zinc-800 rounded-lg">
                    <span class="material-symbols-outlined">account_circle</span>
                </button>
            </div>
        </div>
    </nav>


    <!-- =====================================================================
     HERO
     ===================================================================== -->
    <header class="relative min-h-[870px] flex items-center justify-center pt-16 bg-zinc-900 overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-40">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900/40 via-transparent to-transparent"></div>
            <div class="w-full h-full"
                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBhAmvokStahr7s2-oSzffJoUOoAvuDLXH0lf6hX5rR4nDsjGtKsw0B30MVD6wMf6v65uMzPhMWGOxLwGg6faU34fKeXFm7u-ssbAxUmfvBBFdN5EXGhgI-GoLBnCJsxwMvX7j34xRzt5Zqp_25-Wi3uCLQVD_luBNx4mjD8ytuBFkdztcKiOzfFwfxF7PMTTD92xa-shDsWItEm9wnRpX8ahi7qw2k8jglrW4_nHOVT8ntNNudQuyNOIZLZFv-FuNxdXkNZ-X_wFr3'); background-size: cover; background-position: center;">
            </div>
        </div>
        <div class="relative z-10 text-center px-6 max-w-5xl">
            <h1 class="font-headline text-5xl md:text-7xl font-black text-white tracking-tighter leading-none mb-6">
                Your Digital Universe,<br /><span class="text-blue-500">Delivered Instantly.</span>
            </h1>
            <p class="text-zinc-400 text-lg md:text-xl font-medium mb-10 tracking-wide">
                Repair Services <span class="mx-2 text-blue-600">·</span> Gift Cards
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <button
                    class="px-10 py-4 bg-gradient-to-br from-primary to-primary-container text-white font-bold rounded-full text-lg shadow-lg shadow-primary/20 hover:scale-105 transition-transform">
                    Shop Now
                </button>
                <button
                    class="px-10 py-4 bg-zinc-800 text-white font-bold rounded-full text-lg hover:bg-zinc-700 transition-colors">
                    View Auctions
                </button>
            </div>
        </div>
    </header>


    <!-- =====================================================================
     MAIN CONTENT
     ===================================================================== -->
    <main class="py-20 space-y-24 max-w-[1920px] mx-auto px-6">


        <!-- ── Repair Services (Dynamic from DB) ─────────────────────────── -->
        @if ($repairServices->isNotEmpty())
            <section id="repair-services">
                <div class="flex items-center justify-between mb-10">
                    <div class="border-l-4 border-orange-500 pl-4">
                        <h2 class="font-headline text-2xl font-bold text-on-background tracking-tight">Repair Services
                        </h2>
                        <div class="h-1 w-12 bg-orange-500/30 mt-1"></div>
                    </div>
                    <span
                        class="text-xs font-bold text-zinc-400 uppercase tracking-widest">{{ $repairServices->count() }}
                        services</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($repairServices as $service)
                        <div class="relative bg-surface-container-lowest rounded-xl border border-zinc-200 overflow-hidden transition-all hover:shadow-xl hover:-translate-y-1 group"
                            x-data="{
                                product: {
                                    id: '{{ $service->id }}',
                                    name: {{ Js::from($service->name) }},
                                    platform: 'Repair Service',
                                    price: {{ $service->price }},
                                    type: 'repair',
                                    image: null
                                },
                                added: false
                            }">
                            {{-- Icon header --}}
                            <div
                                class="aspect-4/3 bg-linear-to-br from-orange-500/10 via-surface-container to-amber-500/5 flex items-center justify-center relative overflow-hidden">
                                <div
                                    class="absolute inset-0 bg-[radial-gradient(circle_at_70%_30%,rgba(249,115,22,0.15),transparent_60%)]">
                                </div>
                                @php
                                    $icons = [
                                        'Screen' => 'phone_iphone',
                                        'Battery' => 'battery_charging_full',
                                        'Network' => 'signal_cellular_alt',
                                        'Unlock' => 'lock_open',
                                        'FRP' => 'shield',
                                        'Bypass' => 'shield',
                                        'Software' => 'system_update',
                                        'Flash' => 'system_update',
                                        'Data' => 'sd_storage',
                                        'Recovery' => 'sd_storage',
                                        'Water' => 'water_drop',
                                        'Charging' => 'cable',
                                        'Port' => 'cable',
                                    ];
                                    $icon = 'build';
                                    foreach ($icons as $keyword => $materialIcon) {
                                        if (str_contains($service->name, $keyword)) {
                                            $icon = $materialIcon;
                                            break;
                                        }
                                    }
                                @endphp
                                <span
                                    class="material-symbols-outlined text-6xl text-orange-500/60 group-hover:text-orange-500 group-hover:scale-110 transition-all duration-300 relative z-10">{{ $icon }}</span>
                            </div>

                            {{-- Content --}}
                            <div class="p-5">
                                <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest mb-1">Repair
                                </p>
                                <h3 class="text-sm font-black text-on-background mb-2">{{ $service->name }}</h3>
                                <p class="text-xs text-zinc-500 leading-relaxed mb-4 line-clamp-2">
                                    {{ $service->description }}</p>
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-sm font-black text-orange-600">MZN
                                        {{ number_format($service->price, 0, ',', '.') }}</span>
                                    <a href="/orders?service_code={{ $service->id }}&take_order=true"
                                        class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-xs font-black rounded-full transition-all flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-sm">shopping_cart_checkout</span>
                                        <span>Take order</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- ── Gift Cards (Dynamic from DB) ──────────────────────────────── -->
        <section id="gift-cards" class="gap-12">
            <div>
                <div class="flex items-center justify-between mb-8">
                    <div class="border-l-4 border-blue-600 pl-4">
                        <h2 class="font-headline text-2xl font-bold text-on-background tracking-tight">Gift Cards</h2>
                        <div class="h-1 w-12 bg-blue-600/30 mt-1"></div>
                    </div>
                </div>

                @if ($giftCards->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($giftCards as $card)
                            @php
                                $brandIcons = [
                                    'Amazon' => ['abbr' => 'AMZ', 'from' => 'from-yellow-500', 'to' => 'to-orange-400'],
                                    'App Store' => ['abbr' => 'AAPL', 'from' => 'from-gray-700', 'to' => 'to-gray-500'],
                                    'iTunes' => ['abbr' => 'AAPL', 'from' => 'from-pink-500', 'to' => 'to-pink-400'],
                                    'Google' => ['abbr' => 'GGL', 'from' => 'from-green-500', 'to' => 'to-emerald-400'],
                                    'Netflix' => ['abbr' => 'NFLX', 'from' => 'from-red-600', 'to' => 'to-red-400'],
                                    'PlayStation' => [
                                        'abbr' => 'PSN',
                                        'from' => 'from-blue-600',
                                        'to' => 'to-indigo-500',
                                    ],
                                    'Xbox' => ['abbr' => 'XBOX', 'from' => 'from-green-600', 'to' => 'to-green-400'],
                                ];
                                $brand = collect($brandIcons)->first(fn($v, $k) => str_contains($card->name, $k));
                                $brand = $brand ?? ['abbr' => 'GC', 'from' => 'from-blue-500', 'to' => 'to-blue-400'];
                            @endphp
                            <a href="/buy-giftcard?service_code={{ $card->id }}" class="flex items-center gap-4 p-4 bg-surface-container-lowest border border-zinc-200 rounded-xl hover:shadow-lg transition-all cursor-pointer group">
                                <div
                                    class="w-14 h-14 bg-linear-to-br {{ $brand['from'] }} {{ $brand['to'] }} rounded-lg flex items-center justify-center text-white text-xs font-black shrink-0 shadow-lg">
                                    {{ $brand['abbr'] }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-sm text-on-background">{{ $card->name }}</h4>
                                    <p class="text-xs text-zinc-500 line-clamp-1">{{ $card->description }}</p>
                                </div>
                                <div class="flex flex-col items-end gap-1 flex-shrink-0">
                                    <span class="text-sm font-black text-blue-600">MZN
                                        {{ number_format($card->price, 0, ',', '.') }}</span>
                                    <span class="material-symbols-outlined text-primary transition-all text-lg opacity-0 group-hover:opacity-100">
                                        shopping_cart_checkout
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-zinc-500 text-sm">No gift cards available at the moment.</p>
                @endif
            </div>

        </section>
    </main>


    <!-- =====================================================================
     FOOTER
     ===================================================================== -->
    <footer class="bg-zinc-900 pt-20 pb-12 px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div>
                    <h2 class="text-xl font-bold text-white mb-6">RIBERI</h2>
                    <p class="text-zinc-400 text-sm leading-relaxed mb-6">
                        The premiere marketplace for premium digital goods, gaming accounts, and crypto-backed assets.
                        Secured by RIBERI.
                    </p>
                    <div class="flex gap-4">
                        <a class="w-10 h-10 bg-zinc-800 rounded-full flex items-center justify-center text-white hover:bg-blue-600 transition-colors"
                            href="#">
                            <span class="material-symbols-outlined text-sm">public</span>
                        </a>
                        <a class="w-10 h-10 bg-zinc-800 rounded-full flex items-center justify-center text-white hover:bg-blue-600 transition-colors"
                            href="#">
                            <span class="material-symbols-outlined text-sm">chat</span>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="font-headline text-blue-500 text-xs font-black uppercase tracking-widest mb-8">About
                    </h3>
                    <ul class="space-y-4">
                        <li><a class="text-zinc-300 hover:text-blue-400 transition-all hover:translate-x-1 inline-block text-sm"
                                href="#">Our Mission</a></li>
                        <li><a class="text-zinc-300 hover:text-blue-400 transition-all hover:translate-x-1 inline-block text-sm"
                                href="#">Security Standards</a></li>
                        <li><a class="text-zinc-300 hover:text-blue-400 transition-all hover:translate-x-1 inline-block text-sm"
                                href="#">API Docs</a></li>
                        <li><a class="text-zinc-300 hover:text-blue-400 transition-all hover:translate-x-1 inline-block text-sm"
                                href="#">Discord</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-headline text-blue-500 text-xs font-black uppercase tracking-widest mb-8">Buy</h3>
                    <ul class="space-y-4">
                        <li><a class="text-zinc-300 hover:text-blue-400 transition-all hover:translate-x-1 inline-block text-sm"
                                href="#">Marketplace</a></li>
                        <li><a class="text-zinc-300 hover:text-blue-400 transition-all hover:translate-x-1 inline-block text-sm"
                                href="#">Auctions</a></li>
                        <li><a class="text-zinc-300 hover:text-blue-400 transition-all hover:translate-x-1 inline-block text-sm"
                                href="#">Creators</a></li>
                        <li><a class="text-zinc-300 hover:text-blue-400 transition-all hover:translate-x-1 inline-block text-sm"
                                href="#">Bulk Orders</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-headline text-blue-500 text-xs font-black uppercase tracking-widest mb-8">Help
                        Center</h3>
                    <ul class="space-y-4">
                        <li><a class="text-zinc-300 hover:text-blue-400 transition-all hover:translate-x-1 inline-block text-sm"
                                href="#">Help Center</a></li>
                        <li><a class="text-zinc-300 hover:text-blue-400 transition-all hover:translate-x-1 inline-block text-sm"
                                href="#">Terms of Service</a></li>
                        <li><a class="text-zinc-300 hover:text-blue-400 transition-all hover:translate-x-1 inline-block text-sm"
                                href="#">Privacy Policy</a></li>
                        <li><a class="text-zinc-300 hover:text-blue-400 transition-all hover:translate-x-1 inline-block text-sm"
                                href="#">License Agreement</a></li>
                    </ul>
                </div>
            </div>
            <div
                class="pt-12 border-t border-blue-600/30 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-zinc-400 text-xs">© 2025 RIBERI Digital Goods. All rights reserved.</p>
                <div class="flex gap-8">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-zinc-500 text-[10px] font-bold uppercase tracking-tighter">System
                            Operational</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-zinc-500 text-sm">language</span>
                        <span class="text-zinc-500 text-[10px] font-bold uppercase tracking-tighter">Português
                            (MZ)</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- FAB -->
    <div class="fixed bottom-8 right-8 z-40">
        <button
            class="w-16 h-16 bg-primary text-white rounded-full shadow-2xl shadow-primary/40 flex items-center justify-center hover:scale-110 transition-transform group">
            <span class="material-symbols-outlined text-3xl">add</span>
            <span
                class="absolute right-full mr-4 bg-zinc-900 text-white text-xs font-bold px-4 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">List
                Your Asset</span>
        </button>
    </div>
    @fluxScripts
</body>

</html>
