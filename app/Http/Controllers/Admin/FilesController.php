<?php

namespace App\Http\Controllers\Admin;

use App\File;
use App\Groups;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;

class FilesController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $group)
    {

        $files = File::find($id);
        \Storage::disk('contabo')->delete($files->url);

        $file = $request->file('file');
        $files->url = $request->file->storePublicly(
            path: 'groups/images',
            options: 'contabo'
        );
        $files->extension = $file->getClientOriginalExtension();
        $files->file_size = $file->getSize();
        $files->mime = $file->getMimeType();
        $files->name = $file->getClientOriginalName();
        $files->group_id = $group;
        $files->update();

        return redirect()->back()->with(['success' =>  __('pages.success-add')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = File::find($id);

        \Storage::disk('contabo')->delete($file->url);
        $check = $file->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('pages.success-delete'));
        }
    }
}