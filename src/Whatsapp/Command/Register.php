<?php
namespace Whatsapp\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;

class Register extends Command
{

	protected function configure()
    {
        $this
            ->setName('whatsapp:register')
            ->setDescription('Greet someone');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$helper = $this->getHelper('question');

    	$question1 = new ChoiceQuestion(
	        'Escolha o código do País',
	        array('55'),
	        55
	    );

    	$codigoPais = $helper->ask($input, $output, $question1);

        $question = new Question('Digite seu numero com DDD (sem o "0"): ', false);
        $question->setValidator(function($value) use ($output) {
        	if(strlen($value) > 11 || strlen($value) < 10) {
        		$output->writeln("<error>Numéro inválido inválido, deve conter no minimo 10 e no máximo 11 digitos</error>");
        		return false;
        	}

        	return $value;
        });    
        $numero = $helper->ask($input, $output, $question);
   
        $username = $codigoPais.$numero;
        $command = $this->getApplication()->find('whatsapp:confirm');

	    $arguments = array(
	        'command' => 'whatsapp:confirm',
	        '--number'  => $username,
	    );

	    $inputs = new ArrayInput($arguments);
	    $returnCode = $command->run($inputs, $output);
	 	
    }

}