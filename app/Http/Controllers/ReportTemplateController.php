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
        $phpWord = IOFactory::load($filePath);

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if ($element instanceof \PhpOffice\PhpWord\Element\Table) {
                    $reportData = [];
                    $rows = $element->getRows();
                    foreach ($element->getRows() as $index => $row) {
                        if(count($row->getCells()) >= 2){
                            $cells = $row->getCells();
                            // dd(trim($cells[0]->getElements()[0]->getText()) == 'Subject name');
                            if (trim($cells[0]->getElements()[0]->getText()) == 'Subject name') {
                                $reportData['subject_name'] = trim($cells[1]->getElements()[0]->getText());
                            }
                        }

                        $upper = '';
                        if ($index > 1) {
                            $upper = $rows[$index - 1]->getCells()[0]->getElements()[0]->getText();
                            if($upper == 'Session start date') {
                                $reportData['start_date'] = $rows[$index]->getCells()[0]->getElements()[0]->getText();
                            }
                            if($upper == 'Session end date') {
                                $reportData['end_date'] = $rows[$index]->getCells()[0]->getElements()[0]->getText();
                            }
                            if($upper == 'Improvement target') {
                                $reportData['improvement_target'] = $rows[$index]->getCells()[0]->getElements()[0]->getText();
                            }
                        }

                    }
                    if(!empty($reportData)){
                        $report = new Report;
                        $report->subject_name = $reportData['subject_name'] ;
                        $report->start_date = $reportData['start_date'] ;
                        $report->end_date = $reportData['end_date'] ;
                        $report->improvement_target = $reportData['improvement_target'] ;
                        $report->created_at = now();
                        $report->updated_at = now() ;
                        $report->save();
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
