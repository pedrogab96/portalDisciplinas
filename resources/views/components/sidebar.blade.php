<div id="sidebar">

    <div class="d-flex align-items-center">
        <label class="">
            <i class="fas fa-bars navbar-icon" id='sidebar_btn-active' onclick="move(false)"></i>
        </label>
    </div>

    <div class="text-center">
        @auth
            <div class="user">
                {{-- <img src="img/img1.jpg" alt="" class="sidebar-image_profile"> --}}
                <p class="name_user">{{ Str::words( Auth::user()->name, 2, '' ) }}</p>
            </div>
        @endauth

        <ul class="sidebar-list">

            <li class="sidebar-item">
                <a class="list-links" href="{{route("index")}}">Inicio</a>
            </li>

            @auth
                {{-- <li class="sidebar-item">
                    <a href="" class="list-links">Meu perfil </a>
                </li> --}}
                <li class="sidebar-item">
                    <a href="{{route("mydisciplines")}}" class="list-links">Minhas disciplinas</a>
                </li>
            @endauth
            
            

            <li class="sidebar-item">
                <a class="list-links" href="#">Sobre</a>
            </li>
            <li class="sidebar-item">
                <a class="list-links" href="#">FAQ</a>
            </li>
        </ul>
    </div>
</div>