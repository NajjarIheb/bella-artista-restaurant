@extends('layouts.admin')

@section('title', 'Manage Menu Items')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1>Manage Menu Items</h1>
    <button onclick="document.getElementById('addModal').style.display='block'" class="btn-gold" style="padding: 0.6rem 1.2rem; font-size: 0.85rem;">
        <i class="fas fa-plus" style="margin-right: 6px;"></i> Add New Item
    </button>
</div>

<!-- Filters -->
<form method="GET" action="{{ route('admin.menu') }}" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end; margin-bottom: 1.5rem; background: var(--bg-card); padding: 1.2rem; border: 1px solid var(--color-border); border-radius: 4px;">
    <div class="form-group" style="margin: 0; flex: 1; min-width: 200px;">
        <label>Search</label>
        <input type="text" name="q" class="form-control" value="{{ request('q') }}" placeholder="Search by name, description or allergen...">
    </div>
    <div class="form-group" style="margin: 0;">
        <label>Category</label>
        <select name="category_id" class="form-control">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group" style="margin: 0;">
        <label>Availability</label>
        <select name="availability" class="form-control">
            <option value="all" {{ request('availability', 'all') == 'all' ? 'selected' : '' }}>All</option>
            <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Available</option>
            <option value="unavailable" {{ request('availability') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
        </select>
    </div>
    <button type="submit" class="btn-gold" style="padding: 0.6rem 1.2rem; font-size: 0.85rem;">
        <i class="fas fa-filter" style="margin-right: 6px;"></i> Apply
    </button>
    @if(request('q') || request('category_id') || (request('availability') && request('availability') != 'all'))
        <a href="{{ route('admin.menu') }}" style="padding: 0.6rem 1.2rem; font-size: 0.85rem; color: var(--color-text-muted);">Reset</a>
    @endif
</form>

<p style="margin-bottom: 1rem; color: var(--color-text-muted); font-size: 0.9rem;">{{ $menuItems->count() }} item(s) found.</p>

<!-- Menu Items Table -->
<div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 1px solid var(--color-border); background: rgba(255,255,255,0.02);">
                <th style="padding: 1.2rem;">Image</th>
                <th style="padding: 1.2rem;">Name</th>
                <th style="padding: 1.2rem;">Category</th>
                <th style="padding: 1.2rem;">Price</th>
                <th style="padding: 1.2rem;">Allergens</th>
                <th style="padding: 1.2rem;">Status</th>
                <th style="padding: 1.2rem;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menuItems as $item)
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                <td style="padding: 1.2rem;">
                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}" style="width: 60px; height: 50px; object-fit: cover; border-radius: 3px;">
                </td>
                <td style="padding: 1.2rem;">
                    <strong>{{ $item->name }}</strong>
                    @if($item->is_deal)
                        <span style="margin-left: 0.4rem; font-size: 0.7rem; padding: 0.15rem 0.5rem; border-radius: 3px; background: rgba(212, 175, 55, 0.2); color: var(--color-gold);">DEAL {{ $item->deal_group ? '(' . ucfirst($item->deal_group) . ')' : '' }}</span>
                    @endif
                    <div style="font-size: 0.8rem; color: var(--color-text-muted); max-width: 250px;">{{ $item->description }}</div>
                </td>
                <td style="padding: 1.2rem; color: var(--color-gold);">
                    {{ $item->category->name ?? $item->category_name }}
                </td>
                <td style="padding: 1.2rem; font-weight: bold;">
                    {{ $item->price !== null ? number_format($item->price, 2) . ' DT' : 'Prix sur demande' }}
                    @if($item->cost_price !== null)
                        <div style="font-size: 0.75rem; font-weight: normal; color: var(--color-text-muted);">cost {{ number_format($item->cost_price, 2) }} DT</div>
                    @endif
                </td>
                <td style="padding: 1.2rem; font-size: 0.85rem; color: var(--color-text-muted);">
                    {{ $item->allergens ?? 'None' }}
                </td>
                <td style="padding: 1.2rem;">
                    <span style="color: {{ $item->is_available ? '#2ecc71' : '#e74c3c' }};">
                        {{ $item->is_available ? 'Available' : 'Unavailable' }}
                    </span>
                </td>
                <td style="padding: 1.2rem; white-space: nowrap;">
                    <button type="button"
                            class="edit-btn"
                            data-id="{{ $item->id }}"
                            data-name="{{ $item->name }}"
                            data-category="{{ $item->category_id }}"
                            data-price="{{ $item->price }}"
                            data-image="{{ $item->image_url }}"
                            data-allergens="{{ $item->allergens }}"
                            data-description="{{ $item->description }}"
                            data-available="{{ $item->is_available ? '1' : '0' }}"
                            data-cost="{{ $item->cost_price }}"
                            data-deal="{{ $item->is_deal ? '1' : '0' }}"
                            data-dealgroup="{{ $item->deal_group }}"
                            style="background: none; border: none; color: var(--color-gold); cursor: pointer; font-size: 1.1rem; margin-right: 0.8rem;">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this menu item?');" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer; font-size: 1.1rem;">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding: 2rem; text-align: center; color: var(--color-text-muted);">No menu items match your filters.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Add Item Modal -->
<div id="addModal" style="display: none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.8); z-index: 2000; align-items:center; justify-content:center; overflow-y: auto;">
    <div style="background: var(--bg-card); border: 1px solid var(--color-border); width: 90%; max-width: 550px; margin: 5% auto; padding: 2rem; border-radius: 4px; position: relative;">
        <span onclick="document.getElementById('addModal').style.display='none'" style="position: absolute; top: 1rem; right: 1.5rem; font-size: 1.5rem; cursor: pointer; color: var(--color-text-muted);">&times;</span>
        <h3 style="color: var(--color-gold); margin-bottom: 1.5rem;">Add New Menu Item</h3>

        <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Dish Name *</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Category *</label>
                    <select name="category_id" class="form-control" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Price (DT)</label>
                    <input type="number" step="0.01" min="0" name="price" class="form-control" placeholder="Leave empty for on-request pricing">
                </div>
            </div>

            <div class="form-group">
                <label>Cost Price (DT) — for profit analytics</label>
                <input type="number" step="0.01" min="0" name="cost_price" class="form-control" placeholder="e.g. 12.00">
            </div>

            <div class="form-group">
                <label>Upload Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label>... or Image URL</label>
                <input type="url" name="image_url" class="form-control" placeholder="https://...">
            </div>

            <div class="form-group">
                <label>Allergens / Tags</label>
                <input type="text" name="allergens" class="form-control" placeholder="e.g. Dairy, Gluten Free">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3" class="form-control"></textarea>
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" id="is_available" name="is_available" value="1" checked>
                <label for="is_available" style="margin: 0; text-transform: none;">Available for ordering</label>
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" id="is_deal" name="is_deal" value="1" onchange="document.getElementById('deal_group_wrap').style.display = this.checked ? 'flex' : 'none';">
                <label for="is_deal" style="margin: 0; text-transform: none;">This is a deal / combo meal</label>
            </div>

            <div class="form-group" id="deal_group_wrap" style="display: none; align-items: center; gap: 0.5rem;">
                <label style="margin: 0; text-transform: none;">Deal type:</label>
                <select name="deal_group" class="form-control" style="max-width: 200px;">
                    <option value="kids">Kids Meal</option>
                    <option value="family">Family Meal</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <button type="submit" class="btn-gold" style="width: 100%;">Save Dish</button>
        </form>
    </div>
</div>

<!-- Edit Item Modal -->
<div id="editModal" style="display: none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.8); z-index: 2000; align-items:center; justify-content:center; overflow-y: auto;">
    <div style="background: var(--bg-card); border: 1px solid var(--color-border); width: 90%; max-width: 550px; margin: 5% auto; padding: 2rem; border-radius: 4px; position: relative;">
        <span onclick="document.getElementById('editModal').style.display='none'" style="position: absolute; top: 1rem; right: 1.5rem; font-size: 1.5rem; cursor: pointer; color: var(--color-text-muted);">&times;</span>
        <h3 style="color: var(--color-gold); margin-bottom: 1.5rem;">Edit Menu Item</h3>

        <form action="" method="POST" id="editForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Dish Name *</label>
                <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Category *</label>
                    <select name="category_id" id="edit_category" class="form-control" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Price (DT)</label>
                    <input type="number" step="0.01" min="0" name="price" id="edit_price" class="form-control" placeholder="Leave empty for on-request pricing">
                </div>
            </div>

            <div class="form-group">
                <label>Cost Price (DT) — for profit analytics</label>
                <input type="number" step="0.01" min="0" name="cost_price" id="edit_cost" class="form-control" placeholder="e.g. 12.00">
            </div>

            <div class="form-group">
                <label>Upload New Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label>... or Change Image URL</label>
                <input type="url" name="image_url" id="edit_image" class="form-control" placeholder="https://...">
            </div>

            <div class="form-group">
                <label>Allergens / Tags</label>
                <input type="text" name="allergens" id="edit_allergens" class="form-control" placeholder="e.g. Dairy, Gluten Free">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="edit_description" rows="3" class="form-control"></textarea>
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" id="edit_available" name="is_available" value="1">
                <label for="edit_available" style="margin: 0; text-transform: none;">Available for ordering</label>
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" id="edit_deal" name="is_deal" value="1" onchange="document.getElementById('edit_deal_group_wrap').style.display = this.checked ? 'flex' : 'none';">
                <label for="edit_deal" style="margin: 0; text-transform: none;">This is a deal / combo meal</label>
            </div>

            <div class="form-group" id="edit_deal_group_wrap" style="display: none; align-items: center; gap: 0.5rem;">
                <label style="margin: 0; text-transform: none;">Deal type:</label>
                <select name="deal_group" id="edit_deal_group" class="form-control" style="max-width: 200px;">
                    <option value="kids">Kids Meal</option>
                    <option value="family">Family Meal</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <button type="submit" class="btn-gold" style="width: 100%;">Save Changes</button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('editForm').action = "{{ route('admin.menu.update', 'ID') }}".replace('ID', btn.dataset.id);
            document.getElementById('edit_name').value = btn.dataset.name;
            document.getElementById('edit_category').value = btn.dataset.category;
            document.getElementById('edit_price').value = btn.dataset.price !== '' ? btn.dataset.price : '';
            document.getElementById('edit_image').value = btn.dataset.image || '';
            document.getElementById('edit_allergens').value = btn.dataset.allergens || '';
            document.getElementById('edit_description').value = btn.dataset.description || '';
            document.getElementById('edit_available').checked = btn.dataset.available === '1';
            const isDeal = btn.dataset.deal === '1';
            document.getElementById('edit_deal').checked = isDeal;
            document.getElementById('edit_deal_group').value = btn.dataset.dealgroup || 'kids';
            document.getElementById('edit_deal_group_wrap').style.display = isDeal ? 'flex' : 'none';
            document.getElementById('edit_cost').value = btn.dataset.cost !== '' ? btn.dataset.cost : '';
            document.getElementById('editModal').style.display = 'block';
        });
    });
</script>
@endsection
