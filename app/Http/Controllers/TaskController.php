<?php

namespace App\Http\Controllers;

use App\Domain\Project\Project;
use App\Domain\Project\ProjectRepositoryInterface;
use App\Domain\Task\Task;
use App\Domain\Task\TaskFactory;
use App\Domain\Task\TaskListFactory;
use App\Domain\Task\TaskListRepositoryInterface;
use App\Domain\Task\TaskRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

final class TaskController extends Controller
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository,
        private readonly TaskListRepositoryInterface $taskListRepository,
        private readonly TaskRepositoryInterface $taskRepository,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $project
     * @param int|null $task
     * @return RedirectResponse|Response
     */
    public function index(int $project, int $task = null): Response|RedirectResponse
    {
        /** @var Project $dbProject */
        $dbProject = $this->projectRepository->getById($project, Auth::id());

        if (! $dbProject) {
            return redirect()
                ->route('dashboard')
                ->withErrors(["You're not allowed to access this project"]);
        }

        $lists = $this->taskListRepository->getList($project);

        if ($task) {
            $dbTask = $this->taskRepository->getById($project, $task);
        }

        return Inertia::render('Tasks/Index', [
            'project' => $dbProject,
            'lists' => $lists,
            'task' => $dbTask ?? null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function listStore(Request $request): RedirectResponse
    {
        $list = TaskListFactory::fromArray(array_merge($request->all(), ['user_id' => Auth::id()]));
        $this->taskListRepository->create($list);

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $task = TaskFactory::fromArray(array_merge($request->all(), ['user_id' => Auth::id()]));
        $this->taskRepository->create($task);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $project
     * @param int $task
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $project, int $task): RedirectResponse
    {
        $candidateTask = TaskFactory::fromArray(array_merge($request->all(), ['user_id' => Auth::id()]));
        /** @var Task $dbTask */
        $dbTask = $this->taskRepository->getById($project, $task);
        $this->taskRepository->update($dbTask, $candidateTask);

        if ($request->has('redirectUrl')) {
            return redirect($request->input('redirectUrl'));
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $project
     * @param int $task
     * @return RedirectResponse
     */
    public function move(Request $request, int $project, int $task): RedirectResponse
    {
        $validData = $request->validate([
            'list_id' => 'required|integer|exists:App\Domain\Task\TaskList,id',
            'position' => 'required|numeric',
        ]);

        /** @var Task $dbTask */
        $dbTask = $this->taskRepository->getById($project, $task);
        $this->taskRepository->move($dbTask, $validData['list_id'], $validData['position']);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $project
     * @param int $list
     * @param int $task
     * @return RedirectResponse
     */
    public function destroy(int $project, int $list, int $task): RedirectResponse
    {
        $deletedTask = $this->taskRepository->delete($project, $list, $task);

        if (! $deletedTask) {
            return redirect()
                ->route('projects.tasks.index', $project)
                ->withErrors(["Something went wrong, please try again!"]);
        }

        return redirect()
            ->route('projects.tasks.index', $project);
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
