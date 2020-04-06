<?php

namespace App\Http\Controllers;

use App\Models\User\Solicitation;
use Illuminate\Http\Request;

class SolicitationController extends Controller
{
    private $solicitations;

    public function __construct(Solicitation $solicitation)
    {
        $this->solicitations = $solicitation;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $status = $request->json('status');
            $message =  $request->json('message');
            $ownerId = $request->json('owner_id');
            $offerId = $request->json('offer_id');

            $solicitationData = ['status'=>$status,
                'message'=>$message,
                'owner_id'=>$ownerId,
                'offer_id'=>$offerId];

            $solicitation =  $this->solicitations->create($solicitationData);

            $returns =  ['data' => ['message' => 'Oferta solicitada com sucesso']];
            return response()->json($returns, 201);

        }catch(\Exception $e) {
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
