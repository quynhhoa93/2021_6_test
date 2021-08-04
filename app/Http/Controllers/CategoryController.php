<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $levels = Category::where('parent_id', '0')->get();
        return view('admin.category.create', compact('levels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nameCategory' => 'required|min:6|max:255|unique:categories',
            'descriptionCategory' => 'required|max:255',
            'status' => 'required',
        ],
            [
                'nameCategory.required' => 'Bạn không được bỏ trống phần này',
                'nameCategory.max' => 'Tối đa là 255 ký tự',
                'nameCategory.min' => 'Tối thiểu là 6 ký tự',
                'nameCategory.unique' => 'Tên danh mục phải là duy nhất',
                'descriptionCategory.required' => 'Bạn không được bỏ trống phần này',
                'descriptionCategory.max' => 'Tối đa là 255 ký tự',
            ]
        );

        $categories = Category::all();
        $category = new Category();
        $category->nameCategory = $data['nameCategory'];
        if ($request->parent_id == 0) {
            $category->slug = str_slug($request->nameCategory);
        } elseif ($request->parent_id != 0) {
            foreach ($categories as $cat) {
                if ($cat->id == $request->parent_id) {
                    $category->slug = $cat->slug . '/' . str_slug($request->nameCategory);
                }
            }
        }
        $category->descriptionCategory = $data['descriptionCategory'];
        $category->status = $data['status'];
        $category->parent_id = $request->parent_id;

        $category->save();
        toastr()->success('xong');
        return redirect()->route('danh-muc.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $levels = Category::where('parent_id', '0')->get();
        return view('admin.category.edit', compact('category', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nameCategory' => 'required|min:6|max:255',
            'descriptionCategory' => 'required|max:255',
            'status' => 'required',
        ],
            [
                'nameCategory.required' => 'Bạn không được bỏ trống phần này',
                'nameCategory.max' => 'Tối đa là 255 ký tự',
                'nameCategory.min' => 'Tối thiểu là 6 ký tự',
                'descriptionCategory.required' => 'Bạn không được bỏ trống phần này',
                'descriptionCategory.max' => 'Tối đa là 255 ký tự',
            ]
        );
        $categories = Category::all();
        $category = Category::find($id);
//        if ($category->parent_id == 0 && $category->id ) {
//            toastr()->error('không thay đổi danh mục gốc thành danh mục con được');
//            return redirect()->back();
//        }
        $category->nameCategory = $data['nameCategory'];
        $category->descriptionCategory = $data['descriptionCategory'];
        $category->status = $data['status'];
        if ($category->parent_id == 0) {
            $category->slug = str_slug($request->nameCategory);
        } elseif ($category->parent_id != 0) {
            foreach ($categories as $cat) {
                if ($cat->id == $category->parent_id) {
                    $category->slug = $cat->slug . '/' . str_slug($request->nameCategory);
                }
            }
        }

        $category->save();
        toastr()->success('xong');
        return redirect()->route('danh-muc.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $categories = Category::where('parent_id', '>', '0')->get();
        $category = Category::find($id);
        foreach ($categories as $cat) {
            if ($category->id === $cat->parent_id) {
                toastr()->error('vẫn còn danh mục con nên không xoá được');
                return redirect()->back();
            }
        }
        $category->delete();
        toastr()->warning('xong');
        return redirect()->route('danh-muc.index');
    }
}
