@extends('layouts.app')
@push('css')
@endpush
@section('content')
    @include('layouts.nav')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Chi tiết truyện
                        <br>
                        <br>
                        <p>Tên truyện : {{$story->nameStory}}</p>
                        Mô tả truyện :{!!  $story->descriptionStory !!}
                        <p><img src="{{asset('public/uploads/stories/'.$story->image)}}" style="height: 100px;width:100px"></p>
                        <button class="btn btn-success"><a href="{{route('chapter.create')}}">Thêm chapter mới</a></button>
                    </div>

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên truyện</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Đường dẫn đến truyện</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Mô tả truyện</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush

