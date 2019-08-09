<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatBook;
use App\Http\Resources\StatBookResource;
use App\Http\Resources\StatDateMountResource;
use App\Http\Resources\StatDateYearResource;
use App\Http\Resources\StatResource;
use App\Journal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookStatController extends Controller
{
    /**
     * @var \App\Services\JournalStatService
     */
   // protected $service;

    /**
     * BookStatController constructor.
     *
     * @param \App\Services\JournalStatService $service
     */
//    public function __construct(JournalStatService $service)
//    {
//        $this->service = $service;
//    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function __invoke(StatBook $request)
    {
        $stat = Journal::getData($request);
        return response()->json($stat);
    }
}
