@extends('layouts.app')
@push('css')
@endpush
@section('content')
    @include('layouts.nav')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Liệt kê truyện</div>

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
                        @foreach($stories as $key=>$story)
                            <tr>
                                <th scope="row">{{++$key}}</th>
                                <td>{{$story->nameStory}}</td>
                                <td><img src="{{asset('public/uploads/stories/'.$story->image)}}" style="height: 100px;width:100px"></td>
                                <td>{{$story->category->slug}}</td>
                                <td>{{$story->slug}}</td>
                                <td>{!! str_limit($story->descriptionStory,30) !!}</td>
                                <td>
                                    @if($story->status == 0)
                                        <span class="text text-danger">Ẩn</span>
                                    @elseif($story->status == 1)
                                        <span class="text text-success">Hiện</span>
                                    @endif

                                </td>
                                <td>
{{--                                    <button class="btn btn-info">--}}
                                        <a href="{{route('truyen.show',$story->id)}}"><i class="fa fa-eye"></i> </a>
{{--                                    </button>--}}
{{--                                    <button class="btn btn-success">--}}
                                        <a href="{{route('truyen.edit',$story->id)}}"><i class="fas fa-edit" style="color: #b0d4f1"></i> </a>
{{--                                    </button>--}}
{{--                                    <button class="btn btn-danger" type="button">--}}
                                        <i class="fas fa-trash" onclick="deleteStory({{$story->id}})"></i>
{{--                                    </button>--}}

                                    <form id="delete-from-{{$story->id}}"
                                          action="{{route('truyen.destroy',$story->id)}}"
                                          method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript">
        function deleteStory(id){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass:{
                    confirmButton:'btn btn-success',
                    cancelButton:'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title:'xoá danh mục',
                text:"bạn có chắc muốn xoá san pham này???",
                icon:'warning',
                showCancelButton:true,
                confirmButtonText:'có ',
                cancelButtonText:'thôi',
                reverseButtons:true
            }).then((result)=>{
                if(result.value){
                    event.preventDefault();
                    document.getElementById('delete-from-'+id).submit();
                }else if(
                    result.dismiss === Swal.DismissReason.cancel
                ){
                    swalWithBootstrapButtons.fire(
                        'cảnh báo',
                        'san pham này vẫn tồn tại',
                        'error'
                    )
                }
            })
        }
    </script>


@endpush

