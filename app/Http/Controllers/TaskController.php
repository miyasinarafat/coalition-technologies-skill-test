<?php

namespace App\Http\Controllers;

use App\Domain\Project\Project;
use App\Domain\Project\ProjectRepositoryInterface;
use App\Domain\Task\Task;
use App\Domain\Task\TaskListFactory;
use App\Domain\Task\TaskListRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository,
        private readonly TaskListRepositoryInterface $taskListRepository,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $project
     * @return Response
     */
    public function index(int $project): Response
    {
        /** @var Project $dbProject */
        $dbProject = $this->projectRepository->getById($project, Auth::id());
        $lists = $this->taskListRepository->getList($project);

        return Inertia::render('Tasks/Index', [
            'project' => $dbProject,
            'lists' => $lists,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param int $project
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function listStore(Request $request, int $project): RedirectResponse
    {
        $list = TaskListFactory::fromArray(
            array_merge(
                $request->all(),
                [
                    'project_id' => $project,
                ]
            )
        );
        $this->taskListRepository->create($list);

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $project
     * @param int $list
     * @return RedirectResponse
     */
    public function listDestroy(int $project, int $list): RedirectResponse
    {
        $this->taskListRepository->delete($project, $list);

        return redirect()->back();
    }
}
