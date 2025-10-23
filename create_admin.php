<?php

require_once 'vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

$application = new Application();
$application->add(new \Sylius\Bundle\CoreBundle\Command\CreateAdminUserCommand());

$input = new ArrayInput([
    'command' => 'sylius:admin-user:create',
    '--email' => 'admin@waveshop.com',
    '--username' => 'admin',
    '--password' => 'admin123',
    '--first-name' => 'Admin',
    '--last-name' => 'User'
]);

$output = new ConsoleOutput();
$application->run($input, $output);

