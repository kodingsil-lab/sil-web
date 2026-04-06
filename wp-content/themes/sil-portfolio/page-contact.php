<?php
/*
Template Name: Halaman Kontak
*/
if (!defined('ABSPATH')) exit;

get_header();

$nama = function_exists('sil_get_profile_option') ? sil_get_profile_option('nama', 'Nama Anda') : 'Nama Anda';
$email = function_exists('sil_get_profile_option') ? sil_get_profile_option('email', 'email@domain.com') : 'email@domain.com';
$bio = function_exists('sil_get_profile_option') ? sil_get_profile_option('bio', 'Silakan hubungi saya untuk diskusi project website Anda.') : 'Silakan hubungi saya untuk diskusi project website Anda.';
$whatsapp = function_exists('sil_get_profile_option') ? sil_get_profile_option('whatsapp', '') : '';
$github = function_exists('sil_get_profile_option') ? sil_get_profile_option('github', '') : '';
$instagram = function_exists('sil_get_profile_option') ? sil_get_profile_option('instagram', '') : '';

$contact_form_html = '';

if (shortcode_exists('contact-form-7')) {
    $contact_form_html = do_shortcode('[contact-form-7 id="21" title="Contact form 1"]');
}
?>

<div class="min-h-screen lg:flex">
    <?php get_template_part('template-parts/sidebar'); ?>

    <main class="flex-1 bg-slate-50 dark:bg-slate-900">
        <section class="border-b border-slate-200 bg-slate-100 px-6 py-12 dark:border-slate-800 dark:bg-slate-800/40 lg:px-12">
            <div class="mx-auto max-w-4xl text-center">
                <h1 class="text-4xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Kontak
                </h1>

                <p class="mx-auto mt-5 max-w-3xl text-base leading-8 text-slate-600 dark:text-slate-300">
                    Tertarik bekerja sama untuk project Anda atau ingin berdiskusi lebih lanjut?
                    Silakan isi formulir di bawah atau kirim email ke
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="font-medium text-emerald-600 hover:text-emerald-700">
                        <?php echo esc_html($email); ?>
                    </a>.
                </p>

                <p class="mt-6 text-sm text-slate-500 dark:text-slate-400">
                    Anda juga dapat terhubung melalui kanal sosial berikut.
                </p>

                <div class="mt-5 flex items-center justify-center gap-4">
                    <?php if ($github) : ?>
                        <a href="<?php echo esc_url($github); ?>" target="_blank" rel="noopener noreferrer" class="text-emerald-600 transition hover:scale-110 hover:text-emerald-700">
                            <span class="text-sm font-semibold">GitHub</span>
                        </a>
                    <?php endif; ?>

                    <?php if ($instagram) : ?>
                        <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer" class="text-emerald-600 transition hover:scale-110 hover:text-emerald-700">
                            <span class="text-sm font-semibold">Instagram</span>
                        </a>
                    <?php endif; ?>

                    <?php if ($whatsapp) : ?>
                        <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)); ?>" target="_blank" rel="noopener noreferrer" class="text-emerald-600 transition hover:scale-110 hover:text-emerald-700">
                            <span class="text-sm font-semibold">WhatsApp</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="px-6 py-12 lg:px-12 lg:py-16">
            <div class="mx-auto max-w-3xl">
                <div class="rounded-[28px] bg-white p-8 shadow-sm ring-1 ring-slate-200 dark:bg-slate-800 dark:ring-slate-700">
                    <div class="mb-8 text-center">
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white">
                            Kirim Pesan
                        </h2>
                    </div>

                    <?php if ($contact_form_html) : ?>
                        <div class="sil-contact-form mt-6">
                            <?php echo $contact_form_html; ?>
                        </div>
                    <?php else : ?>
                        <form action="#" method="post" class="space-y-5">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <input
                                        type="text"
                                        name="nama"
                                        placeholder="Name"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 dark:border-slate-600 dark:bg-slate-900 dark:text-white dark:focus:ring-emerald-900"
                                    >
                                </div>

                                <div>
                                    <input
                                        type="email"
                                        name="email"
                                        placeholder="Email"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 dark:border-slate-600 dark:bg-slate-900 dark:text-white dark:focus:ring-emerald-900"
                                    >
                                </div>
                            </div>

                            <div>
                                <select
                                    name="layanan"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-500 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 dark:border-slate-600 dark:bg-slate-900 dark:text-white dark:focus:ring-emerald-900"
                                >
                                    <option value="">Pilih layanan yang Anda minati...</option>
                                    <option value="website-portfolio">Website Portfolio</option>
                                    <option value="company-profile">Company Profile</option>
                                    <option value="landing-page">Landing Page</option>
                                    <option value="website-kampus">Website Kampus / Sekolah</option>
                                    <option value="custom-wordpress">Custom WordPress Theme</option>
                                </select>
                            </div>

                            <div class="text-sm text-slate-500 dark:text-slate-400">
                                Ingin melihat rincian layanan? Silakan cek halaman
                                <a href="<?php echo esc_url(home_url('/layanan')); ?>" class="font-medium text-emerald-600 hover:text-emerald-700">
                                    Layanan & Harga
                                </a>.
                            </div>

                            <div>
                                <textarea
                                    name="pesan"
                                    rows="8"
                                    placeholder="Enter your message"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 dark:border-slate-600 dark:bg-slate-900 dark:text-white dark:focus:ring-emerald-900"
                                ></textarea>
                            </div>

                            <div>
                                <button
                                    type="submit"
                                    class="inline-flex rounded-xl bg-emerald-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700"
                                >
                                    Send Now
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>

                    <div class="mt-12 text-center text-sm text-slate-400 dark:text-slate-500">
                        <?php echo date('Y'); ?> &copy; <?php echo esc_html($nama); ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<?php get_footer(); ?>
