<?php
require_once __DIR__.'/../vendor/autoload.php';

use Whatsapp\Command\Confirm;
use Whatsapp\Command\Register;
use Whatsapp\Command\SendMessage;
use Whatsapp\Command\GetMessage;
use Symfony\Component\Console\Application;

$dotenv = new Dotenv\Dotenv(__DIR__."/..");
$dotenv->load();

$registerCommand = new Register();

$application = new Application();
$application->add(new Confirm());
$application->add($registerCommand);
$application->add(new SendMessage());
$application->add(new GetMessage());
$application->run();
