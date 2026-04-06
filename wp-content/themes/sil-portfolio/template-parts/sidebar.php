<?php if (!defined('ABSPATH')) exit; ?>
<?php
$nama = function_exists('sil_get_profile_option') ? sil_get_profile_option('nama', '') : '';
$jabatan = function_exists('sil_get_profile_option') ? sil_get_profile_option('jabatan', '') : '';
$bio = function_exists('sil_get_profile_option') ? sil_get_profile_option('bio', '') : '';
$foto = function_exists('sil_get_profile_option') ? sil_get_profile_option('foto', '') : '';
$email = function_exists('sil_get_profile_option') ? sil_get_profile_option('email', '') : '';
$wa = function_exists('sil_get_profile_option') ? sil_get_profile_option('whatsapp', '') : '';
$github = function_exists('sil_get_profile_option') ? sil_get_profile_option('github', '') : '';
$instagram = function_exists('sil_get_profile_option') ? sil_get_profile_option('instagram', '') : '';

$nama = $nama ?: get_bloginfo('name');
$jabatan = $jabatan ?: get_bloginfo('description');
$bio = $bio ?: 'Website profil, company profile, portfolio, dan landing page.';
$local_profile_fallback = get_template_directory_uri() . '/assets/images/generated/profile-fallback.png';
$foto = $foto ?: $local_profile_fallback;
$foto_fallback = $local_profile_fallback;
$email_link = $email ? 'mailto:' . antispambot($email) : '';
$whatsapp_link = $wa ? 'https://wa.me/' . preg_replace('/\D+/', '', $wa) : '';
$current_url = untrailingslashit((is_ssl() ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? '') . ($_SERVER['REQUEST_URI'] ?? ''));
$menu_locations = get_nav_menu_locations();
$primary_menu_items = [];
$icon_map = [
    'tentang|about|profil|profile' => [
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4"><circle cx="12" cy="8" r="3.25"/><path stroke-linecap="round" stroke-linejoin="round" d="M5.5 19a6.5 6.5 0 0 1 13 0"/></svg>',
        'classes' => 'text-slate-700 bg-slate-50 border-slate-200 dark:text-slate-100 dark:bg-slate-900 dark:border-slate-700',
    ],
    'portfolio|portofolio|project|proyek|karya' => [
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4"><rect x="3.5" y="6.5" width="17" height="11" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.5V5a1.5 1.5 0 0 1 1.5-1.5h3A1.5 1.5 0 0 1 15 5v1.5"/></svg>',
        'classes' => 'text-slate-700 bg-slate-50 border-slate-200 dark:text-slate-100 dark:bg-slate-900 dark:border-slate-700',
    ],
    'layanan|service|services|harga|pricing' => [
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 9.5h16"/><rect x="4" y="6" width="16" height="12" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 6V4.5h6V6"/></svg>',
        'classes' => 'text-slate-700 bg-slate-50 border-slate-200 dark:text-slate-100 dark:bg-slate-900 dark:border-slate-700',
    ],
    'kontak|contact|hubungi' => [
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6.5h16v11H4z"/><path stroke-linecap="round" stroke-linejoin="round" d="m5 7 7 6 7-6"/></svg>',
        'classes' => 'text-slate-700 bg-slate-50 border-slate-200 dark:text-slate-100 dark:bg-slate-900 dark:border-slate-700',
    ],
    'resume|cv|riwayat' => [
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M8 3.5h6l4 4V20a.5.5 0 0 1-.5.5h-11A.5.5 0 0 1 6 20V4a.5.5 0 0 1 .5-.5H8Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 3.5V8h4"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h6"/></svg>',
        'classes' => 'text-slate-700 bg-slate-50 border-slate-200 dark:text-slate-100 dark:bg-slate-900 dark:border-slate-700',
    ],
    'blog|artikel|berita|tulisan' => [
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18.5a2.5 2.5 0 0 1 2.5-2.5H18"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 5.5h12v13H8.5A2.5 2.5 0 0 1 6 16V5.5Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 9h6M9 12h6"/></svg>',
        'classes' => 'text-slate-700 bg-slate-50 border-slate-200 dark:text-slate-100 dark:bg-slate-900 dark:border-slate-700',
    ],
    'more|page|halaman|lainnya|tambahan' => [
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4"><circle cx="6.5" cy="12" r="1.25"/><circle cx="12" cy="12" r="1.25"/><circle cx="17.5" cy="12" r="1.25"/></svg>',
        'classes' => 'text-slate-600 bg-slate-50 border-slate-200 dark:text-slate-300 dark:bg-slate-800 dark:border-slate-700',
    ],
];

if (!empty($menu_locations['primary_menu'])) {
    $primary_menu_items = wp_get_nav_menu_items($menu_locations['primary_menu']);
}

