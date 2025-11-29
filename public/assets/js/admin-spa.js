const adminApp = document.getElementById('adminApp');
const adminMain = document.getElementById('adminMain');
const sidebar = document.getElementById('adminSidebar');
const pageScripts = document.getElementById('pageScripts');

if (adminApp && adminMain) {
    const state = {
        navigating: false,
        pendingInit: [],
    };

    const spaLinkSelector = 'a[data-spa-link]';

    history.replaceState({ url: window.location.href }, '', window.location.href);
    bindNavLinks();
    bindSidebarToggles(document);

    window.addEventListener('popstate', (event) => {
        const url = event.state?.url || window.location.href;
        navigate(url, false);
    });

    function bindNavLinks() {
        document.querySelectorAll(spaLinkSelector).forEach((link) => {
            link.removeEventListener('click', handleNavClick);
            link.addEventListener('click', handleNavClick);
        });
    }

    function bindSidebarToggles(scope) {
        scope.querySelectorAll?.('[data-sidebar-toggle]').forEach((btn) => {
            btn.removeEventListener('click', toggleSidebar);
            btn.addEventListener('click', toggleSidebar);
        });
    }

    function toggleSidebar(event) {
        event.preventDefault();
        sidebar?.classList.toggle('active');
    }

    function handleNavClick(event) {
        const link = event.currentTarget;
        if (link.target === '_blank') {
            return;
        }
        const url = link.href;
        event.preventDefault();
        if (url === window.location.href) {
            updateActiveNav(url);
            return;
        }
        navigate(url, true);
    }

    async function navigate(url, pushState = true) {
        if (state.navigating) return;
        state.navigating = true;
        adminMain.classList.add('is-loading');

        try {
            const response = await fetch(url, {
                headers: { 'X-Requested-With': 'spa' },
                credentials: 'same-origin',
            });
            const html = await response.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const freshMain = doc.querySelector('#adminMain');
            if (!freshMain) {
                window.location.href = url;
                return;
            }
            replaceSection(adminMain, freshMain, true);

            const freshScripts = doc.querySelector('#pageScripts');
            if (pageScripts && freshScripts) {
                replaceSection(pageScripts, freshScripts);
            }

            document.title = doc.title;
            updateActiveNav(url);
            bindNavLinks();
            runPendingInits();

            if (pushState) {
                history.pushState({ url }, '', url);
            }
        } catch (error) {
            window.location.href = url;
        } finally {
            state.navigating = false;
            adminMain.classList.remove('is-loading');
        }
    }

    function replaceSection(target, source, bindToggles = false) {
        const scripts = Array.from(source.querySelectorAll('script'));
        scripts.forEach((script) => script.parentNode.removeChild(script));

        target.innerHTML = source.innerHTML;

        scripts.forEach(runScript);

        if (bindToggles) {
            bindSidebarToggles(target);
        }
    }

    function runScript(oldScript) {
        const script = document.createElement('script');
        Array.from(oldScript.attributes).forEach((attr) => {
            script.setAttribute(attr.name, attr.value);
        });
        if (oldScript.src) {
            script.src = oldScript.src;
        } else {
            script.textContent = oldScript.textContent;
        }
        document.body.appendChild(script);
        if (!script.src) {
            script.remove();
        }
    }

    function updateActiveNav(url) {
        const targetPath = new URL(url, window.location.origin).pathname;
        document.querySelectorAll('.nav-item').forEach((item) => item.classList.remove('active'));
        document.querySelectorAll(spaLinkSelector).forEach((link) => {
            const linkPath = new URL(link.href, window.location.origin).pathname;
            if (targetPath === linkPath || targetPath.startsWith(linkPath + '/')) {
                link.closest('.nav-item')?.classList.add('active');
            }
        });
    }
}

