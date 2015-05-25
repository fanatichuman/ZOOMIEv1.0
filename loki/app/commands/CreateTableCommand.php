<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateTableCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'table:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the table.';

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
        $handle = fopen(app_path() . "/commands/117_1.csv", "r");
        $this->info('Creating table..');
        //
        // Read first (headers) record only)
        $data = fgetcsv($handle, 1000, ";");
        $sql= 'CREATE TABLE IF NOT EXISTS pictures (';
        for($i=0;$i<count($data); $i++) {
            $sql .= trim($data[$i]).' VARCHAR(100), ';
        }
        //The line below gets rid of the comma
        $sql = substr($sql,0,strlen($sql)-2);
        $sql .= ')';

        $results = DB::statement($sql);
        $this->info('Done.');

        fclose($handle);
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
