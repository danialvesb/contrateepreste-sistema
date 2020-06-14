<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Lib\PusherFactory;
use App\Models\User\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return string[]
     */
    public function sendMessage(Request $request)
    {
        $message = new Message();

        $dataRec = $request->all();

        $text = isset($dataRec['text']) ? $dataRec['text'] : '';
        $solicitationId = isset($dataRec['solicitation_id']) ? $dataRec['solicitation_id'] : '';
        $fromUser = isset($dataRec['from_user']) ? $dataRec['from_user'] : '';
        $toUser =  isset($dataRec['to_user']) ? $dataRec['to_user'] : '';

        $message->fill(['text' => $text, 'solicitation_id' => $solicitationId, 'from_user' => $fromUser, 'to_user' => $toUser]);
        $message->save();

        broadcast(new MessageSent($message));

        return ['status' => 'Message Sent!'];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
