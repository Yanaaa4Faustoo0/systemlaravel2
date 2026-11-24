<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Membership Application</title>
    <style>
        :root{--violet-50:#faf7ff;--violet-100:#f1eaff;--violet-200:#e5d8ff;--violet-400:#a78bfa;--violet-500:#8b5cf6;--violet-700:#6d28d9;--ink:#33264d;--muted:#776b8d}
        *{box-sizing:border-box}body{margin:0;min-height:100vh;background:linear-gradient(135deg,#faf7ff,#eee7ff);color:var(--ink);font-family:Inter,ui-sans-serif,system-ui,sans-serif}.page{width:min(920px,calc(100% - 32px));margin:auto;padding:34px 0 60px}.portal-toggle{display:flex;gap:4px;width:min(430px,100%);margin:0 auto 42px;padding:5px;border:1px solid var(--violet-200);border-radius:999px;background:rgba(255,255,255,.72);box-shadow:0 8px 24px rgba(84,55,139,.1)}.portal-toggle a{flex:1;border-radius:999px;padding:11px 16px;text-align:center;color:var(--violet-700);font-size:.86rem;font-weight:800;text-decoration:none;transition:background .2s,color .2s,box-shadow .2s,transform .2s}.portal-toggle a.active{background:linear-gradient(135deg,var(--violet-500),var(--violet-700));color:#fff;box-shadow:0 5px 14px rgba(109,40,217,.26)}.portal-toggle a:not(.active):hover{background:#dfceff;color:#5b21b6;transform:translateY(-1px)}.hero{margin-bottom:26px}.eyebrow{margin:0 0 9px;color:var(--violet-700);font-size:.76rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase}h1{margin:0 0 10px;font-size:clamp(2rem,5vw,3.4rem);letter-spacing:-.055em;line-height:1}.subtitle{margin:0;color:var(--muted)}.card{border:1px solid rgba(167,139,250,.26);border-radius:22px;background:rgba(255,255,255,.84);box-shadow:0 18px 45px rgba(84,55,139,.1);padding:30px;backdrop-filter:blur(12px)}.intro{display:grid;grid-template-columns:1.2fr .8fr;gap:16px;margin-bottom:18px}.tip{border-radius:18px;padding:18px;background:linear-gradient(135deg,#f1eaff,#dfceff)}.tip strong{display:block;margin-bottom:7px;color:var(--violet-700)}.tip p{margin:0;color:var(--muted);font-size:.88rem;line-height:1.5}.form-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:18px}.full{grid-column:1/-1}label{display:block;margin:0 0 7px;color:#514367;font-size:.84rem;font-weight:700}input,select{width:100%;border:1px solid var(--violet-200);border-radius:12px;background:var(--violet-50);color:var(--ink);font:inherit;outline:0;padding:11px 12px}input:focus,select:focus{border-color:var(--violet-400);background:#fff;box-shadow:0 0 0 4px rgba(167,139,250,.18)}.map-panel{margin-top:18px;border:1px solid var(--violet-200);border-radius:16px;padding:14px;background:var(--violet-50)}.map{height:320px;border-radius:12px;background:#e9e4f3;overflow:hidden}.coordinates{margin:10px 0 0;color:var(--muted);font-size:.84rem}.weather{margin:10px 0 0;padding:10px 12px;border-radius:10px;background:#fff;color:var(--violet-700);font-size:.86rem}.actions{display:flex;gap:10px;margin-top:22px}.button{display:inline-flex;align-items:center;justify-content:center;border:0;border-radius:11px;background:linear-gradient(135deg,var(--violet-500),var(--violet-700));color:#fff;cursor:pointer;font:inherit;font-weight:800;padding:11px 16px}.button.secondary{background:var(--violet-100);color:var(--violet-700);text-decoration:none}.notice,.error{border-radius:11px;margin:0 0 18px;padding:11px 13px;font-size:.9rem}.notice{background:#eee7ff;color:var(--violet-700)}.error{background:#fff0f4;color:#ad315c}@media(max-width:700px){.intro,.form-grid{grid-template-columns:1fr}.full{grid-column:auto}.card{padding:18px}.actions{flex-direction:column}}
        .page{width:min(920px,calc(100% - 32px));margin:34px auto;padding:30px;border:1px solid rgba(167,139,250,.26);border-radius:22px;background:rgba(255,255,255,.84);box-shadow:0 18px 45px rgba(84,55,139,.1);backdrop-filter:blur(12px)}
        .portal-toggle{width:min(530px,100%);margin:0 auto 34px}
        body{display:grid;place-items:center}
        body{display:block}
        .page{min-height:0;margin:34px auto}
    </style>
</head>
<body>
<main class="page">
    <nav class="portal-toggle"><a class="active" href="{{ route('membership.create') }}">Membership Application</a><a href="{{ route('login') }}">Admin Login</a></nav>
    <header class="hero"><p class="eyebrow">Open membership registration</p><h1>Apply for membership</h1><p class="subtitle">Submit your details, choose a category, and share your preferred location.</p></header>
    <div class="intro"><div class="card"><h2>Start your application</h2><p class="subtitle">Your application will receive a unique reference number after submission. We’ll use your email for the confirmation notification.</p></div><div class="tip"><strong>Before you submit</strong><p>Use a valid email address and click the map to select your location.</p></div></div>
    <section class="card">
        @if(session('success'))<p class="notice">{{ session('success') }}</p>@endif
        @if($errors->any())<div class="error"><strong>Please check the form:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('membership.store') }}">@csrf
            <div class="form-grid"><div class="full"><label for="membership_category_id">Membership category</label><select id="membership_category_id" name="membership_category_id" required><option value="">Choose a category</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('membership_category_id')==$category->id)>{{ $category->name }} — {{ $category->description }}</option>@endforeach</select></div><div><label for="full_name">Full name</label><input id="full_name" name="full_name" value="{{ old('full_name') }}" required></div><div><label for="email">Email address</label><input id="email" type="email" name="email" value="{{ old('email') }}" required></div><div><label for="phone">Phone number</label><input id="phone" name="phone" value="{{ old('phone') }}"></div><div><label for="address">Address</label><input id="address" name="address" value="{{ old('address') }}"></div></div>
            <div class="map-panel"><label>Preferred location</label><div id="map" class="map"></div><p id="coordinates" class="coordinates">Click the map to select a location.</p><input id="lat" type="hidden" name="latitude" value="{{ old('latitude','14.5995') }}"><input id="lon" type="hidden" name="longitude" value="{{ old('longitude','120.9842') }}"><p id="weather" class="weather">Weather will appear after selecting a location.</p></div>
            <div class="actions"><button class="button" type="submit">Submit application</button></div>
        </form>
    </section>
