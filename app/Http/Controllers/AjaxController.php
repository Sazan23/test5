<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Records;

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
}
