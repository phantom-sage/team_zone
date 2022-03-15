<?php declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

final class WelcomeControllerTest extends TestCase
{
    /**
     * welcome page.
     *
     * @return void
     * @test
     * @covers \App\Http\Controllers\WelcomeController
     */
    public function welcome_page(): void
    {
        $this->get(route('welcome.page'))
            ->assertOk()
            ->assertInertia(fn(Assert $page) => $page
            ->component('Welcome'));
    }
}
