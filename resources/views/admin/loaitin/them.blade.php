    @extends('admin.layout.index')
    
    @section('content')
    
    <!-- Page Content -->
    <div id="page-wrapper">


            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Loại Tin
                            <small>Thêm</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                    @if(count($errors)>0)
                        <div class="alert alert danger">
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
                        <form action="admin/loaitin/them" method="POST">
                            <input type="hidden" name="_token" value="{{csrf_token()}} "/>
                          
                            <div class="form-group">
                            <label>Thể loại</label>
                                <select class="form-control" name="TheLoai">
                                    <option value="0">Please Choose Category</option>
                                    @foreach($theloai as $tl)
                                           <option value="{{$tl->id}}">{{$tl->Ten}}</option> 
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tên Loại Tin</label>
                                <input class="form-control" name="Ten" placeholder="Please Enter Category Name" />
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