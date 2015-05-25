<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/
Artisan::add(new CreateTableCommand);
Artisan::add(new ParsingFilenameCommand);
Artisan::add(new ProcessingDataCommand);
Artisan::add(new ImportImagesDbCommand);
Artisan::add(new MoveBadImagesCommand);
Artisan::add(new ResetImagesCommand);
Artisan::add(new ReallocateRealCommand);
