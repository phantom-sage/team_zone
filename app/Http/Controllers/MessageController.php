<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\TeamMember;
use App\Models\User;

class MessageController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        return 'index';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return string
     */
    public function create()
    {
        return 'create';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMessageRequest $request
     * @return string
     */
    public function store(StoreMessageRequest $request)
    {
        $data = $request->safe(['message', 'sender_id', 'recipient_id', 'sender_type', 'recipient_type']);
        $message = new Message();
        $message['message'] = $data['message'];
        $message->save();

        if ($data['sender_type'] == 'User' && $data['recipient_type'] == 'TeamMember') {
            $user = User::where('id', '=', $data['sender_id'])->first() ?? null;
            $team_member = TeamMember::where('id', '=', $data['recipient_id'])->first() ?? null;
            if ($user && $team_member) {
                $user->messages()->attach($message['id']);
                $team_member->messages()->attach($message['id']);
                session()->flash('flash.banner', 'Send successfully');
                session()->flash('flash.bannerStyle', 'success');
                return back();
            } else {
                abort(404, 'NOT FOUND');
            }
        } elseif ($data['sender_type'] == 'TeamMember' && $data['recipient_type'] == 'User') {
            $team_member = TeamMember::where('id', '=', $data['sender_id'])->first() ?? null;
            $user = User::where('id', '=', $data['recipient_id'])->first() ?? null;
            if ($user && $team_member) {
                $team_member->messages()->attach($message['id']);
                $user->messages()->attach($message['id']);
                session()->flash('flash.banner', 'Send successfully');
                session()->flash('flash.bannerStyle', 'success');
                return back();
            } else {
                abort(404, 'NOT FOUND');
            }
        } elseif ($data['sender_type'] == 'TeamMember' && $data['recipient_type'] == 'TeamMember') {
            $first_team_member = TeamMember::where('id', '=', $data['sender_id'])->first() ?? null;
            $second_team_member = TeamMember::where('id', '=', $data['recipient_id'])->first() ?? null;
            if ($first_team_member && $second_team_member) {
                $first_team_member->messages()->attach($message['id']);
                $second_team_member->messages()->attach($message['id']);
                session()->flash('flash.banner', 'Send successfully');
                session()->flash('flash.bannerStyle', 'success');
                return back();
            } else {
                abort(404, 'NOT FOUND');
            }
        }
        return abort(404, 'NOT FOUND');
    }

    /**
     * Display the specified resource.
     *
     * @param Message $message
     * @return string
     */
    public function show(Message $message)
    {
        return 'show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Message $message
     * @return string
     */
    public function edit(Message $message)
    {
        return 'edit';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMessageRequest $request
     * @param Message $message
     * @return string
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        return 'update';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Message $message
     * @return string
     */
    public function destroy(Message $message)
    {
        return 'destroy';
    }
}
