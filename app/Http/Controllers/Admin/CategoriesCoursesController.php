<?php

namespace App\Http\Controllers\Admin;

use App\CategoiresCourses;
use App\DataTables\CategoriesCoursesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesCoursesRequest;
use Illuminate\Http\Request;
use Response;

class CategoriesCoursesController extends Controller
{
    public function index(CategoriesCoursesDataTable $categoriesCoursesDataTable)
    {
        return $categoriesCoursesDataTable->render('backend.categories.index');
    }

    public function create()
    {

        return view('backend.categories.create');
    }

    public function store(CategoriesCoursesRequest $categoriesCoursesRequest)
    {

        $categoriesCourses = new CategoiresCourses();
        $categoriesCourses->name      = $categoriesCoursesRequest->name;
        $categoriesCourses->save();

        return redirect('categories')->with(['success' => __('pages.success-add')]);
    }

    public function edit($id)
    {
        $categories = CategoiresCourses::find($id);
        return  view('backend.categories.edit', compact('categories'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
        ]);

        $categories = CategoiresCourses::find($id);
        $categories->name               = $request->name;
        $categories->update();

        return redirect('categories')->with(['success' => __('pages.success-edit')]);
    }


    public function destroy($id)
    {

        $categories = CategoiresCourses::find($id);
        if ($categories->courses()->count() > 0) {
            return response()->json(['message' => 'hasUsers', 'countUsers' => $categories->courses()->count() > 0, 'countGroups' => $categories->courses()->count() > 0]);
        }
        $check = $categories->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('success-delete'));
        }
    }
}