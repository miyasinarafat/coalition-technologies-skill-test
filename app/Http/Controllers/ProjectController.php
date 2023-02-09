<?php

namespace App\Http\Controllers;

use App\Domain\Project\Project;
use App\Domain\Project\ProjectFactory;
use App\Domain\Project\ProjectRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $projects = $this->projectRepository->getList(Auth::id());

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Projects/Create');
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
        $project = ProjectFactory::fromArray($request->all());
        $this->projectRepository->create($project);

        return redirect()
            ->route('dashboard')
            ->with('status', 'Project successfully created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Project $project
     * @return RedirectResponse|Response
     */
    public function edit(Project $project): Response|RedirectResponse
    {
        if ($project->user_id !== Auth::id()) {
            return redirect()
                ->route('dashboard')
                ->withErrors(["You're not allowed to access this project"]);
        }

        return Inertia::render('Projects/Edit', [
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Project $project
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        $candidateProject = ProjectFactory::fromArray($request->all());
        $this->projectRepository->update($project, $candidateProject);

        return redirect()
            ->route('dashboard')
            ->with('status', 'Project successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return RedirectResponse
     */
    public function destroy(Project $project): RedirectResponse
    {
        if ($project->user_id !== Auth::id()) {
            return redirect()
                ->route('dashboard')
                ->withErrors(["You're not allowed to access this project"]);
        }

        $this->projectRepository->delete($project);

        return redirect()
            ->route('dashboard')
            ->with('status', 'Project successfully deleted');
    }
}
