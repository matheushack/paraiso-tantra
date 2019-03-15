<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>

<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark pink">
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark" m-menu-vertical="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item  {{isset($menu_active) && $menu_active == 'dashboard' ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                <a href="{{url('/dashboard')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">Dashboard</span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item {{isset($menu_active) && $menu_active == 'customers' ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                <a href="{{route('customers')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-users"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">Clientes</span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{isset($menu_parent_active) && $menu_parent_active == 'units' ? 'm-menu__item--open m-menu__item--expanded' : ''}}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
                <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-map-location"></i>
                    <span class="m-menu__link-text">Unidades</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item {{isset($menu_active) && $menu_active == 'manage-units' ? 'm-menu__item--active' : ''}} " aria-haspopup="true" >
                            <a  href="{{route('units')}}" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-cogwheel"></i>
                                <span class="m-menu__link-text">Gerenciar</span>
                            </a>
                        </li>
                        <li class="m-menu__item  {{isset($menu_active) && $menu_active == 'employees' ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                            <a  href="{{route('employees')}}" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-profile-1"></i>
                                <span class="m-menu__link-text">Funcionários</span>
                            </a>
                        </li>
                        <li class="m-menu__item  {{isset($menu_active) && $menu_active == 'rooms' ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                            <a  href="{{route('rooms')}}" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-squares-4"></i>
                                <span class="m-menu__link-text">Salas</span>
                            </a>
                        </li>
                        <li class="m-menu__item  {{isset($menu_active) && $menu_active == 'services' ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                            <a  href="{{route('services')}}" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-cart"></i>
                                <span class="m-menu__link-text">Serviços</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="m-menu__item  {{isset($menu_active) && $menu_active == 'calls' ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                <a href="{{route('calls')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-event-calendar-symbol"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">Atendimentos</span>
                        </span>
                    </span>
                </a>
            </li>
            @if(Auth::user()->profile_id == 1)
                <li class="m-menu__item  m-menu__item--submenu {{isset($menu_parent_active) && $menu_parent_active == 'financial' ? 'm-menu__item--open m-menu__item--expanded' : ''}}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
                    <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon flaticon-coins"></i>
                        <span class="m-menu__link-text">Financeiro</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu ">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">
                            <li class="m-menu__item  {{isset($menu_active) && $menu_active == 'accounts' ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                                <a  href="{{route('accounts')}}" class="m-menu__link ">
                                    <i class="m-menu__link-icon flaticon-piggy-bank"></i>
                                    <span class="m-menu__link-text">Contas</span>
                                </a>
                            </li>
                            <li class="m-menu__item {{isset($menu_active) && $menu_active == 'payments' ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                                <a href="{{route('payments')}}" class="m-menu__link">
                                    <i class="m-menu__link-icon flaticon-cart"></i>
                                    <span class="m-menu__link-title">
                                        <span class="m-menu__link-wrap">
                                            <span class="m-menu__link-text">Formas de pagamento</span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="m-menu__item  m-menu__item--submenu {{isset($menu_parent_active) && $menu_parent_active == 'bills' ? 'm-menu__item--open m-menu__item--expanded' : ''}}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
                    <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon fa fa-money"></i>
                        <span class="m-menu__link-text">Contas a pagar</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu ">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">
                            <li class="m-menu__item  {{isset($menu_active) && $menu_active == 'providers' ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                                <a  href="{{route('providers')}}" class="m-menu__link ">
                                    <i class="m-menu__link-icon flaticon-users"></i>
                                    <span class="m-menu__link-text">Fornecedores</span>
                                </a>
                            </li>
                            <li class="m-menu__item  {{isset($menu_active) && $menu_active == 'manage-bills' ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                                <a  href="{{route('bills')}}" class="m-menu__link ">
                                    <i class="m-menu__link-icon flaticon-cogwheel"></i>
                                    <span class="m-menu__link-text">Gerenciar</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            <li class="m-menu__item  m-menu__item--submenu {{isset($menu_parent_active) && $menu_parent_active == 'reports' ? 'm-menu__item--open m-menu__item--expanded' : ''}}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
                <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-graphic-2"></i>
                    <span class="m-menu__link-text">Relatórios</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  {{isset($menu_active) && $menu_active == 'calls' ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                            <a  href="{{route('reports.calls')}}" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-event-calendar-symbol"></i>
                                <span class="m-menu__link-text">Atendimentos</span>
                            </a>
                        </li>
                        <li class="m-menu__item  {{isset($menu_active) && $menu_active == 'customers' ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                            <a  href="{{route('reports.customers')}}" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-users"></i>
                                <span class="m-menu__link-text">Clientes</span>
                            </a>
                        </li>
                        <li class="m-menu__item  {{isset($menu_active) && $menu_active == 'accounts' ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                            <a  href="{{route('reports.accounts')}}" class="m-menu__link ">
                                <i class="m-menu__link-icon fa fa-money"></i>
                                <span class="m-menu__link-text">Contas</span>
                            </a>
                        </li>
                        <li class="m-menu__item  {{isset($menu_active) && $menu_active == 'commissions' ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                            <a  href="{{route('reports.commissions')}}" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-coins"></i>
                                <span class="m-menu__link-text">Comissão</span>
                            </a>
                        </li>
                        <li class="m-menu__item  {{isset($menu_active) && $menu_active == 'extract' ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                            <a  href="{{route('reports.extract')}}" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-list-1"></i>
                                <span class="m-menu__link-text">Extrato</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @if(Auth::user()->profile_id == 1)
                <li class="m-menu__item  m-menu__item--submenu {{isset($menu_parent_active) && $menu_parent_active == 'system' ? 'm-menu__item--open m-menu__item--expanded' : ''}}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
                    <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon flaticon-map-location"></i>
                        <span class="m-menu__link-text">Sistema</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu ">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">
                            <li class="m-menu__item  {{isset($menu_active) && $menu_active == 'users' ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                                <a  href="{{route('users')}}" class="m-menu__link ">
                                    <i class="m-menu__link-icon flaticon-users"></i>
                                    <span class="m-menu__link-text">Usuários</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</div>