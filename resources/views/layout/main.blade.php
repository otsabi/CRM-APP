<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{asset('theme/vendors/materialdesign-webfont/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('theme/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('theme/vendors/dropify/dropify.min.css')}}">

    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('theme/css/vertical-layout-light/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('theme/images/favicon.png')}}" />


    @stack('styles')
</head>

<body>
<div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
            <ul class="navbar-nav mr-lg-2 d-none d-lg-flex">
                <li class="nav-item nav-toggler-item">
                    <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </li>

            </ul>
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="#"><img src="{{asset('theme/images/logo_hi.png')}}" alt="logo"/></a>
                <a class="navbar-brand brand-logo-mini" href="#"><img src="{{asset('theme/images/logo_hi.png')}}" alt="logo"/></a>
            </div>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item nav-profile">
                    <a class="nav-link" href="#">
                        <span class="nav-profile-name">Salut, {{Auth::user()->nom}} {{Auth::user()->prenom}}</span>
                    </a>
                </li>

                <li class="nav-item nav-profile">
                    <a style="font-size: 1.4rem;color: #000" class="nav-link" href="{{ route('logout')}}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout"></i>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

                <li class="nav-item nav-toggler-item-right d-lg-none">
                    <button class="navbar-toggler align-self-center" type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </li>
            </ul>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">

            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                     @admin

                        <li class="nav-item">
                            <a class="nav-link" href="{{route(session('dashboardUrl'))}}">
                                <i class="mdi mdi-view-quilt menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#users" aria-expanded="false" aria-controls="users">
                                <i class="mdi mdi-account menu-icon"></i>
                                <span class="menu-title">Utilisateurs</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="users" style="">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="{{route('admin.users.index')}}">Liste des utilisateurs </a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{route('admin.users.create')}}">Nouveau utilisateur</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#medecins" aria-expanded="false" aria-controls="medecins">
                                <i class="mdi mdi-doctor menu-icon"></i>
                                <span class="menu-title">Médecins</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="medecins">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="{{route('admin.medecins.index')}}">Liste des médecins</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="{{route('admin.medecins.create')}}">Nouveau médecin</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#pharmacies" aria-expanded="false" aria-controls="pharmacies">
                                <i class="mdi mdi-hospital-building menu-icon"></i>
                                <span class="menu-title">Pharmacies</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="pharmacies">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="{{route('admin.pharmacies.index')}}">Liste des pharmacies</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="{{route('admin.pharmacies.create')}}">Nouvelle pharmacie</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.bc.index')}}">
                                <i class="mdi mdi-newspaper-variant-outline menu-icon"></i>
                                <span class="menu-title">PS Business case</span>
                            </a>
                        </li>

                        <div class="dropdown-divider"></div>


                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#rapportmed" aria-expanded="false" aria-controls="rapportmed">
                                <i class="mdi mdi-file-excel menu-icon"></i>
                                <span class="menu-title">Rapport Med</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="rapportmed" style="">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="{{route('file_import_rapportMed')}}"> Importer Rapport Med </a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{route('show_rapport_med')}}">Liste Rapport Med</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#rapportph" aria-expanded="false" aria-controls="rapportph">
                                <i class="mdi mdi-file-excel menu-icon"></i>
                                <span class="menu-title">Rapport Ph</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="rapportph" style="">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="{{route('file_import_rapportPh')}}"> Importer Rapport Ph </a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{route('show_rapport_ph')}}">Liste Rapport Ph</a></li>
                                </ul>
                            </div>
                        </li>


                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.visitemed')}}">
                                <i class="mdi mdi-stethoscope menu-icon"></i>
                                <span class="menu-title">Visites médicales</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.visiteph')}}">
                                <i class="mdi mdi-hospital-box menu-icon"></i>
                                <span class="menu-title">Visites pharmacies</span>
                            </a>
                        </li> --}}



                        <div class="dropdown-divider"></div>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#produits" aria-expanded="false" aria-controls="produits">
                                <i class="mdi mdi-pill menu-icon"></i>
                                <span class="menu-title">Produits</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="produits" style="">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="{{route('admin.products.index')}}">Liste des Produits </a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{route('admin.products.create')}}">Nouveau Produit</a></li>
                                </ul>
                            </div>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.gammes.index')}}">
                                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                                <span class="menu-title">Gammes</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.villes.index')}}">
                                <i class="mdi mdi-map-marker menu-icon"></i>
                                <span class="menu-title">Villes</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.secteurs.index')}}">
                                <i class="mdi mdi-map menu-icon"></i>
                                <span class="menu-title">Secteurs</span>
                            </a>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.specialites.index')}}">
                                <i class="mdi mdi-stethoscope menu-icon"></i>
                                <span class="menu-title">Spécialités</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.feedbacks.index')}}">
                                <i class="mdi mdi-view-quilt menu-icon"></i>
                                <span class="menu-title">Feedbacks</span>
                            </a>

                        </li>

                        <div class="dropdown-divider"></div>

                      @endadmin

                       @if(!Auth::user()->isAdmin())

                            <li class="nav-item">
                                <a class="nav-link" href="/">
                                    <i class="mdi mdi-view-quilt menu-icon"></i>
                                    <span class="menu-title">Dashboard</span>
                                </a>
                            </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../../index.html">
                                <i class="mdi mdi-calendar-month-outline menu-icon"></i>
                                <span class="menu-title">Mon Calendrier</span>
                            </a>
                        </li>
                            @if(Auth::user()->hasRole(['KAM','DM','DSM']))
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#visitemed" aria-expanded="false" aria-controls="visitemed">
                                    <i class="mdi mdi-account-badge-horizontal-outline menu-icon"></i>
                                    <span class="menu-title">Visites Médicale</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="collapse" id="visitemed">
                                    <ul class="nav flex-column sub-menu">
                                        <li class="nav-item"> <a class="nav-link" href="{{route('medvisites.index')}}">Mes visites médicales</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="{{route('medvisites.create')}}">Nouvelle visite</a></li>
                                    </ul>
                                </div>
                            </li>
                            @endif
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#visiteph" aria-expanded="false" aria-controls="visiteph">
                                <i class="mdi mdi-store menu-icon"></i>
                                <span class="menu-title">Visites Pharmacie</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="visiteph">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="{{route('phvisites.index')}}">Mes visites Pharma</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="{{route('phvisites.create')}}">Nouvelle visite</a></li>
                                </ul>
                            </div>
                        </li>

                        @if(Auth::user()->hasRole(['KAM','DM','DSM']))
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#medecins" aria-expanded="false" aria-controls="medecins">
                                <i class="mdi mdi-layers menu-icon"></i>
                                <span class="menu-title">Médecins</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="medecins">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="{{route('medecins.index')}}">Liste des médecins</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="{{route('medecins.create')}}">Nouveau médecin</a></li>
                                </ul>
                            </div>
                        </li>


                        </li>
                        @endif

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#pharmacies" aria-expanded="false" aria-controls="pharmacies">
                                <i class="mdi mdi-layers menu-icon"></i>
                                <span class="menu-title">Pharmacies</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="pharmacies">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="{{route('pharmacies.index')}}">Liste des pharmacies</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="{{route('pharmacies.create')}}">Nouvelle pharmacie</a></li>
                                </ul>
                            </div>
                        </li>
                        @if(Auth::user()->hasRole(['KAM','DM','DSM']))
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#bcs" aria-expanded="false" aria-controls="bcs">
                                <i class="mdi mdi-currency-usd menu-icon"></i>
                                    <span class="menu-title">Business case</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="bcs">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="{{route('bcs.index')}}">Mes BCs</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="{{route('bcs.create')}}">Nouveau BC</a></li>
                                </ul>
                            </div>
                        </li>

                        @endif

                            @if(Auth::user()->hasRole(['KAM','DSM']))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('medvisites.validation')}}">
                                        <i class="mdi mdi-account-card-details-outline menu-icon"></i>
                                        <span class="menu-title">Visites par PS</span>
                                    </a>
                                </li>

                            @endif

                     @endif

                    </ul>
                  </nav>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:../../partials/_footer.html -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © {{Carbon\Carbon::now()->format('Y')}}. All rights reserved.</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Made with <i class="mdi mdi-heart text-danger"></i></span>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="{{asset('theme/vendors/js/vendor.bundle.base.js')}}"></script>
<script src="{{asset('theme/vendors/dropify/dropify.min.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{asset('theme/js/off-canvas.js')}}"></script>
<script src="{{asset('theme/js/hoverable-collapse.js')}}"></script>
<script src="{{asset('theme/js/template.js')}}"></script>
<script src="{{asset('theme/js/settings.js')}}"></script>
<script src="{{asset('theme/js/todolist.js')}}"></script>
<script src="{{asset('theme/js/dropify.js')}}"></script>


@stack('scripts')
<!-- endinject -->
<!-- Custom js for this page-->
<!-- End custom js for this page-->

@yield('modals')

</body>

</html>
