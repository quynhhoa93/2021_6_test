<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stories = Story::orderBy('id', 'DESC')->get();
        return view('admin.story.index',compact('stories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id','=','0')->get();
        $categories_dropdown = "<option selected disabled>select</option>";
        foreach ($categories as $cat){
            $categories_dropdown .="<option value='".$cat->id."' disabled>".$cat->nameCategory."</option>";
            $sub_categories = Category::where('parent_id','=',$cat->id)->get();
            foreach ($sub_categories as $sub_cat){
                $categories_dropdown .="<option value='".$sub_cat->id."'> &nbsp; -- &nbsp".$sub_cat->nameCategory."</option>";
            }
        }
        return view('admin.story.create',compact('categories_dropdown'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categories = Category::where('parent_id', '>', '0')->get();
        $data = $request->validate([
            'nameStory' => 'required|min:6|max:255|unique:stories',
            'descriptionStory' => 'required',
            'status' => 'required',
            'category_id' => 'required',
            'image' => 'required',
        ],
            [
                'nameStory.required' => 'Bạn không được bỏ trống phần này',
                'nameStory.max' => 'Tối đa là 255 ký tự',
                'nameStory.min' => 'Tối thiểu là 6 ký tự',
                'nameStory.unique' => 'Tên danh mục phải là duy nhất',
                'descriptionStory.required' => 'Bạn không được bỏ trống phần này',
                'status.required' => 'Bạn không được bỏ trống phần này',
                'category_id.required' => 'Bạn không được bỏ trống phần này',
                'image.required' => 'Bạn không được bỏ trống phần này',
            ]
        );

        $story = new Story();
        $story->nameStory = $data['nameStory'];
        $story->descriptionStory = $data['descriptionStory'];
        $story->category_id = $data['category_id'];
        $story->status = $data['status'];

        foreach ($categories as $cat) {
            if ($request->category_id == $cat->id) {
                $story->slug = str_slug($cat->nameCategory) . '/' . str_slug($request->nameStory);
            }
        }

        $get_image = $request->image;
        $path = 'public/uploads/stories/';
        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.',$get_name_image));
        $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        $get_image->move($path,$new_image);
        $story->image = $new_image;

        $story->save();
        toastr()->success('xong');
        return redirect()->route('truyen.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $story = Story::find($id);
        return view('admin.story.show',compact('story'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $story = Story::find($id);
        $categories = Category::where('parent_id','=','0')->get();
        $categories_dropdown = "<option selected disabled>select</option>";
        foreach ($categories as $cat){
            $categories_dropdown .="<option value='".$cat->id."' disabled>".$cat->nameCategory."</option>";
            $sub_categories = Category::where('parent_id','=',$cat->id)->get();
            foreach ($sub_categories as $sub_cat){
                if ($sub_cat->id == $story->category_id){
                    $selected = "selected";
                }else{
                    $selected = "";
                }
                $categories_dropdown .="<option value='".$sub_cat->id."'".$selected."> &nbsp; -- &nbsp".$sub_cat->nameCategory."</option>";
            }
        }
        return view('admin.story.edit',compact('story','categories_dropdown'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nameStory' => 'required|min:6|max:255',
            'descriptionStory' => 'required',
            'status' => 'required',
            'category_id' => 'required',
//            'image' => 'required',
        ],
            [
                'nameStory.required' => 'Bạn không được bỏ trống phần này',
                'nameStory.max' => 'Tối đa là 255 ký tự',
                'nameStory.min' => 'Tối thiểu là 6 ký tự',
//                'nameStory.unique' => 'Tên danh mục phải là duy nhất',
                'descriptionStory.required' => 'Bạn không được bỏ trống phần này',
                'status.required' => 'Bạn không được bỏ trống phần này',
                'category_id.required' => 'Bạn không được bỏ trống phần này',
//                'image.required' => 'Bạn không được bỏ trống phần này',
            ]
        );

        $categories = Category::where('parent_id', '>', '0')->get();
        $story = Story::find($id);

        $story->nameStory = $data['nameStory'];
        $story->descriptionStory = $data['descriptionStory'];
        $story->category_id = $data['category_id'];
        $story->status = $data['status'];

        foreach ($categories as $cat) {
            if ($request->category_id == $cat->id) {
                $story->slug = str_slug($cat->nameCategory) . '/' . str_slug($request->nameStory);
            }
        }

        if ($request->hasFile('image')) {
            $get_image = $request->image;
            $path = 'public/uploads/stories/';
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move($path, $new_image);
            //xoa anh cu
            $old_image_patch = 'public/uploads/stories/';
            if (file_exists($old_image_patch.$request->current_image)){
                unlink($old_image_patch.$request->current_image);
            }
        }else{
            $new_image = $request->current_image;
        }
        $story->image = $new_image;
        $story->save();
        toastr()->success('xong');
        return redirect()->route('truyen.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $story = Story::find($id);
        $story_patch = 'public/uploads/stories/';
        if (file_exists($story_patch.$story->image)){
            unlink($story_patch.$story->image);
        }
        $story->delete();
        toastr()->warning('Đã xoá thành công một truyện');
        return redirect()->back();
    }
}
