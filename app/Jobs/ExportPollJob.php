<?php

namespace App\Jobs;

use App\Models\Poll;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\IOFactory;
use \PhpOffice\PhpWord\PhpWord;

class ExportPollJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $polls;

    public function __construct($polls)
    {
        $this->polls = $polls;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $phpWord = new PhpWord();
        Log::channel('single')->info('Получили опросы: ' . $this->polls);

        foreach ($this->polls as $poll) {
            Log::channel('single')->info('Экспортируем опрос: ' . $poll->title . ' с ' . $poll->options->count() . ' опциями');

            $section = $phpWord->addSection();
            $section->addTitle($poll->title, 1);
            $section->addText($poll->description);

            foreach ($poll->options as $option) {
                $section->addListItem($option->text);
            }
        }

        $fileName = 'polls_export_' . now()->format('Y-m-d-h') . '.docx';
        $filePath = storage_path('app/' . $fileName);

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($filePath);

        Log::info('Файл создан: ' . $filePath);
    }
}
