<!-- This file is used to store topbar (right) items -->


 <li class="nav-item d-md-down-none"><a class="nav-link" href="#"><i class="la la-bell"></i><span class="badge badge-pill badge-danger">{{ \App\Models\Announcement::where("receiver", "=", backpack_user()->role)->count() }}</span></a></li>
{{--<li class="nav-item d-md-down-none"><a class="nav-link" href="#"><i class="la la-list"></i></a></li>
<li class="nav-item d-md-down-none"><a class="nav-link" href="#"><i class="la la-map"></i></a></li>--}}
