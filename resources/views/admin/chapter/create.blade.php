@extends('layouts.app')

@section('content')
    @include('layouts.nav')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Thêm chapter truyện</div>

                    <div class="card-body">

                        <form method="POST" action="{{route('chapter.store')}}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Thêm ten chapter</label>
                                <input type="text" name="name" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp" placeholder="Thêm danh mục" value="{{old('name')}}">
                                <p class="help is-danger" style="color:red">{{ $errors->first('nameCategory') }}</p>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả danh mục</label>
                                <input type="text" name="descriptionCategory" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp" placeholder="Mô tả danh mục" value="{{old('descriptionCategory')}}">
                                <p class="help is-danger" style="color:red">{{ $errors->first('descriptionCategory') }}</p>
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng thái</label>
                                <select class="custom-select" name="status">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiện</option>
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