</main>
@if(config('services.google_maps.key'))<script>let map,marker;function setLocation(lat,lon){document.getElementById('lat').value=lat.toFixed(7);document.getElementById('lon').value=lon.toFixed(7);document.getElementById('coordinates').textContent=`Latitude: ${lat.toFixed(5)}, Longitude: ${lon.toFixed(5)}`;if(marker)marker.setMap(null);marker=new google.maps.Marker({position:{lat,lng:lon},map});fetch(`{{ route('weather.show') }}?lat=${lat}&lon=${lon}`).then(r=>r.json()).then(w=>document.getElementById('weather').textContent=w.message||`${w.place}: ${w.temperature}°C, ${w.description}, humidity ${w.humidity}%`).catch(()=>document.getElementById('weather').textContent='Weather is unavailable.')}function initMap(){const lat=Number(document.getElementById('lat').value),lon=Number(document.getElementById('lon').value);map=new google.maps.Map(document.getElementById('map'),{center:{lat,lng:lon},zoom:13});map.addListener('click',e=>setLocation(e.latLng.lat(),e.latLng.lng()));setLocation(lat,lon)}window.initMap=initMap;</script><script async src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap"></script>@else<script>document.getElementById('map').innerHTML='<div style="display:grid;place-items:center;height:100%;color:#776b8d;font-size:.9rem">Add GOOGLE_MAPS_KEY to enable the map</div>';</script>@endif
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
    const startLat = Number(document.getElementById('lat').value);
    const startLon = Number(document.getElementById('lon').value);
    document.getElementById('map').innerHTML = '';
    window.leafletMap = L.map('map').setView([startLat, startLon], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap contributors' }).addTo(window.leafletMap);
    let leafletMarker = L.marker([startLat, startLon]).addTo(window.leafletMap);
    function setLeafletLocation(lat, lon) {
        document.getElementById('lat').value = lat.toFixed(7);
        document.getElementById('lon').value = lon.toFixed(7);
        document.getElementById('coordinates').textContent = `Latitude: ${lat.toFixed(5)}, Longitude: ${lon.toFixed(5)}`;
        leafletMarker.setLatLng([lat, lon]);
        fetch(`{{ route('weather.show') }}?lat=${lat}&lon=${lon}`).then(response => response.json()).then(weather => { document.getElementById('weather').textContent = weather.message || `${weather.place}: ${weather.temperature}°C, ${weather.description}, humidity ${weather.humidity}%`; }).catch(() => { document.getElementById('weather').textContent = 'Weather is unavailable.'; });
    }
    window.leafletMap.on('click', event => setLeafletLocation(event.latlng.lat, event.latlng.lng));
    setLeafletLocation(startLat, startLon);
</script>
</body>
</html>
