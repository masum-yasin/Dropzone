<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class FileUploadController extends Controller
{
    // public function file()
    // {
    //     $files = FileUpload::all();
    //     return Inertia::render('Create', ['files' => $files]);
    // }

    // public function upload(Request $request)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'files.*' => 'required|file|mimes:jpeg,jpg,png,gif,pdf,doc,docx|max:10240', // Example validation rules
    //     ]);

    //     $uploadedFiles = [];

    //     foreach ($request->file('files') as $file) {
    //         $imageName = time() . '_' . $file->getClientOriginalName(); // Ensure unique filenames
    //         $file->move(public_path('images'), $imageName); // Move file to images directory

    //         $uuid = IdGenerator::generate(['table' => 'file_uploads', 'field' => 'uuid', 'length' => 7, 'prefix' => 'File-']);

    //         $imageUpload = new FileUpload();
    //         $imageUpload->uuid = $uuid;
    //         $imageUpload->fileName = $imageName;
    //         $imageUpload->save();

    //         $uploadedFiles[] = $imageName; // Store the uploaded filenames
    //     }

    //     return response()->json(['success' => true, 'files' => $uploadedFiles]); // Return success with uploaded filenames
    // }

    // public function upload(Request $request)
    // {
    //     // Validate the request
    //     $validator = Validator::make($request->all(), [
    //         'files.*' => 'required|file|mimes:jpeg,jpg,png,gif,pdf,doc,docx|max:10240', // Example validation rules
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()->first()], 400);
    //     }

    //     // Handle multiple file uploads
    //     foreach ($request->file('files') as $file) {
    //         // Ensure the 'images' directory exists in public path
    //         $imagename = time() . '.' . $file->extension();
    //         $file->move(public_path('images'), $imagename);

    //         // Generate UUID for each file
    //         $uuid = IdGenerator::generate(['table' => 'FileUploads', 'field' => 'uuid', 'length' => 7, 'prefix' => 'File-']);

    //         // Save file details to database
    //         $imageupload = new FileUpload();
    //         $imageupload->unid = $uuid;
    //         $imageupload->fileName = $imagename;
    //         $imageupload->save();
    //     }

    //     return response()->json(['success' => 'Files uploaded successfully']);
    // }

    public function file()
    {
        // $files = FileUpload::all();
        return Inertia::render('Create');  //, ['files' => $files]
    }

    public function upload(Request $request)
    {
        // Validate the request
        $request->validate([
            'files.*' => 'required|file|mimes:jpeg,jpg,png,gif,pdf,doc,docx|max:10240', // Example validation rules
        ]);

        foreach ($request->file('files') as $file) {
            // Generate a unique ID
            $uuid = IdGenerator::generate(['table' => 'FileUploads', 'field' => 'uuid', 'length' => 7, 'prefix' => 'File-']);

            // Move the file to the public directory
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $imageName);

            // Save the file details to the database
            $fileUpload = new FileUpload();
            $fileUpload->unid = $uuid;
            $fileUpload->fileName = $imageName;
            $fileUpload->save();
        }

        // Return a success response
        return response()->json(['message' => 'Files uploaded successfully']);
    }

}
