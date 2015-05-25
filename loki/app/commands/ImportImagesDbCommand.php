<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ImportImagesDbCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'import:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import images in the database.';

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
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        ini_set('memory_limit','1024M');

        $results = DB::select('select Image from pictures');

        foreach($results as $image) {
            try{
                $path = public_path() . "/pictures/";
                $filename = $image->Image;
                $picture = $path . $filename;
                $data = file_get_contents($picture);
                DB::table('pictures')
                    ->where('Image', $filename)
                    ->update(array('picture' => $data));
            }catch(Exception $e) {
                //print_r($e);
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
        );
    }

}
