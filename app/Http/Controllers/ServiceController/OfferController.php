<?php

namespace App\Http\Controllers;


use App\Models\Service\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{

    /**
     * @var Offer
     */
    private $offers;

    public function __construct(Offer $offer)
    {
        $this->offers = $offer;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = DB::table('offers')
            ->join('services', 'offers.service_id', '=', 'services.id')
            ->join('users', 'offers.owner_id', '=', 'users.id')
            ->get();

        return response()->json($offers);
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
            $serviceId = $request->json('service_id');
            $ownerId =  $request->json('owner_id');
            $amount = $request->json('amount');
            $rating = $request->json('rating');
            $description = $request->json('description');

            $offerData = ['service_id'=>$serviceId,
                'owner_id'=>$ownerId,
                'amount'=>$amount,
                'rating'=>$rating,
                'description'=>$description];

            $offer =  $this->offers->create($offerData);

            $returns =  ['data' => ['message' => 'Serviço ofertado com sucesso']];
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
        $offers = DB::table('offers')
            ->join('services', 'offers.service_id', '=', 'services.id')
            ->join('users', 'offers.owner_id', '=', 'users.id')
            ->where('offers.id','=', $id)
            ->get();

        //Implementar o retorno apenas dos dados necessários.

        return response()->json($offers);

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
        try {
            $offer = $this->offers->all()->find($id);
            $offer->delete($offer);

            $return = ['data' => ['message' => 'Oferta deletada com sucesso']];

            return response()->json($return);
        }catch (\Exception $e) {
            response()->json($e->getMessage());
        }
    }
}
