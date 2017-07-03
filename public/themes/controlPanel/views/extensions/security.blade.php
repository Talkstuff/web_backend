<li>
    <a class="nav-submenu" data-toggle="nav-submenu" href="#">
        <i class="si si-lock fa-2x uk-text-middle"></i>
        Security
    </a>
    <ul>
        <router-link tag="li" :to="{name : 'security.permissions'}">
            <a href="#" class="fg-hover-white">
                <i class="uk-margin-small-right fa fa-key fa-2x uk-text-middle"></i>
                Permissions
            </a>
        </router-link>

        <router-link tag="li" :to="{name : 'security.roles'}">
        <a href="#" class="fg-hover-white">
            <i class="uk-margin-small-right fa fa-check-circle fa-2x uk-text-middle"></i>
            Roles
        </a>
        </router-link>

        <router-link tag="li" :to="{name : 'security.change_password'}">
            <a href="#" class="fg-hover-white">
                <i class="uk-margin-small-right fa fa-unlock fa-2x uk-text-middle"></i>
                Change Password
            </a>
        </router-link>
    </ul>
</li>

@push('user_drop_down')
<router-link tag="li" :to="{name : 'security.change_password'}" class="">
    <a class="" href="#">Change Password</a>
</router-link>
@endpush

@section('scripts')
    <script src="/themes/controlPanel/views/security/security.min.js"></script>
    @parent
@endsection