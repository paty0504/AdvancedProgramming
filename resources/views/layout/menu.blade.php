<div class="col-md-3 ">
        <ul class="list-group" id="menu">
            <li href="#" class="list-group-item menu1 active">
                Menu
            </li>
            @foreach($theloai as $tl)
                @if(count($tl->loaitin)>0)
                <!-- kiem tra xem trong the loai co loai tin nao khong, neu k co thi k in ra; -->
            <li href="#" class="list-group-item menu1">
                {{$tl->Ten}}
            </li>

            <ul>
                @foreach($tl->loaitin as $lt)
                <li class="list-group-item">
                    <a href="loaitin/{{$lt->id}}/{{$lt->TenKhongDau}}.html">{{$lt->Ten}}</a>
                </li>
                @endforeach
            </ul>
                 @endif
            @endforeach
          
        </ul>
    </div>