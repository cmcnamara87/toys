<?php

namespace App\Http\Controllers;

use App\Cluster;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ClustersController extends Controller
{
    //
    public function index() {
        $clusters = Cluster::whereHas('items', function ($query) {
            $query->where('end_time', '>', Carbon::now());
        })->with(['items' => function ($query) {
            $query->where('end_time', '>', Carbon::now());
            $query->orderBy('end_time', 'asc');
        }])->paginate(39);
        return view('clusters.index', compact('clusters'));
    }

    public function show($id) {
        $cluster = Cluster::where('id', $id)->with(['items' => function ($query) use ($id) {
            $query->where('end_time', '>', Carbon::now());
        }])->first();
        return view('clusters.show', compact('cluster'));
    }

}
