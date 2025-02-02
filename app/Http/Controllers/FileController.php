<?php
namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    // Menampilkan halaman utama file
    public function index() {
        return view('file.file-index');
    }

    // Mengambil file berdasarkan parent_id (folder atau file)
    public function getFile(Request $request)
    {
        $parentId = $request->query('parent_id');
        $files = File::where('parent_id', $parentId)->get();
        return response()->json(['data' => $files]);
    }

    // Menambahkan file atau folder
    public function addFile(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:folder,file',
            // 'parent_id' => 'nullable|exists:files,id'  // Validasi parent_id jika ada
        ]);
    
        // Jika parent_id adalah 'NaN', ubah menjadi null
        $parentId = ($request->parent_id === 'NaN' || $request->parent_id === null) ? null : $request->parent_id;
    
        $filePath = null;
    
        // Jika tipe adalah file dan ada file yang diunggah
        if ($request->type === 'file' && $request->hasFile('file_upload_asset')) {
            // Validasi file
            $request->validate([
                'file_upload_asset' => 'required|file|mimes:xlsx,xls,csv,doc,docx,pdf|max:10240', 
            ]);
            
            // Simpan file ke folder 'file_sharing'
            $filePath = $request->file('file_upload_asset')->store('file_sharing');
        }
    
        // Membuat entri baru di tabel file
        $file = File::create([
            'name' => $request->name,
            'type' => $request->type,
            'parent_id' => $parentId,  // Set parent_id menjadi null jika 'NaN'
            'path' => $filePath,  // Simpan path file jika ada
        ]);
    
        return response()->json(['message' => 'File/Folder berhasil ditambahkan', 'file' => $file]);
    }
    
    

    // Menangani pengunggahan file
    public function uploadFile(Request $request)
    {
        // Validasi input
        $request->validate([
            'file_upload_asset' => 'required|file|mimes:xlsx,xls,csv,doc,docx,pdf|max:10240', 
            'parent_id' => 'nullable|exists:files,id', // Pastikan parent_id valid
        ]);
        
        // Memeriksa apakah ada file yang di-upload
        if ($request->hasFile('file_upload_asset')) {
            $file = $request->file('file_upload_asset');
            $path = $file->storeAs('file_sharing', $file->getClientOriginalName(), 'public');
            // dd($path);
            // Membuat entri baru di tabel file
            $uploadedFile = File::create([
                'name' => $file->getClientOriginalName(),
                'type' => 'file',
                'parent_id' => $request->parent_id,  // Menggunakan parent_id yang diterima
                'size' => $file->getSize(),
                'extension' => $file->getClientOriginalExtension(),
                'path' => $path, // Menyimpan path file yang baru di-upload
            ]);
    
            return response()->json(['message' => 'File berhasil di-upload', 'file' => $uploadedFile]);
        }
    
        return response()->json(['message' => 'File tidak ditemukan'], 400); // Jika file tidak ditemukan
    }
    
    
}
