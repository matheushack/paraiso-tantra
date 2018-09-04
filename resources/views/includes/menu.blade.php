<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>

<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark pink">
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark" m-menu-vertical="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item  m-menu__item--active" aria-haspopup="true" >
                <a href="{{url('/dashboard')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">Dashboard</span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item" aria-haspopup="true" >
                <a href="{{url('/dashboard')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-users"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">Clientes</span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  m-menu-submenu-toggle="hover">
                <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-map-location"></i>
                    <span class="m-menu__link-text">Unidades</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item " aria-haspopup="true" >
                            <a  href="components/base/state.html" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-cogwheel"></i>
                                <span class="m-menu__link-text">Gerenciar</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true" >
                            <a  href="components/base/state.html" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-profile-1"></i>
                                <span class="m-menu__link-text">Funcionários</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true" >
                            <a  href="components/base/state.html" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-squares-4"></i>
                                <span class="m-menu__link-text">Salas</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true" >
                            <a  href="components/base/state.html" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-like"></i>
                                <span class="m-menu__link-text">Serviços</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="m-menu__item" aria-haspopup="true" >
                <a href="{{url('/dashboard')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-event-calendar-symbol"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">Atendimentos</span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item" aria-haspopup="true" >
                <a href="{{url('/dashboard')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-piggy-bank"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">Financeiro</span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  m-menu-submenu-toggle="hover">
                <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-map-location"></i>
                    <span class="m-menu__link-text">Sistema</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item " aria-haspopup="true" >
                            <a  href="components/base/state.html" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-cogwheel"></i>
                                <span class="m-menu__link-text">Usuários</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true" >
                            <a  href="components/base/state.html" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-profile-1"></i>
                                <span class="m-menu__link-text">Perfis</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true" >
                            <a  href="components/base/state.html" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-squares-4"></i>
                                <span class="m-menu__link-text">Permissões</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true" >
                            <a  href="components/base/state.html" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-like"></i>
                                <span class="m-menu__link-text">Parâmetros</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>