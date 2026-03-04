<?php
/**
 * Plugin Name: История Олёкмы - Core
 * Description: Custom Post Types, ACF fields и функционал для сайта-архива
 * Version: 1.0.0
 * Author: Agent Jon
 */

// Prevent direct access
if (!defined('ABSPATH')) exit;

class Olekmy_Core {
    
    public function __construct() {
        add_action('init', [$this, 'register_post_types']);
        add_action('init', [$this, 'register_taxonomies']);
        add_action('acf/init', [$this, 'register_acf_fields']);
    }
    
    /**
     * Register Custom Post Types
     */
    public function register_post_types() {
        
        // Events (События)
        register_post_type('event', [
            'labels' => [
                'name' => 'События',
                'singular_name' => 'Событие',
                'add_new' => 'Добавить событие',
                'add_new_item' => 'Добавить новое событие',
                'edit_item' => 'Редактировать событие',
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'sobytiya'],
            'supports' => ['title', 'editor', 'thumbnail'],
            'menu_icon' => 'dashicons-calendar-alt',
            'show_in_rest' => true,
        ]);
        
        // Issues (Выпуски газет)
        register_post_type('issue', [
            'labels' => [
                'name' => 'Выпуски газет',
                'singular_name' => 'Выпуск',
                'add_new' => 'Добавить выпуск',
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'gazety'],
            'supports' => ['title', 'thumbnail'],
            'menu_icon' => 'dashicons-media-document',
            'show_in_rest' => true,
        ]);
        
        // Photos (Фотографии)
        register_post_type('photo', [
            'labels' => [
                'name' => 'Фотографии',
                'singular_name' => 'Фотография',
                'add_new' => 'Добавить фото',
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'foto'],
            'supports' => ['title', 'editor', 'thumbnail'],
            'menu_icon' => 'dashicons-format-image',
            'show_in_rest' => true,
        ]);
        
        // Places (Места)
        register_post_type('place', [
            'labels' => [
                'name' => 'Места',
                'singular_name' => 'Место',
                'add_new' => 'Добавить место',
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'mesta'],
            'supports' => ['title', 'editor', 'thumbnail'],
            'menu_icon' => 'dashicons-location-alt',
            'show_in_rest' => true,
        ]);
        
        // Exhibits (Экспонаты)
        register_post_type('exhibit', [
            'labels' => [
                'name' => 'Экспонаты',
                'singular_name' => 'Экспонат',
                'add_new' => 'Добавить экспонат',
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'ekskursiya'],
            'supports' => ['title', 'editor', 'thumbnail'],
            'menu_icon' => 'dashicons-art',
            'show_in_rest' => true,
        ]);
    }
    
    /**
     * Register Taxonomies
     */
    public function register_taxonomies() {
        
        // Event Topics
        register_taxonomy('event_topic', 'event', [
            'labels' => [
                'name' => 'Темы событий',
                'singular_name' => 'Тема',
            ],
            'hierarchical' => true,
            'public' => true,
            'rewrite' => ['slug' => 'tema-sobytiya'],
            'show_in_rest' => true,
        ]);
        
        // Photo Albums
        register_taxonomy('photo_album', 'photo', [
            'labels' => [
                'name' => 'Альбомы',
                'singular_name' => 'Альбом',
            ],
            'hierarchical' => true,
            'public' => true,
            'rewrite' => ['slug' => 'albom'],
            'show_in_rest' => true,
        ]);
        
        // Photo Topics
        register_taxonomy('photo_topic', 'photo', [
            'labels' => [
                'name' => 'Темы фото',
                'singular_name' => 'Тема',
            ],
            'hierarchical' => false,
            'public' => true,
            'rewrite' => ['slug' => 'tema-foto'],
            'show_in_rest' => true,
        ]);
    }
    
