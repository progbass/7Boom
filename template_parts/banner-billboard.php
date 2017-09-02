
<?php
if( !wp_is_mobile() ){ ?>
<div class="ad_container full_width">
    <div class="ad_unit billboard">
        
        <?php
        if( is_home() ): ?>
            <!-- /94465771/7boom_Billboard_all -->
            <div id='div-gpt-ad-1503949356736-0'>
                <script>
                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1503949356736-0'); });
                </script>
            </div>   
        <?php
        endif; ?>
    
    
       
        <?php
        switch($category->slug){
        case '9am-6pm': ?>
            <!-- /94465771/7boom_Billboard_9am -->
            <div id='div-gpt-ad-1503949678961-0'>
                <script>
                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1503949678961-0'); });
                </script>
            </div>
            <?php
            break;

        case '6pm-8pm': ?>
            <!-- /94465771/7boom_Billboard_6pm -->
            <div id='div-gpt-ad-1503949716909-0'>
                <script>
                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1503949716909-0'); });
                </script>
            </div>
            <?php
            break;

        case '8pm-finde': ?>
            <!-- /94465771/7boom_Billboard_8pm -->
            <div id='div-gpt-ad-1503949802451-0'>
                <script>
                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1503949802451-0'); });
                </script>
            </div>
            <?php
            break;
        } ?>
    </div>
</div>
<?php
} ?>