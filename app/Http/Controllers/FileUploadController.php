<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
// use simplehtmldom\HtmlDocument;
use App\Exports\HtmlTableExport;
use DiDom\Document;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileUploadController extends Controller
{
    public function index()
    {
        return view('upload');
    }

 
    public function upload(Request $request)
    {
        // Validasi file
        // $request->validate([
        //     'file' => 'required|mimes:txt|max:5120', // Maksimal 5MB
        // ]);
    
        // Baca isi file
        $file = $request->file('file');
        $content = file_get_contents($file->getPathname());
    
        // Parsing HTML dari file txt menggunakan DiDom
        $document = new Document($content);
        $tables = $document->find('table'); // Ambil semua tabel
    
        if (empty($tables)) {
            return back()->with('error', 'File tidak mengandung tabel.');
        }
    
        // Ambil header dari tabel pertama
        $headers = [];
        $firstTable = $tables[0];
        foreach ($firstTable->find('th') as $th) {
            $headers[] = trim($th->text());
        }
    
        // Gabungkan semua data dari setiap tabel
        $data = [];
        foreach ($tables as $table) {
            foreach ($table->find('tr') as $tr) {
                $row = [];
                foreach ($tr->find('td') as $td) {
                    $row[] = trim($td->text());
                }
                if (!empty($row)) {
                    $data[] = $row;
                }
            }
        }
    
        // Buat file Excel menggunakan maatwebsite/excel
        $fileName = 'merged_tables.xlsx';
        return Excel::download(new HtmlTableExport($headers, $data), $fileName);
    }
    
        }
        