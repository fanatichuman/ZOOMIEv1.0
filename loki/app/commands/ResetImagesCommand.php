<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ResetImagesCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'reset:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all the images imported in the database.';

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
        DB::table('pictures')
            ->update(array(
                'processed' => 0,
                'group_id' => 0,
                'deleted' => 0,
                'state' => 'real'
            ));
        DB::table('group')->truncate();
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
