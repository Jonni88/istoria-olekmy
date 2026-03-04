<?php
/**
 * Archive Event Template
 */

get_header(); ?>

<div class="content-section">
    <header class="archive-header">
        <h1 class="archive-title"><?php post_type_archive_title(); ?></h1>
    </header>
    
    <?php if (have_posts()) : ?>
        
        <div class="cards-grid">
            <?php while (have_posts()) : the_post(); ?>
                
                <article class="card">
                    <div class="card-content">
                        <div class="card-meta">
                            <?php 
                            $event_date = get_field('event_date');
                            if ($event_date) : ?
003e
                                <span class="event-date">📅 <?php echo date('d.m.Y', strtotime($event_date)); ?></span>
                            <?php endif; ?>
                            
                            <?php if (get_field('year')) : ?>
                                <span class="event-year">📆 <?php the_field('year'); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <h2 class="card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
                        <?php if (get_field('place')) : ?>
                            <p class="card-place">📍 <?php the_field('place'); ?></p>
                        <?php endif; ?>
                        
                        <?php if (get_field('description')) : ?>
                            <p class="card-excerpt"><?php echo wp_trim_words(get_field('description'), 20); ?></p>
                        <?php endif; ?>
                    </div>
                </article>
                
            <?php endwhile; ?>
        </div>
        
        <div class="pagination">
            <?php 
            echo paginate_links([
                'prev_text' => '← Назад',
                'next_text' => 'Вперёд →',
            ]);
            ?>
        </div>
        
    <?php else : ?>
        
        <p>Событий пока нет.</p>
        
    <?php endif; ?>
    
</div>

<?php get_footer(); ?>
