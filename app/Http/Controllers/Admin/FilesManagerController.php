<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class FilesManagerController extends Controller
{
    //
    public function show()
    {
        $response = Gate::inspect('browse-files');
        if ($response->allowed()) {
            return view('admin.files.files-manager');
        }
        abort(403,$response->message());
    }
}



























































































// <?php

// namespace Alexusmai\LaravelFileManager\Controllers;

// use Alexusmai\LaravelFileManager\Events\BeforeInitialization;
// use Alexusmai\LaravelFileManager\Events\Deleting;
// use Alexusmai\LaravelFileManager\Events\DirectoryCreated;
// use Alexusmai\LaravelFileManager\Events\DirectoryCreating;
// use Alexusmai\LaravelFileManager\Events\DiskSelected;
// use Alexusmai\LaravelFileManager\Events\Download;
// use Alexusmai\LaravelFileManager\Events\FileCreated;
// use Alexusmai\LaravelFileManager\Events\FileCreating;
// use Alexusmai\LaravelFileManager\Events\FilesUploaded;
// use Alexusmai\LaravelFileManager\Events\FilesUploading;
// use Alexusmai\LaravelFileManager\Events\FileUpdate;
// use Alexusmai\LaravelFileManager\Events\Paste;
// use Alexusmai\LaravelFileManager\Events\Rename;
// use Alexusmai\LaravelFileManager\Events\Zip as ZipEvent;
// use Alexusmai\LaravelFileManager\Events\Unzip as UnzipEvent;
// use Alexusmai\LaravelFileManager\Requests\RequestValidator;
// use Alexusmai\LaravelFileManager\FileManager;
// use Alexusmai\LaravelFileManager\Services\Zip;
// use Illuminate\Routing\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Gate;


// class FileManagerController extends Controller
// {
//     /**
//      * @var FileManager
//      */
//     public $fm;

//     /**
//      * FileManagerController constructor.
//      *
//      * @param FileManager $fm
//      */
//     public function __construct(FileManager $fm)
//     {
//         $this->fm = $fm;

//     }

//     /**
//      * Initialize file manager
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function initialize()
//     {
//         event(new BeforeInitialization());

//         return response()->json(
//             $this->fm->initialize()
//         );
//     }

//     /**
//      * Get files and directories for the selected path and disk
//      *
//      * @param RequestValidator $request
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function content(RequestValidator $request)
//     {
//         return response()->json(
//             $this->fm->content(
//                 $request->input('disk'),
//                 $request->input('path')
//             )
//         );
//     }

//     /**
//      * Directory tree
//      *
//      * @param RequestValidator $request
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function tree(RequestValidator $request)
//     {
//         return response()->json(
//             $this->fm->tree(
//                 $request->input('disk'),
//                 $request->input('path')
//             )
//         );
//     }

//     /**
//      * Check the selected disk
//      *
//      * @param RequestValidator $request
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function selectDisk(RequestValidator $request)
//     {
//         event(new DiskSelected($request->input('disk')));

//         return response()->json([
//             'result' => [
//                 'status'  => 'success',
//                 'message' => 'diskSelected',
//             ],
//         ]);
//     }

//     /**
//      * Upload files
//      *
//      * @param RequestValidator $request
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function upload(RequestValidator $request)
//     {
//         $authorization =  Gate::inspect('add-files');

//         if ($authorization->allowed()) {

//             event(new FilesUploading($request));

//             $uploadResponse = $this->fm->upload(
//                 $request->input('disk'),
//                 $request->input('path'),
//                 $request->file('files'),
//                 $request->input('overwrite')
//             );

//             event(new FilesUploaded($request));

//             return response()->json($uploadResponse);
//         } else {
//             return [
//                 'result' => [
//                     'status'  => 'error',
//                     'message' => $authorization->message(),
//                 ],
//             ];
//         }
//     }

//     /**
//      * Delete files and folders
//      *
//      * @param RequestValidator $request
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function delete(RequestValidator $request)
//     {
//         $authorization =  Gate::inspect('delete-files');

//         if ($authorization->allowed()) {

//             event(new Deleting($request));

//             $deleteResponse = $this->fm->delete(
//                 $request->input('disk'),
//                 $request->input('items')
//             );

