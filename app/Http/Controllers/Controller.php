<?php

namespace App\Http\Controllers;

use App\Models\Export;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getDownload()
    {
        $file = Export::find(1);
        if ($file) {
            $headers = array(
                'Content-Type: application/pdf',
            );
            return Response::download(public_path($file->file), 'panduan.pdf', $headers);
        }
        return redirect()->back();
    }
    public function saveDownload(Request $request)
    {
        if ($request->file('file')) {
            $newFilename = $request->file('file')->store('public/file');
            $url = Storage::url($newFilename);

            Export::updateOrCreate(
                [
                    'id' => 1,
                ],
                [
                    'file' => $url
                ],
            );
        }
        return redirect()->back();
    }
}
