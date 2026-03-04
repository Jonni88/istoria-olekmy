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
                    $event_date = get_field('event_date');
                    if ($event_date) {
                        echo date('d.m.Y', strtotime($event_date));
                    }
                    ?>
                </span>
                
                <?php if (get_field('year')) : ?>
                    <span class="event-year">📆 <?php the_field('year'); ?></span>
                <?php endif; ?>
                
                <?php if (get_field('place')) : ?>
                    <span class="event-place">📍 <?php the_field('place'); ?></span>
                <?php endif; ?>
            </div>
            
            <h1 class="event-title"><?php the_title(); ?></h1>
            
            <?php
            $topics = get_the_terms(get_the_ID(), 'event_topic');
            if ($topics && !is_wp_error($topics)) : ?>
                <div class="event-topics">
                    <?php foreach ($topics as $topic) : ?>
                        <span class="topic-badge"><?php echo $topic->name; ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </header>
        
        <div class="event-content">
            <?php if (get_field('description')) : ?>
                <div class="event-description">
                    <h3>Описание</h3>
                    <?php echo wpautop(get_field('description')); ?>
                </div>
            <?php endif; ?>
            
            <?php if (get_field('source_quote')) : ?>
                <blockquote class="event-source">
                    <p><?php the_field('source_quote'); ?></p>
                    
                    <?php 
                    $issue = get_field('issue_reference');
                    $page = get_field('page_no');
                    if ($issue) : ?>
                        <cite>
                            Источник: <a href="<?php echo get_permalink($issue); ?>"><?php echo get_the_title($issue); ?></a>
                            <?php if ($page) echo ', стр. ' . $page; ?>
                        </cite>
                    <?php endif; ?>
                </blockquote>
            <?php endif; ?>
        </div>
        
        <footer class="event-footer">
            <?php
            $external_id = get_field('external_id');
            if ($external_id) : ?>
                <div class="event-external-id">
                    Внешний ID: <code><?php echo $external_id; ?></code>
                </div>
            <?php endif; ?>
        </footer>
    </article>
</div>

<?php get_footer(); ?>
