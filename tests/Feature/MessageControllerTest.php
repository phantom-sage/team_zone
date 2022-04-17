<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Message;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class MessageControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * invalid message.
     *
     * @covers \App\Http\Controllers\MessageController::store
     * @test
     */
    public function invalid_message(): void
    {
        User::factory()->count(2)->create();
        $this->assertDatabaseCount('users', 2);
        $data = [
            'message' => $this->faker->sentence(),
            'sender_id' => 123,
            'sender_type' => 'User',
            'recipient_id' => 123,
            'recipient_type' => 'User',
        ];

        $resp = $this->post(route('messages.store'), $data);
        $resp->assertNotFound();
    }

    /**
     * invalid message from team member to team member.
     *
     * @covers \App\Http\Controllers\MessageController::store
     * @test
     */
    public function invalid_message_from_team_member_to_team_member(): void
    {
        TeamMember::factory()->count(2)->create();
        $this->assertDatabaseCount('team_members', 2);

        $data = [
            'message' => $this->faker->sentence(),
            'sender_id' => 123,
            'sender_type' => 'TeamMember',
            'recipient_id' => 123,
            'recipient_type' => 'TeamMember',
        ];

        $resp = $this->post('/messages', $data);
        $resp->assertNotFound();
    }

    /**
     * invalid message from team member to user.
     *
     * @covers \App\Http\Controllers\MessageController::store
     * @test
     */
    public function invalid_message_from_team_member_to_user(): void
    {
        User::factory()->create();
        TeamMember::factory([
            'type' => 'project_manager',
        ])->create();
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('team_members', 1);

        $data = [
            'message' => $this->faker->sentence(),
            'sender_id' => 123,
            'sender_type' => 'TeamMember',
            'recipient_id' => 123,
            'recipient_type' => 'User',
        ];

        $resp = $this->post(route('messages.store'), $data);
        $resp->assertNotFound();
    }

    /**
     * invalid message from user to team member.
     *
     * @covers \App\Http\Controllers\MessageController::store
     * @test
     */
    public function invalid_message_from_user_to_team_member(): void
    {
        User::factory()->create();
        TeamMember::factory([
            'type' => 'project_manager',
        ])->create();
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('team_members', 1);

        $data = [
            'message' => $this->faker->sentence(),
            'sender_id' => 123,
            'sender_type' => 'User',
            'recipient_id' => 123,
            'recipient_type' => 'TeamMember',
        ];

        $resp = $this->post(route('messages.store'), $data);
        $resp->assertNotFound();
    }

    /**
     * message from team member to team member.
     *
     * @covers \App\Http\Controllers\MessageController::store
     * @test
     */
    public function message_from_team_member_to_team_member(): void
    {
        TeamMember::factory()->count(2)->create();
        $this->assertDatabaseCount('team_members', 2);

        $first_team_member = TeamMember::where('id', '=', 1)->first() ?? null;
        $second_team_member = TeamMember::where('id', '=', 2)->first() ?? null;

        if ($first_team_member && $second_team_member) {
            $data = [
                'message' => $this->faker->sentence(),
                'sender_id' => $first_team_member['id'],
                'sender_type' => 'TeamMember',
                'recipient_id' => $second_team_member['id'],
                'recipient_type' => 'TeamMember',
        ];

            $resp = $this->post(route('messages.store'), $data);
            $resp->assertStatus(302);


            $this->assertInstanceOf(Message::class, $first_team_member->messages()->first());
            $this->assertInstanceOf(Message::class, $second_team_member->messages()->first());
        }
    }

    /**
     * send message from project manager to user.
     *
     * @covers \App\Http\Controllers\MessageController::store
     * @test
     */
    public function send_message_from_project_manager_to_user(): void
    {
        User::factory()->create();
        TeamMember::factory([
            'type' => 'project_manager',
        ])->create();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('team_members', 1);

        $user = User::where('id', '=', 1)->first() ?? null;
        $team_member = TeamMember::where('id', '=', 1)->first() ?? null;

        if ($user && $team_member) {

            $this->assertSame('project_manager', $team_member['type']);

            $data = [
                'message' => $this->faker->sentence(),
                'sender_id' => $team_member['id'],
                'sender_type' => 'TeamMember',
                'recipient_id' => $user['id'],
                'recipient_type' => 'User',
            ];

            $resp = $this->post(route('messages.store'), $data);
            $resp->assertStatus(302);

            $this->assertInstanceOf(Message::class, $user->messages()->first());
            $this->assertInstanceOf(Message::class, $team_member->messages()->first());
        }
    }

    /**
     * send message from user to project manager.
     *
     * @covers \App\Http\Controllers\MessageController::store
     * @test
     */
    public function send_message_from_user_to_project_manager(): void
    {
        User::factory()->create();
        TeamMember::factory([
            'type' => 'project_manager',
        ])->create();
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('team_members', 1);

        $user = User::where('id', '=', 1)->first() ?? null;
        $team_member = TeamMember::where('id', '=', '1')->first() ?? null;

        if ($user && $team_member) {
            $this->assertSame('project_manager', $team_member['type']);

            $data = [
                'message' => $this->faker->sentence(),
                'sender_id' => $user['id'],
                'sender_type' => 'User',
                'recipient_id' => $team_member['id'],
                'recipient_type' => 'TeamMember',
            ];

            $resp = $this->post(route('messages.store'), $data);
            $resp->assertStatus(302);
            $this->assertInstanceOf(Message::class, $user->messages()->first());
            $this->assertInstanceOf(Message::class, $team_member->messages()->first());
        }
    }


    /**
     * message index route.
     *
     * @covers \App\Http\Controllers\MessageController::index
     * @test
     */
    public function message_index_route(): void
    {
        $this->get(route('messages.index'))->assertOk();
    }

    /**
     * message create route.
     *
     * @covers \App\Http\Controllers\MessageController::create
     * @test
     */
    public function message_create_route(): void
    {
        $this->get(route('messages.create'))->assertOk();
    }

    /**
     * message show route.
     *
     * @covers \App\Http\Controllers\MessageController::show
     * @test
     */
    public function message_show_route(): void
    {
        Message::factory()->create();
        $this->assertDatabaseCount('messages', 1);
        $message = Message::first() ?? null;
        if ($message) {
            $this->get(route('messages.show', ['message' => $message['id'] ?? null]))->assertOk();
        }
    }


    /**
     * message update route.
     *
     * @covers \App\Http\Controllers\MessageController::update
     * @test
     */
    public function message_update_route(): void
    {
        Message::factory()->create();
        $this->assertDatabaseCount('messages', 1);
        $message = Message::first() ?? null;
        if ($message) {
            $this->put(route('messages.update', ['message' => $message['id'] ?? null]), [])->assertOk();
        }
    }

    /**
     * message destroy route.
     * @covers \App\Http\Controllers\MessageController::destroy
     * @test
     */
    public function message_destroy_route(): void
    {
        Message::factory()->create();
        $this->assertDatabaseCount('messages', 1);
        $message = Message::first() ?? null;
        if ($message) {
            $this->delete(route('messages.destroy', ['message' => $message['id'] ?? null]))->assertOk();
        }
    }

    /**
     * message edit route.
     *
     * @covers \App\Http\Controllers\MessageController::edit
     * @test
     */
    public function message_edit_route(): void
    {
        Message::factory()->create();
        $this->assertDatabaseCount('messages', 1);
        $message = Message::first() ?? null;
        if ($message) {
            $this->get(route('messages.edit', ['message' => $message['id'] ?? null]))->assertOk();
        }
    }
}
