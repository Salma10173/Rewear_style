@extends('layouts.admin')
@section('title','Commandes')

@section('content')

{{-- Filters --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:6px">
    <div class="card-body p-3">
        <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
            <input type="text" name="search" class="form-control" style="max-width:220px"
                   placeholder="Numéro de commande…" value="{{ request('search') }}">
            <select name="status" class="form-select" style="max-width:160px" onchange="this.form.submit()">
                <option value="">Tous les statuts</option>
                @foreach(\App\Models\Order::STATUSES as $status)
                    <option value="{{ $status }}" {{ request('status') === $status ? 'selected':'' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
            <button class="btn btn-accent">Rechercher</button>
            @if(request()->hasAny(['search','status']))
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Effacer</a>
            @endif
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius:6px">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>N° de commande</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Articles</th>
                    <th>Total</th>
                    <th>Paiement</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="fw-medium">{{ $order->order_number }}</td>
                    <td>
                        <div>{{ $order->user->name }}</div>
                        <small class="text-muted">{{ $order->user->email }}</small>
                    </td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td>{{ $order->items_count ?? '—' }}</td>
                    <td class="fw-medium">${{ number_format($order->total, 2) }}</td>
                    <td>
                        <span style="font-size:.78rem">{{ ucwords(str_replace('_',' ',$order->payment_method)) }}</span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $order->status }} px-2 py-1"
                              style="border-radius:2px;font-size:.72rem;text-transform:uppercase;letter-spacing:.04em">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-accent">Voir</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">Aucune commande trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $orders->links() }}</div>
</div>
@endsection
