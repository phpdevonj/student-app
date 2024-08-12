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
        // $request->validate([
        //     'file' => 'required|mimes:xlsx,xls,csv,docx',
        // ]);

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
        // Iterate through sections

        $reportRow = [];
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if ($element instanceof \PhpOffice\PhpWord\Element\Table) {
                    $rows = $element->getRows();
                    foreach ($element->getRows() as $index => $row) {
                        if ($index > 1) {
                            $rows[$index - 1]->getElements()[0]->getText() = '';
                        }
                        if(count($row->getCells()) >= 2){
                            $cells = $row->getCells();
                            // dd(trim($cells[0]->getElements()[0]->getText()) == 'Subject name');
                            if (trim($cells[0]->getElements()[0]->getText()) == 'Subject name') {
                                $subjectName = trim($cells[1]->getElements()[0]->getText());
                                echo 'subject Name - '. $subjectName.'<br>';
                            }
                        }

                        echo '<br>';
                    }
                }
            }
            dd($phpWord->getSections());

            // Get header content (if any)
            $headers = $section->getHeaders();
            foreach ($headers as $header) {
                // Extract text elements from the header
                foreach ($header->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        echo 'Header Text: ' . $element->getText() . PHP_EOL;
                    }
                }
            }

            // Get the main body content
            foreach ($section->getElements() as $element) {
                if ($element instanceof \PhpOffice\PhpWord\Element\Table) {
                    foreach ($element->getRows() as $row) {
                        foreach ($row->getCells() as $cell) {
                            echo 'Cell Text: ' . $cell->getText() . PHP_EOL;
                        }
                    }
                }
            }
        }
        dd('$spreadsheet');
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();
        return $data;
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