//             return response()->json($deleteResponse);
//         } else {
//             return [
//                 'result' => [
//                     'status'  => 'error',
//                     'message' => $authorization->message(),
//                 ],
//             ];
//         }
//     }

//     /**
//      * Copy / Cut files and folders
//      *
//      * @param RequestValidator $request
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function paste(RequestValidator $request)
//     {
//         $authorization =  Gate::inspect('edit-files');

//         if ($authorization->allowed()) {

//             event(new Paste($request));

//             return response()->json(
//                 $this->fm->paste(
//                     $request->input('disk'),
//                     $request->input('path'),
//                     $request->input('clipboard')
//                 )
//             );
//         } else {
//             return [
//                 'result' => [
//                     'status'  => 'error',
//                     'message' => $authorization->message(),
//                 ],
//             ];
//         }
//     }

//     /**
//      * Rename
//      *
//      * @param RequestValidator $request
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function rename(RequestValidator $request)
//     {
//         $authorization =  Gate::inspect('edit-files');

//         if ($authorization->allowed()) {
//             event(new Rename($request));

//             return response()->json(
//                 $this->fm->rename(
//                     $request->input('disk'),
//                     $request->input('newName'),
//                     $request->input('oldName')
//                 )
//             );
//         } else {
//             return [
//                 'result' => [
//                     'status'  => 'error',
//                     'message' => $authorization->message(),
//                 ],
//             ];
//         }
//     }

//     /**
//      * Download file
//      *
//      * @param RequestValidator $request
//      *
//      * @return mixed
//      */
//     public function download(RequestValidator $request)
//     {
//         $authorization =  Gate::inspect('download-files');

//         if ($authorization->allowed()) {
//             event(new Download($request));

//             return $this->fm->download(
//                 $request->input('disk'),
//                 $request->input('path')
//             );
//         } else {
//             return [
//                 'result' => [
//                     'status'  => 'error',
//                     'message' => $authorization->message(),
//                 ],
//             ];
//         }
//     }

//     /**
//      * Create thumbnails
//      *
//      * @param RequestValidator $request
//      *
//      * @return \Illuminate\Http\Response|mixed
//      * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
//      */
//     public function thumbnails(RequestValidator $request)
//     {
//         $authorization =  Gate::inspect('view-files');

//         if ($authorization->allowed()) {
//             return $this->fm->thumbnails(
//                 $request->input('disk'),
//                 $request->input('path')
//             );
//         } else {
//             return [
//                 'result' => [
//                     'status'  => 'error',
//                     'message' => $authorization->message(),
//                 ],
//             ];
//         }
//     }

//     /**
//      * Image preview
//      *
//      * @param RequestValidator $request
//      *
//      * @return mixed
//      * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
//      */
//     public function preview(RequestValidator $request)
//     {
//         $authorization =  Gate::inspect('view-files');

//         if ($authorization->allowed()) {
//             return $this->fm->preview(
//                 $request->input('disk'),
//                 $request->input('path')
//             );
//         } else {
//             return [
//                 'result' => [
//                     'status'  => 'error',
//                     'message' => $authorization->message(),
//                 ],
//             ];
//         }
//     }

//     /**
//      * File url
//      *
//      * @param RequestValidator $request
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function url(RequestValidator $request)
//     {
//         $authorization =  Gate::inspect('view-files');

//         if ($authorization->allowed()) {
//             return response()->json(
//                 $this->fm->url(
//                     $request->input('disk'),
//                     $request->input('path')
//                 )
//             );
//         } else {
//             return [
//                 'result' => [
//                     'status'  => 'error',
//                     'message' => $authorization->message(),
//                 ],
//             ];
//         }
//     }

//     /**
//      * Create new directory
//      *
//      * @param RequestValidator $request
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function createDirectory(RequestValidator $request)
//     {
//         $authorization =  Gate::inspect('add-files');

//         if ($authorization->allowed()) {
//             event(new DirectoryCreating($request));

//             $createDirectoryResponse = $this->fm->createDirectory(
//                 $request->input('disk'),
//                 $request->input('path'),
//                 $request->input('name')
//             );

//             if ($createDirectoryResponse['result']['status'] === 'success') {
//                 event(new DirectoryCreated($request));
//             }

