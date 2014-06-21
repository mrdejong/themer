<?php namespace Mrdejong\Themer\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateCommand extends Command {
    protected $name = 'themer:generate';
    
    protected $description = "Generate theme directory structure";
    
    public function fire()
    {
        
    }
    
    protected function getOptions()
    {
        return array(
            ['resources', 'rs', InputOption::VALUE_OPTIONAL, 'Generates optional directories and files.']  
        );
    }
}