<router-link tag="li" :to="{name : 'app.dashboard'}" class="bg-hover-darkGray">
    <a href="#" class="fg-white">
        <i class="uk-margin-small-right fa fa-home fa-2x uk-text-middle"></i>
        Dashboard
    </a>
</router-link>
<router-link tag="li" :to="{name : 'app.modules'}" class="bg-hover-darkGray">
    <a href="#" class="fg-white">
        <i class="uk-margin-small-right fa fa-cubes fa-2x uk-text-middle"></i>
        Modules
    </a>
</router-link>

@section('scripts')
    <script src="/themes/controlPanel/views/app/app.min.js"></script>
    @parent
@endsection