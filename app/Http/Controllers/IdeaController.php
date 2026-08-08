<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\IdeaStatus;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ideas = Auth::user()
            ->ideas()
            ->when(
                in_array($request->status, IdeaStatus::values()),
                fn ($query) => $query->where('status', request('status')))
            ->latest()
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
    public function store(StoreIdeaRequest $request, User $user)
    {
        //        dd(request()->all());
        Auth::user()->ideas()->create($request->validated());

        return to_route('idea.index')
            ->with('success', 'Idea was created.');
    }

    //    this automatically get the intended idea using the id in the url
    public function show(Idea $idea)
    {
        return view('idea.show', [
            'idea' => $idea,
        ]);
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
    public function destroy(Idea $idea)
    {
        //        autherize that the user is allowed to delete

        $idea->delete();

        return to_route('idea.index');
    }
}
