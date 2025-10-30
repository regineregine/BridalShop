<?php

?>
<header
    class="relative overflow-hidden bg-linear-to-b from-candy-cream via-candy-pink-light to-candy-lavender-light text-center min-h-80 sm:min-h-[420px] md:min-h-[520px]"
    style="
    background-image: url('../img/bg-1.png');
    background-size: cover;
    background-position: center;
    background-blend-mode: overlay;
  ">
    <div class="absolute inset-0 bg-linear-to-b from-candy-cream/80 via-candy-pink-light/70 to-candy-lavender-light/80">
    </div>
    <div
        class="relative z-10 mx-auto max-w-4xl px-4 py-20 sm:max-w-5xl sm:py-28 md:py-32 <?php echo $extra_class ?? ''; ?>">
        <h1
            class="font-Tinos text-center leading-none tracking-widest animate-glow text-4xl text-pink-950 sm:text-5xl md:text-7xl">
            <?php echo $title; ?>
            <span class="text-pink-600"><?php echo $highlight; ?></span>
        </h1>
        <?php if (!empty($subtitle)): ?>
            <p class="font-Tinos mt-4 text-base text-white sm:text-lg md:text-2xl">
                <?php echo $subtitle; ?>
            </p>
        <?php endif; ?>
    </div>
</header>