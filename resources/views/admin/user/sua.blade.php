@extends('admin.layout.index')
    
    @section('content')
    
    <!-- Page Content -->
    <div id="page-wrapper">


            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">User
                            <small>{{$user->name}}</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
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
                    <div class="col-lg-7" style="padding-bottom:120px">
                        <form action="admin/user/sua/{{$user->id}}" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">   
                            <div class="form-group">
                                <label>Họ Tên</label>
                                <input class="form-control" name="name" value="{{$user->name}}" placeholder="Please Enter Name" />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" value="{{$user->email}}" readonly="" name="email" placeholder="Please Enter Email" />
                            </div>
                            <div class="form-group">
                            <input type="checkbox" id="changePassword" name="changePassword">
                                <label>Đổi mật khẩu</label>
                                <input disabled=""  class="form-control password" type="password" name="password" placeholder="Please Enter Password" />
                            </div>
                            <div class="form-group">
                                <label>Nhập lại mật khẩu</label>
                                <input disabled="" class="form-control password" type="password" name="passwordAgain" placeholder="Please Enter Password Again" />
                            </div>
                           
                            <div class="form-group">
                                <label>Quyền</label>
                                <label class="radio-inline">
                                    <input name="quyen"
                                    @if($user->quyen==1){{"checked"}} @endif
                                     value="1"  type="radio">Admin
                                </label>
                                <label class="radio-inline">
                                    <input name="quyen" value="0"  type="radio"
                                    @if($user->quyen==0){{"checked"}} @endif
                                    >Thường
                                </label>
                            </div>
                            <button type="submit" class="btn btn-default">Sửa</button>
                            <button type="reset" class="btn btn-default">Reset</button>
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
                $("#changePassword").change(function(){
                    if($(this).is(":checked")){
                        $(".password").removeAttr('disabled');    
                    } else{
                        $(".password").attr('disabled','');
                    }
                });
            });
    
        </script>
    @endsection