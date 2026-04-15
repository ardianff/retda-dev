{{-- <li>
    <div class="icheck-primary d-inline">
        <input type="checkbox" class="menu-checkbox" id="menu-{{ $menu->id }}" name="menu_id[]" value="{{ $menu->id }}">
        <label for="menu-{{ $menu->id }}">{{ $menu->menu }}</label>
    </div>

    @if (!empty($menu->children))
        <ul class="ml-3">
            @foreach ($menu->children as $child)
                @include('user.partials_menu', ['menu' => $child])
            @endforeach
        </ul>
    @endif
</li> --}}
<li>
    <div class="icheck-primary d-inline">
        <input type="checkbox" class="menu-checkbox" id="menu-{{ $menu->id }}" name="menu_id[]" value="{{ $menu->id }}"
            {{ in_array($menu->id, $userMenuIds) ? 'checked' : '' }}>
        <label for="menu-{{ $menu->id }}">{{ $menu->menu }}</label>
    </div>

    @if ($menu->children->isNotEmpty())
        <ul class="ml-3">
            @foreach ($menu->children as $child)
                @include('akses.partials_menu', ['menu' => $child, 'userMenuIds' => $userMenuIds])
            @endforeach
        </ul>
    @endif
</li>
