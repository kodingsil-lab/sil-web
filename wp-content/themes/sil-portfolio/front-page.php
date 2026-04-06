<?php
if (!defined('ABSPATH')) exit;
get_header();

$nama = function_exists('sil_get_profile_option') ? sil_get_profile_option('nama', '') : '';
$jabatan = function_exists('sil_get_profile_option') ? sil_get_profile_option('jabatan', '') : '';
$bio = function_exists('sil_get_profile_option') ? sil_get_profile_option('bio', '') : '';
$email = function_exists('sil_get_profile_option') ? sil_get_profile_option('email', '') : '';
$wa = function_exists('sil_get_profile_option') ? sil_get_profile_option('whatsapp', '') : '';
$github = function_exists('sil_get_profile_option') ? sil_get_profile_option('github', '') : '';
$instagram = function_exists('sil_get_profile_option') ? sil_get_profile_option('instagram', '') : '';
$cv = function_exists('sil_get_profile_option') ? sil_get_profile_option('cv', '') : '';

$front_page_id = (int) get_option('page_on_front');
$hero_title = $front_page_id ? get_the_title($front_page_id) : get_bloginfo('name');
$hero_excerpt = $front_page_id ? get_post_field('post_excerpt', $front_page_id) : '';
$hero_content = $front_page_id ? get_post_field('post_content', $front_page_id) : '';

if (!$hero_excerpt) {
    $hero_excerpt = $bio ?: 'Saya membantu membangun website yang bersih, modern, dan nyaman digunakan.';
}

if (!$hero_content) {
    $hero_content = 'Fokus saya adalah membuat tampilan website yang rapi, profesional, tidak ramai, dan tetap enak diakses pada desktop maupun mobile.';
}

$portfolio_count = (int) wp_count_posts('portfolio')->publish;
$portfolio_archive_url = get_post_type_archive_link('portfolio');
$contact_link = $wa ? 'https://wa.me/' . preg_replace('/\D+/', '', $wa) : ($email ? 'mailto:' . antispambot($email) : '#kontak');
$contact_label = $wa ? 'WhatsApp Saya' : ($email ? antispambot($email) : 'Kontak');
?>

