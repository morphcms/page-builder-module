<?php

namespace Modules\PageBuilder\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\PageBuilder\Contracts\IContentReadTimeResolver;
use Modules\PageBuilder\Models\Content;

class CalculateReadTimeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected Content $content, protected int $wordsPerMinute = 265)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $resolver = app(IContentReadTimeResolver::class);

        $this->content->read_time = $resolver->calculate($this->content, $this->wordsPerMinute);

        $this->content->saveQuietly();
    }
}