//             return response()->json($createDirectoryResponse);
//         } else {
//             return [
//                 'result' => [
//                     'status'  => 'error',
//                     'message' => $authorization->message(),
//                 ],
//             ];
//         }
//     }

//     /**
//      * Create new file
//      *
//      * @param RequestValidator $request
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function createFile(RequestValidator $request)
//     {
//         $authorization =  Gate::inspect('add-files');

//         if ($authorization->allowed()) {
//             event(new FileCreating($request));

//             $createFileResponse = $this->fm->createFile(
//                 $request->input('disk'),
//                 $request->input('path'),
//                 $request->input('name')
//             );

//             if ($createFileResponse['result']['status'] === 'success') {
//                 event(new FileCreated($request));
//             }

//             return response()->json($createFileResponse);
//         } else {
//             return [
//                 'result' => [
//                     'status'  => 'error',
//                     'message' => $authorization->message(),
//                 ],
//             ];
//         }
//     }

//     /**
//      * Update file
//      *
//      * @param RequestValidator $request
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function updateFile(RequestValidator $request)
//     {
//         $authorization =  Gate::inspect('edit-files');

//         if ($authorization->allowed()) {
//             event(new FileUpdate($request));

//             return response()->json(
//                 $this->fm->updateFile(
//                     $request->input('disk'),
//                     $request->input('path'),
//                     $request->file('file')
//                 )
//             );
//         } else {
//             return [
//                 'result' => [
//                     'status'  => 'error',
//                     'message' => $authorization->message(),
//                 ],
//             ];
//         }
//     }

//     /**
//      * Stream file
//      *
//      * @param RequestValidator $request
//      *
//      * @return mixed
//      */
//     public function streamFile(RequestValidator $request)
//     {
//         $authorization =  Gate::inspect('view-files');
//         dd('sdsds');
//         if ($authorization->allowed()) {
//             return $this->fm->streamFile(
//                 $request->input('disk'),
//                 $request->input('path')
//             );
//         } else {
//             return [
//                 'result' => [
//                     'status'  => 'error',
//                     'message' => $authorization->message(),
//                 ],
//             ];
//         }
//     }

//     /**
//      * Create zip archive
//      *
//      * @param RequestValidator $request
//      * @param Zip              $zip
//      *
//      * @return array
//      */
//     public function zip(RequestValidator $request, Zip $zip)
//     {
//         $authorization =  Gate::inspect('edit-files');

//         if ($authorization->allowed()) {
//             event(new ZipEvent($request));

//             return $zip->create();
//         } else {
//             return [
//                 'result' => [
//                     'status'  => 'error',
//                     'message' => $authorization->message(),
//                 ],
//             ];
//         }
//     }

//     /**
//      * Extract zip archive
//      *
//      * @param RequestValidator $request
//      * @param Zip              $zip
//      *
//      * @return array
//      */
//     public function unzip(RequestValidator $request, Zip $zip)
//     {
//         $authorization =  Gate::inspect('edit-files');

//         if ($authorization->allowed()) {
//             event(new UnzipEvent($request));

//             return $zip->extract();
//         } else {
//             return [
//                 'result' => [
//                     'status'  => 'error',
//                     'message' => $authorization->message(),
//                 ],
//             ];
//         }
//     }

//     /**
//      * Integration with ckeditor 4
//      *
//      * @param Request $request
//      *
//      * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
//      */
//     public function ckeditor()
//     {
//         return view('file-manager::ckeditor');
//     }

//     /**
//      * Integration with TinyMCE v4
//      *
//      * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
//      */
//     public function tinymce()
//     {
//         return view('file-manager::tinymce');
//     }

//     /**
//      * Integration with TinyMCE v5
//      *
//      * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
//      */
//     public function tinymce5()
//     {
//         return view('file-manager::tinymce5');
//     }

//     /**
//      * Integration with SummerNote
//      *
//      * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
//      */
//     public function summernote()
//     {
//         return view('file-manager::summernote');
//     }

//     /**
//      * Simple integration with input field
//      *
//      * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
//      */
//     public function fmButton()
//     {
//         return view('file-manager::fmButton');
//     }
// }