<div class="min-h-screen lg:flex">
    <?php get_template_part('template-parts/sidebar'); ?>

    <main class="flex-1">
        <section class="px-6 py-10 lg:px-12 lg:py-14">
            <div class="mx-auto max-w-6xl">
                <div class="grid gap-6 lg:grid-cols-[1.3fr_0.9fr]">
                    <div class="fade-in card-hover rounded-[28px] bg-white p-8 shadow-sm ring-1 ring-slate-200 dark:bg-slate-950 dark:ring-slate-800">
                        <p class="mb-4 inline-flex rounded-full bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700">
                            Selamat datang di website portfolio saya
                        </p>

                        <h2 class="max-w-3xl text-4xl font-bold leading-tight tracking-tight lg:text-5xl">
                            <?php echo esc_html($hero_title ?: 'Sil Portfolio'); ?>
                        </h2>

                        <p class="mt-6 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-300">
                            <?php echo esc_html(wp_strip_all_tags($hero_excerpt)); ?>
                        </p>

                        <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-500 dark:text-slate-400">
                            <?php echo esc_html(wp_strip_all_tags($hero_content)); ?>
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            <a href="#portfolio" class="btn rounded-xl bg-emerald-600 text-sm text-white hover:bg-emerald-700">
                                Lihat Portfolio
                            </a>
                            <a href="<?php echo esc_url($contact_link); ?>" class="btn rounded-xl border border-slate-300 bg-white text-sm text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:hover:bg-slate-800">
                                Kontak
                            </a>
                        </div>
                    </div>

                    <div class="fade-in card-hover rounded-[28px] bg-gradient-to-br from-emerald-500 to-teal-600 p-8 text-white shadow-sm">
                        <p class="text-sm font-medium text-white/80">Profil Singkat</p>
                        <h3 class="mt-3 text-2xl font-bold">
                            <?php echo esc_html($jabatan ?: 'Frontend yang clean, smooth, dan elegan'); ?>
                        </h3>
                        <p class="mt-4 text-sm leading-7 text-white/90">
                            <?php echo esc_html($bio ?: 'Cocok untuk personal branding, portfolio dosen, profesional, lembaga, atau usaha.'); ?>
                        </p>

                        <div class="mt-8 grid grid-cols-2 gap-4">
                            <div class="rounded-2xl bg-white/10 p-4 backdrop-blur-sm">
                                <p class="text-2xl font-bold"><?php echo esc_html($portfolio_count); ?>+</p>
                                <p class="mt-1 text-sm text-white/80">Project publish</p>
                            </div>
                            <div class="rounded-2xl bg-white/10 p-4 backdrop-blur-sm">
                                <p class="text-2xl font-bold"><?php echo esc_html($nama ?: 'Sil'); ?></p>
                                <p class="mt-1 text-sm text-white/80">Profil website aktif</p>
                            </div>
                        </div>

                        <?php if ($cv || $github || $instagram) : ?>
                            <div class="mt-6 flex flex-wrap gap-3">
                                <?php if ($cv) : ?>
                                    <a href="<?php echo esc_url($cv); ?>" target="_blank" rel="noopener noreferrer" class="rounded-xl bg-white/15 px-4 py-3 text-sm font-semibold text-white hover:bg-white/20">
                                        Lihat CV
                                    </a>
                                <?php endif; ?>
                                <?php if ($github) : ?>
                                    <a href="<?php echo esc_url($github); ?>" target="_blank" rel="noopener noreferrer" class="rounded-xl bg-white/15 px-4 py-3 text-sm font-semibold text-white hover:bg-white/20">
                                        GitHub
                                    </a>
                                <?php endif; ?>
                                <?php if ($instagram) : ?>
                                    <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer" class="rounded-xl bg-white/15 px-4 py-3 text-sm font-semibold text-white hover:bg-white/20">
                                        Instagram
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <section id="layanan" class="mt-8 grid gap-6 md:grid-cols-3">
                    <article class="fade-in card-hover rounded-[24px] bg-white p-6 shadow-sm ring-1 ring-slate-200 dark:bg-slate-950 dark:ring-slate-800">
                        <h3 class="text-lg font-bold">UI Website</h3>
                        <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">
                            Tampilan modern, ringan, dan fokus pada keterbacaan.
                        </p>
                    </article>

                    <article class="fade-in card-hover rounded-[24px] bg-white p-6 shadow-sm ring-1 ring-slate-200 dark:bg-slate-950 dark:ring-slate-800">
                        <h3 class="text-lg font-bold">WordPress Custom</h3>
                        <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">
                            Backend tetap WordPress, tetapi frontend dibuat lebih eksklusif.
                        </p>
                    </article>

                    <article class="fade-in card-hover rounded-[24px] bg-white p-6 shadow-sm ring-1 ring-slate-200 dark:bg-slate-950 dark:ring-slate-800">
                        <h3 class="text-lg font-bold">Responsif</h3>
                        <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">
                            Nyaman dibuka di laptop, tablet, dan handphone.
                        </p>
                    </article>
                </section>

                <section id="portfolio" class="fade-in mt-8 rounded-[28px] bg-white p-8 shadow-sm ring-1 ring-slate-200 dark:bg-slate-950 dark:ring-slate-800">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-emerald-700">Portfolio</p>
                            <h3 class="mt-2 text-2xl font-bold">Project Pilihan</h3>
                        </div>
                        <a href="<?php echo esc_url($portfolio_archive_url ?: '#'); ?>" class="text-sm font-semibold text-emerald-700">Lihat semua</a>
                    </div>

                    <div class="mt-6 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                        <?php
                        $portfolio_query = new WP_Query([
                            'post_type'      => 'portfolio',
                            'posts_per_page' => 6,
                            'meta_key'       => 'urutan',
                            'orderby'        => 'meta_value_num',
                            'order'          => 'ASC',
                            'post_status'    => 'publish',
                        ]);

                        if ($portfolio_query->have_posts()) :
                            while ($portfolio_query->have_posts()) : $portfolio_query->the_post();

                                $client     = function_exists('get_field') ? get_field('client') : '';
                                $teknologi  = function_exists('get_field') ? get_field('teknologi') : '';
                                $tahun      = function_exists('get_field') ? get_field('tahun') : '';
                                $highlight  = function_exists('get_field') ? get_field('highlight') : '';
                                $demo_url   = function_exists('get_field') ? get_field('demo_url') : '';
                                ?>

                                <article class="card-hover overflow-hidden rounded-[22px] border border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-900">
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
                                                <span class="rounded-full bg-slate-200 px-3 py-1 font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-200">
                                                    <?php echo esc_html($tahun); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <h4 class="text-lg font-bold">
                                            <a href="<?php the_permalink(); ?>" class="hover:text-emerald-700">
                                                <?php the_title(); ?>
                                            </a>
                                        </h4>

                                        <p class="mt-2 text-sm leading-7 text-slate-600 dark:text-slate-300">
                                            <?php echo esc_html($highlight ? $highlight : get_the_excerpt()); ?>
                                        </p>

                                        <?php if ($teknologi) : ?>
                                            <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">
                                                <strong>Teknologi:</strong> <?php echo esc_html($teknologi); ?>
                                            </p>
                                        <?php endif; ?>

                                        <div class="mt-4 flex gap-3">
                                            <a href="<?php the_permalink(); ?>" class="text-sm font-semibold text-emerald-700">
                                                Detail
                                            </a>

                                            <?php if ($demo_url) : ?>
                                                <a href="<?php echo esc_url($demo_url); ?>" target="_blank" rel="noopener noreferrer" class="text-sm font-semibold text-slate-700">
                                                    Demo
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </article>

                                <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            ?>
                            <p class="text-sm text-slate-500">Belum ada data portfolio.</p>
                            <?php
                        endif;
                        ?>
                    </div>
                </section>

                <section id="kontak" class="fade-in mt-8 rounded-[28px] bg-white p-8 shadow-sm ring-1 ring-slate-200 dark:bg-slate-950 dark:ring-slate-800">
                    <p class="text-sm font-medium text-emerald-700">Kontak</p>
                    <h3 class="mt-2 text-2xl font-bold">Mari diskusikan website Anda</h3>
                    <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-300">
                        Anda bisa mulai dari website profile, portfolio, atau company profile dengan backend WordPress.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="<?php echo esc_url($contact_link); ?>" class="btn inline-flex rounded-xl bg-slate-900 text-sm text-white hover:opacity-90 dark:bg-emerald-600 dark:hover:bg-emerald-700">
                            <?php echo esc_html($contact_label); ?>
                        </a>

                        <?php if ($email) : ?>
                            <a href="mailto:<?php echo antispambot(esc_attr($email)); ?>" class="btn inline-flex rounded-xl border border-slate-300 bg-white text-sm text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:hover:bg-slate-800">
                                <?php echo esc_html(antispambot($email)); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </section>
    </main>
</div>

<?php get_footer(); ?>
