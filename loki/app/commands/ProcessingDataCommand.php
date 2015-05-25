<?php
//Core Code written by Nicolas Garneau
//Adjusted by Moritz Schmid
//Last modified 8/6/2014
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ProcessingDataCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'processing:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processing data.';

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

        while(1 == 1) {
            //$id = $this->argument('id');
            //if($id) {
                //$results = DB::select('select Image, Form, Area, Convex, Structure, Kurtosis, Skew, posx, posy, timestamp, id from pictures where processed = 0 and Image = "'.$id.'" limit 1');
            //}
            //else{
                $results = DB::select('select Image, Form, Area, Convex, Structure, Gray, Kurtosis, Skew, posx, posy, timestamp,  id from pictures where processed = 0 limit 1');
            //}

            if(count($results) == 0) {
                break;
            }

            $this->info('Getting the first one that hasn\'t been processed yet.');
            $this->info('');


            foreach($results as $result){

                $this->info('Cobail is: ' . $result->Image);
                $this->info('Area of the cobail: ' . $result->Area);
                $this->info('Position X of the cobail: ' . $result->posx);
                $this->info('Position Y of the cobail: ' . $result->posy);
				$this->info('Grayness of the cobail is: ' . $result->Gray);
				$this->info('Form of the cobail is: ' . $result->Form);
				$this->info('Convex of the cobail is: ' . $result->Convex);
                $this->info('Structure of the cobail is: ' . $result->Structure);
                $this->info('Kurtosis of the cobail is: ' . $result->Kurtosis);
				$this->info('Skew of the cobail is: ' . $result->Skew);
				$this->info('');

                // create group for this one
                $idGroup = DB::table('group')->insertGetId( array());
                DB::table('pictures')
                                    ->where('id', $result->id)
                                    ->update(array('group_id' => $idGroup, 'processed' => 1));

                $currentPosX = $result->posx;
                $currentPosY = $result->posy;

                $timestamp = $result->timestamp;

                // fetching other friends
                $this->info('Fetching other friends');
                $fetchUntilTimestamp = $timestamp + 1000;
                $friends = DB::select('select Image, Form, Area, Convex, Structure, Gray, Kurtosis, Skew, posx, posy, timestamp, id from pictures where processed = 0 and timestamp between '.$timestamp.' and '.$fetchUntilTimestamp . ' and state="real" and id != "'.$result->id.'"');
				
				foreach($friends as $friend){
                    $this->info('Comparing friend '.$friend->Image);

                    $areaDiff = abs(floatval(str_replace(',', '.', $result->Area))-floatval(str_replace(',', '.', $friend->Area)));
					$formDiff = abs(floatval(str_replace(',', '.', $result->Form))-floatval(str_replace(',', '.', $friend->Form)));
					$convexDiff = abs(floatval(str_replace(',', '.', $result->Convex))-floatval(str_replace(',', '.', $friend->Convex)));
					$structureDiff = abs(floatval(str_replace(',', '.', $result->Structure))-floatval(str_replace(',', '.', $friend->Structure)));
					$kurtosisDiff = abs(floatval(str_replace(',', '.', $result->Kurtosis))-floatval(str_replace(',', '.', $friend->Kurtosis)));
					$skewDiff = abs(floatval(str_replace(',', '.', $result->Skew))-floatval(str_replace(',', '.', $friend->Skew)));
                    $posxDiff = abs($currentPosX-$friend->posx);
                    $posyDiff = abs($currentPosY-$friend->posy);
					$grayDiff = abs($result->Gray-$friend->Gray);
                    
					$this->info('Area of the friend: ' . $friend->Area);
                    $this->info('Position X of the friend: ' . $friend->posx);
                    $this->info('Position Y of the friend: ' . $friend->posy);
                    $this->info('Grayness of the friend: ' . $friend->Gray);
					$this->info('');

                    $this->info('Area diff: '.(@($areaDiff/$result->Area)));
					$this->info('Grayness diff: '.(@($grayDiff)));
                    $this->info('Position X diff: '.$posxDiff);
                    $this->info('Position Y diff: '.$posyDiff);
                    if(
                        (@($areaDiff/$result->Area)) == true
                        && (@($areaDiff/$result->Area)) < .18
                        && ($posxDiff < 125 || $posyDiff < 125 || ($posxDiff + $posyDiff) < 450)
						&& (@($grayDiff)) < 2
						&& (@($formDiff/$result->Form)) < .2
						&& (@($convexDiff/$result->Convex)) < .2
						&& (@($structureDiff/$result->Structure)) < .2
						&& (@($kurtosisDiff/$result->Kurtosis)) < .2
						&& (@($skewDiff/$result->Skew)) < .2
						//&& ($convexDiff < .1 || $formDiff < 0.1 || $structureDiff < 0.1 || $kurtosisDiff < 0.1 || $skewDiff < 0.1)
                    ){
                        $this->info("It's a match! ===> " . $result->Image . ' - ' . $friend->Image);
                        $currentPosX = ($currentPosX+$friend->posx)/2;
                        $currentPosY = ($currentPosY+$friend->posy)/2;
                        $this->info("Updating posx and posy to: " . $currentPosX . ' - ' . $currentPosY);

                        DB::table('pictures')
                                    ->where('id', $friend->id)
                                    ->update(array('state' => 'double', 'processed' => 1, 'group_id' => $idGroup));
                    }


                    $this->info('');
                    $this->info('');
                }
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
            array('id', InputArgument::OPTIONAL, 'Filename of the image.'),
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
