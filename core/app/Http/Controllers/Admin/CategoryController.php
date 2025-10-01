<?php

namespace App\Http\Controllers\Admin;

use App\Traits\Crud;
use App\Models\Category;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    protected $title        = 'Categories';
    protected $model        = Category::class;
    protected $view         = 'admin.category.';
    protected $searchable   = ['name'];
    protected $operationFor = 'Category';

    use Crud;

    public function __construct()
    {
        $this->hasImage = true;
    }

    public function validation($request, $id = 0)
    {
        $isRequired = $id ? 'nullable' : 'required';
        return $request->validate([
            'name'        => 'required|max:255|unique:categories,name,' . $id,
            'image'       => [$isRequired, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);
    }
}
