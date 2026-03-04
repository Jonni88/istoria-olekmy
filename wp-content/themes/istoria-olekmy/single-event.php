<?php
/**
 * Single Event Template
 */

get_header(); ?>

<div class="content-section">
    <article class="event-single">
        
        <header class="event-header">
            
            <div class="event-meta-top">
                <span class="event-date">
                    📅 <?php 
                    if (function_exists('get_field')) {
                        $event_date = get_field('event_date');
                        if ($event_date) {
                            echo esc_html(date('d.m.Y', strtotime($event_date)));
                        }
                    }
                    ?>
                </span>
                
                <?php if (function_exists('get_field') && get_field('year')) : ?>
                    <span class="event-year">📆 <?php echo esc_html(get_field('year')); ?></span>
                <?php endif; ?>
                
                <?php if (function_exists('get_field') && get_field('place')) : ?>
                    <span class="event-place">📍 <?php echo esc_html(get_field('place')); ?></span>
                <?php endif; ?>
            </div>
            
            <h1 class="event-title"><?php echo esc_html(get_the_title()); ?></h1>
            
            <?php
            $topics = get_the_terms(get_the_ID(), 'event_topic');
            if ($topics && !is_wp_error($topics)) : 
            ?>
                <div class="event-topics">
                    <?php foreach ($topics as $topic) : ?>
                        <span class="topic-badge"><?php echo esc_html($topic->name); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </header>
        
        
        <div class="event-content">
            
            <?php if (function_exists('get_field') && get_field('description')) : ?>
                <div class="event-description">
                    <h3><?php echo esc_html('Описание'); ?></h3>
                    <?php echo wp_kses_post(wpautop(get_field('description'))); ?>
                </div>
            <?php endif; ?>
            
            
            <?php if (function_exists('get_field') && get_field('source_quote')) : ?>
                <blockquote class="event-source">
                    <p><?php echo esc_html(get_field('source_quote')); ?></p>
                    
                    <?php 
                    $issue = get_field('issue_reference');
                    $page = get_field('page_no');
                    if ($issue) : 
                    ?>
                        <cite>
                            <?php echo esc_html('Источник: '); ?>
                            <a href="<?php echo esc_url(get_permalink($issue)); ?>">
                                <?php echo esc_html(get_the_title($issue)); ?>
                            </a>
                            <?php if ($page) echo esc_html(', стр. ' . $page); ?>
                        </cite>
                    <?php endif; ?>
                </blockquote>
            <?php endif; ?>
            
            
            <?php if (function_exists('get_field') && get_field('external_id')) : ?>
                <div class="event-external-id">
                    <?php echo esc_html('Внешний ID: '); ?>
                    <code><?php echo esc_html(get_field('external_id')); ?></code>
                </div>
            <?php endif; ?>
        </div>
    </article>
</div>

<?php get_footer(); ?>
