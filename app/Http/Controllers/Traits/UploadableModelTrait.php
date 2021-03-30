<?php
namespace App\Http\Controllers\Traits;
use Carbon\Carbon;
use App\Exposicion;

trait UploadableModelTrait {

	public function uploadHomeVideo($file)
    {
        /*try {
            $path = \Storage::disk('upload')->putFileAs($this->getUploadDir(), $file, $this->createFileName($file->getClientOriginalName()));
        } catch (\Exception $e) {
            throw new FileException($e->getMessage());
        }
        $path = '/upload/' . $path;
        return $path;*/
        try {
	        $path = 'vid';
					$route = 'uploads/'.$path.'/';
					$filename = $file->getClientOriginalName();
					$file->move($route,$filename);

					return $filename;
        } catch (Exception $e) {

        }
    }

    public function destroyHomeVideo($video)
    {
        \File::delete('uploads/vid/'.$video);
    }

}
