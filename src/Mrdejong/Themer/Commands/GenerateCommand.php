<?php namespace Mrdejong\Themer\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Mrdejong\Themer\Generator\ThemeGenerator;

class GenerateCommand extends Command {
    protected $name = 'themer:generate';
    
    protected $description = "Generate theme directory structure";
    
    public function handle()
    {
        $includeResources = $this->option('resources');
        $name = $this->argument('name');

        $generator = new ThemeGenerator($name);
        $generator->addOptional($includeResources);

        try 
        {
            $generator->run();
        }
        catch(Exception $e)
        {
            $this->error($e->getMessage());
        }
    }
    
    protected function getOptions()
    {
        return array(
            ['resources', null, InputOption::VALUE_NONE, 'Generates optional directories and files.']  
        );
    }

    protected function getArguments()
    {
        return array(
            ['name', InputArgument::REQUIRED, 'The name of the new theme']
        );
    }
}