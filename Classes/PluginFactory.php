<?php

namespace WebKinder\GoogleAnalytics;

include_once 'Plugin.php';

final class PluginFactory
{
    
    // Create and return instance of Plugin if it passes all checks
    public static function create()
    {
        if (count(self::environmentChecks()) == 0) {
            static $plugin = null;

            if ($plugin === null) {
                $plugin = new Plugin();
            }

            return $plugin;
        } else {
            add_action('admin_notices', array( __CLASS__, 'DisplayEvironmentErrors' ));
            return null;
        }
    }
    
    // Load all checks
    public static function getEnvironmentChecks()
    {
        return include WK_GOOGLE_ANALYTICS_DIR . '/Config/EnvironmentChecksConfig.php';
    }
    
    // Return failed checks
    public static function environmentChecks()
    {
        $environment_checks = array();
        foreach (self::getEnvironmentChecks() as $check) {
            if ($check['check']) {
                array_push($environment_checks, $check);
            }
        }
        return $environment_checks;
    }
    
    // Display failed checks in backend
    public static function displayEvironmentErrors()
    {
        foreach (self::environmentChecks() as $fail) :
        ?>
          <div class="notice notice-error">
            <p><strong><?php echo $fail['error_message']; ?></strong></p>
          </div>
        <?php
      endforeach;
    }
}
