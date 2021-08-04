@extends('layouts.app')

@section('content')
    @include('layouts.nav')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Thêm danh mục truyện</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{route('danh-muc.update',$category->id)}}">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Thêm danh mục</label>
                                <input type="text" name="nameCategory" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp" placeholder="Thêm danh mục" value="{{$category->nameCategory}}">
                                <p class="help is-danger" style="color:red">{{ $errors->first('nameCategory') }}</p>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả danh mục</label>
                                <input type="text" name="descriptionCategory" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp" placeholder="Mô tả danh mục" value="{{$category->descriptionCategory}}">
                                <p class="help is-danger" style="color:red">{{ $errors->first('descriptionCategory') }}</p>
                            </div>

{{--                            <div class="form-group">--}}
{{--                                <label>Tên danh mục gốc (nếu có)</label>--}}
{{--                                <select name="parent_id" id="parent_id" class="form-control">--}}
{{--                                    <option value="0">danh mục gốc</option>--}}
{{--                                    @foreach($levels as $level)--}}
{{--                                        <option value="{{$level->id}}" @if($level->id == $category->parent_id)selected @endif>{{$level->nameCategory}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}

                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng thái</label>
                                <select class="custom-select" name="status">
                                    <option value="0" @if($category->status===0)selected @endif>Ẩn</option>
                                    <option value="1" @if($category->status===1)selected @endif>Hiện</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
