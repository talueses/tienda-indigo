<?php
namespace App\Http\Controllers\Traits;

trait Item {

	/**
	 * Nosotros page
	 */
	public function uploadTextareaFiles($src, $filename, $mimetype)
	{

		$filepath = "/uploads/page/$filename";

		$image = \Image::make($src)
			->encode($mimetype, 100)  // encode file to the specified mimetype
			->save(public_path($filepath));

		return $filepath;
	}

	public function uploadMCEVideo($file)
	{
		$route = 'uploads/mcevideos/';
		$filename = rand().'_'.$file->getClientOriginalName();
		$file->move($route, $filename);

		$filename = '/uploads/mcevideos/'.$filename;
		return $filename;
	}

	public function uploadTextareaImages($file, $folder)
	{
		$route = 'uploads/'.$folder.'/';
		$filename = rand().'_'.$file->getClientOriginalName();
		$file->move($route,$filename);

		return $filename;
	}

	public function uploadImages($files, $id, $folder)
	{
		$filenames = [];
		foreach ($files as $file) {
			$filenames[] = $this->uploadImageG($file, $id, $folder);
		}
		return $filenames;
	}

	public function uploadImageG($file, $id, $folder)
	{
		$path = $folder.'/shop';
		$route = 'uploads/'.$path.'/';
		$filename = $id.'_'.$file->getClientOriginalName();
		$file->move($route,$filename);

		return $filename;
	}

	public function uploadCover($file, $slug, $path)
	{
		$route = 'uploads/'.$path.'/';
		$extension = '.'.$file->getClientOriginalExtension();
		$name = md5($slug).$extension;

		$file->move($route,$name);

		return $name;
	}

	public function uploadSlide($file, $filename, $path)
	{
		$name = $filename.'.'.$file->getClientOriginalExtension();
		$file->move($path, $name);
		return $name;
	}

    public function uploadImage($file, $slug, $path)
    {
		$route = 'uploads/'.$path.'/';
		$extension = '.'.$file->getClientOriginalExtension();
		$name = md5($slug).$extension;

		$img = \Image::make($file);
		$img->backup();

		$file->move($route,$name);

		//200x200
		//$img->resize(200, 200);
		$img->resize(400, 400, function ($constraint) {
			$constraint->aspectRatio();
		});

		$img->save($route.'200x200_'.$name);

		//return to backup state
		$img->reset();

		//80x80
		//$img->resize(80, 80);
		$img->resize(160, 160, function ($constraint) {
			$constraint->aspectRatio();
		});


		$img->save($route.'80x80_'.$name);

		return $name;
	}
	
    /**
	 * Generate a unique slug.
	 * If it already exists, a number suffix will be appended.
	 * It probably works only with MySQL.
	 *
	 * @link http://chrishayes.ca/blog/code/laravel-4-generating-unique-slugs-elegantly
	 *
	 * @param Illuminate\Database\Eloquent\Model $model
	 * @param string $value
	 * @return string
	 */
	public function getUniqueSlug(\Illuminate\Database\Eloquent\Model $model, $value)
	{
		$traits = class_uses($model);

		if (in_array('SoftDeletingTrait', $traits))
		{
			$allSlugs = $model->select('slug')->where('slug', 'like', $value.'%')
						  			->where('id', '<>', $model->id)
						  			->withTrashed()
						  			->get();
		} else {
			$allSlugs = $model->select('slug')->where('slug', 'like', $value.'%')
									->where('id', '<>', $model->id)
						   			->get();
		}


		if (! $allSlugs->contains('slug', $value)){
			return $value;
		}

		for ($i = 1; $i <= 10; $i++) {
			$newSlug = $value.'-'.$i;
			if (! $allSlugs->contains('slug', $newSlug)) {
				return $newSlug;
			}
		}

		throw new \Exception('Can not create a unique slug');
	}

	public function sameSlug(\Illuminate\Database\Eloquent\Model $model, $slug)
	{
	    return count($model->whereRaw("slug REGEXP '^{$slug}(-[0-9]+)?$' and id != '{$model->id}'")->get());
	}

	public function uploadImgDom($html) {

        $dom = new \DOMDocument();
        $dom->loadHTML($html);

        $xpath = new \DOMXPath($dom);
        $tags = $xpath->query('//img');

        foreach ($tags as $img) {
            $src = $img->getAttribute('src');
            $name = $img->getAttribute('data-filename');

            preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
            $mimetype = $groups['mime'];

            $filepath = $this->uploadTextareaFiles($src, $name, $mimetype);
            $img->setAttribute('src', $filepath);
        }

        $new_dom = $dom->saveHTML();
        return $new_dom;
	}

}
