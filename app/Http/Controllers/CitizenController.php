<?php

namespace App\Http\Controllers;

use App\Citizen;
use App\Http\Resources\CitizenResource;
use Illuminate\Http\Request;

class CitizenController extends Controller
{
    /**
     * @var Citizen
     */
    private $citizen;

    /**
     * CitizenController constructor.
     * @param Citizen $citizen
     */
    public function __construct(Citizen $citizen)
    {
        $this->citizen = $citizen;
    }

    public function index()
    {
        $citizens = $this->citizen->where('user_id',auth()->user()->id)->get();
        return CitizenResource::collection($citizens);
    }

    public function generate()
    {
        $qty = 300;

        $currentQty = auth()->user()->citizens()->count();

        if ( $currentQty <= $qty) {
            factory(\App\Citizen::class, ($qty - $currentQty))->create([
                'user_id' => auth()->user()->id,
            ]);

            return response()->json([
                'message' => 'Dados gerados com sucesso'
            ]);
        }else{
            abort(403,'Já foram gerando muitos dados para esse usuário');
        }
    }
}
