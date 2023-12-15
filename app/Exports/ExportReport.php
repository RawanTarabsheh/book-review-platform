<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportReport implements FromCollection, WithHeadings, ShouldAutoSize
{

    public $bookCount ;
    public $userCount;
    public $reviewCount ;
    public $userActivity;

    public function  __construct( $bookCount ,$userCount,$reviewCount,$userActivity)
    {
        $this->bookCount =       $bookCount;
        $this->userCount =       $userCount;
        $this->reviewCount =       $reviewCount;
        $this->userActivity =       $userActivity;
    }
    public function collection()
    {

        $userActivity=$this->userActivity->map(function($activity,$index){
            return[
                'id'          =>     $index+1,
                'user'        =>     $activity->user->name? $activity->user->name:'',
                'email'       =>     $activity->user->email?$activity->user->email:'',
                'action'      =>     'Book Reviewed Since'. $activity->user->created_at->diffForHumans(),
                'comment'     =>     $activity->comment?$activity->comment:'',
                'last_log_in' =>     $activity->user->last_login_at? $activity->user->last_login_at->diffForHumans()  ??'N/A':'',
            ];
          } );
        return $userActivity;
    }
    public function headings(): array
    {
        return [
            ["user Count " . $this->userCount ." "],
            ["review Count " . $this->reviewCount ." "],
            ["book Count " . $this->bookCount ." "],
            [
                __('ID'),
                __('User'),
                __('Email'),
                __('Action'),
                __('comment'),
                __('Last Logged In'),
            ]
        ];
    }
}
