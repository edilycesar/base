<?php
namespace Edily\Base;

/**
 * Description of Redirect
 *
 * @author edily
 */
class Redirect
{
    public static function to($url)
    {
        Redirect::toUrl($url);
    }
    
    public static function toUrl($url)
    {
        ?>
        <script> location='<?php echo $url?>'; </script>
        <?php

    }
    
    public static function toNew($url)
    {
        ?>
        <script> window.open('<?php echo $url?>'); </script>
        <?php
    }
}