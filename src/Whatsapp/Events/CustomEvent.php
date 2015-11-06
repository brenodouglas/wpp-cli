<?php
namespace Whatsapp\Events;

use AllEvents as AbstractEvents;

class CustomEvent extends AbstractEvents
{
	private $output;

 	public function __construct(\WhatsProt $whatsProt, $output = null)
    {
        $this->whatsProt = $whatsProt;
        $this->output = $output;
        return $this;
    }

	public function onGetMessage( $mynumber, $from, $id, $type, $time, $name, $body )
	{
	    $this->output->writeln('<fg=green>Message from: '.$name.'</>'.PHP_EOL);
	    $this->output->writeln('<fg=green>Body: '.$body.'</>'.PHP_EOL);

	    echo "Message from $name:\n$body\n\n";
	}

}