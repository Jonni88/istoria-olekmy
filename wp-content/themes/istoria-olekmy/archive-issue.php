<?php
/**
 * Archive Issue Template
 */

get_header(); ?>

<div class="content-section">
    <header class="archive-header">
        <h1 class="archive-title">Архив газет</h1>
    </header>
    
    <?php if (have_posts()) : ?>
        
        <div class="cards-grid">
            
            <?php 
            // Group by year
            $current_year = '';
            while (have_posts()) : the_post(); 
                $issue_date = get_field('issue_date');
                $year = $issue_date ? date('Y', strtotime($issue_date)) : 'Без даты';
                
                if ($year !== $current_year) : 
                    $current_year = $year;
            ?>
                    </h2 class="year-heading"><?php echo $year; ?> год</h2>
            
            <?php endif; ?>
                
                <article class="card">
                    <?php if (has_post_thumbnail()) : ?
                        <?php the_post_thumbnail('medium', ['class' => 'card-image']); ?>
                    <?php endif; ?>
                    
                    <div class="card-content">
                        <div class="card-meta">
                            <?php if ($issue_date) : ?>
                                <span class="issue-date">📅 <?php echo date('d.m.Y', strtotime($issue_date)); ?></span>
                            <?php endif; ?>
                            
                            <?php if (get_field('issue_number')) : ?>
                                <span class="issue-number">№ <?php the_field('issue_number'); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <h2 class="card-title"><?php the_title(); ?></h2>
                        
                        <?php $pdf = get_field('pdf_file'); ?>
                        <?php if ($pdf) : ?>
                            <a href="<?php echo esc_url($pdf); ?>" class="button" target="_blank">📄 Открыть PDF</a>
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
        
        <p>Выпусков пока нет.</p>
        
    <?php endif; ?>
    
</div>

<?php get_footer(); ?>
