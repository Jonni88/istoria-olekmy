<?php
/**
 * Archive Place Template
 */

get_header(); ?>

<div class="content-section">
    <header class="archive-header">
        <h1 class="archive-title">Исторические места</h1>
    </header>
    
    <?php if (have_posts()) : ?>
        
        <div class="places-list">
            
            <?php while (have_posts()) : the_post(); ?>
                
                <article class="place-item">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    
                    <?php if (get_field('latitude') && get_field('longitude')) : ?>
                        <p class="place-coords">
                            📍 <?php the_field('latitude'); ?>, <?php the_field('longitude'); ?>
                        </p>
                    <?php endif; ?>
                    
                    <?php if (get_field('description')) : ?>
                        <p><?php echo wp_trim_words(get_field('description'), 30); ?></p>
                    <?php endif; ?>
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
        
        <p>Мест пока нет.</p>
        
    <?php endif; ?>
    
</div>

<?php get_footer(); ?>
