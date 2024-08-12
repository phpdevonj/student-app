<?php

namespace App\Services;

use App\Models\ReportTemplate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class ReportService
{
    public function generateReport($templateId, $sessionData, $dateRange)
    {
        $template = ReportTemplate::find($templateId);
        $content = $this->replaceShortcodes($template->template_content, $sessionData);

        $pdf = Pdf::loadHTML($content);
        $filePath = 'reports/report_' . time() . '.pdf';
        Storage::put($filePath, $pdf->output());

        return $filePath;
    }

    private function replaceShortcodes($templateContent, $data)
    {
        $replacements = [
            '@student_full_name' => $data['student_full_name'],
            '@session_date' => $data['session_date'],
            '@session_minutes' => $data['session_minutes'],
            '@session_start_time' => $data['session_start_time'],
            '@session_end_time' => $data['session_end_time'],
            '@target_start_date' => $data['target_start_date'],
            '@target_end_date' => $data['target_end_date'],
            '@target' => $data['target'],
            '@session_rating' => $data['session_rating'],
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $templateContent);
    }

    public function splitReport($filePath, $splitDuration)
    {
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile(Storage::path($filePath));

        // Logic to split the PDF into parts based on duration
        // Save the split PDFs to the desired location

        return $splitFilePaths; // Return paths of split files
    }
}
