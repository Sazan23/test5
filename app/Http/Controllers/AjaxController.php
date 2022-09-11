<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Records;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AjaxController extends Controller
{
    /**
     * Saving an edited entry.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateItem(Request $request)
    {
        $input = $request->all();
        $record = Records::find($input['record_id']);
        $record->record_name = $input['record_name'];
        $record->record_phone = $input['record_phone'];
        $record->record_email = $input['record_email'];
        $record->record_date = date('Y-m-d', strtotime($input['record_date']));
        $record->record_company = $input['record_company'];
        $record->record_city  = $input['record_city'];
        $record->record_region = $input['record_region'];
        $record->save();
        
        return response()->json(['success'=>'Запись сохранена']);
    }

    /**
     * Deleting one entry.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteItem(Request $request)
    {
        $input = $request->all();
        Records::where('id', $input['record_id'])->delete();

        return response()->json(['success'=>'Запись удалена','id'=>$input['record_id']]);
    }

    /**
     * Upload image.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function uploadImg(Request $request)
    {
        $resp = [];
        $validator = Validator::make($request->all(), [
            'p_file' => 'required|mimes:jpg,jpeg|max:4096'
        ]);

        if ($validator->fails()) {
            $resp["success"] = false;
            $resp["error"] = $validator->errors()->first('p_file');
        } else {
            $file = $request->file('p_file');
            $upload_folder = 'public' . DIRECTORY_SEPARATOR .'img';
            $id = $request->p_id;
            $filename = $id . '_' . $file->getClientOriginalName();
            Storage::putFileAs($upload_folder, $file, $filename);
            $record = Records::find($id);
            $record->record_img = $filename;
            $record->save();
            $resp["success"] = true;
            $resp["url"] = url('/storage/img/'. $filename);
            $resp["id"] = $id;
            $resp["message"] = "Файл загружен";
        }

        return response()->json($resp);
    }
}
