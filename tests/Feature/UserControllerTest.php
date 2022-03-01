<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Mail\SendReport;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

final class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * send report as pdf to email.
     *
     * @test
     */
    public function send_report_as_pdf_to_email(): void
    {
        Mail::fake();
        Project::factory()->count(10)->create();
        $this->assertDatabaseCount('projects', 10);

        $data = [
            'from_date' => now()->format('Y-m-d'),
            'to_date' => now()->format('Y-m-d'),
            'email' => 'abdoaltayeb10@gmail.com',
        ];

        $resp = $this->post(route('reports.send.email'), $data);
        $resp->assertOk();
        Mail::assertSent(SendReport::class);
    }

    /**
     * send_report_as_pdf_to_email_not_found.
     *
     * @test
     */
    public function send_report_as_pdf_to_email_not_found(): void
    {
        $data = [
            'from_date' => now()->format('Y-m-d'),
            'to_date' => now()->format('Y-m-d'),
            'email' => $this->faker->unique()->safeEmail(),
        ];

        $resp = $this->post(route('reports.send.email'), $data);
        $resp->assertNotFound();
    }


    /**
     * export report as pdf not found.
     *
     * @covers \App\Http\Controllers\UserController::export_report_as_pdf
     * @test
     */
    public function export_report_as_pdf_not_found(): void
    {
        $data = [
            'from_date' => now()->format('Y-m-d'),
            'to_date' => now()->format('Y-m-d'),
        ];

        $resp = $this->post(route('reports.export.pdf'), $data);
        $resp->assertNotFound();
    }

    /**
     * export report as pdf.
     *
     * @test
     */
    public function export_report_as_pdf(): void
    {
        $this->withoutExceptionHandling();
        Project::factory()->count(10)->create();

        Project::factory([
            'created_at' => now()->addDays(10),
        ])->count(10)->create();

        $this->assertDatabaseCount('projects', 20);

        $data = [
            'from_date' => now(),
            'to_date' => now()->addDays(10),
        ];

        $resp = $this->post(route('reports.export.pdf'), $data);
        $resp->assertDownload();
    }

    /**
     * report.
     *
     * @test
     */
    public function report_with_all_records(): void
    {
        Project::factory()->count(10)->create();
        $this->assertDatabaseCount('projects', 10);

        $data = [
            'from_date' => now(),
            'to_date' => now()->addDays(10),
        ];

        $resp = $this->post(route('reports.store'), $data);
        $resp->assertOk();
    }
}