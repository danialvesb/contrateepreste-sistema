<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Lib\PusherFactory;
use App\Models\User\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ChatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $id = auth()->user()->id;

        $data = DB::table('solicitations')
            ->join('offers', 'solicitations.offer_id', '=', 'offers.id')
            ->join('services', 'offers.service_id', '=', 'services.id')
            ->join('users as users_offer', 'users_offer.id', '=', 'offers.owner_id')
            ->join('users as users_solicitation', 'users_solicitation.id', '=', 'solicitations.owner_id')
            ->select('solicitations.id', 'solicitations.status', 'users_offer.name as owner_offer_name', 'users_solicitation.name as owner_solicitation_name'
                ,'users_offer.photo as owner_offer_photo', 'users_solicitation.photo as owner_solicitation_photo', 'users_offer.id as owner_offer_id')
            ->where([['solicitations.owner_id', '=', $id], ['solicitations.status', '!=', 'denied'], ['solicitations.status', '!=', 'closed']])
            ->orWhere([['offers.owner_id', '=', $id]])
            ->get();
        //Foi necessário retornar o array, pois para fazer o map era necessário um, o $solicitations[0] não foi preciso.
        return response()->json($data);

    }

    /**
     * Display a listing of the resource.
     *
     * @param $solicitation
     * @return void
     */
    public function fetchMessages($solicitation) {
        $id = auth()->user()->id;

        $data = DB::table('messages')
            ->join('solicitations', 'solicitations.id', '=', 'messages.solicitation_id')
            ->join('users as user_from', 'user_from.id', '=', 'messages.from_user')
            ->join('users as user_to', 'user_to.id', '=', 'messages.to_user')
            ->select('messages.id', 'messages.from_user', 'messages.to_user', 'user_from.name as from_user_name', 'user_to.name as to_user_name', 'messages.text',
                'messages.solicitation_id', 'messages.created_at', 'user_from.photo as from_user_avatar', 'user_to.photo as to_user_avatar')
            ->where([['solicitations.id', '=', $solicitation]])->orderBy('messages.id', 'DESC')
            ->get();


        //Foi necessário retornar o array, pois para fazer o map era necessário um, o $solicitations[0] não foi preciso.
        return response()->json($data);
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
        $fromUserId = isset($dataRec['from_user']) ? $dataRec['from_user'] : '';
        $toUser =  isset($dataRec['to_user']) ? $dataRec['to_user'] : '';

        $fromUser = User::all()->find($fromUserId);

        $message->fill(['text' => $text, 'solicitation_id' => $solicitationId, 'from_user' => $fromUserId, 'to_user' => $toUser,]);
        $message->save();
        $notification = [
            'text' => $text, 'solicitation_id' => $solicitationId, 'from_user' => $fromUserId, 'to_user' => $toUser,
            'from_user_name' => $fromUser->name, 'from_user_avatar' => $fromUser->photo
        ];
        broadcast(new MessageSent($notification));

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
