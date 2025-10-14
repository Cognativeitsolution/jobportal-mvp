<?php

namespace App\Http\Controllers\Admin;

use App\Traits\Crud;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faq;

class FaqController extends Controller
{
    protected $title        = 'Manage Faq';
    protected $model        = Faq::class;
    protected $view         = 'admin.faq.';
    protected $searchable   = ['question'];
    protected $operationFor = 'Faq';

    use Crud;

    public function validation($request, $id = 0)
    {
        return $request->validate([
            'question' => 'required|max:255|unique:faqs,question,' . $id,
        ]);
    }
}
