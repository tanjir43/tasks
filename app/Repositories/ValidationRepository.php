<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ValidationRepository
{

    public function isValidFile(Request $request, $fileName = null)
    {
        if(!empty($fileName))  {
            return $request->validate([
                $fileName   => 'required|image|max:2048|mimes:jpg,jpeg,png,pdf,docx,doc,xlsx,xlx,pptx,ppt'
            ]);
        }
        return $request->validate([
            'file'      => 'required|image|max:2048|mimes:jpg,jpeg,png,pdf,docx,doc,xlsx,xlx,pptx,ppt'
        ]);
    }

    public function isValidPost(Request $request){
        return Validator::make($request->all(), [
            'title'         => 'required|max:250',
            'description'   => 'nullable|max:250',
            'category_id'   => 'required',
            'status'        => ['required', Rule::in(['draft', 'published', 'archived'])],
            'published_at'  => 'nullable|date',
        ]);
    }
}
