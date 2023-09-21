<?php

namespace App\Http\Services\Slider;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SliderService extends Controller
{
    public function insert($request)
    {
        try {
            #$request->except('_token');
            Slider::create($request->input());
            Session::flash('success', 'Thêm slider mới thành công');
        } catch (Exception $err) {
            Session::flash('error', 'Thêm slider lỗi');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function get()
    {
        return Slider::orderByDesc('id')->paginate(15);
    }

    public function update($request, $slider)
    {

        try {
            $slider->fill($request->input());
            $slider->save();
            Session::flash('success', 'Cập nhật slider thành công');
            return true;
        } catch (Exception $err) {
            Session::flash('error', 'Cập nhật slider thất bại');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }
    
    public function destroy($request){
        $slider = Slider::where('id',$request->input())->first();
        if($slider){
            $path = str_replace('storage','public',$slider->thumb);
            Storage::delete($path);
            $slider->delete();
            return true;
        }
        return false;
    }

    public function show(){
        return Slider::where('active',1)->orderBydesc('sort_by')->get();
    }
}