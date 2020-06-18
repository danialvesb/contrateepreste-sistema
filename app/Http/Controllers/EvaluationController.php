<?php

namespace App\Http\Controllers;

use App\Models\Service\Offer;
use App\Models\User\Evaluation;
use App\Models\User\Solicitation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function sendEvaluate(Request $request)
    {
        $data = $request->all();
        $evaluation = new Evaluation();

        $evaluation->fill(['comment' => $data['comment'],
            'rating' => $data['rating'],
            'reply' => '0',
            'solicitation_id' => $data['solicitation_id']]);
        $evaluation->save();

        DB::table('solicitations')
            ->where('id', $data['solicitation_id'])
            ->update(['is_evaluate' => '1']);

        $qtdEvaluations = DB::table('evaluations')
            ->select('evaluations.id')
            ->join('solicitations', 'evaluations.solicitation_id', '=', 'solicitations.id')
            ->join('offers', 'offers.id', '=', 'solicitations.offer_id')
            ->get()->count();

        $sumRating = DB::table('evaluations')
            ->select('evaluations.rating')
            ->join('solicitations', 'evaluations.solicitation_id', '=', 'solicitations.id')
            ->join('offers', 'offers.id', '=', 'solicitations.offer_id')
            ->sum('evaluations.rating');

        $offerId = DB::table('evaluations')
            ->select('offers.id')
            ->join('solicitations', 'evaluations.solicitation_id', '=', 'solicitations.id')
            ->join('offers', 'offers.id', '=', 'solicitations.offer_id')
            ->first();


        $newRating = $sumRating / $qtdEvaluations;


        $numberFormat = strval(number_format($newRating, 1, '.',''));
        DB::table('offers')
            ->where('id', $offerId->id)
            ->update(['rating' => $numberFormat]);

        print_r($numberFormat);exit();
    }

    public function sendReply(Request $request)
    {
        $data = $request->all();

        DB::table('evaluations')
            ->where('id', $data['evaluation_id'])
            ->update(['reply' => $data['reply']]);

        return response(['status' => 'success']);
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
