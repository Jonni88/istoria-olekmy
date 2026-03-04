<?php
/**
 * Archive Photo Template
 */

get_header(); ?>

<div class="content-section">
    <header class="archive-header">
        <h1 class="archive-title">Фотоархив</h1>
    </header>
    
    <?php if (have_posts()) : ?>
        
        <div class="cards-grid">
            
            <?php while (have_posts()) : the_post(); ?>
                
                <article class="card">
                    <?php if (has_post_thumbnail()) : ?
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', ['class' => 'card-image']); ?>
                        </a>
                    <?php endif; ?>
                    
                    <div class="card-content">
                        <div class="card-meta">
                            <?php if (get_field('year')) : ?>
                                <span class="photo-year">📆 <?php the_field('year'); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <h2 class="card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
                        <?php if (get_field('photo_source')) : ?>
                            <p class="card-source">Источник: <?php the_field('photo_source'); ?></p>
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
        
        <p>Фотографий пока нет.</p>
        
    <?php endif; ?>
    
</div>

<?php get_footer(); ?>
