            <!-- Left Sidebar Start -->
            <div class="app-sidebar-menu">
                <div class="h-100" data-simplebar>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <div class="logo-box">
                            <a class='logo logo-light' href='dashboard.html'>
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm.png" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-light.png" alt="" height="24">
                                </span>
                            </a>
                            <a class='logo logo-dark' href='dashboard.html'>
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm.png" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-dark.png" alt="" height="24">
                                </span>
                            </a>
                        </div>

                        <ul id="side-menu">

                            <!-- Dashboard -->
                            <li>
                                <a href="{{ route('dashboard') }}">
                                    <i data-feather="home"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>


                            <!-- Section Gestion pour Super Admin -->
                            <li class="menu-title">Gestion</li>

                            <li>
                                <a href="#sidebarUsers" data-bs-toggle="collapse">
                                    <i data-feather="users"></i>
                                    <span>Utilisateurs</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarUsers">
                                    <ul class="nav-second-level">
                                        @if (Auth::user()->role === 'superadm')
                                            <li>
                                                <a href="{{ route('managers') }}">Managers</a>
                                            </li>
                                        @endif
                                        <li>
                                            <a href="{{ route('clients') }}">Clients</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('drivers') }}">Livreurs</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @if (Auth::user()->role === 'superadm')
                                <li>
                                    <a href="companies-list.html">
                                        <i data-feather="briefcase"></i>
                                        <span>Sociétés de livraison</span>
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->role === 'superadm' || Auth::user()->role === 'manager')
                                <!-- Section pour Managers et Super Admin -->
                                <li>
                                    <a href="{{ route('parcels-list') }}">
                                        <i data-feather="package"></i>
                                        <span>Colis</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('transports-list') }}">
                                        <i data-feather="truck"></i>
                                        <span>Moyens de transport</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('zone-list') }}">
                                        <i data-feather="map-pin"></i>
                                        <span>Zones de livraison</span>
                                    </a>
                                </li>
                            @endif
                            <li class="menu-title mt-2">Rapports & Paramètres</li>
                            <li>
                                <a href="{{ route('reports') }}">
                                    <i data-feather="bar-chart-2"></i>
                                    <span>Rapports</span>
                                </a>
                            </li>
                            <!-- Section Rapports & Paramètres pour Super Admin -->
                            @if (Auth::user()->role === 'superadm')
                                <li>
                                    <a href="{{ route('settings') }}">
                                        <i data-feather="settings"></i>
                                        <span>Paramètres</span>
                                    </a>
                                </li>
                            @endif

                        </ul>

                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                    <!-- Assistance Card -->
                    <div class="sidebar-support-card p-3 text-center bg-light rounded shadow-sm mt-3 mx-3">
                        <i data-feather="headphones" class="text-primary" width="40" height="40"></i>
                        <h6 class="mt-2">Besoin d'aide ?</h6>
                        <p class="small text-muted">Notre équipe est disponible pour toute assistance.</p>
                        <a href="{{ route('support.index') }}" class="btn btn-primary btn-sm w-100">Contact Support</a>
                    </div>
                </div>
            </div>
            <!-- Left Sidebar End -->
