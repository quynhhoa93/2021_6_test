@extends('layouts.app')

@section('content')
    @include('layouts.nav')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Thêm truyện</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{route('truyen.update',$story->id)}}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên truyện</label>
                                <input type="text" name="nameStory" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp" placeholder="Thêm danh mục" value="{{$story->nameStory}}">
                                <p class="help is-danger" style="color:red">{{ $errors->first('nameStory') }}</p>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tóm tắt truyện</label>
                                <textarea class="form-control" id="summary-ckeditor" name="descriptionStory">{{$story->descriptionStory}}</textarea>
                                <p class="help is-danger" style="color:red">{{ $errors->first('descriptionStory') }}</p>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh truyện</label>
                                <br>
                                <img src="{{asset('public/uploads/stories/'.$story->image)}}" style="height: 200px;width:200px">
                                <input type="file" name="image" class="form-control-file"
                                       aria-describedby="emailHelp">
                                <input type="hidden" name="current_image" value="{{$story->image}}">
                                <p class="help is-danger" style="color:red">{{ $errors->first('image') }}</p>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Danh mục truyện</label>
                                <select class="custom-select" name="category_id">
                                    <?php echo $categories_dropdown; ?>
                                </select>
                                <p class="help is-danger" style="color:red">{{ $errors->first('category_id') }}</p>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng thái</label>
                                <select class="custom-select" name="status">
                                    <option value="0" @if($story->status===0)selected @endif>Ẩn</option>
                                    <option value="1" @if($story->status===1)selected @endif>Hiện</option>
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
