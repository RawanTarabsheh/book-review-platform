<?php

namespace App\Http\Controllers\admin;

use PDF;
use App\Models\Book;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Exports\ExportReport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function dashboard()
    {
        $bookCount = Book::count();
        $userCount = User::count();
        $reviewCount = Review::count();
        $userActivity = Review::userActivity();
        return view('admin.dashboard', compact('bookCount', 'userCount', 'reviewCount', 'userActivity'));
    }
    public function getUsers(){
        $users = User::getUsers();
        return view('admin.users', compact('users'));

    }
    public function generatePDF()
    {
        $userActivities = Review::userActivity();
        $bookCount = Book::count();
        $userCount = User::count();
        $reviewCount = Review::count();
        $data = [
            'userActivity' => $userActivities,
            'bookCount' => $bookCount,
            'userCount' => $userCount,
            'reviewCount' => $reviewCount,
        ];

        $pdf = PDF::loadView(
            'pdf',
            $data,
            [
                'mode'                       => '',
                'format'                     => 'A4',
                'default_font_size'          => '12',
                'default_font'               => 'sans-serif',
                'margin_left'                => 10,
                'margin_right'               => 10,
                'margin_top'                 => 10,
                'margin_bottom'              => 10,
                'margin_header'              => 0,
                'margin_footer'              => 0,
                'orientation'                => 'P',
                'title'                      => 'Report Patient',
                'author'                     => '',
                'watermark'                  => '',
                'show_watermark'             => false,
                'show_watermark_image'       => false,
                'watermark_font'             => 'sans-serif',
                'display_mode'               => 'fullpage',
                'watermark_text_alpha'       => 0.1,
                'watermark_image_path'       => '',
                'watermark_image_alpha'      => 0.2,
                'watermark_image_size'       => 'D',
                'watermark_image_position'   => 'P',
                'custom_font_dir'            => '',
                'custom_font_data'           => [],
                'auto_language_detection'    => false,
                'temp_dir'                   => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
                'pdfa'                       => false,
                'pdfaauto'                   => false,
                'use_active_forms'           => false,
            ]
        );

        // You can also customize the PDF, e.g., set header and footer
        return $pdf->stream('user_book_report.pdf');

        return $pdf->download('user_book_report.pdf');
    }
    public function generateEXCEL()
    {
        $bookCount = Book::count();
        $userCount = User::count();
        $reviewCount = Review::count();
        $userActivity = Review::userActivity();

        $export = new ExportReport($bookCount, $userCount, $reviewCount, $userActivity);

        return Excel::download($export, 'user_book_report.xlsx');
    }
}
