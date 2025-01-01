<?php
namespace App\Repositories;

use App\Models\Event;
use App\Models\Post;
use App\Models\Media;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaveRepository {

    public function UploadFile(Request $request,$fileName = null)
    {
        $created_by = Auth::user()->id;

        $upload = $request->file($fileName ?? 'file');
        $path   = $upload->getRealPath();
        $file   = file_get_contents($path);
        $base64 = base64_encode($file);
        $file = [
            'name'          =>  $upload->getClientOriginalName(),
            'mime'          =>  $upload->getClientMimeType(),
            'size'          =>  number_format(($upload->getSize() / 1024), 1),
            'attachment'    =>  'data:'.$upload->getClientMimeType().';base64,'.$base64,
            'created_by'    =>  $created_by
        ];
        $info = Media::create($file);
        return $info->id;
    }

    public function RemoveMedia($id)
    {
        try {
            Media::where('id',$id)->delete();
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function Post(Request $request,$id)
    {
        if (!empty($id)) {
            $info = Post::find($id);
            if (!empty($info)){
                $info->title            =   $request->title;
                $info->description      =   $request->description;

                DB::beginTransaction();
                try {
                    $info->save();
                    DB::commit();
                    return 'success';
                } catch (Exception $e) {
                    DB::rollback();
                    return $e;
                }
            }
            else {
                return  "No record found";
            }
        }
        $data = [
            'title'                 => $request->title,
            'description'           => $request->description,
        ];
        DB::beginTransaction();
        try {
            Post::create($data);
            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function BlockPost($id)
    {
        $info = Post::find($id);
        if (!empty($info)){
            DB::beginTransaction();
            try {
                $info->delete();
                DB::commit();
                return 'success';
            } catch (Exception $e) {
                DB::rollback();
                return $e;
            }
        }
        else {
            return __('msg.no_record_found');
        }
    }

    public function UnblockPost($id)
    {
        $info = Post::withTrashed()->find($id);
        if (!empty($info)){
            DB::beginTransaction();
            try {
                $info->save();
                $info->restore();
                DB::commit();
                return 'success';
            } catch (Exception $e) {
                DB::rollback();
                return $e;
            }
        }
        else{
            return __('msg.no_record_found');
        }
    }
}
