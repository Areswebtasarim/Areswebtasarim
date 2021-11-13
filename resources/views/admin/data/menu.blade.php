<!--**********************************
        Sidebar start
    ***********************************-->
<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">

            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-paper-clip menu-icon"></i> <span class="nav-text">Sayfalar</span>
                </a>
                <ul aria-expanded="false">
                    @isset($moduller)
                        @foreach($moduller as $modul)
                            <li>
                                <a href="{{route('liste',$modul->selflink)}}" aria-expanded="false">
                                    <i class="icon-pie-chart menu-icon"></i><span class="nav-text">{{$modul->baslik}}</span>
                                </a>

                            </li>
                        @endforeach
                    @endisset

                </ul>
            </li>

            <li>
                <a href="{{route('moduller')}}" aria-expanded="false">
                    <i class="icon-folder menu-icon"></i><span class="nav-text">Modul Ekleme</span>
                </a>
            </li>
            <li>
                <a href="{{route('ayarlar')}}" aria-expanded="false">
                    <i class="icon-settings menu-icon"></i><span class="nav-text">Ayarlar</span>
                </a>
            </li>
            <li>
                <a href="{{route('iletisim')}}" aria-expanded="false">
                    <i class="icon-phone menu-icon"></i><span class="nav-text">İletişim Ayarları</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!--**********************************
    Sidebar end
***********************************-->
