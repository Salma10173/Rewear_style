@extends('layouts.admin')
@section('title','Categories')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div></div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-accent px-4">
        <i class="fa fa-plus me-1"></i> Ajouter une catégorie
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius:6px">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Nom</th><th>Slug</th><th>Produits</th><th>Statut</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td class="fw-medium">{{ $cat->name }}</td>
                    <td><code style="font-size:.78rem">{{ $cat->slug }}</code></td>
                    <td>{{ $cat->products_count }}</td>
                    <td>
                        <span class="badge {{ $cat->is_active ? 'bg-success' : 'bg-secondary' }}" style="border-radius:2px">
                            {{ $cat->is_active ? 'Actif':'Masqué' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-outline-secondary me-1">Modifier</a>
                        <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Supprimer cette catégorie ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Aucune catégorie encore.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $categories->links() }}</div>
</div>
@endsection
