<?php
/**
 * Template Name: Этот месяц в истории
 * 
 * Показывает события за выбранный месяц по годам
 */

get_header();

// Получаем месяц из URL или используем текущий
$month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
$month = max(1, min(12, $month));

$month_name = russian_month($month);
$month_names = [
    1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 4 => 'Апрель',
    5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
    9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь'
];
?

<div class="content-section">
    
    <header class="page-header">
        <h1><?php echo esc_html("Что писали газеты в {$month_names[$month]}"); ?></h1>
        <p class="archive-description">
            События Олёкминского района, произошедшие в <?php echo esc_html($month_name); ?> разных лет
        </p>
    </header>
    
    <!-- Selector -->
    <div class="month-selector" style="text-align: center; margin: 2rem 0; padding: 1rem; background: #e8dcc8; border-radius: 8px;">
        <form method="get" action="">
            <label for="month">Выберите месяц: </label>
            <select name="month" id="month" onchange="this.form.submit()" style="padding: 8px; font-size: 16px;">
                <?php foreach ($month_names as $num => $name) : ?>
                    <option value="<?php echo $num; ?>" <?php selected($month, $num); ?>>
                        <?php echo esc_html($name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
    
    <?php
    // Get all events for this month, grouped by year
    $events_query = new WP_Query([
        'post_type' => 'event',
        'posts_per_page' => -1,
        'meta_query' => [
            [
                'key' => 'event_date',
                'compare' => 'EXISTS',
            ],
            [
                'key' => 'event_date',
                'value' => '',
                'compare' => '!=',
            ],
        ],
        'orderby' => 'meta_value',
        'meta_key' => 'event_date',
        'order' => 'ASC',
    ]);
    
    // Filter and group by year
    $grouped_events = [];
    if ($events_query->have_posts()) {
        while ($events_query->have_posts()) {
            $events_query->the_post();
            $event_date = function_exists('get_field') ? get_field('event_date') : '';
            
            if ($event_date) {
                $timestamp = strtotime($event_date);
                $event_month = date('n', $timestamp);
                
                if ($event_month == $month) {
                    $year = date('Y', $timestamp);
                    if (!isset($grouped_events[$year])) {
                        $grouped_events[$year] = [];
                    }
                    $grouped_events[$year][] = [
                        'post' => get_post(),
                        'date' => $event_date,
                        'day' => date('j', $timestamp),
                    ];
                }
            }
        }
        wp_reset_postdata();
    }
    
    // Sort by year (descending - newest first)
    krsort($grouped_events);
    ?>
    
    
    <?php if (!empty($grouped_events)) : ?>
        
        <div class="monthly-timeline">
            
            <?php foreach ($grouped_events as $year => $events) : ?>
                
                <section class="year-section" style="margin-bottom: 3rem;">
                    
                    <h2 class="year-heading" style="color: #3d2914; border-bottom: 3px solid #c9a227; padding-bottom: 0.5rem; margin-bottom: 1.5rem;">
                        <?php echo esc_html($year); ?> год
                    </h2>
                    
                    <div class="year-events">
                        
                        <?php foreach ($events as $event_data) : 
                            $post = $event_data['post'];
                            setup_postdata($post);
                        ?>
                            
                            <article class="event-card" style="background: white; padding: 1.5rem; margin-bottom: 1rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                
                                <div class="event-date-badge" style="display: inline-block; background: #c9a227; color: white; padding: 0.25rem 0.75rem; border-radius: 4px; font-weight: bold; margin-bottom: 0.5rem;">
                                    <?php echo esc_html($event_data['day'] . ' ' . $month_name); ?>
                                </div>
                                
                                <h3 style="margin: 0.5rem 0;">
                                    <a href="<?php echo esc_url(get_permalink($post)); ?>" style="color: #3d2914; text-decoration: none;">
                                        <?php echo esc_html(get_the_title($post)); ?>
                                    </a>
                                </h3>
                                
                                <?php 
                                $description = function_exists('get_field') ? get_field('description', $post->ID) : '';
                                if ($description) : 
                                ?>
                                    <p style="color: #5a4a3a; margin: 0.5rem 0;">
                                        <?php echo esc_html(wp_trim_words($description, 30)); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <?php 
                                $place = function_exists('get_field') ? get_field('place', $post->ID) : '';
                                if ($place) : 
                                ?>
                                    <span style="color: #888; font-size: 0.9rem;">📍 <?php echo esc_html($place); ?></span>
                                <?php endif; ?>
                            </article>
                            
                        <?php endforeach; wp_reset_postdata(); ?>
                    </div>
                </section>
                
            <?php endforeach; ?>
        </div>
        
    <?php else : ?>
        
        <div class="no-events" style="text-align: center; padding: 3rem; background: #f5f0e8; border-radius: 8px;">
            
003e
            <p><?php echo esc_html("Событий за {$month_name} пока нет в архиве."); ?></p>
            
            <p><a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>" class="button">Смотреть все события →</a></p>
        </div>
        
    <?php endif; ?>
    
</div>

<?php get_footer(); ?>
