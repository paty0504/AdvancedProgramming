<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin; //Khai bao model the loai 
use App\TheLoai;
class LoaiTinController extends Controller
{
    //
    public function getDanhSach(){
        $loaitin= Loaitin::all();
        return view('admin.loaitin.danhsach', ['loaitin'=>$loaitin]); //Truyen du lieu sang trang loaitin.danhsach
    }

    public function getThem(){
        $theloai = TheLoai::all(); //truyen danh sach the loai sang 
        return view('admin.loaitin.them', ['theloai'=>$theloai]);
    }

    public function postThem(Request $request){
        $this->validate($request,[
            'Ten' => 'required|unique:LoaiTin,Ten|min:1|max:100',
            'TheLoai'=>'required'
        ],
        [
            'Ten.required' => 'Bạn chưa nhập tên loại tin',
            'Ten.unique' => 'Tên loại tin đã tồn tại',
            'Ten.min'=>'Tên loại tin phải có độ dài từ 1 đến 100 ký tự',
            'Ten.max'=>'Tên loại tin phải có độ dài từ 1 đến 100 ký tự',
            'TheLoai.required'=>'Bạn chưa chọn thể loại'
        ]);
        $loaitin = new LoaiTin;
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTitle($request->Ten);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();
        return redirect('admin/loaitin/them')->with('thongbao','Bạn đã thêm thành công');
    }

    public function getSua($id){
        //Nhan ve $id tu route xong tim id tuong ung
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::find($id);
        //Tim xong truyen thong tin ve the loai can sua sang trang sua de hien thi
        return view('admin.loaitin.sua',['loaitin'=>$loaitin, 'theloai'=>$theloai]);
    }

    public function postSua(Request $request, $id){
        $loaitin = LoaiTin::find($id);
        $this->validate($request,
        [
            'Ten' => 'required|unique:LoaiTin,Ten|min:3|max:100', //unique: kiem tra ten co trung trong bang loaitin, cot Ten khong

        ],
        [
            'Ten.required' => 'Bạn chưa nhập tên thể loại',
            'Ten.unique' => 'Tên đã tồn tại',
            'Ten.min' => 'Tên thể loại phải có độ dài từ 3 đến 100 kí tự',
            'Ten.max' => 'Tên thể loại phải có độ dài từ 3 đến 100 kí tự',
        ]);
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTitle($request->Ten);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();
        return redirect('admin/loaitin/sua/'.$id)->with('thongbao','Sửa thành công');
    }
    public function getXoa($id){
        $loaitin = Loaitin::find($id);
        $loaitin -> delete();
        return redirect('admin/loaitin/danhsach')->with('thongbao','Đã xóa');
    }
} 
