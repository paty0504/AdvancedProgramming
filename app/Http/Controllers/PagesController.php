<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\TheLoai;
use App\Slide;
use App\LoaiTin;
use App\TinTuc;
use App\User;
class PagesController extends Controller
{
    //
    function __construct(){
        $slide = Slide::all();
        $theloai = TheLoai::all();
        view()->share('theloai',$theloai);
        view()->share('slide',$slide);

        if(Auth::check()){
            view()->share('nguoidung',Auth::user());
        } 
    }
    function trangchu(){
       
        return view('pages.trangchu');
    }
    function lienhe(){
        
        return view('pages.lienhe');
    }
    function loaitin($id){
        $loaitin = LoaiTin::find($id);
        $tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5);
        return view('pages.loaitin',['loaitin'=>$loaitin,'tintuc'=>$tintuc]);
    }
    function tintuc($id){
        $tintuc = TinTuc::find($id);
        $tinnoibat = TinTuc::where('NoiBat',1)->take(4)->get();
        $tinlienquan = TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
        return view('pages.tintuc',['tintuc'=>$tintuc, 'tinnoibat'=>$tinnoibat, 'tinlienquan'=>$tinlienquan]);
    }

    function getDangNhap(){
        return view('pages.dangnhap');
    }
    function postDangNhap(Request $request){
        $this->validate($request,[
            'email'=>'required',
            'password'=>'required|min:3|max:32',
        ],
        [
            'email.required' => 'bạn chưa nhập email',
            'password.required' => 'ban chua nhap password',
            'password.min' => 'Password co do dai tu 3 den 32 ky tu',
            'password.max' => 'Password co do dai tu 3 den 32 ky tu',
        ]);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('trangchu');
        }         
        else{
            return redirect('dangnhap')->with('thongbao','Đăng nhập không thành công');
        }
    }
    function getDangxuat(){
        Auth::logout();
        return redirect('trangchu');
    }
    function getNguoiDung(){
        $user = Auth::user();
        return view('pages.nguoidung',['nguoidung'=>$user]);
    }
    function postNguoiDung(Request $request){
        $this->validate($request,[
            'name' => 'required|min:3',
           
            
          ],[
            'name.required' => 'Bạn chưa nhập tên người dùng',
            'name.min' => 'Tên người dùng phải có ít nhất 3 ký tự',
           
          ]);
          $user = Auth::user();
          $user->name = $request->name;
         
         if($request->changePassword == "on")
          {
            $this->validate($request,[
               
                'password' => 'required|min:3|max:32',
                'passwordAgain' => 'required|same:password'
              ],[
              
                'password.required' => 'Bạn chưa nhập mật khẩu',
                'password.min' => 'mật khẩu phải có độ dài từ 3 đến 32 ký tự',
                'password.max' => 'mật khẩu phải có độ dài từ 3 đến 32 ký tự',
                'passwordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
                'passwordAgain.same' => 'Mật khẩu không khớp'
              ]);  
            $user->password = bcrypt($request->password);}

          
          $user->save();
          return redirect('nguoidung')->with('thongbao','Bạn đã sửa thành công');
    }

    function getDangky(){
        return view('pages.dangky');
    }
    function postDangky(Request $request){
        $this->validate($request,[
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3|max:32',
            'passwordAgain' => 'required|same:password'
          ],[
            'name.required' => 'Bạn chưa nhập tên người dùng',
            'name.min' => 'Tên người dùng phải có ít nhất 3 ký tự',
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Bạn chưa nhập đúng định dạng email',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'password.min' => 'mật khẩu phải có độ dài từ 3 đến 32 ký tự',
            'password.max' => 'mật khẩu phải có độ dài từ 3 đến 32 ký tự',
            'passwordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
            'passwordAgain.same' => 'Mật khẩu không khớp'
          ]);
          $user = new User;
          $user->name = $request->name;
          $user->email = $request->email;
          $user->password = bcrypt($request->password);
          $user->quyen = 0;
          $user->save();
          return redirect('dangnhap')->with('thongbao','Đăng ký thành công');
    }

}
