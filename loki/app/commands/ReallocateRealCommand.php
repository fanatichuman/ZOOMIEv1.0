<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ReallocateRealCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'reallocate:real';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reallocate the real guy for each groups';

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
        $groups = Group::all();
        foreach($groups as $group){
            $this->_reallocateRealGuy($group);
        }
    }

    private function _reallocateRealGuy(Group $group)
    {
        $pictures = $group->pictures;

        foreach($pictures as $picture) {
            $picture->state = "double";
            $picture->save();
        }

        $firstPicture = $pictures->filter(
            function($picture){
                if($picture->deleted == 0) {
                    return true;
                }
            }
        )->first();
        $firstPicture->state = "real";
        $firstPicture->save();
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
