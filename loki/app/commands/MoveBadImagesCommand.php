<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MoveBadImagesCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'move:badimages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Moves bad images in a separate folder.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
        // Make sure that the bad images folder is created
        $publicPath = public_path() . "/loki/public";
        var_dump($publicPath);
		@mkdir($publicPath . '/pictures/bad');

        $results = DB::select('select Image from pictures where state = "double" or deleted = 1');
        foreach($results as $img) {
            if(file_exists($publicPath . '/pictures/' . $img->Image)) {
                rename($publicPath . '/pictures/' . $img->Image, $publicPath . '/pictures/bad/' . $img->Image);
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
        );
    }

}
