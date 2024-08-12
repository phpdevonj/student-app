<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportTemplate;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
// use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpWord\IOFactory;

class ReportTemplateController extends Controller
{

    public function index(): Response
    {
        $templates = ReportTemplate::all();
        $reports = Report::paginate(10);
        return Inertia::render('Report/index', [
            'templates' => $templates,
            'reports' => $reports,
        ]);
    }

    public function uploadFile(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads');
            try{
                $content = $this->parseDocx(storage_path('app/' . $path));
            } catch (\Exception $exception) {
                dd($exception);
            }
        }
    }
    private function parseDocx($filePath)
    {

        // Load the DOCX file
        try {
            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
            $phpWord = IOFactory::load($filePath);
        } catch (\Exception $e) {
            echo "Error loading DOCX file: " . $e->getMessage();
            exit;
        }
        $phpWord->getSettings()->setEvenAndOddHeaders(false);

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {

                // get only table data
                if ($element instanceof \PhpOffice\PhpWord\Element\Table) {
                    $reportData = [];
                    $rows = $element->getRows();
                    foreach ($element->getRows() as $index => $row) {
                        if ($index > 1) {

                            if(count($row->getCells()) == 5){
                                $cell = $row->getCells();
                                $reportData['subject_name'] = $cell[0]->getElements()[0]->getText();
                                $reportData['start_date'] = $cell[2]->getElements()[0]->getText();
                                $reportData['end_date'] = $cell[3]->getElements()[0]->getText();
                                $reportData['improvement_target'] = $cell[4]->getElements()[0]->getText();
                            }

                            if(count($row->getCells()) == 4){
                                $cell = $row->getCells();
                                $reportData['subject_name'] = $cell[0]->getElements()[0]->getText();
                                $date = explode(' to ', $cell[2]->getElements()[0]->getText());
                                $reportData['start_date'] = $date[0];
                                $reportData['end_date'] = $date[1];
                                preg_match('/\d+/', $cell[3]->getElements()[0]->getText(), $target);
                                $reportData['improvement_target'] = $target[0];
                            }

                            if(count($row->getCells()) >= 2){
                                $cells = $rows[$index - 1]->getCells();

                                if (trim($cells[0]->getElements()[0]->getText()) == 'Subject name') {
                                    $reportData['subject_name'] = $rows[$index]->getCells()[0]->getElements()[0]->getText();
                                }
                            }
                            $upperRow = '';
                            $upperRow = $rows[$index - 1]->getCells()[0]->getElements()[0]->getText();
                            if($upperRow == 'Session start date' || $upperRow == 'Start Date') {
                                $reportData['start_date'] = $rows[$index]->getCells()[0]->getElements()[0]->getText();
                            }
                            if($upperRow == 'Session end date' || $upperRow == 'End Date') {
                                $reportData['end_date'] = $rows[$index]->getCells()[0]->getElements()[0]->getText();
                            }
                            if($upperRow == 'Improvement target' || $upperRow == 'target') {
                                $reportData['improvement_target'] = $rows[$index]->getCells()[0]->getElements()[0]->getText();
                            }
                        }

                        // validate if all required fields have values
                        $missingFields = array_diff(['subject_name', 'start_date', 'end_date', 'improvement_target'], array_keys($reportData));
                        if (empty($missingFields) && !in_array(null, $reportData)) {
                            $report = new Report;
                            $report->subject_name = $reportData['subject_name'] ;
                            $report->start_date = $reportData['start_date'] ;
                            $report->end_date = $reportData['end_date'] ;
                            $report->improvement_target = $reportData['improvement_target'] ;
                            $report->created_at = now();
                            $report->updated_at = now() ;
                            $report->save();

                            // empty reportData for next collection
                            $reportData = [];
                        }
                    }
                }
            }
        }
        return true;
    }


    public function create()
    {
        return view('Report.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'template_name' => 'required',
            'template_content' => 'required',
        ]);

        ReportTemplate::create($request->all());

        return redirect()->route('Report.index')
                        ->with('success', 'Report Template created successfully.');
    }

    public function edit($id)
    {
        $template = ReportTemplate::find($id);
        return view('report-templates.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'template_name' => 'required',
            'template_content' => 'required',
        ]);

        $template = ReportTemplate::find($id);
        $template->update($request->all());

        return redirect()->route('report-templates.index')
                        ->with('success', 'Report Template updated successfully.');
    }

    public function destroy($id)
    {
        $template = ReportTemplate::find($id);
        $template->delete();

        return redirect()->route('report-templates.index')
                        ->with('success', 'Report Template deleted successfully.');
    }
}
