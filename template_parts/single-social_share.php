<div class="social_holder">
    <ul>
        <li><a class="facebook" onclick="socialshare('facebook', '<?php the_permalink(); ?>', '<?php the_title(); ?>');">Compartir</a></li>
        
        <?php
        if(wp_is_mobile()): ?>
            <li><a class="whatsapp" onclick="socialshare('whatsapp', '<?php the_permalink(); ?>', '<?php the_title(); ?>');">Whatsapp</a></li>
        <?php
        endif; ?>
    </ul>
</div>