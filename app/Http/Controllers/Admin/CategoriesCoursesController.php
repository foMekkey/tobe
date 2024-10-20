<?php

namespace App\Http\Controllers\Admin;

use App\CategoiresCourses;
use App\DataTables\CategoriesCoursesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesCoursesRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        $categoriesCourses->lang      = $categoriesCoursesRequest->lang;
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
            'name' => [
                'required',
                Rule::unique('course_categories')->where(function ($query) use ($request, $id) {
                    return $query->where('name', $request->name)
                        ->where('lang', $request->lang)
                        ->where('id', '!=', $id);
                })
            ],

        ]);

        $categories = CategoiresCourses::find($id);
        $categories->name               = $request->name;
        $categories->lang               = $request->lang;
        $categories->update();

        return redirect('categories')->with(['success' => __('pages.success-edit')]);
    }


    public function destroy($id)
    {

        $categories = CategoiresCourses::find($id);
        if ($categories->courses()->count() > 0) {
            return response()->json(['message' => 'hasUsers', 'countUsers' => $categories->courses()->count(), 'countGroups' => $categories->courses()->count()]);
        }
        $check = $categories->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('success-delete'));
        }
    }
}