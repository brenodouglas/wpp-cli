<?php
namespace Whatsapp\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class SendMessage extends Command
{

	protected function configure()
    {
        $this
            ->setName('whatsapp:message')
            ->setDescription('Código de confirmação');
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

        $helper = $this->getHelper('question');

        $question = new Question('Digite o numero que deseja enviar sua mensagem: ', false);
        $destination = $helper->ask($input, $output, $question);

        $question = new Question('Digite sua mensagem: ', false);
        $message = $helper->ask($input, $output, $question);

        $w->sendMessage($destination , $message);

	 	$output->writeln('<fg=green>Send message with success!</>');
    }

}