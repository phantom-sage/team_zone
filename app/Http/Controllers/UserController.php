<?php

namespace App\Http\Controllers;

use App\Mail\SendReport;
use App\Models\Project;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{

    //
    /**
     * send report as pdf to email.
     *
     * @param Request $request
     * @return string
     */
    public function send_report_as_pdf_to_email(Request $request)
    {
        $data = $request->validate([
            'from_date' => ['required', 'date'],
            'to_date' => ['required', 'date'],
        ]);

        $projects = Project::all();
        $x = [];
        if ($projects != null) {
            foreach ($projects as $project) {
                if ($project != null) {
                    $p_c = $project->created_at ? $project->created_at->format('Y-m-d') : null;
                    if ($p_c <= $data['from_date'] && $p_c <= $data['to_date']
                    ) {
                        $x[] = $project;
                    }
                }
            }
            if (!empty($x)) {
                $pdf_data = [
                    'projects' => $x,
                    'date' => now(),
                    'title' => env('APP_NAME', 'TeamZone')
                ];

                $pdf = PDF::loadView('projects.report', $pdf_data);
                $pdf_name = 'report_' . time() . '.pdf';
                if (Storage::disk('public')->put('reports/' . $pdf_name, $pdf->output(), ['mime' => 'application/pdf'])) {
                    $email = Auth::user()->email;
                    Mail::to($email)->send(new SendReport($pdf_name));
                    return 'send';
                }
            }
        }
        return abort(404, 'NOT FOUND');
    }

    /**
     * report.
     *
     * @param Request $request
     * @return mixed
     */
    public function report(Request $request)
    {
        $data = $request->validate([
            'from_date' => ['required', 'date'],
            'to_date' => ['required', 'date'],
        ]);
        return Project::where('created_at', '=', $data['from_date'])
            ->orWhere('created_at', '=', $data['to_date'])->get();
    }

    /**
     * export report as pdf.
     *
     * @param Request $request
     * @return BinaryFileResponse|string
     */
    public function export_report_as_pdf(Request $request)
    {
        $data = $request->validate([
            'from_date' => ['required', 'date'],
            'to_date' => ['required', 'date'],
        ]);
        $projects = Project::all();
        $x = [];
        foreach ($projects as $project) {
            $p_c = $project->created_at ? $project->created_at->format('Y-m-d') : null;
            if ($p_c <= $data['from_date'] && $p_c <= $data['to_date']) {
                $x[] = $project;
            }
        }
        if (!empty($x)) {
            $pdf_data = [
                'projects' => $projects,
                'date' => now(),
                'title' => env('APP_NAME', 'TeamZone')
            ];

            $pdf = PDF::loadView('projects.report', $pdf_data);
            $pdf_name = 'report_' . time() . '.pdf';
            $pdf_created = Storage::disk('public')
                ->put('reports/' . $pdf_name, $pdf->output(), ['mime' => 'application/pdf']);
            if ($pdf_created) {
                $pdf_to_download = Storage::disk('public')->path('reports/' . $pdf_name);
                return response()->download($pdf_to_download, 'report.pdf', [
                    'Content-Disposition' =>  'attachment;',
                ], 'attachment');
            }
        }
        return abort(404, 'NOT FOUND');
    }
}
