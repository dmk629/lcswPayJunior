<?php declare(strict_types=1);


namespace App;


use Swoft\SwoftApplication;

/**
 * Class Application
 *
 * @since 2.0
 */
class Application extends SwoftApplication
{
    public function getCLoggerConfig(): array
    {
        $config = parent::getCLoggerConfig();
        // disable print console start log
        $config['enable'] = false;

        return $config;
    }
}
