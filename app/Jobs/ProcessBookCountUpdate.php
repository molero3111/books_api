<?php

namespace App\Jobs;

use App\Models\Author;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessBookCountUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The Book instance.
     *
     * @var Author
     */
    public $author;

    /**
     * Create a new job instance.
     */
    public function __construct(Author $author)
    {
        $this->author = $author;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->author->published_books = $this->author->books()->count();
        $this->author->save();
    }
}