$social_links = array_filter([
    [
        'label' => 'Email',
        'url' => $email_link,
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6.5h16v11H4z"/><path stroke-linecap="round" stroke-linejoin="round" d="m5 7 7 6 7-6"/></svg>',
        'classes' => 'text-slate-700 bg-white border-slate-200 shadow-sm dark:text-slate-100 dark:bg-slate-900 dark:border-slate-700',
    ],
    [
        'label' => 'WhatsApp',
        'url' => $whatsapp_link,
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M20 11.5a8 8 0 1 1-14.9 4l-1.1 3.5 3.6-1A8 8 0 0 1 20 11.5Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.5 8.8c.3-.7.8-.7 1.1-.7h.4c.1 0 .3.1.4.4l.8 1.9c.1.2.1.4 0 .6l-.4.5c-.1.1-.2.3-.1.5.3.6 1 1.5 2.1 2.1.2.1.4 0 .5-.1l.5-.5c.2-.2.4-.2.6-.1l1.8.8c.2.1.4.2.4.4v.4c0 .4-.2.8-.7 1.1-.4.2-1.2.4-2.5-.1-1.2-.4-2.7-1.6-3.8-2.7s-2.3-2.7-2.7-3.8c-.4-1.3-.2-2.1 0-2.6Z"/></svg>',
        'classes' => 'text-slate-700 bg-white border-slate-200 shadow-sm dark:text-slate-100 dark:bg-slate-900 dark:border-slate-700',
    ],
    [
        'label' => 'GitHub',
        'url' => $github,
        'icon' => '<svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M12 .5a12 12 0 0 0-3.8 23.4c.6.1.8-.2.8-.6v-2.1c-3.3.7-4-1.4-4-1.4-.5-1.3-1.3-1.6-1.3-1.6-1.1-.8 0-.8 0-.8 1.2 0 1.9 1.3 1.9 1.3 1.1 1.8 2.8 1.3 3.5 1 .1-.8.4-1.3.8-1.6-2.7-.3-5.5-1.3-5.5-6A4.6 4.6 0 0 1 6.4 8c-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.3 1.2a11.1 11.1 0 0 1 6 0C18 4.6 19 4.9 19 4.9c.6 1.6.2 2.8.1 3.1a4.6 4.6 0 0 1 1.2 3.2c0 4.6-2.8 5.6-5.5 6 .4.3.8 1 .8 2v3c0 .4.2.7.8.6A12 12 0 0 0 12 .5Z"/></svg>',
        'classes' => 'text-slate-700 bg-white border-slate-200 shadow-sm dark:text-slate-100 dark:bg-slate-900 dark:border-slate-700',
    ],
    [
        'label' => 'Instagram',
        'url' => $instagram,
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4"><rect x="3.5" y="3.5" width="17" height="17" rx="4"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".8" fill="currentColor" stroke="none"/></svg>',
        'classes' => 'text-slate-700 bg-white border-slate-200 shadow-sm dark:text-slate-100 dark:bg-slate-900 dark:border-slate-700',
    ],
]);
?>

<button id="menu-toggle" class="mb-4 rounded-xl bg-emerald-600 px-4 py-2 text-white shadow-sm hover:bg-emerald-700 lg:hidden">
    Menu
</button>

<div id="sidebar-overlay" class="pointer-events-none fixed inset-0 z-40 bg-slate-950/50 opacity-0 backdrop-blur-sm lg:hidden"></div>

