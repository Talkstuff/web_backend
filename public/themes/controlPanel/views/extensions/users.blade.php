<router-link tag="li" :to="{name : 'users'}" class="bg-hover-darkGray">
    <a href="#" class="fg-white">
        <i class="uk-margin-small-right fa fa-user fa-2x uk-text-middle"></i>
        Users
    </a>
</router-link>

@section('scripts')
    <script src="/themes/controlPanel/views/users/users.js"></script>
    @parent
@endsection