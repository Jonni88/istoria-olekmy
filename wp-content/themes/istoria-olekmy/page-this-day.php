<?php
/**
 * Template Name: Этот день в истории
 */

get_header(); ?>

<div class="content-section">
    
    <header class="page-header">
        <h1><?php echo esc_html('Этот день в истории Олёкминска'); ?></h1>
        <p class="this-day-date"><?php echo esc_html(date('j ') . russian_month(date('n'))); ?></p>
    </header>
    
    <?php
    // Get events for today
    $today = getdate();
    $day = $today['mday'];
    $month = $today['mon'];
    
    // Build meta query for events with event_date matching today
    $meta_query = [
        'relation' => 'AND',
        [
            'key' => 'event_date',
            'compare' => 'EXISTS',
        ],
        [
            'key' => 'event_date',
            'value' => '',
            'compare' => '!=',
        ],
    ];
    
    $events = new WP_Query([
        'post_type' => 'event',
        'posts_per_page' => 10,
        'meta_query' => $meta_query,
        'orderby' => 'meta_value',
        'meta_key' => 'event_date',
        'order' => 'ASC',
    ]);
    
    // Filter events manually by day/month
    $filtered_events = [];
    if ($events->have_posts()) {
        while ($events->have_posts()) {
            $events->the_post();
            $event_date = get_field('event_date');
            if ($event_date) {
                $event_timestamp = strtotime($event_date);
                if ($event_timestamp) {
                    $event_day = date('j', $event_timestamp);
                    $event_month = date('n', $event_timestamp);
                    if ($event_day == $day && $event_month == $month) {
                        $filtered_events[] = [
                            'post' => get_post(),
                            'year' => date('Y', $event_timestamp),
                        ];
                    }
                }
            }
        }
        wp_reset_postdata();
    }
    ?>
    
    
    <?php if (!empty($filtered_events)) : ?>
        
        <div class="this-day-events">
            
            <?php foreach ($filtered_events as $event_data) : 
                $post = $event_data['post'];
                setup_postdata($post);
            ?>
                
                <article class="this-day-event">
                    <div class="event-year-badge">
                        <?php echo esc_html($event_data['year']); ?>
                    </div>
                    
                    <div class="event-content">
                        <h2><a href="<?php echo esc_url(get_permalink($post)); ?>"><?php echo esc_html(get_the_title($post)); ?></a></h2>
                        
                        <?php 
                        $place = function_exists('get_field') ? get_field('place', $post->ID) : '';
                        if ($place) : 
                        ?>
                            <p class="event-place">📍 <?php echo esc_html($place); ?></p>
                        <?php endif; ?>
                        
                        <?php 
                        $description = function_exists('get_field') ? get_field('description', $post->ID) : '';
                        if ($description) : 
                        ?>
                            <p><?php echo esc_html(wp_trim_words($description, 40)); ?></p>
                        <?php endif; ?>
                    </div>
                </article>
                
            <?php endforeach; wp_reset_postdata(); ?>
        </div>
        
        <?php if (count($filtered_events) >= 10) : ?>
            <div class="show-more">
                <a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>" class="button">
                    Показать все события →
                </a>
            </div>
        <?php endif; ?>
        
    <?php else : ?>
        
        <div class="no-events">
            <p>На сегодняшний день событий в архиве не найдено.</p>
            <p><a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>" class="button">Смотреть все события →</a></p>
        </div>
        
    <?php endif; ?>
    
</div>

<?php get_footer(); ?>
