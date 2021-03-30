<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Newsletter;
use App\Exports\NewsletterExport;
use App\Services\Excel;
//use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class NewsletterController extends Controller
{

    public function index()
    {
        $emails = Newsletter::all();

        return view('admin.newsletter.index')->with('emails', $emails);
    }

    public function subscribe(Request $request)
    {
        $email = Newsletter::find($request->emailId);
        $email->active = intval($request->active);

        if ($email->save()) {
            return response()->json([
                "data" => "Subscripcion de email actualizada"
              ]);
        } else {
            return response()->json([
                "data" => "Error al actualizar subscripcion de email"
              ]);
        }
    }

    public function export()
    {
        //return Excel::download(new NewsletterExport, 'newsletter.xlsx');
        $headers = \Schema::getColumnListing('newsletter');

        $name = 'newsletter';

        $headers = ['id', 'email', 'activo', 'nombres'];
        $items = Newsletter::all()->toArray();
        $excel = new Excel;
        return $excel->export($headers, $items, $name);
    }

}
