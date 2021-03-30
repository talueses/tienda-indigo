<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pagina;
use App\General;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\Item;
use App\Http\Controllers\Traits\UploadableModelTrait;
use Illuminate\Http\Exceptions\PostTooLargeException;

class AdminController extends Controller
{
    use Item, UploadableModelTrait;

    public function uploadVideo(Request $request)
    {
        /*$this->validate($request, [
          'file_video' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm|max:20000',
        ]);*/
        $pagina = new Pagina;
        $pagina->titulo = 'inicio';
        $pagina->contenido = $this->uploadHomeVideo($request->file('file_video'));
        $pagina->video = true;
        if ($pagina->save()) {
            session()->flash('message', ['type' => 'success', 'message' => 'Video subido.']);
        }
        return redirect()->route('admin');
    }

    public function destroyVideo($id)
    {
        $slide = Pagina::findOrFail($id);
        
        if ($this->destroyHomeVideo($slide->contenido)) {
            $slide->delete();
            session()->flash('message', ['type' => 'success', 'message' => 'Video eliminado.']);
        }
        return redirect()->route('admin');
    }

    public function createSlider(Request $request)
    {
        $this->validate($request, [
          'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('img')) {
            $pagina = new Pagina;
            $pagina->titulo = 'inicio';
            $pagina->contenido = $request->get('slide_caption');

            $title = "sl".md5(openssl_random_pseudo_bytes(20)).strtotime('now');
            $path = 'uploads/home/gallery/';
            $pagina->img = ($request->hasFile('img')) ?
                  $this->uploadSlide($request->file('img'), $title, $path) : null;

            if ($pagina->save()) {
                session()->flash('message', ['type' => 'success', 'message' => 'Slider creado.']);
            } else {
                session()->flash('message', ['type' => 'danger', 'message' => 'Hubo un error al crear el slider. Por favor intentelo de nuevo.']);
            }

        } else {
            session()->flash('message', ['type' => 'danger', 'message' => 'No se pudo crear slider.']);
        }

        return redirect()->route('admin');
    }

    public function updateHomeImage(Request $request)
    {
        //$data = $request->all();
        $path = 'uploads/home/section/';

        $section = $request->get('home_image_name');
        $pagina = Pagina::where('titulo', '=', $section)->first();

        $img = $this->uploadSlide($request->file('img'), $section, $path);

        if ($pagina) {
            $pagina->img = $img;
            $pagina->save();

            session()->flash('message', ['type' => 'success', 'message' => 'Sección actualizada.']);

        } else {
            $pagina = new Pagina;
            $pagina->titulo = $section;
            $pagina->img = $img;
            $pagina->save();

            session()->flash('message', ['type' => 'success', 'message' => 'Sección creada.']);
        }

        return redirect()->route('admin');
    }

    public function updateSlider(Request $request, $id)
    {
        $data = $request->all();

        $pagina = Pagina::findOrFail($id);
        $path = 'uploads/home/gallery/';
        $data['video'] = 0;
        $data['img'] = $pagina->img;

        //image
        if($request->hasFile('img')) {

            $this->validate($request, [
              'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            \File::delete($path.$pagina->img);
            $title = explode('.',$pagina->img)[0];

            $data['img'] = ($request->hasFile('img')) ?
                $this->uploadSlide($request->file('img'), $title, $path) : null;
        }

        $data['contenido'] = $request->get('slide_caption');

        if ($pagina->update($data)) {
            session()->flash('message', ['type' => 'success', 'message' => 'Slider actualizado.']);
        } else {
            session()->flash('message', ['type' => 'danger', 'message' => 'Ocurrio un error al actualizar el slider.']);
        }

        return redirect()->route('admin');
    }

    public function destroySlider($id)
    {
        $slide = Pagina::findOrFail($id);

        if ($slide->delete()) {
            \File::delete('uploads/home/gallery/'.$slide->img);
            session()->flash('message', ['type' => 'success', 'message' => 'Slider eliminado.']);
        } else {
            session()->flash('message', ['type' => 'danger', 'message' => 'No se pudo eliminar el slider.']);
        }

        return redirect()->route('admin');
    }

    public function uploadVideoTextarea(Request $request)
    {
        $link = '';

        try {
          $link = $this->uploadMCEVideo($request->file('file'));
        } catch (\Exception $e) {
          if($e instanceof PostTooLargeException){
            //return redirect()->back()->withErrors("Size of attached file should be less ".ini_get("upload_max_filesize")."B", 'addNote');
            return response()->json([
              "error" => ("Size of attached file should be less ".ini_get("upload_max_filesize")."B")
            ]);
          }

          return response()->json([
            "error" => $e->getMessage()
          ]);
            exit;
        }


        $response = new \StdClass;
        $response->location = $link;

        echo stripslashes(json_encode($response));

    }

    /**
     *
     */
    public function uploadImageTextarea(Request $request)
    {
        $link = '';

        $path = 'exhibitions/events';

        if($request->section) {
            $path = $request->section;
        }

        if ($request->hasFile('file')) {
            $new_image = $this->uploadTextareaImages($request->file('file'), $path);
            $link = '/uploads/'.$path.'/'.$new_image;
        }

        $response = new \StdClass;
        $response->location = $link;

        echo stripslashes(json_encode($response));

    }
}
