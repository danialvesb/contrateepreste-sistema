<?php

namespace App\Http\Controllers;

use App\Models\User\Solicitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $id = auth()->user()->id;

        $data = DB::table('solicitations')
            ->join('offers', 'solicitations.offer_id', '=', 'offers.id')
            ->join('services', 'offers.service_id', '=', 'services.id')
            ->select('solicitations.id', 'solicitations.status', 'solicitations.message as solicitation_message', 'offers.amount', 'offers.description as offer_description', 'services.title as type_service')
            ->where('solicitations.owner_id', '=', $id)
            ->get();
        //Foi necessário retornar o array, pois para fazer o map era necessário um, o $solicitations[0] não foi preciso.
        return response()->json($data);
    }

    public function calleds(){
        $id = auth()->user()->id;

        $data = DB::table('solicitations')
            ->join('offers', 'solicitations.offer_id', '=', 'offers.id')
            ->join('services', 'offers.service_id', '=', 'services.id')
            ->join('users', 'solicitations.owner_id', '=', 'users.id')
            ->select('users.name as customer','users.uf as uf_customer','users.city as city_customer',
                'users.district as district_customer', 'solicitations.id', 'solicitations.status',
                'solicitations.message as solicitation_message', 'offers.amount', 'offers.description as offer_description',
                'services.title as type_service')
            ->where([['offers.owner_id', '=', $id], ['solicitations.status', '=', 'pending']])
            ->get();

        return response()->json($data);
    }

    public function acceptCalled($id) {
        $idUser = auth()->user()->id;
        if ($idUser) {
            DB::table('solicitations')
                ->where('id', $id)
                ->update(['status' => 'accepted']);
        }

        return response()->json('called successfully agreed');
    }
    public function refuseCalled($id) {
        $idUser = auth()->user()->id;
        if ($idUser) {
            DB::table('solicitations')
                ->where('id', $id)
                ->update(['status' => 'denied']);
        }

        return response()->json('called successfully declined');
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

            $files = $request->json('files');
            //Files vai criar o registro em files depois criar a relação com solicitation

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
