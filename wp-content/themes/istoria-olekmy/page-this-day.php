<?php
/**
 * Template Name: Этот день в истории
 */

get_header(); ?>

<div class="content-section">
    
    <header class="page-header">
        <h1>Этот день в истории Олёкминска</h1>
        <p class="this-day-date"><?php echo date('j ') . russian_month(date('n')); ?></p>
    </header>
    
    <?php
    // Get events for today
    $today = getdate();
    $day = $today['mday'];
    $month = $today['mon'];
    
    $events = new WP_Query([
        'post_type' => 'event',
        'posts_per_page' => -1,
        'meta_query' => [
            [
                'key' => 'event_date',
                'value' => ['[0-9]{4}-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day)],
                'compare' => 'REGEXP',
            ],
        ],
        'orderby' => 'meta_value',
        'meta_key' => 'event_date',
        'order' => 'ASC',
    ]);
    ?>
    
    
    <?php if ($events->have_posts()) : ?>
        
        <div class="this-day-events">
            
            <?php while ($events->have_posts()) : $events->the_post(); ?>
                
                <article class="this-day-event">
                    <div class="event-year-badge">
                        <?php 
                        $event_date = get_field('event_date');
                        echo $event_date ? date('Y', strtotime($event_date)) : get_field('year');
                        ?>
                    </div>
                    
                    <div class="event-content">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        
                        <?php if (get_field('place')) : ?>
                            <p class="event-place">📍 <?php the_field('place'); ?></p>
                        <?php endif; ?>
                        
                        <?php if (get_field('description')) : ?>
                            <p><?php echo wp_trim_words(get_field('description'), 40); ?></p>
                        <?php endif; ?>
                    </div>
                </article>
                
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        
    <?php else : ?>
        
        <div class="no-events">
            <p>На сегодняшний день событий в архиве не найдено.</p>
            <p><a href="/sobytiya/" class="button">Смотреть все события →</a></p>
        </div>
        
    <?php endif; ?
003e
    
</div>

<?php get_footer(); ?>
