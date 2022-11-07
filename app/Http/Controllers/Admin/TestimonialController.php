<?php

namespace App\Http\Controllers\Admin;
use App\Testimonial;
use App\User;
use App\DataTables\TestimonialDatatable;
use App\Http\Requests\TestimonialRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class TestimonialController extends Controller
{

    /**
     * @param TestimonialDatatable $testimonialsDatatable
     * @return mixed
     */
    public function index(TestimonialDatatable $testimonialsDatatable)
    {
        return $testimonialsDatatable->render('backend.testimonials.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::pluck('user_name', 'id')->toArray();
        return view('backend.testimonials.create', compact('users'));
    }


    /**
     * @param TestimonialRequest $testimonialsRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(TestimonialRequest $testimonialsRequest)
    {
        $data = $testimonialsRequest->only(['user_id', 'message', 'datetime']);
        $data['datetime'] = Carbon::createFromFormat('m/d/Y', $data['datetime']);
        Testimonial::insert($data);

        return redirect('testimonials')->with(['success' =>  __('pages.success-add')]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $testimonial = Testimonial::find($id);
        $users = User::pluck('user_name', 'id')->toArray();
        
        return  view('backend.testimonials.edit',compact('testimonial', 'users'));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'user_id'=>'required',
            'message'=>'required',
            'datetime'=>'required'
        ]);
        
        $data = $request->only(['user_id', 'message', 'datetime']);
        $data['datetime'] = Carbon::createFromFormat('m/d/Y', $data['datetime']);
        Testimonial::where('id', $id)->update($data);

        return redirect('testimonials')->with(['success' =>  __('pages.success-edit')]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);

        $check = $testimonial->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('pages.success-delete'));

        }
    }
}
