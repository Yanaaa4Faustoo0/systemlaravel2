<div class="form-grid">
    <div>
        <label for="member_number">Member number</label>
        <input id="member_number" name="member_number" value="{{ old('member_number', $member->member_number ?? '') }}" required>
    </div>
    <div>
        <label for="joined_at">Date joined</label>
        <input type="date" id="joined_at" name="joined_at" value="{{ old('joined_at', isset($member) ? $member->joined_at?->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
    </div>
    <div>
        <label for="first_name">First name</label>
        <input id="first_name" name="first_name" value="{{ old('first_name', $member->first_name ?? '') }}" required>
    </div>
    <div>
        <label for="last_name">Last name</label>
        <input id="last_name" name="last_name" value="{{ old('last_name', $member->last_name ?? '') }}" required>
    </div>
    <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $member->email ?? '') }}">
    </div>
    <div>
        <label for="phone">Phone</label>
        <input id="phone" name="phone" value="{{ old('phone', $member->phone ?? '') }}">
    </div>
    <div>
        <label for="category">Membership category</label>
        <select id="category" name="category" required>
            <option value="">Choose a category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->name }}" @selected(old('category', $member->category ?? '') === $category->name)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="level">Membership level</label>
        <select id="level" name="level" required>
            <option value="">Choose a level</option>
            @foreach ($levels as $level)
                <option value="{{ $level->name }}" @selected(old('level', $member->level ?? '') === $level->name)>{{ $level->name }} — ₱{{ number_format($level->fee, 2) }} / {{ $level->validity_months }} months</option>
            @endforeach
        </select>
    </div>
    <div class="full">
        <label for="address">Address</label>
        <textarea id="address" name="address">{{ old('address', $member->address ?? '') }}</textarea>
    </div>
    @isset($member)
        <div>
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="active" @selected(old('status', $member->status) === 'active')>Active</option>
                <option value="inactive" @selected(old('status', $member->status) === 'inactive')>Inactive</option>
            </select>
        </div>
    @endisset
</div>
