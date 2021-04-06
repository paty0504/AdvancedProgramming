<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TinTuc; //Khai bao model the loai 
use App\TheLoai;
use App\LoaiTin;
use App\Comment;
class TinTucController extends Controller
{
    //
    public function getDanhSach(){
        $tintuc= TinTuc::orderBy('id','DESC')->get();
        return view('admin.tintuc.danhsach', ['tintuc'=>$tintuc]); //Truyen du lieu sang trang tintuc.danhsach
    }

    public function getThem(){
        $theloai = TheLoai::all(); //truyen danh sach the loai sang 
        $loaitin = LoaiTin::all();
        return view('admin.tintuc.them', ['theloai'=>$theloai, 'loaitin'=>$loaitin]);
    }

    public function postThem(Request $request){
        $this->validate($request,[
            
            'LoaiTin'=>'required',
            'TieuDe'=>'required|unique:TinTuc,TieuDe|min:3|max:100',
            'TomTat'=>'required',
            'NoiDung'=>'required'
        ],
        [
            'LoaiTin.required' => 'Bạn chưa chon loại tin',
            'TieuDe.required' =>'Bạn chưa nhập tiêu đề',
            'TieuDe.unique' => 'Tiêu Đề đã tồn tại',
            'TieuDe.min'=>'Tiêu đề phải có độ dài từ 1 đến 100 ký tự',
            'TieuDe.max'=>'Tiêu đề phải có độ dài từ 1 đến 100 ký tự',
            'TomTat.required'=>'Bạn chưa nhập tóm tắt',
            'NoiDung.required'=>'Bạn chưa nhập nội dung'
        ]);
        $tintuc = new TinTuc;
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->SoLuotXem = 0;
        if($request->hasFile('Hinh')){
       
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg' ){
                return redirect('admin/tintuc/them')->with('loi','Bạn chỉ được chọn file có đuôi jpg, png, jpeg');
            }
            $name = $file->getClientOriginalName();
            $Hinh = str_random(4)."_".$name; 
            //randomr ra 1 chuoi de ten hinh k bi trung
            while(file_exists("upload/tintuc/".$Hinh)){
                $Hinh = str_random(4)."_".$name; 
            }
            $file->move("upload/tintuc", $Hinh);
            $tintuc->Hinh = $Hinh;
        }
        else{
            $tintuc->Hinh="";
        }
        $tintuc->save();
        return redirect('admin/tintuc/them')->with('thongbao','Bạn đã thêm thành công');
    }

    public function getSua($id){
        //Nhan ve $id tu route xong tim id tuong ung
        $loaitin = LoaiTin::all();
        $theloai = TheLoai::all();
        $tintuc = TinTuc::find($id);
        //Tim xong truyen thong tin ve tin tuc can sua sang trang sua de hien thi
        return view('admin.tintuc.sua',['tintuc'=>$tintuc, 'theloai'=>$theloai, 'loaitin'=>$loaitin]);
    }

    public function postSua(Request $request, $id){
        $tintuc = TinTuc::find($id);
        $this->validate($request,[
            
            'LoaiTin'=>'required',
            'TieuDe'=>'required|unique:TinTuc,TieuDe|min:3|max:100',
            'TomTat'=>'required',
            'NoiDung'=>'required'
        ],
        [
            'LoaiTin.required' => 'Bạn chưa chon loại tin',
            'TieuDe.required' =>'Bạn chưa nhập tiêu đề',
            'TieuDe.unique' => 'Tiêu Đề đã tồn tại',
            'TieuDe.min'=>'Tiêu đề phải có độ dài từ 1 đến 100 ký tự',
            'TieuDe.max'=>'Tiêu đề phải có độ dài từ 1 đến 100 ký tự',
            'TomTat.required'=>'Bạn chưa nhập tóm tắt',
            'NoiDung.required'=>'Bạn chưa nhập nội dung'
        ]);
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
   
        if($request->hasFile('Hinh')){
       
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg' ){
                return redirect('admin/tintuc/them')->with('loi','Bạn chỉ được chọn file có đuôi jpg, png, jpeg');
            }
            $name = $file->getClientOriginalName();
            $Hinh = str_random(4)."_".$name; 
            //randomr ra 1 chuoi de ten hinh k bi trung
            while(file_exists("upload/tintuc/".$Hinh)){
                $Hinh = str_random(4)."_".$name; 
            }
            
            $file->move("upload/tintuc", $Hinh);
            unlink("upload/tintuc/".$tintuc->Hinh); 
            // Xoa file hinh cu

            $tintuc->Hinh = $Hinh;
            //Luu file hinh moi
        }
       
        $tintuc->save();
        return redirect('admin/tintuc/sua/'.$id)->with('thongbao','Sửa thành công');
    }
    public function getXoa($id){
        $tintuc = TinTuc::find($id);
        $tintuc -> delete();
        return redirect('admin/tintuc/danhsach')->with('thongbao','Đã xóa');
    }
} 