<aside id="sidebar" class="fixed left-0 top-0 z-50 h-full w-[280px] -translate-x-full transform border-r border-slate-200 bg-white p-6 shadow-lg transition-transform duration-300 dark:border-slate-800 dark:bg-slate-950 lg:sticky lg:top-0 lg:h-screen lg:w-[320px] lg:flex-shrink-0 lg:translate-x-0 lg:shadow-none">
    <div class="flex h-full flex-col">
        <div class="pb-8 text-center sidebar-divider">
            <div class="media-shell mx-auto mb-4 h-32 w-32 overflow-hidden rounded-full bg-white">
                <img
                    src="<?php echo esc_url($foto); ?>"
                    data-fallback-src="<?php echo esc_url($foto_fallback); ?>"
                    alt="Foto Profil"
                    loading="eager"
                    fetchpriority="high"
                    decoding="async"
                    class="media-image h-full w-full object-cover"
                >
            </div>

            <h1 class="text-2xl font-bold tracking-tight">
                <?php echo esc_html($nama); ?>
            </h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                <?php echo esc_html($jabatan); ?>
            </p>
            <p class="mx-auto mt-3 max-w-[240px] text-sm leading-7 text-slate-500 dark:text-slate-400">
                <?php echo esc_html($bio); ?>
            </p>

            <?php if ($social_links) : ?>
                <div class="mt-5 flex flex-wrap items-center justify-center gap-3">
                    <?php foreach ($social_links as $social_link) : ?>
                        <a href="<?php echo esc_url($social_link['url']); ?>"<?php echo str_starts_with($social_link['url'], 'mailto:') ? '' : ' target="_blank" rel="noopener noreferrer"'; ?> class="inline-flex h-10 w-10 items-center justify-center rounded-full border shadow-sm hover:-translate-y-0.5 hover:brightness-105 <?php echo esc_attr($social_link['classes']); ?>" aria-label="<?php echo esc_attr($social_link['label']); ?>">
                            <?php echo $social_link['icon']; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <nav class="my-8 pb-8 sidebar-divider">
            <?php if ($primary_menu_items) : ?>
                <ul class="space-y-2">
                    <?php foreach ($primary_menu_items as $menu_item) : ?>
                        <?php
                        $label = wp_strip_all_tags($menu_item->title);
                        $normalized = sanitize_title($label);
                        $item_url = untrailingslashit($menu_item->url);
                        $is_active = false;
                        $icon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/><path stroke-linecap="round" stroke-linejoin="round" d="m12 5 7 7-7 7"/></svg>';
                        $icon_classes = 'text-slate-600 bg-slate-50 border-slate-200 dark:text-slate-300 dark:bg-slate-800 dark:border-slate-700';

                        if ($item_url && $current_url && $item_url === $current_url) {
                            $is_active = true;
                        } elseif (!empty($menu_item->object_id) && is_singular() && (int) get_queried_object_id() === (int) $menu_item->object_id) {
                            $is_active = true;
                        } elseif (!empty($menu_item->object) && 'page' === $menu_item->object && is_page($menu_item->object_id)) {
                            $is_active = true;
                        }

                        foreach ($icon_map as $pattern => $icon_data) {
                            if (preg_match('/(' . $pattern . ')/i', $normalized)) {
                                $icon = $icon_data['icon'];
                                $icon_classes = $icon_data['classes'];
                                break;
                            }
                        }
                        ?>
                        <li>
                            <a href="<?php echo esc_url($menu_item->url); ?>" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold <?php echo $is_active ? 'bg-emerald-50 text-emerald-700 shadow-sm ring-1 ring-emerald-100 dark:bg-slate-800 dark:text-emerald-400 dark:ring-emerald-900/40' : 'text-slate-700 hover:bg-emerald-50/80 hover:text-emerald-700 dark:text-slate-100 dark:hover:bg-slate-800 dark:hover:text-emerald-400'; ?>" aria-current="<?php echo $is_active ? 'page' : 'false'; ?>">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full border <?php echo $is_active ? 'border-emerald-200 bg-white text-emerald-700 shadow-sm dark:border-emerald-900/50 dark:bg-slate-900 dark:text-emerald-400' : $icon_classes; ?>">
                                    <?php echo $icon; ?>
                                </span>
                                <span><?php echo esc_html($label); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </nav>

        <div class="pb-8 sidebar-divider">
            <button id="dark-toggle" type="button" role="switch" aria-checked="false" class="flex w-full items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 hover:border-emerald-200 hover:bg-emerald-50/70 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:hover:border-emerald-900 dark:hover:bg-slate-800">
                <span class="flex items-center gap-3">
                    <span id="dark-toggle-icon" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-amber-100 bg-amber-50 text-amber-600 dark:border-indigo-500/20 dark:bg-indigo-500/10 dark:text-indigo-300">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4"><circle cx="12" cy="12" r="3.5"/><path stroke-linecap="round" d="M12 2.5v2.2M12 19.3v2.2M4.9 4.9l1.5 1.5M17.6 17.6l1.5 1.5M2.5 12h2.2M19.3 12h2.2M4.9 19.1l1.5-1.5M17.6 6.4l1.5-1.5"/></svg>
                    </span>
                    <span>
                        <span class="block font-semibold" id="dark-toggle-label">Mode Gelap</span>
                        <span class="block text-xs text-slate-500 dark:text-slate-400" id="dark-toggle-description">Tampilan terang sedang aktif</span>
                    </span>
                </span>
                <span class="sidebar-switch-track">
                    <span class="sidebar-switch-thumb"></span>
                </span>
            </button>
        </div>

        <div class="mt-auto rounded-2xl bg-slate-50 p-4 dark:bg-slate-900">
            <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">Siap bekerja sama</p>

            <?php if ($wa) : ?>
                <a href="https://wa.me/<?php echo esc_attr($wa); ?>" target="_blank" rel="noopener noreferrer" class="mt-4 inline-flex w-full justify-center rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-4 py-3 text-white shadow-[0_16px_40px_-22px_rgba(16,185,129,0.9)] ring-1 ring-emerald-400/30 hover:from-emerald-500 hover:to-emerald-700 hover:shadow-[0_20px_45px_-24px_rgba(16,185,129,1)] dark:ring-emerald-500/20">
                    Hubungi Saya
                </a>
            <?php elseif ($email) : ?>
                <a href="mailto:<?php echo antispambot(esc_attr($email)); ?>" class="mt-4 inline-flex w-full justify-center rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-4 py-3 text-white shadow-[0_16px_40px_-22px_rgba(16,185,129,0.9)] ring-1 ring-emerald-400/30 hover:from-emerald-500 hover:to-emerald-700 hover:shadow-[0_20px_45px_-24px_rgba(16,185,129,1)] dark:ring-emerald-500/20">
                    Hubungi Saya
                </a>
            <?php endif; ?>
        </div>
    </div>
</aside>
