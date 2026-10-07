(function () {
    var KEY = 'bella_artista_cart';

    function load() {
        try {
            return JSON.parse(localStorage.getItem(KEY)) || {};
        } catch (e) {
            return {};
        }
    }

    function total() {
        var c = load();
        var s = 0;
        for (var k in c) { if (c.hasOwnProperty(k)) s += c[k]; }
        return s;
    }

    function save(c) {
        localStorage.setItem(KEY, JSON.stringify(c));
        notify();
    }

    function updateBadge() {
        var n = total();
        var badges = document.querySelectorAll('.cart-badge');
        for (var i = 0; i < badges.length; i++) {
            badges[i].textContent = n > 99 ? '99+' : n;
            badges[i].style.display = n > 0 ? 'inline-flex' : 'none';
        }
    }

    function notify() {
        window.dispatchEvent(new CustomEvent('cartchange', { detail: total() }));
        updateBadge();
    }

    window.Cart = {
        get: load,
        count: total,
        add: function (id) {
            var c = load();
            c[id] = (c[id] || 0) + 1;
            save(c);
        },
        changeQty: function (id, delta) {
            var c = load();
            if (!(id in c)) return;
            c[id] += delta;
            if (c[id] <= 0) delete c[id];
            save(c);
        },
        remove: function (id) {
            var c = load();
            delete c[id];
            save(c);
        },
        clear: function () {
            localStorage.removeItem(KEY);
            notify();
        },
        updateBadge: updateBadge
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', updateBadge);
    } else {
        updateBadge();
    }
})();
