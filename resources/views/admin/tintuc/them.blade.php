    @extends('admin.layout.index')
    
    @section('content')
    
    <!-- Page Content -->
    <div id="page-wrapper">


            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Tin Tức
                            <small>Thêm</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                    @if(count($errors)>0)
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $err)
                                {{$err}}<br>;
                            @endforeach
                        </div>
                    @endif
                    @if(session('thongbao'))
                        <div class="alert alert-success">
                            {{session('thongbao')}}
                        </div>
                    @endif
                        <form action="admin/tintuc/them" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <!-- enctype="multipart/form-data" khai bao de upload file anh -->
                            <div class="form-group">
                                <label>Thể Loại</label>
                                <select id="TheLoai" class="form-control" name="TheLoai">
                                    @foreach($theloai as $tl)
                                        <option value="{{$tl->id}}">{{$tl->Ten}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Loại Tin</label>
                                <select id="LoaiTin" class="form-control" name="LoaiTin">
                                    @foreach($loaitin as $lt)
                                        <option value="{{$tl->id}}">{{$lt->Ten}}</option>
                                    @endforeach
                                  
                                </select>
                            </div>
                           
                            <div class="form-group">
                                <label>Tiêu đề</label>
                                <input class="form-control" name="TieuDe" placeholder="Nhập tiêu đề" />
                            </div>
                            
                            <div class="form-group">
                                <label>Tóm tắt</label>
                                <textarea id="demo" name="TomTat" class="form-control ckeditor" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Nội Dung</label>
                                <textarea id="demo" name="NoiDung" class="form-control ckeditor" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label >Hình Ảnh</label>
                                <input type="file" name="Hinh" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label>Nổi Bật</label>
                                <label class="radio-inline">
                                    <input name="NoiBat" value="0" checked="" type="radio">Không
                                </label>
                                <label class="radio-inline">
                                    <input name="NoiBat" value="1" type="radio">Có
                                </label>
                            </div>
                            <button type="submit" class="btn btn-default">Thêm</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>
                        <form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    @endsection 
    @section('script')

    
        <script>
            $(document).ready(function(){
               $("#TheLoai").change(function(){
                    var idTheLoai = $(this).val();
                    $.get("admin/ajax/loaitin/"+idTheLoai, function(data){
                        
                           $("#LoaiTin").html(data); 
                    });
                    // tao trang ajax
               });
            });
        </script>
        <!-- tao trang ajax de hien thi cac LoaiTin trong TheLoai da chon -->
    @endsection