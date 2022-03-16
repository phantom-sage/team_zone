<?php

namespace App\Http\Controllers;

use App\Mail\SendReport;
use App\Models\Project;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{

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
            'project' => ['required'],
        ]);

        $from_date = Carbon::parse($data['from_date'])->format('Y-m-d');
        $to_date = Carbon::parse($data['to_date'])->format('Y-m-d');

        if ($data['project'] == 'all') {

            $projects = Project::all()->filter(function ($project) use ($from_date, $to_date) {
                return $project->created_at->format('Y-m-d') <= $from_date || $project->created_at->format('Y-m-d') <= $to_date;
            });

            if (!empty($projects)) {
                $pdf_data = [
                    'projects' => $projects,
                    'date' => now(),
                    'title' => env('APP_NAME', 'TeamZone')
                ];

                $pdf = PDF::loadView('projects.report', $pdf_data);
                $pdf_name = 'report_' . time() . '.pdf';
                if (Storage::disk('public')->put('reports/' . $pdf_name, $pdf->output(), ['mime' => 'application/pdf'])) {
                    $user = Auth::user();
                    if ($user != null) {
                        Mail::to($user['email'] ?? null)->send(new SendReport($pdf_name));
                        session()->flash('flash.banner', 'Send successfully');
                        session()->flash('flash.bannerStyle', 'success');
                        return back();
                    }
                }
            }
            return abort(404, 'NOT FOUND');
        }

        $project = Project::find($data['project'])->filter(function ($p) use ($from_date, $to_date) {
            return $p->created_at->format('Y-m-d') <= $from_date || $p->created_at->format('Y-m-d') <= $to_date;
        });
        if (!empty($project)) {
            $pdf_data = [
                'projects' => $project,
                'date' => now(),
                'title' => env('APP_NAME', 'TeamZone')
            ];

            $pdf = PDF::loadView('projects.report', $pdf_data);
            $pdf_name = 'report_' . time() . '.pdf';
            if (Storage::disk('public')->put('reports/' . $pdf_name, $pdf->output(), ['mime' => 'application/pdf'])) {
                $user = Auth::user();
                if ($user != null) {
                    Mail::to($user['email'] ?? null)->send(new SendReport($pdf_name));
                    session()->flash('flash.banner', 'Send successfully');
                    session()->flash('flash.bannerStyle', 'success');
                    return back();
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
            'project' => ['required'],
        ]);
        $from_date = Carbon::parse($data['from_date'])->format('Y-m-d');
        $to_date = Carbon::parse($data['to_date'])->format('Y-m-d');

        if ($data['project'] == 'all') {

            $projects = Project::all()->filter(function ($project) use ($from_date, $to_date) {
                return $project->created_at->format('Y-m-d') <= $from_date || $project->created_at->format('Y-m-d') <= $to_date;
            });

            if (!empty($projects)) {
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
                        'Content-Disposition' => 'attachment;',
                    ], 'attachment');
                }
            }
            return abort(404, 'NOT FOUND');
        }

        $project = Project::find($data['project']);
        if (!empty($project)) {
            $pdf_data = [
                'project' => $project,
                'date' => now(),
                'title' => env('APP_NAME', 'TeamZone')
            ];

            $pdf = PDF::loadView('projects.single', $pdf_data);
            $pdf_name = 'report_' . time() . '.pdf';
            $pdf_created = Storage::disk('public')
                ->put('reports/' . $pdf_name, $pdf->output(), ['mime' => 'application/pdf']);
            if ($pdf_created) {
                $pdf_to_download = Storage::disk('public')->path('reports/' . $pdf_name);
                return response()->download($pdf_to_download, 'report.pdf', [
                    'Content-Disposition' => 'attachment;',
                ], 'attachment');
            }
        }
        return abort(404, 'NOT FOUND');
    }
}
