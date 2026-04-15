<tr>
    <td>{{ $menu->id }}</td>
    <td>{{ $menu->parent?->menu ?? '-' }}</td>
    <td>{!! str_repeat('— ', $level) !!} {{ $menu->menu }}</td>
    <td>{{ $menu->route ?? '-' }}</td>
    <td>{{ $menu->urutan }}</td>
    <td>
        <div class="btn-group">
            <button type="button" onclick="editForm('{{route('menu.update', $menu->id) }}')" class="btn btn-xs btn-info btn-flat"><i class="fas fa-pen-alt    "></i></button>
            <button type="button" onclick="deleteData('{{route('menu.destroy', $menu->id) }}')" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
        </div>
    </td>
</tr>
@if ($menu->children->isNotEmpty())
    @foreach($menu->children as $child)
        @include('menu.partial', ['menu' => $child, 'level' => $level + 1])
    @endforeach
@endif
