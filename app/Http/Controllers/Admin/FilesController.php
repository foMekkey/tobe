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

        $file = $request->file('file');
        $files->url = $request->file->store('files');
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
        return "sss";
        $file = File::find($id);

        \Storage::disk('contabo')->delete(config("filesystems.disks.contabo.url") . '/' . $file->url);
        return config("filesystems.disks.contabo.url") . '/' . $file->url;
        $check = $file->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('pages.success-delete'));
        }
    }
}