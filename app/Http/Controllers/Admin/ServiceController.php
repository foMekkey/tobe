<?php

namespace App\Http\Controllers\Admin;
use App\Service;
use App\DataTables\ServiceDatatable;
use App\Http\Requests\ServiceRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class ServiceController extends Controller
{

    /**
     * @param ServiceDatatable $servicesDatatable
     * @return mixed
     */
    public function index(ServiceDatatable $servicesDatatable)
    {
        return $servicesDatatable->render('backend.services.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.services.create');
    }


    /**
     * @param ServiceRequest $servicesRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ServiceRequest $servicesRequest)
    {
        $data = $servicesRequest->only(['lang', 'title', 'desc', 'content']);
        if (isset($servicesRequest->image) ||  $servicesRequest->image != null) {
            $data['image'] = $servicesRequest->image->store('services');
        }
        
        Service::insert($data);

        return redirect('services')->with(['success' =>  __('pages.success-add')]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::find($id);

        return  view('backend.services.edit',compact('service'));
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
            'lang'=>'required',
            'title'=>'required',
            'desc'=>'required',
            'content'=>'required',
        ]);
        
        $data = $request->only(['lang', 'title', 'desc', 'content']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->image->store('services');
        }
        
        Service::where('id', $id)->update($data);

        return redirect('services')->with(['success' =>  __('pages.success-edit')]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $service = Service::find($id);

        $check = $service->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('pages.success-delete'));

        }
    }
}
