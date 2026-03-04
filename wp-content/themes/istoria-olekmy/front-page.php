<?php
/**
 * Template Name: Главная страница
 */

get_header(); ?>

<!-- Hero Section -->
<?php
$hero_image = get_template_directory() . '/assets/images/hero-bg.jpg';
$hero_style = file_exists($hero_image) 
    ? 'background-image: url(' . get_template_directory_uri() . '/assets/images/hero-bg.jpg);' 
    : 'background-color: #3d2914;';
?>
<section class="hero-section" style="<?php echo esc_attr($hero_style); ?>">
    <div class="hero-content">
        <h1><?php echo esc_html('История Олёкминского района'); ?></h1>
        <p><?php echo esc_html('Цифровой архив событий, фотографий и воспоминаний. Сохраняем историю для будущих поколений.'); ?></p>
    </div>
</section>

<!-- This Day Section -->
<section class="content-section">
    <div class="this-day-section">
        <div class="this-day-title">
            <span class="icon">📅</span>
            <h2><?php echo esc_html('Сегодня в истории: ' . date('j ') . russian_month(date('n'))); ?></h2>
        </div>
        <div id="this-day-events" class="this-day-list">
            <p><?php echo esc_html('Загрузка событий...'); ?></p>
        </div>
        <div class="text-center" style="margin-top: 1rem;">
            <a href="<?php echo esc_url(home_url('/this-day')); ?>" class="button">Все события дня →</a>
        </div>
    </div>
</section>

<!-- Photo Archive Preview -->
<section class="content-section">
    <h2 class="section-title"><?php echo esc_html('Фото прошлых лет'); ?></h2>
    
    <?php
    $random_photo = new WP_Query([
        'post_type' => 'photo',
        'posts_per_page' => 1,
        'orderby' => 'rand',
    ]);
    
    if ($random_photo->have_posts()) : 
        while ($random_photo->have_posts()) : $random_photo->the_post();
    ?>
        <div class="photo-featured">
            <?php if (has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('large', ['style' => 'max-width: 100%; height: auto; border-radius: 8px;']); ?>
                </a>
            <?php endif; ?>
            
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            
            <?php 
            $year = function_exists('get_field') ? get_field('year') : '';
            if ($year) : 
            ?>
                <p>📆 <?php echo esc_html($year); ?></p>
            <?php endif; ?>
        </div>
        
    <?php 
        endwhile;
        wp_reset_postdata();
    else : 
    ?>
        <p><?php echo esc_html('Фотографии скоро появятся.'); ?></p>
        
    <?php endif; ?>
    
    <div class="text-center">
        <a href="<?php echo esc_url(get_post_type_archive_link('photo')); ?>" class="button"><?php echo esc_html('Все фотографии →'); ?></a>
    </div>
</section>

<!-- Newspaper Archive -->
<section class="content-section">
    <h2 class="section-title"><?php echo esc_html('Архив газет'); ?></h2>
    
    <?php
    $latest_issues = new WP_Query([
        'post_type' => 'issue',
        'posts_per_page' => 6,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);
    
    if ($latest_issues->have_posts()) : 
    ?>
        <div class="cards-grid">
            
            <?php while ($latest_issues->have_posts()) : $latest_issues->the_post(); ?>
                
                <article class="card">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium', ['class' => 'card-image']); ?>
                    <?php endif; ?>
                    
                    <div class="card-content">
                        <div class="card-meta">
                            <?php 
                            $issue_date = function_exists('get_field') ? get_field('issue_date') : '';
                            if ($issue_date) : 
                            ?>
                                <span>📅 <?php echo esc_html(date('d.m.Y', strtotime($issue_date))); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        
                        <?php 
                        $pdf = function_exists('get_field') ? get_field('pdf_file') : '';
                        if ($pdf) : 
                        ?>
                            <a href="<?php echo esc_url($pdf); ?>" class="button" target="_blank">📄 PDF</a>
                        <?php endif; ?>
                    </div>
                </article>
                
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        
    <?php else : ?>
        <p><?php echo esc_html('Выпуски газет скоро появятся.'); ?></p>
        
    <?php endif; ?>
    
    <div class="text-center" style="margin-top: 2rem;">
        <a href="<?php echo esc_url(get_post_type_archive_link('issue')); ?>" class="button"><?php echo esc_html('Весь архив газет →'); ?></a>
    </div>
</section>

<!-- Search Section -->
<section class="content-section">
    <div class="search-section" style="text-align: center; padding: 3rem 2rem; background: #e8dcc8; border-radius: 8px;">
        
        <h2><?php echo esc_html('Поиск по архиву'); ?></h2>
        
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <input 
                type="search" 
                name="s" 
                placeholder="<?php echo esc_attr('Введите запрос...'); ?>" 
                style="padding: 12px; width: 300px; max-width: 100%; border: 1px solid #3d2914; border-radius: 4px; font-size: 16px;"
            >
            <button type="submit" class="button" style="margin-left: 10px; padding: 12px 24px;"><?php echo esc_html('Поиск'); ?></button>
        </form>
    </div>
</section>

<?php get_footer(); ?>
