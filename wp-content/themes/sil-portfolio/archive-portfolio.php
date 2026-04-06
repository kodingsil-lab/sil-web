<?php
if (!defined('ABSPATH')) exit;
get_header();
?>

<div class="min-h-screen lg:flex">
    <?php get_template_part('template-parts/sidebar'); ?>

    <main class="flex-1 px-6 py-10 lg:px-12 lg:py-14">
        <div class="mx-auto max-w-6xl">
            <div class="fade-in mb-8">
                <p class="text-sm font-medium text-emerald-700">Portfolio</p>
                <h1 class="mt-2 text-3xl font-bold">Semua Project</h1>
                <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">
                    Kumpulan project website yang telah dibuat dengan pendekatan clean, modern, dan profesional.
                </p>
            </div>

            <?php if (have_posts()) : ?>
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php
                        $client    = function_exists('get_field') ? get_field('client') : '';
                        $tahun     = function_exists('get_field') ? get_field('tahun') : '';
                        $highlight = function_exists('get_field') ? get_field('highlight') : '';
                        ?>
                        <article class="fade-in card-hover overflow-hidden rounded-[22px] border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-950">
                            <a href="<?php the_permalink(); ?>" class="media-shell block aspect-[4/3] bg-slate-200">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('large', ['class' => 'media-image h-full w-full object-cover', 'loading' => 'lazy', 'decoding' => 'async']); ?>
                                <?php else : ?>
                                    <div class="flex h-full w-full flex-col items-center justify-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                                        <span class="text-xs uppercase tracking-[0.2em]">Preview</span>
                                        <span>Project segera ditampilkan</span>
                                    </div>
                                <?php endif; ?>
                            </a>

                            <div class="p-5">
                                <div class="mb-3 flex flex-wrap gap-2 text-xs">
                                    <?php if ($client) : ?>
                                        <span class="rounded-full bg-emerald-50 px-3 py-1 font-medium text-emerald-700">
                                            <?php echo esc_html($client); ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if ($tahun) : ?>
                                        <span class="rounded-full bg-slate-100 px-3 py-1 font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-200">
                                            <?php echo esc_html($tahun); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <h2 class="text-lg font-bold">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-emerald-700">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <p class="mt-2 text-sm leading-7 text-slate-600 dark:text-slate-300">
                                    <?php echo esc_html($highlight ? $highlight : get_the_excerpt()); ?>
                                </p>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div class="mt-8">
                    <?php the_posts_pagination(); ?>
                </div>
            <?php else : ?>
                <p class="text-sm text-slate-500">Belum ada portfolio.</p>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php get_footer(); ?>
