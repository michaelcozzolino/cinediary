<?php

namespace App\Http\Controllers;

use App\Models\Diary;
use App\Traits\ScreenplayTypes;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DiariesController extends Controller
{
    use ScreenplayTypes;
    public const DELETE_ERROR_MESSAGE = 'you are trying to delete a main diary which cannot be deleted';
    public const DELETE_SUCCESS_MESSAGE = 'deleted';

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        $diaries = Diary::withCount($this->getScreenplayTypes())->get();

        return Inertia::render('Diaries/Index', compact('diaries'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'diaryName' => 'required',
        ]);

        Diary::withoutGlobalScope('userDiaries')->create([
            'name' => $request->input('diaryName'),
            'user_id' => \Auth::id(),
        ]);

        return redirect()->back();
    }

    /**
     * @param Diary $diary
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Diary $diary)
    {
        $message = $diary->delete() ? self::DELETE_SUCCESS_MESSAGE : self::DELETE_ERROR_MESSAGE;

        return redirect()
            ->back()
            ->with(compact('message'));
    }
}
