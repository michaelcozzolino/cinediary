<?php

namespace App\Http\Controllers;

use App\Http\Requests\Diaries\Store\Request as StoreDiaryRequest;
use App\Models\Diary;
use App\Repositories\DiaryRepository;
use App\Responses\Diaries\Index as IndexResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DiaryController extends Controller
{
    public function __construct(protected DiaryRepository $diaryRepository)
    {
    }

    public function index(): InertiaResponse
    {
        return inertia()->render(
            'Diaries/Index',
            new IndexResponse(
                $this->diaryRepository->getAllWithScreenplayCountByUser(auth()->id())
            )
        );
    }

    public function store(StoreDiaryRequest $request): RedirectResponse
    {
        $this->diaryRepository->create([
            'name' => $request->diaryName,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back();
    }

    public function destroy(Diary $diary): RedirectResponse
    {
        if ($this->diaryRepository->delete($diary)) {
            return redirect()
                ->back();
        }

        throw new BadRequestHttpException(
            sprintf('The diary `%u` cannot be deleted.', $diary->id)
        );
    }
}
