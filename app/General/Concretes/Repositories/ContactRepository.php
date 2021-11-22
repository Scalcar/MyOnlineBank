<?php

namespace App\General\Concretes\Repositories;

use App\General\Abstracts\Repository;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ContactRepository extends Repository
{
    protected $model = Contact::class;

    public function search($select,$value)
    {
        switch($select) {
            case '0':
                return $this->model::where('nickname','like','%' . $value . '%')->where('list_id', Auth::user()->id)->get();
                break;
            case '1':
                return $this->model::whereHas('account', function($q) {
                    return $q->where('accNo','like','%' . request()->post('searchForm') . '%');
                })->where('list_id',Auth::user()->id)->get();
                break;
        }
    }
}