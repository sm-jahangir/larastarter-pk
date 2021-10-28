<div class="list-group">
    <a href="{{ route('app.settings.general') }}" class="list-group-item list-group-item-action {{ Route::is('app.settings.index') ? 'active' : ''  }}">
        General
    </a>
    <a href="{{route('app.settings.appearance.index')}}" class="list-group-item list-group-item-action {{ Route::is('app.settings.appearance.index') ? 'active' : ''  }}">
        Appearance
    </a>
    <a href="" class="list-group-item list-group-item-action {{ Route::is('app.settings.mail.index') ? 'active' : ''  }}">
        Mail
    </a>
    <a href="" class="list-group-item list-group-item-action {{ Route::is('app.settings.socialite.index') ? 'active' : ''  }}">
        Socialite
    </a>
</div>