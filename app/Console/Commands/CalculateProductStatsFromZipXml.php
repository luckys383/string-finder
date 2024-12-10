<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FindProductStatsFromZipXml;

class CalculateProductStatsFromZipXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'find:product:stats {string} {quarter=1} {year=2019} {limit=all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate stats of product by Quantity or Revenue.';

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
    public function handle(FindProductStatsFromZipXml $service)
    {
        $string = $this->argument('string');
        $limit = $this->argument('limit');
        $quarter = $this->argument('quarter');
        $year = $this->argument('year');

        $this->info("Finding Company in Quarter:- ". $quarter);
        
        $service->setString($string)
                ->setYear($year)
                ->setQuarter($quarter)
                ->setLimit($limit)
                ->setProgressBar($this->output)
                ->exec();

        $this->info("Restoring Files");
        $service->setQuarter($quarter)
                ->restoreFiles();
    }
}
