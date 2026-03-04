<?php
/**
 * Template Name: Главная страница
 */

get_header(); ?>

<!-- Hero Section -->
<section class="hero-section" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/hero-bg.jpg');">
    <div class="hero-content">
        <h1>История Олёкминского района</h1>
        <p>Цифровой архив событий, фотографий и воспоминаний. Сохраняем историю для будущих поколений.</p>
    </div>
</section>

<!-- This Day Section -->
<section class="content-section">
    <div class="this-day-section">
        <div class="this-day-title">
            <span class="icon">📅</span>
            <h2>Сегодня в истории: <?php echo date('j ') . russian_month(date('n')); ?></h2>
        </div>
        <div id="this-day-events" class="this-day-list">
            <p>Загрузка событий...</p>
        </div>
    </div>
</section>

<!-- Photo Archive Preview -->
<section class="content-section">
    <h2 class="section-title">Фото прошлых лет</h2>
    <div id="random-photo" class="photo-featured">
        <!-- Photo loaded via JS -->
    </div>
    
    <div class="text-center">
        <a href="/foto" class="button">Все фотографии →</a>
    </div>
</section>

<!-- Newspaper Archive -->
<section class="content-section">
    <h2 class="section-title">Архив газет</h2>
    <div id="latest-issues" class="cards-grid">
        <!-- Issues loaded via JS -->
    </div>
</section>

<!-- Random Exhibit -->
<section class="content-section">
    <h2 class="section-title">Случайный экспонат</h2>
    <div id="random-exhibit" class="exhibit-featured">
        <!-- Exhibit loaded via JS -->
    </div>
</section>

<!-- Latest Additions -->
<section class="content-section">
    <h2 class="section-title">Последние добавления</h2>
    
    <div class="latest-grid">
        <?php
        $latest = new WP_Query([
            'post_type' => ['event', 'photo', 'issue'],
            'posts_per_page' => 6,
        ]);
        
        while ($latest->have_posts()) : $latest->the_post();
        ?>
            <article class="card">
                <?php if (has_post_thumbnail()) : ?
                    <?php the_post_thumbnail('medium', ['class' => 'card-image']); ?>
                <?php endif; ?>
                
                <div class="card-content">
                    <div class="card-meta"><?php echo get_post_type_object(get_post_type())->label; ?></div>
                    <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date(); ?></time>
                </div>
            </article>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
</section>

<!-- Search Section -->
<section class="content-section">
    <div class="search-section" style="text-align: center; padding: var(--spacing-lg); background: var(--color-beige); border-radius: 8px;">
        <h2>Поиск по архиву</h2>
        
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="search" name="s" placeholder="Введите запрос..." style="padding: 12px; width: 300px; max-width: 100%; border: 1px solid var(--color-brown); border-radius: 4px;">
            <button type="submit" class="button" style="margin-left: 10px;">Поиск</button>
        </form>
    </div>
</section>

<?php get_footer(); ?>
