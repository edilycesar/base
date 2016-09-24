<?php
/**
 * Description of Redirect.
 *
 * @author edily
 */
class Redirect
{
    public static function to($url)
    {
        self::toUrl(BASE_URL.$url);
    }

    public static function toUrl($url)
    {
        ?>
        <script> location='<?php echo $url?>'; </script>
        <?php

    }

    public static function toNew($url)
    {
        $url = BASE_URL.$url; ?>
        <script> window.open('<?php echo $url?>'); </script>
        <?php

    }
}
