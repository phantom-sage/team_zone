<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Client;
use App\Models\Hr;
use App\Models\Message;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class MessageTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;


    /**
     * team member have messages.
     *
     * @test
     */
    public function team_member_have_messages(): void
    {
        TeamMember::factory()->create();
        $this->assertDatabaseCount('team_members', 1);

        $message = new Message();
        $message['message'] = $this->faker->sentence();
        $message->save();
        $this->assertDatabaseCount('messages', 1);

        $team_member = TeamMember::first() ?? null;
        if ($team_member) {
            $team_member->messages()->attach($message['id']);
            $this->assertInstanceOf(Message::class, $team_member->messages()->first());
        }
    }

    /**
     * user have messages.
     *
     * @test
     */
    public function user_have_messages(): void
    {
        User::factory()->create();
        $this->assertDatabaseCount('users', 1);

        $message = new Message();
        $message['message'] = $this->faker->sentence();
        $message->save();
        $this->assertDatabaseCount('messages', 1);

        $user = User::first() ?? null;
        if ($user) {
            $user->messages()->attach($message['id']);
            $this->assertInstanceOf(Message::class, $user->messages()->first());
        }
    }
}
