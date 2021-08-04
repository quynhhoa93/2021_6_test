@extends('layouts.app')
@push('css')
@endpush

@section('content')
    @include('layouts.nav')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Liệt kê danh mục truyện</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif


                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên danh mục</th>
                                <th scope="col">Slug danh mục</th>
                                <th scope="col">Mô tả danh mục</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $key=>$category)
                                <tr>
                                    <th scope="row">{{++$key}}</th>
                                    <td>{{$category->nameCategory}}</td>
                                    <td>{{$category->slug}}</td>
                                    <td>{{$category->descriptionCategory}}</td>
                                    <td>
                                        @if($category->status == 0)
                                            <span class="text text-danger">Ẩn</span>
                                        @elseif($category->status == 1)
                                            <span class="text text-success">Hiện</span>
                                        @endif
                                    </td>
                                    <td><a href="{{route('danh-muc.edit',$category->id)}}"><button class="btn btn-success btn-mini">sửa</button> </a>|
                                        <button class="btn btn-danger" type="button"
                                                onclick="deleteCategory({{$category->id}})">
                                            <i>xoá</i>
                                        </button>

                                        <form id="delete-from-{{$category->id}}"
                                              action="{{route('danh-muc.destroy',$category->id)}}"
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
    </div>
@endsection



@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript">
        function deleteCategory(id){
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




<
