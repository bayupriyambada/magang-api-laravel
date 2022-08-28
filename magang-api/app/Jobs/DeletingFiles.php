<?php

namespace App\Jobs;

use Illuminate\Support\Facades\File;

class DeletingFiles extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $deleting;
    public function __construct($deleting)
    {
        $this->deleting = $deleting;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (File::exists($this->deletingFiles)) {
            unlink($this->deletingFiles);
        }
    }
}
