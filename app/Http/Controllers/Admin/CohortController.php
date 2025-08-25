<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CohortsDataTable;
use App\Http\Requests\CreateCohortRequest;
use App\Http\Requests\UpdateCohortRequest;
use App\Repositories\CohortRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CohortsExport;
use App\User;
use App\DataTables\CohortTraineesDataTable;
use App\Models\Cohort;

class CohortController extends AppBaseController
{
    /** @var CohortRepository $cohortRepository */
    private $cohortRepository;

    public function __construct(CohortRepository $cohortRepo)
    {
        $this->cohortRepository = $cohortRepo;
    }

    /**
     * Display a listing of the Cohort.
     *
     * @param CohortsDataTable $cohortDataTable
     * @return Response
     */
    public function index(CohortsDataTable $cohortDataTable)
    {
        return $cohortDataTable->render('admin.cohorts.index');
    }

    /**
     * Show the form for creating a new Cohort.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.cohorts.create');
    }

    /**
     * Store a newly created Cohort in storage.
     *
     * @param CreateCohortRequest $request
     *
     * @return Response
     */
    public function store(CreateCohortRequest $request)
    {
        $input = $request->all();

        $cohort = $this->cohortRepository->create($input);

        Flash::success('تم إنشاء الفوج بنجاح.');

        return redirect(route('cohorts.index'));
    }

    /**
     * Display the specified Cohort.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id, CohortTraineesDataTable $dataTable)
    {
        $cohort = $this->cohortRepository->find($id);

        if (empty($cohort)) {
            Flash::error('الفوج غير موجود');

            return redirect(route('cohorts.index'));
        }

        return $dataTable->with('cohortId', $id)->render('admin.cohorts.show', compact('cohort'));
    }

    /**
     * Show the form for editing the specified Cohort.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cohort = $this->cohortRepository->find($id);

        if (empty($cohort)) {
            Flash::error('الفوج غير موجود');

            return redirect(route('cohorts.index'));
        }

        return view('admin.cohorts.edit')->with('cohort', $cohort);
    }

    /**
     * Update the specified Cohort in storage.
     *
     * @param  int              $id
     * @param UpdateCohortRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCohortRequest $request)
    {
        $cohort = $this->cohortRepository->find($id);

        if (empty($cohort)) {
            Flash::error('الفوج غير موجود');

            return redirect(route('cohorts.index'));
        }

        $cohort = $this->cohortRepository->update($request->all(), $id);

        Flash::success('تم تحديث الفوج بنجاح.');

        return redirect(route('cohorts.index'));
    }

    /**
     * Remove the specified Cohort from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cohort = $this->cohortRepository->find($id);

        if (empty($cohort)) {
            Flash::error('الفوج غير موجود');

            return redirect(route('cohorts.index'));
        }

        $this->cohortRepository->delete($id);

        Flash::success('تم حذف الفوج بنجاح.');

        return redirect(route('cohorts.index'));
    }

    /**
     * Get available trainees for a cohort
     *
     * @param int $id
     * @return Response
     */
    public function getAvailableTrainees($id)
    {
        $cohort = $this->cohortRepository->find($id);

        if (empty($cohort)) {
            return response()->json(['error' => 'الفوج غير موجود'], 404);
        }

        // Get users with role 'student' who are not already in this cohort
        $trainees = User::whereHas('roles', function ($q) {
            $q->where('role', 'متعلم');
        })->whereDoesntHave('courseRegistrations', function ($q) use ($id) {
            $q->where('cohort_id', $id);
        })->get(['id', 'user_name']);

        return response()->json($trainees);
    }

    /**
     * Add trainee to cohort
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function addTrainee(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $cohort = $this->cohortRepository->find($id);

        if (empty($cohort)) {
            Flash::error('الفوج غير موجود');
            return redirect(route('cohorts.show', $id));
        }

        if (!$cohort->hasAvailableSlots()) {
            Flash::error('الفوج ممتلئ ولا يمكن إضافة متدربين جدد');
            return redirect(route('cohorts.show', $id));
        }

        // Check if user is already in this cohort
        if ($cohort->trainees()->where('user_id', $request->user_id)->exists()) {
            Flash::error('المتدرب موجود بالفعل في هذا الفوج');
            return redirect(route('cohorts.show', $id));
        }

        $cohort->registrations()->create(['user_id' => $request->user_id, 'status' => 'approved', 'course_id' => 23]);

        Flash::success('تم إضافة المتدرب إلى الفوج بنجاح');

        return redirect(route('cohorts.show', $id));
    }

    /**
     * Remove trainee from cohort
     *
     * @param int $cohortId
     * @param int $userId
     * @return Response
     */
    public function removeTrainee($cohortId, $userId)
    {
        $cohort = $this->cohortRepository->find($cohortId);

        if (empty($cohort)) {
            Flash::error('الفوج غير موجود');
            return redirect(route('cohorts.index'));
        }

        $cohort->registrations()->whereUserId($userId)->delete();

        Flash::success('تم إزالة المتدرب من الفوج بنجاح');

        return redirect(route('cohorts.show', $cohortId));
    }

    public function export()
    {
        return Excel::download(new CohortsExport, 'cohorts.xlsx');
    }

    public function exportTrainees($id)
    {
        $cohort = Cohort::findOrFail($id);

        // Check if the cohort exists and has a name
        $filename = 'متدربين_' . ($cohort->name ? str_replace(' ', '_', $cohort->name) : $id) . '_' . date('Y-m-d') . '.xlsx';

        return Excel::download(new \App\Exports\CohortTraineesExport($id), $filename);
    }
}
