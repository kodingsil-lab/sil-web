<?php
/**
 * Plugin Name: SIL Core
 * Description: Core functionality untuk portfolio website.
 * Version: 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

function sil_core_register_portfolio_cpt() {
    $labels = [
        'name'               => 'Portfolio',
        'singular_name'      => 'Portfolio',
        'menu_name'          => 'Portfolio',
        'name_admin_bar'     => 'Portfolio',
        'add_new'            => 'Tambah Baru',
        'add_new_item'       => 'Tambah Portfolio Baru',
        'new_item'           => 'Portfolio Baru',
        'edit_item'          => 'Edit Portfolio',
        'view_item'          => 'Lihat Portfolio',
        'all_items'          => 'Semua Portfolio',
        'search_items'       => 'Cari Portfolio',
        'not_found'          => 'Portfolio tidak ditemukan',
        'not_found_in_trash' => 'Portfolio tidak ditemukan di sampah',
    ];

    $args = [
        'labels'       => $labels,
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-portfolio',
        'rewrite'      => ['slug' => 'portfolio'],
        'show_in_rest' => true,
        'supports'     => ['title', 'editor', 'thumbnail', 'excerpt'],
    ];

    register_post_type('portfolio', $args);
}
add_action('init', 'sil_core_register_portfolio_cpt');

function sil_core_register_portfolio_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key' => 'group_sil_portfolio',
        'title' => 'Detail Portfolio',
        'fields' => [
            [
                'key' => 'field_sil_client',
                'label' => 'Client / Instansi',
                'name' => 'client',
                'type' => 'text',
            ],
            [
                'key' => 'field_sil_teknologi',
                'label' => 'Teknologi',
                'name' => 'teknologi',
                'type' => 'text',
                'instructions' => 'Contoh: WordPress, Tailwind CSS, Alpine.js',
            ],
            [
                'key' => 'field_sil_demo_url',
                'label' => 'Link Demo',
                'name' => 'demo_url',
                'type' => 'url',
            ],
            [
                'key' => 'field_sil_github_url',
                'label' => 'Link GitHub',
                'name' => 'github_url',
                'type' => 'url',
            ],
            [
                'key' => 'field_sil_tahun',
                'label' => 'Tahun',
                'name' => 'tahun',
                'type' => 'text',
            ],
            [
                'key' => 'field_sil_highlight',
                'label' => 'Highlight Singkat',
                'name' => 'highlight',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_sil_urutan',
                'label' => 'Urutan Tampil',
                'name' => 'urutan',
                'type' => 'number',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'portfolio',
                ],
            ],
        ],
        'position' => 'normal',
        'style' => 'default',
        'active' => true,
    ]);
}
add_action('acf/init', 'sil_core_register_portfolio_acf_fields');

function sil_core_portfolio_thumbnail_support() {
    add_post_type_support('portfolio', 'thumbnail');
}
add_action('init', 'sil_core_portfolio_thumbnail_support');

function sil_core_activate() {
    sil_core_register_portfolio_cpt();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'sil_core_activate');

function sil_core_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'sil_core_deactivate');
