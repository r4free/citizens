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
        $citizens = $this->citizen->get();
        return CitizenResource::collection($citizens);
    }
}
