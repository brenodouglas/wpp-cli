<?php
namespace Whatsapp\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

use Whatsapp\Events\CustomEvent;


class GetMessage extends Command
{

	protected function configure()
    {
        $this
            ->setName('whatsapp:messages:get')
            ->setDescription('Verificar e receber mensagens');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = getenv('USERNAME');
        $nickname = getenv('NICKNAME');
        $password = getenv('PASSWORD');
        $debug = false;

        // Create a instance of WhastPort.
        $w = new \WhatsProt($username, $nickname, $debug);

        $w->connect(); // Connect to WhatsApp network
        $w->loginWithPassword($password);

        $events = new CustomEvent($w, $output);
        $events->setEventsToListenFor(['onGetMessage']);

        $w->pollMessage();

        $helper = $this->getHelper('question');

        $question = new Question('..', false);
        $destination = $helper->ask($input, $output, $question);
    }

}