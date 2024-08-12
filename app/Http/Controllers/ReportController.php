<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportTemplate;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'template_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $sessionData = $this->getSessionData($request->start_date, $request->end_date);
        $filePath = $this->reportService->generateReport($request->template_id, $sessionData, $request->start_date, $request->end_date);

        return response()->download(storage_path('app/' . $filePath));
    }

    private function getSessionData($startDate, $endDate)
    {
        // Logic to fetch and prepare session data based on the date range
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');
        $filePath = $file->getPathName();

        // Load the spreadsheet
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getRowIterator() as $row) {
            dd($row);
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $rowData = [];
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }

            // Assuming the columns are: subject_name, start_date, end_date, improvement_target
            Report::create([
                'subject_name' => $rowData[0],  // Adjust based on your spreadsheet columns
                'start_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rowData[1]),
                'end_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rowData[2]),
                'improvement_target' => $rowData[3],
            ]);
        }
    }

}

