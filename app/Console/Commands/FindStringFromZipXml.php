<?php

namespace App\Console\Commands;

use App\Services\FindFromZipXml;
use Illuminate\Console\Command;

class FindStringFromZipXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'find:zip:xml {string} {quarter=1} {limit=all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle(FindFromZipXml $service)
    {
        $string = $this->argument('string');
        $limit = $this->argument('limit');
        $quarter = $this->argument('quarter');

        $this->info("Finding Company in Quarter:- ". $quarter);
        
        $service->setString($string)
                ->setQuarter($quarter)
                ->setLimit($limit)
                ->exec();

        $this->info("Restoring Files");
        $service->setQuarter($quarter)
                ->restoreFiles();
    }
}
