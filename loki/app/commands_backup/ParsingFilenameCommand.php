<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ParsingFilenameCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'parse:filename';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing images filename.';

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

        $regexp = "/(\d{8})\s+(\d{6})\s+(\d{3})\s+\d+\s+(\d+)\s+(\d+)/";
        while(1 == 1) {

            $result = DB::select('select count(*) as count from pictures where timestamp is null');
            $this->info($result[0]->count . ' rows left.');
            if($result[0]->count == 0){
                break;
            }
            unset($result);

            $results = DB::select('select Image, id from pictures where timestamp is null limit 1000');
            foreach ($results as $pic)
            {
                $image = $pic->Image;
                $md5 = $pic->id;
                unset($pic);
                $parsedFilename = preg_match($regexp, $image, $matches);
                $milli = $matches[3];
                $date = new DateTime($matches[1] . ' ' . $matches[2]);
                $timestamp = $date->getTimestamp()*1000 + $milli;
                unset($date);
                $posX = $matches[4];
                $posY = $matches[5];
                DB::table('pictures')
                            ->where('id', $md5)
                            ->update(array('milliseconds' => $milli, 'posx' => $posX, 'posy' => $posY, 'timestamp' => $timestamp));
            }
            unset($results);
            $this->info('Process 1000 rows');
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
