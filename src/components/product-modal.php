<!-- product details modal -->
<div id="product-modal"
    class="modal-panel relative mx-auto hidden max-h-[calc(100svh-2rem)] w-full max-w-3xl scale-95 overflow-y-auto rounded-2xl border border-pink-100/40 bg-white p-0 text-pink-900 opacity-0 shadow-[0_10px_30px_rgba(236,72,153,0.06)] ring-1 ring-pink-50 transition-all duration-300 sm:max-h-[calc(100svh-4rem)]">
    <!-- scroll shadows -->
    <div
        class="shadow-top pointer-events-none sticky top-0 z-10 h-6 bg-linear-to-b from-white/90 to-transparent opacity-0 transition-opacity duration-200">
    </div>

    <!-- header -->
    <div class="flex items-start justify-between gap-4 border-b border-pink-100 px-5 py-4">
        <div>
            <h2 id="pm-title" class="font-RobotoCondensed text-2xl font-semibold text-pink-800">
                Product Title
            </h2>
            <div id="pm-price" class="mt-1 text-pink-700 font-semibold">$0.00</div>
        </div>
        <button id="close-product" aria-label="Close product modal"
            class="cursor-pointer rounded-md px-2 py-1 text-3xl font-semibold leading-none text-pink-600/80 transition hover:rotate-90 hover:text-pink-800">
            ×
        </button>
    </div>

    <!-- body -->
    <div class="grid grid-cols-1 gap-4 p-5 md:grid-cols-2">
        <div class="overflow-hidden rounded-lg bg-pink-50">
            <img id="pm-image" src="" alt="Product image" loading="lazy" decoding="async"
                sizes="(min-width: 768px) 50vw, 100vw" class="h-full w-full object-cover" />
        </div>
        <div class="min-h-[200px]">
            <div class="prose max-w-none">
                <p id="pm-description" class="text-pink-800/90 leading-7"></p>
            </div>
        </div>
    </div>

    <div
        class="shadow-bottom pointer-events-none sticky bottom-0 z-10 h-8 bg-linear-to-t from-white/90 to-transparent opacity-0 transition-opacity duration-200">
    </div>
</div>