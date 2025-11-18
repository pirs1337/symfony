<?php

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use \Symfony\Component\Filesystem\Filesystem;

require dirname(__DIR__).'/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

if (!isset($_SERVER['APP_ENV'])) {
    $_SERVER['APP_ENV'] = 'test';
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

(new Filesystem())->remove(__DIR__.'/../var/cache/test');

if ($_SERVER['APP_ENV'] === 'test') {
    $kernel = new App\Kernel($_SERVER['APP_ENV'], true);
    $kernel->boot();

    $application = new Application($kernel);
    $application->setAutoExit(false);

    $inputCreate = new ArrayInput([
        'command' => 'doctrine:database:create',
        '--env' => 'test',
        '--if-not-exists' => true,
    ]);

    $application->run($inputCreate);

    $inputMigrate = new ArrayInput([
        'command' => 'doctrine:migrations:migrate',
        '--env' => 'test',
        '--no-interaction' => true,
    ]);

    $application->run($inputMigrate);

    $inputFixtures = new ArrayInput([
        'command' => 'doctrine:fixtures:load',
        '--env' => 'test',
        '--no-interaction' => true,
    ]);

    $application->run($inputFixtures);

    $kernel->shutdown();
}
