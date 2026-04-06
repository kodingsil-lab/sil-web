<?php
if (!defined('ABSPATH')) exit;
get_header();

if (have_posts()) :
    while (have_posts()) : the_post();

        $client    = function_exists('get_field') ? get_field('client') : '';
        $teknologi = function_exists('get_field') ? get_field('teknologi') : '';
        $demo_url  = function_exists('get_field') ? get_field('demo_url') : '';
        $github_url = function_exists('get_field') ? get_field('github_url') : '';
        $tahun     = function_exists('get_field') ? get_field('tahun') : '';
        $highlight = function_exists('get_field') ? get_field('highlight') : '';
        ?>

        <div class="min-h-screen lg:flex">
            <?php get_template_part('template-parts/sidebar'); ?>

            <main class="flex-1 px-6 py-10 lg:px-12 lg:py-14">
                <div class="mx-auto max-w-4xl">
                    <article class="fade-in overflow-hidden rounded-[28px] bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-950 dark:ring-slate-800">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="media-shell aspect-[16/9] bg-slate-200">
                                <?php the_post_thumbnail('large', ['class' => 'media-image h-full w-full object-cover', 'loading' => 'eager', 'fetchpriority' => 'high', 'decoding' => 'async']); ?>
                            </div>
                        <?php else : ?>
                            <div class="media-shell flex aspect-[16/9] items-center justify-center bg-slate-200 text-sm text-slate-500 dark:text-slate-400">
                                Preview project belum tersedia
                            </div>
                        <?php endif; ?>

                        <div class="p-8">
                            <div class="mb-4 flex flex-wrap gap-2 text-xs">
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

                            <h1 class="text-3xl font-bold"><?php the_title(); ?></h1>

                            <?php if ($highlight) : ?>
                                <p class="mt-4 text-base leading-8 text-slate-600 dark:text-slate-300">
                                    <?php echo esc_html($highlight); ?>
                                </p>
                            <?php endif; ?>

                            <?php if ($teknologi) : ?>
                                <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">
                                    <strong>Teknologi:</strong> <?php echo esc_html($teknologi); ?>
                                </p>
                            <?php endif; ?>

                            <div class="prose prose-slate mt-8 max-w-none">
                                <?php the_content(); ?>
                            </div>

                            <div class="mt-8 flex flex-wrap gap-3">
                                <?php if ($demo_url) : ?>
                                    <a href="<?php echo esc_url($demo_url); ?>" target="_blank" rel="noopener noreferrer" class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700">
                                        Lihat Demo
                                    </a>
                                <?php endif; ?>

                                <?php if ($github_url) : ?>
                                    <a href="<?php echo esc_url($github_url); ?>" target="_blank" rel="noopener noreferrer" class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-100 dark:hover:bg-slate-800">
                                        GitHub
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                </div>
            </main>
        </div>

        <?php
    endwhile;
endif;

get_footer();
