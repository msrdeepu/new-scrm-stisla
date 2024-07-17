<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

trait FileUploadTrait
{

    public function uploadFile(Request $request, $inputName, ?string $oldPath = null, string $path = '/uploads')
    {
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);


            Log::info('File detected', [
                'original_name' => $file->getClientOriginalName(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getSize(),
            ]);

            $ext = $file->getClientOriginalExtension();
            $fileName = 'media_' . uniqid() . '.' . $ext;

            $destinationPath = public_path($path);


            if (!File::exists($destinationPath)) {
                if (!File::makeDirectory($destinationPath, 0755, true)) {
                    Log::error('Failed to create directory: ' . $destinationPath);
                    return null;
                }
            }


            if ($file->move($destinationPath, $fileName)) {
                Log::info('File moved successfully', ['path' => $path . '/' . $fileName]);
                return $path . '/' . $fileName;
            } else {
                Log::error('File could not be moved to destination path: ' . $destinationPath);
                return null;
            }
        }


        Log::error('No file found in the request for input name: ' . $inputName);
        return null;
    }
}
