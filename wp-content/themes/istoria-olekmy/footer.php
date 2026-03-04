<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-content">
            <div class="footer-section">
                <h4><?php bloginfo('name'); ?></h4>
                <p>Цифровой архив истории Олёкминского района.</p>
            </div>
            
            <div class="footer-section">
                <h4>Разделы</h4>
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'container' => false,
                    'menu_class' => 'footer-menu',
                ]);
                ?>
            </div>
            
            <div class="footer-section">
                <h4>Контакты</h4>
                <p>Есть материалы для архива?</p>
                <a href="/dobavit-material">Добавить материал →</a>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>© <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Все права защищены.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
