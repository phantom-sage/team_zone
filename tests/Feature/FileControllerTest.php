<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Models\File;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

final class FileControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * file destroy route.
     *
     * @test
     */
    public function file_destroy_route(): void
    {
        File::factory()->create();
        $this->assertDatabaseCount('files', 1);
        $this->assertDatabaseCount('projects', 1);
        $file_id = File::first()['id'] ?? null;
        if ($file_id) {
            $this->delete(route('files.destroy', ['file' => $file_id]))->assertOk();
        }
    }

    /**
     * file update route.
     *
     * @test
     */
    public function file_update_route(): void
    {
        File::factory()->create();
        $this->assertDatabaseCount('files', 1);
        $this->assertDatabaseCount('projects', 1);
        $file_id = File::first()['id'] ?? null;
        if ($file_id) {
            $this->put(route('files.update', ['file' => $file_id]))->assertOk();
        }
    }

    /**
     * file edit route.
     *
     * @test
     */
    public function file_edit_route(): void
    {
        File::factory()->create();
        $this->assertDatabaseCount('files', 1);
        $this->assertDatabaseCount('projects', 1);
        $file_id = File::first()['id'] ?? null;
        if ($file_id) {
            $this->get(route('files.edit', ['file' => $file_id]))->assertOk();
        }
    }

    /**
     * file show route.
     *
     * @test
     */
    public function file_show_route(): void
    {
        File::factory()->create();
        $this->assertDatabaseCount('files', 1);
        $this->assertDatabaseCount('projects', 1);
        $file_id = File::first()['id'] ?? null;
        if ($file_id) {
            $this->get(route('files.show', ['file' => $file_id]))->assertOk();
        }
    }

    /**
     * file create route.
     *
     * @test
     */
    public function file_create_route(): void
    {
        $this->get(route('files.create'))->assertOk();
    }

    /**
     * file index route.
     *
     * @test
     */
    public function file_index_route(): void
    {
        $this->get(route('files.index'))->assertOk();
    }


    /**
     * add file to project.
     *
     * @test
     */
    public function add_file_to_project(): void
    {
        Storage::fake('projects');
        $file = UploadedFile::fake()->image('srs.pdf');

        Project::factory()->create();
        $this->assertDatabaseCount('projects', 1);
        $project_id = Project::first()['id'] ?? null;
        if ($project_id) {
            $data = [
                'title' => $this->faker->name(),
                'description' => $this->faker->sentence(),
                'path' => $file,
                'project_id' => $project_id
            ];
            $resp = $this->post(route('files.store'), $data);
            $resp->assertOk();
            Storage::disk('public')->assertExists('projects/' . $file->hashName());
            $this->assertDatabaseCount('files', 1);
        }
    }

    /**
     * add file without title.
     *
     * @covers \App\Http\Controllers\FileController::store
     * @test
     */
    public function add_file_without_title(): void
    {
        Storage::fake('projects');
        $file = UploadedFile::fake()->image('srs.pdf');

        Project::factory()->create();
        $this->assertDatabaseCount('projects', 1);
        $project_id = Project::first()['id'] ?? null;
        if ($project_id) {
            $data = [
                'description' => $this->faker->sentence(),
                'path' => $file,
                'project_id' => $project_id
            ];
            $resp = $this->post(route('files.store'), $data);
            $resp->assertRedirect();
        }
    }
}
