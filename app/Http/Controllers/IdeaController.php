<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\Idea;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ideas = Auth::user()
            ->ideas()
            ->when(request('status'), fn($query) => $query->where('status', request('status')))
            ->get();

//        select status,count(*) from ideas group by status
        $statusCount = Auth::user()
            ->ideas()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')->pluck('count', 'status')
            ->put('all', Auth::user()->ideas()->count());

//        dd($statusCount);

        return view('idea.index', [
            'ideas' => $ideas,
            'statusCount' => $statusCount,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIdeaRequest $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea): void
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, Idea $idea): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea): void
    {
        //
    }
}