    /**
     * Register ACF Fields
     */
    public function register_acf_fields() {
        
        if (!function_exists('acf_add_local_field_group')) return;
        
        // Event Fields
        acf_add_local_field_group([
            'key' => 'group_event_fields',
            'title' => 'Данные события',
            'fields' => [
                [
                    'key' => 'field_event_date',
                    'label' => 'Дата события',
                    'name' => 'event_date',
                    'type' => 'date_picker',
                    'display_format' => 'd.m.Y',
                    'return_format' => 'Y-m-d',
                    'required' => 1,
                ],
                [
                    'key' => 'field_event_year',
                    'label' => 'Год (текстом)',
                    'name' => 'year',
                    'type' => 'text',
                    'instructions' => 'Например: 1985 или 1980-е',
                ],
                [
                    'key' => 'field_event_place',
                    'label' => 'Место',
                    'name' => 'place',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_event_description',
                    'label' => 'Описание',
                    'name' => 'description',
                    'type' => 'textarea',
                    'rows' => 4,
                ],
                [
                    'key' => 'field_event_source',
                    'label' => 'Цитата из источника',
                    'name' => 'source_quote',
                    'type' => 'textarea',
                    'rows' => 3,
                ],
                [
                    'key' => 'field_event_page',
                    'label' => 'Номер страницы',
                    'name' => 'page_no',
                    'type' => 'number',
                ],
                [
                    'key' => 'field_event_external_id',
                    'label' => 'Внешний ID',
                    'name' => 'external_id',
                    'type' => 'text',
                    'instructions' => 'Для импорта/синхронизации',
                ],
                [
                    'key' => 'field_event_issue',
                    'label' => 'Связанный выпуск',
                    'name' => 'issue_reference',
                    'type' => 'post_object',
                    'post_type' => ['issue'],
                    'return_format' => 'id',
                ],
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'event',
                    ],
                ],
            ],
        ]);
        
        // Issue Fields
        acf_add_local_field_group([
            'key' => 'group_issue_fields',
            'title' => 'Данные выпуска',
            'fields' => [
                [
                    'key' => 'field_issue_date',
                    'label' => 'Дата выпуска',
                    'name' => 'issue_date',
                    'type' => 'date_picker',
                    'display_format' => 'd.m.Y',
                    'return_format' => 'Y-m-d',
                ],
                [
                    'key' => 'field_issue_number',
                    'label' => 'Номер выпуска',
                    'name' => 'issue_number',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_issue_pdf',
                    'label' => 'PDF файл',
                    'name' => 'pdf_file',
                    'type' => 'file',
                    'return_format' => 'url',
                    'mime_types' => 'pdf',
                ],
                [
                    'key' => 'field_issue_external_id',
                    'label' => 'Внешний ID',
                    'name' => 'external_id',
                    'type' => 'text',
                ],
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'issue',
                    ],
                ],
            ],
        ]);
        
        // Photo Fields
        acf_add_local_field_group([
            'key' => 'group_photo_fields',
            'title' => 'Данные фотографии',
            'fields' => [
                [
                    'key' => 'field_photo_year',
                    'label' => 'Год',
                    'name' => 'year',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_photo_source',
                    'label' => 'Источник',
                    'name' => 'photo_source',
                    'type' => 'text',
                    'instructions' => 'От кого получена фотография',
                ],
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'photo',
                    ],
                ],
            ],
        ]);
        
        // Place Fields
        acf_add_local_field_group([
            'key' => 'group_place_fields',
            'title' => 'Координаты места',
            'fields' => [
                [
                    'key' => 'field_place_lat',
                    'label' => 'Широта',
                    'name' => 'latitude',
                    'type' => 'number',
                    'step' => 0.000001,
                ],
                [
                    'key' => 'field_place_lng',
                    'label' => 'Долгота',
                    'name' => 'longitude',
                    'type' => 'number',
                    'step' => 0.000001,
                ],
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'place',
                    ],
                ],
            ],
        ]);
    }
}

// Initialize
new Olekmy_Core();

/**
 * REST API Endpoints
 */
add_action('rest_api_init', function() {
    
    // Get events by day/month
    register_rest_route('olekmy/v1', '/events/this-day/(?P<day>\d+)/(?P<month>\d+)', [
        'methods' => 'GET',
        'callback' => 'olekmy_get_events_this_day',
        'permission_callback' => '__return_true',
    ]);
    
    // Get random photo
    register_rest_route('olekmy/v1', '/photos/random', [
        'methods' => 'GET',
        'callback' => 'olekmy_get_random_photo',
        'permission_callback' => '__return_true',
    ]);
    
    // Get latest issues
    register_rest_route('olekmy/v1', '/issues/latest', [
        'methods' => 'GET',
        'callback' => 'olekmy_get_latest_issues',
        'permission_callback' => '__return_true',
    ]);
    
    // Get random exhibit
    register_rest_route('olekmy/v1', '/exhibits/random', [
        'methods' => 'GET',
        'callback' => 'olekmy_get_random_exhibit',
        'permission_callback' => '__return_true',
    ]);
});

function olekmy_get_events_this_day($request) {
    $day = $request['day'];
    $month = $request['month'];
    
    $events = get_posts([
        'post_type' => 'event',
        'posts_per_page' => 10,
        'meta_query' => [
            [
                'key' => 'event_date',
                'value' => ['^[0-9]{4}-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day)],
                'compare' => 'REGEXP',
            ],
        ],
        'orderby' => 'meta_value',
        'meta_key' => 'event_date',
        'order' => 'ASC',
    ]);
    
    $data = [];
    foreach ($events as $event) {
        $data[] = [
            'id' => $event->ID,
            'title' => $event->post_title,
            'date' => get_field('event_date', $event->ID),
            'year' => get_field('year', $event->ID),
            'place' => get_field('place', $event->ID),
            'description' => get_field('description', $event->ID),
            'link' => get_permalink($event->ID),
        ];
    }
    
    return $data;
}

function olekmy_get_random_photo() {
    $photos = get_posts([
        'post_type' => 'photo',
        'posts_per_page' => 1,
        'orderby' => 'rand',
    ]);
    
    if (empty($photos)) return null;
    
    $photo = $photos[0];
    return [
        'id' => $photo->ID,
        'title' => $photo->post_title,
        'image' => get_the_post_thumbnail_url($photo->ID, 'large'),
        'year' => get_field('year', $photo->ID),
        'link' => get_permalink($photo->ID),
    ];
}

function olekmy_get_latest_issues() {
    $issues = get_posts([
        'post_type' => 'issue',
        'posts_per_page' => 5,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);
    
    $data = [];
    foreach ($issues as $issue) {
        $data[] = [
            'id' => $issue->ID,
            'title' => $issue->post_title,
            'date' => get_field('issue_date', $issue->ID),
            'number' => get_field('issue_number', $issue->ID),
            'pdf' => get_field('pdf_file', $issue->ID),
            'link' => get_permalink($issue->ID),
        ];
    }
    
    return $data;
}

function olekmy_get_random_exhibit() {
    $exhibits = get_posts([
        'post_type' => 'exhibit',
        'posts_per_page' => 1,
        'orderby' => 'rand',
    ]);
    
    if (empty($exhibits)) return null;
    
    $exhibit = $exhibits[0];
    return [
        'id' => $exhibit->ID,
        'title' => $exhibit->post_title,
        'image' => get_the_post_thumbnail_url($exhibit->ID, 'large'),
        'link' => get_permalink($exhibit->ID),
    ];
}
