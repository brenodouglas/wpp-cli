<?php
namespace Whatsapp\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class Confirm extends Command
{

	protected function configure()
    {
        $this
            ->setName('whatsapp:confirm')
            ->setDescription('Código de confirmação')
            ->addOption(
        		'number',
		        null,
		        InputOption::VALUE_REQUIRED,
		        ''
        	);
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $number = $input->getOption('number');
        $debug = true;

        try {
            // Create a instance of Registration class.
            $r = new \Registration($number, $debug);
            $r->codeRequest('sms'); // could be 'voice' too
        } catch(\Exception $e) {
            $output->writeln('<error>the number is invalid '.$number.'</error>');
            return false;
        }

        $helper = $this->getHelper('question');

        $question = new Question('Digite seu código de confirmação recebido por SMS (sem hífen "-"): ', false);
        $question->setValidator(function($value) use ($output, $r) {
            try {
               $response = $r->codeRegister($value); 
               $output->writeln('<fg=green>Your password is: '.$response->pw.' and your login: '.$response->login.'</>');
            } catch (\Exception $e) {
                $output->writeln("<error>Código inválido, tente novamente mais tarde!</error>");
                return false;
            }
            
            return true;
        });
        
        $codigo = $helper->ask($input, $output, $question);

	 	$output->writeln('<fg=green>Your number is '.$number.' and your code: '.$codigo.'</>');
    }

}