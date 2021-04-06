<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai; //Khai bao model the loai 

class TheLoaiController extends Controller
{
    //
    public function getDanhSach(){
        $theloai= TheLoai::all();
        return view('admin.theloai.danhsach', ['theloai'=>$theloai]); //Truyen du lieu sang trang theloai.danhsach
    }

    public function getThem(){
        return view('admin.theloai.them');
    }

    public function postThem(Request $request){
       $this->validate($request,
       [
        'Ten' => 'required|unique:TheLoai,Ten|min:3|max:100'
       ],
       [
        'Ten.required' => 'Bạn chưa nhập tên thể loại',
        'Ten.min' => 'Tên thể loại phải có độ dài từ 3 đến 100 kí tự',
        'Ten.max' => 'Tên thể loại phải có độ dài từ 3 đến 100 kí tự',
        'Ten.unique' => 'Tên đã tồn tại',
       ]);
       $theloai = new TheLoai; //Lay du lieu luu vao model TheLoai
       $theloai->Ten = $request->Ten;
       $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();
        return redirect('admin/theloai/them')->with('thongbao','Thêm thành công');
    }

    public function getSua($id){
        //Nhan ve $id tu route xong tim id tuong ung
        $theloai = TheLoai::find($id);
        //Tim xong truyen thong tin ve the loai can sua sang trang sua de hien thi
        return view('admin.theloai.sua',['theloai'=>$theloai]);
    }

    public function postSua(Request $request, $id){
        $theloai = TheLoai::find($id);
        $this->validate($request,
        [
            'Ten' => 'required|unique:TheLoai,Ten|min:3|max:100', //unique: kiem tra ten co trung trong bang TheLoai, cot Ten khong

        ],
        [
            'Ten.required' => 'Bạn chưa nhập tên thể loại',
            'Ten.unique' => 'Tên đã tồn tại',
            'Ten.min' => 'Tên thể loại phải có độ dài từ 3 đến 100 kí tự',
            'Ten.max' => 'Tên thể loại phải có độ dài từ 3 đến 100 kí tự',
        ]);
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();
        return redirect('admin/theloai/sua/'.$id)->with('thongbao','Sửa thành công');
    }
    public function getXoa($id){
        $theloai = TheLoai::find($id);
        $theloai -> delete();
        return redirect('admin/theloai/danhsach')->with('thongbao','Đã xóa');
    }
} 
