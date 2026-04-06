<?php

if (!defined('ABSPATH')) {
    exit;
}

function sil_portfolio_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    register_nav_menus([
        'primary_menu' => 'Menu Utama',
    ]);
}
add_action('after_setup_theme', 'sil_portfolio_setup');

function sil_portfolio_assets() {
    wp_enqueue_style(
        'sil-portfolio-tailwind',
        get_template_directory_uri() . '/assets/css/output.css',
        [],
        filemtime(get_template_directory() . '/assets/css/output.css')
    );

    wp_enqueue_script(
        'sil-portfolio-app',
        get_template_directory_uri() . '/assets/js/app.js',
        [],
        filemtime(get_template_directory() . '/assets/js/app.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'sil_portfolio_assets');

function sil_portfolio_menu_classes($classes, $item, $args) {
    if (isset($args->theme_location) && $args->theme_location === 'primary_menu') {
        $classes[] = 'sil-menu-item';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'sil_portfolio_menu_classes', 10, 3);

function sil_portfolio_menu_link_atts($atts, $item, $args) {
    if (isset($args->theme_location) && $args->theme_location === 'primary_menu') {
        $atts['class'] = 'block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-emerald-50 hover:text-emerald-700';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'sil_portfolio_menu_link_atts', 10, 3);

function sil_profile_defaults() {
    return [
        'nama' => get_bloginfo('name'),
        'jabatan' => get_bloginfo('description'),
        'bio' => 'Website profil, company profile, portfolio, dan landing page.',
        'foto' => '',
        'email' => get_option('admin_email'),
        'whatsapp' => '',
        'github' => '',
        'instagram' => '',
        'cv' => '',
    ];
}

function sil_get_profile_settings() {
    $defaults = sil_profile_defaults();
    $settings = get_option('sil_profile_settings', []);

    if (!is_array($settings)) {
        $settings = [];
    }

    return wp_parse_args($settings, $defaults);
}

function sil_get_profile_option($key, $default = '') {
    $settings = sil_get_profile_settings();
    return $settings[$key] ?? $default;
}

function sil_sanitize_profile_settings($input) {
    $defaults = sil_profile_defaults();
    $input = is_array($input) ? $input : [];

    return [
        'nama' => sanitize_text_field($input['nama'] ?? $defaults['nama']),
        'jabatan' => sanitize_text_field($input['jabatan'] ?? $defaults['jabatan']),
        'bio' => sanitize_textarea_field($input['bio'] ?? $defaults['bio']),
        'foto' => esc_url_raw($input['foto'] ?? ''),
        'email' => sanitize_email($input['email'] ?? $defaults['email']),
        'whatsapp' => sanitize_text_field($input['whatsapp'] ?? ''),
        'github' => esc_url_raw($input['github'] ?? ''),
        'instagram' => esc_url_raw($input['instagram'] ?? ''),
        'cv' => esc_url_raw($input['cv'] ?? ''),
    ];
}

function sil_register_profile_settings() {
    register_setting(
        'sil_profile_settings_group',
        'sil_profile_settings',
        [
            'sanitize_callback' => 'sil_sanitize_profile_settings',
            'default' => sil_profile_defaults(),
        ]
    );
}
add_action('admin_init', 'sil_register_profile_settings');

function sil_add_profile_settings_page() {
    add_menu_page(
        'Pengaturan Profil',
        'Profil Website',
        'edit_posts',
        'sil-profile-settings',
        'sil_render_profile_settings_page',
        'dashicons-admin-users',
        61
    );
}
add_action('admin_menu', 'sil_add_profile_settings_page');

function sil_profile_media_field($name, $label, $value, $button_label) {
    ?>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr($name); ?>"><?php echo esc_html($label); ?></label>
        </th>
        <td>
            <input type="url" class="regular-text" id="<?php echo esc_attr($name); ?>" name="sil_profile_settings[<?php echo esc_attr($name); ?>]" value="<?php echo esc_url($value); ?>">
            <button type="button" class="button sil-media-upload" data-target="<?php echo esc_attr($name); ?>" data-type="image"><?php echo esc_html($button_label); ?></button>
            <?php if ($value) : ?>
                <div style="margin-top:12px;">
                    <img src="<?php echo esc_url($value); ?>" alt="" style="max-width:120px;height:auto;border-radius:12px;border:1px solid #dcdcde;">
                </div>
            <?php endif; ?>
        </td>
    </tr>
    <?php
}

function sil_profile_file_field($name, $label, $value, $button_label) {
    ?>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr($name); ?>"><?php echo esc_html($label); ?></label>
        </th>
        <td>
            <input type="url" class="regular-text" id="<?php echo esc_attr($name); ?>" name="sil_profile_settings[<?php echo esc_attr($name); ?>]" value="<?php echo esc_url($value); ?>">
            <button type="button" class="button sil-media-upload" data-target="<?php echo esc_attr($name); ?>" data-type="file"><?php echo esc_html($button_label); ?></button>
        </td>
    </tr>
    <?php
}

function sil_render_profile_settings_page() {
    $settings = sil_get_profile_settings();
    ?>
    <div class="wrap">
        <h1>Profil Website</h1>
        <p>Kelola identitas website yang dipakai di sidebar, homepage, dan halaman kontak.</p>

        <form method="post" action="options.php">
            <?php settings_fields('sil_profile_settings_group'); ?>

            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="nama">Nama</label></th>
                    <td><input type="text" class="regular-text" id="nama" name="sil_profile_settings[nama]" value="<?php echo esc_attr($settings['nama']); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="jabatan">Jabatan / Profesi</label></th>
                    <td><input type="text" class="regular-text" id="jabatan" name="sil_profile_settings[jabatan]" value="<?php echo esc_attr($settings['jabatan']); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="bio">Bio Singkat</label></th>
                    <td><textarea class="large-text" rows="4" id="bio" name="sil_profile_settings[bio]"><?php echo esc_textarea($settings['bio']); ?></textarea></td>
                </tr>
                <?php sil_profile_media_field('foto', 'Foto Profil', $settings['foto'], 'Pilih Foto'); ?>
                <tr>
                    <th scope="row"><label for="email">Email</label></th>
                    <td><input type="email" class="regular-text" id="email" name="sil_profile_settings[email]" value="<?php echo esc_attr($settings['email']); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="whatsapp">WhatsApp</label></th>
                    <td><input type="text" class="regular-text" id="whatsapp" name="sil_profile_settings[whatsapp]" value="<?php echo esc_attr($settings['whatsapp']); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="github">GitHub</label></th>
                    <td><input type="url" class="regular-text" id="github" name="sil_profile_settings[github]" value="<?php echo esc_attr($settings['github']); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="instagram">Instagram</label></th>
                    <td><input type="url" class="regular-text" id="instagram" name="sil_profile_settings[instagram]" value="<?php echo esc_attr($settings['instagram']); ?>"></td>
                </tr>
                <?php sil_profile_file_field('cv', 'File CV', $settings['cv'], 'Pilih File'); ?>
            </table>

            <?php submit_button('Simpan Profil Website'); ?>
        </form>
    </div>
    <?php
}

function sil_profile_admin_assets($hook) {
    if ('toplevel_page_sil-profile-settings' !== $hook) {
        return;
    }

    wp_enqueue_media();
    $script = <<<'JS'
(function($){
    $(function(){
        $('.sil-media-upload').on('click', function(e){
            e.preventDefault();
            const button = $(this);
            const target = $('#' + button.data('target'));
            const frame = wp.media({
                title: 'Pilih media',
                button: { text: 'Gunakan media ini' },
                multiple: false
            });

            frame.on('select', function(){
                const attachment = frame.state().get('selection').first().toJSON();
                target.val(attachment.url).trigger('change');
            });

            frame.open();
        });
    });
})(jQuery);
JS;
    wp_add_inline_script(
        'jquery-core',
        $script
    );
}
add_action('admin_enqueue_scripts', 'sil_profile_admin_assets');

function sil_cleanup_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'sil_cleanup_admin_menu');
